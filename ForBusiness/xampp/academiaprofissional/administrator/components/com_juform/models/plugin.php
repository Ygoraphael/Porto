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

class JUFormModelPlugin extends JModelAdmin
{
	
	public function getTable($type = 'Plugin', $prefix = 'JUFormTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	
	public function getForm($data = array(), $loadData = true)
	{
		
		$form = $this->loadForm('com_juform.plugin', 'plugin', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form))
		{
			return false;
		}

		return $form;
	}

	
	public function getScript()
	{
		return 'administrator/components/com_juform/models/forms/plugin.js';
	}

	
	protected function loadFormData()
	{
		
		$data = JFactory::getApplication()->getUserState('com_juform.edit.plugin.data', array());

		if (empty($data))
		{
			$data = $this->getItem();
		}

		$this->preprocessData('com_juform.plugin', $data);

		return $data;
	}
}