<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php JHTML::_('behavior.tooltip'); ?>

<script language="javascript" type="text/javascript">
<?php
echo ''
.'Joomla.submitbutton = function(task) {'. "\n"
.' var form = document.adminForm;'. "\n"
.' if (task == \'phocaemailwrite.send\') {'. "\n"
.'  if (form.from.value == ""){'. "\n"
.'	 alert( "'. JText::_('COM_PHOCAEMAIL_ERROR_FIELD_FROM').'" );'. "\n"
.'	} else if (form.fromname.value == ""){'. "\n"
.'	 alert( "'. JText::_('COM_PHOCAEMAIL_ERROR_FIELD_FROMNAME').'" );'. "\n"
.'	} ' . "\n";
if ($this->param['display_users_list'] == 0) {
	echo '      else if (form.to.value == ""){'. "\n"
.'	 alert( "'. JText::_('COM_PHOCAEMAIL_ERROR_FIELD_TO').'" );'. "\n"
.'	}' . "\n";
} else {
	echo '      else if (form.tousers.value == "" && form.to.value == "") { ' . "\n"
.'	 alert( "'. JText::_('COM_PHOCAEMAIL_ERROR_FIELD_TO_USERS_EMPTY').'" );'. "\n"
.'  }' . "\n";
}
echo ' else if (form.subject.value == ""){'. "\n"
.'   alert( "'. JText::_('COM_PHOCAEMAIL_ERROR_FIELD_SUBJECT').'" );'. "\n"
.'	} else {'. "\n"
.'	 Joomla.submitform(task);'. "\n"
.'   document.getElementById(\'sending-email\').style.display=\'block\';'. "\n"
.'	}'. "\n"
.' } else {'. "\n"
.'   Joomla.submitform(task);'. "\n"
//.'      document.getElementById(\'sending-email\').style.display=\'block\';'. "\n"
.' }'. "\n"
.'}'. "\n"
?>
</script>

<form action="index.php?option=com_phocaemail&view=phocaemailwrite" method="post" name="adminForm" id="adminForm">
<table border="0">
<tr>	
	<td align="right"><label for="title"><?php echo JText::_('COM_PHOCAEMAIL_FIELD_FROMNAME'); ?>:</label></td>
	<td><input class="inputbox" type="text" name="fromname" id="fromname" style="width:300px" maxlength="100" value="<?php echo $this->r['fromname']; ?>" /></td>
</tr>
	
<tr>	
	<td align="right"><label for="title"><?php echo JText::_('COM_PHOCAEMAIL_FIELD_FROM'); ?>:</label></td>
	<td><input class="inputbox" type="text" name="from" id="from" style="width:300px" maxlength="100" value="<?php echo $this->r['from']; ?>" /></td>
</tr>
	
<tr>	
	<td align="right"><label for="title"><?php echo JText::_('COM_PHOCAEMAIL_FIELD_TO'); ?>:</label></td>
	<td><input class="inputbox" type="text" name="to" id="to" style="width:300px" maxlength="250" value="<?php echo $this->r['to']; ?>" /></td>
</tr>

<?php if ($this->param['display_users_list'] == 1) { ?>
<tr>	
	<td align="right"><label for="title"><?php echo JText::_('COM_PHOCAEMAIL_FIELD_TO_USERS'); ?>:</label></td>
	<td><?php echo $this->tmpl['userlist']; ?></td>
</tr>
<?php } ?>

<?php if ($this->param['display_groups_list'] == 1) { ?>
<tr>	
	<td align="right"><label for="title"><?php echo JText::_('COM_PHOCAEMAIL_FIELD_TO_GROUPS'); ?>:</label></td>
	<td><?php echo $this->tmpl['grouplist']; ?></td>
</tr>
<?php } ?>

<tr>	
	<td align="right"><label for="title"><?php echo JText::_('COM_PHOCAEMAIL_FIELD_CC'); ?>:</label></td>
	<td><input class="inputbox" type="text" name="cc" id="cc" style="width:300px" maxlength="250" value="<?php echo $this->r['cc']; ?>" /></td>
