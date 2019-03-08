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
$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn = $this->escape($this->state->get('list.direction'));
$saveOrder = ($listOrder == 'form.ordering');

if ($saveOrder)
{
	$saveOrderingUrl = 'index.php?option=com_juform&task=forms.saveOrderAjax&tmpl=component';
	JHtml::_('sortablelist.sortable', 'data-list', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
}
?>

<?php echo JUFormHelper::getMenu(JFactory::getApplication()->input->get('view')); ?>

<div id="iframe-help"></div>

<form
	action="<?php echo JRoute::_('index.php?option=com_juform&view=forms'); ?>"
	method="post" name="adminForm" id="adminForm">
	<div id="j-main-container" class="span12">
		<?php
		
		echo JLayoutHelper::render('joomla.searchtools.default', array('view' => $this, 'options' => array("filterButton" => true)));
		?>
		<?php if (empty($this->items)) : ?>
			<div class="alert alert-no-items">
				<?php echo JText::_('COM_JUFORM_NO_MATCHING_RESULTS'); ?>
			</div>
		<?php else : ?>
			<table class="table table-striped adminlist" id="data-list">
				<thead>
				<tr>
					<th style="width:2%" class="nowrap center hidden-phone">
						<?php echo JHtml::_('searchtools.sort', '', 'form.ordering', $listDirn, $listOrder, null, 'asc', 'COM_JUFORM_FIELD_ORDERING', 'icon-menu-2'); ?>
					</th>
					<th style="width:2%" class="hidden-phone">
						<?php echo JHtml::_('grid.checkall'); ?>
					</th>
					<th style="width:65%" class="nowrap">
						<?php echo JHtml::_('searchtools.sort', 'COM_JUFORM_FIELD_TITLE', 'form.title', $listDirn, $listOrder); ?>
					</th>
					<th style="width: 15%">
						<?php echo JHtml::_('searchtools.sort', 'COM_JUFORM_FIELD_ACCESS', 'form.access', $listDirn, $listOrder); ?>
					</th>
					<th style="width: 8%">
						<?php echo JHtml::_('searchtools.sort', 'COM_JUFORM_FIELD_HITS', 'form.hits', $listDirn, $listOrder); ?>
					</th>
					<th style="width:5%" class="nowrap center">
						<?php echo JHtml::_('searchtools.sort', 'COM_JUFORM_FIELD_PUBLISHED', 'form.published', $listDirn, $listOrder); ?>
					</th>
					<th style="width:3%" class="nowrap center">
						<?php echo JHtml::_('searchtools.sort', 'COM_JUFORM_FIELD_ID', 'form.id', $listDirn, $listOrder); ?>
					</th>
				</tr>
				</thead>

				<tfoot>
				<tr>
					<td colspan="7"><?php echo $this->pagination->getListFooter(); ?></td>
				</tr>
				</tfoot>

				<tbody>
				<?php
				foreach ($this->items AS $i => $item) :
					$canEdit    = $user->authorise('core.edit','com_juform') && $this->groupCanDoManage;
					$canCheckin = $user->authorise('core.manage', 'com_checkin') || $item->checked_out == $userId || $item->checked_out == 0;
					$canEditOwn = $user->authorise('core.edit.own','com_juform') && $item->created_by == $userId && $this->groupCanDoManage;
					$canChange  = $user->authorise('core.edit.state','com_juform') && $canCheckin && $this->groupCanDoManage;
					?>
					<tr class="row<?php echo $i % 2; ?>">
						<td class="order nowrap center hidden-phone">
							<?php
							$iconClass = '';
							if (!$canChange)
							{
								$iconClass = ' inactive';
							}
							elseif (!$saveOrder)
							{
								$iconClass = ' inactive tip-top hasTooltip" title="' . JHtml::tooltipText('JORDERINGDISABLED');
							}
							?>
							<span class="sortable-handler<?php echo $iconClass ?>">
								<i class="icon-menu"></i>
							</span>
							<?php if ($canChange && $saveOrder) : ?>
								<input type="text" style="display:none" name="order[]" size="5" value="<?php echo $item->ordering; ?>" class="width-20 text-area-order " />
							<?php endif; ?>
						</td>
						<td class="hidden-phone">
							<?php echo JHtml::_('grid.id', $i, $item->id); ?>
						</td>
						<td>
							<?php
							if ($item->checked_out)
							{
								echo JHtml::_('jgrid.checkedout', $i, $item->checked_out_name, $item->checked_out_time, 'forms.', $canCheckin || $user->authorise('core.manage', 'com_checkin'));
							}
							?>
							<?php if ($canEdit || $canEditOwn)
							{
								?>
								<a href="index.php?option=com_juform&task=form.edit&id=<?php echo $item->id; ?>"><?php echo $item->title; ?></a>
							<?php
							}
							else
							{
								echo $item->title;
							} ?>
						</td>
						<td>
							<?php echo $this->escape($item->access_level); ?>
						</td>
						<td>
							<?php echo $item->hits; ?>
						</td>
						<td class="center">
							<?php echo JHtml::_('jgrid.published', $item->published, $i, 'forms.', $canChange, 'cb', $item->publish_up, $item->publish_down); ?>
						</td>
						<td class="center">
							<?php echo $item->id; ?>
						</td>
					</tr>
				<?php endforeach; ?>
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