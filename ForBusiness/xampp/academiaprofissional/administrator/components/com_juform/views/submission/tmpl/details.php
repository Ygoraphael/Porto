<?php
/**
 * ------------------------------------------------------------------------
 * JUForm for Joomla 3.x
 * ------------------------------------------------------------------------
 *
 * @copyright      Copyright (C) 2010-2016 JoomUltra Co., Ltd. All Rights Reserved.
 * @license        GNU General Public License version 2 or later; see LICENSE.txt
 * @author         JoomUltra Co., Ltd
 * @website        http://www.joomultra.com
 * @----------------------------------------------------------------------@
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

$app      = JFactory::getApplication();
if ($app->input->get('layout') == 'details')
{
	$document = JFactory::getDocument();
	$style = 'body {
		background: transparent;
	}';
	$document->addStyleDeclaration($style);
}
?>
<div id="iframe-help"></div>

<div id="jufm-container" class="jubootstrap detail-form form-horizontal">
	<?php
		foreach($this->fields AS $field)
		{
			if ($field->canView())
			{
				echo '<div class="control-group field-group">';
				echo $field->getLabel(false, true);
				echo '<div class="controls">';
				echo $field->getDisplayPrefixText();
				echo $field->getOutput();
				echo $field->getDisplaySuffixText();
				echo '</div>';
				echo '</div>';
			}
		}
	?>
	<fieldset>
		<legend><?php echo JText::_('COM_JUFORM_INFORMATION'); ?></legend>
		<div class="span6">
			<label><strong><?php echo JText::_('COM_JUFORM_CREATED'); ?>:</strong> <?php echo JHtml::_('date', $this->item->created, 'd F Y H:i:s'); ?></label>
			<label><strong><?php echo JText::_('COM_JUFORM_CREATED_BY'); ?>:</strong>
				<?php
					if($this->item->user_id)
					{
						$user = JFactory::getUser($this->item->user_id);
						if($user)
						{
							echo $user->name . ' <span class="small break-word">(' . $user->email . ')</span>';
						}
					}
					else
					{
						echo JText::_('COM_JUFORM_GUEST');
					}
				?>
			</label>
		</div>

		<div class="span6">
			<label><strong><?php echo JText::_('COM_JUFORM_BROWSER'); ?>:</strong> <?php echo $this->item->browser; ?></label>
			<label><strong><?php echo JText::_('COM_JUFORM_PLATFORM'); ?>:</strong> <?php echo $this->item->platform; ?></label>
			<label><strong><?php echo JText::_('COM_JUFORM_IP_ADDRESS'); ?>:</strong> <a href="http://whois.domaintools.com/<?php echo $this->item->ip_address; ?>" target="_blank"><?php echo $this->item->ip_address; ?></a></label>
		</div>
	</fieldset>
</div>
