-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 16, 2014 at 11:03 AM
-- Server version: 5.5.38-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `Persons`
--

-- --------------------------------------------------------

--
-- Table structure for table `Categories`
--

CREATE TABLE IF NOT EXISTS `Categories` (
  `ID` int(16) NOT NULL AUTO_INCREMENT,
  `Name` varchar(32) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `Categories`
--

INSERT INTO `Categories` (`ID`, `Name`) VALUES
(1, 'Student'),
(2, 'Employe'),
(3, 'Intern');

-- --------------------------------------------------------

--
-- Table structure for table `Marks`
--

CREATE TABLE IF NOT EXISTS `Marks` (
  `ID` int(16) NOT NULL AUTO_INCREMENT,
  `Pers_ID` int(16) NOT NULL,
  `Subj_ID` int(16) NOT NULL,
  `Mark` int(3) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `Personal`
--

CREATE TABLE IF NOT EXISTS `Personal` (
  `ID` int(16) NOT NULL AUTO_INCREMENT,
  `Name` varchar(32) NOT NULL,
  `Surname` varchar(32) NOT NULL,
  `Age` int(3) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `Personal`
--

INSERT INTO `Personal` (`ID`, `Name`, `Surname`, `Age`) VALUES
(24, 'Garry', 'Fawler', 64),
(25, 'Simone', 'Zaza', 22),
(26, 'Pol', 'SCOULS', 32);

-- --------------------------------------------------------

--
-- Table structure for table `State`
--

CREATE TABLE IF NOT EXISTS `State` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Pers_ID` int(11) NOT NULL,
  `Cat_ID` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `Subjects`
--

CREATE TABLE IF NOT EXISTS `Subjects` (
  `ID` int(16) NOT NULL AUTO_INCREMENT,
  `Name` varchar(32) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `Subjects`
--

INSERT INTO `Subjects` (`ID`, `Name`) VALUES
(1, 'Js'),
(2, 'Php');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
