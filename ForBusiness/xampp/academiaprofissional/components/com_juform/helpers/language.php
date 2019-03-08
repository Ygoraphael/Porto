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

class JUFormFrontHelperLanguage
{
	
	protected static $cache = array();

	
	public static function loadLanguageFile($name, $basePath = JPATH_BASE, $reload = false, $default = true)
	{
		$lang  = JFactory::getLanguage();
		$files = array();

		if (is_string($name))
		{
			$tags = $lang->getKnownLanguages();

			if (!empty($tags))
			{
				foreach ($tags AS $tag => $value)
				{
					if (isset($files[$tag]))
					{
						$files[$tag][] = $name;
					}
					else
					{
						$files[$tag] = array($name);
					}
				}
			}
		}
		elseif ($name instanceof SimpleXMLElement)
		{
			if (!$name || !count($name->children()))
			{
				return 0;
			}
			$lang     = JFactory::getLanguage();
			$elements = $name->children();

			foreach ($elements AS $element)
			{
				if ($element)
				{
					
					$first_pos = strpos($element, '.');
					$last_pos  = strrpos($element, '.');
					$extension = substr($element, $first_pos + 1, $last_pos - $first_pos - 1);

					$tag = (string) $element->attributes()->tag;

					if (isset($files[$tag]))
					{
						$files[$tag][] = $extension;
					}
					else
					{
						$files[$tag] = array($extension);
					}
				}
			}
		}
		else
		{
			return false;
		}

		if (!empty($files))
		{
			foreach ($files AS $language => $file_names)
			{
				if (!empty($file_names))
				{
					foreach ($file_names AS $name)
					{
						$lang->load($name, $basePath, $language, $reload, $default);
					}
				}
			}
		}

		return true;
	}
}