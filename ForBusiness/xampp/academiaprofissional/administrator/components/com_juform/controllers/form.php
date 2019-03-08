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


jimport('joomla.application.component.controllerform');


class JUFormControllerForm extends JControllerForm
{
	
	protected $text_prefix = 'COM_JUFORM_FORM';

	
	public function add()
	{
		$db = JFactory::getDbo();
		$query = "SELECT COUNT(*) FROM #__juform_forms";
		$db->setQuery($query);

		if (!$this->allowAdd())
		{
			
			$this->setError(JText::_('JLIB_APPLICATION_ERROR_CREATE_RECORD_NOT_PERMITTED'));
			$this->setMessage($this->getError(), 'error');

			$this->setRedirect(
				JRoute::_(
					'index.php?option=' . $this->option . '&view=' . $this->view_list
					. $this->getRedirectToListAppend(), false
				)
			);

			return false;
		}

		$app     = JFactory::getApplication();
		$context = "$this->option.edit.$this->context";

		
		$app->setUserState($context . '.data', null);

		
		$model                  = $this->getModel();
		$table                  = $model->getTable();
		$table->id              = 0;
		$table->title           = JText::_('COM_JUFORM_NEW_FORM_TITLE');
		$table->published       = -1;
		$table->access          = 1;
		$table->save_submission = 1;
		$table->show_title      = 1;
		$table->created         = JFactory::getDate()->toSql();
		$table->created_by      = JFactory::getUser()->id;

		
		$db = JFactory::getDbo();
		$db->setQuery('SELECT MAX(ordering) FROM #__juform_forms');
		$max             = $db->loadResult();
		$table->ordering = $max + 1;

		$table->store();

		
		$this->deleteExpiredForm();

		
		$this->setRedirect(
			JRoute::_(
				'index.php?option=' . $this->option . '&view=' . $this->view_item
				. $this->getRedirectToItemAppend($table->id), false
			)
		);

		return true;
	}

	
	protected function deleteExpiredForm()
	{
		$db   = JFactory::getDbo();
		$date = JFactory::getDate();
		
		$time  = $date->toUnix() - 86400;
		$date  = JFactory::getDate($time);
		$query = 'DELETE FROM #__juform_forms WHERE published = -1 AND created < ' . $db->quote($date->toSql());
		$db->setQuery($query);
		$db->execute();
	}

	
	public function cancel($key = null)
	{
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		$app   = JFactory::getApplication();
		$model = $this->getModel();
		$table = $model->getTable();

		if (empty($key))
		{
			$key = $table->getKeyName();
		}

		$recordId = $app->input->getInt($key);

		if ($table->load($recordId))
		{
			if ($table->published == -1)
			{
				$db    = JFactory::getDbo();
				$query = 'DELETE FROM #__juform_fields WHERE form_id = ' . $table->id;
				$db->setQuery($query);
				$db->execute();
				$table->delete();

				$this->setRedirect(
					JRoute::_(
						'index.php?option=' . $this->option . '&view=' . $this->view_list
						. $this->getRedirectToListAppend(), false
					)
				);

				return false;
			}
		}

		return parent::cancel($key);
	}

	
	public function generateTemplate()
	{
		$app        = JFactory::getApplication();
		$data       = $app->input->get('jform', array(), 'array');
		$formId     = $data['id'];
		$templateId = $data['template_id'];
		$template   = JUFormHelper::getPluginById($templateId);
		$code       = '';
		if ($formId && $template)
		{
			$templateParams = isset($data['template_params'][$template->folder]) ? $data['template_params'][$template->folder] : array();
			$model          = $this->getModel();
			$code           = $model->generateTemplate($formId, $template->folder, $templateParams);
		}

		JUFormHelper::obCleanData();
		echo trim($code);
		exit;
	}

	
	

	
	public function generateFieldCondition()
	{
		$app    = JFactory::getApplication();
		$formId = $app->input->getInt('formId', 0);
		if ($formId)
		{
			$model = $this->getModel();
			JUFormHelper::obCleanData();
			echo $model->generateFieldCondition($formId);
			exit;
		}
	}

	
	public function changeConditionField()
	{
		$app     = JFactory::getApplication();
		$fieldId = $app->input->getInt('fieldId', 0);
		$field   = JUFormFrontHelperField::getField($fieldId);

		$options = array();
		if ($field)
		{
			$options = (array) $field->getPredefinedValues();
		}

		JUFormHelper::obCleanData();
		echo JHtml::_('select.options', $options);
		exit;
	}

	
	

	
	public function removeFieldAction()
	{
		$app      = JFactory::getApplication();
		$actionId = $app->input->getInt('id', 0);
		if ($actionId)
		{
			$model = $this->getModel();
			if ($model->removeFieldAction($actionId))
			{
				JUFormHelper::obCleanData();
				echo 1;
				exit;
			}
		}
	}

	
	public function changeFieldAction()
	{
		$app    = JFactory::getApplication();
		$formId = $app->input->getInt('formId', 0);
		$action = $app->input->getString('action', '');

		$html = '';
		if ($formId && $action)
		{
			$fields       = JUFormFrontHelperField::getFields($formId);
			$fieldOptions = array();
			foreach ($fields AS $field)
			{
				if (($action == 'show' && $field->isHide() === true) || ($action == 'hide' && $field->isHide() === false))
				{
					$fieldOptions[] = array('value' => $field->id, 'text' => $field->getCaption(true));
				}
			}

			if ($fieldOptions)
			{
				$html = JHtml::_('select.options', $fieldOptions);
			}
		}

		JUFormHelper::obCleanData();
		echo $html;
		exit;
	}

