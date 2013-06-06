-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Czas wygenerowania: 06 Cze 2013, 20:40
-- Wersja serwera: 5.5.16
-- Wersja PHP: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Baza danych: `blackhawk`
--

--
-- Zrzut danych tabeli `_realizations`
--

INSERT INTO `_realizations` (`id`, `tytul`, `tekst`, `data`, `zajawka`, `obrazek`, `url`, `used_technologies`) VALUES
(1, 'Kortowiada 2012', 'Strona SSFK "Kortowiada 2012" stworzona z myślą o szybkim dzieleniu się zdjęciami z wydarzeń olsztyńskich juwenalii.', '2012-05-10', 'Strona Specjalnego Serwisu Fotograficznego "Kortowiada 2012"', 'Korto2012_large.png', NULL, 'PHP, Zend Framework, jQuery, MySQL'),
(2, 'WMZZP', 'Strona "Warmińsko-Mazurskich Zespołowych Zawodów Programistycznych" stworzona w celu podania uczestnikom i chętnym podstawowych informacji o zawodach. Umieszczono na niej również podstawowe informacje o wynikach z poprzednich lat.\r\n<br /><br />\r\nWspółautorzy:\r\n<ul>\r\n<li>Katarzyna Urbańska(grafika)</li>\r\n<li>Jarosław Mikołajczak(frontend)</li>\r\n<li>Patryk Ratajczak(grafika)</li>\r\n</ul>', '2012-04-01', 'Strona "W-M Zespołowych Zawodów Programistycznych"', 'WMZZP_large.png', NULL, 'HTML, jQuery, Zend Framework');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
