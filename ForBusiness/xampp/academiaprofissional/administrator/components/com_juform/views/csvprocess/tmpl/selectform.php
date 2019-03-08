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
JHtml::_('behavior.formvalidator');
JHtml::_('behavior.keepalive');
JHtml::_('behavior.multiselect');
JHtml::_('behavior.tooltip');
?>

<script type="text/javascript">
    Joomla.submitbutton = function (task)
    {
        if (task == 'csvprocess.cancel' || document.formvalidator.isValid(document.getElementById("adminForm"))) {
            Joomla.submitform(task, document.getElementById('adminForm'));
        }
    };
</script>

<div class="jubootstrap">
    <?php echo JUFormHelper::getMenu(JFactory::getApplication()->input->get('view')); ?>

    <div id="iframe-help"></div>

    <form action="#" method="post" name="adminForm" id="adminForm" class="form-validate" enctype="multipart/form-data">
        <div class="control-group">
            <label class="control-label" for="form-id"><?php echo JText::_('COM_JUFORM_SELECT_FORM'); ?></label>
            <select name="form_id" class="required" id="form-id">
                <option value=""><?php echo JText::_('COM_JUFORM_SELECT_FORM'); ?></option>
                <?php echo JHtml::_('select.options', $this->formOptions, 'value', 'text'); ?>
            </select>
        </div>
        <div>
            <input type="hidden" name="task" value="" />
            <input type="hidden" name="boxchecked" value="0" />
            <?php echo JHtml::_('form.token'); ?>
        </div>
    </form>
</div>