	public function saveFieldActionOrdering()
	{
		$app            = JFactory::getApplication();
		$fieldActionIds = $app->input->getString('fieldActionIds', '');
		if ($fieldActionIds)
		{
			$model          = $this->getModel();
			$fieldActionIds = explode(',', $fieldActionIds);
			if ($model->saveFieldActionOrdering($fieldActionIds))
			{
				JUFormHelper::obCleanData();
				echo 1;
				exit;
			}
		}
	}

	public function changeFieldPublish()
	{
		$app     = JFactory::getApplication();
		$fieldId = $app->input->getInt('fieldId');
		JUFormHelper::obCleanData();

		if ($fieldId)
		{
			$model = $this->getModel();
			echo $model->changeFieldPublish($fieldId);
		}
		exit;
	}

	
	public function generateFormEmail()
	{
		JHtml::_('bootstrap.tooltip');
		JHtml::_('behavior.keepalive');
		JHtml::_('behavior.formvalidator');

		$document = JFactory::getDocument();
		$model   = $this->getModel();
		$app     = JFactory::getApplication();
		$emailId = $app->input->getInt('emailId', 0);
		$formId  = $app->input->getInt('formId', 0);
		$email   = null;
		if ($emailId)
		{
			$email = JUFormFrontHelper::getEmail($emailId);
		}

		$html            = '';
		$actionOptions   = array();
		$actionOptions[] = array('value' => 'show', 'text' => JText::_('JSHOW'));
		$actionOptions[] = array('value' => 'hide', 'text' => JText::_('JHIDE'));

		$html .= '<form name="adminForm" id="adminForm" class="form-validate">';
		$html .= '<div id="email-add" class="form-horizontal">';

		$html .= '<div class="control-group input-append">';
		$html .= '<label for="email-subject" class="control-label">' . JText::_('COM_JUFORM_SUBJECT') . '<span class="star"> *</span></label>';
		$html .= '<div class="controls">';
		$html .= '<input type="text" id="email-subject" class="required" value="' . ($email ? $email->subject : '') . '"/>';
		$html .= '<button type="button" class="btn select-field hasTooltip" href="#"  title="' . JText::_('COM_JUFORM_INSERT_FIELD') . '">...</button>';
		$html .= '</div>';
		$html .= '</div>';

		$html .= '<div class="control-group input-append">';
		$html .= '<label for="email-from" class="control-label hasTooltip" title="' . JHtml::tooltipText('COM_JUFORM_FROM_DESC') . '">' . JText::_('COM_JUFORM_FROM') . '<span class="star"> *</span></label>';
		$html .= '<div class="controls">';
		$html .= '<input type="text" id="email-from" class="required" value="' . ($email ? $email->from : '') . '"/>';
		$html .= '<button type="button" class="btn select-field hasTooltip" href="#"  title="' . JText::_('COM_JUFORM_INSERT_FIELD') . '">...</button>';
		$html .= '</div>';
		$html .= '</div>';

		$html .= '<div class="control-group input-append">';
		$html .= '<label for="email-from-name" class="control-label hasTooltip" title="' . JHtml::tooltipText('COM_JUFORM_FROM_NAME_DESC') . '">' . JText::_('COM_JUFORM_FROM_NAME') . '</label>';
		$html .= '<div class="controls">';
		$html .= '<input type="text" id="email-from-name" value="' . ($email ? $email->from_name : '') . '"/>';
		$html .= '<button type="button" class="btn select-field hasTooltip" href="#"  title="' . JText::_('COM_JUFORM_INSERT_FIELD') . '">...</button>';
		$html .= '</div>';
		$html .= '</div>';

		$html .= '<div class="control-group input-append">';
		$html .= '<label for="email-recipients" class="control-label hasTooltip" title="' . JHtml::tooltipText('COM_JUFORM_RECIPIENTS_DESC') . '">' . JText::_('COM_JUFORM_RECIPIENTS') . '<span class="star"> *</span></label>';
		$html .= '<div class="controls">';
		$html .= '<input type="text" id="email-recipients" class="required" value="' . ($email ? $email->recipients : '') . '"/>';
		$html .= '<button type="button" class="btn select-field hasTooltip" href="#"  title="' . JText::_('COM_JUFORM_INSERT_FIELD') . '">...</button>';
		$html .= '</div>';
		$html .= '</div>';

		$html .= '<div class="control-group input-append">';
		$html .= '<label for="email-cc" class="control-label hasTooltip" title="' . JHtml::tooltipText('COM_JUFORM_CC_DESC') . '">' . JText::_('COM_JUFORM_CC') . '</label>';
		$html .= '<div class="controls">';
		$html .= '<input type="text" id="email-cc" value="' . ($email ? $email->cc : '') . '"/>';
		$html .= '<button type="button" class="btn select-field hasTooltip" href="#"  title="' . JText::_('COM_JUFORM_INSERT_FIELD') . '">...</button>';
		$html .= '</div>';
		$html .= '</div>';

		$html .= '<div class="control-group input-append">';
		$html .= '<label for="email-bcc" class="control-label hasTooltip" title="' . JHtml::tooltipText('COM_JUFORM_BCC_DESC') . '">' . JText::_('COM_JUFORM_BCC') . '</label>';
		$html .= '<div class="controls">';
		$html .= '<input type="text" id="email-bcc" value="' . ($email ? $email->bcc : '') . '"/>';
		$html .= '<button type="button" class="btn select-field hasTooltip" href="#"  title="' . JText::_('COM_JUFORM_INSERT_FIELD') . '">...</button>';
		$html .= '</div>';
		$html .= '</div>';

		$html .= '<div class="control-group input-append">';
		$html .= '<label for="email-reply-to" class="control-label hasTooltip" title="' . JHtml::tooltipText('COM_JUFORM_REPLY_TO_DESC') . '">' . JText::_('COM_JUFORM_REPLY_TO') . '</label>';
		$html .= '<div class="controls">';
		$html .= '<input type="text" id="email-reply-to" value="' . ($email ? $email->reply_to : '') . '"/>';
		$html .= '<button type="button" class="btn select-field hasTooltip" href="#"  title="' . JText::_('COM_JUFORM_INSERT_FIELD') . '">...</button>';
		$html .= '</div>';
		$html .= '</div>';

		$html .= '<div class="control-group input-append">';
		$html .= '<label for="email-reply-to-name" class="control-label hasTooltip" title="' . JHtml::tooltipText('COM_JUFORM_REPLY_TO_NAME_DESC') . '">' . JText::_('COM_JUFORM_REPLY_TO_NAME') . '</label>';
		$html .= '<div class="controls">';
		$html .= '<input type="text" id="email-reply-to-name" value="' . ($email ? $email->reply_to_name : '') . '"/>';
		$html .= '<button type="button" class="btn select-field hasTooltip" href="#"  title="' . JText::_('COM_JUFORM_INSERT_FIELD') . '">...</button>';
		$html .= '</div>';
		$html .= '</div>';

		$editor = JEditor::getInstance($app->get('editor', 'tinymce'));
		$html .= '<div class="control-group">';
		$html .= '<label for="email_message" class="control-label hasTooltip" title="' . JHtml::tooltipText('COM_JUFORM_MESSAGE_DESC') . '">' . JText::_('COM_JUFORM_MESSAGE') . '<span class="star"> *</span></label>';
		$html .= '<div class="controls">';
		$html .= '<button type="button" class="btn select-field hasTooltip" href="#"  title="' . JText::_('COM_JUFORM_INSERT_FIELD') . '">...</button>';

		$html .= $editor->display('', htmlspecialchars($email ? $email->message : '', ENT_COMPAT, 'UTF-8'), 600, 400, 50, 10, '', 'email_message');
		$html .= '</div>';
		$html .= '</div>';

		$html .= '<div class="control-group">';
		$html .= '<label for="email-mode" class="control-label">' . JText::_('COM_JUFORM_MODE') . '</label>';
		$html .= '<div class="controls">';
		$html .= '<select id="email-mode">';
		$value = $email ? $email->mode : 1;
		$html .= '<option value="1" ' . ($value == 1 ? 'selected' : '') . '>' . JText::_('COM_JUFORM_HTML') . '</option>';
		$html .= '<option value="0" ' . ($value == 0 ? 'selected' : '') . '>' . JText::_('COM_JUFORM_TEXT') . '</option>';
		$html .= '</select>';
		$html .= '</div>';
		$html .= '</div>';

		$html .= '<div class="control-group">';
		$html .= '<label for="email-published" class="control-label">' . JText::_('COM_JUFORM_LANGUAGE') . '</label>';
		$html .= '<div class="controls">';
		$languages = JHtml::_('contentlanguage.existing');
		$value     = $email ? $email->language : '*';
		$options   = array();
		$options[] = JHTML::_('select.option', '*', JText::_('JALL'));
		foreach ($languages AS $language)
		{
			$options[] = JHTML::_('select.option', $language->value, $language->text);
		}

		$html .= JHTML::_('select.genericlist', $options, '', '', 'value', 'text', $value, 'email-language');
		$html .= '</div>';
		$html .= '</div>';

		$html .= '<div class="control-group">';
		$html .= '<label for="email-published" class="control-label">' . JText::_('COM_JUFORM_PUBLISHED') . '</label>';
		$html .= '<div class="controls">';
		$html .= '<select id="email-published">';
		$value = $email ? $email->published : 1;
		$html .= '<option value="1" ' . ($value == 1 ? 'selected' : '') . '>' . JText::_('JYES') . '</option>';
		$html .= '<option value="0" ' . ($value == 0 ? 'selected' : '') . '>' . JText::_('JNO') . '</option>';
		$html .= '</select>';
		$html .= '</div>';
		$html .= '</div>';

		$html .= '<div class="control-group">';
		$html .= '<label for="email-attachments" class="control-label">' . JText::_('COM_JUFORM_ATTACHMENTS') . '</label>';
		$html .= '<div class="controls">';
		$html .= '<ul id="email-attachments">';
		if ($email && $email->attachments)
		{
			$code        = md5($email->id . $app->get('secret'));
			$attachments = json_decode($email->attachments);
			foreach ($attachments AS $attachment)
			{
				$link = JUFormHelper::emailLinkRouter(JUri::root(true) . '/index.php?option=com_juform&task=email.downloadattachment&mail_id=' . $email->id . '&file_id=' . $attachment->id . '&code=' . $code);
				$html .= '<li>';
				$html .= '<input type="checkbox" class="email-attachment" checked data-id="' . $attachment->id . '" style="margin: 0 5px 0 0;"/>';
				$html .= '<a href="' . $link . '" title="' . JText::_('COM_JUFORM_DOWNLOAD') . '" target="_blank">' . $attachment->name . '</a>';
				$html .= '</li>';
			}
		}
		$html .= '</ul>';
		$html .= '<div class="file-upload-container">';
		$html .= '<button type="button" class="btn btn-primary btn-small pickfiles"><i class="icon-plus"></i> ' . JText::_('COM_JUFORM_ADD_ATTACHMENT') . '</button>';
		$html .= '</div>';
		$html .= '</div>';
		$html .= '</div>';

		$conditionOptions   = array();
		$conditionOptions[] = array('value' => '&&', 'text' => JText::_('COM_JUFORM_ALL'));
		$conditionOptions[] = array('value' => '||', 'text' => JText::_('COM_JUFORM_ANY'));
		$default            = $email ? $email->send_mail_condition : '&&';
		$html .= '<hr style="clear: both"/>';
		$html .= '<div class="input-prepend input-append pull-left clearfix" style="margin-bottom: 10px;"><span class="add-on">Send email if</span>' . JHtml::_('select.genericlist', $conditionOptions, 'condition', 'class="select-condition input-small"', 'value', 'text', $default, null) . '<span class="add-on">of the following match:</span></div>';

		$html .= '<button type="button" class="email-condition-add btn btn-primary btn-small pull-left clearfix" style="clear: both;"><i class="icon-plus"></i> ' . JText::_('COM_JUFORM_ADD_CONDITION') . '</button>';

		$html .= '<ul class="email-condition-list" style="list-style: none; margin: 10px 0 0 0">';
		if ($emailId)
		{
			$conditions = JUFormFrontHelper::getEmailConditions($emailId);
			foreach ($conditions AS $condition)
			{
				$html .= $model->generateEmailCondition($formId, $condition);
			}
		}
		$html .= '</ul>';

		$html .= '<hr style="clear: both"/>';

		$html .= '<div>';
		$html .= '<button type="button" id="email-save" class="btn btn-primary">' . JText::_('COM_JUFORM_SAVE') . '</button>';
		$html .= '<button type="button" id="email-cancel" class="btn" style="margin-left: 3px">' . JText::_('COM_JUFORM_CANCEL') . '</button>';
		$html .= '<input type="hidden" id="email-id" value="' . $emailId . '"/>';
		$html .= '</div>';

		$html .= '</div>';

		$html .= '<div id="dropdown-field" class="hidden">';
		$html .= '<ul class="email field-list">';
		$fields = JUFormFrontHelperField::getFields($formId);
		if ($fields)
		{
			foreach ($fields AS $field)
			{
				if($field->getPlaceholderValue() !== false)
				{
					$html .= '<li class="field-item" id="' . $field->field_name . '">' . $field->getCaption(true) . '</li>';
				}
			}
		}
		$html .= '<li class="field-item" id="site_name">Site name</li>';
		$html .= '<li class="field-item" id="admin_email">Admin email</li>';
		$html .= '<li class="field-item" id="admin_name">Admin name</li>';
		$html .= '<li class="field-item" id="user_email">User email</li>';
		$html .= '<li class="field-item" id="user_name">Name of user</li>';
		$html .= '<li class="field-item" id="user_username">Username</li>';
		$html .= '<li class="field-item" id="form_title">Form title</li>';
		$html .= '<li class="field-item" id="form_link">Form link</li>';
		$html .= '<li class="field-item" id="ip_address">IP Address</li>';
		$html .= '<li class="field-item" id="browser">Browser</li>';
		$html .= '<li class="field-item" id="platform">Platform</li>';
		$html .= '</ul>';
		$html .= '</div>';
		$html .= '</form>';

		echo $html;

		$style = 'body.component {
						background: transparent;
						height: auto;
						padding: 5px;
					}';
		$document->addStyleDeclaration($style);

