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

class JUFormFrontHelperField
{
	
	public static $cache = array();

	
	public static function getFieldById($fieldId, $fieldObj = null, $resetCache = false)
	{
		
		$storeId = md5(__METHOD__ . "::$fieldId");

		if (!isset(self::$cache[$storeId]) || $resetCache)
		{
			if (!is_object($fieldObj))
			{
				$db    = JFactory::getDbo();
				$query = $db->getQuery(true);
				$query->select('field.*, p.folder')
					->from('#__juform_fields AS field')
					->join('LEFT', '#__juform_plugins AS p ON p.id = field.plugin_id');

				if (is_numeric($fieldId))
				{
					$query->where('field.id = ' . $fieldId);
				}

				$db->setQuery($query);

				$fieldObj = $db->loadObject();
			}

			self::$cache[$storeId] = $fieldObj;
		}

		return self::$cache[$storeId];
	}

	
	public static function getFieldByFieldName($fieldName, $formId, $resetCache = false)
	{
		
		$storeId = md5(__METHOD__ . "::$fieldName::$formId");

		if (!isset(self::$cache[$storeId]) || $resetCache)
		{
			$db    = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('field.*, p.folder')
				->from('#__juform_fields AS field')
				->join('LEFT', '#__juform_plugins AS p ON p.id = field.plugin_id')
				->where('field.field_name = ' . $db->quote($fieldName))
				->where('field.form_id = ' . $db->quote($formId));

			$db->setQuery($query);

			$fieldObj = $db->loadObject();

			self::$cache[$storeId] = $fieldObj;
		}

		return self::$cache[$storeId];
	}

	
	public static function getField($field, $submission = null, $resetFormCache = false)
	{
		if (!$field)
		{
			return null;
		}

		if (is_object($field))
		{
			$fieldId = $field->id;
		}
		else
		{
			$fieldId = $field;
		}

		
		$storeId = md5("JUFMField::" . $fieldId);
		if (!isset(self::$cache['fields'][$storeId]))
		{
			
			if (!is_object($field))
			{
				$field = self::getFieldById($field);
			}

			if ($field)
			{
				if (!isset($field->folder) || !$field->folder)
				{
					if ($field->plugin_id)
					{
						$plugin = JUFormHelper::getPluginById($field->plugin_id);
						if ($plugin)
						{
							$field->folder = $plugin->folder;
						}
					}
					else
					{
						$field->folder = 'Base';
					}
				}

				

				$fieldClassName = 'JUFormField' . $field->folder;

				$_fieldObj = clone $field;
			}
			else
			{
				$fieldClassName = 'JUFormFieldError';
				$_fieldObj      = $fieldId;
			}

			$fieldClass = null;
			if (class_exists($fieldClassName))
			{
				$fieldClass = new $fieldClassName($_fieldObj);
			}

			self::$cache['fields'][$storeId] = $fieldClass;
		}

		
		$fieldClass = self::$cache['fields'][$storeId];
		if ($fieldClass)
		{
			$fieldClassWithSubmission = clone $fieldClass;
			$fieldClassWithSubmission->loadSubmission($submission, $resetFormCache);

			return $fieldClassWithSubmission;
		}
		else
		{
			return $fieldClass;
		}
	}

	
	public static function getFields($formId, $submission = null, $view = null, $includedOnlyFields = array(), $ignoredFields = array(), $additionFields = array())
	{
		$user        = JFactory::getUser();
		$accessLevel = implode(',', $user->getAuthorisedViewLevels());
		$date        = JFactory::getDate();
		$db          = JFactory::getDbo();

		if (!$formId)
		{
			return false;
		}

		$fieldsStoreId = md5(__METHOD__ . "::fieldsObj::$formId::" . serialize($submission) . "::$view::" . "::" . serialize($includedOnlyFields) . serialize($ignoredFields) . "::" . serialize($additionFields));
		if (!isset(self::$cache[$fieldsStoreId]))
		{
			$query = $db->getQuery(true);
			$query->select("field.*, plg.folder");
			$query->from("#__juform_fields AS field");
			$query->join("", "#__juform_plugins AS plg ON (field.plugin_id = plg.id)");
			
			$nullDate = $db->quote($db->getNullDate());
			$nowDate  = $db->quote($date->toSql());
			$query->where('field.published = 1');
			$query->where('field.publish_up <= ' . $nowDate);
			$query->where('(field.publish_down = ' . $nullDate . ' OR field.publish_down > ' . $nowDate . ')');

			$query->where('field.access IN (' . $accessLevel . ')');
			$query->where('field.form_id = ' . (int) $formId);

			
			$additionFieldsStr = "";
			if ($additionFields)
			{
				$additionFieldsStr = " OR field.id IN (" . implode(",", $additionFields) . ")";
			}

			
			if ($view == 1)
			{
				$query->where("(field.list_view = 1" . $additionFieldsStr . ")");
			}
			elseif ($view == 2)
			{
				$query->where("(field.details_view = 1" . $additionFieldsStr . ")");
			}

			
			if ($ignoredFields)
			{
				$query->where("field.field_name NOT IN ('" . implode("','", $ignoredFields) . "')");
			}

			
			if ($includedOnlyFields)
			{
				$query->where("field.field_name IN ('" . implode("','", $includedOnlyFields) . "')");
			}

			$query->group('field.id');
			$query->order("field.ordering");
			$db->setQuery($query);

			$fields = $db->loadObjectList();

			
			$newFields = array();
			foreach ($fields AS $key => $field)
			{
				
				if (isset($field->ordering) && is_null($field->ordering))
				{
					$newFields[] = $field;
					unset($fields[$key]);
				}
			}
			
			if (!empty($newFields))
			{
				$fields = array_merge($fields, $newFields);
			}

			self::$cache[$fieldsStoreId] = $fields;
		}
		$fields = self::$cache[$fieldsStoreId];

		
		if (!$fields)
		{
			return false;
		}

		
		if (is_numeric($submission))
		{
			$submission = JUFormHelper::getSubmissionById($submission);
		}

		$fieldObjectList = array();
		if (count($fields))
		{
			foreach ($fields AS $_field)
			{
				$field                       = clone $_field;
				$fieldObjectList[$field->id] = self::getField($field, $submission);

				unset($field);
			}
		}

		return $fieldObjectList;
	}

	
	public static function getFieldsByFormId($form_id, $checkPermission = false, $condition = '', $ordering = 'field.ordering')
	{
		if (!$form_id)
		{
			return array();
		}

		$fieldsStoreId = md5(__METHOD__ . "::$condition::$ordering");
		if (!isset(self::$cache[$fieldsStoreId]))
		{
			$db       = JFactory::getDbo();
			$nullDate = $db->getNullDate();
			$nowDate  = JFactory::getDate()->toSql();
			$query    = $db->getQuery(true);
			$query->select("field.*, plg.folder");
			$query->from("#__juform_fields AS field");
			$query->join("", "#__juform_forms AS form ON (form.id = field.form_id)");
			$query->join("", "#__juform_plugins AS plg ON plg.id = field.plugin_id");
			$query->where("form.id = " . $form_id);
			if ($condition)
			{
				$query->where($condition);
			}

			if ($checkPermission)
			{
				$query->where("field.published > 0");
				$query->where('field.publish_up <= ' . $db->quote($nowDate));
				$query->where('(field.publish_down = ' . $db->quote($nullDate) . ' OR field.publish_down > ' . $db->quote($nowDate) . ')');
			}

			$query->group('field.id');
			if ($ordering)
			{
				$query->order($ordering);
			}

			$db->setQuery($query);

			self::$cache[$fieldsStoreId] = $db->loadObjectList();
		}

		return self::$cache[$fieldsStoreId];
	}

	public static function getFieldPages($fields)
	{
		$pageFields = array();
		if (!$fields)
		{
			return $pageFields;
		}
		$page  = 0;
		$state = 'end';

		$i = 0;
		foreach ($fields AS $field)
		{
			
			if (!isset($pageFields[$page]))
			{
				$pageFields[$page] = array('fields' => array(), 'beginfield' => null, 'endfield' => null);
			}

			if ($field->folder == 'beginpage')
			{
				
				if ($state == 'begin' || count($pageFields[$page]['fields']))
				{
					$page++;
				}

				$pageFields[$page]['beginfield'] = $field;
				$state                           = 'begin';
			}
			elseif ($field->folder == 'endpage')
			{
				$pageFields[$page]['endfield'] = $field;
				$state                         = 'end';
				$page++;
			}
			else
			{
				$pageFields[$page]['fields'][] = $field;
			}

			$i++;
		}

		return $pageFields;
	}
}