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
jimport('joomla.application.component.controller');

$l['cp']	= 'COM_PHOCAEMAIL_CONTROL_PANEL';
$l['w']		= 'COM_PHOCAEMAIL_WRITE';
$l['in']	= 'COM_PHOCAEMAIL_INFO';

$view	= JRequest::getVar( 'view', '', '', 'string', JREQUEST_ALLOWRAW );
if ($view == '' || $view == 'phocaemailcp') {
	JSubMenuHelper::addEntry(JText::_($l['cp']), 'index.php?option=com_phocaemail', true);
	JSubMenuHelper::addEntry(JText::_($l['w']), 'index.php?option=com_phocaemail&view=phocaemailwrite');
	JSubMenuHelper::addEntry(JText::_($l['in']), 'index.php?option=com_phocaemail&view=phocaemailinfo' );
}

else if ($view == 'phocaemailwrite') {
	JSubMenuHelper::addEntry(JText::_($l['cp']), 'index.php?option=com_phocaemail');
	JSubMenuHelper::addEntry(JText::_($l['w']), 'index.php?option=com_phocaemail&view=phocaemailwrite', true);
	JSubMenuHelper::addEntry(JText::_($l['in']), 'index.php?option=com_phocaemail&view=phocaemailinfo' );
}

else if ($view == 'phocaemailinfo') {
	JSubMenuHelper::addEntry(JText::_($l['cp']), 'index.php?option=com_phocaemail');
	JSubMenuHelper::addEntry(JText::_($l['w']), 'index.php?option=com_phocaemail&view=phocaemailwrite');
	JSubMenuHelper::addEntry(JText::_($l['in']), 'index.php?option=com_phocaemail&view=phocaemailinfo', true );
}

class PhocaEmailCpController extends JController {
	function display() {
		parent::display();
	}
}
?>