		$script   = "
			jQuery(document).ready(function($){
				$(document).on('click', '#email-save', function(){
					if(document.formvalidator.isValid(document.getElementById('adminForm'))) {
						" . $editor->save('email_message') . "
						if (typeof tinyMCE !== 'undefined') {
							tinyMCE.triggerSave();
						}
						var self = $(this);
						var parent = self.closest('#email-add');
						var data = {};
						data['id'] = parent.find('#email-id').val();
						data['formId'] = " . (int) $formId . ";
						data['subject'] = parent.find('#email-subject').val();
						data['from'] = parent.find('#email-from').val();
						data['from_name'] = parent.find('#email-from-name').val();
						data['recipients'] = parent.find('#email-recipients').val();
						data['cc'] = parent.find('#email-cc').val();
						data['bcc'] = parent.find('#email-bcc').val();
						data['reply_to'] = parent.find('#email-reply-to').val();
						data['reply_to_name'] = parent.find('#email-reply-to-name').val();
						data['message'] = parent.find('#email_message').val();
						data['mode'] = parent.find('#email-mode').val();
						data['language'] = parent.find('#email-language').val();
						data['published'] = parent.find('#email-published').val();
						data['attachments'] = [];
						$('.email-attachment').each(function(){
							var attachment = {};
							if($(this).is(':checked')){
								attachment.id = $(this).data('id');
								if(attachment.id == 0){
									attachment.name = $(this).data('name');
									attachment.target = $(this).data('target');
								}
								data['attachments'].push(attachment);
							}
						});

						data['send_mail_condition'] = parent.find('.select-condition').val();

						data['conditions'] = [];

						parent.find('.email-condition-list li').each(function(){
							var condition = $(this);
							var conditionData = {};
							conditionData['id'] = condition.find('.condition-id').val();
							conditionData['fieldId'] = condition.find('.select-field-condition').val();
							conditionData['operator'] = condition.find('.select-operator').val();
							conditionData['value'] = condition.find('.select-field-value').val();

							data['conditions'].push(conditionData);
						});

						$.ajax({
							url: 'index.php?option=com_juform&task=form.saveEmail&tmpl=component',
							data: data,
							type: 'POST',
							beforeSend: function(){
								window.parent.showSpinner();
							}
						}).done(function(result) {
							if(result){
								if(data['id'] > 0){
									$(window.parent.document).find('#email-'+data['id']).replaceWith(result);
								}else{
									$(window.parent.document).find('.email-list tbody').append(result);
								}
								window.parent.jQuery.fancybox.close();
							}
							window.parent.hideSpinner();
						});
					}
				});

				$(document).on('click', '#email-cancel', function(){
					window.parent.jQuery.fancybox.close();
				});

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
					var input = self.closest('.controls').find('input');
					if(input.length){
						var value = input.val();
						value += '{'+self.attr('id')+'}';
						input.val(value);
					}
					else
					{
						var textarea = self.closest('.controls').find('textarea');
						jInsertEditorText( '{'+self.attr('id')+'}', textarea.attr('id') );
					}

					$('.select-field').popover('hide');
				});

