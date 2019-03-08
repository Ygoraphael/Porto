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

$html = '<ul class="image-list output field-images" ' . $this->getAttribute(null, null, "output") . '>';
foreach ($images AS $key => $image)
{
	if (!$image->published)
	{
		continue;
	}

	$originalImage = $attach_dir . $image->name;
	$resizedImage  = $this->renderImages($originalImage);
	if ($key == 0)
	{
		$class = " first";
	}
	elseif ($key == count($images) - 1)
	{
		$class = " last";
	}
	else
	{
		$class = "";
	}

	$description = '';
	if ($image->title)
	{
		$description .= "<h4 class='img-title'>" . htmlspecialchars($image->title, ENT_QUOTES) . "</h4>";
	}

	if ($image->description)
	{
		$description .= "<div class='img-description'>" . htmlspecialchars($image->description, ENT_QUOTES) . '</div>';
	}

	$html .= "<li class='" . $class . "'>";
	$html .= '<a href="' . $originalImage . '" class="item-image" data-fancybox-group="group-' . $this->submission_id . '-' . $this->id . '" title="' . $description . '">
				<img src="' . $resizedImage . '" alt="' . htmlspecialchars($image->title, ENT_QUOTES) . '" />
			</a>';
	$html .= "</li>";
}

$html .= '</ul>';

echo $html;

?>