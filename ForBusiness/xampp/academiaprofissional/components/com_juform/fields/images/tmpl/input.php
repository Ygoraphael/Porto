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
?>
	<!-- New video template -->
	<script id="newfile-template-<?php echo $this->getId(); ?>" type="text/x-handlebars-template">
		<li id="{{file.id}}" class="pending">
			<span class="file-remove-btn icon-trash" data-icon-undo="icon-undo" data-icon-trash="icon-trash"
			      title="<?php echo JText::_('COM_JUFORM_REMOVE'); ?>"></span>
			<span class="file-publish-btn icon-eye" data-icon-publish="icon-eye" data-icon-unpublish="icon-eye-close"
			      title="<?php echo JText::_('COM_JUFORM_PUBLISH'); ?>"></span>

			<div class="file-image">
				<img src="#" alt="{{file.name}}"/>
			</div>
			<div class="file-title-description">
				<input type="text" class="file-title" name="<?php echo $this->getName() ?>[{{key}}][title]"
				       value="{{file.name}}" placeholder="<?php echo JText::_('COM_JUFORM_TITLE'); ?>"/>
				<textarea class="file-description" name="<?php echo $this->getName() ?>[{{key}}][description]"
				          placeholder="<?php echo JText::_('COM_JUFORM_DESCRIPTION'); ?>"></textarea>
			</div>
			<div class="file-info-wrap">
				<div class="file-info file-size-wrap"><label
						class="info-label"><?php echo JText::_('COM_JUFORM_SIZE'); ?>:</label><span class="info-value">{{file.sizeFormatted}}</span>
				</div>
				<div class="file-info file-type-wrap"><label
						class="info-label"><?php echo JText::_('COM_JUFORM_TYPE'); ?>:</label><span class="info-value">{{file.type}}</span>
				</div>
				<div class="file-info file-state-wrap"><label
						class="info-label"><?php echo JText::_('COM_JUFORM_STATE'); ?>:</label><span
						class="info-value"><?php echo JText::_('COM_JUFORM_PENDING'); ?></span></div>
			</div>

			<input type="hidden" class="file-id" name="<?php echo $this->getName() ?>[{{key}}][id]"
			       value="{{file.id}}"/>
			<input type="hidden" class="file-name" name="<?php echo $this->getName() ?>[{{key}}][name]"
			       value="{{file.name}}"/>
			<input type="hidden" class="file-size" value="{{file.size}}"
			       name="<?php echo $this->getName(); ?>[{{key}}][size]"/>
			<input type="hidden" class="file-type" value="{{file.type}}"
			       name="<?php echo $this->getName(); ?>[{{key}}][type]"/>
			<input type="hidden" class="file-target" value="" name="<?php echo $this->getName(); ?>[{{key}}][target]"/>
			<input type="hidden" class="file-published" value="1"
			       name="<?php echo $this->getName(); ?>[{{key}}][published]"/>
			<input type="hidden" class="file-remove" value="0" name="<?php echo $this->getName(); ?>[{{key}}][remove]"/>
			<input type="hidden" class="file-isnew" value="1" name="<?php echo $this->getName(); ?>[{{key}}][is_new]"/>
		</li>
	</script>

