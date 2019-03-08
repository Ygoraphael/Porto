<?php
/**------------------------------------------------------------------------
03.# mod_wdsfacebookwall - WDS Facebook Wall for Joomla! 2.5, 3.X
04.# ------------------------------------------------------------------------
05.# author    Robert Long
06.# copyright Copyright (C) 2013 Webdesignservices.net. All Rights Reserved.
07.# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
08.# Websites: http://www.webdesignservices.net
09.# Technical Support:  Support - https://www.webdesignservices.net/support/customer-support.html
10.------------------------------------------------------------------*/
// no direct access
defined('_JEXEC') or die;



// Include the helper file

require_once dirname(__FILE__).'/helper.php';



// if cURL is disabled, then extension cannot work

if(!is_callable('curl_init')){

	$data = false;

	$curlDisabled = true;

}

else {

	$model = new mod_wdsfacebookwall();

	$model->addStyles($params);

	 $FBdata = $model->getData($params);

}



if( $FBdata) {

	require JModuleHelper::getLayoutPath('mod_wdsfacebookwall', $params->get('layout', 'default'));

}

else {

	require JModuleHelper::getLayoutPath('mod_wdsfacebookwall', 'error/error');

}

