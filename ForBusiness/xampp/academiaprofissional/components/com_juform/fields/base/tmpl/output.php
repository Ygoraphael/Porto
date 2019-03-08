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


if (is_array($values))
{
	if (!count($values))
	{
		return "";
	}

	$html = "<ul class='nav' " . $this->getAttribute(null, null, "output") . ">";
	foreach ($values AS $value)
	{
		$html .= "<li>" . $value . "</li>";
	}
	$html .= "</ul>";
}

else
{
	if ($values === "")
	{
		return "";
	}

	if ($this->params->get("is_numeric", 0))
	{
		$totalNumbers  = $this->params->get("digits_in_total", 11);
		$decimals      = $this->params->get("decimals", 2);
		$dec_point     = $this->params->get("dec_point", ".");
		$thousands_sep = $this->params->get("use_thousands_sep", 0) ? $this->params->get("thousands_sep", ",") : "";
		
		$html_values = $this->numberFormat($values, $totalNumbers, $decimals, $dec_point, $thousands_sep);
	}
	else
	{
		$html_values = $values;
	}

	$html = "<div " . $this->getAttribute(null, null, "output") . " >";
	$html .= $html_values;
	$html .= "</div>";
}

echo $html;
?>