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

$this->addAttribute("style", "width: auto; height: auto;", "search");
$this->setAttribute("rows", 2, "search");
$this->setAttribute("cols", 30, "search");

$html = "<textarea id=\"" . $this->getId() . "\" name=\"" . $this->getName() . "\" " . $this->getAttribute(null, null, "search") . ">" . $value . "</textarea>";

echo $html;

?>