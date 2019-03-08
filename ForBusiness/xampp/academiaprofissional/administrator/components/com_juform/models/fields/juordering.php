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

jimport('joomla.html.html');
jimport('joomla.form.formfield');

class JFormFieldJUOrdering extends JFormField
{
	protected $type = 'juordering';

	protected function getInput()
	{
		
		$html = array();
		$attr = '';

		
		$id = (int) $this->form->getValue('id');
		if ($this->element['table'])
		{
			switch (strtolower($this->element['table']))
			{
				case "forms":
				default:
					$whereLabel = '';
					$whereValue = '';
					$table      = '#__juform_forms';
					$query      = 'SELECT ordering AS value, title AS text FROM ' . $table;
					break;
			}
		}

		
		$attr .= $this->element['class'] ? ' class="' . (string) $this->element['class'] . '"' : '';
		$attr .= ((string) $this->element['disabled'] == 'true') ? ' disabled="disabled"' : '';
		$attr .= $this->element['size'] ? ' size="' . (int) $this->element['size'] . '"' : '';
		
		$attr .= $this->element['onchange'] ? ' onchange="' . (string) $this->element['onchange'] . '"' : '';

		if ($whereLabel != '')
		{
			$query .= ' WHERE ' . $whereLabel . ' = ' . (int) $whereValue;
		}

		switch (strtolower($this->element['table']))
		{
			case "forms":
			default:
				$query .= ' ORDER BY ordering';
				break;
		}

		
		if ((string) $this->element['readonly'] == 'true')
		{
			$html[] = JHtml::_('list.ordering', '', $query, trim($attr), $this->value, $id ? 0 : 1);
			$html[] = '<input type="hidden" name="' . $this->name . '" value="' . $this->value . '" />';
		}
		
		else
		{
			$html[] = JHtml::_('list.ordering', $this->name, $query, trim($attr), $this->value, $id ? 0 : 1);
		}

		return implode($html);
	}
}