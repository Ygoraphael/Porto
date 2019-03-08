<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2018-05-16 15:12:26 --> Severity: Warning --> mysqli::real_connect(): (HY000/2002): A connection attempt failed because the connected party did not properly respond after a period of time, or established connection failed because connected host has failed to respond.
 D:\dev\ncao\system\database\drivers\mysqli\mysqli_driver.php 201
ERROR - 2018-05-16 15:12:26 --> Unable to connect to the database
ERROR - 2018-05-16 15:12:36 --> Severity: Warning --> mysqli::real_connect(): (HY000/2002): A connection attempt failed because the connected party did not properly respond after a period of time, or established connection failed because connected host has failed to respond.
 D:\dev\ncao\system\database\drivers\mysqli\mysqli_driver.php 201
ERROR - 2018-05-16 15:12:36 --> Severity: Error --> session_start(): Failed to initialize storage module: user (path: db_session) D:\dev\ncao\system\libraries\Session\Session.php 143
ERROR - 2018-05-16 15:12:38 --> Severity: Warning --> mysqli::real_connect(): (HY000/1045): Access denied for user 'root'@'localhost' (using password: YES) D:\dev\ncao\system\database\drivers\mysqli\mysqli_driver.php 201
ERROR - 2018-05-16 15:12:38 --> Unable to connect to the database
ERROR - 2018-05-16 15:12:38 --> Severity: Warning --> mysqli::real_connect(): (HY000/1045): Access denied for user 'root'@'localhost' (using password: YES) D:\dev\ncao\system\database\drivers\mysqli\mysqli_driver.php 201
ERROR - 2018-05-16 15:12:38 --> Severity: Error --> session_start(): Failed to initialize storage module: user (path: db_session) D:\dev\ncao\system\libraries\Session\Session.php 143
ERROR - 2018-05-16 15:12:47 --> Severity: Warning --> mysqli::real_connect(): (HY000/1049): Unknown database 'taskas' D:\dev\ncao\system\database\drivers\mysqli\mysqli_driver.php 201
ERROR - 2018-05-16 15:12:47 --> Unable to connect to the database
ERROR - 2018-05-16 15:12:47 --> Severity: Warning --> mysqli::real_connect(): (HY000/1049): Unknown database 'taskas' D:\dev\ncao\system\database\drivers\mysqli\mysqli_driver.php 201
ERROR - 2018-05-16 15:12:47 --> Severity: Error --> session_start(): Failed to initialize storage module: user (path: db_session) D:\dev\ncao\system\libraries\Session\Session.php 143
ERROR - 2018-05-16 15:13:13 --> Query error: Table 'ncangola.db_session' doesn't exist - Invalid query: SELECT `data`
FROM `db_session`
WHERE `id` = 'e7vd946mbqkbnvoap3d0rpllmkj9l0bq'
ERROR - 2018-05-16 15:13:13 --> Query error: Table 'ncangola.db_session' doesn't exist - Invalid query: INSERT INTO `db_session` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('e7vd946mbqkbnvoap3d0rpllmkj9l0bq', '::1', 1526476393, '__ci_last_regenerate|i:1526476393;')
ERROR - 2018-05-16 15:13:13 --> Severity: Warning --> session_write_close(): Failed to write session data (user). Please verify that the current setting of session.save_path is correct (db_session) Unknown 0
ERROR - 2018-05-16 15:14:27 --> Query error: Table 'ncangola.db_session' doesn't exist - Invalid query: SELECT `data`
FROM `db_session`
WHERE `id` = 'e7vd946mbqkbnvoap3d0rpllmkj9l0bq'
ERROR - 2018-05-16 15:14:27 --> Query error: Table 'ncangola.db_session' doesn't exist - Invalid query: INSERT INTO `db_session` (`id`, `ip_address`, `timestamp`, `data`) VALUES ('e7vd946mbqkbnvoap3d0rpllmkj9l0bq', '::1', 1526476467, '__ci_last_regenerate|i:1526476467;')
ERROR - 2018-05-16 15:14:27 --> Severity: Warning --> session_write_close(): Failed to write session data (user). Please verify that the current setting of session.save_path is correct (db_session) Unknown 0
