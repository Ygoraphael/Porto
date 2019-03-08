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

$function = $app->input->get('function', 'jSelectMenuItem');
$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn = $this->escape($this->state->get('list.direction'));
?>

<form
	action="<?php echo JRoute::_('index.php?option=com_juform&view=menuitems&layout=modal&tmpl=component&function=' . $function . '&' . JSession::getFormToken() . '=1'); ?>"
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
			<select name="filter_menutype" class="inputbox" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('JOPTION_SELECT_MENU');?></option>
				<?php echo JHtml::_('select.options', $this->menutypes, 'value', 'text', $this->state->get('filter.menutype'));?>
			</select>
			<select name="filter_access" class="input-medium" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('JOPTION_SELECT_ACCESS');?></option>
				<?php echo JHtml::_('select.options', JHtml::_('access.assetgroups'), 'value', 'text', $this->state->get('filter.access'));?>
			</select>
			<select name="filter_language" class="inputbox" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('JOPTION_SELECT_LANGUAGE');?></option>
				<?php echo JHtml::_('select.options', JHtml::_('contentlanguage.existing', true, true), 'value', 'text', $this->state->get('filter.language'));?>
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
					<?php echo JHtml::_('searchtools.sort', 'COM_JUFORM_FIELD_TITLE', 'mei.title', $listDirn, $listOrder); ?>
				</th>
				<th style="width: 10%">
					<?php echo JHtml::_('searchtools.sort', 'COM_JUFORM_FIELD_MENUTYPE', 'mei.menutype', $listDirn, $listOrder); ?>
				</th>
				<th style="width: 10%">
					<?php echo JHtml::_('searchtools.sort', 'COM_JUFORM_FIELD_ACCESS', 'mei.access', $listDirn, $listOrder); ?>
				</th>
				<th style="width: 15%">
					<?php echo JHtml::_('searchtools.sort', 'COM_JUFORM_FIELD_LANGUAGE', 'mei.language', $listDirn, $listOrder); ?>
				</th>
				<th style="width: 5%;" class=" center nowrap">
					<?php echo JHtml::_('searchtools.sort', 'COM_JUFORM_FIELD_ID', 'mei.id', $listDirn, $listOrder); ?>
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
						<span><?php echo $this->escape($item->menutype_title); ?> » <?php echo $this->escape($item->title); ?></span>
					</td>
					<td>
						<?php echo $item->access_level; ?>
					</td>
					<td>
						<?php
							if($item->language == '*'){
								echo JText::_('JALL');
							}else{
								echo $item->language_title;
							}
						?>
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