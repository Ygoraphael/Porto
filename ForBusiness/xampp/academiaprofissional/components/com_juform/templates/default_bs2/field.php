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

$tabStr = str_repeat("\t", $this->tab);
echo "\n" . $tabStr . '<!-- Begin Field ' . $this->field->getCaption(true) . ' -->';
echo "\n" . $tabStr . '<?php';
echo "\n" . $tabStr . '$field = $this->getField("' . $this->field->field_name . '");';
echo "\n" . $tabStr . 'if ($field && $field->canSubmit())';
echo "\n" . $tabStr . '{';
echo "\n" . $tabStr . '?>';
echo "\n" . $tabStr . '<div class="control-group field-group" <?php echo $field->isHide() ? \'style="display: none;"\' : \'\'; ?>>';
echo "\n\t" . $tabStr . '<?php';
echo "\n\t\t" . $tabStr . 'echo $field->getLabel();';
echo "\n\t" . $tabStr . '?>';
echo "\n\t" . $tabStr . '<div class="controls field-input">';
echo "\n\t\t" . $tabStr . '<?php';
echo "\n\t\t\t" . $tabStr . 'echo $field->getModPrefixText();';
echo "\n\t\t\t" . $tabStr . 'echo $field->getInput();';
echo "\n\t\t\t" . $tabStr . 'echo $field->getModSuffixText();';
echo "\n\t\t\t" . $tabStr . 'echo $field->getInvalidHtml();';
echo "\n\t\t" . $tabStr . '?>';
echo "\n\t" . $tabStr . '</div>';
echo "\n" . $tabStr . '</div>';
echo "\n" . $tabStr . '<?php';
echo "\n" . $tabStr . '}';
echo "\n" . $tabStr . '?>';
echo "\n" . $tabStr . '<!-- End Field ' . $this->field->getCaption(true) . ' -->';
echo "\n";