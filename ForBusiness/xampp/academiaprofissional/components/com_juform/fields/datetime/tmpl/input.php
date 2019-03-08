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


$attribs = $this->getAttribute(null, null, "input", "array");

$readonly = isset($attribs['readonly']) && $attribs['readonly'] == 'readonly';
$disabled = isset($attribs['disabled']) && $attribs['disabled'] == 'disabled';

if (is_array($attribs))
{
	$attribs = JArrayHelper::toString($attribs);
}


$datetime = DateTime::createFromFormat($format, $value);
if($datetime)
{
	$value_sqlformat = $datetime->format('Y-m-d H:i:s');
}
else
{
	$value_sqlformat = '';
}

if (!$readonly && !$disabled)
{
	$html = '<div class="input-append">';
	$html .= '<input type="text" title="' . (0 !== (int) $value ? JHtml::_('date', $value_sqlformat, null, null) : '') . '" name="' . $this->getName() . '" id="' . $this->getId() . '"';
	$html .= ' value="' . (0 !== (int) $value ? $value : '') . '" ' . $attribs . ' ' . $this->getValidateData() . '/>';
	$html .= '<span class="add-on btn icon-calendar fa fa-calendar" id="' . $this->getId() . '_show"></span>';
	$html .= '</div>';
}
else
{
	$html = '<div class="input-append">';
	$html .= '<input type="text" title="' . (0 !== (int) $value ? JHtml::_('date', $value_sqlformat, null, null) : '')
		. '" value="' . (0 !== (int) $value ? $value : '') . '" ' . $attribs
		. ' /><input type="hidden" name="' . $this->getName() . '" id="' . $this->getId() . '" value="' . (0 !== (int) $value ? $value : '') . '" />';
	$html .= '</div>';
}

echo $html;
?>