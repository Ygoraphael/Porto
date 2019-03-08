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

class JUFormFrontHelperForm
{
	
	protected static $cache = array();

	
	public static function getForm($formId, $checkAccess = true, $formObject = null)
	{
		if (!$formId)
		{
			return null;
		}

		

		$storeId = md5(__METHOD__ . "::$formId::" . (int) $checkAccess);
		if (!isset(self::$cache[$storeId]))
		{
			if (empty($formObject))
			{
				$formObject = JUFormHelper::getFormById($formId);
			}
			$nowDate = JFactory::getDate()->toSql();

			if (!is_object($formObject))
			{
				self::$cache[$storeId] = false;

				return self::$cache[$storeId];
			}

			if ($formObject->published != 1)
			{
				self::$cache[$storeId] = false;

				return self::$cache[$storeId];
			}

			if ($formObject->publish_up > $nowDate)
			{
				self::$cache[$storeId] = false;

				return self::$cache[$storeId];
			}

			if ($formObject->publish_down != '0000-00-00 00:00:00' && $formObject->publish_down < $nowDate)
			{
				self::$cache[$storeId] = false;

				return self::$cache[$storeId];
			}

			if ($checkAccess)
			{
				$user   = JFactory::getUser();
				$levels = $user->getAuthorisedViewLevels();

				if ($user->get('guest'))
				{
					if (!in_array($formObject->access, $levels))
					{
						self::$cache[$storeId] = false;

						return self::$cache[$storeId];
					}
				}
				else
				{
					if (!in_array($formObject->access, $levels) && $formObject->created_by != $user->id)
					{
						self::$cache[$storeId] = false;

						return self::$cache[$storeId];
					}
				}
			}

			self::$cache[$storeId] = $formObject;
		}

		return self::$cache[$storeId];
	}

	public static function updateHits($formId)
	{
		$app = JFactory::getApplication();

		
		$visited_forms = $app->getUserState('com_juform.visited_forms', array());
		if(array_search($formId, $visited_forms) === false)
		{
			$visited_forms[] = $formId;
			$app->setUserState('com_juform.visited_forms', $visited_forms);

			
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->update('#__juform_forms')
				->set('hits = hits + 1')
				->where('id = ' . $formId);
			$db->setQuery($query);
			$db->execute();
		}
	}
} 