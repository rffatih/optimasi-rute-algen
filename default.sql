-- Adminer 4.8.1 MySQL 5.5.5-10.6.4-MariaDB-1:10.6.4+maria~focal dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `attribute`;
CREATE TABLE `attribute` (
  `kode` varchar(7) NOT NULL,
  `nama` varchar(31) DEFAULT NULL,
  PRIMARY KEY (`kode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `attribute` (`kode`, `nama`) VALUES
('start',	NULL),
('time',	NULL);

DROP TABLE IF EXISTS `list_object`;
CREATE TABLE `list_object` (
  `kode` varchar(5) NOT NULL,
  `nama` varchar(25) NOT NULL,
  PRIMARY KEY (`kode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `matrix_jarak`;
CREATE TABLE `matrix_jarak` (
  `kode` varchar(5) NOT NULL,
  `awal` int(11) DEFAULT NULL,
  PRIMARY KEY (`kode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- 2021-10-27 18:24:12
