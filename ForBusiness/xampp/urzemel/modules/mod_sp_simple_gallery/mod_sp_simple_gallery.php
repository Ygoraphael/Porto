<?php
/**
* @title		Simple image gallery module
* @website		http://www.joomshaper.com
* @copyright	Copyright (C) 2010 - 2012 JoomShaper.com. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
*/

// no direct access
defined('_JEXEC') or die('Restricted access');
$document 			= JFactory::getDocument();
$uniqid				= $module->id;
$style				= $params->get('style', "border:1px solid #DDD; margin:0 5px 10px 5px; padding:5px; background:#fff;");
$styles 			= 'img.sp_simple_gallery {' . $style . '}'; 

$document->addStyleSheet(JURI::base(true) . '/modules/mod_sp_simple_gallery/scripts/slimbox.css');
if (JVERSION<3) {
	JHtml::_('behavior.framework',true);
	$document->addScript(JURI::base(true) . '/modules/mod_sp_simple_gallery/scripts/slimbox.js');
} else {
	JHtml::_('jquery.framework');
	$document->addScript(JURI::base(true) . '/modules/mod_sp_simple_gallery/scripts/slimbox_jquery.js');
}
$document->addStyleDeclaration( $styles );

require_once (dirname(__FILE__).'/helper.php');
$list = modSPGalleryHelper::getimgList($params);
require(JModuleHelper::getLayoutPath('mod_sp_simple_gallery'));