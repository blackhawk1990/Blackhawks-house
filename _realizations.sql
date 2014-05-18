-- phpMyAdmin SQL Dump
-- version 4.1.9
-- http://www.phpmyadmin.net
--
-- Host: mysql.webio.pl:3306
-- Generation Time: May 18, 2014 at 05:17 AM
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
-- Table structure for table `_realizations`
--

CREATE TABLE IF NOT EXISTS `_realizations` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `title` varchar(22) NOT NULL,
  `text` text NOT NULL,
  `date` varchar(20) NOT NULL,
  `introduction` varchar(60) NOT NULL,
  `image` varchar(60) NOT NULL,
  `url` varchar(60) DEFAULT NULL,
  `used_technologies` varchar(60) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `_realizations`
--

INSERT INTO `_realizations` (`id`, `title`, `text`, `date`, `introduction`, `image`, `url`, `used_technologies`) VALUES
(1, 'Kortowiada 2012', 'Strona SSFK "Kortowiada 2012" stworzona z myślą o szybkim dzieleniu się zdjęciami z wydarzeń olsztyńskich juwenalii.', '2012-05-10', 'Strona Specjalnego Serwisu Fotograficznego "Kortowiada 2012"', 'Korto2012_large.png', NULL, 'PHP, Zend Framework, jQuery, MySQL'),
(2, 'WMZZP', 'Strona "Warmińsko-Mazurskich Zespołowych Zawodów Programistycznych" stworzona w celu podania uczestnikom i chętnym podstawowych informacji o zawodach. Umieszczono na niej również podstawowe informacje o wynikach z poprzednich lat.\r\n<br /><br />\r\nWspółautorzy:\r\n<ul>\r\n<li>Katarzyna Urbańska(grafika)</li>\r\n<li>Jarosław Mikołajczak(frontend)</li>\r\n<li>Patryk Ratajczak(grafika)</li>\r\n</ul>', '2012-04-01', 'Strona "W-M Zespołowych Zawodów Programistycznych"', 'WMZZP_large.png', NULL, 'HTML, jQuery, Zend Framework');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
