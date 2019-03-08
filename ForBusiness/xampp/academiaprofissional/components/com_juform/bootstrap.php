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

defined('_JEXEC') or die('Restricted access');

jimport('joomla.filesystem.file');
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.path');
jimport('joomla.access.access');

require_once dirname(__FILE__) . '/constants.php';
require_once JUFORM_HELPERS . '/helper.php';
require_once JUFORM_HELPERS . '/field.php';
require_once JUFORM_HELPERS . '/route.php';
require_once JUFORM_HELPERS . '/language.php';
require_once JUFORM_HELPERS . '/mail.php';
require_once JUFORM_HELPERS . '/template.php';
require_once JUFORM_ADMIN_HELPERS . '/juform.php';
require_once JUFORM_ADMIN_ROOT . '/timthumb/timthumb.php';


JUFormFrontHelperLanguage::loadLanguageFile("com_juform.custom");

spl_autoload_register(array('JUFormHelper', 'autoLoadFieldClass'));
?>