				addEmailAttachment = function(file, state){
					var html = '';
					if(state == false){
						html += '<li id='+file.id+'>';
							html += '<div class=\"upload-progress\">';
								html += '<div class=\"progress-bar\"></div>';
							html += '</div>';
						html += '</li>';
						$('#email-attachments').append(html);
					}else{
						html += '<input type=\"checkbox\" class=\"email-attachment\" checked data-id=\"0\" data-name=\"'+file.name+'\" data-target=\"'+file.target_name+'\" style=\"margin: 0 5px 0 0;\"/>';
						html += '<span>'+file.name+'</span>';
						$('#'+file.id).html(html);
					}
				};

				var uploader = new plupload.Uploader({
					runtimes: 'html5,flash,silverlight,html4',
					browse_button: $('.pickfiles').get(),
					url: 'index.php?option=com_juform&task=form.addEmailAttachment&tmpl=component',
					chunk_size: '1024kb',
					max_retries: 3,
					multi_selection: true,
					unique_names: true,

					
					flash_swf_url: '" . JUri::root(true) . "/components/com_juform/assets/plupload/Moxie.swf',

					
					silverlight_xap_url: '" . JUri::root(true) . "/components/com_juform/assets/plupload/Moxie.xap',

					init: {
						ChunkUploaded: function (up, file, info) {
							var response = $.parseJSON(info.response);
							if (!response.OK) {
								this.trigger('Error', {
									code: response.error.code,
									message: response.error.message,
									file: file
								});
							}
						},
						FilesAdded: function (up, files) {
							plupload.each(files, function (file) {
								addEmailAttachment(file, false);
							});

							up.start();
						},
						UploadProgress : function(up, file){
							if(file.percent) {
								$('#' + file.id).find('.progress-bar').css('width', file.percent + '%');
							}
						},
						FileUploaded: function (up, file, info) {
							up.removeFile(file);
							var response = $.parseJSON(info.response);
							if (!response.OK) {
								this.trigger('Error', {
									code: response.error.code,
									message: response.error.message,
									file: file
								});
							}else{
								$('#' + file.id).find('.progress-bar').css('width', file.percent + '%');
								setTimeout(function(){
									addEmailAttachment(file, true);
								}, 200);
							}
						},
						Error: function (up, err) {
							alert('Error #' + err.code + ': ' + err.message);
							up.stop();
							up.each(files, function (file) {
								up.removeFile(file);
							});
						}
					}
				});

