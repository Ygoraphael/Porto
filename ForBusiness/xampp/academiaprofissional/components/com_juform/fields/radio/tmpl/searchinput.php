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

if ($options)
{
	$html           = "<fieldset id=\"" . $this->getId() . "\" class=\"checkboxes\">";
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

			$this->setAttribute("type", "checkbox", "search");

			$this->setAttribute("value", htmlspecialchars($option->value, ENT_COMPAT, 'UTF-8'), "search");

			if (in_array($option->value, $value, true))
			{
				$this->setAttribute("checked", "checked", "search");
			}
			else
			{
				$this->setAttribute("checked", null, "search");
			}

			$input = "<input id=\"" . $this->getId() . $key . "\" name=\"" . $this->getName() . "[]\" " . $this->getAttribute(null, null, "search") . " />";
			$html .= "<label class=\"radio inline\" for=\"" . $this->getId() . $key . "\">$input $text</label>";
		}
	}
	else
	{
		$html .= "<ul class='nav'>";
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

			if ($number_columns)
			{
				$width = 100 / (int) $number_columns;
				$html .= '<li style="width:' . $width . '%; float: left; clear: none;" >';
			}
			else
			{
				$html .= "<li>";
			}

			$this->setAttribute("type", "checkbox", "search");

			$this->setAttribute("value", htmlspecialchars($option->value, ENT_COMPAT, 'UTF-8'), "search");

			if (in_array($option->value, $value, true))
			{
				$this->setAttribute("checked", "checked", "search");
			}
			else
			{
				$this->setAttribute("checked", null, "search");
			}

			$input = "<input id=\"" . $this->getId() . $key . "\" name=\"" . $this->getName() . "[]\" " . $this->getAttribute(null, null, "search") . " />";
			$html .= "<label class=\"radio\" for=\"" . $this->getId() . $key . "\">$input $text</label>";
			$html .= "</li>";
		}

		$html .= "</ul>";
	}
	$html .= "</fieldset>";

	echo $html;
}
?>