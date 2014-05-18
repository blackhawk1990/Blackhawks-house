-- phpMyAdmin SQL Dump
-- version 4.1.9
-- http://www.phpmyadmin.net
--
-- Host: mysql.webio.pl:3306
-- Generation Time: May 18, 2014 at 05:08 AM
-- Server version: 5.5.27-log
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `7770_blhouse`
--

-- --------------------------------------------------------

--
-- Table structure for table `_slider_slides`
--

CREATE TABLE IF NOT EXISTS `_slider_slides` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(30) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `_slider_slides`
--

INSERT INTO `_slider_slides` (`id`, `title`, `content`, `image`) VALUES
(2, 'Strony szyte na miarę', 'Serwisy internetowe spełniające wszystkie Twoje wymagania, <br />wykorzystujące najnowsze technologie takie jak: HTML5, jQuery i CSS3.', 'banner_photo_2.png'),
(4, 'Profesjonalna obsługa', 'Dopasowanie projektu strony do wymagań klienta <br />i profesjonalna wycena zlecenia.', 'banner_photo_3.png');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
