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

class JFormFieldForms extends JFormFieldList
{
	
	protected $type = 'forms';

	
	protected function getOptions()
	{
		
		$db = JFactory::getDbo();

		$query = $db->getQuery(true);
		$query->select('id AS value, title AS text');
		$query->from('#__juform_forms');
		$query->where('published != -1');
		$query->order('title ASC');

		
		$db->setQuery($query);
		$options = $db->loadObjectList();

		
		$options = array_merge(parent::getOptions(), $options);

		return $options;
	}
}
