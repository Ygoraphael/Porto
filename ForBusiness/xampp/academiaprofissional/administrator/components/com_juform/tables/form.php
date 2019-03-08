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


class JUFormTableForm extends JTable
{
	
	public function __construct(&$db)
	{
		parent::__construct('#__juform_forms', 'id', $db);
	}


	
	public function check()
	{

		if (trim($this->alias) == '')
		{
			$this->alias = $this->title;
		}

		$this->alias = JApplicationHelper::stringURLSafe($this->alias);

		if (trim(str_replace('-', '', $this->alias)) == '')
		{
			$this->alias = JFactory::getDate()->format('Y-m-d-H-i-s');
		}

		
		
		if (!empty($this->metakeyword))
		{
			
			$bad_characters = array("\n", "\r", "\"", "<", ">"); 
			$after_clean    = JString::str_ireplace($bad_characters, "", $this->metakeyword); 
			$keys           = explode(',', $after_clean); 
			$clean_keys     = array();

			foreach ($keys AS $key)
			{
				if (trim($key))
				{
					
					$clean_keys[] = trim($key);
				}
			}
			$this->metakeyword = implode(", ", $clean_keys); 
		}

		return true;
	}

	
	public function bind($array, $ignore = array())
	{
		
		if (isset($array['metadata']) && is_array($array['metadata']))
		{
			$registry = new JRegistry;
			$registry->loadArray($array['metadata']);
			$array['metadata'] = (string) $registry;
		}

		
		if (isset($array['afterprocess_action_value']) && is_array($array['afterprocess_action_value']))
		{
			$registry = new JRegistry;
			$registry->loadArray($array['afterprocess_action_value']);
			$array['afterprocess_action_value'] = (string) $registry;
		}

		
		if (isset($array['params']) && is_array($array['params']))
		{
			$registry = new JRegistry;
			$registry->loadArray($array['params']);
			$array['params'] = (string) $registry;
		}

		
		if (isset($array['template_params']) && is_array($array['template_params']))
		{
			$registry = new JRegistry;
			$registry->loadArray($array['template_params']);
			$array['template_params'] = (string) $registry;
		}

		return parent::bind($array, $ignore);
	}

	public function store($updateNulls = false)
	{
		
		$table = JTable::getInstance('Form', 'JUFormTable');

		if ($table->load(array('alias' => $this->alias)) && ($table->id != $this->id || $this->id == 0))
		{
			$this->setError(JText::_('JLIB_DATABASE_ERROR_ARTICLE_UNIQUE_ALIAS'));

			return false;
		}

		return parent::store($updateNulls);
	}

	public function delete($pk = null)
	{
		if (parent::delete($pk))
		{
			$db    = JFactory::getDbo();
			$query = 'SELECT id FROM #__juform_fields WHERE form_id = ' . $this->id;
			$db->setQuery($query);
			$fieldIds = $db->loadColumn();

			if ($fieldIds)
			{
				$fieldTable = JTable::getInstance('Field', 'JUFormTable');
				foreach ($fieldIds as $fieldId)
				{
					$fieldTable->delete($fieldId);
				}

				$query = 'DELETE FROM #__juform_emails WHERE form_id = ' . $this->id;
				$db->setQuery($query);
				$db->execute();
			}

			return true;
		}

		return false;
	}


}
