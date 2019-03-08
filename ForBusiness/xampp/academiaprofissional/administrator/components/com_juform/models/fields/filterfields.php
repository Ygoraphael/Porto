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

JFormHelper::loadFieldClass('list');

class JFormFieldFilterFields extends JFormFieldList
{
	
	protected $type = 'filterfields';

	
	protected function getOptions()
	{
		$form_id = $this->form->getValue('form_id', 'list');
		$options = array();
		if ($form_id)
		{
			
			$fields   = JUFormFrontHelperField::getFields($form_id);
			foreach ($fields AS $field)
			{
				if ($field->isBackendListView())
				{
					$options[] = array('value' => $field->id.' ASC', 'text' => $field->caption.' ascending');
					$options[] = array('value' => $field->id.' DESC', 'text' => $field->caption.' descending');
				}
			}
		}

		
		$options = array_merge(parent::getOptions(), $options);

		return $options;
	}


}
