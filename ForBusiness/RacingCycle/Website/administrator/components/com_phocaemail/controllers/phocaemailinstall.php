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

class PhocaEmailCpControllerPhocaEmailInstall extends PhocaEmailCpController
{
	function __construct() {
		parent::__construct();
		$this->registerTask( 'install'  , 'install' );
		$this->registerTask( 'upgrade'  , 'upgrade' );		
	}

	function install() {		
		
		$msg = JText::_( 'COM_PHOCAEMAIL_SUCCESS_INSTALL' );
		$link = 'index.php?option=com_phocaemail';
		$this->setRedirect($link, $msg);
	}

	function upgrade() {
		$msg = JText::_( 'COM_PHOCAEMAIL_SUCCESS_UPGRADE' );
		$link = 'index.php?option=com_phocaemail';
		$this->setRedirect($link, $msg);
	}
	
}
// utf-8 test: ä,ö,ü,ř,ž
?>