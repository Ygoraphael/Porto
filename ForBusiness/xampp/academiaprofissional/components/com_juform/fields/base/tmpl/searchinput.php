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


if ($this->params->get("is_numeric", 0))
{
	$this->setAttribute("class", "input-small", "search");

	$defaultValueFrom = isset($defaultValue["from"]) ? $defaultValue["from"] : "";
	$this->setAttribute("value", $defaultValueFrom, "search");
	$html = "<div class=\"input-prepend\" style=\"margin-right: 5px;\">";
	$html .= "<span class=\"add-on from\">";
	$html .= JText::_('COM_JUFORM_FROM');
	$html .= "</span>";
	$html .= "<input id=\"" . $this->getId() . "_from\" name=\"" . $this->getName() . "[from]\" " . $this->getAttribute(null, null, "search") . " />";
	$html .= "</div>";

	$defaultValueTo = isset($defaultValue["to"]) ? $defaultValue["to"] : "";
	$this->setAttribute("value", $defaultValueTo, "search");
	$html .= "<div class=\"input-prepend\">";
	$html .= "<span class=\"add-on to\">";
	$html .= JText::_('COM_JUFORM_TO');
	$html .= "</span>";
	$html .= "<input id=\"" . $this->getId() . "_to\" name=\"" . $this->getName() . "[to]\" " . $this->getAttribute(null, null, "search") . " />";
	$html .= "</div>";
}
else
{
	if ($this->params->get("placeholder", ""))
	{
		$placeholder = htmlspecialchars($this->params->get("placeholder", ""), ENT_COMPAT, 'UTF-8');
		$this->setAttribute("placeholder", $placeholder, "input");
	}

	$this->setAttribute("value", htmlspecialchars($defaultValue, ENT_COMPAT, 'UTF-8'), "search");

	$html = "<input id=\"" . $this->getId() . "\" name=\"" . $this->getName() . "\" " . $this->getAttribute(null, null, "search") . " />";
}

echo $html;
?>