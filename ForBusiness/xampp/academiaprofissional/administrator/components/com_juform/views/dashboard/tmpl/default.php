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

JHtml::_('behavior.multiselect');
JHtml::_('behavior.tooltip');

$model = $this->getModel();
$statistics = $this->get('Statistics');
$lastCreatedForms = $model->getForms("lastCreatedForms");
$lastModifiedForms = $model->getForms("lastModifiedForms");
?>

<div id="iframe-help"></div>

<div class="adminform" id="adminForm">
<div class="cpanel-left">
<div id="position-icon" class="pane-sliders">

<?php if (JUFormHelper::checkGroupPermission(null, "forms"))
{
	?>
	<div class="cpanel">
		<div class="icon-wrapper">
			<div class="icon">
				<a href="<?php echo JRoute::_('index.php?option=com_juform&amp;view=forms'); ?>">
					<img alt="<?php echo JText::_('COM_JUFORM_DASHBOARD_FORMS'); ?>" src="<?php echo JUri::root(true); ?>/administrator/components/com_juform/assets/img/icon/form.png" />
					<span><?php echo JText::_('COM_JUFORM_DASHBOARD_FORMS'); ?></span>
				</a>
			</div>
		</div>
	</div>
<?php } ?>

<?php if (JUFormHelper::checkGroupPermission(null, "submissions"))
{
	?>
	<div class="cpanel">
		<div class="icon-wrapper">
			<div class="icon">
				<a href="<?php echo JRoute::_('index.php?option=com_juform&amp;view=submissions'); ?>">
					<img alt="<?php echo JText::_('COM_JUFORM_DASHBOARD_SUBMISSIONS'); ?>" src="<?php echo JUri::root(true); ?>/administrator/components/com_juform/assets/img/icon/submission.png" />
					<span><?php echo JText::_('COM_JUFORM_DASHBOARD_SUBMISSIONS'); ?></span>
				</a>
			</div>
		</div>
	</div>
<?php } ?>

<?php if (JUFormHelper::checkGroupPermission(null, "plugins"))
{
	?>
	<div class="cpanel">
		<div class="icon-wrapper">
			<div class="icon">
				<a href="<?php echo JRoute::_('index.php?option=com_juform&amp;view=plugins'); ?>">
					<img alt="<?php echo JText::_('COM_JUFORM_DASHBOARD_PLUGINS'); ?>" src="<?php echo JUri::root(true); ?>/administrator/components/com_juform/assets/img/icon/plugin.png" />
					<span><?php echo JText::_('COM_JUFORM_DASHBOARD_PLUGINS'); ?></span>
				</a>
			</div>
		</div>
	</div>
<?php } ?>

<?php if (JUFormHelper::checkGroupPermission(null, "languages"))
{
	?>
	<div class="cpanel">
		<div class="icon-wrapper">
			<div class="icon">
				<a href="<?php echo JRoute::_('index.php?option=com_juform&amp;view=languages'); ?>">
					<img alt="<?php echo JText::_('COM_JUFORM_DASHBOARD_LANGUAGES'); ?>" src="<?php echo JUri::root(true); ?>/administrator/components/com_juform/assets/img/icon/language.png" />
					<span><?php echo JText::_('COM_JUFORM_DASHBOARD_LANGUAGES'); ?></span>
				</a>
			</div>
		</div>
	</div>
<?php } ?>

<?php if (JUFormHelper::checkGroupPermission(null, "backendpermission") && JUFMPROVERSION)
{
	?>
	<div class="cpanel">
		<div class="icon-wrapper">
			<div class="icon">
				<a href="<?php echo JRoute::_('index.php?option=com_juform&amp;view=backendpermission'); ?>">
					<img alt="<?php echo JText::_('COM_JUFORM_DASHBOARD_BACKEND_PERMISSION'); ?>" src="<?php echo JUri::root(true); ?>/administrator/components/com_juform/assets/img/icon/permission.png" />
					<span><?php echo JText::_('COM_JUFORM_DASHBOARD_BACKEND_PERMISSION'); ?></span>
				</a>
			</div>
		</div>
	</div>
<?php } ?>

</div>
</div>

