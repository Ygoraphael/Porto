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

$canDownload = $this->canDownload();
$html        = '<ul class="field-files file-list" ' . $this->getAttribute(null, null, "output") . '>';
foreach ($files AS $key => $file)
{
	$fileTitle = $file->title ? $file->title : ($file->name ? $file->name : $file->id);
	$html .= '<li>';
	$href = JRoute::_("index.php?option=com_juform&task=rawdata&function=downloadFile&submission_id=" . $this->submission_id . "&field_id=" . $this->id . "&file_id=" . $file->id);
	$html .= $canDownload ? '<a href="' . $href . '" title="' . JText::_('COM_JUFORM_DOWNLOAD') . '" target="_blank" >' . $fileTitle . '</a>' : $fileTitle;
	if ($this->params->get("show_download_counter_output", 0))
	{
		$html .= ' - <span class="downloads">' . JText::plural('COM_JUFORM_N_DOWNLOAD', $file->downloads) . '</span>';
	}
	$html .= '</li>';
}
$html .= '</ul>';
echo $html;
?>