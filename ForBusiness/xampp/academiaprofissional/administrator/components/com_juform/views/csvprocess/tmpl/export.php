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
JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidator');
$document = JFactory::getDocument();
$document->addScript(JUri::root(true).'/components/com_juform/assets/js/jquery.dragsort.min.js');
?>

<script type="text/javascript">
	Joomla.submitbutton = function (task)
    {
		if (task == 'csvprocess.cancel' || task == 'csvprocess.export' || document.formvalidator.isValid(document.getElementById("adminForm"))) {
			Joomla.submitform(task, document.getElementById('adminForm'));
		}
	};

    jQuery(document).ready(function($)
    {
        $('input[name="checkall-toggle"]').click(function(){
            var c = $(this).attr('sub-checkbox');
            if($(this).prop('checked')==false){
                $('.'+c).prop('checked', false);
            }else{
                $('.'+c).prop('checked', true);
            }
        });

        $("table.table tbody").dragsort({ dragSelector: "tr", placeHolderTemplate: "<tr class='placeHolder'><td></td></tr>", dragSelectorExclude: "input,label" });
    });
</script>

<div class="jubootstrap">
	<?php echo JUFormHelper::getMenu(JFactory::getApplication()->input->get('view')); ?>

	<div id="iframe-help"></div>

	<form action="#" method="post" name="adminForm" id="adminForm" class="form-validate" enctype="multipart/form-data">

		<div class="span4">
			<fieldset class="adminform">
				<legend><?php echo JText::_("COM_JUFORM_CSV_EXPORT_SETTINGS"); ?></legend>
					<?php
					foreach ($this->exportForm->getFieldset('details') AS $field)
					{
						echo $field->getControlGroup();
					}
					?>
			</fieldset>
		</div>

		<div class="span8">
            <legend><?php echo JText::_("COM_JUFORM_FIELDS_TO_EXPORT"); ?></legend>
            <?php
            $fields = $this->model->getFields();
            
            if ($fields)
            {
            ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
	                        <th width="1%">
		                        <i class="icon-menu-2"></i>
	                        </th>
                            <th width="1%">
                                <input type="checkbox" sub-checkbox="core_field" id="core_field_toggle" title="<?php echo JText::_('COM_JUFORM_CHECK_ALL'); ?>" value="" name="checkall-toggle" checked/>
                            </th>
                            <th>
                                <?php echo JText::_('COM_JUFORM_FIELD_NAME'); ?>
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        foreach ($fields AS $key => $field)
                        {
                            if (is_object($field)) {
                                if(!$field->canExport()){
                                    continue;
                                }

                                $value = $field->id;
                                $label = $field->getCaption(true);
                            } else {
                                $value = $field;
                                $label = ucfirst(str_replace('_', ' ', $field));
                            }

                            ?>
                            <tr>
	                            <td>
		                            <i class="icon-menu"></i>
	                            </td>
                                <td>
                                    <input type="checkbox" class="core_field" checked
                                           onclick="Joomla.isChecked(this.checked);" value="<?php echo $value; ?>"
                                           name="col[]" id="cb<?php echo $key; ?>"/>
                                </td>
                                <td>
                                    <label for="cb<?php echo $key; ?>"><?php echo $label; ?></label>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            <?php
            }
            ?>
		</div>

		<div class="clr clearfix"></div>

		<div>
			<input type="hidden" name="task" value="" />
            <input type="hidden" name="boxchecked" value="0" />
            <?php echo JHtml::_('form.token'); ?>
		</div>
	</form>
</div>