<div class="cpanel-right">
<?php
echo JHtml::_('bootstrap.startAccordion', 'accordion', array('active' => 'top-5-sliders'));
echo JHtml::_('bootstrap.addSlide', 'accordion', JText::_('COM_JUFORM_TOP_5'), 'top-5-sliders', 'top-5-sliders');
echo JHtml::_('bootstrap.startTabSet', 'top-5', array('active' => 'last-add-form'));
echo JHtml::_('bootstrap.addTab', 'top-5', 'last-add-form', JText::_('COM_JUFORM_LAST_ADDED_FORM'));
?>
<table class="adminlist table table-striped">
	<thead>
	<tr>
		<th style="width: 30%"><?php echo JText::_('COM_JUFORM_FIELD_TITLE'); ?></th>
		<th style="width: 15%"><?php echo JText::_('COM_JUFORM_FIELD_CREATED_BY'); ?></th>
		<th style="width: 15%"><?php echo JText::_('COM_JUFORM_FIELD_CREATED'); ?></th>
		<th style="width: 10%"><?php echo JText::_('COM_JUFORM_FIELD_PUBLISHED'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php
	foreach ($lastCreatedForms AS $form)
	{
		$link        = 'index.php?option=com_juform&amp;task=form.edit&amp;id=' . $form->id;
		$checked_out = $form->checked_out ? JHtml::_('jgrid.checkedout', $form->id, $form->checked_out_name, $form->checked_out_time, 'forms.', false) : '';
		?>
		<tr>
			<td><?php echo $checked_out ?>
				<a href="<?php echo $link; ?>" title="<?php echo $form->title; ?>"><?php echo $form->title; ?></a>
			</td>
			<td><?php echo $form->created_by_name; ?></td>
			<td><?php echo JHtml::date($form->created, 'Y-m-d H:i:s'); ?></td>
			<td class="center"><?php echo JHtml::_('grid.boolean', $form->id, $form->published); ?></td>
		</tr>
	<?php
	} ?>
	</tbody>
</table>
<!--  Last updated -->
<?php
echo JHtml::_('bootstrap.endTab');
echo JHtml::_('bootstrap.addTab', 'top-5', 'last-updated-form', JText::_('COM_JUFORM_LAST_MODIFIED_FORMS'));
?>
<table class="adminlist table table-striped">
	<thead>
	<tr>
		<th style="width: 50%"><?php echo JText::_('COM_JUFORM_FIELD_TITLE'); ?></th>
		<th style="width: 20%"><?php echo JText::_('COM_JUFORM_FIELD_MODIFIED'); ?></th>
		<th style="width: 20%"><?php echo JText::_('COM_JUFORM_FIELD_CREATED'); ?></th>
		<th style="width: 10%"><?php echo JText::_('COM_JUFORM_FIELD_PUBLISHED'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php
	foreach ($lastModifiedForms AS $form)
	{
		$link        = 'index.php?option=com_juform&amp;task=form.edit&amp;id=' . $form->id;
		$checked_out = $form->checked_out ? JHtml::_('jgrid.checkedout', $form->id, $form->checked_out_name, $form->checked_out_time, 'forms.', false) : '';
		?>
		<tr>
			<td><?php echo $checked_out ?>
				<a href="<?php echo $link; ?>" title="<?php echo $form->title; ?>"><?php echo $form->title; ?></a>
			</td>
			<td><?php echo $form->modified; ?></td>
			<td><?php echo JHtml::date($form->created, 'Y-m-d H:i:s'); ?></td>
			<td class="center"><?php echo JHtml::_('grid.boolean', $form->id, $form->published); ?></td>
		</tr>
	<?php
	} ?>
	</tbody>
</table>
<!--  !Last updated -->

<!--  Static -->
<?php
echo JHtml::_('bootstrap.endTab');
echo JHtml::_('bootstrap.addTab', 'top-5', 'static', JText::_('COM_JUFORM_STATISTICS'));
?>
<table class="adminlist table table-striped">
	<thead>
	<tr>
		<th style="width: 75%"><?php echo JText::_('COM_JUFORM_FIELD_TYPE'); ?></th>
		<th style="width: 25%"><?php echo JText::_('COM_JUFORM_FIELD_TOTAL'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php
	foreach ($statistics AS $key => $value)
	{
		?>
		<tr>
			<td><?php echo $key; ?></td>
			<td><?php echo $value; ?></td>
		</tr>
	<?php
	} ?>
	</tbody>
</table>
<!--  !Static -->

<?php
echo JHtml::_('bootstrap.endTab');
echo JHtml::_('bootstrap.endTabSet');
echo JHtml::_('bootstrap.endSlide');
echo JHtml::_('bootstrap.endAccordion');
?>

<?php
if(JUFMPROVERSION)
{
	echo JHtml::_('bootstrap.startAccordion', 'accordion-chart', array('active' => 'chart'));
	echo JHtml::_('bootstrap.addSlide', 'accordion-chart', JText::_('COM_JUFORM_CHART'), 'chart', 'chart');
	$document = JFactory::getDocument();
	$document->addScript('https://www.google.com/jsapi');
	$app          = JFactory::getApplication();
	$type         = $app->getUserState('com_juform.dashboard.chart.type', 'day');
	$submissionData = $this->getModel()->getSubmissionData($type);
	?>
	<script type="text/javascript">
		uploadData = '<?php echo json_encode($submissionData); ?>';
		var parsed = JSON.parse(uploadData);
		uploadData = [];
		for (key in parsed) {
			if (parsed.hasOwnProperty(key)) {
				uploadData[key] = parsed[key];
			}
		}

		google.load("visualization", "1", {packages: ["corechart"]});
		google.setOnLoadCallback(drawChart);

		function drawChart() {
			var vAxisTitle = getvAxisTitle('<?php echo $type; ?>');
			_drawChart(uploadData, vAxisTitle);
		}

		function _drawChart(uploadData, vAxisTitle) {
			var data = new google.visualization.DataTable();
			data.addColumn('string', '<?php echo JText::_('COM_JUFORM_DAY')?>');
			data.addColumn('number', '<?php echo JText::_('COM_JUFORM_SUBMISSIONS')?>');
			data.addRows(uploadData.length);
			for (var $i = 0; $i < uploadData.length; $i++) {
				for (var $j = 0; $j < uploadData[$i].length; $j++) {
					if ($j == 0) {
						data.setCell($i, $j, String(uploadData[$i][$j]));
					} else {
						data.setCell($i, $j, parseInt(uploadData[$i][$j]));
					}
				}
			}

			var options = {
				axisTitlesPosition: 'in',
				chartArea: {left: 50, top: 80, width: '100%'},
				legend: {position: 'top'},
				title: '<?php echo JText::sprintf('COM_JUFORM_FORM_SUBMISSION_CHART', date('M/Y')); ?>',
				pointSize: 2,
				lineWidth: 1,
				hAxis: {title: '<?php echo JText::_('COM_JUFORM_TIMES'); ?>'},
				vAxis: {title: vAxisTitle}
			};

			var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
			chart.draw(data, options);
		}

		function getvAxisTitle(type) {
			switch (type) {
				case 'day':
					var vAxisTitle = '<?php echo JText::_('COM_JUFORM_HOUR'); ?>';
					break;
				case 'week':
				case 'month':
					var vAxisTitle = '<?php echo JText::_('COM_JUFORM_DAY'); ?>';
					break;
				case 'year':
					var vAxisTitle = '<?php echo JText::_('COM_JUFORM_MONTH'); ?>';
					break;
				default :
					var vAxisTitle = '';
			}

			return vAxisTitle;
		}

		jQuery(document).ready(function ($) {
			$('#upload_chart').change(function () {
				type = $(this).val();
				$.ajax({
					url: "index.php?option=com_juform&task=dashboard.getChartData",
					data: {type: type},
					dataType: 'json',
					beforeSend: function () {
						$('#chart_div').css({opacity: 0.5}).append('<img style="position: absolute; top: 50%; left: 50%; opacity: 1" src="<?php echo JURi::base(true);?>/components/com_juform/assets/img/orig-loading.gif"/>');
					}
				})
					.done(function (uploadData) {
						if (uploadData) {
							$('#chart_div').css({opacity: 1});
							var vAxisTitle = getvAxisTitle(type);
							_drawChart(uploadData, vAxisTitle);
						}
					});
			});
		});
	</script>

	<?php
	$typeOptions = array('day' => JText::_('COM_JUFORM_DAY'), 'week' => JText::_('COM_JUFORM_WEEK'), 'month' => JText::_('COM_JUFORM_MONTH'), 'year' => JText::_('COM_JUFORM_YEAR'));
	echo JHtml::_('select.genericlist', $typeOptions, 'upload_chart', 'class="input-medium"', 'text', 'value', $type);
	?>

	<div id="chart_div" style="width: 100%; height: 350px;"></div>

	<?php
	echo JHtml::_('bootstrap.endSlide');
	echo JHtml::_('bootstrap.endAccordion');
}
?>
</div>
</div>

<div class="clearfix"></div>

<div class="center small">
	<div><?php echo JUFormHelper::getComVersion(); ?></div>
	<div>A product built with <span class="icon-heart" style="color: #CC0000; font-size: 110%;"></span> by <a href="http://www.joomultra.com" title="Visit JoomUltra website" target="_blank">JoomUltra</a></div>
</div>