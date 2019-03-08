<?php
/*
 * @version $Id: view.html.php,v 1.10 2014/06/07 12:15:07 Jot Exp $
 * @package JotCache
 * @category Joomla 2.5
 * @copyright (C) 2010-2014 Vladimir Kanich
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.view');
class RecacheViewRecache extends JView {
var $help_site = "http://kbase.jotcomponents.net/jotcache:help:direct42:";
function display($tpl = null) {
    $document = JFactory::getDocument();
$document->addScript('components/com_jotcache/assets/jotcache.js');
$document->addStyleSheet('components/com_jotcache/assets/jotcache.css');
$plugins = $this->get('Plugins');
$filter = array();
$cid = JRequest::getVar('cid', null, '', 'array');
$filter['chck'] = (isset($cid)) ? true : false;
$filter['search'] = JRequest::getString('search', '');
$filter['com'] = JRequest::getString('filter_com', '');
$filter['view'] = JRequest::getString('filter_view', '');
$filter['mark'] = (JRequest::getString('filter_mark', '')) ? 'Yes' : '';
$this->assignRef('filter', $filter);
$this->assignRef('plugins', $plugins);
parent::display($tpl);
}function stopRecache() {
$this->setLayout("stop");
parent::display();
}}