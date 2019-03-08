-- version $Id: install.sqlsrv.utf8.sql,v 1.8 2014/06/07 12:15:07 Jot Exp $
-- SQL script for MS SQL Server
-- package JotCache
-- category Joomla 2.5
-- copyright (C) 2010-2014 Vladimir Kanich
-- license http://www.gnu.org/copyleft/gpl.html GNU/GPL
IF NOT EXISTS (SELECT * FROM sysobjects 
WHERE id = object_id(N'[dbo].[#__jotcache]')
AND type in (N'U'))
CREATE TABLE [#__jotcache] (
  [fname] nvarchar(76) NOT NULL,
  [domain] nvarchar(255) NOT NULL,
  [com] nvarchar(100) NOT NULL,
  [view] nvarchar(100) NOT NULL,
  [id] bigint NOT NULL,
  [ftime] datetime NOT NULL,
  [mark] tinyint,
  [recache] tinyint,
  [recache_chck] tinyint,
  [agent] tinyint,
  [checked_out] bigint NOT NULL,
  [title] nvarchar(255) NOT NULL,
  [uri] nvarchar(2000) NOT NULL,
  [language] nvarchar(5) NOT NULL,
  [browser] nvarchar(50) NOT NULL,
  [qs] nvarchar(2000) NOT NULL,
  [cookies] nvarchar(2000) NOT NULL,
  [sessionvars] nvarchar(2000) NOT NULL,
  CONSTRAINT [PK_#__jotcache_fname] PRIMARY KEY CLUSTERED (
	[fname] ASC
));
IF NOT EXISTS (SELECT * FROM sysobjects 
WHERE id = object_id(N'[dbo].[#__jotcache_exclude]')
AND type in (N'U'))
CREATE TABLE [#__jotcache_exclude] (
  [id] int IDENTITY(1,1) NOT NULL,
  [name] nvarchar(64) NOT NULL,
  [value] nvarchar(2000) NOT NULL,
  [type] tinyint,
CONSTRAINT [PK_#__jotcache_exclude_id] PRIMARY KEY CLUSTERED (
	[id] ASC
));