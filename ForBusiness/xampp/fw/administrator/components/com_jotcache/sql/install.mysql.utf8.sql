-- version $Id: install.mysql.utf8.sql,v 1.7 2014/06/07 12:15:07 Jot Exp $
-- SQL script for MySQL database
-- package JotCache
-- category Joomla 2.5
-- copyright (C) 2010-2014 Vladimir Kanich
-- license http://www.gnu.org/copyleft/gpl.html GNU/GPL
CREATE TABLE IF NOT EXISTS `#__jotcache` (
  `fname` varchar(76) NOT NULL,
  `domain` varchar(255) NOT NULL,
  `com` varchar(100) NOT NULL,
  `view` varchar(100) NOT NULL,
  `id` int(11) NOT NULL,
  `ftime` datetime NOT NULL,
  `mark` tinyint(1) NOT NULL,
  `recache` tinyint(1) NOT NULL,
  `recache_chck` tinyint(1) NOT NULL,
  `agent` tinyint(1) NOT NULL,
  `checked_out` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `uri` text NOT NULL,
  `language` varchar(5) NOT NULL,
  `browser` varchar(50) NOT NULL,
  `qs` text NOT NULL,
  `cookies` text NOT NULL,
  `sessionvars` text NOT NULL,
  PRIMARY KEY (`fname`)
);
CREATE TABLE IF NOT EXISTS `#__jotcache_exclude` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(64) NOT NULL default '',
  `value` text NOT NULL,
  `type` tinyint(4) NOT NULL,
  PRIMARY KEY  (`id`));