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

$app = JFactory::getApplication();

JHtml::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_juform/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.multiselect');

$function = $app->input->get('function', 'jSelectForm');
$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn = $this->escape($this->state->get('list.direction'));
?>

<form
	action="<?php echo JRoute::_('index.php?option=com_juform&&view=forms&layout=modal&tmpl=component&function=' . $function . '&' . JSession::getFormToken() . '=1'); ?>"
	method="post" name="adminForm" id="adminForm" class="form-inline">
	<fieldset class="filter clearfix">
		<div class="btn-toolbar">
			<div class="btn-group pull-left">
				<label for="filter_search">
					<?php echo JText::_('JSEARCH_FILTER_LABEL'); ?>
				</label>
			</div>
			<div class="btn-group pull-left">
				<input type="text" name="filter_search" id="filter_search"
				       value="<?php echo $this->escape($this->state->get('filter.search')); ?>" size="30"
				       title="<?php echo JText::_('COM_JUFORM_FILTER_SEARCH_DESC'); ?>"/>
			</div>
			<div class="btn-group pull-left">
				<button type="submit" class="btn hasTooltip"
				        title="<?php echo JHtml::tooltipText('JSEARCH_FILTER_SUBMIT'); ?>" data-placement="bottom">
					<span class="icon-search"></span><?php echo '&#160;' . JText::_('JSEARCH_FILTER_SUBMIT'); ?>
				</button>
				<button type="button" class="btn hasTooltip"
				        title="<?php echo JHtml::tooltipText('JSEARCH_FILTER_CLEAR'); ?>" data-placement="bottom"
				        onclick="document.id('filter_search').value='';this.form.submit();">
					<span class="icon-remove"></span><?php echo '&#160;' . JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
			</div>
			<div class="clearfix"></div>
		</div>
		<hr class="hr-condensed"/>
		<div class="filters pull-left">
			<select name="filter_access" class="input-medium" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('JOPTION_SELECT_ACCESS');?></option>
				<?php echo JHtml::_('select.options', JHtml::_('access.assetgroups'), 'value', 'text', $this->state->get('filter.access'));?>
			</select>

			<select name="filter_published" class="input-medium" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('JOPTION_SELECT_PUBLISHED'); ?></option>
				<?php
				$statusArr = array();
				$optionPublished = new stdClass();
				$optionPublished->value = 1;
				$optionPublished->text = JText::_("COM_JUFORM_PUBLISHED");
				$statusArr[] = $optionPublished;
				$optionUnpublished = new stdClass();
				$optionUnpublished->value = 0;
				$optionUnpublished->text = JText::_("COM_JUFORM_UNPUBLISHED");
				$statusArr[] = $optionUnpublished;
				?>
				<?php echo JHtml::_('select.options', $statusArr, 'value', 'text', $this->state->get('filter.published'), true); ?>
			</select>
		</div>
	</fieldset>
	<?php if (empty($this->items)) : ?>
		<div class="alert alert-no-items">
			<?php echo JText::_('COM_JUFORM_NO_MATCHING_RESULTS'); ?>
		</div>
	<?php else : ?>
		<table class="table table-striped adminlist" id="data-list">
			<thead>
			<tr>
				<th style="width: 25%">
					<?php echo JHtml::_('searchtools.sort', 'COM_JUFORM_FIELD_TITLE', 'form.title', $listDirn, $listOrder); ?>
				</th>
				<th style="width: 15%">
					<?php echo JHtml::_('searchtools.sort', 'COM_JUFORM_FIELD_CREATED_BY', 'form.created_by', $listDirn, $listOrder); ?>
				</th>
				<th style="width: 10%">
					<?php echo JHtml::_('searchtools.sort', 'COM_JUFORM_FIELD_ACCESS', 'form.access', $listDirn, $listOrder); ?>
				</th>
				<th style="width: 15%">
					<?php echo JHtml::_('searchtools.sort', 'COM_JUFORM_FIELD_CREATED', 'form.created', $listDirn, $listOrder); ?>
				</th>
				<th style="width: 5%;" class=" center nowrap">
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
				?>
				<tr class="row<?php echo $i % 2; ?>">
					<td>
						<a class="pointer" onclick="if (window.parent) window.parent.<?php echo $this->escape($function); ?>('<?php echo $item->id; ?>', '<?php echo $this->escape(addslashes(str_replace(array("\r", "\n"), "", $item->title))); ?>');">
							<?php echo $this->escape($item->title); ?>
						</a>
					</td>
					<td>
						<?php echo $this->escape($item->created_by); ?>
					</td>
					<td>
						<?php echo $this->escape($item->access_level); ?>
					</td>
					<td>
						<?php echo JHtml::_('date', $item->created, 'd F Y H:i'); ?>
					</td>
					<td class="center nowrap">
						<?php echo (int) $item->id; ?>
					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	<?php endif; ?>
	<div>
		<input type="hidden" name="task" value=""/>
		<input type="hidden" name="boxchecked" value="0"/>
		<?php echo JHtml::_('form.token'); ?>
	</div>

</form>