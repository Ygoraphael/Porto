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

JHtml::_('behavior.tooltip');

?>

<?php echo JUFormHelper::getMenu(JFactory::getApplication()->input->get('view')); ?>

<div id="iframe-help"></div>

<form action="<?php echo JRoute::_('index.php?option=com_juform&view=backendpermission'); ?>" method="post" name="adminForm" id="adminForm" class="form-validate">
	<div id="backend-permision">
		<div class="adminform">
			<?php
			$html = '<div class="group-permission-wrap">';
			$html .= '<div class="group-permission-label-div">';
			$html .= '<ul class="group-permission-label nav">';
			$html .= '<li class="header">';
			$html .= '<span class="group"><label>' . JText::_('COM_JUFORM_USER_GROUP') . '</label></span>';
			$html .= '<span class="view"><label>' . JText::_('COM_JUFORM_PERMISSION_VIEW') . '</label></span>';
			$html .= '<span class="manage"><label>' . JText::_('COM_JUFORM_PERMISSION_MANAGE') . '</label></span>';
			$html .= '<span class="delete"><label>' . JText::_('COM_JUFORM_PERMISSION_DELETE') . '</label></span>';
			$html .= '</li>';
			foreach ($this->groups AS $group)
			{
				$html .= '<li>';
				$html .= "<span class=\"group\"><label class=\"hasTip\" title=\"" . $group->title . "\" >" . $group->title . "</label></span>";
				$html .= "<span class=\"view\"><input id=\"group-view-" . $group->id . "\" class=\"toggle-check-all-row-view hasTip\" type=\"checkbox\" checked title=\"" . JText::_('COM_JUFORM_CLICK_TO_TOGGLE_VIEW_PERMISSION_FOR_THIS_USER_GROUP') . "\"></span>";
				$html .= "<span class=\"manage\"><input id=\"group-manage-" . $group->id . "\" class=\"toggle-check-all-row-manage hasTip\" type=\"checkbox\" checked title=\"" . JText::_('COM_JUFORM_CLICK_TO_TOGGLE_MANAGE_PERMISSION_FOR_THIS_USER_GROUP') . "\"></span>";
				$html .= "<span class=\"delete\"><input id=\"group-delete-" . $group->id . "\" class=\"toggle-check-all-row-delete hasTip\" type=\"checkbox\" checked title=\"" . JText::_('COM_JUFORM_CLICK_TO_TOGGLE_DELETE_PERMISSION_FOR_THIS_USER_GROUP') . "\"></span>";
				$html .= '</li>';
			}
			$html .= '</ul>';
			$html .= '</div>';
			$html .= '<div class="group-permission-div">';
			$html .= '<table class="group-permission">';
			$html .= '<tr class="header">';

			foreach ($this->taskArray AS $key => $task)
			{
				$html .= "<th class=\"center\">" .
					"<label>" . $task['title'] . "<br />" .
					"<span id=\"task-view-" . $key . "\" class=\"toggle-check-all-col-view hasTip\" title=\"" . JText::_('COM_JUFORM_CLICK_TO_TOGGLE_VIEW_PERMISSION_FOR_THIS_VIEW') . "\">V</span>&nbsp;" .
					"<span id=\"task-manage-" . $key . "\"  class=\"toggle-check-all-col-manage hasTip\" title=\"" . JText::_('COM_JUFORM_CLICK_TO_TOGGLE_MANAGE_PERMISSION_FOR_THIS_VIEW') . "\">M</span>&nbsp;" .
					"<span id=\"task-delete-" . $key . "\" class=\"toggle-check-all-col-delete hasTip\" title=\"" . JText::_('COM_JUFORM_CLICK_TO_TOGGLE_DELETE_PERMISSION_FOR_THIS_VIEW') . "\">D</span>" .
					"</label>
					</th>";
			}

			foreach ($this->groups AS $group)
			{
				$group_permission_value = $this->getPermission($group->id);
				$html .= "<tr>";
				foreach ($this->taskArray AS $key => $name)
				{
					$html .= "<td class=\"center\"><div>";
					if ($group_permission_value[$key]['view'] === 0)
					{
						$check = "";
					}
					else
					{
						$check = "checked";
					}

					$html .= "<input title=\"" . JText::_('COM_JUFORM_PERMISSION_VIEW') . "\" class=\"permission task-view-" . $key . " group-view-" . $group->id . "\" name=\"" . $group->id . "-$key-view\" value=\"1\" type=\"checkbox\" $check />";

					if ($group_permission_value[$key]['manage'] === 0)
					{
						$check = "";
					}
					else
					{
						$check = "checked";
					}
					$html .= "<input title=\"" . JText::_('COM_JUFORM_PERMISSION_MANAGE') . "\" class=\"permission task-manage-" . $key . " group-manage-" . $group->id . "\" name=\"" . $group->id . "-$key-manage\" value=\"1\" type=\"checkbox\" $check>";

					if ($group_permission_value[$key]['delete'] === 0)
					{
						$check = "";
					}
					else
					{
						$check = "checked";
					}
					$html .= "<input title=\"" . JText::_('COM_JUFORM_PERMISSION_DELETE') . "\" class=\"permission task-delete-" . $key . " group-delete-" . $group->id . "\" name=\"" . $group->id . "-$key-delete\" value=\"1\" type=\"checkbox\" $check>";
					$html .= "</div></td>";
				}
				$html .= "</tr>";
			}
			$html .= '</table>';
			$html .= '</div>';
			$html .= '</div>';
			echo $html;
			?>
		</div>
	</div>
	<div>
		<input type="hidden" name="task" value="" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>