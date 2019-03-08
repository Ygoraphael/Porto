<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

header('Content-type: text/html; charset=utf-8');

// ini_set('display_errors',1);
// error_reporting(E_ALL);

// by default SCRIPT_NAME = /modules/mod_vm_cherry_picker_cf/ajax/ajax.php
// and JRoute takes it as PATH. Let's substitute it to index.php
// $_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['SCRIPT_NAME'] = dirname(dirname(dirname(dirname($_SERVER['SCRIPT_NAME'])))) .'/index.php';
// $_SERVER['PHP_SELF'] = '/index.php';

// When the site is in the subdirectory: /second/index.php
// Joomla router tends to loose VM category when using CP Update with Ajax.
// Having this line fixes the issue.
JRoute::_('index.php?option=com_virtuemart&view=category');


$module_id = (int)JRequest::getVar('module_id', null);
if (! $module_id)
	die('No module');

require('../defines.php');
require('../helpers/factory.php');


$conf = CPFactory::getConfiguration();
$conf->getOptionsForModule($module_id);
$conf->set('module_url', JURI::base() .'modules/mod_vm_cherry_picker/');

$ajax_request = (isset($_SERVER['HTTP_X_REQUESTED_WITH'])
	&& $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') ? true : false;
$conf->set('ajax_request', $ajax_request);


$debugQueries = $conf->get('enable_debug');
if ($debugQueries) {
	$db = JFactory::getDBO(); // set database to debug, to calculate the number of queries made
	$db->debug(1);
	$time_start = microtime(true);
	$start_memory = memory_get_usage();
}

$moduleController = CPFactory::getModuleController();
$conf->set('legacy_mode', $moduleController->shouldRunInLegacyMode());

$actionType = JRequest::getVar('action_type', null);

switch ($actionType) {
	case 'seemore':
		require('seemore_helper.php');
		break;

	case 'get_total':
		require('totalresults_helper.php');
		break;

	case 'get_dd_filters':
		require('dropdown_getfilters_helper.php');
		break;

	case 'load_module':
		require('load_module_helper.php');
		break;

	case 'simple_dropdown_next_filters':
		require('simpledropdown_progressive_load_helper.php');
		break;

	case 'warning_message_dialog':
		require('warning_message_helper.php');
		break;

	default:
		die();
}




if ($debugQueries) {
	echo '<pre style="font-size:12px;">';

	$time_end = microtime(true);
	$elapsed = $time_end - $time_start;
	echo '<br />Elapsed: '. $elapsed .'<br />';

	echo "<br/>Memory peak usage: ". memory_get_peak_usage() . "<br>";
	$end_memory = memory_get_usage();
	echo "<br />Memory usage: ". ($end_memory - $start_memory);
	echo '<br />Queries made:'. $db->getTicker();
	echo '<br/>';
	print_r($db->getLog());
	echo '</pre>';
}
