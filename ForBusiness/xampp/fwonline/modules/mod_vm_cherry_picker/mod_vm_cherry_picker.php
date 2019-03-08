<?php

defined('_JEXEC') or die('Restricted access');
/**
 * Cherry Picker - Product Filter Module
 *
 * @package Cherry Picker Product Types 3 - September 2013
 * @copyright Copyright � 2009-2013 Maksym Stefanchuk All rights reserved.
 * @license http://www.gnu.org/licenses/gpl.html GNU/GPL
 *
 * http://www.galt.md
 */
// ini_set('display_errors', 1);
// error_reporting(E_ALL);

$cid = JRequest::getVar('virtuemart_category_id', 0);
$displayMode = $params->get('display_mode', 0);

// if set to display only in Virtuemart
$option = JRequest::getVar('option', null);
// if ($displayMode == 1 && $option != 'com_virtuemart') return;
if ($displayMode == 1 && ($option != 'com_virtuemart' ||
        $params->get('hide_in_vm_root', 0) == 1 && $cid == 0))
    return;


$view = JRequest::getVar('view', null);
$displayOnProductDetailsPage = $params->get('display_on_product_details_page', 0);
if ($view == 'productdetails' && !$displayOnProductDetailsPage)
    return;



// Collect debug info
$debugTime = (JRequest::getVar('chp', '') == 'showtime') ? 1 : 0;
$debugQueries = $params->get('enable_debug');
if ($debugTime || $debugQueries) {
    $time_start = microtime(true);
    echo '<div style="color:orange;margin:15px">CP debug mode is ON</div>';
}

if ($debugQueries) {
    $db = JFactory::getDBO();
    $db->debug(1);
    $start_memory = memory_get_usage();
}




require_once('defines.php');
require_once('helpers/factory.php');

$conf = CPFactory::getConfiguration();
$conf->initializeOptions($params->toArray());
$conf->set('module_id', $module->id);

//tiago hack
$conf->set('module_url', JURI::base() . 'modules/mod_vm_cherry_picker/');
$lang1 = JFactory::getLanguage();
$conf->set('cur_lang', substr($lang1->getTag(), 0, 2));
//tiago hack

$moduleController = CPFactory::getModuleController();
$moduleController->run();



// release objects to free memory
CPFactory::releaseObjects();
unset($moduleController);
unset($conf);




// print debug info if enabled
if ($debugTime || $debugQueries) {
    $time_end = microtime(true);
    $elapsed = $time_end - $time_start;
    echo '<br />Elapsed: ' . $elapsed . '<br />';
}

if ($debugQueries) {
    echo '<pre style="font-size:12px;">';
    echo "<br/>Memory peak usage: " . memory_get_peak_usage() . "<br>";
    $end_memory = memory_get_usage();
    echo "<br />Memory usage: " . ($end_memory - $start_memory);
    echo '<br />Queries made:' . $db->getTicker();
    echo '<br/>';
    print_r($db->getLog());
    echo '</pre>';
}
?>
