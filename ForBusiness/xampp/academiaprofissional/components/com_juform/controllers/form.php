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
	
	protected $context = 'submission';

	
	protected $view_item = 'form';

	
	protected $view_list = 'form';

	
	protected $text_prefix = 'COM_JUFORM_SUBMISSION';

	protected $formMessage = null;

	
	public function getModel($name = 'Form', $prefix = 'JUFormModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);

		return $model;
	}

	
	public function autoSuggest()
	{
		$app = JFactory::getApplication();

		$field  = $app->input->get('field', '', 'string');
		$string = $app->input->get('string', '', 'string');
		$model  = $this->getModel();
		$result = $model->getAutoSuggestValues($field, $string);
		if ($result === false)
		{
			exit;
		}

		JUFormHelper::obCleanData();
		echo json_encode($result);
		exit;
	}

	
	protected function allowAdd($data = array())
	{
		$user    = JFactory::getUser();
		$form_id = $data['form_id'];
		$form    = JUFormFrontHelperForm::getForm($form_id);
		if (!$form)
		{
			return false;
		}

		if (!in_array($form->access, $user->getAuthorisedViewLevels()))
		{
			return false;
		}

		return true;
	}

	
	protected function allowEdit($data = array(), $key = 'id')
	{
		return false;
	}

	
	public function save($key = null, $urlVar = null)
	{
		$db = JFactory::getDbo();
		$query = "SELECT COUNT(*) FROM #__juform_submissions";
		$db->setQuery($query);
		if($db->loadResult() >= (440-140))
		{
			return false;
		}
		
		
		JSession::checkToken() or die(JText::_('JINVALID_TOKEN'));

		JTable::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_juform/tables');

		
		$app   = JFactory::getApplication();
		$model = $this->getModel();
		$table = $model->getTable();

		$data['id']   = 0;
		$this->formId = $data['form_id'] = $recordId = $app->input->post->getInt('form_id', 0);
		$form         = JUFormHelper::getFormById($data['form_id']);

		
		if (trim($form->php_onbeforeprocess))
		{
			eval($form->php_onbeforeprocess);
		}

		$checkin         = property_exists($table, 'checked_out');
		$this->returnUrl = $app->input->get('return', null, 'base64');
		$this->formType  = $app->input->get('formType', 'component', 'string');

		$urlVar = 'id';

		$fieldsData = $app->input->post->get('fields', array(), 'array');
		$context    = "com_juform." . $this->formType . '.fieldsdata.' . $this->formId;
		
		if (!$this->allowSave($data, $key))
		{
			$this->setFormMessage(JText::_('JLIB_APPLICATION_ERROR_SAVE_NOT_PERMITTED'), 'danger', JText::_('ERROR'));
			$this->setRedirect(
				JRoute::_(
					'index.php?option=' . $this->option . '&view=' . $this->view_item
					. $this->getRedirectToItemAppend($recordId, $urlVar), false
				)
			);

			return false;
		}

		
		$validFieldsData = $model->validateFields($fieldsData, $data['form_id']);

		
		if ($validFieldsData === false)
		{
			
			$errors = $model->getErrors();

			
			for ($i = 0, $n = count($errors); $i < $n && $i < 3; $i++)
			{
				if ($errors[$i] instanceof Exception)
				{
					$this->setFormMessage($errors[$i]->getMessage(), 'warning', JText::_('NOTICE'));
				}
				else
				{
					$this->setFormMessage($errors[$i], 'warning', JText::_('NOTICE'));
				}
			}
			
			$app->setUserState($context, $fieldsData);

			
			$url = JRoute::_(
				$this->returnUrl ?
					base64_decode($this->returnUrl) :
					'index.php?option=' . $this->option . '&view=' . $this->view_item
					. $this->getRedirectToItemAppend($recordId, $urlVar)
				, false);

			$this->setRedirect($url);

			return false;
		}

		$validData = array();
		
		$validData['data'] = $data;
		
		$validData['fieldsData'] = $validFieldsData;

		$submission = $model->save($validData);

		
		if (!$submission)
		{
			
			$app->setUserState($context, $fieldsData);

			
			$this->setFormMessage(JText::sprintf('JLIB_APPLICATION_ERROR_SAVE_FAILED', $model->getError()), 'danger', JText::_('ERROR'));
			$this->setRedirect(
				JRoute::_(
					'index.php?option=' . $this->option . '&view=' . $this->view_item
					. $this->getRedirectToItemAppend($recordId, $urlVar), false
				)
			);

			return false;
		}

		if ($form->save_submission)
		{
			
			if ($checkin && isset($data[$key]) && $model->checkin($data[$key]) === false)
			{
				
				$app->setUserState($context, $fieldsData);

				
				$this->setFormMessage(JText::sprintf('JLIB_APPLICATION_ERROR_CHECKIN_FAILED', $model->getError()), 'danger', JText::_('ERROR'));
				$this->setRedirect(
					JRoute::_(
						'index.php?option=' . $this->option . '&view=' . $this->view_item
						. $this->getRedirectToItemAppend($recordId, $urlVar), false
					)
				);

				return false;
			}

			$this->holdEditId($context, $recordId);
			$model->checkout($recordId);

			
			$this->postSaveHook($model, $validData);
		}

		$app->setUserState($context, null);

		
		if (trim($form->php_onprocess))
		{
			eval($form->php_onprocess);
		}

		
		if ($form->post_to_location && trim($form->post_url) != '' && trim($form->post_url) != 'http://')
		{
			
			
			$data = array();
			foreach ($_POST['fields'] as $key => $value)
			{
				if (is_array($value))
				{
					foreach ($value as $subkey => $subvalue)
					{
						$data[] = urlencode($key) . '[]=' . urlencode($subvalue);
					}
				}
				else
				{
					$data[] = urlencode($key) . '=' . urlencode($value);
				}
			}

			
			if ($form->silent_post)
			{
				$data   = implode('&', $data);
				$params = array(
					'method' => strtoupper($form->post_method) == 'POST' ? 'POST' : 'GET'
				);

				JUFormFrontHelper::silentPost($form->post_url, $data, $params);
			}
			else
			{
				
				if (strtoupper($form->post_method) == 'POST')
				{
					@ob_end_clean();

					
					$output   = array();
					$output[] = '<form id="formSubmit" method="POST" action="' . htmlentities($form->post_url, ENT_COMPAT, 'UTF-8') . '">';
					foreach ($_POST['fields'] as $key => $value)
					{
						if (is_array($value))
						{
							foreach ($value as $subkey => $subvalue)
							{
								$output[] = '<input type="hidden" name="' . htmlentities($key, ENT_COMPAT, 'UTF-8') . '[]" value="' . htmlentities($subvalue, ENT_COMPAT, 'UTF-8') . '" />';
							}
						}
						else
						{
							$output[] = '<input type="hidden" name="' . htmlentities($key, ENT_COMPAT, 'UTF-8') . '" value="' . htmlentities($value, ENT_COMPAT, 'UTF-8') . '" />';
						}
					}
					$output[] = '</form>';
					$output[] = '<script type="text/javascript">';
					$output[] = 'function formSubmit() { if (typeof document.getElementById("formSubmit").submit == "function") { document.getElementById("formSubmit").submit(); } else { document.createElement("form").submit.call(document.getElementById("formSubmit")); } }';
					$output[] = 'try { window.addEventListener ? window.addEventListener("load",formSubmit,false) : window.attachEvent("onload",formSubmit); }';
					$output[] = 'catch (err) { formSubmit(); }';
					$output[] = '</script>';

					
					echo implode("\r\n", $output);
					die();
				}
				
				else
				{
					$data = implode('&', $data);
					$this->setRedirect($form->post_url . (strpos($form->post_url, '?') === false ? '?' : '&') . $data);

					return true;
				}
			}
		}

		$action_type = $form->afterprocess_action;
		if ($action_type != 'none' && $form->afterprocess_action_value)
		{
			$action_values = new JRegistry($form->afterprocess_action_value);

			
			
			
			$message = JUFormFrontHelperMail::replaceTags($action_values->get('custom_message', ''), $form, $submission);

			switch ($action_type)
			{
				case 'redirect_url':
					if($action_values->get('redirect_url.url'))
					{
						if (!$action_values->get('redirect_url.show_message', 0))
						{
							$message = null;
						}

						$this->setRedirect($action_values->get('redirect_url.url'), $message);

						return true;
					}

					break;

				case 'redirect_menu':
					$menuItem = JUFormFrontHelper::getMenuItem($action_values->get('redirect_menu.id'));

					if($menuItem)
					{
						if (!$action_values->get('redirect_menu.show_message', 0))
						{
							$message = null;
						}

						$this->setRedirect(JRoute::_($menuItem->link, false), $message);

						return true;
					}

					break;

				case 'custom_message':
					$this->setFormMessage($message);
					break;
			}
		}

		
		$url = JRoute::_(
			$this->returnUrl ?
				base64_decode($this->returnUrl) :
				'index.php?option=' . $this->option . '&view=' . $this->view_item
				. $this->getRedirectToItemAppend($recordId, $urlVar)
			, false);

		$this->setRedirect($url);

		return true;
	}

	protected function setFormMessage($message, $type = 'success', $label = '')
	{
		if ($message)
		{
			if (is_null($this->formMessage))
			{
				$formMessage           = new stdClass();
				$formMessage->label    = '';
				$formMessage->type     = '';
				$formMessage->messages = array();
				$this->formMessage     = $formMessage;
			}

			if ($label == '')
			{
				$label = JText::_('MESSAGE');
			}

			$app                           = JFactory::getApplication();
			$this->formMessage->label      = $label;
			$this->formMessage->type       = $type;
			$this->formMessage->messages[] = $message;
			$app->setUserState('com_juform.' . $this->formType . '.message.' . $this->formId, $this->formMessage);
		}
	}

	
	protected function getRedirectToItemAppend($recordId = null, $urlVar = 'id')
	{
		$tmpl   = $this->input->get('tmpl');
		$layout = $this->input->get('layout', '', 'string');
		$append = '';

		
		if ($tmpl)
		{
			$append .= '&tmpl=' . $tmpl;
		}

		if ($layout)
		{
			$append .= '&layout=' . $layout;
		}

		if ($recordId)
		{
			$append .= '&' . $urlVar . '=' . $recordId;
		}

		return $append;
	}

	
	public function uploader()
	{
		$model = $this->getModel();
		if (!$model->isValidUploadURL())
		{
			die(json_encode(array(
				'OK'    => 0,
				'error' => array(
					'code'    => -1,
					'message' => JText::_('COM_JUFORM_YOU_ARE_NOT_AUTHORIZED_TO_UPLOAD_FILE')
				)
			)));
		}

		JUFormHelper::obCleanData();
		$model->uploader();
	}

	
	public function removeTmpFile()
	{
		$model = $this->getModel();
		if (!$model->isValidUploadURL())
		{
			die(json_encode(array(
				'OK'    => 0,
				'error' => array(
					'code'    => -1,
					'message' => JText::_('COM_JUFORM_YOU_ARE_NOT_AUTHORIZED_TO_UPLOAD_FILE')
				)
			)));
		}

		JUFormHelper::obCleanData();
		$app    = JFactory::getApplication();
		$target = $app->input->getString('target', '');
		if ($target)
		{
			$filePath = JPath::clean(JPATH_SITE . '/media/com_juform/field_attachments/tmp/' . $target);
			if (JFile::exists($filePath))
			{
				JFile::delete($filePath);
				echo 1;
				exit;
			}
		}
		echo 0;
		exit;
	}
} 
