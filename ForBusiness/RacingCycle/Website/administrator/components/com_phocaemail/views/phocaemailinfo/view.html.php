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
defined('_JEXEC') or die();
jimport( 'joomla.application.component.view' );


class PhocaEmailCpViewPhocaEmailInfo extends JView
{
	public function display($tpl = null) {
		
		$tmpl			= array();
		$params 		= JComponentHelper::getParams('com_phocaemail');
		$tmpl['version'] = PhocaEmailHelper::getPhocaVersion();
		
		JHtml::stylesheet( 'administrator/components/com_phocaemail/assets/phocaemail.css' );

		$this->assignRef('tmpl',	$tmpl);
		
		$this->addToolbar();
		parent::display($tpl);
	}
	
	protected function addToolbar() {
		JToolBarHelper::title( JText::_( 'COM_PHOCAEMAIL_PE_INFO' ), 'info.png' );
		JToolBarHelper::cancel( 'cancel', 'COM_PHOCAEMAIL_CLOSE' );
		JToolBarHelper::divider();
		JToolBarHelper::help( 'screen.phocaemail', true );
	}
}
?>
