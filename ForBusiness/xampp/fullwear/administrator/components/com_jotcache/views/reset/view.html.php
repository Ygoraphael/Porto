<?php
/*
 * @version $Id: view.html.php,v 1.19 2014/06/07 12:15:07 Jot Exp $
 * @package JotCache
 * @category Joomla 2.5
 * @copyright (C) 2010-2014 Vladimir Kanich
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.view');
class ResetViewReset extends JView {
var $help_site = "http://kbase.jotcomponents.net/jotcache:help:direct42:";
function ResetViewReset() {
parent::__construct();
$document = JFactory::getDocument();
$document->addScript('components/com_jotcache/assets/jotcache.js');
$document->addStyleSheet('components/com_jotcache/assets/jotcache.css');
}function display($tpl = null) {
$app = JFactory::getApplication();
$data = $this->get('Data');
$lists = $this->get('Lists');
$status = $this->get('Status');
$marks = $this->get('Marks');
$model = $this->getModel();
$search = $app->getUserStateFromRequest('com_jotcache.search', 'search', '', 'string');
$search = JString::strtolower($search);
$lists['search'] = $search;
if ($search) {
$lists['reset'] = "<button onclick=\"jotcache.resetSelect(2);\">" . JText::_('Reset') . "</button>";
} else {
$lists['reset'] = "";
}$lists['order_Dir'] = $model->file_order_Dir;
$lists['order'] = $model->file_order;
$this->assignRef('data', $data);
$this->assignRef('lists', $lists);
$this->assignRef('status', $status);
$this->assignRef('marks', $marks);
parent::display($tpl);
}function exclude($tpl = null) {
$exlist = $this->get('ExList');
$this->assignRef('data', $exlist);
$this->setLayout("exclude");
parent::display();
}function tplex($tpl = null) {
$lists = $this->get('TplLists');
$this->assignRef('lists', $lists);
$this->setLayout("tplex");
parent::display();
}function bcache($tpl = null) {
$bcdata = $this->get('BcData');
$this->assignRef('data', $bcdata);
$this->setLayout("bcache");
parent::display();
}function debug($tpl = null) {
$page_data = $this->get('CachedContent');
$page_data->mode = JRequest::getWord('mode');
$fname_ext = JRequest::getCmd('fname') . '.php';
$this->assignRef('data', $page_data);
$this->assignRef('fname_ext', $fname_ext);
$this->setLayout("debug");
parent::display();
}}