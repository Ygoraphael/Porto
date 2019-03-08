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


class JUFormHelper
{
	
	protected static $cache = array();

	
	public static function getActions()
	{
		$user   = JFactory::getUser();
		$result = new JObject;

		$component = 'com_juform';

		$path = JPATH_ADMINISTRATOR . '/components/' . $component . '/access.xml';

		$actions = JAccess::getActionsFromFile($path, "/access/section[@name='component']/");

		$assetName = $component;

		foreach ($actions AS $action)
		{
			$result->set($action->name, $user->authorise($action->name, $assetName));
		}

		return $result;
	}

	public static function getSubmissionById($submissionId, $resetCache = false, $submissionObject = null)
	{
		if (!$submissionId)
		{
			return null;
		}

		

		$storeId = md5(__METHOD__ . "::" . $submissionId);
		if (!isset(self::$cache[$storeId]) || $resetCache)
		{
			
			if (!is_object($submissionObject))
			{
				$db    = JFactory::getDbo();
				$query = $db->getQuery(true);
				$query->SELECT('sub.*');
				$query->FROM('#__juform_submissions AS sub');
				$query->WHERE('sub.id = ' . $submissionId);
				$db->setQuery($query);
				$submissionObject = $db->loadObject();
			}

			if ($submissionObject && $submissionObject->form_id > 0)
			{
				self::$cache[$storeId] = $submissionObject;
			}
			else
			{
				return $submissionObject;
			}
		}

		return self::$cache[$storeId];
	}

	################################< FORM SECTION >################################

	
	public static function getFormById($form_id, $resetCache = false, $formObject = null)
	{
		if (!$form_id)
		{
			return null;
		}

		

		$storeId = md5(__METHOD__ . "::" . $form_id);
		if (!isset(self::$cache[$storeId]) || $resetCache)
		{
			
			if (!is_object($formObject))
			{
				$db    = JFactory::getDbo();
				$query = $db->getQuery(true);
				$query->SELECT('form.*');
				$query->FROM('#__juform_forms AS form');
				$query->WHERE('form.id = ' . $form_id);
				$db->setQuery($query);
				$formObject = $db->loadObject();
			}

			self::$cache[$storeId] = $formObject;
		}

		return self::$cache[$storeId];
	}



