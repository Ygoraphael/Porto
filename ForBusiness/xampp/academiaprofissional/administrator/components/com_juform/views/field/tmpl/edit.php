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

JHtml::_('behavior.tooltip');
JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidator');
JHtml::_('formbehavior.chosen', 'select');

$editor  = JFactory::getConfig()->get('editor', 'tinymce');
$JEditor = JEditor::getInstance($editor);
?>

<script type="text/javascript">
	Joomla.submitbutton = function (task) {
		if (task == 'field.cancel' || (document.formvalidator.isValid(document.getElementById("adminForm")) && (jQuery('#jform_predefined_values_type').val() != 2 || jQuery('#jform_php_predefined_values').data('validPhp')))) {
			<?php
			$fieldSets = $this->form->getFieldSets();
			if ($fieldSets)
			{
				foreach ($fieldSets AS $fieldSet)
				{
					$fields = $this->form->getFieldSet($fieldSet->name);
					if ($fields)
					{
						foreach ($fields AS $field)
						{
							if (strtolower($field->type) == 'editor')
							{
								echo $field->save() . "\n";
							}
						}
					}
				}
			}
			?>

			if (document.getElementById('jform_php_predefined_values')) {
				<?php echo JEditor::getInstance('codemirror')->save('jform_php_predefined_values'); ?>
			}

			if (typeof tinyMCE !== 'undefined') {
				tinyMCE.triggerSave();
			}

			saveField();
		}
		else {
			
			testPhpCode(true, task);
		}
	};

	function saveField() {
		$ = jQuery.noConflict();
		var form = $('#adminForm');
		var url = form.attr('action');
		var data = form.serialize();
		$.ajax({
				url: url,
				data: data,
				type: 'POST',
				dataType: 'json',
				beforeSend: function () {
					window.parent.showSpinner();
				}
			})
			.done(function (data) {
				window.parent.hideSpinner();
				if (data.success == 1) {
					window.parent.addField(data.field);
					updateCustomMessage();
					window.parent.jQuery.fancybox.close();
				} else {
					var error = '<div id="system-message" class="alert alert-error">' + data.message + '</div>';
					$('#system-message-container').html(error);
					$('html,body').animate({
							scrollTop: $("#system-message-container").offset().top
						},
						'slow');
				}
			});
	}

	
	function updateCustomMessage() {
		var old_field_name = jQuery('#jform_field_name').data('old_field_name');
		var new_field_name = jQuery('#jform_field_name').val();

		if (new_field_name !== old_field_name) {
			var content = window.parent.<?php echo $JEditor->getContent('custom_message'); ?>
				content = content.replace('{' + old_field_name + '}', '{' + new_field_name + '}');
			<?php
			
			if ($editor == 'codemirror')
			{
				echo 'window.parent.' . str_replace('"content"', 'content', $JEditor->setContent('custom_message', 'content'));
			}
			else
			{
				echo 'window.parent.' . $JEditor->setContent('custom_message', 'content');
			}
			?>
		}
	}

	jQuery(document).ready(function ($) {
		$('.form-cancel').click(function () {
			window.parent.jQuery.fancybox.close();
		});

		
		var old_field_name = $('#jform_field_name').val();
		$('#jform_field_name').data('old_field_name', old_field_name);

		<?php
		if(!$this->item->id)
		{ ?>
		$('#jform_field_name').on('change', function () {
			$(this).data('user_defined', true);
		});

		$('#jform_caption').on('change keyup', function () {
			if ($('#jform_field_name').data('user_defined')) {
				return false;
			}

			
			var field_name = $(this).val().replace(/[^0-9a-z_]+/gi, '_');
			
			field_name = field_name.replace(/^_+|_+$/g, '');
			
			field_name = field_name.toLowerCase();
			$('#jform_field_name').val(field_name);
		});
		<?php
		} ?>
	});
</script>

<style type="text/css">
	body.component {
		background: transparent;
		padding: 10px;
	}
</style>

<form action="<?php echo JRoute::_('index.php?option=com_juform&layout=edit&id=' . (int) $this->item->id); ?>"
      method="post" name="adminForm" id="adminForm" class="form-validate">
	<div class="form-horizontal">
		<?php echo JHtml::_('bootstrap.startTabSet', 'field-' . (int) $this->item->id, array('active' => 'general')); ?>
		<?php echo JHtml::_('bootstrap.addTab', 'field-' . (int) $this->item->id, 'general', JText::_('COM_JUFORM_GENERAL_TAB')); ?>
		<?php
		$fields = $this->form->getFieldSet('general');
		if ($fields)
		{
			foreach ($fields AS $field)
			{
				echo $field->getControlGroup();
			}
		}
		?>
		<?php echo JHtml::_('bootstrap.endTab'); ?>

		<?php
		$fieldClass = JUFormFrontHelperField::getField($this->item);
		if ($fieldClass && $fieldClass->getPredefinedValuesHtml() !== null)
		{
			?>
			<?php echo JHtml::_('bootstrap.addTab', 'field-' . (int) $this->item->id, 'predefinedvalue', JText::_('COM_JUFORM_PREDEFINED_VALUE_TAB')); ?>
			<?php
			$fields = $this->form->getFieldSet('predefinedvalue');
			if ($fields)
			{
				foreach ($fields AS $field)
				{
					echo $field->getControlGroup();
				}
			}
			?>
			<?php echo JHtml::_('bootstrap.endTab'); ?>
			<?php
		}
		?>

		<?php
		$fieldSets = $this->form->getFieldSets('params');
		if ($fieldSets)
		{
			foreach ($fieldSets AS $fieldSet)
			{
				$label  = $fieldSet->label ? JText::_($fieldSet->label) : JText::_($fieldSet->name);
				$fields = $this->form->getFieldSet($fieldSet->name);
				if ($fields)
				{
					?>
					<?php echo JHtml::_('bootstrap.addTab', 'field-' . (int) $this->item->id, $fieldSet->name, $label); ?>
					<?php
					foreach ($fields AS $field)
					{
						echo $field->getControlGroup();
					}
					?>
					<?php echo JHtml::_('bootstrap.endTab'); ?>
					<?php
				}
			}
		}
		?>

		<?php echo JHtml::_('bootstrap.addTab', 'field-' . (int) $this->item->id, 'advanced', JText::_('COM_JUFORM_ADVANCED_TAB')); ?>
		<?php
		$fields = $this->form->getFieldSet('advanced');
		if ($fields)
		{
			foreach ($fields AS $field)
			{
				echo $field->getControlGroup();
			}
		}
		?>
		<?php echo JHtml::_('bootstrap.endTab'); ?>

		<?php echo JHtml::_('bootstrap.endTabSet'); ?>

		<button type="button" class="btn btn-primary form-submit"
		        onclick="Joomla.submitbutton('field.apply')"><?php echo JText::_('COM_JUFORM_SUBMIT'); ?></button>
		<button type="button" class="btn form-cancel"><?php echo JText::_('COM_JUFORM_CANCEL'); ?></button>
	</div>

	<div>
		<input type="hidden" name="task" value="field.save"/>
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>