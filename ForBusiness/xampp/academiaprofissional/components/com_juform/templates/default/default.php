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

$this->page_id = 0;

$columns = $this->params->get('columns', 1);
$columnArray = JUFormFrontHelper::getBootstrapColumns($columns);
// Label/Input width in bootstrap cols
$this->labelWidth = $this->params->get('label_width', 2);
$this->inputWidth = 12 - $this->labelWidth;

echo '<div class="default form-' . $this->params->get('layout', 'horizontal') . '">';
// Page contains beginfield, endfield, and all other fields in page
foreach ($this->pages AS $page)
{
	// All field objects in current page
	$fields = isset($page['fields']) ? $page['fields'] : array();

	$totalFieldsPerPage = count($fields);

	//$fieldsPerColumn = ceil($totalFieldsPerPage / $columns);

	// If has begin/end field => increase page_id (multi page form)
	$isInPage = false;
	if ($page['beginfield'] || $page['endfield'])
	{
		$isInPage = true;
		$this->page_id++;
	}

	if ($isInPage)
	{
		$this->field = $page['beginfield'];
		echo $this->loadTemplate('beginpage.php');
	}

	// Number of tab add to code in field.php to generate nice code
	$this->tab = 1;

	if ($columns > 1)
	{
		$this->tab = 3;
	}

	foreach ($fields AS $i => $field)
	{
		if ($columns > 1 && (($i + 1) % $columns == 1))
		{
			echo "\n\t<div class=\"row\">";
		}

		if ($columns > 1)
		{
			echo "\n\t\t<div class=\"col-md-" . $columnArray[$i % $columns] . "\">";
		}

		$this->field = $field;
		echo $this->loadTemplate('field.php');

		if ($columns > 1)
		{
			echo "\t\t</div>";
			echo "\n";
		}

		if ($columns > 1 && (($i + 1) % $columns == 0 || ($i + 1) == $totalFieldsPerPage))
		{
			echo "\t</div>";
			echo "\n";
			echo "\n";
		}
	}

	if ($isInPage)
	{
		$this->field = $page['endfield'];
		echo $this->loadTemplate('endpage.php');
	}
}
echo "\n" . '</div>';