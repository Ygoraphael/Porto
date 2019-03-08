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


jimport('joomla.application.component.modellist');


class JUFormModelForms extends JModelList
{
	
	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
				'form.id',
				'form.title',
				'form.created_by',
				'form.created',
				'form.access',
				'form.hits',
				'form.published',
				'form.ordering'
			);
		}

		parent::__construct($config);
	}

	
	protected function populateState($ordering = null, $direction = null)
	{
		$app = JFactory::getApplication();

		
		if ($layout = $app->input->get('layout'))
		{
			$this->context .= '.' . $layout;
		}

		$search = $this->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

		$access = $this->getUserStateFromRequest($this->context . '.filter.access', 'filter_access');
		$this->setState('filter.access', $access);

		$published = $this->getUserStateFromRequest($this->context . '.filter.published', 'filter_published');
		$this->setState('filter.published', $published);

		parent::populateState($ordering, $direction);
	}

	
	protected function getListQuery()
	{
		$listOrder = $this->state->get('list.ordering');
		$listDirn  = $this->state->get('list.direction');
		$search    = $this->state->get('filter.search');

		$db    = $this->getDBO();
		$query = $db->getQuery(true);
		$query->SELECT('form.*');
		$query->FROM('#__juform_forms AS form');

		$query->SELECT('ua.name AS checked_out_name');
		$query->JOIN('LEFT', '#__users AS ua ON ua.id = form.checked_out');

		$query->SELECT('ua1.name AS created_by');
		$query->JOIN('LEFT', '#__users AS ua1 ON ua1.id = form.created_by');

		
		$query->SELECT('vl.title AS access_level');
		$query->JOIN('LEFT', '#__viewlevels AS vl ON vl.id = form.access');

		$query->WHERE('form.published != -1');

		
		$access = $this->getState('filter.access');
		if ($access)
		{
			$query->where('form.access = ' . (int) $access);
		}

		
		$published = $this->getState('filter.published', '');
		if ($published !== '')
		{
			$query->where('form.published = ' . (int) $published);
		}

		
		if (!empty($search))
		{
			if (stripos($search, 'id:') === 0)
			{
				$query->where('form.id = ' . (int) substr($search, 3));
			}
			elseif (stripos($search, 'created_by:') === 0)
			{
				$search = substr($search, 11);
				if (is_numeric($search))
				{
					$query->where('form.created_by = 0 OR form.created_by IS NULL');
				}
				else
				{
					$search = $db->Quote('%' . $db->escape($search, true) . '%');
					$query->where('(ua.name LIKE ' . $search . ' OR ua.username LIKE ' . $search . ')');
				}
			}
			else
			{
				$search = $db->Quote('%' . $db->escape($search, true) . '%');
				$query->where('form.title LIKE ' . $search);
			}
		}

		if ($listOrder != '')
		{
			$query->order($db->escape($listOrder . ' ' . $listDirn));
		}

		return $query;
	}

}
