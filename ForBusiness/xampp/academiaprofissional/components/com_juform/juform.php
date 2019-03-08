<?php
/**
 * ------------------------------------------------------------------------
 * JUForm for Joomla 3.x
 * ------------------------------------------------------------------------
 *
 * @copyright      Copyright (C) 2010-2016 JoomUltra Co., Ltd. All Rights Reserved.
 * @license        GNU General Public License version 2 or later; see LICENSE.txt
 * @author         JoomUltra Co., Ltd
 * @website        http://www.joomultra.com
 * @----------------------------------------------------------------------@
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');


jimport('joomla.application.component.controller');
jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.path');

// Don't change this constant if you don't know what are you doing, it can break your site
define('JUFMPROVERSION', false);


JLoader::register('JUFormFrontHelperBreadcrumb', JPATH_SITE . '/components/com_juform/helpers/breadcrumb.php');
JLoader::register('JUFormFrontHelperString', JPATH_SITE . '/components/com_juform/helpers/string.php');
JLoader::register('JUFormFrontHelperLanguage', JPATH_SITE . '/components/com_juform/helpers/language.php');


JUFormFrontHelperLanguage::loadLanguageFile("com_juform.custom");

require_once(dirname(__FILE__) . '/bootstrap.php');

JHtml::_('script', 'system/core.js', false, true);

$app  = JFactory::getApplication();
$task = $app->input->get('task');

switch ($task)
{
	case 'rawdata':
		$field_id      = $app->input->getInt('field_id', 0);
		$submission_id = $app->input->getInt('submission_id', 0);
		$fieldClass    = JUFormFrontHelperField::getField($field_id, $submission_id);
		JUFormHelper::obCleanData();
		$fieldClass->getRawData();
		exit;
		break;

	case 'cron':
		exit;
		break;

	default:
		$controller = JControllerLegacy::getInstance('juform');

		
		$controller->execute($app->input->get('task'));

		
		$controller->redirect();
		break;
}
