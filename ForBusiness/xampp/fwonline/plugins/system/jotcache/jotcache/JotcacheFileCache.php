<?php
/*
 * @version $Id: JotcacheFileCache.php,v 1.6 2014/06/07 12:15:10 Jot Exp $
 * @package JotCache
 * @category Joomla 2.5
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license	GNU General Public License version 2
 */
defined('JPATH_BASE') or die;
require_once JPATH_ROOT . '/libraries/joomla/cache/controller.php';
class JotcacheFileCache extends JCacheController {
public $fname;
private $_id;
private $_application;
private $_hash;
private $_language;
private $_root;
private $_now;
private $_lifetime;
private $_group;
private $_locking;
public function __construct($options = array()) {
parent::__construct($options);
$config = JFactory::getConfig();
$this->_root = $this->cache->_options['cachebase'];
$this->_language = $this->cache->_options['language'];
$this->_hash = $config->get('secret');
$this->_group = $options['defaultgroup'];
$this->_locking = (isset($options['locking'])) ? $options['locking'] : true;
$this->_lifetime = (isset($options['lifetime'])) ? $options['lifetime'] : null;
$this->_now = (isset($options['now'])) ? $options['now'] : time();
if (empty($this->_lifetime)) {
$this->_lifetime = 60;
}$this->_id = md5($options['uri'].'-'.$options['browser'].$options['cookies'].$options['sessionvars']);
    $this->fname = md5($this->_application.'-'.$this->_id.'-'.$this->_hash.'-'.$this->_language);
}public function get($id=null, $group = null) {
$data = false;
$path = $this->_getFilePath();
$this->_setExpire($path);
if (file_exists($path)) {
$data = file_get_contents($path);
if ($data) {
$data = preg_replace('/^.*\n/', '', $data);
}}return $data;
}public function store($data, $id=null, $group = null) {
    if ($data) {
$written = false;
$path = $this->_getFilePath();
$expirePath = $path.'_expire';
$die = '<?php die("Access Denied"); ?>'."\n";
$data = $die.$data;
$fp = @fopen($path, "wb");
if ($fp) {
if ($this->_locking) {
@flock($fp, LOCK_EX);
}$len = strlen($data);
@fwrite($fp, $data, $len);
if ($this->_locking) {
@flock($fp, LOCK_UN);
}@fclose($fp);
$written = true;
} if ($written && ($data == file_get_contents($path))) {
@file_put_contents($expirePath, ($this->_now + $this->_lifetime));
return true;
} else {
return false;
}}return false;
}private function _getFilePath() {
$folder = $this->_group;
$dir = $this->_root.DS.$folder;
if (!is_dir($dir)) {
$indexFile = $dir.DS.'index.html';
@ mkdir($dir) && file_put_contents($indexFile, '<html><body bgcolor="#FFFFFF"></body></html>');
} if (!is_dir($dir)) {
return false;
}return $dir.DS.$this->fname.'.php';
}private function _setExpire($path) {
if (file_exists($path.'_expire')) {
$time = @file_get_contents($path.'_expire');
if ($time < $this->_now || empty($time)) {
$this->remove($path);
}} elseif (file_exists($path)) {
$this->remove($path);
}}public function remove($path) {
@unlink($path.'_expire');
if (!@unlink($path)) {
return false;
}return true;
}public function getRootDir(){
return $this->_root.DS.$this->_group.DS;
}}