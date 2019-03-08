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


class JUFormModelMenuitems extends JModelList
{
	
	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
				'mei.id',
				'mei.title',
				'mei.language',
				'mei.access',
				'mei.menutype'
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

		$language = $this->getUserStateFromRequest($this->context . '.filter.language', 'filter_language');
		$this->setState('filter.language', $language);

		$menutype = $this->getUserStateFromRequest($this->context . '.filter.menutype', 'filter_menutype');
		$this->setState('filter.menutype', $menutype);

		parent::populateState($ordering, $direction);
	}

	
	protected function getListQuery()
	{
		$listOrder = $this->state->get('list.ordering');
		$listDirn  = $this->state->get('list.direction');
		$search    = $this->state->get('filter.search');

		$db    = $this->getDBO();
		$query = $db->getQuery(true);
		$query->SELECT('mei.*');
		$query->FROM('#__menu AS mei');

		$query->SELECT('met.title AS menutype_title');
		$query->JOIN('LEFT', '#__menu_types AS met ON met.menutype = mei.menutype');

		$query->SELECT('vl.title AS access_level');
		$query->JOIN('LEFT', '#__viewlevels AS vl ON vl.id = mei.access');

		$query->SELECT('lag.title AS language_title');
		$query->JOIN('LEFT', '#__languages AS lag ON lag.lang_code = mei.language');

		
		$access = $this->getState('filter.access');
		if ($access)
		{
			$query->where('mei.access = ' . (int) $access);
		}

		
		$language = $this->getState('filter.language', '');
		if ($language !== '' && $language != '*')
		{
			$query->where('mei.language = ' . $db->quote($language));
		}

		
		$menutype = $this->getState('filter.menutype', '');
		if ($menutype !== '')
		{
			$query->where('mei.menutype = ' . $db->quote($menutype));
		}

		
		if (!empty($search))
		{
			if (stripos($search, 'id:') === 0)
			{
				$query->where('mei.id = ' . (int) substr($search, 3));
			}
			else
			{
				$search = $db->Quote('%' . $db->escape($search, true) . '%');
				$query->where('mei.title LIKE ' . $search);
			}
		}

		$query->where('mei.published = 1');

		$query->where('mei.id > 1');

		if ($listOrder != '')
		{
			$query->order($db->escape($listOrder . ' ' . $listDirn));
		}

		return $query;
	}

	public function getMenutypes()
	{
		$db    = JFactory::getDbo();
		$query = 'SELECT menutype AS value, title AS text FROM #__menu_types';
		$db->setQuery($query);

		return $db->loadObjectList();
	}
}
