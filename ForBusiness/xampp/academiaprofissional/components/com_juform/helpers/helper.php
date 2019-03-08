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

jimport('joomla.utilities.utility');

JLoader::register('JUFormHelper', JPATH_ADMINISTRATOR . '/components/com_juform/helpers/juform.php');


JLoader::register('JUFormFrontHelperBreadcrumb', JPATH_SITE . '/components/com_juform/helpers/breadcrumb.php');
JLoader::register('JUFormFrontHelperForm', JPATH_SITE . '/components/com_juform/helpers/form.php');
JLoader::register('JUFormFrontHelperField', JPATH_SITE . '/components/com_juform/helpers/field.php');
JLoader::register('JUFormFrontHelperLanguage', JPATH_SITE . '/components/com_juform/helpers/language.php');
JLoader::register('JUFormFrontHelperMail', JPATH_SITE . '/components/com_juform/helpers/mail.php');
JLoader::register('JUFormFrontHelperString', JPATH_SITE . '/components/com_juform/helpers/string.php');

class JUFormFrontHelper
{
	
	protected static $cache = array();

	
	public static $sef_replace = array(
		'%26' => '-26', 
		'%3F' => '-3F', 
		'%2F' => '-2F', 
		'%3C' => '-3C', 
		'%3E' => '-3E', 
		'%23' => '-23', 
		'%24' => '-24', 
		'%3A' => '-3A', 
		'%2E' => '-2E', 
		'%2B' => '-2B', 
		'%25' => '-25', 
	);


	
	public static function setCanonical($canonicalLink)
	{
		$homPage = false;

		$language        = JFactory::getLanguage();
		$languageTagArr  = explode('-', $language->getTag());
		$currentUrl      = trim(str_replace(array('index.php/', 'index.php'), '', JUri::getInstance()->toString()), '/');
		$currentUrl      = str_replace('?lang=' . $languageTagArr[0], '', $currentUrl);
		$homeUrl         = JUri::base();
		$homeUrlWithLang = $homeUrl . $languageTagArr[0];

		if ($currentUrl == $homeUrl || $currentUrl == $homeUrlWithLang)
		{
			$homPage = true;
		}

		if (!$homPage)
		{
			$document = JFactory::getDocument();
			
			$canonicalTagExisted = false;
			$formHeadData        = $document->getHeadData();
			$formHeadDataLink    = $formHeadData['links'];

			
			if (!empty($formHeadDataLink))
			{
				foreach ($formHeadDataLink AS $formHeadDataLinkKey => $formHeadDataLinkItem)
				{
					if (is_array($formHeadDataLinkItem) && isset($formHeadDataLinkItem['relation']) && $formHeadDataLinkItem['relation'] == 'canonical')
					{
						$canonicalTagExisted = true;
						unset($formHeadDataLink[$formHeadDataLinkKey]);
						$formHeadDataLink[$canonicalLink] = $formHeadDataLinkItem;
					}
				}
				$formHeadData['links'] = $formHeadDataLink;
				$document->setHeadData($formHeadData);
			}

			
			if (!$canonicalTagExisted)
			{
				$document->addHeadLink(htmlspecialchars($canonicalLink), 'canonical');
			}
		}
	}

	
	public static function loadjQuery()
	{
		$document = JFactory::getDocument();
		if ($document->getType() != 'html')
		{
			return true;
		}

		JHtml::_('jquery.framework');
	}

	
	public static function loadjQueryUI($forceLoad = false)
	{
		
		$params = JComponentHelper::getParams('com_juform');
		
		if ($params->get('load_jquery_ui', 2) == 0)
		{
			return false;
		}

		$loadjQueryUI = true;
		
		if ($params->get('load_jquery_ui', 2) == 2)
		{
			$loadjQueryUI = true;
			$document     = JFactory::getDocument();
			$header       = $document->getHeadData();
			$scripts      = $header['scripts'];
			if (count($scripts))
			{
				$pattern = '/([\/\\a-zA-Z0-9_:\.-]*)jquery[.-]ui([0-9\.-]|core|custom|min|pack)*?.js(.*?)/i';
				foreach ($scripts AS $script => $opts)
				{
					if (preg_match($pattern, $script))
					{
						$loadjQueryUI = false;
						break;
					}
				}
			}
		}

		
		if ($loadjQueryUI || $forceLoad)
		{
			JUFormFrontHelper::loadjQuery();
			$document = JFactory::getDocument();
			$document->addScript(JUri::root(true) . '/components/com_juform/assets/js/jquery-ui.min.js');
			$document->addStyleSheet(JUri::root(true) . '/components/com_juform/assets/css/jquery-ui.min.css');
		}
	}

	
	public static function loadBootstrap($version = 2, $type = 2)
	{
		$document = JFactory::getDocument();

		
		if ($document->getType() != 'html')
		{
			return true;
		}

		$app        = JFactory::getApplication();

		
		if ($type == 0)
		{
			return false;
		}

		
		$loadBootstrap = true;
		if ($type == 2 || $app->isAdmin())
		{
			$header  = $document->getHeadData();
			$scripts = $header['scripts'];
			if (count($scripts))
			{
				$pattern = '/([\/\\a-zA-Z0-9_:\.-]*)bootstrap.([0-9\.-]|core|custom|min|pack)*?.js(.*?)/i';
				foreach ($scripts AS $script => $opts)
				{
					if (preg_match($pattern, $script))
					{
						$loadBootstrap = false;
						break;
					}
				}
			}
		}

		
		if ($loadBootstrap)
		{
			JUFormFrontHelper::loadjQuery();

			if ($version == 2)
			{
				JHtml::_('bootstrap.framework');
				if ($app->isSite())
				{
					JHtml::_('bootstrap.loadCss');
				}
			}
			elseif ($version == 3)
			{
				$document->addScript(JUri::root(true) . '/components/com_juform/assets/bootstrap3/js/bootstrap.min.js');
				$document->addStyleSheet(JUri::root(true) . '/components/com_juform/assets/bootstrap3/css/bootstrap.min.css');
				$document->addStyleSheet(JUri::root(true) . '/components/com_juform/assets/bootstrap3/css/bootstrap-theme.min.css');

				
			}
		}

		
		if ($app->isAdmin())
		{
			$document->addScript(JUri::root(true) . '/administrator/components/com_juform/assets/js/bootstrap-hover-dropdown.js');
		}
	}

	
	public static function getBootstrapColumns($numOfColumns)
	{
		switch ($numOfColumns)
		{
			case 1:
				return array(12);
				break;
			case 2:
				return array(6, 6);
				break;
			case 3:
				return array(4, 4, 4);
				break;
			case 4:
				return array(3, 3, 3, 3);
				break;
			case 5:
				return array(3, 3, 2, 2, 2);
				break;
			case 6:
				return array(2, 2, 2, 2, 2, 2);
				break;
			case 7:
				return array(2, 2, 2, 2, 2, 1, 1);
				break;
			case 8:
				return array(2, 2, 2, 2, 1, 1, 1, 1);
				break;
			case 9:
				return array(2, 2, 2, 1, 1, 1, 1, 1, 1);
				break;
			case 10:
				return array(2, 2, 1, 1, 1, 1, 1, 1, 1, 1);
				break;
			case 11:
				return array(2, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
				break;
			case 12:
				return array(1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
				break;
			default:
				return array(12);
				break;
		}
	}

	
	public static function getIpAddress()
	{
		$ipaddress = '';
		if (getenv('HTTP_CLIENT_IP'))
		{
			$ipaddress = getenv('HTTP_CLIENT_IP');
		}
		else
		{
			if (getenv('HTTP_X_FORWARDED_FOR'))
			{
				$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
			}
			else
			{
				if (getenv('HTTP_X_FORWARDED'))
				{
					$ipaddress = getenv('HTTP_X_FORWARDED');
				}
				else
				{
					if (getenv('HTTP_FORWARDED_FOR'))
					{
						$ipaddress = getenv('HTTP_FORWARDED_FOR');
					}
					else
					{
						if (getenv('HTTP_FORWARDED'))
						{
							$ipaddress = getenv('HTTP_FORWARDED');
						}
						else
						{
							if (getenv('REMOTE_ADDR'))
							{
								$ipaddress = getenv('REMOTE_ADDR');
							}
							else
							{
								$ipaddress = '';
							}
						}
					}
				}
			}
		}

		return $ipaddress;
	}

	
	public static function getPlatform($user_agent)
	{
		$os_platform = "";

		$os_array = array(
			'/windows nt 10/i'      => 'Windows 10',
			'/windows nt 6.3/i'     => 'Windows 8.1',
			'/windows nt 6.2/i'     => 'Windows 8',
			'/windows nt 6.1/i'     => 'Windows 7',
			'/windows nt 6.0/i'     => 'Windows Vista',
			'/windows nt 5.2/i'     => 'Windows Server 2003/XP x64',
			'/windows nt 5.1/i'     => 'Windows XP',
			'/windows xp/i'         => 'Windows XP',
			'/windows nt 5.0/i'     => 'Windows 2000',
			'/windows me/i'         => 'Windows ME',
			'/win98/i'              => 'Windows 98',
			'/win95/i'              => 'Windows 95',
			'/win16/i'              => 'Windows 3.11',
			'/macintosh|mac os x/i' => 'Mac OS X',
			'/mac_powerpc/i'        => 'Mac OS 9',
			'/linux/i'              => 'Linux',
			'/ubuntu/i'             => 'Ubuntu',
			'/iphone/i'             => 'iPhone',
			'/ipod/i'               => 'iPod',
			'/ipad/i'               => 'iPad',
			'/android/i'            => 'Android',
			'/blackberry/i'         => 'BlackBerry',
			'/webos/i'              => 'Mobile'
		);

		foreach ($os_array AS $regex => $value)
		{
			if (preg_match($regex, $user_agent))
			{
				$os_platform = $value;
			}
		}

		return $os_platform;
	}

	
	public static function UrlEncode($string)
	{
		
		$string = urlencode($string);

		$params = JComponentHelper::getParams('com_juform');
		$string = preg_replace('/' . $params->get('sef_space', '-') . '/', "%252D", $string);
		$string = preg_replace('/\+/', $params->get('sef_space', '-'), $string);
		

		foreach (self::$sef_replace AS $key => $value)
		{
			$string = preg_replace('/' . $key . '/', $value, $string);
		}

		return $string;
	}

	
	public static function UrlDecode($string)
	{
		foreach (self::$sef_replace AS $key => $value)
		{
			$string = str_replace($value, urldecode($key), $string);
		}

		$params = JComponentHelper::getParams('com_juform');
		$string = preg_replace('/' . $params->get('sef_space', '-') . '/', "%20", $string);
		
		$string = preg_replace('/&quot;/', "%22", $string);
		$string = preg_replace("/%252D/", $params->get('sef_space', '-'), $string);

		
		$string = urldecode($string);

		return $string;
	}

	
	public static function canUpload(&$file, &$error = array(), $legal_extensions, $max_size = 0, $check_mime = false, $allowed_mime = '', $ignored_extensions = '', $image_extensions = 'bmp,gif,jpg,jpeg,png')
	{
		
		if (empty($file['name']))
		{
			isset($error['WARN_SOURCE']) ? $error['WARN_SOURCE']++ : $error['WARN_SOURCE'] = 1;

			return false;
		}

		jimport('joomla.filesystem.file');

		
		

		
		$executable = array(
			'php', 'js', 'exe', 'phtml', 'java', 'perl', 'py', 'asp', 'dll', 'go', 'ade', 'adp', 'bat', 'chm', 'cmd', 'com', 'cpl', 'hta', 'ins', 'isp',
			'jse', 'lib', 'mde', 'msc', 'msp', 'mst', 'pif', 'scr', 'sct', 'shb', 'sys', 'vb', 'vbe', 'vbs', 'vxd', 'wsc', 'wsf', 'wsh'
		);

		$legal_extensions   = array_map('trim', explode(",", strtolower(str_replace("\n", ",", $legal_extensions))));
		$ignored_extensions = array_map('trim', explode(",", strtolower(str_replace("\n", ",", $ignored_extensions))));

		$format = strtolower(JFile::getExt($file['name']));
		
		if ($format == '' || $format == false || (!in_array($format, $legal_extensions)) || in_array($format, $executable))
		{
			isset($error['WARN_FILETYPE']) ? $error['WARN_FILETYPE']++ : $error['WARN_FILETYPE'] = 1;

			return false;
		}

		
		if ($max_size > 0 && (int) $file['size'] > $max_size)
		{
			isset($error['WARN_FILETOOLARGE']) ? $error['WARN_FILETOOLARGE']++ : $error['WARN_FILETOOLARGE'] = 1;

			return false;
		}

		
		if ($check_mime)
		{
			$image_extensions = array_map('trim', explode(",", strtolower(str_replace("\n", ",", $image_extensions))));

			
			if (in_array($format, $image_extensions))
			{
				
				
				if (!empty($file['tmp_name']))
				{
					if (($imginfo = getimagesize($file['tmp_name'])) === false)
					{
						isset($error['WARN_INVALID_IMG']) ? $error['WARN_INVALID_IMG']++ : $error['WARN_INVALID_IMG'] = 1;

						return false;
					}
				}
				else
				{
					isset($error['WARN_FILETOOLARGE']) ? $error['WARN_FILETOOLARGE']++ : $error['WARN_FILETOOLARGE'] = 1;

					return false;
				}

				$file['mime_type'] = $imginfo['mime'];
			}
			
			elseif (!in_array($format, $ignored_extensions))
			{
				
				$allowed_mime = array_map('trim', explode(",", strtolower(str_replace("\n", ",", $allowed_mime))));

				if (function_exists('finfo_open'))
				{
					
					$finfo = finfo_open(FILEINFO_MIME);
					$type  = finfo_file($finfo, $file['tmp_name']);

					if (strlen($type) && !in_array($type, $allowed_mime))
					{
						isset($error['WARN_INVALID_MIME']) ? $error['WARN_INVALID_MIME']++ : $error['WARN_INVALID_MIME'] = 1;

						return false;
					}
					$file['mime_type'] = $type;
					finfo_close($finfo);
				}
				elseif (function_exists('mime_content_type'))
				{
					
					$type = mime_content_type($file['tmp_name']);

					if (strlen($type) && !in_array($type, $allowed_mime))
					{
						isset($error['WARN_INVALID_MIME']) ? $error['WARN_INVALID_MIME']++ : $error['WARN_INVALID_MIME'] = 1;

						return false;
					}
					$file['mime_type'] = $type;
				}
				
			}
		}

		$xss_check = file_get_contents($file['tmp_name'], false, null, -1, 256);

		$html_tags = array(
			'abbr', 'acronym', 'address', 'applet', 'area', 'audioscope', 'base', 'basefont', 'bdo', 'bgsound', 'big', 'blackface', 'blink',
			'blockquote', 'body', 'bq', 'br', 'button', 'caption', 'center', 'cite', 'code', 'col', 'colgroup', 'comment', 'custom', 'dd', 'del',
			'dfn', 'dir', 'div', 'dl', 'dt', 'em', 'embed', 'fieldset', 'fn', 'font', 'form', 'frame', 'frameset', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6',
			'head', 'hr', 'html', 'iframe', 'ilayer', 'img', 'input', 'ins', 'isindex', 'keygen', 'kbd', 'label', 'layer', 'legend', 'li', 'limittext',
			'link', 'form', 'map', 'marquee', 'menu', 'meta', 'multicol', 'nobr', 'noembed', 'noframes', 'noscript', 'nosmartquotes', 'object',
			'ol', 'optgroup', 'option', 'param', 'plaintext', 'pre', 'rt', 'ruby', 's', 'samp', 'script', 'select', 'server', 'shadow', 'sidebar',
			'small', 'spacer', 'span', 'strike', 'strong', 'style', 'sub', 'sup', 'table', 'tbody', 'td', 'textarea', 'tfoot', 'th', 'thead', 'title',
			'tr', 'tt', 'ul', 'var', 'wbr', 'xml', 'xmp', '!DOCTYPE', '!--'
		);

		
		foreach ($html_tags AS $tag)
		{
			
			if (stristr($xss_check, '<' . $tag . ' ') || stristr($xss_check, '<' . $tag . '>'))
			{
				isset($error['WARN_IEXSS']) ? $error['WARN_IEXSS']++ : $error['WARN_IEXSS'] = 1;

				return false;
			}
		}

		

		return true;
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

	public static function checkEditor($name)
	{
		
		$name = JFilterInput::getInstance()->clean($name, 'cmd');
		$path = JPATH_PLUGINS . '/editors/' . $name . '.php';

		if (!JFile::exists($path))
		{
			$path = JPATH_PLUGINS . '/editors/' . $name . '/' . $name . '.php';
			if (!JFile::exists($path))
			{
				return false;
			}
		}

		$db = JFactory::getDbo();
		
		$query = $db->getQuery(true);
		$query->select('element');
		$query->from('#__extensions');
		$query->where('element = ' . $db->quote($name));
		$query->where('folder = ' . $db->quote('editors'));
		$query->where('enabled = 1');

		
		$db->setQuery($query, 0, 1);
		$editor = $db->loadResult();
		if (!$editor)
		{
			return false;
		}

		return true;
	}

	public static function getFieldAction($actionId)
	{
		$db    = JFactory::getDbo();
		$query = 'SELECT * FROM #__juform_fields_actions WHERE id = ' . $actionId;
		$db->setQuery($query);

		return $db->loadObject();
	}

	public static function getFieldActions($form_id)
	{
		if (!$form_id)
		{
			return false;
		}

		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('action.*')
			->from('#__juform_fields_actions AS action')
			->join('', '#__juform_fields AS field ON field.id = action.field_id')
			->where('field.form_id = ' . $form_id)
			->order('ordering');
		$db->setQuery($query);

		return $db->loadObjectList();
	}

	public static function getFieldConditions($actionId)
	{
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('*')
			->from('#__juform_fields_conditions')
			->where('action_id = ' . $db->quote($actionId));
		$db->setQuery($query);

		return $db->loadObjectList();
	}

	
	public static function getEmails($formId)
	{
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('*')
			->from('#__juform_emails')
			->where('form_id = ' . $db->quote($formId))
			->order('ordering');
		$db->setQuery($query);

		return $db->loadObjectList();
	}

	public static function getEmail($emailId)
	{
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('*')
			->from('#__juform_emails')
			->where('id = ' . $db->quote($emailId));
		$db->setQuery($query);

		return $db->loadObject();
	}

	public static function getEmailConditions($emailId)
	{
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('*')
			->from('#__juform_emails_conditions')
			->where('email_id = ' . $db->quote($emailId));
		$db->setQuery($query);

		return $db->loadObjectList();
	}

	public static function getFieldCalculations($formId)
	{
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('*')
			->from('#__juform_fields_calculations')
			->where('form_id = ' . $db->quote($formId))
			->order('ordering');
		$db->setQuery($query);

		return $db->loadObjectList();
	}

	public static function getFieldCalculation($emailId)
	{
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('*')
			->from('#__juform_fields_calculations')
			->where('id = ' . $db->quote($emailId));
		$db->setQuery($query);

		return $db->loadObject();
	}

	public static function getTemplates()
	{
		$db    = JFactory::getDbo();
		$query = 'SELECT * FROM #__juform_plugins WHERE type="template"';
		$db->setQuery($query);

		return $db->loadObjectList();
	}

	public static function getMenuItem($menuId)
	{
		$menuId = (int) $menuId;

		if (!$menuId)
		{
			return null;
		}

		$db    = JFactory::getDbo();
		$query = 'SELECT * FROM #__menu WHERE id = ' . $menuId;
		$db->setQuery($query);

		return $db->loadObject();
	}

	public static function silentPost($url, $data, $params = array())
	{
		$url_info  = parse_url($url);
		$useragent = 'JUForm';
		$timeout   = isset($params['timeout']) ? (int) $params['timeout'] : 10;
		$method    = isset($params['method']) ? strtoupper($params['method']) : 'POST';

		if (isset($url_info['host']) && $url_info['host'] == 'localhost')
			$url_info['host'] = '127.0.0.1';

		
		if (extension_loaded('curl'))
		{
			
			$ch = @curl_init();

			if ($method == 'GET' && $data)
				$url .= (strpos($url, '?') === false ? '?' : '&') . $data;
			elseif ($method == 'POST')
				@curl_setopt($ch, CURLOPT_POST, true);

			
			@curl_setopt($ch, CURLOPT_URL, $url);
			@curl_setopt($ch, CURLOPT_FAILONERROR, 1);
			@curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			@curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
			@curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
			@curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			@curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
			@curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

			
			@curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);

			
			@curl_exec($ch);

			
			@curl_close($ch);

			return true;
		}

		
		if (function_exists('fsockopen'))
		{
			$errno  = 0;
			$errstr = '';

			$port = $url_info['scheme'] == 'https' ? 443 : 80;
			$ssl  = $url_info['scheme'] == 'https' ? 'ssl://' : '';

			
			$fsock = @fsockopen($ssl . $url_info['host'], $port, $errno, $errstr, $timeout);

			if ($fsock)
			{
				
				@stream_set_blocking($fsock, 1);
				@stream_set_timeout($fsock, $timeout);

				if ($method == 'GET')
				{
					if (!isset($url_info['query']))
						$url_info['query'] = '';
					if ($data)
						$url_info['query'] .= ($url_info['query'] ? '&' : '') . $data;
				}

				@fwrite($fsock, $method . ' ' . $url_info['path'] . (!empty($url_info['query']) ? '?' . $url_info['query'] : '') . ' HTTP/1.1' . "\r\n");
				@fwrite($fsock, 'Host: ' . $url_info['host'] . "\r\n");
				@fwrite($fsock, "User-Agent: " . $useragent . "\r\n");
				if ($method == 'POST')
				{
					@fwrite($fsock, "Content-Type: application/x-www-form-urlencoded\r\n");
					@fwrite($fsock, "Content-Length: " . strlen($data) . "\r\n");
				}
				@fwrite($fsock, 'Connection: close' . "\r\n");
				@fwrite($fsock, "\r\n");

				if ($method == 'POST')
					@fwrite($fsock, $data);

				
				@fclose($fsock);

				return true;
			}
		}

		return false;
	}

	public static function parseExpression($expression, $formId, &$fieldIds, $field_idsuffix)
	{
		if ($expression)
		{
			$result = preg_match_all('/{(\w+)}/', $expression, $matches);
			
			if ($result > 0)
			{
				$replaces    = array();
				$replaceTags = array();
				$realTags    = $matches[0];

				foreach ($realTags AS $key => $tag)
				{
					$replaceBy        = 0;
					$fieldObj         = JUFormFrontHelperField::getFieldByFieldName($matches[1][$key], $formId);
					$field            = JUFormFrontHelperField::getField($fieldObj);

					if ($field)
					{
						$field->id_suffix = $field_idsuffix;

						if ($field->folder == "radio")
						{
							$fieldIds[] = '[id^="' . $field->getId() . '"]';
							$replaceBy  = 'parseFloat($("[id^=\'' . $field->getId() . '\']:checked").val())';
						}
						else
						{
							$fieldIds[] = '#' . $field->getId();
							$replaceBy  = 'parseFloat($("#' . $field->getId() . '").val())';
						}
					}

					$replaceTags[] = $tag;
					$replaces[]    = $replaceBy;
				}

				return str_replace($replaceTags, $replaces, $expression);
			}
		}

		return null;
	}

} 