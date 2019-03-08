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


class JUFormModelSubmissions extends JModelList
{
	public $fields_use = array();

	
	public function __construct($config = array())
	{
		$app = JFactory::getApplication();
		$list = JFactory::getApplication()->input->get('list', array(), 'array');
		if(isset($list['form_id'])){
			$app->setUserState('com_juform.submissions.form_id', $list['form_id']);
		}
		$form_id = $app->getUserState('com_juform.submissions.form_id');
		if ($form_id && empty($config['ignore_request']))
		{
			
			$fields   = JUFormFrontHelperField::getFields($form_id);
			$fieldIds = array();
			foreach ($fields AS $field)
			{
				if ($field->isBackendListView())
				{
					$fieldIds[]         = $field->id;
					$this->fields_use[] = $field;
				}
			}

			$config['filter_fields'] = array_merge(array('sub.id', 'sub.user_id', 'sub.created'), $fieldIds);
		}

		parent::__construct($config);
	}

	
	protected function populateState($ordering = null, $direction = null)
	{
		$form_id = $this->getUserStateFromRequest($this->context . '.form_id', 'form_id', 0);
		$this->setState('list.form_id', $form_id);

		$state = $this->getUserStateFromRequest($this->context . '.filter.state', 'filter_state');
		$this->setState('filter.state', $state);

		$search = $this->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
		$this->setState('filter.search', $search);


		parent::populateState($ordering, $direction);
	}

	
	protected function getStoreId($id = '')
	{
		
		$id .= ':' . $this->getState('list.form_id');
		$id .= ':' . $this->getState('filter.state');
		$id .= ':' . $this->getState('filter.search');

		return parent::getStoreId($id);
	}

	
	protected function _getListCount($query)
	{
		
		if (!$query)
		{
			return 0;
		}
		else
		{
			if ($query instanceof JDatabaseQuery
				&& $query->type == 'select'
				&& ($query->group !== null || $query->having !== null)
			)
			{
				$query = clone $query;
				$query->clear('select')->clear('order')->select('1');
			}

			return parent::_getListCount($query);
		}
	}

	
	protected function getListQuery()
	{
		$form_id   = $this->state->get('list.form_id');
		$listOrder = $this->state->get('list.ordering');
		$listDirn  = $this->state->get('list.direction');
		$db        = JFactory::getDbo();
		$query     = $db->getQuery(true);
		if ($form_id)
		{
			$query->SELECT('sub.*');
			$query->FROM('#__juform_submissions AS sub');
			$query->JOIN("", "#__juform_forms AS form ON form.id = sub.form_id");
			$query->SELECT('ua.name AS user_name');
			$query->JOIN("LEFT", "#__users AS ua ON ua.id = sub.user_id");
			$query->SELECT('ua1.name AS checked_out_name');
			$query->JOIN('LEFT', '#__users AS ua1 ON ua1.id = sub.checked_out');

			$search = $this->state->get('filter.search');
			if (!empty($search))
			{
				$fields = JUFormFrontHelperField::getFields($form_id);
				if ($fields)
				{
					$where = array();
					foreach ($fields AS $field)
					{
						if ($field->isBackendListView())
						{
							$fieldClass = JUFormFrontHelperField::getField($field);
							$fieldClass->onSimpleSearch($query, $where, $search);
						}
					}

					if (!empty($where))
					{
						$query->WHERE("(" . implode(" OR ", $where) . ")");
					}
				}
			}

			$query->where('form.id = ' . $form_id);

			$hasOrdering = false;
			if ($listOrder)
			{
				if (is_numeric($listOrder))
				{
					$fieldClass = JUFormFrontHelperField::getField($listOrder);
					if ($fieldClass)
					{
						$priority = $fieldClass->orderingPriority($query);
						if ($priority)
						{
							$query->order($priority['ordering'] . ' ' . $listDirn);
							$hasOrdering = true;
						}
					}
				}
				else
				{
					$query->order($listOrder . ' ' . $listDirn);
					$hasOrdering = true;
				}
			}

			if (!$hasOrdering)
			{
				$query->order('sub.created DESC');
			}

			$query->group('sub.id');

			return $query;
		}

		return null;
	}

	public function getItems()
	{
		
		$query = $this->_getListQuery();
		if ($query)
		{
			$items = parent::getItems();
			foreach ($items AS $item)
			{
				$item->actionLink = 'index.php?option=com_juform&task=submission.edit&id=' . $item->id;
				$item->detailLink = 'index.php?option=com_juform&tmpl=component&view=submission&layout=details&id=' . $item->id;
			}

			return $items;
		}
		else
		{
			return array();
		}
	}

}
