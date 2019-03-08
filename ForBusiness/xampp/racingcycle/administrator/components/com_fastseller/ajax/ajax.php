<?php
// Set flag that this is a parent file
define( '_JEXEC', 1 );

// Use script path on local set-up and __FILE__ on production
if (isset($_ENV['FASTSELLER_LOCAL'])) {
	define('JPATH_BASE', dirname(dirname(dirname(dirname($_SERVER['SCRIPT_FILENAME'])))) );
	// Maximum error reporting for local development
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
} else {
	define('JPATH_BASE', dirname(dirname(dirname(dirname(__FILE__)))) );
}
define('DS', DIRECTORY_SEPARATOR);
require(JPATH_BASE.DS.'includes'.DS.'defines.php');
require(JPATH_BASE.DS.'includes'.DS.'framework.php');

$app = JFactory::getApplication('administrator');

require('helper.php');
