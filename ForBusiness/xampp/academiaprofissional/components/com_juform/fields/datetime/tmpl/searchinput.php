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

$this->setAttribute("class", "input-medium", "search");

$valueFrom = isset($value["from"]) ? $value["from"] : "";
$html      = JHtml::_('juformadministrator.calendar', $valueFrom, $this->getName() . '[from]', $this->getId() . '_from', '%Y-%m-%d %H:%M:%S', $this->getAttribute(null, null, "search"));

$html .= "<span class=\"to\"> <i class=\"icon-arrow-right-4\"></i> </span>";

$valueTo = isset($value["to"]) ? $value["to"] : "";
$html .= JHtml::_('juformadministrator.calendar', $valueTo, $this->getName() . '[to]', $this->getId() . '_to', '%Y-%m-%d %H:%M:%S', $this->getAttribute(null, null, "search"));

echo $html;

?>