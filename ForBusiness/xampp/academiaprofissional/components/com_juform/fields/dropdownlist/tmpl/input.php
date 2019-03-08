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
	$attrs   = array();
	$attrs[] = $this->getAttribute(null, null, "input");
	$attrs[] = $this->getValidateData();
	$attrs   = implode(' ', $attrs);

	echo JHtml::_('select.genericlist', $options, $this->getName(), $attrs, 'value', 'text', $value, $this->getId());
}
?>