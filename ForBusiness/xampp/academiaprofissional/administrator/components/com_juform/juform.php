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

jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.path');

// Don't change this constant if you don't know what are you doing, it can break your site
define('JUFMPROVERSION', false);


JLoader::register('JUFormFrontHelperString', JPATH_SITE . '/components/com_juform/helpers/string.php');
JLoader::register('JUFMViewAdmin', JPATH_ADMINISTRATOR . '/components/com_juform/helpers/jufmviewadmin.php');

require_once(JPATH_SITE . '/components/com_juform/bootstrap.php');

spl_autoload_register(array('JUFormHelper', 'autoLoadFieldClass'));


jimport('joomla.application.component.controller');

$app = JFactory::getApplication();


$task       = $app->input->get('task');
$view       = $app->input->get('view');
$permission = JUFormHelper::checkGroupPermission($task, $view);
if (!$permission)
{
	return JError::raiseError(403, JText::_('JLIB_APPLICATION_ERROR_ACCESS_FORBIDDEN'));
}


if (!JFactory::getUser()->authorise('core.manage', 'com_juform'))
{
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}

$document = JFactory::getDocument();
$document->addStyleSheet(JUri::root(true) . '/administrator/components/com_juform/assets/css/styles.css');

JUFormFrontHelper::loadjQuery();
JUFormFrontHelper::loadBootstrap();

$task = $app->input->get('task');

switch ($task)
{
	case 'rawdata':
		$field_id      = $app->input->getInt('field_id', 0);
		$submission_id = $app->input->getInt('submission_id', 0);
		$fieldObj      = JUFormFrontHelperField::getField($field_id, $submission_id);
		JUFormHelper::obCleanData();
		$fieldObj->getRawData();
		exit;
		break;

	default:
		
		$controller = JControllerLegacy::getInstance('JUForm');

		
		$controller->execute($app->input->get('task'));

		
		$controller->redirect();

		break;
}
