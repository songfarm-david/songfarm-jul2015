-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 16, 2015 at 08:21 PM
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
-- Table structure for table `songcircle`
--

CREATE TABLE IF NOT EXISTS `songcircle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `songcircle_id` varchar(20) NOT NULL,
  `songcircle_name` varchar(50) NOT NULL,
  `date_of_songcircle` datetime NOT NULL,
  `songcircle_permission` varchar(10) NOT NULL,
  `participants` tinyint(3) NOT NULL,
  `duration` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `songcircle_id` (`songcircle_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `songcircle`
--

INSERT INTO `songcircle` (`id`, `user_id`, `songcircle_id`, `songcircle_name`, `date_of_songcircle`, `songcircle_permission`, `participants`, `duration`) VALUES
(1, 1, '1-55f9ebe116ea9', 'Open Songcircle', '2015-09-27 13:00:00', 'Public', 12, '2_hours'),
(14, 1, '1-55f9ed7abff7a', 'Closed Songcircle', '2015-09-24 18:00:00', 'Private', 6, '2_hours'),
(15, 1, '1-55f9f7f8dafa7', 'New Songcircle', '2015-10-23 17:30:00', 'Public', 10, '3_hours');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `user_photo`
--

INSERT INTO `user_photo` (`id`, `user_id`, `filename`, `type`, `size`) VALUES
(1, 1, '55f9e0fab343a2.89596506', '.jpeg', 7572),
(2, 2, '55f9e992301cc0.96066905', '.jpeg', 40269);

-- --------------------------------------------------------

--
-- Table structure for table `user_register`
--

CREATE TABLE IF NOT EXISTS `user_register` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_type` int(1) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_password` varchar(255) DEFAULT NULL,
  `reg_date` date NOT NULL,
  `permission` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `artist_email` (`user_email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Songfarm Artist Sign Up test' AUTO_INCREMENT=5 ;

--
-- Dumping data for table `user_register`
--

INSERT INTO `user_register` (`id`, `user_type`, `user_name`, `user_email`, `user_password`, `reg_date`, `permission`) VALUES
(1, 1, 'David Burke Gaskin', 'davidburkegaskin@gmail.com', '$2y$10$SrMLfryMmaxj5X9o2a1KF.glh232vHLZDOoLhsSRNzXPts2167sbq', '2015-08-28', 1),
(2, 1, 'David Burke', 'ste_llar@hotmail.com', '$2y$10$YYqIEqezG/rP4bFJsArZp.tpbuIupg/pu7NXhhcguoVLfZaesM6VK', '2015-08-28', 0),
(3, 1, 'Luna', 'luna@ecuatoriano.com', '$2y$10$x8gfnNme7QrYSfyedWEYyu6xCWne50qRnOPhTt6YgJlXkqB9BPZHe', '2015-08-28', 0),
(4, 1, 'Bowie', 'davidbowie@bowie.com', '$2y$10$FOLcRXoxdDXd0eSZQELht.kXbp7anvYrQrhBtz6NIvgiUDMA0bPsq', '2015-09-03', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
