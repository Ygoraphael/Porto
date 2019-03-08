-- version $Id: uninstall.sqlsrv.utf8.sql,v 1.2 2012/02/14 12:21:28 Vlado Exp $
-- SQL script for MS SQL Server
-- package JotCache
-- category Joomla 2.5
-- copyright (C) 2010-2014 Vladimir Kanich
-- license http://www.gnu.org/copyleft/gpl.html GNU/GPL
IF EXISTS (SELECT * FROM sysobjects 
WHERE id = object_id(N'[dbo].[#__jotcache]')
AND type in (N'U'))
DROP TABLE [#__jotcache];
IF EXISTS (SELECT * FROM sysobjects 
WHERE id = object_id(N'[dbo].[#__jotcache_exclude]')
AND type in (N'U'))
DROP TABLE [#__jotcache_exclude];