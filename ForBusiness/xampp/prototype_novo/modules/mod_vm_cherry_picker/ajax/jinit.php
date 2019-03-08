<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

// define('JPATH_BASE', dirname(dirname(dirname(dirname(__FILE__)))));
define('JPATH_BASE', dirname(dirname(dirname(dirname($_SERVER['SCRIPT_FILENAME'])))));
define('DS', DIRECTORY_SEPARATOR );
require(JPATH_BASE.DS.'includes'.DS.'defines.php');
require(JPATH_BASE.DS.'includes'.DS.'framework.php');

$mainframe = JFactory::getApplication('site');