	################################< FIELD GROUP & FIELD SECTION >################################

	
	public static function deleteFieldValuesOfSubmission($submissionId)
	{
		
		$submission = JUFormHelper::getSubmissionById($submissionId);
		if ($submission && $submission->form_id)
		{
			$db    = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select("field.*, plg.folder");
			$query->from("#__juform_fields AS field");
			$query->join("", "#__juform_plugins AS plg ON field.plugin_id = plg.id");
			$query->where("field.form_id = " . $submission->form_id);
			$db->setQuery($query);
			$fields = $db->loadObjectList();
			foreach ($fields AS $field)
			{
				
				$fieldClass = JUFormFrontHelperField::getField($field, $submissionId);
				$fieldClass->onDelete();
			}
		}
	}

	
	public static function autoLoadFieldClass($class)
	{
		
		if (class_exists($class))
		{
			return null;
		}

		$pattern = '/^juformfield(.*)$/i';
		preg_match($pattern, strtolower($class), $matches);
		if ($matches)
		{
			$fieldFolderPath = JPATH_SITE . '/components/com_juform/fields/';
			
			if ($matches[1])
			{
				
				$path = $fieldFolderPath . $matches[1] . '/' . $matches[1] . '.php';
				if (JFile::exists($path))
				{
					require_once $path;
				}
			}
		}
	}

	
	public static function hasCSVPlugin()
	{
		JLoader::register('JUFormCSV', JPATH_SITE . '/components/com_juform/plugins/csv/csv.php');
		if (!class_exists('JUFormCSV'))
		{
			return false;
		}

		return true;
	}

	
	public static function fileNameFilter($fileName)
	{
		
		$fileNameFilterPath = JPATH_ADMINISTRATOR . "/components/com_juform/helper/filenamefilter.php";
		if (JFile::exists($fileNameFilterPath))
		{
			require_once $fileNameFilterPath;
			if (class_exists("JUFileNameFilter"))
			{
				
				if (function_exists("fileNameFilter"))
				{
					$fileName = call_user_func("fileNameFilter", $fileName);
				}
			}
		}

		$fileInfo = pathinfo($fileName);
		$fileName = str_replace("-", "_", JFilterOutput::stringURLSafe($fileInfo['filename']));

		$fileName = JFile::makeSafe($fileName);

		
		if (!$fileName)
		{
			$fileName = JFactory::getDate()->format('Y_m_d_H_i_s');
		}

		return isset($fileInfo['extension']) ? $fileName . "." . $fileInfo['extension'] : $fileName;
	}

	
	public static function getMimeType($filePath)
	{
		$mime_type = '';

		if (function_exists('finfo_open'))
		{
			$fhandle   = finfo_open(FILEINFO_MIME);
			$mime_type = finfo_file($fhandle, $filePath);
		}

		if (function_exists('mime_content_type'))
		{
			$mime_type = mime_content_type($filePath);
		}

		if (!$mime_type)
		{
			$imageExtension = array("jpeg", "pjpeg", "png", "gif", "bmp", "jpg");
			$extension      = JFile::getExt($filePath);

			if (in_array($extension, $imageExtension))
			{
				$imageInfo = getimagesize($filePath);

				$mime_type = $imageInfo['mime'];
			}
		}

		return $mime_type;
	}

	
	public static function formatBytes($n_bytes)
	{
		if ($n_bytes < 1024)
		{
			return $n_bytes . ' B';
		}
		elseif ($n_bytes < 1048576)
		{
			return round($n_bytes / 1024) . ' KB';
		}
		elseif ($n_bytes < 1073741824)
		{
			return round($n_bytes / 1048576, 2) . ' MB';
		}
		elseif ($n_bytes < 1099511627776)
		{
			return round($n_bytes / 1073741824, 2) . ' GB';
		}
		elseif ($n_bytes < 1125899906842624)
		{
			return round($n_bytes / 1099511627776, 2) . ' TB';
		}
		elseif ($n_bytes < 1152921504606846976)
		{
			return round($n_bytes / 1125899906842624, 2) . ' PB';
		}
		elseif ($n_bytes < 1180591620717411303424)
		{
			return round($n_bytes / 1152921504606846976, 2) . ' EB';
		}
		elseif ($n_bytes < 1208925819614629174706176)
		{
			return round($n_bytes / 1180591620717411303424, 2) . ' ZB';
		}
		else
		{
			return round($n_bytes / 1208925819614629174706176, 2) . ' YB';
		}
	}

	
	public static function getPostMaxSize()
	{
		$val  = ini_get('post_max_size');
		$last = strtolower($val[strlen($val) - 1]);
		switch ($last)
		{
			case 'g':
				$val *= 1024;
			case 'm':
				$val *= 1024;
			case 'k':
				$val *= 1024;
		}

		return $val;
	}

	
	public static function getPhysicalPath($path)
	{
		if (empty($path))
		{
			return '';
		}

		
		if (stripos($path, JUri::root()) === 0)
		{
			$path = JPath::clean(str_replace(JUri::root(), JPATH_ROOT . "/", $path));
		}
		else
		{
			if (stripos($path, JPATH_ROOT) === false)
			{
				$path = JPath::clean(JPATH_ROOT . "/" . $path);
			}
		}

		if (JFile::exists($path))
		{
			return $path;
		}

		return '';
	}

	
	public static function downloadFile($file, $fileName, $transport = 'php', $speed = 50, $resume = true, $downloadMultiParts = true, $mimeType = false)
	{
		
		if (ini_get('zlib.output_compression'))
		{
			@ini_set('zlib.output_compression', 'Off');
		}

		
		if (function_exists('apache_setenv'))
		{
			apache_setenv('no-gzip', '1');
		}

		
		

		
		
		
		$agent = isset($_SERVER['HTTP_USER_AGENT']) ? trim($_SERVER['HTTP_USER_AGENT']) : null;
		if ($agent && preg_match('#(?:MSIE |Internet Explorer/)(?:[0-9.]+)#', $agent)
			&& (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
		)
		{
			header('Pragma: ');
			header('Cache-Control: ');
		}
		else
		{
			header('Pragma: no-store,no-cache');
			header('Cache-Control: no-cache, no-store, must-revalidate, max-age=-1');
			header('Cache-Control: post-check=0, pre-check=0', false);
		}
		header('Expires: Mon, 14 Jul 1789 12:30:00 GMT');
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');

		
		if (is_resource($file) && get_resource_type($file) == "stream")
		{
			$transport = 'php';
		}
		
		elseif (!JFile::exists($file))
		{
			return JText::sprintf("COM_JUFORM_FILE_NOT_FOUND_X", $fileName);
		}

		
		if ($transport != 'php')
		{
			
			header('Content-Description: File Transfer');
			header('Date: ' . @gmdate("D, j M m Y H:i:s ") . 'GMT');
			
			if ($resume)
			{
				header('Accept-Ranges: bytes');
			}
			
			elseif (isset($_SERVER['HTTP_RANGE']))
			{
				exit;
			}

			if (!$downloadMultiParts)
			{
				
				header('Accept-Ranges: none');
			}

			header('Content-Type: application/force-download');
			
			
			
			
			header('Content-Disposition: attachment; filename="' . $fileName . '"');
		}

		switch ($transport)
		{
			
			case 'apache':
				
				$modules = apache_get_modules();
				if (in_array('mod_xsendfile', $modules))
				{
					header('X-Sendfile: ' . $file);
				}
				break;

			
			case 'ngix':
				$path = preg_replace('/' . preg_quote(JPATH_ROOT, '/') . '/', '', $file, 1);
				header('X-Accel-Redirect: ' . $path);
				break;

			
			case 'lighttpd':
				header('X-LIGHTTPD-send-file: ' . $file); 
				header('X-Sendfile: ' . $file); 
				break;

			
			case 'php':
			default:
				JLoader::register('JUDownload', JPATH_ADMINISTRATOR . '/components/com_juform/helpers/judownload.class.php');

				JUFormHelper::obCleanData();

				$download = new JUDownload($file);

				$download->rename($fileName);
				if ($mimeType)
				{
					$download->mime($mimeType);
				}
				if ($resume)
				{
					$download->resume();
				}
				$download->speed($speed);
				$download->start();

				if ($download->error)
				{
					return $download->error;
				}

				unset($download);
				break;
		}

		return true;
	}

	
	public static function checkGroupPermission($task_str = '', $view_str = '')
	{
		$storeId = md5(__METHOD__ . "::" . $task_str . "::" . $view_str);
		if (!isset(self::$cache[$storeId]))
		{
			$user = JFactory::getUser();
			
			if ($user->authorise('core.admin', 'com_juform'))
			{
				self::$cache[$storeId] = true;

				return self::$cache[$storeId];
			}

			
			$mappedPermissions = array(
				"forms"             => array(
					"delete" => array("task" => array('forms.delete'),
					                  "view" => array()
					),
					"manage" => array("task" => array("form.edit", "form.add", "form.save", "form.apply", "forms\..*"),
					                  "view" => array('form')
					),
					"view"   => array("task" => array(),
					                  "view" => array("forms")
					)
				),
				"submissions"       => array(
					"delete" => array("task" => array('submissions.delete'),
					                  "view" => array()
					),
					"manage" => array("task" => array("submission.edit", "submission.save", "submission.apply", "submissions\..*"),
					                  "view" => array('submission')
					),
					"view"   => array("task" => array(),
					                  "view" => array("submissions")
					)
				),
				"plugins"           => array(
					"delete" => array("task" => array("plugins.delete"),
					                  "view" => array()
					),
					"manage" => array("task" => array("plugin.edit", "plugin.add", "plugins\..*"),
					                  "view" => array("plugin")
					),
					"view"   => array("task" => array(),
					                  "view" => array("plugins")
					)
				),
				"languages"         => array(
					"delete" => array("task" => array(),
					                  "view" => array()
					),
					"manage" => array("task" => array("languages\..*"),
					                  "view" => array()
					),
					"view"   => array("task" => array(),
					                  "view" => array("languages")
					)
				),
				"backendpermission" => array(
					"delete" => array("task" => array(),
					                  "view" => array()
					),
					"manage" => array("task" => array("backendpermission\..*"),
					                  "view" => array("backendpermission")
					),
					"view"   => array("task" => array(),
					                  "view" => array("backendpermission")
					)
				)
			);

			$_view           = "";
			$_permissionType = "";

			
			foreach ($mappedPermissions AS $view => $permissionArr)
			{
				foreach ($permissionArr AS $permissionType => $taskViewPatterns)
				{
					
					if ($task_str)
					{
						$patterns    = $taskViewPatterns["task"];
						$checked_str = $task_str;
					}
					else
					{
						$patterns    = $taskViewPatterns["view"];
						$checked_str = $view_str;
					}

					

					
					foreach ($patterns AS $pattern)
					{
						if (preg_match("/^" . $pattern . "$/i", $checked_str))
						{
							$_view           = $view;
							$_permissionType = $permissionType;
							break;
						}
					}
					
					if ($_view && $_permissionType)
					{
						break;
					}
				}

				
				if ($_view && $_permissionType)
				{
					break;
				}
			}

			$db = JFactory::getDbo();

			
			
			foreach ($user->groups AS $group)
			{
				$query = $db->getQuery(true);
				$query->select('permission');
				$query->from('#__juform_backend_permission');
				$query->where('group_id = ' . $group);
				$db->setQuery($query);
				$permission = $db->loadResult();

				$registry = new JRegistry;
				$registry->loadString($permission);

				$groupPermission = $registry->toArray();
				
				if (!isset($groupPermission[$_view][$_permissionType]) || $groupPermission[$_view][$_permissionType] === 1)
				{
					self::$cache[$storeId] = true;

					return self::$cache[$storeId];
				}
				
				else
				{
					continue;
				}
			}

			
			self::$cache[$storeId] = false;

			return self::$cache[$storeId];
		}

		return self::$cache[$storeId];
	}

	################################< MENU SECTION >################################

	
	protected static function addPathMenu($item, $path = '')
	{
		$item->addAttribute('path', $path ? $path . '.' . $item['name'] : $item['name']);
		if (strlen(trim((string) $item)) == 0)
		{
			foreach ($item->children() AS $child)
			{
				self::addPathMenu($child, $item['path']);
			}
		}
	}

	
	protected static function showMenuItem($item)
	{
		if (strpos($item['name'], 'criteria') !== false && !self::hasMultiRating())
		{
			return 0;
		}

		if (strpos($item['name'], 'csv') !== false && !self::hasCSVPlugin())
		{
			return 0;
		}

		if ($item['proversion'] == "true" && !JUFMPROVERSION)
		{
			return 0;
		}

		$task = $view = $item['name'];
		if (strpos($item['name'], ".") !== false)
		{
			$view = "";
		}
		else
		{
			$task = "";
		}

		if (!self::checkGroupPermission($task, $view))
		{
			$showItemStatus = 0;
			$children       = $item->children();
			if (count($children))
			{
				foreach ($children AS $child)
				{
					if (self::showMenuItem($child) != 0)
					{
						$showItemStatus = 2;
						break;
					}
				}
			}
		}
		else
		{
			$showItemStatus = 1;
		}

		return $showItemStatus;
	}

	
	protected static function getMenuItems($item, $activePath)
	{
		$html     = '';
		$children = $item->children();

		if (self::showMenuItem($item) == 2)
		{
			$item['link'] = '#';
		}
		elseif (self::showMenuItem($item) == 0)
		{
			return $html;
		}

		$icon        = $item['icon'] ? $item['icon'] . ' ' : '';
		$activeClass = in_array($item['name'], $activePath) ? 'active' : '';
		if ($item->getName() == 'divider')
		{
			$html .= '<li class="divider"></li>';
		}
		elseif ($item->getName() == 'header')
		{
			$html .= '<li class="nav-header">' . $icon . ($item['label'] ? JText::_($item['label']) : $item['name']) . '</li>';
		}
		else
		{
			if (count($children) > 0)
			{
				$child_html = '';
				foreach ($children AS $child)
				{
					$child_html .= self::getMenuItems($child, $activePath);
				}

				$html .= '<li class="dropdown ' . $activeClass . '">';
				$html .= '<a href="' . $item['link'] . '" class="dropdown-toggle" data-toggle="dropdown">' . $icon . ($item['label'] ? JText::_($item['label']) : $item['name']) . ($child_html ? '<b class="caret"></b>' : '') . '</a>';
				if ($child_html)
				{
					$html .= '<ul class="dropdown-menu">';
					$html .= $child_html;
					$html .= '</ul>';
				}
				$html .= '</li>';
			}
			else
			{
				$html .= '<li class="' . $activeClass . '"><a href="' . $item['link'] . '">' . $icon . ($item['label'] ? JText::_($item['label']) : $item['name']) . '</a></li>';
			}
		}

		return $html;
	}

	
	public static function getMenu($menuName)
	{
		
		$app = JFactory::getApplication();
		if ($app->input->get('tmpl', '') == 'component')
		{
			return '';
		}

		$menu_path = JPATH_ADMINISTRATOR . "/" . 'components/com_juform/helpers/menu.xml';
		$menu_xml  = JFactory::getXML($menu_path, true);
		$html      = '';
		if (!$menu_xml)
		{
			return $html;
		}

		foreach ($menu_xml->children() AS $child)
		{
			self::addPathMenu($child);
		}

		$activePath = array();
		$activeMenu = $menu_xml->xpath('//item[@name="' . $menuName . '"]');
		if (isset($activeMenu[0]) && $activeMenu[0])
		{
			$activePath = $activeMenu[0]['path'];
			if ($activePath)
			{
				$activePath = explode(".", $activePath);
			}
		}
		$html .= '<div class="navbar" id="jumenu">';
		$html .= '<div class="navbar-inner">';
		$html .= '<div class="container">';
		$html .= '<ul class="nav">';
		foreach ($menu_xml->children() AS $child)
		{
			$html .= self::getMenuItems($child, $activePath);
		}
		$html .= '</ul>';
		$html .= '</div>';
		$html .= '</div>';
		$html .= '</div>';

		$document = JFactory::getDocument();

		$script = "jQuery(document).ready(function($){
						$('#jumenu .dropdown-toggle').dropdownHover();
					});";
		$document->addScriptDeclaration($script);

