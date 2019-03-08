<?php
/*
 * @version $Id: jotcache.php,v 1.2 2013/09/25 07:33:15 Jot Exp $
 * @package JotCache
 * @category Joomla 2.5
 * @copyright (C) 2010-2014 Vladimir Kanich
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
defined('_JEXEC') or die('Restricted access');
require_once(JPATH_COMPONENT_ADMINISTRATOR . DS . 'controller.php');
$task = JRequest::getCmd('task');
$controller = JRequest::getCmd('view', 'reset');
require_once(JPATH_COMPONENT_ADMINISTRATOR . DS . 'controllers' . DS . $controller . '.php');
$classname = $controller . 'Controller';
$controller = new $classname();
$controller->execute($task);
$controller->redirect();
?>