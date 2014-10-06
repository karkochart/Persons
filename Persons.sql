-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 06, 2014 at 04:19 AM
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=55 ;

--
-- Dumping data for table `Marks`
--

INSERT INTO `Marks` (`ID`, `Pers_ID`, `Subj_ID`, `Mark`) VALUES
(1, 1, 1, 1),
(2, 1, 2, 1),
(7, 7, 1, 4),
(8, 8, 1, 5),
(9, 8, 2, 3),
(18, 4, 2, 4),
(19, 4, 1, 3),
(35, 37, 1, 5),
(36, 37, 2, 5),
(39, 40, 1, 9),
(40, 40, 2, 7),
(42, 41, 1, 3),
(43, 41, 2, 4),
(44, 2, 1, 3),
(45, 2, 2, 3),
(46, 5, 1, 3),
(47, 5, 2, 3),
(50, 19, 1, 6),
(51, 19, 2, 6),
(52, 3, 1, 2),
(53, 9, 1, 4),
(54, 9, 2, 3);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=42 ;

--
-- Dumping data for table `Personal`
--

INSERT INTO `Personal` (`ID`, `Name`, `Surname`, `Age`) VALUES
(1, 'Karen', 'Kochinyan', 24),
(2, 'Cristian', 'Tesh', 22),
(3, 'Mark', 'Gonsales', 26),
(4, 'Cristian', 'Tesh', 70),
(5, 'Tomy', 'Cunkler', 33),
(7, 'Paul', 'Robben', 36),
(8, 'Mark', 'Yohanson', 44),
(9, 'Anton', 'Schultz', 51),
(19, 'Natali', 'Brown', 66),
(37, 'Nona', 'Teshyan', 16),
(40, 'Anna', 'Karenina', 25),
(41, 'Anahit', 'Cambel', 24);

-- --------------------------------------------------------

--
-- Table structure for table `State`
--

CREATE TABLE IF NOT EXISTS `State` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Pers_ID` int(11) NOT NULL,
  `Cat_ID` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `State`
--

INSERT INTO `State` (`ID`, `Pers_ID`, `Cat_ID`) VALUES
(1, 1, 1),
(5, 7, 1),
(6, 8, 1),
(7, 9, 3),
(12, 4, 1),
(23, 37, 2),
(26, 40, 3),
(27, 41, 1),
(28, 2, 3),
(29, 5, 3),
(30, 19, 2);

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
(1, 'js'),
(2, 'php');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