		return $html;
	}

	################################< OTHER SECTION >################################

	
	public static function obCleanData($error_reporting = false)
	{
		
		if (!$error_reporting)
		{
			error_reporting(0);
		}

		$obLevel = ob_get_level();
		if ($obLevel)
		{
			while ($obLevel > 0)
			{
				ob_end_clean();
				$obLevel--;
			}
		}
		else
		{
			ob_clean();
		}

		return true;
	}

	
	public static function isJoomla3x()
	{
		return version_compare(JVERSION, '3.0', 'ge');
	}

	
	public static function generateRandomString($length = 10)
	{
		$characters   = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';
		for ($i = 0; $i < $length; $i++)
		{
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}

		return $randomString;
	}

	
	public static function appendXML(SimpleXMLElement $source, SimpleXMLElement $append, $globalConfig = false, $displayParams = false)
	{
		if ($append)
		{
			$attributes = $append->attributes();
			if ($globalConfig)
			{
				if ((isset($attributes['override']) && $attributes['override'] != 'true' && $attributes['override'] != 1) &&
					(in_array($append->getName(), array('field', 'fields', 'fieldset')))
				)
				{
					return false;
				}
			}

			if ($displayParams && $attributes['type'] == 'list')
			{
				$globalOption = $append->addChild('option', 'COM_JUFORM_USE_GLOBAL');
				$globalOption->addAttribute('value', '-2');
			}
            
            

			if (strlen(trim((string) $append)) == 0)
			{
				$xml = $source->addChild($append->getName());
				foreach ($append->children() AS $child)
				{
					self::appendXML($xml, $child, $globalConfig, $displayParams);
				}
			}
			else
			{
				$xml = $source->addChild($append->getName(), (string) $append);
			}

			foreach ($append->attributes() AS $n => $v)
			{
				if ($displayParams && $n == 'fieldset')
				{
					$xml->addAttribute('fieldset', 'params');
				}
				elseif ($displayParams && $n == 'default')
				{
					$xml->addAttribute($n, '-2');
				}
				else
				{
					$xml->addAttribute($n, $v);
				}
			}
		}
	}

	
	public static function emailLinkRouter($url, $xhtml = true, $ssl = null)
	{
		
		$app    = JFactory::getApplication('site');
		$router = $app->getRouter();

		
		if (!$router)
		{
			return null;
		}

		if ((strpos($url, '&') !== 0) && (strpos($url, 'index.php') !== 0))
		{
			return $url;
		}

		
		$uri = $router->build($url);

		$url = $uri->toString(array('path', 'query', 'fragment'));

		
		$url = preg_replace('/\s/u', '%20', $url);

		
		if ((int) $ssl)
		{
			$uri = JUri::getInstance();

			
			static $prefix;
			if (!$prefix)
			{
				$prefix = $uri->toString(array('host', 'port'));
			}

			
			$scheme = ((int) $ssl === 1) ? 'https' : 'http';

			
			if (!preg_match('#^/#', $url))
			{
				$url = '/' . $url;
			}

			
			$url = $scheme . '://' . $prefix . $url;
		}

		if ($xhtml)
		{
			$url = htmlspecialchars($url);
		}

		
		$url = str_replace('/administrator', '', $url);

		return $url;
	}

	
	public static function getPluginOptions($type = null, $default = null)
	{
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('id AS value, title AS text');
		$query->from('#__juform_plugins');
		if ($type)
		{
			$query->where('`type` = "' . $type . '"');
		}

		if (!is_null($default))
		{
			$query->where('`default` = "' . (int) $default . '"');
		}

		$db->setQuery($query);
		$plugins = $db->loadObjectlist();

		$options = array();
		foreach ($plugins AS $plugin)
		{

			$options[] = JHtml::_('select.option', $plugin->value, $plugin->text);
		}

		return $options;
	}

	public static function getComVersion($comName = true, $comVersion = true)
	{
		$app    = JFactory::getApplication();
		$option = $app->input->get('option', '');
		$db     = JFactory::getDbo();
		$query  = $db->getQuery(true);
		$query->select('manifest_cache')
			->from('#__extensions')
			->where('element = ' . $db->quote($option));
		$db->setQuery($query);
		$result   = $db->loadResult();
		$manifest = new JRegistry($result);
		$version  = array();
		if ($comName)
		{
			$name = $manifest->get('name');
			if (!JUFMPROVERSION)
			{
				$name .= ' Lite';
			}
			$version[] = $name;
		}

		if ($comVersion)
		{
			$version[] = 'Version ' . $manifest->get('version');
		}

		return implode(" - ", $version);
	}

	public static function getPluginById($pluginId)
	{
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('*');
		$query->from('#__juform_plugins');
		$query->where('id = ' . (int) $pluginId);
		$db->setQuery($query);

		return $db->loadObject();
	}

	
	public static function getLayouts($templateFolder)
	{
		$layoutPath = JPATH_SITE . '/components/com_juform/templates/' . $templateFolder . '/layouts/';
		$layouts    = array();
		if (JFolder::exists($layoutPath))
		{
			$layouts = JFolder::folders($layoutPath);
		}

		return $layouts;
	}

	
	public static function getThemes($templateFolder)
	{
		$themePath = JPATH_SITE . '/components/com_juform/templates/' . $templateFolder . '/themes/';
		$themes    = array();
		if (JFolder::exists($themePath))
		{
			$files = glob($themePath . "*.{css}", GLOB_BRACE);
			foreach ($files as $file)
			{
				$themes[] = basename($file, ".css");
			}
		}

		return $themes;
	}

	
	public static function uploader($targetDir = null, $cb_check_file = false)
	{
		
		error_reporting(0);

		JLoader::register('PluploadHandler', JPATH_SITE . '/components/com_juform/helpers/pluploadhandler.php');

		
		if (!$targetDir)
		{
			$targetDir = JPATH_ROOT . "/media/com_juform/tmp";
		}

		$cleanupTargetDir = true; 
		$maxFileAge       = 5 * 3600; 

		
		self::cleanup($targetDir, $maxFileAge);

		
		if (!JFolder::exists($targetDir))
		{
			JFolder::create($targetDir);
			$indexHtml = $targetDir . 'index.html';
			$buffer    = "<!DOCTYPE html><title></title>";
			JFile::write($indexHtml, $buffer);
		}

		
		if (!is_writable($targetDir))
		{
			$targetDir = sys_get_temp_dir() . DIRECTORY_SEPARATOR . "plupload";
			

			
			if (!file_exists($targetDir))
			{
				@mkdir($targetDir);
			}
		}

		PluploadHandler::no_cache_headers();
		PluploadHandler::cors_headers();

		if (!PluploadHandler::handle(array(
			'target_dir'    => $targetDir,
			'cleanup'       => $cleanupTargetDir,
			'max_file_age'  => $maxFileAge,
			'cb_check_file' => $cb_check_file,
		))
		)
		{
			die(json_encode(array(
				'OK'    => 0,
				'error' => array(
					'code'    => PluploadHandler::get_error_code(),
					'message' => PluploadHandler::get_error_message()
				)
			)));
		}
		else
		{
			die(json_encode(array('OK' => 1)));
		}
	}

	
	private static function cleanup($tmpDir, $maxFileAge = 18000)
	{
		
		if (JFolder::exists($tmpDir))
		{
			foreach (glob($tmpDir . '/*.*') AS $tmpFile)
			{
				if (basename($tmpFile) == 'index.html' || (time() - filemtime($tmpFile) < $maxFileAge))
				{
					continue;
				}

				if (is_dir($tmpFile))
				{
					JFolder::delete($tmpFile);
				}
				else
				{
					JFile::delete($tmpFile);
				}
			}
		}
	}

	
	public static function isValidUploadURL()
	{
		$app  = JFactory::getApplication();
		$time = $app->input->getInt('time', 0);
		$code = $app->input->get('code', '');

		if (!$time || !$code)
		{
			return false;
		}

		$secret = JFactory::getConfig()->get('secret');
		if ($code != md5($time . $secret))
		{
			return false;
		}

		
		$liveTimeUrl = 60 * 60 * 5;
		if ((time() - $time) > $liveTimeUrl)
		{
			return false;
		}

		return true;
	}

	public static function checkJUFormExtensionPlugin()
	{
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('*')
			->from('#__extensions')
			->where('type = "plugin"')
			->where('element = "juform"')
			->where('folder = "extension"');
		$db->setQuery($query);
		$extensionObj = $db->loadObject();
		if (!$extensionObj)
		{
			JError::raiseWarning('', JText::_('COM_JUFORM_JUFORM_EXTENSION_PLUGIN_IS_NOT_INSTALLED'));

			return false;
		}

		if (!$extensionObj->enabled)
		{
			JError::raiseWarning('', JText::_('COM_JUFORM_JUFORM_EXTENSION_PLUGIN_IS_NOT_ACTIVE'));

			return false;
		}

		return true;
	}
}