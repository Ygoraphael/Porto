<?php
/*
 * @version $Id: reset.php,v 1.14 2013/09/25 07:35:30 Jot Exp $
 * @package JotCache
 * @category Joomla 2.5
 * @copyright (C) 2010-2014 Vladimir Kanich
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
class ResetController extends JotcacheController {
function ResetController() {
parent::JotcacheController();
$this->registerTask('close', 'display');
$this->registerTask('apply', 'save');
$this->registerTask('tplapply', 'tplsave');
$this->registerTask('bcapply', 'bcsave');
$this->assignViewModel('reset');
}function display($cachable = false, $urlparams = false) {
parent::display();
}function refresh() {
$this->model->refresh();
$this->model->removeExpired();
parent::display();
}function recache() {
$this->assignViewModel('recache');
$this->model->flagRecache();
parent::display();
}function mark() {
$cookie_mark = JRequest::getVar('jotcachemark', '0', 'COOKIE', 'INT');
$markid = JRequest::getInt('markid');
$line = "option=com_jotcache&view=reset";
$this->model->resetMark();
    switch ($markid) {
case 0:
setcookie('jotcachemark', '0', '0', '/');
$this->setRedirect('index.php?' . $line . "&filter_mark=", JText::_('JOTCACHE_RS_MSG_RESET'));
break;
case 1:
setcookie('jotcachemark', '1', '0', '/');
$this->setRedirect('index.php?' . $line, JText::_('JOTCACHE_RS_MSG_SET'));
break;
case 2:
setcookie('jotcachemark', '2', '0', '/');
$this->setRedirect('index.php?' . $line, JText::_('JOTCACHE_RS_MSG_RENEW'));
break;
default:
break;
}}function renew() {
$token = JRequest::getCmd('token', '');
if (strlen($token) == 32) {
$this->model->renew($token);
$url = $_SERVER['HTTP_REFERER'];
$this->setRedirect($url);
}}function delete() {
$this->model->delete();
$this->setRedirect('index.php?option=com_jotcache&view=reset', JText::_('JOTCACHE_RS_DEL'));
}function deleteall() {
$this->model->deleteall();
$this->setRedirect('index.php?option=com_jotcache&view=reset', JText::_('JOTCACHE_RS_DEL'));
}function exclude() {
$this->view->exclude();
}function tplex() {
$this->view->tplex();
}function bcache() {
$this->view->bcache();
}function debug() {
$this->view->debug();
}function getcachedfile() {
$fname_ext = JRequest::getCmd('fname');
if (JSession::checkToken('get') && strlen($fname_ext) == 36) {
$file_path = JPATH_CACHE . '/page/' . $fname_ext;
$this->model->transferFile($file_path);
} else {
$this->setRedirect('index.php?option=com_jotcache&view=reset&task=debug', JText::_('JINVALID_TOKEN'));
}}function save() {
$post = JRequest::get('post');
$cid = JRequest::getVar('cid', array(0), 'post', 'array');
JArrayHelper::toInteger($cid, array(0));
if ($this->model->store($post, $cid)) {
$msg = JText::_('JOTCACHE_EXCLUDE_SAVE');
}if ($this->getTask() == 'save') {
$this->setRedirect('index.php?option=com_jotcache&view=reset&task=refresh', $msg);
} else {
$this->setRedirect('index.php?option=com_jotcache&view=reset&task=exclude', $msg);
}}function tplsave() {
$post = JRequest::get('post');
$cids = JRequest::getVar('cid', array(0), 'post', 'array');
for ($i = 0; $i < count($cids); $i++) {
$cids[$i] = JFilterInput::clean($cids[$i], 'CMD');
}$tpl_id = $this->model->tplstore($post, $cids);
if ($tpl_id > 0) {
$msg = JText::_('JOTCACHE_TPLEX_SAVE');
}if ($this->getTask() == 'tplsave') {
$this->setRedirect('index.php?option=com_jotcache&view=reset&task=display&sel_id=' . $tpl_id, $msg);
} else {
$this->setRedirect('index.php?option=com_jotcache&view=reset&task=tplex&sel_id=' . $tpl_id, $msg);
}}function bcsave() {
$post = JRequest::get('post');
if ($this->model->bcstore($post)) {
$msg = JText::_('JOTCACHE_EXCLUDE_SAVE');
}if ($this->getTask() == 'bcsave') {
$this->setRedirect('index.php?option=com_jotcache&view=reset&task=display', $msg);
} else {
$this->setRedirect('index.php?option=com_jotcache&view=reset&task=bcache', $msg);
}}function bcdelete() {
if ($this->model->bcdelete()) {
$msg = JText::_('JOTCACHE_RS_DEL');
}$this->setRedirect('index.php?option=com_jotcache&view=reset&task=bcache', $msg);
}}?>