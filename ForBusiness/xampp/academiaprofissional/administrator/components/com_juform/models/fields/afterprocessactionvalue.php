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

class JFormFieldAfterProcessActionValue extends JFormField
{
	public $type = 'afterprocessactionvalue';

	public function getInput()
	{
		$document = JFactory::getDocument();
		$script   = "
			jQuery(document).ready(function($){
				$('#select-menu-item').fancybox();

				var parent = $('#afterprocess-action-value').closest('.control-group');
				$('#afterprocess-action-value > div').hide();
				$('#jform_afterprocess_action').change(function(){
					var value = $(this).val();
					$('#afterprocess-action-value > div').hide();
					$('#'+value+'_wrap').show().find('input[type=\"checkbox\"].show_message').trigger('change');
				});

				$('input[type=\"checkbox\"].show_message').change(function(){
					var checked = $(this).is(':checked');
					if(checked)
					{
						$('#custom_message_wrap').show();
					} else {
						$('#custom_message_wrap').hide();
					}
				});

				$('#jform_afterprocess_action').trigger('change');

				jSelectMenuItem = function(id, title){
					if($('#redirect_menu_id').val() != id){
						$('#redirect_menu_id').val(id);
						$('#redirect_menu_title').val(title);
					}

					$.fancybox.close();
				}

				$('.select-field').popover({
					html : true,
					placement : 'bottom',
				    content : function() {
						return $('#dropdown-field').html();
					}
				});

				$('body').on('click', function (e) {
					var element = $('.select-field');
			        
			        
			        if (!element.is(e.target) && element.has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
			            element.popover('hide');
			        }
				});

				$(document).on('click', '.popover.fade .field-item', function(){
					var self = $(this);
					var textarea = self.closest('#custom_message_wrap').find('textarea');
					jInsertEditorText( '{'+self.attr('id')+'}', textarea.attr('id') );

					$('.select-field').popover('hide');
				});
			});
		";
		$document->addScriptDeclaration($script);

		$action_values = new JRegistry($this->value);

		$html = '<div id="afterprocess-action-value" class="afterprocess-action-value">';

		
		$html .= '<div id="none_wrap">';
		$html .= '<span>' . JText::_('COM_JUFORM_NO_ACTION') . '</span>';
		$html .= '</div>';

		
		$html .= '<div id="redirect_url_wrap">';
		$html .= '<input type="text" placeholder="' . JText::_('COM_JUFORM_ENTER_YOUR_URL') . '" class="" value="' . $action_values->get('redirect_url.url', '') . '" id="redirect_url" name="' . $this->name . '[redirect_url][url]">';
		$html .= '<label for="redirect_url_show_message" class="show_message-lbl checkbox hasTooltip" title="' . JText::_('COM_JUFORM_SHOW_CUSTOM_MESSAGE_DESC') . '">';
		$html .= '<input type="checkbox" name="' . $this->name . '[redirect_url][show_message]" value="1" ' . ((int) $action_values->get('redirect_url.show_message', 0) ? 'checked' : '') . ' id="redirect_url_show_message" class="show_message" />';
		$html .= JText::_('COM_JUFORM_SHOW_CUSTOM_MESSAGE') . '</label>';
		$html .= '</div>';

		
		$html .= '<div id="redirect_menu_wrap">';
		$html .= '<input type="hidden" name="' . $this->name . '[redirect_menu][id]" value="' . (int) $action_values->get('redirect_menu.id', 0) . '" id="redirect_menu_id" />';
		$menuTitle = '';
		$menuItem  = JUFormFrontHelper::getMenuItem((int) $action_values->get('redirect_menu.id', 0));
		if ($menuItem)
		{
			$menuTitle = $menuItem->title;
		}
		$html .= '<div class="input-append">';
		$html .= '<input type="text" placeholder="' . JText::_('COM_JUFORM_SELECT_A_MENU_ITEM') . '" disabled="disabled" value="' . $menuTitle . '" id="redirect_menu_title" />';
		$html .= '<a class="btn"
 							href="index.php?option=com_juform&view=menuitems&layout=modal&tmpl=component&function=jSelectMenuItem"
 							id="select-menu-item" onclick="return false;" data-fancybox-type="iframe">...</a>';
		$html .= '</div>';
		$html .= '<label for="redirect_menu_show_message" class="show_message-lbl checkbox hasTooltip" title="' . JText::_('COM_JUFORM_SHOW_CUSTOM_MESSAGE_DESC') . '">';
		$html .= '<input type="checkbox" name="' . $this->name . '[redirect_menu][show_message]" value="1" ' . ((int) $action_values->get('redirect_menu.show_message', 0) ? 'checked' : '') . ' id="redirect_menu_show_message" class="show_message" />';
		$html .= JText::_('COM_JUFORM_SHOW_CUSTOM_MESSAGE') . '</label>';
		$html .= '</div>';

		
		$html .= '<div id="custom_message_wrap">';
		
		$html .= '<button type="button" class="btn select-field hasTooltip" href="#"  title="' . JText::_('COM_JUFORM_INSERT_FIELD') . '">...</button>';
		$html .= '<div id="dropdown-field" class="hidden">';
		$html .= '<ul class="email field-list">';
		$fields = JUFormFrontHelperField::getFields($this->form->getValue('id'));
		if ($fields)
		{
			foreach ($fields AS $field)
			{
				if ($field->getPlaceholderValue() !== false)
				{
					$html .= '<li class="field-item" id="' . $field->field_name . '">' . $field->getCaption(true) . '</li>';
				}
			}
		}
		$html .= '</ul>';
		$html .= '</div>';
		$app    = JFactory::getApplication();
		$editor = JEditor::getInstance($app->get('editor', 'tinymce'));
		$html .= '<div>';
		$html .= $editor->display($this->name . '[custom_message]', htmlspecialchars($action_values->get('custom_message', ''), ENT_COMPAT, 'UTF-8'), 600, 400, 50, 5, '', 'custom_message');
		$html .= '</div>';

		$html .= '</div>';

		$html .= '</div>';

		return $html;
	}
}

?>