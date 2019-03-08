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

class JUFormFieldEndPage extends JUFormFieldBase
{
	public function getPreview()
	{
		return $this->fetch('preview.php', __CLASS__);
	}

	public function getInput($fieldValue = null)
	{
		if (!$this->isPublished())
		{
			return "";
		}

		return $this->fetch('input.php', __CLASS__);
	}

	public function getOutput($options = array())
	{
		if (!$this->isPublished())
		{
			return "";
		}

		return $this->fetch('output.php', __CLASS__);
	}

	public function getSearchInput($defaultValue = "")
	{
		return null;
	}

	public function getPredefinedValuesHtml()
	{
		return null;
	}

	public function storeValue($value)
	{
		return true;
	}

	public function canEdit($userID = null)
	{
		return false;
	}

	public function isRequired()
	{
		return null;
	}

	public function isBackendListView()
	{
		return null;
	}

	public function isHide()
	{
		return null;
	}

	public function getPlaceholderValue(&$email = null)
	{
		return false;
	}

	public function canExport()
	{
		return false;
	}
}

?>