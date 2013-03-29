-- phpMyAdmin SQL Dump
-- version 3.3.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 29, 2013 at 11:39 AM
-- Server version: 5.1.50
-- PHP Version: 5.3.14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `skillvillebe`
--
DROP DATABASE `skillvillebe`;
CREATE DATABASE `skillvillebe` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `skillvillebe`;

-- --------------------------------------------------------

--
-- Table structure for table `inschrijven`
--

CREATE TABLE IF NOT EXISTS `inschrijven` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `naam` varchar(256) NOT NULL DEFAULT '',
  `voornaam` varchar(256) NOT NULL DEFAULT '',
  `email` varchar(256) NOT NULL DEFAULT '',
  `school` varchar(256) NOT NULL DEFAULT '',
  `opt` varchar(64) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `inschrijven`
--

