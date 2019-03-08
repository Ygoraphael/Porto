<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_users
 * @copyright	Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @since		1.6
 */

defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
?>
<!-- registo -->
<div style="width:100%;">
<?php if ($this->params->get('show_page_heading')) : ?>
	<h1><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
<?php endif; ?>

	<form style="padding:20px;" id="member-registration" action="<?php echo JRoute::_('index.php?option=com_users&task=registration.register'); ?>" method="post" class="formLogin" enctype="multipart/form-data">
		<?php foreach ($this->form->getFieldsets() as $fieldset): // Iterate through the form fieldsets and display each one.?>
			<?php $fields = $this->form->getFieldset($fieldset->name);?>
			<?php if (count($fields)):?>
				<fieldset>
					<?php if (isset($fieldset->label)):// If the fieldset has a label set, display it as the legend.
						?>
			<h5 style="text-align:center;"><?php echo JText::_($fieldset->label);?></h5>
		<?php endif;?>
			<dl>
				<div class="imgcontainer">
					<img src="http://www.fenixaerocarga.com.br/img/avatar.png" alt="Avatar" class="avatar">
				</div>
		<?php foreach($fields as $field):// Iterate through the fields in the set and display them.?>
			<?php if ($field->hidden):// If the field is hidden, just display the input.?>
				<?php echo $field->input;?>
			<?php else:?>
				<dt>
					<?php echo $field->label; ?>
					<?php if (!$field->required && $field->type!='Spacer'): ?>
						<span class="optional"><?php echo JText::_('COM_USERS_OPTIONAL'); ?></span>
					<?php endif; ?>
				</dt>
				<dd><?php echo ($field->type!='Spacer') ? $field->input : "&#160;"; ?></dd>
			<?php endif;?>
		<?php endforeach;?>
			</dl>
		</fieldset>
	<?php endif;?>
<?php endforeach;?>
		<div>
			<button type="submit" class="validate btn btn-primary btn-block no-border-radius" style="margin-bottom:10px;" style="background:#eb4800;"><?php echo JText::_('JREGISTER');?></button>
			<button type="submit" class="validate btn btn-primary btn-block no-border-radius">
				<a href="<?php echo JRoute::_('');?>" style="pointer-events:none; color:white;" style="background:#eb4800;"><?php echo JText::_('JCANCEL');?></a></button>
			<input type="hidden" name="option" value="com_users" />
			<input type="hidden" name="task" value="registration.register" />
			<?php echo JHtml::_('form.token');?>
		</div>
	</form>
</div>
<!-- /registo -->
