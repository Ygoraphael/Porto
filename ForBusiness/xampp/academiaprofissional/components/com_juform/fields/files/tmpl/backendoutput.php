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

$html = '';

$html .= '<div class="field-files">';
if ($files)
{
	$totalDownload = 0;
	foreach ($files AS $file)
	{
		$totalDownload += $file->downloads;
	}

	$html .= '<span class="total-file">' . JText::plural('COM_JUFORM_N_FILES', count($files)) . '</span>';
	$html .= '<span class="total-download">' . JText::plural('COM_JUFORM_N_DOWNLOAD', $totalDownload) . '</span>';
}
else
{
	$html .= JText::_('COM_JUFORM_NO_FILE');
}
$html .= '</div>';
echo $html;
?>