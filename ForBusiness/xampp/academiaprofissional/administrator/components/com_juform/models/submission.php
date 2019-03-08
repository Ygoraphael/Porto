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


class JUFormModelSubmission extends JModelAdmin
{
	
	public function getTable($type = 'Submission', $prefix = 'JUFormTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	public function getForm($data = array(), $loadData = true)
	{
		return true;
	}

	
	public function getAutoSuggestValues($fieldString, $string)
	{
		$pattern = "/(fields)\[(.+)\]/";
		preg_match($pattern, $fieldString, $matches);

		
		if (!$matches || !$string)
		{
			return false;
		}

		$fieldId = $matches[2];

		$fieldClass = JUFormFrontHelperField::getField($fieldId);

		return $fieldClass->onAutoSuggest($string);
	}

	
	public function getLastCreateSubmissionTimeOfUser($userId)
	{
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('MAX(created)');
		$query->from('#__juform_submissions');
		$query->where('user_id = ' . $userId);
		$db->setQuery($query);

		return $db->loadResult();
	}

	
	public function save($dataInput)
	{
		$submissionId = $dataInput['data']['id'];
		if($submissionId == 0)
		{
			$db     = JFactory::getDbo();
			$query  = "SELECT COUNT(*) FROM #__juform_submissions";
			$db->setQuery($query);
			if ($db->loadResult() >= (150+150))
			{
				return false;
			}
		}
		
		
		$fieldsData = $dataInput['fieldsData'];
		$data       = $dataInput['data'];
		

		
		$dispatcher = JDispatcher::getInstance();
		$table      = $this->getTable();
		$key        = $table->getKeyName();
		$pk         = (!empty($data[$key])) ? $data[$key] : (int) $this->getState($this->getName() . '.id');
		$isNew      = true;

		
		JPluginHelper::importPlugin('content');

		
		try
		{
			
			if ($pk > 0)
			{
				$table->load($pk);

				
				$isNew = false;
			}

			
			if (!$table->bind($data))
			{
				$this->setError($table->getError());

				return false;
			}

			
			$this->prepareTable($table);

			
			if (!$table->check())
			{
				$this->setError($table->getError());

				return false;
			}

			
			$result = $dispatcher->trigger($this->event_before_save, array($this->option . '.' . $this->name, $table, $isNew));
			if (in_array(false, $result, true))
			{
				$this->setError($table->getError());

				return false;
			}

			
			if (!$table->store())
			{
				$this->setError($table->getError());

				return false;
			}

			
			$this->saveFields($fieldsData, $table, $isNew);

			
			$this->cleanCache();

			
			$dispatcher->trigger($this->event_after_save, array($this->option . '.' . $this->name, $table, $isNew));
		}
		catch (Exception $e)
		{
			$this->setError($e->getMessage());

			return false;
		}

		$pkName = $table->getKeyName();

		if (isset($table->$pkName))
		{
			$this->setState($this->getName() . '.id', $table->$pkName);
		}
		$this->setState($this->getName() . '.new', $isNew);

		$submission = JUFormHelper::getSubmissionById($table->id);

		$app = JFactory::getApplication();
		if ($app->isSite())
		{
			JUFormFrontHelperMail::sendEmail($submission);
		}

		$form = JUFormHelper::getFormById($table->form_id);

		if (!$form->save_submission)
		{
			$table->delete();
		}

		return $submission;
	}

	
	protected function prepareTable($table)
	{
		$date = JFactory::getDate();
		$user = JFactory::getUser();

		if (!$table->id)
		{
			$table->user_id = $user->id;
			$table->created = $date->toSql();

			require_once JPATH_SITE . '/components/com_juform/libs/browser.php';
			$browser           = new Browser();
			$table->user_agent = $browser->getUserAgent();
			
			$table->platform = JUFormFrontHelper::getPlatform($table->user_agent);
			if (!$table->platform)
			{
				$table->platform = $browser->getPlatform();
			}

			$_browser          = array();
			$_browser[]        = $browser->getBrowser();
			$_browser[]        = $browser->getVersion();
			$table->browser    = implode(" ", $_browser);
			$table->ip_address = JUFormFrontHelper::getIpAddress();
		}
		else
		{
			$table->modified    = $date->toSql();
			$table->modified_by = $user->id;
		}
	}

	
	public function saveFields($fieldsData, $table, $isNew)
	{
		$app          = JFactory::getApplication();
		$hiddenFields = $app->input->post->getString('hidden_field', '');
		if ($hiddenFields)
		{
			$hiddenFields = array_filter(array_unique(explode(',', $hiddenFields)));
		}
		else
		{
			$hiddenFields = array();
		}

		$submission = (object) $table->getProperties();
		$fields     = JUFormFrontHelperField::getFields($table->form_id, $submission);
		
		foreach ($fields AS $field)
		{
			if (in_array($field->field_name, $hiddenFields))
			{
				continue;
			}

			
			if ((!$isNew && $field->canEdit()) || ($isNew && $field->canSubmit()))
			{
				$field->fields_data = $fieldsData;
				$fieldValue         = isset($fieldsData[$field->field_name]) ? $fieldsData[$field->field_name] : "";
				
				$field->is_new = $isNew;
				$fieldValue    = $field->onSaveSubmission($fieldValue);
				$field->storeValue($fieldValue);
			}
		}
	}

	
	public function validateFields($fieldsData, $formId, $submissionId = null)
	{
		
		$error  = false;
		$fields = JUFormFrontHelperField::getFields($formId, $submissionId);

		$app          = JFactory::getApplication();
		$hiddenFields = $app->input->post->getString('hidden_field', '');
		if ($hiddenFields)
		{
			$hiddenFields = array_filter(array_unique(explode(',', $hiddenFields)));
		}
		else
		{
			$hiddenFields = array();
		}

		
		foreach ($fields AS $field)
		{
			if (in_array($field->field_name, $hiddenFields))
			{
				continue;
			}

			
			if (($submissionId && $field->canEdit()) || (!$submissionId && $field->canSubmit()))
			{
				$fieldValue         = isset($fieldsData[$field->field_name]) ? $fieldsData[$field->field_name] : null;
				$field->is_new      = true;
				$field->fields_data = $fieldsData;
				$fieldValue         = $field->filterField($fieldValue);
				$valid              = $field->PHPValidate($fieldValue);
				
				if ($valid === true)
				{
					$fieldsData[$field->field_name] = $fieldValue;
				}
				else
				{
					$error = true;
					unset($fieldsData[$field->field_name]);
					$errorMessage = $field->getCaption(true) . ': ' . $valid;
					$this->setError($errorMessage);
				}
			}
		}

		if ($error)
		{
			return false;
		}
		else
		{
			return $fieldsData;
		}
	}

	public function saveOrderingField($fieldOrdering)
	{
		if ($fieldOrdering)
		{
			$fieldTable = JTable::getInstance('Field', 'JUFormTable');
			$ordering   = 1;
			foreach ($fieldOrdering AS $field)
			{
				$fieldTable->reset();
				if ($fieldTable->load($field->fieldId))
				{
					$fieldTable->backend_list_view = $field->state;
					$fieldTable->ordering          = $ordering;
					$fieldTable->store();
					$ordering++;
				}
			}

			return true;
		}

		return false;
	}

	
	public function uploader()
	{
		
		error_reporting(0);

		JLoader::register('PluploadHandler', JPATH_SITE . '/components/com_juform/helpers/pluploadhandler.php');

		
		$targetDir        = JPATH_ROOT . "/media/com_juform/field_attachments/tmp";
		$cleanupTargetDir = true; 
		$maxFileAge       = 5 * 3600; 

		
		$this->cleanup($targetDir, $maxFileAge);

		
		if (!JFolder::exists($targetDir))
		{
			JFolder::create($targetDir);
			$indexHtml = $targetDir . 'index.html';
			$buffer    = "<!DOCTYPE html><title></title>";
			JFile::write($indexHtml, $buffer);
		}

		
		if (!is_writable($targetDir))
		{
			$targetDir = sys_get_temp_dir() . DIRECTORY_SEPARATOR . "plupload";
			

			
			if (!file_exists($targetDir))
			{
				@mkdir($targetDir);
			}
		}

		PluploadHandler::no_cache_headers();
		PluploadHandler::cors_headers();

		if (!PluploadHandler::handle(array(
			'target_dir'    => $targetDir,
			'cleanup'       => $cleanupTargetDir,
			'max_file_age'  => $maxFileAge,
			'cb_check_file' => array(__CLASS__, 'canUpload'),
		))
		)
		{
			die(json_encode(array(
				'OK'    => 0,
				'error' => array(
					'code'    => PluploadHandler::get_error_code(),
					'message' => PluploadHandler::get_error_message()
				)
			)));
		}
		else
		{
			die(json_encode(array('OK' => 1)));
		}
	}

	
	public function isValidUploadURL()
	{
		$app  = JFactory::getApplication();
		$time = $app->input->getInt('time', 0);
		$code = $app->input->get('code', '');

		if (!$time || !$code)
		{
			return false;
		}

		$secret = JFactory::getConfig()->get('secret');
		if ($code != md5($time . $secret))
		{
			return false;
		}

		
		$liveTimeUrl = 60 * 60 * 5;
		if ((time() - $time) > $liveTimeUrl)
		{
			return false;
		}

		return true;
	}

	
	private function cleanup($tmpDir, $maxFileAge = 18000)
	{
		
		if (JFolder::exists($tmpDir))
		{
			foreach (glob($tmpDir . '/*.*') AS $tmpFile)
			{
				if (basename($tmpFile) == 'index.html' || (time() - filemtime($tmpFile) < $maxFileAge))
				{
					continue;
				}

				if (is_dir($tmpFile))
				{
					JFolder::delete($tmpFile);
				}
				else
				{
					JFile::delete($tmpFile);
				}
			}
		}
	}
}
