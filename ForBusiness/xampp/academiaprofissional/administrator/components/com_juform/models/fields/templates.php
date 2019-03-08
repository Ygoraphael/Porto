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

JFormHelper::loadFieldClass('list');

class JFormFieldTemplates extends JFormFieldList
{
	
	protected $type = 'templates';

	protected function getInput()
	{
		$document = JFactory::getDocument();
		$script   = "\njQuery(document).ready(function($){
			$('#" . $this->id . "').change(function(){
				var templateId = $(this).val();
				$('.template-params').hide();
				$('#template-'+templateId).show();
				setTimeout(function(){
					$('#jform_template_type').trigger('change');
				}, 0);
			});";

		$script .= "\n $('#" . $this->id . "').trigger('change');";

		$script .= "\n});\n";

		$document->addScriptDeclaration($script);

		return parent::getInput();
	}

	
	protected function getOptions()
	{
		$templates = JUFormFrontHelper::getTemplates();
		$options   = array();
		foreach ($templates AS $template)
		{
			$options[] = array('value' => $template->id, 'text' => ucfirst($template->title));
		}
		
		$options = array_merge(parent::getOptions(), $options);

		return $options;
	}


}