</tr>

<?php if ($this->param['display_users_list_cc'] == 1) { ?>
<tr>	
	<td align="right"><label for="title"><?php echo JText::_('COM_PHOCAEMAIL_FIELD_CC_USERS'); ?>:</label></td>
	<td><?php echo $this->tmpl['ccuserlist']; ?></td>
</tr>
<?php } ?>

<tr>	
	<td align="right"><label for="title"><?php echo JText::_('COM_PHOCAEMAIL_FIELD_BCC'); ?>:</label></td>
	<td><input class="inputbox" type="text" name="bcc" id="bcc" style="width:300px" maxlength="250" value="<?php echo $this->r['bcc']; ?>" /></td>
</tr>

<?php if ($this->param['display_users_list_bcc'] == 1) { ?>
<tr>	
	<td align="right"><label for="title"><?php echo JText::_('COM_PHOCAEMAIL_FIELD_BCC_USERS'); ?>:</label></td>
	<td><?php echo $this->tmpl['bccuserlist']; ?></td>
</tr>
<?php } ?>
	
<tr>	
	<td align="right"><label for="title"><?php echo JText::_('COM_PHOCAEMAIL_FIELD_SUBJECT'); ?>:</label></td>
	<td><input class="inputbox" type="text" name="subject" id="subject" style="width:650px" maxlength="250" value="<?php echo $this->r['subject']; ?>" /></td>
</tr>

<?php if ($this->param['display_select_article'] == 1) { ?>
<tr>
	<td align="right"><label for="title"><?php echo JText::_('COM_PHOCAEMAIL_FIELD_ARTICLE_ID'); ?>:</label></td>
	<td>
	<div style="float: left;"><input style="background: none repeat scroll 0% 0% rgb(255, 255, 255);" id="article_name" value="<?php echo $this->r['article_name']; ?>" disabled="disabled" type="text" size="40" /></div> 
	
	<?php
	// Build the script.
	$script = array();
	$script[] = '	function jSelectArticle_article(id, title, catid, object) {';
	$script[] = '		document.id("article_id").value = id;';
	$script[] = '		document.id("article_name").value = title;';
	$script[] = '		SqueezeBox.close();';
	$script[] = '	}';

	// Add the script to the document head.
	JFactory::getDocument()->addScriptDeclaration(implode("\n", $script));
	
	$link = 'index.php?option=com_content&amp;view=articles&amp;layout=modal&amp;tmpl=component&amp;function=jSelectArticle_article';
	?>
	
	<div class="button2-left" style="margin-left: 10px;"><div class="blank"><a class="modal-button" title="<?php echo JText::_('COM_PHOCAEMAIL_SELECT_ARTICLE'); ?>" href="<?php echo $link; ?>" rel="{handler: 'iframe', size: {x: 650, y: 375}}"><?php echo JText::_('COM_PHOCAEMAIL_SELECT'); ?></a></div></div>
	
	<input type="hidden" id="article_id" name="article_id" value="<?php echo $this->r['article_id']; ?>" />
	<?php /*<input type="hidden" id="article_name" name="article_name" value="<?php echo $this->r['article_name']; ?>" />*/ ?>
	</td>
</tr>
<?php } ?>
	
	
<tr>	
	<td align="right" valign="top"><label for="title"><?php echo JText::_('COM_PHOCAEMAIL_FIELD_MESSAGE');  ?>:</label></td><td>
	<?php // parameters : areaname, content, width, height, cols, rows, show xtd buttons
	echo $this->tmpl['editor']->display( 'message',  $this->r['message'], '648', '350', '80', '50', array('pagebreak', 'readmore', 'image') ) ;
	?></td>
</tr>

