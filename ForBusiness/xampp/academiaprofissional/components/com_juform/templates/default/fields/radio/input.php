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

$html = "";
if ($options)
{
	$number_columns = $this->params->get("number_columns", 0);
	if (!$number_columns)
	{
		foreach ($options AS $key => $option)
		{
			if ($option->text == strtoupper($option->text))
			{
				$text = JText::_($option->text);
			}
			else
			{
				$text = $option->text;
			}
			$text = htmlspecialchars($text, ENT_COMPAT, 'UTF-8');

			$this->setAttribute("value", htmlspecialchars($option->value, ENT_COMPAT, 'UTF-8'), "input");

			if ($option->value === $value)
			{
				$this->setAttribute("checked", "checked", "input");
			}
			else
			{
				$this->setAttribute("checked", null, "input");
			}

			if ((isset($option->disabled) && $option->disabled))
			{
				$this->setAttribute("disabled", "disabled", "input");
			}
			else
			{
				$this->setAttribute("disabled", null, "input");
			}

			if ($key == 0)
			{
				$input = "<input id=\"" . $this->getId() . '_' . $option->value . "\" name=\"" . $this->getName() . "\" " . $this->getAttribute(null, null, "input") . "
				" . $this->getValidateData() . "/>";
			}
			else
			{
				$input = "<input id=\"" . $this->getId() . '_' . $option->value . "\" name=\"" . $this->getName() . "\" " . $this->getAttribute(null, null, "input") . " />";
			}

			$html .= "<label class=\"radio-inline\" for=\"" . $this->getId() . '_' . $option->value . "\">$input $text</label>";
		}
	}
	else
	{
		$html .= '<ul class="radio-box">';
		$width = 100 / (int) $number_columns;
		foreach ($options AS $key => $option)
		{
			$html .= '<li class="" style="width: ' . $width . '%; float: left; clear: none;" >';
			if ($option->text == strtoupper($option->text))
			{
				$text = JText::_($option->text);
			}
			else
			{
				$text = $option->text;
			}
			// Check box text accept HTML tags, uncomment line bellow if you want to convert special characters to HTML entities
			//$text = htmlspecialchars($text, ENT_COMPAT, 'UTF-8');

			$this->setAttribute("value", htmlspecialchars($option->value, ENT_COMPAT, 'UTF-8'), "input");

			if ($option->value === $value)
			{
				$this->setAttribute("checked", "checked", "input");
			}
			else
			{
				$this->setAttribute("checked", null, "input");
			}

			if ((isset($option->disabled) && $option->disabled))
			{
				$this->setAttribute("disabled", "disabled", "input");
			}
			else
			{
				$this->setAttribute("disabled", null, "input");
			}

			if ($key == 0)
			{
				$input = "<input id=\"" . $this->getId() . '_' . $option->value . "\" name=\"" . $this->getName() . "\" " . $this->getAttribute(null, null, "input") . "
				" . $this->getValidateData() . "/>";
			}
			else
			{
				$input = "<input id=\"" . $this->getId() . '_' . $option->value . "\" name=\"" . $this->getName() . "\" " . $this->getAttribute(null, null, "input") . " />";
			}

			$html .= "<label class=\"radio\" for=\"" . $this->getId() . '_' . $option->value . "\">$input $text</label>";
			$html .= "</li>";
		}
		$html .= "</ul>";
	}

	echo $html;
}
?>