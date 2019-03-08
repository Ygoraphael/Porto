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

if ($this->field)
{
	$tabStr = str_repeat("\t", 1);
	echo "\n" . $tabStr . '<?php';
	echo "\n" . $tabStr . '$field = $this->getField("' . $this->field->field_name . '");';
	echo "\n" . $tabStr . 'if ($field && $field->canSubmit())';
	echo "\n" . $tabStr . '{';
	echo "\n" . $tabStr . '?>';
	echo "\n" . $tabStr . '<div class="form-group field-group" <?php echo $field->isHide() ? \'style="display: none;"\' : \'\'; ?>>';
	echo "\n\t" . $tabStr . '<?php';
	if($this->params->get('layout', 'horizontal') == 'horizontal')
	{
		echo "\n\t\t" . $tabStr . '$field->addAttribute("class", "col-sm-' . $this->labelWidth . '", "label");';
	}
	echo "\n\t\t" . $tabStr . 'echo $field->getLabel();';
	echo "\n\t" . $tabStr . '?>';
	if($this->params->get('layout', 'horizontal') == 'horizontal')
	{
		echo "\n\t" . $tabStr . '<div class="field-input col-sm-' . $this->inputWidth . '">';
	}
	else
	{
		echo "\n\t" . $tabStr . '<div class="field-input">';
	}
	echo "\n\t\t" . $tabStr . '<?php';
	//echo "\n\t\t\t" . $tabStr . '$field->addAttribute("class", "form-control", "input");';
	echo "\n\t\t\t" . $tabStr . 'echo $field->getModPrefixText();';
	echo "\n\t\t\t" . $tabStr . 'echo $field->getInput();';
	echo "\n\t\t\t" . $tabStr . 'echo $field->getModSuffixText();';
	echo "\n\t\t" . $tabStr . '?>';
	echo "\n\t" . $tabStr . '</div>';
	echo "\n" . $tabStr . '</div>';
	echo "\n" . $tabStr . '<?php';
	echo "\n" . $tabStr . '}';
	echo "\n" . $tabStr . '?>';
}
echo "\n" . '</div>';
echo "\n" . '<!-- End Page ' . $this->page_id . ' -->';
echo "\n";