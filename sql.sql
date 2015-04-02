
-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Darbinė stotis: localhost
-- Atlikimo laikas: 2015 m. Bal 02 d. 14:10
-- Serverio versija: 5.1.69
-- PHP versija: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Duomenų bazė: `u822378726_1`
--

-- --------------------------------------------------------

--
-- Sukurta duomenų struktūra lentelei `ip`
--

CREATE TABLE IF NOT EXISTS `ip` (
  `id` int(5) NOT NULL AUTO_INCREMENT COMMENT 'Vartotojo id',
  `ip` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Vartotojo ip',
  `pakviete` int(4) NOT NULL COMMENT 'Vartotojo pakvietimai',
  `pakvietimas` varchar(20) CHARACTER SET utf8 COLLATE utf8_lithuanian_ci NOT NULL COMMENT 'Paskutinis pakvietimas',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=42 ;

--
-- Sukurta duomenų struktūra lentelei `pakviesti`
--

CREATE TABLE IF NOT EXISTS `pakviesti` (
  `id` int(5) NOT NULL AUTO_INCREMENT COMMENT 'Pakviestų id',
  `ip` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Pakviesto ip',
  `pakviete` int(5) NOT NULL COMMENT 'Kas pakvietė id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=43 ;