<?php
$html = "<div id=\"" . $this->getId() . "_wrap\" " . $this->getAttribute(null, null, "input") . " class=\"field-images\">";
$html .= "<ul class=\"file-list\">";
if ($files)
{
	$imageUrl = JUri::root(true) . "/media/com_juform/field_attachments/images/" . $this->id . "_" . $this->submission_id . "/";
	$imageTmp = JUri::root(true) . "/media/com_juform/tmp_img/";
	foreach ($files AS $key => $file)
	{
		if (isset($file['target']) && !$file['target'])
		{
			continue;
		}

		$isNewFile = isset($file['is_new']) ? true : false;

		$class = array();
		if ($isNewFile)
		{
			$state   = JText::_('COM_JUFORM_UPLOADED');
			$class[] = 'uploaded';
		}
		else
		{
			$state   = JText::_('COM_JUFORM_COMPLETED');
			$class[] = 'completed';
		}

		$iconRemove = 'icon-trash';
		if (isset($file['remove']) && $file['remove'] == 1)
		{
			$iconRemove = 'icon-undo';
			$class[]    = 'remove';
		}

		$iconPublished = 'icon-eye';
		if ($file['published'] == 0)
		{
			$iconPublished = 'icon-eye-close';
			$class[]       = 'unpublish';
		}

		$class = implode(' ', $class);

		$html .= '<li class="' . $class . '">';
		$html .= '<span class="file-remove-btn ' . $iconRemove . '" data-icon-undo="icon-undo" data-icon-trash="icon-trash" title="' . JText::_('COM_JUFORM_REMOVE') . '"></span>';
		$html .= '<span class="file-publish-btn ' . $iconPublished . '" data-icon-publish="icon-eye" data-icon-unpublish="icon-eye-close" title="' . JText::_('COM_JUFORM_PUBLISH') . '"></span>';
		$html .= '<div class="file-image">';
		if ($isNewFile)
		{
			$html .= '<img src="' . $imageTmp . $file['target'] . '" alt="' . $file['title'] . '"/>';
		}
		else
		{
			$html .= '<img src="' . $imageUrl . $file['name'] . '" alt="' . $file['title'] . '"/>';
		}
		$html .= '</div>';
		$html .= '<div class="file-title-description">';
		$html .= '<input type="text" class="file-title" name="' . $this->getName() . '[' . $key . '][title]" value="' . $file['title'] . '" placeholder="' . JText::_('COM_JUFORM_TITLE') . '" />';
		$html .= '<textarea class="file-description" name="' . $this->getName() . '[' . $key . '][description]" placeholder="' . JText::_('COM_JUFORM_DESCRIPTION') . '">' . $file['description'] . '</textarea>';
		$html .= '</div>';
		$html .= '<div class="file-info-wrap">';
		$html .= '<div class="file-info file-size-wrap"><label class="info-label">' . JText::_('COM_JUFORM_SIZE') . ':</label><span class="info-value">' . $this->formatBytes($file['size']) . '</span></div>';
		$html .= '<div class="file-info file-type-wrap"><label class="info-label">' . JText::_('COM_JUFORM_TYPE') . ':</label><span class="info-value">' . $file['type'] . '</span></div>';
		$html .= '<div class="file-info file-state-wrap"><label class="info-label">' . JText::_('COM_JUFORM_STATE') . ':</label><span class="info-value">' . $state . '</span></div>';
		$html .= '</div>';
		if ($isNewFile)
		{
			$html .= '<input type="hidden" class="file-name" name="' . $this->getName() . '[' . $key . '][name]" value="' . $file['name'] . '" />';
			$html .= '<input type="hidden" class="file-size" name="' . $this->getName() . '[' . $key . '][size]" value="' . $file['size'] . '" />';
			$html .= '<input type="hidden" class="file-type" name="' . $this->getName() . '[' . $key . '][type]" value="' . $file['type'] . '" />';
			$html .= '<input type="hidden" class="file-target" name="' . $this->getName() . '[' . $key . '][target]" value="' . $file['target'] . '" />';
			$html .= '<input type="hidden" class="file-isnew" name="' . $this->getName() . '[' . $key . '][is_new]" value="1" />';
		}
		$html .= '<input type="hidden" class="file-published" name="' . $this->getName() . '[' . $key . '][published]" value="' . $file['published'] . '" />';
		$html .= '<input type="hidden" class="file-remove" name="' . $this->getName() . '[' . $key . '][remove]" value="' . (isset($file['remove']) ? $file['remove'] : 0) . '" />';
		$html .= '<input type="hidden" class="file-id" name="' . $this->getName() . '[' . $key . '][id]" value="' . $file['id'] . '" />';
		$html .= "</li>";
	}
}
$html .= "</ul>";

$html .= "<div class=\"file-warning-area-wrap hide\">";
$html .= "<span class=\"toggle-file-warning icon-expand\" data-icon-expand=\"icon-expand\" data-icon-contract=\"icon-contract\"></span>";
$html .= "<div class=\"file-warning-area\">";
$html .= "</div>";
$html .= "</div>";

$html .= "<div class=\"file-upload-container\">";
$html .= "<span class=\"pickfiles btn btn-mini\"><i class=\"icon-new\"></i> " . JText::_('COM_JUFORM_SELECT_FILE') . "</span>";
if (!$this->params->get('auto_upload', 0))
{
	$html .= " <span class=\"uploadfiles btn btn-mini disabled\"><i class=\"icon-upload\"></i> " . JText::_('COM_JUFORM_UPLOAD') . "</span>";
}
$html .= "</div>";

$html .= "<input type=\"hidden\" " . $this->getValidateData() . " id=\"" . $this->getId() . "\" name=\"" . $this->getId() . "\" value=\"0\" />";

$html .= "</div>";

echo $html;

?>