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

JHtml::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_juform/helpers/html');
JHtml::_('behavior.calendar');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.keepalive');

$document = JFactory::getDocument();
$document->addScript(JUri::root(true).'/components/com_juform/assets/jqueryvalidation/jquery.validate.min.js');
$document->addScript(JUri::root(true).'/components/com_juform/assets/jqueryvalidation/additional-methods.min.js');
$document->addScript(JUri::root(true).'/components/com_juform/assets/js/view.form.js');
$document->addStyleSheet(JUri::root(true) . '/components/com_juform/assets/css/view.form.css');

$formIdStr = 'adminForm';
$script = '
	jQuery(document).ready(function ($) {
		$("#' . $formIdStr . '").juformvalidate({formId: "' . $formIdStr . '"});
	});';
$document->addScriptDeclaration($script);

$this->JUFormTemplate->setupFieldAction('adminForm');
$this->JUFormTemplate->setupFieldCalculation();
?>
<script type="text/javascript">
	Joomla.submitbutton = function (task) {
		if (task == 'submission.cancel') {
			jQuery('#adminForm').removeData("validator");
			Joomla.submitform(task, document.getElementById('adminForm'));
		}else{
			var form = document.getElementById('adminForm');
			if (typeof(task) !== 'undefined' && task !== "") {
				form.task.value = task;
			}

			juFormSubmit();
		}
	};
</script>

<div id="iframe-help"></div>

<div id="jufm-container" class="jubootstrap component jufm-container view-form jufm-form">
	<form action="<?php echo JRoute::_('index.php?option=com_juform');?>"
		enctype="multipart/form-data" method="post" name="adminForm" id="adminForm" class="form-vertical">
		<?php
		if($this->pages)
		{
			$page_id = 0;
			foreach($this->pages AS $page)
			{
				
				$isInPage = false;
				if ($page['beginfield'] || $page['endfield'])
				{
					$isInPage = true;
					$page_id++;
				}

				if($isInPage)
				{
					echo '<div class="juform-page' . ($page_id == 1 ? ' active' : '') . '">';

					echo '<div class="control-group field-group">';
					echo $page['beginfield']->getLabel();
					echo '<div class="controls">';
					echo $page['beginfield']->getInput();
					echo '</div>';
					echo '</div>';
				}

				$fields = isset($page['fields']) ? $page['fields'] : array();

				foreach($fields AS $field)
				{
					if ($field->canSubmit())
					{
						echo '<div class="control-group field-group">';
						echo $field->getLabel();
						echo '<div class="controls">';
						echo $field->getModPrefixText();
						if (isset($this->fieldsData[$field->field_name]))
						{
							$field->value_input_default = $this->fieldsData[$field->field_name];
						}
						echo $field->getInput();
						echo $field->getModSuffixText();
						echo $field->getCountryFlag();
						echo $field->getInvalidHtml();
						echo '</div>';
						echo '</div>';
					}
				}

				if($isInPage)
				{
					echo '<div class="control-group field-group">';
					echo $page['endfield']->getLabel();
					echo '<div class="controls">';
					echo $page['endfield']->getInput();
					echo '</div>';
					echo '</div>';

					echo '</div>';
				}
			}
		}
		?>
		<div>
			<input type="hidden" name="id" value="<?php echo $this->item->id; ?>" />
			<input type="hidden" name="task" value="submission.save" />
			<input type="hidden" name="hidden_field" value=""/>
			<?php echo JHtml::_('form.token'); ?>
		</div>
	</form>
</div>