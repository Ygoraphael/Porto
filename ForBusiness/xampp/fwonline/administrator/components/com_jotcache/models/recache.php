<?php
/*
 * @version $Id: recache.php,v 1.10 2013/10/04 10:25:03 Jot Exp $
 * @package JotCache
 * @category Joomla 2.5
 * @copyright (C) 2010-2014 Vladimir Kanich
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.model');
require_once JPATH_ADMINISTRATOR . '/components/com_jotcache/helpers/recacherunner.php';
class RecacheModelRecache extends JModel {
var $_db;
var $_sql = "";
function RecacheModelRecache() {
parent::__construct();
}function runRecache() {
$params = JComponentHelper::getParams("com_jotcache");
$timeout = (int) $params->get('recachetimeout', 300);
register_shutdown_function(array($this, 'recacheShutdown'));
ini_set('max_execution_time', $timeout);
$scopeAllow = array('none', 'chck', 'sel', 'all', 'direct');
$scope = JRequest::getWord('scope', '');
if (in_array($scope, $scopeAllow, TRUE)) {
$this->_sql = $this->_db->getQuery(true);
switch ($scope) {
case 'none':
return;
case 'chck':
$this->_sql->update($this->_db->quoteName('#__jotcache'))
->set($this->_db->quoteName('recache') . ' = ' . $this->_db->quote(1))
->set($this->_db->quoteName('recache_chck') . ' = ' . $this->_db->quote(0))
->where("recache_chck='1'");
$sql = $this->_db->setQuery($this->_sql);
          $sql->query();
break;
case 'sel':
          $search = JRequest::getString('search');
$com = JRequest::getCmd('com');
$view = JRequest::getCmd('pview');
$mark = JRequest::getInt('mark');
$params = JComponentHelper::getParams("com_jotcache");
$mode = (bool) $params->get('mode');
if ($com) {
$this->_sql->where("com='$com'");
}if ($view) {
$part = $this->_db->quoteName('view');
$this->_sql->where("$part='$view'");
}if ($mark) {
$this->_sql->where("mark='$mark'");
}if ($search) {
if ($mode) {
$this->_sql->where('LOWER(uri) LIKE ' . $this->_db->Quote('%' . $this->_db->getEscaped($search, true) . '%', false));
} else {
$this->_sql->where('LOWER(title) LIKE ' . $this->_db->Quote('%' . $this->_db->getEscaped($search, true) . '%', false));
}}break;
default:
break;
}if ($scope != 'direct') {
$this->_sql->update($this->_db->quoteName('#__jotcache'))
->set($this->_db->quoteName('recache') . ' = ' . $this->_db->quote(1));
$sql = $this->_db->setQuery($this->_sql);
        $sql->query();
}$this->controlRecache(1);
define('JOTCACHE_RECACHE_BROWSER', true);
$main = new RecacheRunner();
$jcplugin = strtolower(JRequest::getWord('jotcacheplugin'));
$jcparams = JRequest::getVar('jcparams', array(), 'get', 'array');
$states = JRequest::getVar('jcstates', array(), 'post', 'array');
$jcstates = array();
if (count($states) > 0) {
$app = JFactory::getApplication();
foreach ($states as $key => $value) {
$cur_state = $app->getUserState('jotcache.' . $jcplugin . '.' . $key, null);
$new_state = $states[$key];
if ($cur_state !== $new_state) {
$jcstates[$key] = $new_state;
$app->setUserState('jotcache.' . $jcplugin . '.' . $key, $new_state);
} else {
$jcstates[$key] = $cur_state;
}}}$starturl = JURI::root();
if(substr($starturl, -1)=='/'){
$starturl = substr($starturl,0,strlen($starturl)-1);
}      $main->doExecute($starturl, $jcplugin, $jcparams, $jcstates);
}}function recacheShutdown() {
echo JText::_('JOTCACHE_RECACHE_SHUTDOWN'), PHP_EOL;
}function flagRecache() {
$cid = JRequest::getVar('cid', array(0), '', 'array');
$list = implode("','", $cid);
$this->_sql = $this->_db->getQuery(true);
$this->_sql->update($this->_db->quoteName('#__jotcache'))
->set($this->_db->quoteName('recache_chck') . ' = ' . $this->_db->quote(1))
->where("fname IN ('$list')");
$this->_db->setQuery($this->_sql)->query();
}function controlRecache($flag) {
$cacheDir = JPATH_CACHE . '/page';
if (!file_exists($cacheDir)) {
mkdir($cacheDir, 0755);
}$flagPath = $cacheDir . '/jotcache_recache_flag_tmp.php';
if ($flag) {
file_put_contents($flagPath, "defined('_JEXEC') or die;", LOCK_EX);
} else {
if (file_exists($flagPath)) {
unlink($flagPath);
$this->_sql = $this->_db->getQuery(true);
$this->_sql->update($this->_db->quoteName('#__jotcache'))
->set($this->_db->quoteName('recache') . ' = ' . $this->_db->quote(0));
$this->_db->setQuery($this->_sql)->query();
}}}function getPlugins() {
$query = $this->_db->getQuery(true);
$query->select('p.*')
->from('#__extensions AS p')
->where('p.enabled = 1')
->where('p.type = ' . $this->_db->quote('plugin'))
->where('p.folder = ' . $this->_db->quote('jotcacheplugins'))
->order('p.ordering');
$this->_db->setQuery($query);
$plugins = $this->_db->loadObjectList();
return $plugins;
}}