				uploader.init();

				$(document).on('click', '.email-condition-add:not(.disabled)', function(){
					var self = $(this);
					$.ajax({
						url: 'index.php?option=com_juform&task=form.generateFieldCondition&tmpl=component',
						data: {formId : " . (int) $formId . "},
						beforeSend: function(){
							self.addClass('disabled');
						}
					}).done(function(data) {
						self.next('.email-condition-list').find('.no-conditional-field').remove().end().append(data);
						self.removeClass('disabled');
					});
				});

				$(document).on('change', '.select-field-condition', function(){
					var self = $(this);
					$.ajax({
						url: 'index.php?option=com_juform&task=form.changeConditionField&tmpl=component',
						data: {fieldId : self.val()},
						data: {fieldId : self.val()},
						beforeSend: function(){
							
						}
					}).done(function(data) {
						self.parent().find('.select-field-value').html(data);
						
					});
				});

				$(document).on('click', '.condition-remove', function(){
					$(this).closest('li').remove();
				});
			});
		";
		$document->addScriptDeclaration($script);

		$document->addStyleSheet(JUri::root() . 'components/com_juform/assets/plupload/css/jquery.plupload.queue.css');
		$document->addScript(JUri::root() . "components/com_juform/assets/plupload/js/plupload.full.min.js");
		$document->addScript(JUri::root() . "components/com_juform/assets/plupload/js/jquery.plupload.queue.min.js");
	}


	
	public function saveEmail()
	{
		$app                         = JFactory::getApplication();
		$data                        = array();
		$data['id']                  = $app->input->getInt('id', 0);
		$data['form_id']             = $app->input->getInt('formId', 0);
		$data['subject']             = $app->input->getString('subject', '');
		$data['from']                = $app->input->getString('from', '');
		$data['from_name']           = $app->input->getString('from_name', '');
		$data['recipients']          = $app->input->getString('recipients', '');
		$data['cc']                  = $app->input->getString('cc', '');
		$data['bcc']                 = $app->input->getString('bcc', '');
		$data['reply_to']            = $app->input->getString('reply_to', '');
		$data['reply_to_name']       = $app->input->getString('reply_to_name', '');
		$data['message']             = $app->input->get('message', '', 'raw');
		$data['mode']                = $app->input->getInt('mode', '');
		$data['language']            = $app->input->getString('language', '*');
		$data['published']           = $app->input->getInt('published', '');
		$data['attachments']         = $app->input->get('attachments', array(), 'array');
		$data['send_mail_condition'] = $app->input->getString('send_mail_condition', '&&');
		$data['conditions']          = $app->input->get('conditions', array(), 'array');

		$model = $this->getModel();
		$data  = $model->saveEmail($data);

		JUFormHelper::obCleanData();
		echo $data;
		exit;
	}

	
	public function removeEmail()
	{
		$app     = JFactory::getApplication();
		$emailId = $app->input->getInt('id', 0);
		if ($emailId)
		{
			$model = $this->getModel();
			if ($model->removeEmail($emailId))
			{
				JUFormHelper::obCleanData();
				echo 1;
				exit;
			}
		}
	}

	
	public function saveEmailOrdering()
	{
		$app      = JFactory::getApplication();
		$emailIds = $app->input->getString('emailIds', '');
		if ($emailIds)
		{
			$model    = $this->getModel();
			$emailIds = explode(',', $emailIds);
			if ($model->saveEmailOrdering($emailIds))
			{
				JUFormHelper::obCleanData();
				echo 1;
				exit;
			}
		}
	}

	
	public function addEmailAttachment()
	{
		JUFormHelper::obCleanData();
		JUFormHelper::uploader();
	}

	public function changeEmailPublish()
	{
		$app     = JFactory::getApplication();
		$emailId = $app->input->get('emailId');
		JUFormHelper::obCleanData();
		if ($emailId)
		{
			$model = $this->getModel();
			echo $model->changeEmailPublish($emailId);
		}

		exit;
	}

	
	

	
	

	
	public function removeCalculation()
	{
		$app           = JFactory::getApplication();
		$calculationId = $app->input->getInt('id', 0);
		if ($calculationId)
		{
			$model = $this->getModel();
			if ($model->removeCalculation($calculationId))
			{
				JUFormHelper::obCleanData();
				echo 1;
				exit;
			}
		}
	}

	
	public function saveCalculationOrdering()
	{
		$app            = JFactory::getApplication();
		$calculationIds = $app->input->getString('calculationIds', '');
		if ($calculationIds)
		{
			$model          = $this->getModel();
			$calculationIds = explode(',', $calculationIds);
			if ($model->saveCalculationOrdering($calculationIds))
			{
				JUFormHelper::obCleanData();
				echo 1;
				exit;
			}
		}
	}

	public function save($key = null, $urlVar = null)
	{
		$return = parent::save($key, $urlVar);
		if ($return === true)
		{
			
			$task = $this->getTask();
			if ($task == 'save2new')
			{
				$this->setRedirect(
					JRoute::_(
						'index.php?option=' . $this->option . '&task=form.add', false
					)
				);
			}
		}

		return $return;
	}
}
