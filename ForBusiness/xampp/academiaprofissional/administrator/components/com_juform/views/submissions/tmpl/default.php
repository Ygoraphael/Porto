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
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');

$user = JFactory::getUser();
$userId = $user->get('id');
$formId = $this->state->get('list.form_id');
$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn = $this->escape($this->state->get('list.direction'));
?>

<script type="application/javascript">
	Joomla.submitbutton = function (task) {
		if (task == 'submissions.export') {
			window.location.href = 'index.php?option=com_juform&task=csvprocess.selectform&form_id=<?php echo $this->state->get('list.form_id', 0); ?>';
		}else{
			Joomla.submitform(task, document.getElementById('adminForm'));
		}
	};

	jQuery(document).ready(function($){
		$('.submission-details').fancybox();
	});
</script>
<?php echo JUFormHelper::getMenu(JFactory::getApplication()->input->get('view')); ?>

<div id="iframe-help"></div>

<form
	action="<?php echo JRoute::_('index.php?option=com_juform&view=submissions'); ?>"
	method="post" name="adminForm" id="adminForm">
	<div id="j-main-container" class="span12">
		<?php
		
		echo JLayoutHelper::render('joomla.searchtools.default', array('view' => $this, 'options' => array("filterButton" => false)));

		$list = $this->filterForm->getGroup('form_select');
		?>
		<?php if ($list) : ?>
			<div class="ordering-select hidden-phone">
				<?php foreach ($list as $fieldName => $field) : ?>
					<div class="js-stools-field-list">
						<?php echo $field->input; ?>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<?php if (empty($this->items)) : ?>
			<div class="alert alert-no-items">
				<?php
					if($formId)
					{
						echo JText::_('COM_JUFORM_NO_MATCHING_RESULTS');
					}
					else
					{
						echo JText::_('COM_JUFORM_PLEASE_SELECT_A_FORM');
					}
				?>
			</div>
		<?php else : ?>
			<table class="table table-striped adminlist">
				<thead>
				<tr>
					<th style="min-width: 40px !important; width: 40px !important;" class="hidden-phone">
						<?php echo JHtml::_('grid.checkall'); ?>
					</th>
					<th style="min-width: 80px !important;" class="nowrap">
						<?php echo JHtml::_('searchtools.sort', JText::_('COM_JUFORM_USER'), 'sub.user_id', $listDirn, $listOrder);?>
					</th>
					<th style="min-width: 80px !important;" class="nowrap">
						<?php echo JHtml::_('searchtools.sort', JText::_('COM_JUFORM_CREATED'), 'sub.created', $listDirn, $listOrder);?>
					</th>
					<?php
					foreach ($this->model->fields_use AS $field)
					{
						echo '<th style="min-width: 80px !important;" class="nowrap">';
						echo JHtml::_('searchtools.sort', $field->caption, $field->id, $listDirn, $listOrder);
						echo '</th>';
					}
					?>
				</tr>
				</thead>

				<tfoot>
				<tr>
					<td colspan="<?php echo count($this->model->fields_use) + 3; ?>">
						<?php echo $this->pagination->getListFooter(); ?>
					</td>
				</tr>
				</tfoot>

				<tbody>
				<?php
				foreach ($this->items AS $i => $item)
				{
					$canEdit    = $user->authorise('core.edit','com_juform') && $this->groupCanDoManage;
					$canCheckin = $user->authorise('core.manage', 'com_checkin') || $item->checked_out == $userId || $item->checked_out == 0;
					$canEditOwn = $user->authorise('core.edit.own','com_juform') && $item->user_id == $userId && $this->groupCanDoManage;
					$canChange  = $user->authorise('core.edit.state','com_juform') && $canCheckin && $this->groupCanDoManage;
					?>
					<tr class="row<?php echo $i % 2; ?>">
						<td class="hidden-phone">
							<?php echo JHtml::_('grid.id', $i, $item->id); ?>
						</td>
						<td class="hidden-phone">
							<?php
							if ($item->checked_out)
							{
								echo JHtml::_('jgrid.checkedout', $i, $item->checked_out_name, $item->checked_out_time, 'submissions.', $canCheckin || $user->authorise('core.manage', 'com_checkin'));
							}
							?>
							<a href="<?php echo $item->actionLink; ?>" title="<?php echo JText::_('COM_JUFORM_EDIT'); ?>"><?php echo $item->user_name ? $item->user_name : JText::_('COM_JUFORM_GUEST'); ?></a>
							<a class="btn btn-micro submission-details" title="<?php echo JText::_('COM_JUFORM_VIEW'); ?>" href="<?php echo $item->detailLink; ?>" data-fancybox-type="iframe"><i class="icon-eye-open icon-eye"></i></a>
						</td>
						<td class="hidden-phone">
							<?php echo JHtml::_('date', $item->created, 'd F Y H:i:s'); ?>
						</td>
						<?php
						foreach ($this->model->fields_use AS $field)
						{
							echo '<td>';
							$field = JUFormFrontHelperField::getField($field, $item);
							echo $field->getBackendOutput();
							echo '</td>';
						}
						?>
					</tr>
				<?php
				} ?>
				</tbody>
			</table>
		<?php endif; ?>

		<div>
			<input type="hidden" name="task" value="" />
			<input type="hidden" name="boxchecked" value="0" />
			<?php echo JHtml::_('form.token'); ?>
		</div>
	</div>
</form>