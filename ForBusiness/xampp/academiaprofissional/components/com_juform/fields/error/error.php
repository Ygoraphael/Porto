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

class JUFormFieldError extends JUFormFieldBase
{
	
	public function __construct($field = null, $submission = null)
	{
		$_field = new stdClass();
		if (is_object($field))
		{
			$_field->id = $field->id;
		}
		else
		{
			$_field->id = $field;
		}

		$_field->caption     = JText::_('Error field');
		$_field->description = JText::_('Error field');
		$_field->params      = '';
		$_field->plugin_id   = 0;
		$_field->folder      = 'error';

		return parent::__construct($_field);
	}

	public function canSearch($userID = null)
	{
		return false;
	}

	public function canEdit($userID = null)
	{
		return false;
	}

	public function canSubmit($userID = null)
	{
		return false;
	}

	public function canView($options = array())
	{
		return false;
	}

	public function getInput($fieldValue = null)
	{
		return $this->fetch('input.php', __CLASS__);
	}

	public function getLabel($required = true, $forceShow = false)
	{
		return $this->fetch('label.php', __CLASS__);
	}

	public function getBackendOutput()
	{
		return '';
	}

	protected function getValue()
	{
		return '';
	}

	public function canExport()
	{
		return false;
	}
}