<?php
if (!defined('_JEXEC'))
    define('_JEXEC', 1);
if (!defined('DS'))
    define('DS', DIRECTORY_SEPARATOR);
if (!defined('JPATH_BASE'))
    define('JPATH_BASE', $_SERVER['DOCUMENT_ROOT'] . DS . "dev" . DS . "fw");

require_once( JPATH_BASE . DS . 'includes' . DS . 'defines.php' );
require_once( JPATH_BASE . DS . 'includes' . DS . 'framework.php' );
require_once( JPATH_BASE . DS . 'libraries' . DS . 'joomla' . DS . 'factory.php' );

if (!defined('ADMIN_EMAIL'))
    define('ADMIN_EMAIL', 'tiago.loureiro@novoscanais.com');

date_default_timezone_set('Europe/Lisbon');