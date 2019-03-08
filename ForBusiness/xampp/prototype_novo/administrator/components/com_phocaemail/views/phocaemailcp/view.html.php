<?php
/*
 * @package		Joomla.Framework
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 *
 * @component Phoca Component
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License version 2 or later;
 */
defined( '_JEXEC' ) or die();
jimport( 'joomla.application.component.view' );

class PhocaEmailCpViewPhocaEmailCp extends JView
{
	//public function display($tpl = null) {
	function display($tpl = null) {
		$tmpl = array();
		JHtml::stylesheet( 'administrator/components/com_phocaemail/assets/phocaemail.css' );
		//JHTML::_('behavior.tooltip');
		$tmpl['version'] = PhocaEmailHelper::getPhocaVersion();
		
		$this->assignRef('tmpl',	$tmpl);
		$this->addToolbar();
		parent::display($tpl);
	}
	
	//protected function addToolbar() {
	function addToolbar() {
		require_once JPATH_COMPONENT.DS.'helpers'.DS.'phocaemailcp.php';

		$state	= $this->get('State');
		$canDo	= PhocaEmailCpHelper::getActions();
		JToolBarHelper::title( JText::_( 'COM_PHOCAEMAIL_PE_CONTROL_PANEL' ), 'pe.png' );
		
		if ($canDo->get('core.admin')) {
			JToolBarHelper::preferences('com_phocaemail', 460);
			JToolBarHelper::divider();
		}
		
		JToolBarHelper::help( 'screen.phocaemail', true );
	}
}
?>