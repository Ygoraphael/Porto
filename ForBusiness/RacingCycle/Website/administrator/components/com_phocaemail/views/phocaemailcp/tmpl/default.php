<?php defined('_JEXEC') or die('Restricted access');?>

<form action="index.php" method="post" name="adminForm">
<div class="adminform">
<div class="cpanel-left">
	<div id="cpanel">
		<?php
		$link = 'index.php?option=com_phocaemail&view=phocaemailwrite';
		echo PhocaEmailCpHelper::quickIconButton( $link, 'icon-48-pe-write.png', JText::_('COM_PHOCAEMAIL_WRITE') );
		
		$link = 'index.php?option=com_phocaemail&view=phocaemailinfo';
		echo PhocaEmailCpHelper::quickIconButton( $link, 'icon-48-pe-info.png', JText::_( 'COM_PHOCAEMAIL_INFO' ) );
		?>
				
		<div style="clear:both">&nbsp;</div>
		<p>&nbsp;</p>
		<div style="text-align:center;padding:0;margin:0;border:0;">
			<iframe style="padding:0;margin:0;border:0" src="http://www.phoca.cz/adv/phocaemail" noresize="noresize" frameborder="0" border="0" cellspacing="0" scrolling="no" width="500" marginwidth="0" marginheight="0" height="125">
			<a href="http://www.phoca.cz/adv/phocaemail" target="_blank">Phoca Email</a>
			</iframe>
		</div>
	</div>
</div>
		
<div class="cpanel-right">
	<div style="border:1px solid #ccc;background:#fff;margin:15px;padding:15px">
		<div style="float:right;margin:10px;">
			<?php echo JHTML::_('image', 'administrator/components/com_phocaemail/assets/images/icon-logo-seal.png', 'Phoca.cz' );?>
		</div>
			
		<?php
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
		
		
		echo '<p>&nbsp;</p>';

		echo '<div style="border-top:1px solid #c2c2c2"></div>'
.'<div id="pg-update"><a href="http://www.phoca.cz/version/index.php?phocaemail='.  $this->tmpl['version'] .'" target="_blank">'.  JText::_('COM_PHOCAEMAIL_CHECK_FOR_UPDATE') .'</a></div>';
		?>
		
	</div>
</div>

<div style="clear:both"></div>

</div>

<input type="hidden" name="option" value="com_phocaemail" />
<input type="hidden" name="view" value="phocaemailcp" />
<input type="hidden" name="<?php echo JUtility::getToken(); ?>" value="1" />
</form>