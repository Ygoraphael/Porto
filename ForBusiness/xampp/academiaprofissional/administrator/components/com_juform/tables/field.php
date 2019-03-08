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


class JUFormTableField extends JTable
{
	
	public function __construct(&$db)
	{
		parent::__construct('#__juform_fields', 'id', $db);
	}

	

	public function bind($array, $ignore = array())
	{
		if (isset($array['metadata']) && is_array($array['metadata']))
		{
			$registry = new JRegistry;
			$registry->loadArray($array['metadata']);
			$array['metadata'] = (string) $registry;
		}

		return parent::bind($array, $ignore);
	}

	
	public function delete($pk = null)
	{
		
		$k  = $this->_tbl_key;
		$pk = (is_null($pk)) ? $this->$k : $pk;

		$this->load($pk);

		$pk = (is_null($pk)) ? $this->id : $pk;
		$db = JFactory::getDbo();

		
		$fieldClass = JUFormFrontHelperField::getField($pk);
		$fieldClass->onDelete(true);

		
		$query = 'DELETE FROM #__juform_fields_values WHERE field_id = ' . $pk;
		$db->setQuery($query);
		$db->execute();

		$query = 'DELETE FROM #__juform_fields_actions WHERE field_id = ' . $pk;
		$db->setQuery($query);
		$db->execute();

		$query = 'DELETE FROM #__juform_fields_conditions WHERE field_id = ' . $pk;
		$db->setQuery($query);
		$db->execute();

		$query = 'DELETE FROM #__juform_emails_conditions WHERE field_id = ' . $pk;
		$db->setQuery($query);
		$db->execute();

		$query = 'DELETE FROM #__juform_fields_calculations WHERE field_id = ' . $pk;
		$db->setQuery($query);
		$db->execute();

		return parent::delete($pk);
	}

	
	public function check()
	{
		if (trim($this->caption) == '')
		{
			$this->setError(JText::_('COM_JUFORM_TITLE_MUST_NOT_BE_EMPTY'));

			return false;
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

	public function store($updateNulls = false)
	{
		
		$table = JTable::getInstance('Field', 'JUFormTable');

		if ($table->load(array('field_name' => $this->field_name, 'form_id' => $this->form_id)) && ($table->id != $this->id || $this->id == 0))
		{
			$this->setError(JText::_('COM_JUFORM_FIELD_NAME_MUST_BE_UNIQUE'));

			return false;
		}

		return parent::store($updateNulls);
	}

}
