<?php
defined('_JEXEC') or die;
JHTML::_('behavior.tooltip');
echo '<div class="phoca-adminform">'
	.'<form action="index.php" method="post" name="adminForm">'
	.'<div style="float:right;margin:10px;">'
	. JHTML::_('image', 'administrator/components/com_phocaemail/assets/images/icon-logo-seal.png', 'Phoca.cz' )
	.'</div>'
	. JHTML::_('image', 'administrator/components/com_phocaemail/assets/images/logo.png', 'Phoca.cz')
	.'<h3>'.JText::_('COM_PHOCAEMAIL_PHOCA_EMAIL').' - '. JText::_('COM_PHOCAEMAIL_INFORMATION').'</h3>';

echo '<h3>'.  JText::_('COM_PHOCAEMAIL_HELP').'</h3>';

echo '<p>'
.'<a href="http://www.phoca.cz/phocaemail/" target="_blank">Phoca Email Main Site</a><br />'
.'<a href="http://www.phoca.cz/documentation/" target="_blank">Phoca Email User Manual</a><br />'
.'<a href="http://www.phoca.cz/forum/" target="_blank">Phoca Email Forum</a><br />'
.'</p>';

echo '<h3>'.  JText::_('COM_PHOCAEMAIL_VERSION').'</h3>'
.'<p>'.  $this->tmpl['version'] .'</p>';

echo '<h3>'.  JText::_('COM_PHOCAEMAIL_COPYRIGHT').'</h3>'
.'<p>© 2007 - '.  date("Y"). ' Jan Pavelka</p>'
.'<p><a href="http://www.phoca.cz/" target="_blank">www.phoca.cz</a></p>';

echo '<h3>'.  JText::_('COM_PHOCAEMAIL_LICENSE').'</h3>'
.'<p><a href="http://www.gnu.org/licenses/gpl-2.0.html" target="_blank">GPLv2</a></p>';

echo '<h3>'.  JText::_('COM_PHOCAEMAIL_TRANSLATION').': '. JText::_('COM_PHOCAEMAIL_TRANSLATION_LANGUAGE_TAG').'</h3>'
        .'<p>© 2007 - '.  date("Y"). ' '. JText::_('COM_PHOCAEMAIL_TRANSLATER'). '</p>'
        .'<p>'.JText::_('COM_PHOCAEMAIL_TRANSLATION_SUPPORT_URL').'</p>';

echo '<input type="hidden" name="task" value="" />'
.'<input type="hidden" name="option" value="com_phocaemail" />'
.'<input type="hidden" name="controller" value="phocaemailinfo" />'
.'</form>';

echo '<p>&nbsp;</p>';

echo '<div style="border-top:1px solid #eee"></div>'
.'<div id="pg-update"><a href="http://www.phoca.cz/version/index.php?phocaemail='.  $this->tmpl['version'] .'" target="_blank">'.  JText::_('COM_PHOCAEMAIL_CHECK_FOR_UPDATE') .'</a></div>';

echo '<div style="margin-top:30px;height:39px;background: url(\''.JURI::base(true).'/components/com_phocaemail/assets/images/line.png\') 100% 0 no-repeat;">&nbsp;</div>';

echo '</div>';