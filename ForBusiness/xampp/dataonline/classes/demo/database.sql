-- Adminer 3.7.1 MySQL dump

SET NAMES utf8;
SET foreign_key_checks = 0;
SET time_zone = '+02:00';
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

CREATE DATABASE `userauth` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_bin */;
USE `userauth`;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `login` varchar(255) COLLATE utf8_bin NOT NULL,
  `pass` varchar(255) COLLATE utf8_bin NOT NULL,
  `salt` varchar(255) COLLATE utf8_bin NOT NULL,
  `sid` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`login`),
  UNIQUE KEY `sid` (`sid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `users` (`login`, `pass`, `salt`, `sid`) VALUES
('admin',	'admin',	'',	'');

-- 2013-09-03 19:23:53
