<?php
/*
 * @version 4.2.3
 * @package JotCache
 * @category Joomla 2.5
 * @copyright (C) 2010-2014 Vladimir Kanich
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
defined('_JEXEC') or die;
class plgSystemJotmarker extends JPlugin {
public function onAfterDispatch() {
$app = JFactory::getApplication();
if ($app->isAdmin() || JDEBUG || $_SERVER['REQUEST_METHOD'] == 'POST') {
return;
}JLoader::register('JDocumentRendererModules', dirname(__FILE__) . '/modules.php', true);
}public function onAfterRenderModules(&$buffer, &$params) {
$app = JFactory::getApplication();
if ($app->isAdmin() || JDEBUG || $_SERVER['REQUEST_METHOD'] == 'POST') {
return;
}$user = JFactory::getUser();
if (!$user->get('guest', false)) {
return;
}$database = JFactory::getDBO();
$query = $database->getQuery(true);
$tpl_id = 1;
$query->select('value')
->from('#__jotcache_exclude')
->where($database->quoteName('type') . ' = 4')
->where($database->quoteName('name') . ' = ' . (int) $tpl_id);
$value = $database->setQuery($query)->loadResult();
$tplDef = unserialize($value);
if (is_array($tplDef) && is_array($params) && key_exists("name", $params) && key_exists($params["name"], $tplDef) && strlen($buffer) > 0) {
$prefix = '<jot ' . $params["name"] . ' s';
if (key_exists('style', $params)) {
$prefix .=' style="' . $params["style"] . '"';
}if (count($params) > 2) {
foreach ($params as $key => $value) {
if ($key == 'name' || $key == 'style') {
continue;
} else {
$prefix .=' ' . $key . '="' . $value . '"';
}}}$buffer = $prefix . ' >' . $buffer . '<jot ' . $params["name"] . ' e >';
}}}?>