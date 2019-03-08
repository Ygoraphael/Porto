<?php
/*
 * @version $Id: jotcache.php,v 1.27 2014/06/16 06:35:00 Jot Exp $
 * @package JotCache
 * @category Joomla 2.5
 * @copyright (C) 2010-2014 Vladimir Kanich
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
defined('JPATH_BASE') or die;
jimport('joomla.plugin.plugin');
require_once(dirname(__FILE__) . '/jotcache/UserAgent.php');
require_once(dirname(__FILE__) . '/jotcache/JotcacheFileCache.php');
class plgSystemJotCache extends JPlugin {
protected $_cache = null;
protected $_fname = null;
protected $_exclude = false;
protected $_uri = null;
protected $_agent = false;
protected $_clean = false;
public function plgSystemJotCache(& $subject, $config) {
    if (array_key_exists('HTTP_X_REQUESTED_WITH', $_SERVER)) {
return;
}    parent::__construct($subject, $config);
$browser = "";
$this->_agent = (array_key_exists('HTTP_USER_AGENT', $_SERVER) && (strpos($_SERVER['HTTP_USER_AGENT'], 'jotcache') !== false)) ? true : false;
$cache_client = $this->params->get('cacheclient', '');
$bot_exclude = $this->params->get('botexclude', '1');
if ($cache_client || $bot_exclude) {
if (!is_array($cache_client))
$cache_client = array($cache_client);
$userAgent = new UserAgent();
$browser = $userAgent->getBrowserName();
if ($bot_exclude && $browser == 'bot') {
$this->_exclude = true;
} else {
if ($browser === null) {
if ($this->_agent === true) {
$browser = "";
} else {
$this->_exclude = true;
}} else {
if (!in_array($browser, $cache_client)) {
$browser .= substr($userAgent->getBrowserVersion(), 0, 3);
if (!in_array($browser, $cache_client)) {
$browser = "";
}}}}}$globalex = $this->params->get('cacheexclude', '');
if ($globalex and $browser !== null) {
$globalex = explode(',', $globalex);
$uri = $this->_getUri();
      foreach ($globalex as $ex) {
if (strpos($uri, $ex) !== false) {
$this->_exclude = true;
break;
}}}$cookieslist = $this->params->get('cachecookies', '');
$cookies = '';
if ($cookieslist !== '') {
if (substr($cookieslist, 0, 1) == '#') {
$cookieslist = substr($cookieslist, 1);
}$cookiegroups = explode('#', $cookieslist);
foreach ($cookiegroups as $cookiegroup) {
        $cookiedef = trim($cookiegroup);
        $cookie = JRequest::getVar($cookiedef, "", "COOKIE");
if ($cookie) {
$cookies .="#" . $cookiedef . $cookie;
}}}$varlist = $this->params->get('cachesessionvars', '');
$sessionvars = '';
if ($varlist !== '') {
$app = JFactory::getApplication();
if (substr($varlist, 0, 1) == '#') {
$varlist = substr($varlist, 1);
}$vargroups = explode('#', $varlist);
foreach ($vargroups as $vargroup) {
$vardef = trim($vargroup);
$sessionvar = $app->getUserState("$vardef");
if ($sessionvar) {
$sessionvars .="#" . $vardef . $sessionvar;
}}}    $options = array(
'defaultgroup' => 'page',
'lifetime' => $this->params->get('cachetime', 15) * 60,
'browsercache' => 0,
'browseron' => $this->params->get('browsercache', false),
'browsertime' => $this->params->get('browsertime', 1) * 60,
'caching' => false,
'browser' => $browser,
'cookies' => $cookies,
'sessionvars' => $sessionvars,
'uri' => $this->_getUri()
);$this->_cache = new JotcacheFileCache($options);
}protected function _getUri() {
if (!isset($this->_uri)) {
$uri = JUri::getInstance();
if ($this->params->get('domain', '0')) {
        $this->_uri = $uri->toString(array('scheme', 'host', 'port', 'path', 'query'));
} else {
$this->_uri = $uri->toString(array('path', 'query'));
}}return $this->_uri;
}public function onAfterInitialise() {
global $_PROFILER;
$app = JFactory::getApplication();
$user = JFactory::getUser();
$renew = (JRequest::getVar('jotcachemark', '0', 'COOKIE', 'INT') == 2);
if ($this->_agent) {
$this->_cache->setCaching(true);
return;
}if ($app->isAdmin() || JDEBUG || ($_SERVER['REQUEST_METHOD'] == 'POST') || (count($app->getMessageQueue()) > 0) || $this->_exclude || $renew) {
return;
}if ($this->params->get('autoclean', 0)) {
$this->autoclean();
}if (!$user->get('guest') || $_SERVER['REQUEST_METHOD'] != 'GET') {
return;
} else {
$this->_cache->setCaching(true);
}$data = $this->_cache->get();
$this->_setCacheMark();
if ($data !== false) {
$app->route();
      if (file_exists(dirname(__FILE__) . '/custom.php')) {
include dirname(__FILE__) . '/custom.php';
}$data = $this->_rewriteData($data, $app);
$token = JUtility::getToken();
$search = '#<input type="hidden" name="[0-9a-f]{32}" value="1" />#';
$replacement = '<input type="hidden" name="' . $token . '" value="1" />';
$data = preg_replace($search, $replacement, $data);
$cookie_mark = JRequest::getVar('jotcachemark', '0', 'COOKIE', 'INT');
if ($cookie_mark) {
$site_url = JURI::root();
$lang = JFactory::getLanguage();
$lang->load('plg_system_jotcache', JPATH_ADMINISTRATOR, null, false, true);
$renew_url = $site_url . 'administrator/index.php?option=com_jotcache&view=reset&task=renew&token=';
$link_css = '<link rel="stylesheet" href="' . $site_url . 'plugins/system/jotcache/jotcache/plg_jotcache.css" type="text/css" />';
$data = preg_replace('#<title>(.*)<\/title>#', '<title>[MARK] \\1</title>' . $link_css, $data);
$data = preg_replace('#<body([^>]*)>#', '<body \\1><div class="jotcache_top"><p>JotCache Mark Mode</p><p class="jotcache_fix"><a href="' . $renew_url . $this->_cache->fname . '">' . JText::_('JOTCACHE_RENEW_LBL') . '</a></p></div>', $data);
} else {
$data = preg_replace('/<jot .*? >/', '', $data);
}if ($this->_cache->options['browseron']) {
$database = JFactory::getDBO();
$uri = $this->_getUri();
        $btime = $this->getBrowserTime($uri, $database);
if ($btime > 0) {
JResponse::allowCache(true);
JResponse::setHeader('Expires', gmdate('D, d M Y H:i:s', time() + $btime) . ' GMT');
}}JResponse::setBody($data);
echo JResponse::toString($app->getCfg('gzip'));
if (JDEBUG) {
$_PROFILER->mark('afterCache');
echo implode('', $_PROFILER->getBuffer());
}$app->close();
}}private function _rewriteData($data, $app) {
$document = JFactory::getDocument();
    $result = null;
    if (strpos($data, '<!-- jot ') !== false) {
$data = preg_replace('#(<!--\s)(jot\s[_a-zA-Z0-9-]*\s[es]\s(?:\w*="[_a-zA-Z0-9-]*"\s*)*)(-->)#', '<$2>', $data);
}preg_match_all('#<jot\s([_a-zA-Z0-9-]*)\s[es]\s((?:\w*="[_a-zA-Z0-9-\.\s]*"\s*)*)>#', $data, $matches);
$marks = $matches[0];
$checks = array_unique($matches[1]);
$attrs = $matches[2];
$err = array();
for ($i = 0; $i < count($marks); $i = $i + 2) {
if ($marks[$i] != "<jot " . @$checks[$i] . " s " . @$attrs[$i] . ">" || @$marks[$i + 1] != "<jot " . @$checks[$i] . " e >")
$err[] = @$checks[$i];
}if (!array_key_exists(0, $err)) {
      $lang = JFactory::getLanguage();
      $lang->load('lib_joomla', JPATH_SITE, null, false, false)
              || $lang->load('lib_joomla', JPATH_SITE, null, true);
$template = $app->getTemplate();
$lang->load('tpl_' . $template, JPATH_BASE, null, false, false) || $lang->load('tpl_' . $template, JPATH_THEMES . "/$template", null, false, false) || $lang->load('tpl_' . $template, JPATH_BASE, $lang->getDefault(), false, false) || $lang->load('tpl_' . $template, JPATH_THEMES . "/$template", $lang->getDefault(), false, false);
$end = 0;
foreach ($checks as $key => $value) {
$start = strpos($data, "<jot " . $value . " s " . $attrs[$key] . ">", $end) + strlen($value) + strlen($attrs[$key]) + 9;
$end = strpos($data, "<jot " . $value . " e >", $start);
$chunk = substr($data, $start, $end - $start);
$attribs = JUtility::parseAttributes($attrs[$key]);
$attribs['name'] = $value;
$replacement = $document->getBuffer('modules', $value, $attribs);
if ($this->params->get('cachemark', false)) {
$cookie_mark = JRequest::getVar('jotcachemark', '0', 'COOKIE', 'INT');
if ($cookie_mark) {
$replacement = '<div style="outline: Red dashed thin;">' . $replacement . '</div>';
}}if ($this->params->get('cachecompress', false)) {
$replacement = preg_replace('#\n\s+#', "\n", $replacement);
$replacement = preg_replace('/(?:(?<=\>)|(?<=\/\>))(\s+)(?=\<\/?)/', '', $replacement);
$replacement = preg_replace('#<!--[^>\[\]]*-->#', '', $replacement);
}$part1 = substr($data, 0, $start);
$part2 = substr($data, $end);
$data = $part1 . $replacement . $part2;
$end = $end - strlen($chunk) + strlen($replacement);
}}return $data;
}public function onAfterRender() {
$app = JFactory::getApplication();
if ($app->isAdmin() || JDEBUG || $_SERVER['REQUEST_METHOD'] == 'POST' || $this->_exclude) {
return;
}    if ((count($app->getMessageQueue()) > 0)) {
@$this->_cache->remove($this->_cache->_getFilePath());
return;
}    if ($this->blockedUri()) {
return;
}$user = JFactory::getUser();
$mark = $this->_setCacheMark();
$expart = false;
if ($user->get('guest')) {
$database = JFactory::getDBO();
$com = JRequest::getCmd('option', '');
$view = JRequest::getCmd('view', '');
$query = $database->getQuery(true);
$query->select($database->quoteName('value'))
->from('#__jotcache_exclude')
->where('name=' . $database->quote($com));
$value = $database->setQuery($query)->loadResult();
$expart = $this->_exlude($view, $value);
$exclude = ($value == '1' or $expart) ? true : false;
if ($exclude) {
return;
}$id = JRequest::getInt('id', 0);
if ($id == 0)
$id = JRequest::getInt('cid', 0);
$fname = $this->_cache->fname;
$uri = $this->_getUri();
      $qs = serialize(JRequest::get('GET'));
$browser = $this->_cache->options['browser'];
$language = $this->_cache->options['language'];
$document = JFactory::getDocument();
$title = (get_magic_quotes_gpc()) ? addslashes($document->title) : $document->title;
$btime = 0;
if ($this->_cache->options['browseron']) {
$btime = $this->getBrowserTime($uri, $database);
}      if ($btime === 0) {
$tpl_id = 1;
$query->clear();
$query->select('value')
->from('#__jotcache_exclude')
->where($database->quoteName('type') . ' = 4')
->where($database->quoteName('name') . ' = ' . (int) $tpl_id);
$value = $database->setQuery($query)->loadResult();
$tplDef = unserialize($value);
if ($tplDef !== false) {
          $params = JComponentHelper::getParams('com_jotcache');
$debug = $params->get('showfname');
foreach ($tplDef as $key => $value) {
$split = explode('|', $value);
            $part = $document->getBuffer('modules', $key, '');
if ($mark && $part && $debug) {
$path = JPATH_CACHE . '/page/';
$partPath = $path . $fname . '_part_' . $key . '.php';
@file_put_contents($partPath, $part);
}          }        }}      $query = $database->getQuery(true);
$query->clear();
$query->select('COUNT(*)')
->from('#__jotcache')
->where('fname=' . $database->quote($fname));
$found = $database->setQuery($query)->loadResult();
$query->clear();
$now = date($database->getDateFormat());
$cookies = $this->_cache->options['cookies'];
$sessionvars = $this->_cache->options['sessionvars'];
$agent = $this->_agent ? '1' : '0';
$domain = '';
if ($this->params->get('domain', '0')) {
$uri2 = JUri::getInstance();
$domain = $uri2->toString(array('scheme', 'host', 'port'));
}if (!$found) {
$part = $database->quoteName('view');
$query->insert('#__jotcache')
->columns("fname,title,uri,browser,language,agent,com,$part,id,ftime,mark,qs,checked_out,cookies,sessionvars,domain")
->values("'$fname'," . $database->quote($title) . "," . $database->quote($uri) . ",'$browser','$language','$agent','$com','$view','$id','$now','$mark'," . $database->quote($qs) . ",''," . $database->quote($cookies, true) . "," . $database->quote($sessionvars, true). ",'$domain'");
        if (!$database->setQuery($query)->query()) {
JError::raiseNotice(100, $database->getErrorMsg());
}} else {
$query->update($database->quoteName('#__jotcache'))
->set($database->quoteName('title') . ' = ' . $database->quote($title))
->set($database->quoteName('ftime') . ' = ' . $database->quote($now))
->set($database->quoteName('mark') . ' = ' . $database->quote($mark))
->set($database->quoteName('agent') . ' = ' . $database->quote($agent))
->set($database->quoteName('qs') . ' = ' . $database->quote($qs))
->where($database->quoteName('fname') . ' = ' . $database->quote($fname));
if (!$database->setQuery($query)->query()) {
JError::raiseNotice(100, $database->getErrorMsg());
}}if ($this->_cache->options['browseron']) {
JResponse::allowCache(true);
JResponse::setHeader('Expires', gmdate('D, d M Y H:i:s', time() + $btime) . ' GMT');
}$data = JResponse::getBody();
if ($this->params->get('cachecompress')) {
$data = preg_replace('#\n\s+#', "\n", $data);
$data = preg_replace('/(?:(?<=\>)|(?<=\/\>))(\s+)(?=\<\/?)/', '', $data);
$data = preg_replace('#<!--[^>\[\]]*-->#', '', $data);
      }$this->_cache->store($data);
$data = preg_replace('/<jot .*? >/', '', $data);
$cookie_mark = JRequest::getVar('jotcachemark', '0', 'COOKIE', 'INT');
switch ($cookie_mark) {
case 1:
$data = preg_replace('#<title>(.*)<\/title>#', '<title>[CACHED] \\1</title>', $data);
break;
case 2:
$data = preg_replace('#<title>(.*)<\/title>#', '<title>[RENEW] \\1</title>', $data);
break;
default:
break;
}JResponse::setBody($data);
}}private function _exlude($view, $value) {
$divs = explode(',', $value);
if ($view != '' && array_search($view, $divs) !== false) {
return true;
}$query_array = JRequest::get();
foreach ($divs as $div) {
if (@strpos($div, '=') !== false) {
$parts = explode('=', $div);
if (array_key_exists($parts[0], $query_array) && $query_array[$parts[0]] == $parts[1]) {
return true;
}}}return false;
}function getBrowserTime($uri, $database) {
$query = $database->getQuery(true);
$query->select('value')
->from('#__jotcache_exclude')
->where($database->quoteName('type') . ' = 3');
$data = $database->setQuery($query, 0, 1)->loadResult();
$items = unserialize($data);
$btime = 0;
if (is_array($items)) {
foreach ($items as $key => $value) {           if (strtolower(substr($uri, 0, strlen($key))) == strtolower($key)) {
$btime = $value;
break;
}}}return 60 * $btime;
}private function _setCacheMark() {
if ($this->params->get('cachemark', false)) {
$cookie_mark = JRequest::getVar('jotcachemark', '0', 'COOKIE', 'INT');
if ($cookie_mark) {
$database = JFactory::getDBO();
$fname = $this->_cache->fname;
$query = $database->getQuery(true);
$query->update($database->quoteName('#__jotcache'))
->set('mark=1')
->where($database->quoteName('fname') . ' = ' . $database->quote($fname));
if (!$database->setQuery($query)->query()) {
JError::raiseNotice(100, $database->getErrorMsg());
}return true;
}return false;
}}public function autoclean() {
$vector = @file_get_contents($this->_cache->getRootDir() . '.autoclean');
$cleantime = @explode('|', $vector);
if (!(is_array($cleantime) && count($cleantime)) == 3) {
$cleantime = array(0, 0, '');
}$this->_clean = false;
if ($cleantime[0] > 0) {
if (time() > $cleantime[0]) {
require_once(dirname(__FILE__) . '/jotcache/autoclean.php');
$clean = new JotcacheClean();
jimport('joomla.filesystem.file');
$dir = $this->_cache->options['cachebase'] . DS . 'page' . DS;
if ($clean->setDir($dir)) {
$clean->setGradeId($this->params->get('cleanmode', 0));
$ret = array($cleantime[1], $cleantime[2]);
$ret = $clean->run($ret);
if ($this->params->get('cleanlog', 0)) {
$stat = $clean->getStat();
$msg1 = ($ret[0] > -1) ? "interrupted on : (" . $ret[0] . "|" . $ret[1] . ") " : "";
$line = $msg1 . "last deleted : " . $stat[1];
jimport('joomla.log.log');
JLog::addLogger(array('text_file' => "plg_jotcache.autoclean.log.php", 'text_entry_format' => "{DATE} {TIME}\t{MESSAGE}"), JLog::INFO, 'jotcache');
JLog::add($line, JLog::INFO, 'jotcache');
}$database = JFactory::getDBO();
$query = $database->getQuery(true);
$expired = time() - $this->params->get('cachetime', 15) * 60;
$db_expired = date("Y-m-d H:i:s", $expired);
$query->delete()
->from($database->quoteName('#__jotcache'))
->where("ftime < '$db_expired'");
if (!$database->setQuery($query)->query()) {
JError::raiseNotice(100, $database->getErrorMsg());
}if (is_array($ret)) {              $this->_clean = true;
$this->_paramsUpdate(false, $ret);
} else {
$this->_paramsUpdate(false, array(0, ''));
}}}} else {
$this->_paramsUpdate(true, array(0, ''));
}}private function _paramsUpdate($init, $ret) {
$ret_string = '|' . implode('|', $ret);
if ($this->_clean) {        $cleantime = '1' . $ret_string;
} else {          $delay = (int) $this->params->get('autoclean', 0) * 60;
$cleantime = (time() + $delay) . $ret_string;
}@file_put_contents($this->_cache->getRootDir() . '.autoclean', $cleantime);
}private function blockedUri() {
$uri = strtolower(urldecode($_SERVER['REQUEST_URI']));
$invalid = preg_match('#(mosConfig|https?|<\s*script|;|\<|\>|\"|[.][.]\/)#', $uri);
if ($invalid) {
return true;
} else {
$index_check = preg_match('#(\w*)\.php#', $uri, $matches);
if (count($matches) > 0 && $matches[1] != 'index') {
return true;
}}return false;
}}