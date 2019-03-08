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

jimport('joomla.application.component.helper');
jimport('joomla.filesystem.file');

abstract class JUFormHelperRoute
{
	protected static $lookup;

	protected static $cache = array();

	
	public static function getFormRoute($formId, $layout = '')
	{
		
		$link = 'index.php?option=com_juform&view=form&id=' . $formId;

		if ($layout && $layout != 'default')
		{
			$link .= '&layout=' . $layout;
		}

		$itemId = JUFormHelperRoute::findItemId(array('form' => array($formId)));

		if ($itemId)
		{
			$link .= '&Itemid=' . $itemId;
		}

		return $link;
	}

	
	public static function findItemId($needles = null, $acceptNotFound = false)
	{
		$app  = JFactory::getApplication();
		$menu = $app->getMenu('site');

		if (!empty($needles))
		{
			foreach ($needles AS $view => $ids)
			{
				if (!isset(self::$lookup[$view]))
				{
					$component  = JComponentHelper::getComponent('com_juform');
					$attributes = array('component_id');
					$values     = array($component->id);

					$items = $menu->getItems($attributes, $values);

					foreach ($items AS $item)
					{
						if (isset($item->query) && isset($item->query['view']) && $item->query['view'] == $view)
						{
							if (!isset(self::$lookup[$item->query['view']]))
							{
								self::$lookup[$item->query['view']] = array();
							}

							if (isset($item->query['id']))
							{
								if (!isset(self::$lookup[$item->query['view']][$item->query['id']]))
								{
									self::$lookup[$item->query['view']][$item->query['id']] = $item->id;
								}
							}
						}
					}
				}

				foreach ($ids AS $id)
				{
					if (isset(self::$lookup[$view][$id]))
					{
						return self::$lookup[$view][$id];
					}
				}
			}
		}

		if ($acceptNotFound)
		{
			return false;
		}

		
		return null;
	}

	
	public static function getJUFormMenuItems()
	{
		$app       = JFactory::getApplication('site');
		$menus     = $app->getMenu();
		$component = JComponentHelper::getComponent('com_juform');
		$menuItems = $menus->getItems('component_id', $component->id);

		return $menuItems;
	}

	
	public static function getActiveMenuItemIdOfJUForm()
	{
		$app   = JFactory::getApplication();
		$menus = $app->getMenu('site');

		
		$activeMenu = $menus->getActive();

		if ($activeMenu && $activeMenu->component == 'com_juform')
		{
			return $activeMenu->id;
		}

		$homeMenuItemId = JUFormHelperRoute::getHomeMenuItemId();

		if ($homeMenuItemId)
		{
			return $homeMenuItemId;
		}

		return false;
	}

	
	public static function getHomeMenuItemId()
	{
		$storeId = md5(__METHOD__);
		if (!isset(self::$cache[$storeId]))
		{
			
			$db    = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id');
			$query->from('#__menu');
			$query->where('home = 1');
			$db->setQuery($query);

			self::$cache[$storeId] = (int) $db->loadResult();
		}

		return self::$cache[$storeId];
	}

	public static function parseLayout($layout, &$vars, $params)
	{
		$isLayout = preg_match('/^' . preg_quote(JApplicationHelper::stringURLSafe($params->get('sef_layout', 'layout')) . '-') . '/', $layout);
		if ($isLayout)
		{
			$vars['layout'] = substr($layout, strlen(JApplicationHelper::stringURLSafe($params->get('sef_layout', 'layout')) . '-'));

			return true;
		}

		return false;
	}

	
	public static function isLayout($viewName, $layoutName)
	{
		$viewPath         = JPath::clean(JPATH_SITE . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'com_juform' . DIRECTORY_SEPARATOR . 'views');
		$specificViewPath = JPath::clean($viewPath . DIRECTORY_SEPARATOR . $viewName);
		$layoutPath       = JPath::clean($specificViewPath . DIRECTORY_SEPARATOR . 'tmpl');
		$layoutFilePath   = JPath::clean($layoutPath . $layoutName . '.xml');
		if (JFile::exists($layoutFilePath))
		{
			return true;
		}

		return false;
	}
}