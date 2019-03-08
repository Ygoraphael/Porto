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

class JFormFieldFields extends JFormField
{
	public $type = 'fields';

	public function getLabel()
	{
		return '';
	}

	public function getInput()
	{
		$form_id = $this->form->getValue('id');

		$document = JFactory::getDocument();
		$document->addScript(JUri::root(true) . '/components/com_juform/assets/js/jquery.dragsort.min.js');
		$script = "
				var isVisible = false;
				jQuery(document).ready(function($){
					$('.add-field, .edit-field').fancybox({
						beforeLoad: function() {
											if(this.element.hasClass('show-form'))
											{
												var total_fields = this.element.closest('.field-config').find('.field-list table tbody tr').length - 1;
												if(total_fields >= (20-12))
												{
													alert('Y' + 'our fo' + 'rm r' + 'ea' + 'ch ma' + 'x ' + '8 f' + 'ield' + 's per f' + 'orm');
													return false;
												}
											}
											this.title = $(this.element).data('caption');
									   }
					});

					$('.field-list').on('click', '.remove-field', function(){
						var r = confirm('" . JText::_('COM_JUFORM_ARE_YOU_SURE_YOU_WANT_TO_REMOVE_THIS_FIELD') . "');
						if (r == false) {
						    return false;
						}
						
						var tr = $(this).closest('tr');
						var fieldId = tr.attr('id');

						jQuery.ajax({
							type: 'POST',
							url : 'index.php?option=com_juform&tmpl=component&task=field.remove',
							data: 'fieldId=' + fieldId + '&" . JSession::getFormToken() . "=1',
							beforeSend: function () {
								showSpinner();
							}
						})
						.done(function (value) {
							if(value == 1){
								tr.remove();
							}

							hideSpinner();
						});
					});

					$('.field-list').on('click', '.duplicate-field', function(){
						var total_fields = $(this).closest('tbody').find('> tr').length - 1;
						if(total_fields >= 8)
						{
							alert('Yo' + 'ur f' + 'o' + 'rm' + ' rea' + 'ch m' + 'a' + 'x 8 f' + 'ie' + 'ld' + 's per f' + 'orm');
							return false;
						}
						var tr = $(this).closest('tr');
						var fieldId = tr.attr('id');

						jQuery.ajax({
							type: 'POST',
							url : 'index.php?option=com_juform&tmpl=component&task=field.duplicate',
							data: 'fieldId=' + fieldId + '&" . JSession::getFormToken() . "=1',
							dataType: 'json',
							beforeSend: function () {
								showSpinner();
							}
						})
						.done(function (data) {
							if(data.success == 1){
								addField(data.field);
							}

							hideSpinner();
						});
					});

					$('#ordering-type').change(function(){
						var type = $(this).val();
						jQuery.ajax({
									type: 'POST',
									url : 'index.php?option=com_juform&tmpl=component&task=field.getOrdering',
									data: 'form_id=" . $form_id . "&type=' + type + '&" . JSession::getFormToken() . "=1'
						})
						.done(function (value) {
							if(value){
								var fieldIds = value.split(',');
								var tbody = $('.field-list tbody');
								var place = tbody.clone();
								place.html('');
								for(x in fieldIds){
									if(fieldIds.hasOwnProperty(x)){
										var element = tbody.find('#'+fieldIds[x]).clone();
										if(element){
											place.append(element);
										}
									}
								}

								tbody.hide(0).html(place.html()).fadeIn();
							}
						});
					});

					changeFieldPublish = function(self, fieldId){
						if(fieldId){
							$.ajax({
								type: 'POST',
								url : 'index.php?option=com_juform&tmpl=component&task=form.changeFieldPublish',
								data: {fieldId : fieldId},
								beforeSend: function () {
									showSpinner();
								}
							})
							.done(function (msg) {
								el = jQuery(msg)[0];
								$('body > .tooltip.fade').remove();
								$(el).tooltip({'html': true,'container': 'body'});
								$(self).parent().html(el);

								hideSpinner();
							});
						}
					}
				});

				var addField = function(field){
					if(field){
						var html = getFieldHtml(field);
						html = jQuery(html);
						$('body > .tooltip.fade').remove();
						html.find('a.field-publish').tooltip({'html': true,'container': 'body'});
					    var element = jQuery('#'+field.id);
					    if(element.length){
						    element.replaceWith(html);
					    }else{
						    jQuery('.field-list table tbody').append(html);
					    }
					}
				};

				var changeValue = function(self, fieldId, column){
					if(self && fieldId && column){
						self = jQuery(self);
						jQuery.ajax({
							type: 'POST',
							url : 'index.php?option=com_juform&tmpl=component&task=field.changeValue',
							data: 'fieldId=' + fieldId + '&column=' + column + '&" . JSession::getFormToken() . "=1',
							beforeSend: function () {
								showSpinner();
							}
						})
						.done(function (value) {
							if(value == 1){
								self.find('i').removeClass('icon-unpublish').addClass('icon-publish');
							}else if(value == 0){
								self.find('i').removeClass('icon-publish').addClass('icon-unpublish');
							}

							hideSpinner();
						});
					}
				}

				var getFieldHtml = function(field){
					var html = '<tr id=\"'+field.id+'\">';
					html += '<td class=\"hidden-phone hidden-tablet\">';
					html += '<i class=\"icon-menu\"></i>';
					html += '</td>';
					html += '<td class=\"hidden-phone hidden-tablet\">';
					html += field.field_name;
					html += '</td>';
					html += '<td>';
					html += field.caption;
					html += '</td>';
					html += '<td>';
					html += field.preview;
					html += '</td>';
					html += '<td class=\"center hidden-phone hidden-tablet\">';
					html += field.published;
					html += '</td>';
					html += '<td class=\"center hidden-phone hidden-tablet\">';
						if(field.required === 'unset'){
							html += '-';
						}
						else{
							if(field.required == '1'){
								html += '<a href=\"#\" class=\"btn btn-micro active hasTooltip\" onclick=\"changeValue(this, \\''+field.id+'\\', \\'required\\'); return false;\"><i class=\"icon-publish\"></i></a>';
							}else{
								html += '<a href=\"#\" class=\"btn btn-micro active hasTooltip\" onclick=\"changeValue(this, \\''+field.id+'\\', \\'required\\'); return false;\"><i class=\"icon-unpublish\"></i></a>';
							}
						}
					html += '</td>';
					html += '<td class=\"center hidden-phone hidden-tablet\">';
						if(field.hide === 'unset'){
							html += '-';
						}
						else{
							if(field.hide == '1'){
								html += '<a href=\"#\" class=\"btn btn-micro active hasTooltip\" onclick=\"changeValue(this, \\''+field.id+'\\', \\'hide\\'); return false;\"><i class=\"icon-publish\"></i></a>';
							}else{
								html += '<a href=\"#\" class=\"btn btn-micro active hasTooltip\" onclick=\"changeValue(this, \\''+field.id+'\\', \\'hide\\'); return false;\"><i class=\"icon-unpublish\"></i></a>';
							}
						}
					html += '</td>';
					html += '<td class=\"center\">';
						var link = 'index.php?option=com_juform&view=field&layout=edit&tmpl=component&id='+field.id;
						html += '<a href=\"'+link+'\" class=\"btn btn-small edit-field\" data-fancybox-type=\"iframe\" data-caption=\"" . JText::_('COM_JUFORM_EDIT') . ": '+field.caption+'\" title=\"" . JText::_('COM_JUFORM_EDIT') . "\"><i class=\"icon-edit\"></i></a>';
						html += ' <button type=\"button\" class=\"btn btn-small btn-danger remove-field\" title=\"" . JText::_('COM_JUFORM_REMOVE') . "\"><i class=\"icon-trash\"></i></button>';
						html += ' <button type=\"button\" class=\"btn btn-small btn-primary duplicate-field\" title=\"" . JText::_('COM_JUFORM_DUPLICATE') . "\"><i class=\"icon-copy\"></i></button>';
					html += '</td>';
					html += '</tr>';

					return html;
				}
				";
		$document->addScriptDeclaration($script);

		$script = "jQuery(document).ready(function($){
						$('.field-list tbody').dragsort({ dragSelector: 'tr', dragEnd: saveOrder, placeHolderTemplate: '<tr class=\"placeHolder\"><td colspan=\"5\"></td></tr>', dragSelectorExclude : 'button, a, input, textarea'});
						function saveOrder() {
							var ids = $('.field-list tbody tr').map(function() { return $(this).attr('id'); }).get();
							
							var type = 'ordering';
							if(ids && type){
								$.ajax({
									type: 'POST',
									url : 'index.php?option=com_juform&tmpl=component&task=field.ordering',
									data: 'fieldIds=' + ids.join(',') + '&type=' + type + '&" . JSession::getFormToken() . "=1',
									beforeSend: function () {
										showSpinner();
									}
								})
								.done(function (value) {
									hideSpinner();
								});
							}
						}
					});
					";

		$document->addScriptDeclaration($script);

		$style = '
			.popover-iframe {
				width: 600px;
				height: 500px;
			}
		';
		$document->addStyleDeclaration($style);

		$fields = $this->getFields();
		$html    = '';

		

		$html .= '<div class="field-config row-fluid">';
		$html .= '<div class="span2">';
		$html .= '<ul class="fieldtype-list nav nav-list">';
		foreach ($fields AS $field)
		{
            
            
			$html .= '<li>';
			$url = 'index.php?option=com_juform&view=field&layout=edit&tmpl=component&form_id=' . $form_id . '&plugin_id=' . $field->id . '&id=0';
            
            if($field->id==1 || $field->id==3){
                
               $html .= '<a href="' . $url . '" class="add-field type-' . $field->folder . '" data-fancybox-type="iframe">' . $field->title . '</a>'; 
                
            }
			
			$html .= '</li>';
		}
		$html .= '</ul>';
		$html .= '</div>';

		$html .= '<div class="field-list span10">';
		$html .= '<table class="table table-striped">';
		$html .= '<thead>';
		$html .= '<th class="hidden-phone" style="width: 1%"><i class="icon-menu-2"></i></th>';
		$html .= '<th class="hidden-phone hidden-tablet" style="width: 10%">' . JText::_('COM_JUFORM_FIELD_NAME') . '</th>';
		$html .= '<th style="width: 15%">' . JText::_('COM_JUFORM_CAPTION') . '</th>';
		$html .= '<th style="width: 45%">' . JText::_('COM_JUFORM_PREVIEW') . '</th>';
		$html .= '<th class="center" style="width: 5%">' . JText::_('COM_JUFORM_PUBLISHED') . '</th>';
		$html .= '<th class="center hidden-phone hidden-tablet" style="width: 5%">' . JText::_('COM_JUFORM_REQUIRED') . '</th>';
		$html .= '<th class="center hidden-phone hidden-tablet" style="width: 5%">' . JText::_('COM_JUFORM_HIDE') . '</th>';
		$html .= '<th class="center" style="width: 15%">' . JText::_('COM_JUFORM_ACTIONS') . '</th>';
		$html .= '</thead>';
		$html .= '<tbody>';
		$html .= '<tr id="0" style="display: none;"><td></td></tr>';

		$fieldIds = array();
		$form_id  = $this->form->getValue('id');
		$fields   = JUFormFrontHelperField::getFieldsByFormId($form_id);
		foreach ($fields AS $field)
		{
			$fieldClass = JUFormFrontHelperField::getField($field);
			if ($fieldClass)
			{
				$fieldIds[] = $field->id;
				$html .= '<tr id="' . $field->id . '">';
				$html .= '<td class="hidden-phone">';
				$html .= '<i class="icon-menu"></i>';
				$html .= '</td>';
				$html .= '<td class="hidden-phone hidden-tablet">';
				$html .= $fieldClass->field_name;
				$html .= '</td>';
				$html .= '<td>';
				$html .= $fieldClass->getCaption(true);
				$html .= '</td>';
				$html .= '<td>';
				$html .= $fieldClass->getPreview();
				$html .= '</td>';
				$html .= '<td class="center">';
				$html .= JHtml::_('juformadministrator.published', $fieldClass->published, $fieldClass->id, 'fields.', true, 'cb', $fieldClass->publish_up, $fieldClass->publish_down);
				
				$html .= '</td>';
				$html .= '<td class="center hidden-phone hidden-tablet">';
				if ($fieldClass->isRequired() === null)
				{
					$html .= '-';
				}
				else
				{
					if ($fieldClass->isRequired())
					{
						$html .= '<a href="#" class="btn btn-micro active hasTooltip" onclick="changeValue(this, \'' . $field->id . '\', \'required\'); return false;"><i class="icon-publish"></i></a>';
					}
					else
					{
						$html .= '<a href="#" class="btn btn-micro active hasTooltip" onclick="changeValue(this, \'' . $field->id . '\', \'required\'); return false;"><i class="icon-unpublish"></i></a>';
					}
				}
				$html .= '</td>';
				$html .= '<td class="center hidden-phone hidden-tablet">';
				if ($fieldClass->isHide() === null)
				{
					$html .= '-';
				}
				else
				{
					if ($fieldClass->isHide())
					{
						$html .= '<a href="#" class="btn btn-micro active hasTooltip" onclick="changeValue(this, \'' . $field->id . '\', \'hide\'); return false;"><i class="icon-publish"></i></a>';
					}
					else
					{
						$html .= '<a href="#" class="btn btn-micro active hasTooltip" onclick="changeValue(this, \'' . $field->id . '\', \'hide\'); return false;"><i class="icon-unpublish"></i></a>';
					}
				}
				$html .= '</td>';
				$html .= '<td class="center">';
				$url = 'index.php?option=com_juform&view=field&layout=edit&tmpl=component&id=' . $field->id;
				$html .= '<a href="' . $url . '" class="btn btn-small edit-field" data-fancybox-type="iframe" data-caption="' . JText::_('COM_JUFORM_EDIT') . ': ' . $field->caption . '" title="' . JText::_('COM_JUFORM_EDIT') . '"><i class="icon-edit"></i></a>';
				$html .= ' <button type="button" class="btn btn-small btn-danger remove-field" title="' . JText::_('COM_JUFORM_REMOVE') . '"><i class="icon-trash"></i></button>';
				$html .= ' <button type="button" class="btn btn-small btn-primary duplicate-field" title="' . JText::_('COM_JUFORM_DUPLICATE') . '"><i class="icon-copy"></i></button>';
				$html .= '</td>';
				$html .= '</tr>';
			}
		}

		$html .= '</tbody>';
		$html .= '</table>';
		$html .= '</div>';
		$html .= '</div>';

		return $html;
	}

	protected function getFields()
	{
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('*')
			->from('#__juform_plugins')
			->where('type = "field"')
			->order('id ASC');

		$db->setQuery($query);

		return $db->loadObjectList();
	}
}

?>