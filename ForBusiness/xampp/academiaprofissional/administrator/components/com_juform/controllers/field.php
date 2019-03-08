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


class JUFormControllerField extends JControllerForm
{

	
	protected $text_prefix = 'COM_JUFORM_FIELD';

	
	public function save($key = null, $urlVar = null)
	{
		$db = JFactory::getDbo();
		$app = JFactory::getApplication();
		$jform = $app->input->get('jform', array(), 'array');
		$formId = $jform['form_id'];
		$query = "SELECT COUNT(*) FROM #__juform_fields WHERE form_id = " . $formId;
		$db->setQuery($query);
		if($db->loadResult() >= 8)
		{
			$respond['success'] = 0;
			$respond['message'] = 'Yo' . 'ur fo' . 'rm rea' . 'ch ma' . 'x 8 f' . 'ield' . 's per f' . 'orm';
			JUFormHelper::obCleanData();
			echo json_encode($respond);
			exit;
		}
		
		
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		$app     = JFactory::getApplication();
		$model   = $this->getModel();
		$table   = $model->getTable();
		$data    = $this->input->post->get('jform', array(), 'array');
		$checkin = property_exists($table, 'checked_out');
		$context = "$this->option.edit.$this->context";
		$respond = array();

		
		if (empty($key))
		{
			$key = $table->getKeyName();
		}

		
		if (empty($urlVar))
		{
			$urlVar = $key;
		}

		$recordId = $this->input->getInt($urlVar);

		
		$data[$key] = $recordId;

		
		if (!$this->allowSave($data, $key))
		{
			$this->setError(JText::_('JLIB_APPLICATION_ERROR_SAVE_NOT_PERMITTED'));
			$respond['success'] = 0;
			$respond['message'] = $this->getError();
			JUFormHelper::obCleanData();
			echo json_encode($respond);
			exit;
		}

		
		
		$form = $model->getForm($data, false);

		if (!$form)
		{
			$respond['success'] = 0;
			$respond['message'] = $model->getError();
			JUFormHelper::obCleanData();
			echo json_encode($respond);
			exit;
		}

		
		$validData = $model->validate($form, $data);

		
		if ($validData === false)
		{
			
			$errors       = $model->getErrors();
			$messageError = array();
			
			for ($i = 0, $n = count($errors); $i < $n && $i < 3; $i++)
			{
				if ($errors[$i] instanceof Exception)
				{
					$messageError[] = $errors[$i]->getMessage();
				}
				else
				{
					$messageError[] = $errors[$i];
				}
			}

			
			$app->setUserState($context . '.data', $data);

			$respond['success'] = 0;
			$respond['message'] = implode("<br/>", $messageError);
			JUFormHelper::obCleanData();
			echo json_encode($respond);
			exit;
		}

		
		$data = $model->save($validData);
		if (!$data)
		{
			
			$app->setUserState($context . '.data', $validData);

			
			$this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_SAVE_FAILED', $model->getError()));
			$respond['success'] = 0;
			$respond['message'] = $this->getError();
			JUFormHelper::obCleanData();
			echo json_encode($respond);
			exit;
		}

		
		if ($checkin && $model->checkin($validData[$key]) === false)
		{
			
			$app->setUserState($context . '.data', $validData);

			
			$this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_CHECKIN_FAILED', $model->getError()));
			$respond['success'] = 0;
			$respond['message'] = $this->getError();
			JUFormHelper::obCleanData();
			echo json_encode($respond);
			exit;
		}

		$recordId = $model->getState($this->context . '.id');
		$this->holdEditId($context, $recordId);
		$app->setUserState($context . '.data', null);
		$model->checkout($recordId);

		
		$this->postSaveHook($model, $validData);

		$data  = JUFormFrontHelperField::getFieldById($data->id, $data->getProperties(), true);
		$field = JUFormFrontHelperField::getField($data);
		if ($field)
		{
			$fieldData              = array();
			$fieldData['id']        = $data->id;
			$fieldData['plugin_id'] = $data->plugin_id;
			JHtml::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_juform/helpers/html');
			$fieldData['published']  = JHtml::_('juformadministrator.published', $data->published, $data->id, 'fields.', true, 'cb', $data->publish_up, $data->publish_down);
			$fieldData['folder']     = $field->folder;
			$fieldData['caption']    = $field->getCaption(true);
			$fieldData['field_name'] = $field->field_name;
			$fieldData['preview']    = $field->getPreview();
			$required                = $field->isRequired();
			$fieldData['required']   = $required === null ? 'unset' : ($required === true ? 1 : 0);
			$hide                    = $field->isHide();
			$fieldData['hide']       = $hide === null ? 'unset' : ($hide === true ? 1 : 0);

			$respond['success'] = 1;
			$respond['field']   = $fieldData;
			JUFormHelper::obCleanData();
			echo json_encode($respond);
			exit;
		}

		exit;
	}

	
	protected function allowAdd($data = array())
	{
		$user = JFactory::getUser();

		return $user->authorise('core.create', 'com_juform');
	}

	
	protected function allowEdit($data = array(), $key = 'id')
	{
		$recordId = (int) isset($data[$key]) ? $data[$key] : 0;
		$user     = JFactory::getUser();
		$userId   = $user->get('id');
		$asset    = 'com_juform.field.' . $recordId;

		
		if ($user->authorise('core.edit', $asset))
		{
			return true;
		}

		
		
		if ($user->authorise('core.edit.own', $asset))
		{
			
			$ownerId = (int) isset($data['created_by']) ? $data['created_by'] : 0;
			if (empty($ownerId) && $recordId)
			{
				
				$record = $this->getModel()->getItem($recordId);

				if (empty($record))
				{
					return false;
				}

				$ownerId = $record->created_by;
			}

			
			if ($ownerId == $userId)
			{
				return true;
			}
		}

		
		return parent::allowEdit($data, $key);
	}

