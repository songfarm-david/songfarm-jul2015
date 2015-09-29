-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 28, 2015 at 11:34 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `songfarm-jul2015`
--

-- --------------------------------------------------------

--
-- Table structure for table `songcircle_create`
--

CREATE TABLE IF NOT EXISTS `songcircle_create` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `songcircle_id` varchar(13) NOT NULL,
  `songcircle_name` varchar(50) NOT NULL,
  `date_of_songcircle` datetime NOT NULL COMMENT 'All times are UTC',
  `songcircle_permission` tinyint(1) NOT NULL COMMENT '0=public, 1=private',
  `participants` tinyint(3) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `songcircle_id` (`songcircle_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `songcircle_create`
--

INSERT INTO `songcircle_create` (`id`, `user_id`, `songcircle_id`, `songcircle_name`, `date_of_songcircle`, `songcircle_permission`, `participants`) VALUES
(3, 0, '5608f10f3debc', 'Songfarm Open Songcircle', '2015-11-15 19:00:00', 0, 12);

-- --------------------------------------------------------

--
-- Table structure for table `songcircle_register`
--

CREATE TABLE IF NOT EXISTS `songcircle_register` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `songcircle_id` varchar(13) NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(250) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `songcircle_id` (`songcircle_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_photo`
--

CREATE TABLE IF NOT EXISTS `user_photo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT 'Foreign Key to Registree_info',
  `filename` varchar(23) NOT NULL,
  `type` varchar(20) NOT NULL,
  `size` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `filename_2` (`filename`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `user_photo`
--

INSERT INTO `user_photo` (`id`, `user_id`, `filename`, `type`, `size`) VALUES
(3, 1, '55fb5c764c6a73.47257210', '.jpeg', 7572),
(4, 2, '55fb69807c4054.69246280', '.jpeg', 40269);

-- --------------------------------------------------------

--
-- Table structure for table `user_register`
--

CREATE TABLE IF NOT EXISTS `user_register` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_type` int(1) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_password` varchar(255) DEFAULT NULL,
  `reg_date` date NOT NULL,
  `permission` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `artist_email` (`user_email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Songfarm Artist Sign Up test' AUTO_INCREMENT=11 ;

--
-- Dumping data for table `user_register`
--

INSERT INTO `user_register` (`user_id`, `user_type`, `user_name`, `user_email`, `user_password`, `reg_date`, `permission`) VALUES
(0, 1, 'Songfarm', 'david@songfarm.ca', '$2y$10$MC6rznH95/4wEVxPxWRILe74iCMzGOqiLneMgnEWJ3a3QP/EMDZ0S', '2015-09-23', 1),
(1, 1, 'David Burke Gaskin', 'davidburkegaskin@gmail.com', '$2y$10$SrMLfryMmaxj5X9o2a1KF.glh232vHLZDOoLhsSRNzXPts2167sbq', '2015-08-28', 1),
(2, 1, 'David Burke', 'ste_llar@hotmail.com', '$2y$10$YYqIEqezG/rP4bFJsArZp.tpbuIupg/pu7NXhhcguoVLfZaesM6VK', '2015-08-28', 0),
(10, 1, 'Pradip', 'email@email.com', '$2y$10$NHhoiIA7glm6TRHOVTNQm.jzDuyobLbfOw6qiHbGz4BpaLOY7Le5u', '2015-09-28', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_timezone`
--

CREATE TABLE IF NOT EXISTS `user_timezone` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `timezone` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Stores user''s selected timezone' AUTO_INCREMENT=4 ;

--
-- Dumping data for table `user_timezone`
--

INSERT INTO `user_timezone` (`id`, `user_id`, `timezone`) VALUES
(1, 1, 'America/Toronto'),
(2, 0, 'America/Vancouver'),
(3, 2, 'Europe/London');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
