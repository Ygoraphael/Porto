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


jimport('joomla.application.component.modeladmin');


class JUFormModelField extends JModelAdmin
{

	
	public function getTable($type = 'Field', $prefix = 'JUFormTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	
	public function getForm($data = array(), $loadData = true)
	{
		
		if ($data)
		{
			$data = (object) $data;
		}
		else
		{
			$data = $this->getItem();
		}

		
		$field_xml_path = JPATH_COMPONENT . '/models/forms/field.xml';
		$field_xml      = JFactory::getXML($field_xml_path, true);

		
		if ($data->plugin_id)
		{
			$db    = JFactory::getDbo();
			$query = 'SELECT folder, type' .
				' FROM #__juform_plugins' .
				' WHERE (id = ' . $data->plugin_id . ')';
			$db->setQuery($query);
			$pluginObj = $db->loadObject();

			if ($pluginObj && $pluginObj->folder)
			{
				$folder   = strtolower(str_replace(' ', '', $pluginObj->folder));
				$xml_file = JPATH_SITE . "/components/com_juform/fields/" . $folder . "/" . $folder . '.xml';

				if (JFile::exists($xml_file))
				{
					
					$field_plugin_xml = JFactory::getXML($xml_file);
					if ($field_plugin_xml->config)
					{
						
						foreach ($field_plugin_xml->config->children() AS $child)
						{
							$field_params_xpath = $field_xml->xpath('//fields[@name="params"]');
							JUFormHelper::appendXML($field_params_xpath[0], $child);
						}

						
						if ($field_plugin_xml->languages->count())
						{
							foreach ($field_plugin_xml->languages->children() AS $language)
							{
								$languageFile = (string) $language;
								
								$first_pos       = strpos($languageFile, '.');
								$last_pos        = strrpos($languageFile, '.');
								$languageExtName = substr($languageFile, $first_pos + 1, $last_pos - $first_pos - 1);

								
								$client = JApplicationHelper::getClientInfo((string) $language->attributes()->client, true);
								$path   = isset($client->path) ? $client->path : JPATH_BASE;

								JUFormFrontHelperLanguage::loadLanguageFile($languageExtName, $path);
							}
						}
					}
				}
			}
		}

		
		$form = $this->loadForm('com_juform.field', $field_xml->asXML(), array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form))
		{
			return false;
		}

		$ignored_options = explode(",", $data->ignored_options);
		foreach ($ignored_options AS $ignored_option)
		{
			$form->setFieldAttribute($ignored_option, 'disabled', 'true');
			$form->setFieldAttribute($ignored_option, 'filter', 'unset');
		}

		
		if (!$this->canEditState($data))
		{
			
			$form->setFieldAttribute('ordering', 'disabled', 'true');
			$form->setFieldAttribute('published', 'disabled', 'true');
			
			
			$form->setFieldAttribute('ordering', 'filter', 'unset');
			$form->setFieldAttribute('published', 'filter', 'unset');
		}

		return $form;
	}

	
	public function getScript()
	{
		return 'administrator/components/com_juform/models/forms/field.js';
	}

	
	protected function loadFormData()
	{
		
		$data = JFactory::getApplication()->getUserState('com_juform.edit.field.data', array());
		if (empty($data))
		{
			$data = $this->getItem();
		}

		$this->preprocessData('com_juform.field', $data);

		return $data;
	}

	
	public function getItem($pk = null)
	{
		$item = parent::getItem($pk);
		if (!$item->id)
		{
			$app             = JFactory::getApplication();
			$item->id        = 0;
			$item->plugin_id = $app->input->get('plugin_id', 0);
			$item->form_id   = $app->input->get('form_id', 0);
		}

		return $item;
	}

	
	protected function getReorderConditions($table)
	{
		$condition   = array();
		$condition[] = 'group_id = ' . (int) $table->group_id;

		return $condition;
	}

	
	protected function prepareTable($table)
	{
		$date = JFactory::getDate();

		if ($table->published == 1 && intval($table->publish_up) == 0)
		{
			$table->publish_up = JFactory::getDate()->toSql();
		}

		if (empty($table->id))
		{
			if (!$table->created)
			{
				$table->created = $date->toSql();
			}

			
			$db = JFactory::getDbo();
			$db->setQuery('SELECT MAX(ordering) FROM #__juform_fields WHERE form_id =' . (int) $table->form_id);
			$max             = (int) $db->loadResult();
			$table->ordering = $max + 1;

			$table->backend_list_view_ordering = $max + 1;
		}

	}

	
	public function save($data)
	{
		$db = JFactory::getDbo();
		$formId = $data['form_id'];
		$query = "SELECT COUNT(*) FROM #__juform_fields WHERE form_id = " . $formId;
		$db->setQuery($query);
		if($db->loadResult() >= 8)
		{
			return false;
		}
		
		$app            = JFactory::getApplication();
		$jform          = $app->input->post->get('jform', array(), 'array');
		$data['params'] = isset($jform['params']) ? $jform['params'] : null;

		
		$field = JUFormFrontHelperField::getField((object) $data);
		if ($field)
		{
			$data           = $field->onSave($data);
			$data['params'] = json_encode($data['params']);
		}
		
		else
		{
			$data['params'] = "";
		}


		
		$dispatcher = JEventDispatcher::getInstance();
		$table      = $this->getTable();

		if ((!empty($data['tags']) && $data['tags'][0] != ''))
		{
			$table->newTags = $data['tags'];
		}

		$key   = $table->getKeyName();
		$pk    = (!empty($data[$key])) ? $data[$key] : (int) $this->getState($this->getName() . '.id');
		$isNew = true;

		
		JPluginHelper::importPlugin('content');

		
		try
		{
			
			if ($pk > 0)
			{
				$table->load($pk);
				$isNew = false;
			}

			$oldFieldName = false;
			if (!$isNew && $data['field_name'] != $table->field_name)
			{
				$oldFieldName = $table->field_name;
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

			if ($oldFieldName)
			{
				
				$formTable = JTable::getInstance('Form', 'JUFormTable');
				$formTable->load($table->form_id);
				$formTable->afterprocess_action_value = str_replace('{' . $oldFieldName . '}', '{' . $table->field_name . '}', $formTable->afterprocess_action_value);
				$formTable->check();
				$formTable->store();

				
				$emails = JUFormFrontHelper::getEmails($table->form_id);
				if ($emails)
				{
					$emailTable = JTable::getInstance('Email', 'JUFormTable');
					foreach ($emails AS $email)
					{
						foreach ($email AS $property => $value)
						{
							$email->$property = str_replace('{' . $oldFieldName . '}', '{' . $table->field_name . '}', $value);
						}

						$emailTable->reset();
						$emailTable->bind($email);
						$emailTable->store();
					}
				}

				
				$calculations = JUFormFrontHelper::getFieldCalculations($table->form_id);
				if ($calculations)
				{
					$calculationTable = JTable::getInstance('Calculation', 'JUFormTable');
					foreach ($calculations AS $calculation)
					{
						$calculation->expression = str_replace('{' . $oldFieldName . '}', '{' . $table->field_name . '}', $calculation->expression);
						$calculationTable->reset();
						$calculationTable->bind($calculation);
						$calculationTable->store();
					}
				}
			}

			
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

		return $table;
	}

	
	public function changeValue(&$pk, $column)
	{
		$table = $this->getTable();
		$db    = $this->getDbo();
		if ($table->load($pk))
		{
			if (!$this->checkout())
			{
				return false;
			}

			$value = $table->$column;
			if ($value == 1)
			{
				$updateValue = 0;
			}
			else
			{
				$updateValue = 1;
			}

			$query = "UPDATE #__juform_fields SET " . $db->quoteName($column) . " = " . $updateValue . " WHERE id = " . $pk;
			$db->setQuery($query);

			if ($db->execute())
			{
				return $updateValue;
			}
		}

		return false;
	}

	
	public function remove($id)
	{
		$table = $this->getTable();
		if ($table->load($id))
		{
			if ($table->delete())
			{
				return true;
			}
		}

		return false;
	}

	
	protected function generateNewTitle($form_id, $field_name, $caption)
	{
		
		$table = $this->getTable();

		while ($table->load(array('field_name' => $field_name, 'form_id' => $form_id)))
		{
			$caption    = JString::increment($caption);
			$field_name = str_replace("-", "_", JString::increment($field_name, 'dash'));
		}

		return array($caption, $field_name);
	}

	
	public function duplicate($id)
	{
		$table = $this->getTable();
		if ($table->load($id))
		{
			$db = JFactory::getDbo();
			$formId = $table->form_id;
			$query  = "SELECT COUNT(*) FROM #__juform_fields WHERE form_id = " . $formId;
			$db->setQuery($query);
			if ($db->loadResult() >= 8)
			{
				$respond['success'] = 0;
				$respond['field']   = array();
				echo json_encode($respond);
				exit;
			}
		}
		
		$table = $this->getTable();
		if ($table->load($id))
		{
			list($caption, $field_name) = $this->generateNewTitle($table->form_id, $table->field_name, $table->caption);
			$table->caption    = $caption;
			$table->field_name = $field_name;
			$table->ordering   = $table->getNextOrder('form_id = ' . $table->form_id);
			$table->id         = 0;
			if ($table->store())
			{
				$data                   = JUFormFrontHelperField::getFieldById($table->id, $table->getProperties(), true);
				$field                  = JUFormFrontHelperField::getField($data);
				$fieldData              = array();
				$fieldData['id']        = $data->id;
				$fieldData['plugin_id'] = $data->plugin_id;
				JHtml::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_juform/helpers/html');
				$fieldData['published']         = JHtml::_('juformadministrator.published', $data->published, $data->id, 'fields.', true, 'cb', $data->publish_up, $data->publish_down);
				$fieldData['folder']            = $field->folder;
				$fieldData['caption']           = $field->getCaption();
				$fieldData['field_name']        = $field->field_name;
				$fieldData['preview']           = $field->getPreview();
				$required                       = $field->isRequired();
				$fieldData['required']          = $required === null ? 'unset' : ($required === true ? 1 : 0);
				$blv                            = $field->isBackendListView();
				$fieldData['backend_list_view'] = $blv === null ? 'unset' : ($blv === true ? 1 : 0);

				$respond['success'] = 1;
				$respond['field']   = $fieldData;

				return $respond;
			}
		}

		return false;
	}


	
	public function ordering($ids, $type = 'ordering')
	{
		$table    = $this->getTable();
		$ordering = 1;
		foreach ($ids AS $id)
		{
			if ($table->load($id))
			{
				$table->$type = $ordering;
				$table->store();
				$ordering++;
			}
		}

		return true;
	}

	
	public function getOrdering($form_id, $type)
	{
		$db    = JFactory::getDbo();
		$query = 'SELECT id FROM #__juform_fields WHERE form_id = ' . (int) $form_id . ' ORDER BY ' . $db->quoteName($type);
		$db->setQuery($query);

		return $db->loadColumn();
	}
}
