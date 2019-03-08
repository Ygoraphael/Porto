<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_vmsubmenu
 * @copyright	Copyright 2015 Linelab.org. All rights reserved.
 * @license		GNU General Public License version 2
 */
// no direct access
defined('_JEXEC') or die;
// Include the syndicate functions only once
require_once dirname(__FILE__).'/helper.php';
$list	= modMenuLinelabHelper::getList($params);
$app	= JFactory::getApplication();
$menu	= $app->getMenu();
$active	= $menu->getActive();
$active_id = isset($active) ? $active->id : $menu->getDefault()->id;
$path	= isset($active) ? $active->tree : array();
$showAll	= $params->get('showAllChildren');
$class_sfx	= htmlspecialchars($params->get('class_sfx'));
//print_r($list);
//echo JFactory::getLanguage()->getTag();
if(count($list)) {
	require JModuleHelper::getLayoutPath('mod_vmsubmenu', $params->get('layout', 'default'));
}