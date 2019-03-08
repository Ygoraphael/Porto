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

class JUFormGenerateTemplate
{
	protected $_template;
	protected $_file;
	public $params;

	public function __construct($template, $params = null)
	{
		$this->_template = $template;
		$this->params    = new JRegistry($params);
	}

	public function getTemplate()
	{
		return $this->_template;
	}

	
	public function loadTemplate($file)
	{
		
		$this->_output = null;

		$template = $this->getTemplate();
		

		
		$file = preg_replace('/[^A-Z0-9_\.-\/]/i', '', $file);

		$layoutFullPath = $themeFullPath = array();
		
		$layoutFullPath[] = JPATH_SITE . '/components/com_juform/templates/' . $template . '/' . $file;
		$layoutFullPath   = array_reverse($layoutFullPath);
		foreach ($layoutFullPath AS $path)
		{
			if (JFile::exists($path))
			{
				$this->_file = $path;
				break;
			}
		}

		if ($this->_file != false)
		{
			
			unset($tpl);
			unset($file);

			
			if (isset($this->this))
			{
				unset($this->this);
			}

			
			ob_start();

			
			
			include $this->_file;

			
			
			$this->_output = ob_get_contents();
			ob_end_clean();

			return $this->_output;
		}
		else
		{
			throw new Exception(JText::sprintf('JLIB_APPLICATION_ERROR_LAYOUTFILE_NOT_FOUND', $file), 500);
		}
	}
}