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

$btnSubmitLabel         = $this->params->get('submit_btn_label', 'Submit');
$showResetBtn           = $this->params->get('show_reset_btn', 0);
$btnResetLabel          = $this->params->get('reset_btn_label', 'Reset');
$btnSubmitAttributesStr = $this->params->get('submit_btn_attributes', 'class="btn btn-default btn-primary"');
$btnResetAttributesStr  = $this->params->get('reset_btn_attributes', 'class="btn btn-default"');

$showNextPrevBtn      = $this->params->get('show_next_prev_btn', 0);
$btnNextLabel         = $this->params->get('next_btn_label', 'Next');
$btnPrevLabel         = $this->params->get('prev_btn_label', 'Prev');
$btnNextAttributesStr = $this->params->get('next_btn_attributes', 'class="btn btn-default"');
$btnPrevAttributesStr = $this->params->get('prev_btn_attributes', 'class="btn btn-default"');
$validateOnChangePage = $this->params->get('validate_on_change_page', '0');

$html = '';

if ($showNextPrevBtn)
{
	$registry = new JRegistry();
	if ($btnPrevAttributesStr)
	{
		$registry->loadString($btnPrevAttributesStr);
	}
	$class = $registry->get('class', '') ? ' ' . $registry->get('class', '') : '';
	$registry->set('class', 'btn-prev-page' . $class);

	$onclick = $registry->get('onclick', '') ? ' ' . $registry->get('onclick', '') : '';
	$registry->set('onclick', 'JUFormPrevPage(this, ' . $validateOnChangePage . ');' . $onclick . ' return false;');
	$btnPrevAttributes = $registry->toString('ini');

	$registry = new JRegistry();
	if ($btnNextAttributesStr)
	{
		$registry->loadString($btnNextAttributesStr);
	}
	$class = $registry->get('class', '') ? ' ' . $registry->get('class', '') : '';
	$registry->set('class', 'btn-next-page' . $class);

	$onclick = $registry->get('onclick', '') ? ' ' . $registry->get('onclick', '') : '';
	$registry->set('onclick', 'JUFormNextPage(this, ' . $validateOnChangePage . ');' . $onclick . ' return false;');
	$btnNextAttributes = $registry->toString('ini');
}

if ($showNextPrevBtn)
{
	$html .= '<button type="button" ' . $btnPrevAttributes . '>' . $btnPrevLabel . '</button>';
}

$registry = new JRegistry();
if ($btnSubmitAttributesStr)
{
	$registry->loadString($btnSubmitAttributesStr);
}
$class = $registry->get('class', '') ? ' ' . $registry->get('class', '') : '';
$registry->set('class', 'btn-submit-form' . $class);
$submitAttributes = $registry->toString('ini');

$html .= ' <button type="submit" ' . $submitAttributes . '>' . $btnSubmitLabel . '</button>';

if ($showResetBtn)
{
	$registry = new JRegistry();
	if ($btnResetAttributesStr)
	{
		$registry->loadString($btnResetAttributesStr);
	}
	$class = $registry->get('class', '') ? ' ' . $registry->get('class', '') : '';
	$registry->set('class', 'btn-reset-form' . $class);

	$onclick = $registry->get('onclick', '') ? ' ' . $registry->get('onclick', '') : '';
	$registry->set('onclick', 'juFormReset(this);' . $onclick . ' return false;');
	$resetAttributes = $registry->toString('ini');
	$html .= ' <button type="button" ' . $resetAttributes . '>' . $btnResetLabel . '</button>';
}

if ($showNextPrevBtn)
{
	$html .= ' <button type="button" ' . $btnNextAttributes . '>' . $btnNextLabel . '</button>';
}

echo $html;
?>