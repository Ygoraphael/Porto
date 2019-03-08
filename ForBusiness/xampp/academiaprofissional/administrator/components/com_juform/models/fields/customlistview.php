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

class JFormFieldCustomListView extends JFormField
{
	protected $type = 'customlistview';

	protected function getInput()
	{
		$form_id = $this->form->getValue('form_id', 'list', 0);
		$html    = '';

		if ($form_id)
		{
			$document = JFactory::getDocument();
			$document->addScript(JUri::root(true) . '/components/com_juform/assets/js/jquery.dragsort.min.js');
			$script = "
			jQuery(document).ready(function($){
				$('.select-field').popover({
					html : true,
					placement : 'bottom',
					title : function(){
						if($('#popover_content_wrapper').data('state')){
							var btnClass = 'save-order-field';
						}else{
							var btnClass = 'save-order-field disabled';
						}

						return 'Select Fields <span class=\"'+btnClass+'\" title=\"Apply\"><i class=\"icon-ok\"></i></span>';
					},
				    content : function() {
						setTimeout(function(){
							$('.popover-content .field-list').dragsort({ dragSelector: 'li', dragEnd: dragEnd, placeHolderTemplate: '<li class=\"placeHolder\"><label class=\"checkbox\"></label></label></li>', dragSelectorExclude: 'input, label' });
							$('.popover-content .field-list input').change(function(){
								if($(this).is(':checked')){
									$('#popover_content_wrapper .field-list input[value=\"'+$(this).val()+'\"]').attr('checked', 'checked');
								}else{
									$('#popover_content_wrapper .field-list input[value=\"'+$(this).val()+'\"]').removeAttr('checked');
								}

								changeState();
							});
						}, 0);

						return $('#popover_content_wrapper').html();
					}
				});

				function dragEnd(){
					$('#popover_content_wrapper .field-list').html($('.popover-content .field-list').html());
					changeState();
				}

				function changeState() {
					var originalOrdering = $('#popover_content_wrapper').data('original-ordering');
					var currentOrdering = $('.popover-content .field-list input').map(function() {
						var data = {};
						data['fieldId'] = $(this).val();
						if($(this).is(':checked')){
							data['state'] = 1;
						}else{
							data['state'] = 0;
						}

						return data;
					}).get();

					var changed = false;
					for(x in originalOrdering){
						if((originalOrdering[x].fieldId != currentOrdering[x].fieldId) || (originalOrdering[x].state != currentOrdering[x].state)){
							changed = true;
							break;
						}
					}

					if(changed){
						$('.save-order-field').removeClass('disabled');
					}else{
						$('.save-order-field').addClass('disabled');
					}

					$('#popover_content_wrapper').data('state', changed);
				}

				$('body').on('click', function (e) {
					var element = $('.select-field');
			        
			        
			        if (!element.is(e.target) && element.has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
			            element.popover('hide');
			        }
				});

				$('#adminForm').on('click', '.save-order-field', function(){
					var self = $(this);

					if(self.hasClass('disabled')){
						return false;
					}

					var currentOrdering = $('.popover-content .field-list input').map(function() {
						var data = {};
						data['fieldId'] = $(this).val();
						if($(this).is(':checked')){
							data['state'] = 1;
						}else{
							data['state'] = 0;
						}

						return data;
					}).get();

					$.ajax({
						url: 'index.php?option=com_juform&task=submissions.saveOrderingField',
						data : 'fieldOrdering='+JSON.stringify(currentOrdering)+'&" . JSession::getFormToken() . "=1',
						type : 'POST',
						beforeSend : function(){
							self.css('opacity', 0.5);
						}
					}).done(function(result) {
						if(result == 1){
							window.location.replace('index.php?option=com_juform&view=submissions');
						}
						
						$('.select-field').popover('hide');
						self.css('opacity', 0.5);
					});
				});
			});
			";

			$document->addScriptDeclaration($script);

			$html .= '
			<button class="select-field btn btn-icon" onclick="return false;" id="select_field" data-toggle="popover">
				<i class="icon-list"></i>
			</button>
			';

			$fields           = JUFormFrontHelperField::getFields($form_id);
			$_html            = '<ul class="submissions field-list" style="list-style: none; margin: 0; width: 170px">';
			$originalOrdering = array();
			foreach ($fields AS $field)
			{
				$fieldClass = JUFormFrontHelperField::getField($field);
				if ($fieldClass->isBackendListView() !== null)
				{
					$_html .= '<li>';
					$_html .= '<label class="checkbox">';
					if ($fieldClass->isBackendListView())
					{
						$originalOrdering[] = array('fieldId' => $field->id, 'state' => 1);
						$_html .= '<input checked="true" type="checkbox" title="' . $fieldClass->getCaption(true) . '" name="fields[]" value="' . $field->id . '">';
					}
					else
					{
						$originalOrdering[] = array('fieldId' => $field->id, 'state' => 0);
						$_html .= '<input type="checkbox" title="' . $fieldClass->getCaption(true) . '" name="fields[]" value="' . $field->id . '">';
					}
					$_html .= $fieldClass->getCaption(true);
					$_html .= '</label>';
					$_html .= '</li>';
				}
			}
			$_html .= '</ul>';

			$html .= '<div id="popover_content_wrapper" style="display: none;"
					data-original-ordering="' . htmlspecialchars(json_encode($originalOrdering)) . '">';
			$html .= $_html;
			$html .= '</div>';
			
		}

		return $html;
	}
}

?>