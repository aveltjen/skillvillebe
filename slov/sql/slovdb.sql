-- phpMyAdmin SQL Dump
-- version 3.3.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 25, 2013 at 12:04 PM
-- Server version: 5.1.50
-- PHP Version: 5.3.14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `slovdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `ID` int(11) NOT NULL,
  `SchoolID` int(11) NOT NULL,
  `Lastname` varchar(100) NOT NULL,
  `Firstname` varchar(100) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`ID`, `SchoolID`, `Lastname`, `Firstname`) VALUES
(7, 1, 'Cheatson', 'Cheater');

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('aecd961b8372152de55f01ff65ed12ff', '127.0.0.1', 'Opera/9.80 (Windows NT 6.1; WOW64) Presto/2.12.388 Version/12.12', 1359111436, 'a:2:{s:9:"user_data";s:0:"";s:4:"user";s:171:"O:13:"c{{slash}}admin{{slash}}Admin":5:{s:6:"userId";s:1:"7";s:8:"schoolId";s:1:"1";s:8:"userName";s:4:"demo";s:9:"firstName";s:7:"Cheater";s:8:"lastName";s:8:"Cheatson";}";}'),
('db8dac2020cf53bde5ea69a882c45402', '127.0.0.1', 'Opera/9.80 (Windows NT 6.1; WOW64) Presto/2.12.388 Version/12.12', 1359109636, 'a:1:{s:4:"user";s:169:"O:13:"c{{slash}}admin{{slash}}Admin":5:{s:6:"userId";s:1:"1";s:8:"schoolId";s:1:"1";s:8:"userName";s:4:"demo";s:9:"firstName";s:6:"Robert";s:8:"lastName";s:7:"Rodgers";}";}');

-- --------------------------------------------------------

--
-- Table structure for table `group`
--

CREATE TABLE IF NOT EXISTS `group` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `SchoolID` int(11) NOT NULL,
  `CreateDate` date NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Description` varchar(200) DEFAULT NULL,
  `Key` varchar(10) NOT NULL,
  `LinkID` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `KeyIdx` (`Key`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `group`
--

INSERT INTO `group` (`ID`, `SchoolID`, `CreateDate`, `Name`, `Description`, `Key`, `LinkID`) VALUES
(6, 1, '2013-01-25', 'Group A', NULL, '9M16D9L0Z8', 1),
(7, 1, '2013-01-25', 'Group B', NULL, '9874RL9JD7', 1),
(9, 1, '2013-01-25', 'Group Z1', NULL, 'XXQC2V1G6', 2);

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE IF NOT EXISTS `login` (
  `AccountID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'The ID used to identify the account and type',
  `Username` varchar(100) NOT NULL COMMENT 'The username of the account',
  `Password` char(64) NOT NULL COMMENT 'The password of the account stored as a SHA256 hash',
  `Type` tinyint(4) NOT NULL COMMENT 'Refers to the type of account via table index of the account',
  PRIMARY KEY (`AccountID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`AccountID`, `Username`, `Password`, `Type`) VALUES
(5, 'teacher1', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 2),
(6, 'teacher2', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 2),
(7, 'demo', '2a97516c354b68848cdbd8f54a226a0a55b21ed138e207ad6c5cbb9c00aa5aea', 0);

-- --------------------------------------------------------

--
-- Table structure for table `package`
--

CREATE TABLE IF NOT EXISTS `package` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `package`
--

INSERT INTO `package` (`ID`, `Name`) VALUES
(1, 'Package A'),
(2, 'Package B');

-- --------------------------------------------------------

--
-- Table structure for table `packagelink`
--

CREATE TABLE IF NOT EXISTS `packagelink` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `SchoolID` int(11) NOT NULL,
  `PackageID` int(11) NOT NULL,
  `StudentCount` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `packagelink`
--

INSERT INTO `packagelink` (`ID`, `SchoolID`, `PackageID`, `StudentCount`) VALUES
(1, 1, 1, 200),
(2, 1, 2, 250);

-- --------------------------------------------------------

--
-- Table structure for table `school`
--

CREATE TABLE IF NOT EXISTS `school` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) NOT NULL,
  `Address` varchar(300) NOT NULL,
  `Postcode` varchar(10) NOT NULL,
  `City` varchar(50) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `school`
--

INSERT INTO `school` (`ID`, `Name`, `Address`, `Postcode`, `City`) VALUES
(1, 'Test School', 'Somewhere', '0123', 'City');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE IF NOT EXISTS `student` (
  `ID` int(11) NOT NULL,
  `Lastname` varchar(100) NOT NULL,
  `Firstname` varchar(100) NOT NULL,
  `Birthdate` date NOT NULL,
  `ActiveGroup` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student`
--


-- --------------------------------------------------------

--
-- Table structure for table `studentgroup`
--

CREATE TABLE IF NOT EXISTS `studentgroup` (
  `StudentID` int(11) NOT NULL,
  `GroupID` int(11) NOT NULL,
  `EnterDate` datetime DEFAULT NULL,
  `LeaveDate` datetime DEFAULT NULL,
  PRIMARY KEY (`StudentID`,`GroupID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `studentgroup`
--


-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE IF NOT EXISTS `teacher` (
  `ID` int(11) NOT NULL,
  `SchoolID` int(11) NOT NULL,
  `Lastname` varchar(100) NOT NULL,
  `Firstname` varchar(100) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`ID`, `SchoolID`, `Lastname`, `Firstname`) VALUES
(5, 1, 'Test', 'Teacher123'),
(6, 1, 'Test', 'Teacher2');

-- --------------------------------------------------------

--
-- Table structure for table `teachergroup`
--

CREATE TABLE IF NOT EXISTS `teachergroup` (
  `TeacherID` int(11) NOT NULL,
  `GroupID` int(11) NOT NULL,
  PRIMARY KEY (`TeacherID`,`GroupID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `teachergroup`
--

