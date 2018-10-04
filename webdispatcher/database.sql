-- Adminer 4.6.3 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

CREATE DATABASE `escapegame` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `escapegame`;

CREATE TABLE `cables` (
  `idCable` int(11) NOT NULL AUTO_INCREMENT,
  `nameCable` text NOT NULL,
  `description` text,
  PRIMARY KEY (`idCable`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

INSERT INTO `cables` (`idCable`, `nameCable`, `description`) VALUES
(1,	'Alimentation PC',	NULL),
(2,	'DVI',	NULL),
(3,	'HDMI',	NULL),
(4,	'RJ45',	NULL),
(5,	'USB',	NULL)
ON DUPLICATE KEY UPDATE `idCable` = VALUES(`idCable`), `nameCable` = VALUES(`nameCable`), `description` = VALUES(`description`);

CREATE TABLE `gameinprogress` (
  `idGameInProgress` int(11) NOT NULL AUTO_INCREMENT,
  `timeStart` datetime NOT NULL,
  `timeFirstStep` datetime DEFAULT NULL,
  `timeSecondeStep` datetime DEFAULT NULL,
  `timeEnd` datetime DEFAULT NULL,
  `success` int(11) NOT NULL DEFAULT '1',
  `idGame` int(11) NOT NULL,
  PRIMARY KEY (`idGameInProgress`),
  KEY `idGame` (`idGame`),
  CONSTRAINT `gameinprogress_ibfk_1` FOREIGN KEY (`idGame`) REFERENCES `gameset` (`idGame`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `gameset` (
  `idGame` int(11) NOT NULL AUTO_INCREMENT,
  `cableSelect1` int(11) NOT NULL,
  `cableSelect2` int(11) NOT NULL,
  `cableSelect3` int(11) NOT NULL,
  `indice1` char(1) NOT NULL,
  `indice2` char(1) NOT NULL,
  PRIMARY KEY (`idGame`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8;

INSERT INTO `gameset` (`idGame`, `cableSelect1`, `cableSelect2`, `cableSelect3`, `indice1`, `indice2`) VALUES
(1,	1,	2,	3,	'B',	'E'),
(2,	1,	2,	4,	'E',	'C'),
(3,	1,	2,	5,	'8',	'0'),
(4,	1,	3,	2,	'A',	'7'),
(5,	1,	3,	4,	'B',	'C'),
(6,	1,	3,	5,	'A',	'5'),
(7,	1,	4,	2,	'E',	'8'),
(8,	1,	4,	3,	'E',	'5'),
(9,	1,	4,	5,	'B',	'2'),
(10,	1,	5,	2,	'8',	'D'),
(11,	1,	5,	3,	'8',	'4'),
(12,	1,	5,	4,	'C',	'7'),
(13,	2,	1,	3,	'B',	'C'),
(14,	2,	1,	4,	'A',	'4'),
(15,	2,	1,	5,	'E',	'E'),
(16,	2,	3,	1,	'8',	'A'),
(17,	2,	3,	4,	'9',	'7'),
(18,	2,	3,	5,	'E',	'4'),
(19,	2,	4,	1,	'A',	'5'),
(20,	2,	4,	3,	'D',	'7'),
(21,	2,	4,	5,	'D',	'D'),
(22,	2,	5,	1,	'B',	'B'),
(23,	2,	5,	3,	'A',	'A'),
(24,	2,	5,	4,	'9',	'C'),
(25,	3,	1,	2,	'E',	'2'),
(26,	3,	1,	4,	'D',	'3'),
(27,	3,	1,	5,	'A',	'7'),
(28,	3,	2,	1,	'8',	'2'),
(29,	3,	2,	4,	'9',	'6'),
(30,	3,	2,	5,	'A',	'3'),
(31,	3,	4,	1,	'C',	'1'),
(32,	3,	4,	2,	'C',	'7'),
(33,	3,	4,	5,	'D',	'B'),
(34,	3,	5,	1,	'8',	'6'),
(35,	3,	5,	2,	'C',	'9'),
(36,	3,	5,	4,	'8',	'2'),
(37,	4,	1,	2,	'A',	'7'),
(38,	4,	1,	3,	'8',	'2'),
(39,	4,	1,	5,	'D',	'D'),
(40,	4,	2,	1,	'9',	'B'),
(41,	4,	2,	3,	'B',	'8'),
(42,	4,	2,	5,	'A',	'A'),
(43,	4,	3,	1,	'9',	'B'),
(44,	4,	3,	2,	'A',	'A'),
(45,	4,	3,	5,	'A',	'A'),
(46,	4,	5,	1,	'8',	'D'),
(47,	4,	5,	2,	'8',	'8'),
(48,	4,	5,	3,	'E',	'B'),
(49,	5,	1,	2,	'9',	'0'),
(50,	5,	1,	3,	'E',	'8'),
(51,	5,	1,	4,	'C',	'C'),
(52,	5,	2,	1,	'8',	'4'),
(53,	5,	2,	3,	'8',	'8'),
(54,	5,	2,	4,	'E',	'B'),
(55,	5,	3,	1,	'B',	'C'),
(56,	5,	3,	2,	'A',	'5'),
(57,	5,	3,	4,	'A',	'8'),
(58,	5,	4,	1,	'D',	'1'),
(59,	5,	4,	2,	'D',	'E'),
(60,	5,	4,	3,	'A',	'1')
ON DUPLICATE KEY UPDATE `idGame` = VALUES(`idGame`), `cableSelect1` = VALUES(`cableSelect1`), `cableSelect2` = VALUES(`cableSelect2`), `cableSelect3` = VALUES(`cableSelect3`), `indice1` = VALUES(`indice1`), `indice2` = VALUES(`indice2`);

-- 2018-10-04 12:56:07
