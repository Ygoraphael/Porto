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


class JUFormModelForm extends JModelAdmin
{
	protected $cache = array();

	
	public function getTable($type = 'Form', $prefix = 'JUFormTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	
	public function getForm($data = array(), $loadData = true)
	{
		
		$form_xml_path = JPATH_COMPONENT . '/models/forms/form.xml';
		$form_xml      = JFactory::getXML($form_xml_path, true);

		$templates = JUFormFrontHelper::getTemplates();
		if ($templates)
		{
			foreach ($templates AS $template)
			{
				$folder   = strtolower(str_replace(' ', '', $template->folder));
				$xml_file = JPATH_SITE . "/components/com_juform/templates/" . $folder . "/" . $folder . '.xml';
				if (JFile::exists($xml_file))
				{
					
					$template_xml = JFactory::getXML($xml_file);
					if ($template_xml->config && $template_xml->config->children())
					{
						$fieldsXml             = new SimpleXMLElement('<fields name="' . $folder . '"></fields>');
						$template_params_xpath = $form_xml->xpath('//fields[@name="template_params"]');

						JUFormHelper::appendXML($template_params_xpath[0], $fieldsXml);
						
						foreach ($template_xml->config->children() AS $child)
						{
							$jplugin_xpath = $form_xml->xpath('//fields[@name="' . $folder . '"]');
							JUFormHelper::appendXML($jplugin_xpath[0], $child);
						}

						
						if ($template_xml->languages->count())
						{
							foreach ($template_xml->languages->children() AS $language)
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

		
		$form = $this->loadForm('com_juform.form', $form_xml->asXML(), array('control' => 'jform', 'load_data' => $loadData));

		if (empty($form))
		{
			return false;
		}

		if ($data)
		{
			$data = (object) $data;
		}
		else
		{
			$data = $this->getItem();
		}

		
		if (!$this->canEditState($data))
		{
			
			
			$form->setFieldAttribute('published', 'disabled', 'true');
			
			
			
			$form->setFieldAttribute('published', 'filter', 'unset');
		}

		return $form;
	}

	
	public function getScript()
	{
		return 'administrator/components/com_juform/models/forms/form.js';
	}

	
	protected function prepareTable($table)
	{
		$date = JFactory::getDate();
		$user = JFactory::getUser();

		

		if (empty($table->id))
		{
			

			
			if (!$table->created)
			{
				$table->created = $date->toSql();
			}

			
			if (!$table->created_by)
			{
				$table->created_by = $user->id;
			}
		}
		else
		{
			$_table = JTable::getInstance('Form', 'JUFormTable');
			if ($_table->load($table->id) && $_table->published != -1)
			{
				
				$table->modified = $date->toSql();

				
				$table->modified_by = $user->id;
			}
		}

		if ($table->published == 1 && intval($table->publish_up) == 0)
		{
			$table->publish_up = $date->toSql();
		}
	}


	
	public function getItem($pk = null)
	{
		$storeId = md5(__METHOD__ . "::" . $pk);
		if (!isset($this->cache[$storeId]))
		{
			$item = parent::getItem($pk);

			if ($item->id)
			{
				
				$registry = new JRegistry;
				$registry->loadString($item->metadata);
				$item->metadata = $registry->toArray();

				
				$registry = new JRegistry;
				$registry->loadString($item->afterprocess_action_value);
				$item->afterprocess_action_value = $registry->toArray();

				
				$registry = new JRegistry;
				$registry->loadString($item->template_params);
				$item->template_params = $registry->toArray();
			}

			$this->cache[$storeId] = $item;
		}

		return $this->cache[$storeId];
	}

	
	protected function loadFormData()
	{
		
		$data = JFactory::getApplication()->getUserState('com_juform.edit.form.data', array());

		if (empty($data))
		{
			$data = $this->getItem();
		}

		$this->preprocessData('com_juform.form', $data);

		return $data;
	}

	
	public function generateTemplate($formId, $templateFolder, $templateParams)
	{
		$fields     = JUFormFrontHelperField::getFields($formId);
		$pages      = JUFormFrontHelperField::getFieldPages($fields);
		$totalPages = 0;

		foreach ($pages AS $page)
		{
			if ($page['beginfield'] || $page['endfield'])
			{
				$totalPages++;
			}
		}

		include_once JPATH_SITE . '/components/com_juform/helpers/generatetemplate.php';

		$layoutClass             = new JUFormGenerateTemplate($templateFolder, $templateParams);
		$layoutClass->fields     = $fields;
		$layoutClass->pages      = $pages;
		$layoutClass->totalPages = $totalPages;

		return $layoutClass->loadTemplate('default.php');
	}

	
	protected function generateNewTitle($category_id, $alias, $title)
	{
		
		$table = $this->getTable();

		while ($table->load(array('alias' => $alias)))
		{
			$title = JString::increment($title);
			$alias = JString::increment($alias, 'dash');
		}

		return array($title, $alias);
	}

	public function save($data)
	{
		$db = JFactory::getDbo();
		$query = "SELECT COUNT(*) FROM #__juform_forms";
		$db->setQuery($query);
		
		$input = JFactory::getApplication()->input;

		if ($input->get('task') == 'save2copy')
		{
			$origTable = clone $this->getTable();
			$origTable->load($input->getInt('id'));

			
			if ($data['title'] == $origTable->title)
			{
				list($title, $alias) = $this->generateNewTitle(null, $data['alias'], $data['title']);
				$data['title'] = $title;
				$data['alias'] = $alias;
			}
			else
			{
				if ($data['alias'] == $origTable->alias)
				{
					$data['alias'] = '';
				}
			}
		}

		if (parent::save($data))
		{
			if ($input->get('task') == 'save2copy')
			{
				$newFormId = $this->getState($this->getName() . '.id');
				$this->copyFields($input->getInt('id'), $newFormId);
				$this->copyEmail($input->getInt('id'), $newFormId);
			}

			$table = $this->getTable();
			$table->reorder();

			return true;
		}

		return false;
	}

	protected function copyFields($origId, $newId)
	{
		$db    = JFactory::getDbo();
		$query = 'SELECT id FROM #__juform_fields WHERE form_id = ' . $origId;
		$db->setQuery($query);

		$fieldIds    = $db->loadColumn();
		$mapFieldIds = array();

		if ($fieldIds)
		{
			$fieldTable = JTable::getInstance('Field', 'JUFormTable');
			foreach ($fieldIds AS $fieldId)
			{
				$fieldTable->reset();
				$fieldTable->load($fieldId);
				$fieldTable->id      = 0;
				$fieldTable->form_id = $newId;

				$fieldTable->store();
				$mapFieldIds[$fieldId] = $fieldTable->id;
			}

			
			$query = 'SELECT id FROM #__juform_fields_actions WHERE field_id IN (' . implode(',', $fieldIds) . ')';
			$db->setQuery($query);

			$actionIds    = $db->loadColumn();
			$mapActionIds = array();
			if ($actionIds)
			{
				$fieldActionTable = JTable::getInstance('FieldAction', 'JUFormTable');
				foreach ($actionIds AS $actionId)
				{
					$fieldActionTable->reset();
					$fieldActionTable->load($actionId);
					$fieldActionTable->id       = 0;
					$fieldActionTable->field_id = $mapFieldIds[$fieldActionTable->field_id];
					$fieldActionTable->store();
					$mapActionIds[$actionId] = $fieldActionTable->id;
				}

				$query = 'SELECT id FROM #__juform_fields_conditions WHERE action_id IN (' . implode(',', $actionIds) . ')';
				$db->setQuery($query);

				$conditionIds = $db->loadColumn();
				if ($conditionIds)
				{
					$fieldConditionTable = JTable::getInstance('FieldCondition', 'JUFormTable');
					foreach ($conditionIds AS $conditionId)
					{
						$fieldConditionTable->reset();
						$fieldConditionTable->load($conditionId);
						$fieldConditionTable->id        = 0;
						$fieldConditionTable->action_id = $mapActionIds[$fieldConditionTable->action_id];
						$fieldConditionTable->field_id  = $mapFieldIds[$fieldConditionTable->field_id];
						$fieldConditionTable->store();
					}
				}
			}

			
			$query = 'SELECT * FROM #__juform_fields_calculations WHERE field_id IN (' . implode(',', $fieldIds) . ') ORDER BY ordering';
			$db->setQuery($query);
			$calculations = $db->loadObjectList();
			if ($calculations)
			{
				$calculationTable = JTable::getInstance('Calculation', 'JUFormTable');
				$ordering         = 1;
				foreach ($calculations AS $calculation)
				{
					$calculation->id       = 0;
					$calculation->form_id  = $newId;
					$calculation->field_id = $mapFieldIds[$calculation->field_id];
					$calculation->ordering = $ordering;
					$ordering++;
					$calculationTable->reset();
					$calculationTable->bind($calculation);
					$calculationTable->store();
				}
			}
		}
	}

	protected function copyEmail($origId, $newId)
	{
		$db    = JFactory::getDbo();
		$query = 'SELECT id FROM #__juform_emails WHERE form_id = ' . $origId;
		$db->setQuery($query);

		$emailIds = $db->loadColumn();
		if ($emailIds)
		{
			$emailTable = JTable::getInstance('Email', 'JUFormTable');
			foreach ($emailIds AS $emailId)
			{
				$emailTable->reset();
				$emailTable->load($emailId);
				$emailTable->id      = 0;
				$emailTable->form_id = $newId;
				$emailTable->store();
			}
		}
	}

	

	
	

	
	public function removeFieldAction($actionId)
	{
		$db    = JFactory::getDbo();
		$query = 'DELETE FROM #__juform_fields_actions WHERE id = ' . $actionId;
		$db->setQuery($query);
		$db->execute();

		$query = 'DELETE FROM #__juform_fields_conditions WHERE action_id = ' . $actionId;
		$db->setQuery($query);
		$db->execute();

		return true;
	}

	
	public function saveFieldActionOrdering($fieldActionIds)
	{
		$db = JFactory::getDbo();

		$ordering = 0;
		foreach ($fieldActionIds AS $fieldActionId)
		{
			$ordering++;
			$query = 'UPDATE #__juform_fields_actions SET ordering = ' . $ordering . ' WHERE id = ' . $fieldActionId;
			$db->setQuery($query);
			$db->execute();
		}

		return true;
	}

	public function changeFieldPublish($fieldId)
	{
		$fieldTable = JTable::getInstance('Field', 'JUFormTable');
		if ($fieldTable->load($fieldId))
		{
			if ($fieldTable->published == 1)
			{
				$fieldTable->published = 0;
			}
			else
			{
				$fieldTable->published = 1;
			}

			$fieldTable->store();

			JHtml::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_juform/helpers/html');

			return JHtml::_('juformadministrator.published', $fieldTable->published, $fieldTable->id, 'fields.', true, 'cb', $fieldTable->publish_up, $fieldTable->publish_down);
		}

		return '';
	}

	
	public function generateEmailCondition($formId, $condition = null)
	{
		$fields = JUFormFrontHelperField::getFields($formId);
		$html   = '';
		$html .= '<li>';
		$fieldOptions = array();
		foreach ($fields AS $field)
		{
			if ($field->folder == 'checkboxes' || $field->folder == 'radio' || $field->folder == 'dropdownlist' || $field->folder == "multipleselect")
			{
				if ($condition)
				{
					if ($condition->field_id == $field->id)
					{
						$fieldValue = $field;
					}
				}
				elseif (!isset($fieldValue))
				{
					$fieldValue = $field;
				}

				$fieldOptions[] = array('value' => $field->id, 'text' => $field->getCaption(true));
			}
		}

		$html .= JHtml::_('select.genericlist', $fieldOptions, 'condition_field_id', 'class="select-field-condition"', 'value', 'text', $fieldValue->id, null);

		$operatorOptions   = array();
		$operatorOptions[] = array('value' => '==', 'text' => JText::_('COM_JUFORM_IS'));
		$operatorOptions[] = array('value' => '!=', 'text' => JText::_('COM_JUFORM_IS_NOT'));

		$default = $condition ? $condition->operator : '==';
		$html .= JHtml::_('select.genericlist', $operatorOptions, 'operator', 'class="select-operator input-small"', 'value', 'text', $default, null);

		$valueOptions = array();
		if ($fieldValue)
		{
			$valueOptions = (array) $fieldValue->getPredefinedValues();
		}

		$default = $condition ? $condition->value : '';
		$html .= JHtml::_('select.genericlist', $valueOptions, 'field_value', 'class="select-field-value"', 'value', 'text', $default, null);
		$html .= '<input type="hidden" class="condition-id" value="' . ($condition ? $condition->id : 0) . '">';
		$html .= ' <button type="button" class="condition-remove btn btn-small btn-danger">' . JText::_('COM_JUFORM_REMOVE') . '</button>';
		$html .= '</li>';

		return $html;
	}

	
	public function saveEmail($data)
	{
		JTable::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_juform/tables');
		$emailTable     = JTable::getInstance('Email', 'JUFormTable');
		$emailConditionTable = JTable::getInstance('EmailCondition', 'JUFormTable');
		$oldAttachments = array();
		if ($data['id'])
		{
			if (!$emailTable->load($data['id']))
			{
				return false;
			}

			if ($emailTable->attachments)
			{
				$attachments = json_decode($emailTable->attachments);
				foreach ($attachments AS $attachment)
				{
					$oldAttachments[$attachment->id] = $attachment;
				}
			}
		}

		$attachments         = $data['attachments'];
		$data['attachments'] = '';
		$data['ordering']    = $emailTable->getNextOrder('form_id = ' . (int) $data['form_id']);
		$emailTable->bind($data);

		$emailTable->store();

		$emailId = $emailTable->id;

		$attach_dir           = JPATH_ROOT . "/media/com_juform/email_attachments/" . $emailId . "/";
		$attach_dir_tmp       = JPATH_ROOT . "/media/com_juform/tmp/";
		$data['attachments']  = array();
		$keepOldAttachmentIds = array();
		if ($attachments)
		{
			if (!JFolder::exists($attach_dir))
			{
				JFolder::create($attach_dir);
				$file_index = $attach_dir . 'index.html';
				$buffer     = "<!DOCTYPE html><title></title>";
				JFile::write($file_index, $buffer);
			}

			foreach ($attachments AS $attachment)
			{
				if ($attachment['id'] !== '0')
				{
					$keepOldAttachmentIds[] = $attachment['id'];
					$data['attachments'][]  = $oldAttachments[$attachment['id']];
				}
				else
				{
					if (isset($attachment['target']))
					{
						$fileInfo = pathinfo($attachment['name']);
						do
						{
							$newFileTarget = md5($attachment['name'] . JUFormHelper::generateRandomString(10)) . "." . $fileInfo['extension'];
							$dest          = $attach_dir . $newFileTarget;
						} while (JFile::exists($dest));

						if (JFile::move($attach_dir_tmp . $attachment['target'], $dest))
						{
							$data['attachments'][] = array(
								'id'     => JUFormHelper::generateRandomString(8),
								'name'   => $attachment['name'],
								'target' => $newFileTarget
							);
						}
					}
				}
			}
		}

		if ($oldAttachments)
		{
			foreach ($oldAttachments AS $oldAttachment)
			{
				if (!in_array($oldAttachment->id, $keepOldAttachmentIds))
				{
					$filePath = $attach_dir . $oldAttachment->target;
					if (JFile::exists($filePath))
					{
						JFile::delete($filePath);
					}
				}
			}
		}

		$emailTable->attachments = json_encode($data['attachments']);
		$emailTable->store();

		$oldConditionIds       = array();
		$oldConditions         = JUFormFrontHelper::getEmailConditions($emailId);
		$removeOldConditionIds = array();

		$conditions = $data['conditions'];

		foreach ($conditions AS $condition)
		{
			$conditionData = array();
			$emailConditionTable->reset();
			if ($condition['id'])
			{
				if (!$emailConditionTable->load($condition['id']))
				{
					continue;
				}

				$oldConditionIds[] = $condition['id'];
			}
			else
			{
				$conditionData['id'] = 0;
			}

			if(!$condition['fieldId'])
			{
				continue;
			}

			$conditionData['email_id']  = $emailId;
			$conditionData['field_id']  = $condition['fieldId'];
			$conditionData['operator']  = $condition['operator'];
			$conditionData['value']     = $condition['value'];

			$emailConditionTable->bind($conditionData);
			$emailConditionTable->store();
		}

		foreach ($oldConditions AS $condition)
		{
			if (!in_array($condition->id, $oldConditionIds))
			{
				$removeOldConditionIds[] = $condition->id;
			}
		}

		if ($removeOldConditionIds)
		{
			$db    = JFactory::getDbo();
			$query = 'DELETE FROM #__juform_emails_conditions WHERE id IN(' . implode(',', $removeOldConditionIds) . ')';
			$db->setQuery($query);
			$db->execute();
		}

		$html = '<tr id="email-' . $emailTable->id . '">';
		$html .= '<td class="hidden-phone">';
		$html .= '<i class="icon-menu"></i>';
		$html .= '</td>';
		$html .= '<td>';
		$html .= $emailTable->subject;
		$html .= '</td>';
		$html .= '<td>';
		$html .= $emailTable->from;
		$html .= '</td>';
		$html .= '<td>';
		$html .= $emailTable->recipients;
		$html .= '</td>';
		$html .= '<td class="center">';
		if ($emailTable->published)
		{
			$html .= '<a href="#" class="btn btn-micro active hasTooltip" onclick="changeEmailPublish(this, \'' . $emailTable->id . '\'); return false;"><i class="icon-publish"></i></a>';
		}
		else
		{
			$html .= '<a href="#" class="btn btn-micro active hasTooltip" onclick="changeEmailPublish(this, \'' . $emailTable->id . '\'); return false;"><i class="icon-unpublish"></i></a>';
		}
		$html .= '</td>';
		$html .= '<td class="center">';
		$html .= '<a class="btn btn-small email-edit" href="index.php?option=com_juform&task=form.generateFormEmail&formId=' . (int) $data['form_id'] . '&emailId=' . (int) $emailTable->id . '&tmpl=component" data-fancybox-type="iframe">' . JText::_('COM_JUFORM_EDIT') . '</a>';
		$html .= ' <button type="button" class="btn btn-small btn-danger email-remove">' . JText::_('COM_JUFORM_REMOVE') . '</button>';
		$html .= '</td>';
		$html .= '<tr>';

		return $html;
	}

	
	public function removeEmail($emailId)
	{
		$db    = JFactory::getDbo();
		$query = 'DELETE FROM #__juform_emails WHERE id = ' . $emailId;
		$db->setQuery($query);
		$db->execute();

		$query = 'DELETE FROM #__juform_emails_conditions WHERE email_id = ' . $emailId;
		$db->setQuery($query);
		$db->execute();

		return true;
	}

	
	public function saveEmailOrdering($emailIds)
	{
		$db = JFactory::getDbo();

		$ordering = 0;
		foreach ($emailIds AS $emailId)
		{
			$ordering++;
			$query = 'UPDATE #__juform_emails SET ordering = ' . $ordering . ' WHERE id = ' . $emailId;
			$db->setQuery($query);
			$db->execute();
		}

		return true;
	}

	public function changeEmailPublish($emailId)
	{
		$emailTable = JTable::getInstance('Email', 'JUFormTable');
		if ($emailTable->load($emailId))
		{
			if ($emailTable->published == 1)
			{
				$emailTable->published = 0;
			}
			else
			{
				$emailTable->published = 1;
			}

			$emailTable->store();

			return $emailTable->published;
		}

		return '';
	}


	
	

	
	public function removeCalculation($calculationId)
	{
		$db    = JFactory::getDbo();
		$query = 'DELETE FROM #__juform_fields_calculations WHERE id = ' . $calculationId;
		$db->setQuery($query);
		$db->execute();

		return true;
	}

	
	public function saveCalculationOrdering($calculationIds)
	{
		$db = JFactory::getDbo();

		$ordering = 0;
		foreach ($calculationIds AS $calculationId)
		{
			$ordering++;
			$query = 'UPDATE #__juform_fields_calculations SET ordering = ' . $ordering . ' WHERE id = ' . $calculationId;
			$db->setQuery($query);
			$db->execute();
		}

		return true;
	}

}
