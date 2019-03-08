<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
header('Content-type: text/html; charset=utf-8');
header('Expires: -1');

//$uri = JFactory::getURI();
//$site = $uri->getScheme().'://'.$uri->getHost();

// Access this content only from Administrator area, when logged in.
$user = JFactory::getUser();
if ($user->id == 0) {
	//$app->redirect( $site, '' );
	die();
}

$base = JURI::base();
$correct_path = strpos($base, 'com_fastseller');
if ($correct_path === false) {
	$base .= 'components/com_fastseller/ajax/';
}

// $comp_path = dirname(dirname(__FILE__)) .'/';

$uri = JFactory::getURI();
$base_url = $uri->getScheme() .'://'. $uri->getHost() .
	dirname(dirname(dirname(dirname(dirname($uri->getPath()))))) .'/';

define('FS_AJAX', $base .'ajax.php');
define('FS_PATH', JPATH_BASE . DIRECTORY_SEPARATOR .'components'. DIRECTORY_SEPARATOR .'com_fastseller/');
define('FS_URL', dirname($base) .'/');
define('FS_BASE_URL', $base_url);


require(FS_PATH .'controllers/FSConf.php');
FSConf::getConfiguration();

require(FS_PATH .'defines.php');


$debugQueries = FSConf::get('debug');
if ($debugQueries) {
	$dd = JFactory::getDBO(); // set database to debug, to calculate the number of queries made
	$dd->debug(1);

	ini_set('display_errors',1);
	error_reporting(E_ALL);
}



$index = JRequest::getCmd('i', '');
switch ($index) {

	case 'HOME':
		require(FS_PATH .'controllers/FSHome.php');
		break;

	case 'ASSIGN':
		require(FS_PATH .'controllers/FSAssignFilters.php');
		break;

	case 'CREATE':
		require(FS_PATH .'controllers/FSCreateFilters.php');
		break;

	case 'CONF':
		require(FS_PATH .'controllers/FSConfigureOptions.php');
		break;

	case 'HELP':
		require(FS_PATH .'controllers/FSHelp.php');
		break;

	default:
		require(FS_PATH .'controllers/FSHome.php');
		break;
}



if ($debugQueries) {
	echo '<br />Queries made:'.$dd->getTicker();
	echo '<pre>';
	print_r($dd->getLog());
	echo '</pre>';
}

?>
