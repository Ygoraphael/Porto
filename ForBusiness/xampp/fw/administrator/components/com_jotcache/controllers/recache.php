<?php
/*
 * @version $Id: recache.php,v 1.8 2013/09/04 17:06:47 Jot Exp $
 * @package JotCache
 * @category Joomla 2.5
 * @copyright (C) 2010-2014 Vladimir Kanich
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
defined('_JEXEC') or die;
class RecacheController extends JotcacheController {
function RecacheController() {
parent::JotcacheController();
    $this->assignViewModel('recache');
}function display($cachable = false, $urlparams = false) {
parent::display();
}function recache() {
$this->model->flagRecache();
parent::display();
}function close() {
$this->setRedirect('index.php?option=com_jotcache&view=reset&task=display');
}function start() {
JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
$this->model->runRecache();
$this->model->controlRecache(0);
$this->view->stopRecache();
}function stop() {
$this->model->controlRecache(0);
}function status() {
$flag = JRequest::getWord('flag', '');
if ($flag == 'stop') {
$this->model->controlRecache(0);
} else {
$plugin = strtolower(JRequest::getWord('plugin'));
include JPATH_PLUGINS . '/jotcacheplugins/' . $plugin . '/' . $plugin . '_status.php';
}}}?>