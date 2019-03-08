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

class JUFormFieldFreeText extends JUFormFieldBase
{
	public function getPreview()
	{
		if (!$this->isPublished())
		{
			return "";
		}

		$value = $this->params->get('text', '');

		if ($this->params->get('parse_plugin', 1))
		{
			
			
		}

		$this->setVariable('value', $value);

		return $this->fetch('preview.php', __CLASS__);
	}

	public function getInput($fieldValue = null)
	{
		if (!$this->isPublished())
		{
			return "";
		}

		$value = $this->getPredefinedValues();

		
		if($value === null)
		{
			$value = $this->params->get('text', '');
		}

		if ($this->params->get('parse_plugin', 1))
		{
			$params = new JObject(array('submission_id' => $this->submission_id, 'field_id' => $this->id));
			$value  = JHtml::_('content.prepare', $value, $params, 'com_juform.field');
		}

		$this->setVariable('value', $value);

		return $this->fetch('input.php', __CLASS__);
	}

	public function getOutput($options = array())
	{
		if (!$this->isPublished())
		{
			return "";
		}

		$value = $this->getPredefinedValues();

		
		if($value === null)
		{
			$value = $this->params->get('text', '');
		}

		if ($this->params->get('parse_plugin', 1))
		{
			$params = new JObject(array('submission_id' => $this->submission_id, 'field_id' => $this->id));
			$value  = JHtml::_('content.prepare', $value, $params, 'com_juform.field');
		}

		$this->setVariable('value', $value);

		return $this->fetch('output.php', __CLASS__);
	}

	public function getPredefinedValuesHtml()
	{
		$predefined_value = $this->getPredefinedValues(1);
		$predefined_value = @htmlspecialchars($predefined_value, ENT_COMPAT, 'UTF-8');

		return "<textarea name=\"jform[predefined_values]\" rows=\"15\" cols=\"50\">" . $predefined_value . "</textarea>";
	}

	public function storeValue($value)
	{
		return true;
	}

	public function isRequired()
	{
		return null;
	}

	public function isBackendListView()
	{
		return null;
	}

	public function canExport()
	{
		return false;
	}
}

?>