	public function fastAddOptions()
	{
		$app      = JFactory::getApplication();
		$postData = $app->input->post->get("data", '', 'raw');
		$postData = str_replace(array("\r\n", "\r"), array("\\n", "\\n"), $postData);
		JUFormHelper::obCleanData();
		if ($postData)
		{
			$data = array();

			
			if (!is_null(json_decode($postData)))
			{
				$jsonData = json_decode($postData);
				if (is_array($jsonData) || is_object($jsonData))
				{
					foreach ($jsonData AS $option)
					{
						if (is_object($option))
						{
							$option = get_object_vars($option);
						}

						if (is_array($option))
						{
							$optionArray    = array();
							$option         = array_values($option);
							$optionArray[0] = $option[0];
							$optionArray[1] = $option[1];
							$data[]         = $optionArray;
						}
					}
				}
			}
			
			else
			{
				$delimiter    = $app->input->getWord("delimiter", ",");
				$enclosure    = $app->input->getWord("enclosure", '"');
				$csvDataArray = explode("\n", $postData);
				if ($csvDataArray)
				{
					foreach ($csvDataArray AS $csvData)
					{
						$csvArray           = str_getcsv($csvData, $delimiter, $enclosure);
						$data[$csvArray[0]] = $csvArray;
					}
				}
			}

			if ($data)
			{
				echo json_encode(array_values($data));
			}
			else
			{
				echo '0';
			}
			exit;
		}

		echo '0';
		exit;
	}

