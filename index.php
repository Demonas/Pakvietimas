<?php session_start(); 
require("config.php");
date_default_timezone_set("Europe/Vilnius");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo "$pavadinimas Pakvietimų sistema"; ?></title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<STYLE TYPE="text/css">
BODY
   {
   font-family:Tahoma;
   }
</STYLE>
  </head>
  <script type='text/javascript'>
function refreshCaptcha(){
	var img = document.images['captchaimg'];
	img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
}
</script>
  <body>
	<div class="row">
		<div class="col-md-4"></div>
		<div class="col-md-4">
			<br><br><br><br>
			<div class="panel panel-success">
				<div class="panel-heading">
					<h1 class="panel-title"><center><?php echo $pavadinimas; ?><abbr title="<?php echo $paiskinimas; ?>"> Pakvietimų sistema</abbr></center></h1>
				</div>			
				<div class="panel-body">
					<?php 
					include('mysql.php');
					if(isset($_GET['pakviete']) && !empty($_GET['pakviete'])) {
						$pakviete = $_GET['pakviete']; 
						$pakvietusio_ip = $_SERVER['REMOTE_ADDR']; 
						$pav = "SELECT * FROM `pakviesti` WHERE `ip`='$pakvietusio_ip'";
						$db = $conn->query($pav);
						$raw = $db->num_rows;
						if($raw == 1) { 
							echo "<span style='color:red'>Tu jau buvai pakviestas!</span>";
							?><meta http-equiv="refresh" content="3;url=index.php"><?php
						}else{ 
							if(isset($_POST['Submit'])){
								if(empty($_SESSION['captcha_code'] ) || strcasecmp($_SESSION['captcha_code'], $_POST['captcha_code']) != 0){  
									$msg="<span style='color:red'>Neteisingas apsaugos kodas</span>";		
								}else{	
									$pav = "SELECT * FROM `ip` WHERE `id`='$pakviete'";
									$db = $conn->query($pav);
									$raw = $db->num_rows;
									$data = date("Y-m-d H:i:s");
									if($raw == 1) {
										$msg="<span style='color:green'>Jūs sėkmingai pakviestas</span>";
										$conn->query("UPDATE  ip  SET pakviete = pakviete +1 WHERE  id ='$pakviete'");
										$conn->query("UPDATE  ip  SET pakvietimas ='$data' WHERE  id ='$pakviete'");
										$conn->query("INSERT INTO  pakviesti  (ip,pakviete) VALUES ('$pakvietusio_ip','$pakviete')");
										?><meta http-equiv="refresh" content="3;url=index.php"><?php
									}else{
										$msg="<span style='color:red'>Tokio vartotojo nėra!</span>";
										?><meta http-equiv="refresh" content="3;url=index.php"><?php
									}
								}
							}?>
							<form action="" method="post" name="form1" id="form1" >
								<table width="400" border="0" align="center" cellpadding="5" cellspacing="1" class="table">
									<?php if(isset($msg)){?>
									<tr>
										<td colspan="2" align="center" valign="top"><?php echo $msg;?></td>
									</tr>
									<?php } ?>
									<tr>
										<td align="right" valign="top"> Apsaugos kodas:</td>
										<td><img src="captcha.php?rand=<?php echo rand();?>" id='captchaimg'><br>
										<label for='message'>Įveskite apsaugos koda čia:</label>
										<br>
										<input id="captcha_code" name="captcha_code" type="text">
										<br>
										Neperskaitai ? spausk <a href='javascript: refreshCaptcha();'>čia</a> kad perkrautum</td>
									</tr>
									<tr>
										<td> </td>
										<td><input name="Submit" type="submit" onclick="return validate();" value="Aš žmogus!" class="btn btn-lg btn-success"></td>
									</tr>
								</table>
							</form>
							<?php

						}
	
					} else {
						$page = $_SERVER['SERVER_NAME']; 
						$file = $_SERVER['PHP_SELF']; 
						$ip = $_SERVER['REMOTE_ADDR']; 
						$pav = "SELECT * FROM `ip` WHERE `ip`='$ip'";
						$db = $conn->query($pav);
						$raw = $db->num_rows;
						if($raw == 1){
							$row = $db->fetch_assoc();
							$id = $row['id']; 
							$pakviete = $row['pakviete']; 
							$pakvietimas = $row['pakvietimas']; 
							?>
							<ul class="list-group">
								<li class="list-group-item active">Sveikas sugrįžęs ,tavo informacija</li>
								<li class="list-group-item"><span class="badge"><?php echo $ip; ?></span> Tavo ip</li>
								<li class="list-group-item"><span class="badge"><?php echo $pakviete; ?></span>Esi pakvietes</li>
								<li class="list-group-item"><span class="badge"><?php echo $pakvietimas; ?></span>Paskutinis pakvietimas</li>
								<li class="list-group-item"><span class="badge"><?php echo "www.$page$file?pakviete=".$id.""; ?></span>Tavo nuoroda </li>
							</ul>
							<?php
						}else{
							$conn->query("INSERT INTO `ip` (ip,pakviete) VALUES ('$ip','0')"); 
							header("Location: index.php"); 
						}
					}
					?>
				</div>
			</div>
		</div>
		<div class="col-md-4"></div>
	</div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>