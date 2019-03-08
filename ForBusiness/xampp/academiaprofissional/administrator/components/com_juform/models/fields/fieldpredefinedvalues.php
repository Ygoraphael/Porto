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


jimport('joomla.form.formfield');

class JFormFieldFieldPredefinedValues extends JFormField
{
	
	protected $type = 'FieldPredefinedValues';

	
	protected function getInput()
	{
		if ($this->form->getValue("plugin_id"))
		{
			$fieldModel       = JModelLegacy::getInstance('Field', 'JUFormModel');
			$field            = $fieldModel->getItem($this->form->getValue("id"));
			$field->plugin_id = $this->form->getValue("plugin_id");
			$fieldClass       = JUFormFrontHelperField::getField($field);
			if ($fieldClass)
			{
				$html = $fieldClass->getPredefinedValuesHtml();
			}
		}
		else
		{
			$html = '<span class="readonly">' . JText::_('COM_JUFORM_NO_VALUE') . '</span>';
		}

		return $html;
	}
}
