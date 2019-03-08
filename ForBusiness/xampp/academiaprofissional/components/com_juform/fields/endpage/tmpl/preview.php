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

$validateChangePage   = $this->params->get('validate_on_change_page', 0);
$showNextPrevBtn      = $this->params->get('show_next_prev_btn', 1);
$btnNextLabel         = $this->params->get('next_btn_label', 'Next');
$btnPrevLabel         = $this->params->get('prev_btn_label', 'Prev');
$btnNextAttributesStr = $this->params->get('next_btn_attributes', 'class="btn btn-default"');
$btnPrevAttributesStr = $this->params->get('prev_btn_attributes', 'class="btn btn-default"');

$showSubmitBtn          = $this->params->get('show_submit_btn', 0);
$btnSubmitLabel         = $this->params->get('submit_btn_label', 'Submit');
$showResetBtn           = $this->params->get('show_reset_btn', 0);
$btnResetLabel          = $this->params->get('reset_btn_label', 'Reset');
$btnSubmitAttributesStr = $this->params->get('submit_btn_attributes', 'class="btn btn-default btn-primary"');
$btnResetAttributesStr  = $this->params->get('reset_btn_attributes', 'class="btn btn-default"');

$html = '';
if ($showNextPrevBtn)
{
	$registry = new JRegistry();
	if ($btnNextAttributesStr)
	{
		$registry->loadString($btnNextAttributesStr);
	}
	$class = $registry->get('class', '') ? ' ' . $registry->get('class', '') : '';
	$registry->set('class', 'btn-next-page' . $class);

	$btnNextAttributes = $registry->toString('ini');

	$registry = new JRegistry();
	if ($btnPrevAttributesStr)
	{
		$registry->loadString($btnPrevAttributesStr);
	}
	$class = $registry->get('class', '') ? ' ' . $registry->get('class', '') : '';
	$registry->set('class', 'btn-prev-page' . $class);

	$btnPrevAttributes = $registry->toString('ini');

	$html .= '<button type="button" ' . $btnPrevAttributes . '>' . $btnPrevLabel . '</button>';
	$html .= ' <button type="button" ' . $btnNextAttributes . '>' . $btnNextLabel . '</button>';
}

if ($showSubmitBtn)
{
	$registry = new JRegistry();
	if ($btnSubmitAttributesStr)
	{
		$registry->loadString($btnSubmitAttributesStr);
	}
	$class = $registry->get('class', '') ? ' ' . $registry->get('class', '') : '';
	$registry->set('class', 'btn-submit-form' . $class);
	$submitAttributes = $registry->toString('ini');

	$html .= ' <button type="submit" ' . $submitAttributes . ' onclick="return false;">' . $btnSubmitLabel . '</button>';
}

if ($showResetBtn)
{
	$registry = new JRegistry();
	if ($btnResetAttributesStr)
	{
		$registry->loadString($btnResetAttributesStr);
	}
	$class = $registry->get('class', '') ? ' ' . $registry->get('class', '') : '';
	$registry->set('class', 'btn-reset-form' . $class);

	$resetAttributes = $registry->toString('ini');
	$html .= ' <button type="button" ' . $resetAttributes . '>' . $btnResetLabel . '</button>';
}

echo $html;
?>