	public function testPhpCode()
	{
		
		JSession::checkToken() or die(JText::_('JINVALID_TOKEN'));

		$app       = JFactory::getApplication();
		$field_id  = $app->input->post->getInt('field_id', 0);
		$plugin_id = $app->input->post->getInt('plugin_id', 0);

		$php_code = $app->input->post->get('php_predefined_values', '', 'raw');

		if (trim($php_code))
		{
			
			if ($plugin_id)
			{
				$db    = JFactory::getDbo();
				$query = "SELECT folder FROM #__juform_plugins WHERE id = " . $plugin_id;
				$db->setQuery($query);
				$folder = $db->loadResult();

				$fieldClassName = 'JUFormField' . $folder;
				if ($field_id)
				{
					$fieldObj = new $fieldClassName($field_id);
				}
				else
				{
					$fieldObj = new $fieldClassName();
				}
			}
			
			else
			{
				echo 'No plugin selected';
				exit;
			}

			$fieldObj->php_predefined_values = $php_code;

			JUFormHelper::obCleanData(true);
			
			$result = $fieldObj->getPredefinedFunction();
			echo '<div class="return">';
			var_dump($result);
			echo '</div>';
		}

		exit;
	}

	public function changeValue()
	{
		
		JSession::checkToken() or die(JText::_('JINVALID_TOKEN'));

		
		$app    = JFactory::getApplication();
		$id     = $app->input->getInt('fieldId', 0);
		$column = $app->input->get('column', '');
		if (!$id || !$column)
		{
			die();
		}

		$model  = $this->getModel();
		$result = $model->changeValue($id, $column);
		JUFormHelper::obCleanData();
		if ($result)
		{
			echo $result;
		}

		exit;
	}

	
	public function remove()
	{
		
		JSession::checkToken() or die(JText::_('JINVALID_TOKEN'));

		
		$app   = JFactory::getApplication();
		$id    = $app->input->getInt('fieldId', 0);
		if (!$id)
		{
			exit;
		}

		$model  = $this->getModel();
		$result = $model->remove($id);
		JUFormHelper::obCleanData();
		if ($result)
		{
			echo 1;
		}

		exit;
	}

	
	public function duplicate()
	{
		$db = JFactory::getDbo();
		$app = JFactory::getApplication();
		$fieldId  = $app->input->getInt('fieldId', 0);
		$query = "SELECT form_id FROM #__juform_fields WHERE id = " . $fieldId;
		$db->setQuery($query);
		$formId = $db->loadResult();
		$query = "SELECT COUNT(*) FROM #__juform_fields WHERE form_id = " . $formId;
		$db->setQuery($query);
		if($db->loadResult() >= 8)
		{
			$result['success'] = 0;
			$result['field']   = array();
			echo json_encode($result);
			exit;
		}
		
		
		JSession::checkToken() or die(JText::_('JINVALID_TOKEN'));

		
		$app = JFactory::getApplication();
		$id  = $app->input->getInt('fieldId', 0);
		if (!$id)
		{
			exit;
		}

		$model  = $this->getModel();
		$result = $model->duplicate($id);
		JUFormHelper::obCleanData();
		if ($result)
		{
			echo json_encode($result);
			exit;
		}

		exit;
	}

	public function ordering()
	{
		
		JSession::checkToken() or die(JText::_('JINVALID_TOKEN'));

		
		$app  = JFactory::getApplication();
		$ids  = $app->input->getString('fieldIds', '');
		$type = $app->input->get('type', '');
		if (!$ids || !$type)
		{
			die();
		}

		$ids = explode(',', $ids);
		if (count($ids) < 2)
		{
			die();
		}

		$model  = $this->getModel();
		$result = $model->ordering($ids, $type);
		JUFormHelper::obCleanData();
		if ($result)
		{
			echo 1;
		}

		exit;
	}

	public function getOrdering()
	{
		
		JSession::checkToken() or die(JText::_('JINVALID_TOKEN'));

		
		$app     = JFactory::getApplication();
		$form_id = $app->input->get('form_id', 0);
		$type    = $app->input->get('type', '');
		if (!$form_id || !$type)
		{
			die();
		}

		$model    = $this->getModel();
		$fieldIds = $model->getOrdering($form_id, $type);
		JUFormHelper::obCleanData();
		if ($fieldIds)
		{
			echo implode(',', $fieldIds);
		}

		exit;
	}
}
