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


JLoader::register('JUFormFrontHelper', JPATH_SITE . '/components/com_juform/helpers/helper.php');
JLoader::register('JUFormFrontHelperBreadcrumb', JPATH_SITE . '/components/com_juform/helpers/breadcrumb.php');
JLoader::register('JUFormFrontHelperForm', JPATH_SITE . '/components/com_juform/helpers/form.php');
JLoader::register('JUFormFrontHelperField', JPATH_SITE . '/components/com_juform/helpers/field.php');
JLoader::register('JUFormFrontHelperLanguage', JPATH_SITE . '/components/com_juform/helpers/language.php');
JLoader::register('JUFormFrontHelperLog', JPATH_SITE . '/components/com_juform/helpers/log.php');
JLoader::register('JUFormFrontHelperMail', JPATH_SITE . '/components/com_juform/helpers/mail.php');
JLoader::register('JUFormFrontHelperModerator', JPATH_SITE . '/components/com_juform/helpers/moderator.php');
JLoader::register('JUFormFrontHelperString', JPATH_SITE . '/components/com_juform/helpers/string.php');
JLoader::register('JUFormHelper', JPATH_ADMINISTRATOR . '/components/com_juform/helpers/juform.php');
JLoader::register('JUFormHelperRoute', JPATH_SITE . '/components/com_juform/helpers/route.php');


if (!class_exists('JComponentRouterBase'))
{
	
	abstract class JComponentRouterBase
	{
		
		public function preprocess($query)
		{
			return $query;
		}
	}
}


class JUFormRouter extends JComponentRouterBase
{
	
	public function build(&$query)
	{
		$segments = array();

		
		$app      = JFactory::getApplication();
		$menu     = $app->getMenu();
		$params   = JComponentHelper::getParams('com_content');
		$advanced = $params->get('sef_advanced_link', 0);

		
		if (empty($query['Itemid']))
		{
			$menuItem      = $menu->getActive();
			$menuItemGiven = false;
		}
		else
		{
			$menuItem      = $menu->getItem($query['Itemid']);
			$menuItemGiven = true;
		}

		
		if ($menuItemGiven && isset($menuItem) && $menuItem->component != 'com_juform')
		{
			$menuItemGiven = false;
			unset($query['Itemid']);
		}

		if (isset($query['view']))
		{
			$view = $query['view'];
		}
		else
		{
			
			return $segments;
		}

		
		if (($menuItem instanceof stdClass) && $menuItem->query['view'] == $query['view'] && isset($query['id']) && $menuItem->query['id'] == (int) $query['id'])
		{
			unset($query['view']);

			if (isset($query['layout']))
			{
				unset($query['layout']);
			}

			unset($query['id']);

			return $segments;
		}

		if ($view == 'form')
		{
			if (!$menuItemGiven)
			{
				$segments[] = $view;
			}

			unset($query['view']);

			if ($view == 'form')
			{
				if (isset($query['id']))
				{
					
					if (strpos($query['id'], ':') === false)
					{
						$form = JUFormHelper::getFormById($query['id']);
						if ($form)
						{
							$query['id'] = $query['id'] . ':' . $form->alias;
						}
						else
						{
							return $segments;
						}
					}
				}
				else
				{
					
					return $segments;
				}
			}

			if ($view == 'form')
			{
				if ($advanced)
				{
					list($tmp, $id) = explode(':', $query['id'], 2);
				}
				else
				{
					$id = $query['id'];
				}

				$segments[] = $id;
			}

			unset($query['id']);
		}

		
		if (isset($query['layout']))
		{
			if ($menuItemGiven && isset($menuItem->query['layout']))
			{
				if ($query['layout'] == $menuItem->query['layout'])
				{
					unset($query['layout']);
				}
			}
			else
			{
				if ($query['layout'] == 'default')
				{
					unset($query['layout']);
				}
			}
		}

		$total = count($segments);

		for ($i = 0; $i < $total; $i++)
		{
			$segments[$i] = str_replace(':', '-', $segments[$i]);
		}

		return $segments;
	}

	
	public function parse(&$segments)
	{
		$total = count($segments);
		$vars  = array();

		for ($i = 0; $i < $total; $i++)
		{
			$segments[$i] = preg_replace('/-/', ':', $segments[$i], 1);
		}

		
		$app  = JFactory::getApplication();
		$menu = $app->getMenu();
		$item = $menu->getActive();

		
		$count = count($segments);

		
		if (!isset($item))
		{
			$vars['view'] = $segments[0];
			$vars['id']   = (int) $segments[$count - 1];

			return $vars;
		}

		
		if ($count == 1)
		{
			
			if (strpos($segments[0], ':') === false)
			{
				$vars['view'] = 'form';
				$vars['id']   = (int) $segments[0];

				return $vars;
			}

			list($id, $alias) = explode(':', $segments[0], 2);

			
			$form = JUFormHelper::getFormById($id);

			if ($form)
			{
				$vars['view'] = 'form';
				$vars['id']   = (int) $id;
			}
			else
			{
				JError::raiseError(404, JText::_('COM_JUFORM_ERROR_FORM_NOT_FOUND'));

				return $vars;
			}
		}
	}
}


function JUFormBuildRoute(&$query)
{
	$router = new JUFormRouter;

	return $router->build($query);
}

function JUFormParseRoute($segments)
{
	$router = new JUFormRouter;

	return $router->parse($segments);
}