<tr>	
	<td align="right" valign="top"><label for="title"><?php echo JText::_('COM_PHOCAEMAIL_FIELD_ATTACHMENT');  ?>:</label></td>
	<?php
	if (!empty($this->tmpl['attachment'])) {
		echo '<td>';
		foreach ($this->tmpl['attachment'] as $key => $value) {
			
			echo '<input type="checkbox" '.$this->tmpl['attachment'][$key]['checked'].' name="attachment['.$key.']" id="attachment-'.$key.'" >';
			echo '<input type="hidden" name="attachmentfile['.$key.']" id="attachmentfile-'.$key.'" value="'.$this->tmpl['attachment'][$key]['file'].'" >';
			$attIco = 'icon-16-attachment.png';
			if (isset($this->tmpl['attachment'][$key]['pdf']) && $this->tmpl['attachment'][$key]['pdf'] == 1) {
				$attIco = 'icon-16-pdf.png';
			}
			echo JHtml::_('image', 'administrator/components/com_phocaemail/assets/images/'.$attIco, '')
			. ' ' .$this->tmpl['attachment'][$key]['file'] . '<br />';
		}
		echo '</td>';
	}
	?>
</tr>
<?php /*
	<td><input type="checkbox" name="attachment[0]" id="attachment[0]" <?php echo $attachmentInvoiceChecked ;?> ><img src="<?php echo $mosConfig_live_site ?>/images/M_images/pdf_button.png" border="0" /><?php echo $attachmentInvoice; ?><br />
				<?php
			} else { // only invoice or receipt - not both - RECEIPT
				?><input type="checkbox" name="attachment[1]" id="attachment[1]" <?php echo  $attachmentReceiptChecked ;?> ><img src="<?php echo $mosConfig_live_site ?>/images/M_images/pdf_button.png" border="0" /><?php echo $attachmentReceipt; ?><br />
				<?php
			} ?>
			<input type="checkbox" name="attachment[2]" id="attachment[2]" <?php echo $attachmentDeliveryNoteChecked ;?> ><img src="<?php echo $mosConfig_live_site ?>/images/M_images/pdf_button.png" border="0" /><?php echo $attachmentDeliveryNote; ?><br />
		</td>
	</tr> */ ?>
	
<tr>	
	<td align="right" valign="top" colspan="2"><input type="submit" class="phocabutton" value="<?php echo JText::_('COM_PHOCAEMAIL_SEND')  ?>" onclick="javascript: Joomla.submitbutton('phocaemailwrite.send');return false;" /></td>
</tr>
						
</table>

<?php 
if ($this->r['ext'] == 'virtuemart') {
	echo '<input type="hidden" name="order_id" value="'.$this->r['order_id'].'" />'. "\n";
	echo '<input type="hidden" name="delivery_id" value="'.$this->r['delivery_id'].'" />' . "\n";
	echo '<input type="hidden" name="type" value="'.$this->r['type'].'" />' . "\n";
	echo '<input type="hidden" name="ext" value="'.$this->r['ext'].'" />' . "\n";
}
/*
<input type="hidden" name="order_id" value="<?php echo $order_id ?>" />
<input type="hidden" name="delivery_id" value="<?php echo $delivery_id ?>" />
<input type="hidden" name="gen" value="<?php echo $gen ?>" />
<input type="hidden" name="vmtoken" value="<?php echo vmSpoofValue($sess->getSessionId()) ?>" />
<input type="hidden" name="receiptChecked" value="<?php echo $attachmentReceipt ?>" />
<input type="hidden" name="invoiceChecked" value="<?php echo $attachmentInvoice ?>" />
<input type="hidden" name="deliveryNoteChecked" value="<?php echo $attachmentDeliveryNote ?>" />*/ 
?>

<input type="hidden" name="task" value="" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>

<div id="sending-email"><div class="loading"><center><?php echo JHTML::_('image', 'administrator/components/com_phocaemail/assets/images/icon-sending.gif', '' ) . ' &nbsp; &nbsp; '. JText::_('COM_PHOCAEMAIL_SENDING_MESSAGE'); ?></center></div></div>