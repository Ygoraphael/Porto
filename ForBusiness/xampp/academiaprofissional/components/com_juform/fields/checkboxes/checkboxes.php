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

class JUFormFieldCheckboxes extends JUFormFieldBase
{
	public function getDefaultPredefinedValues()
	{
		$options = $this->getPredefinedValues();
		$return  = array();
		if ($options)
		{
			foreach ($options AS $option)
			{
				if (isset($option->default) && $option->default == 1)
				{
					$return[] = $option->value;
				}
			}
		}

		return $return;
	}

	public function parseValue($value)
	{
		if (!$this->isPublished())
		{
			return null;
		}

		if ($value)
		{
			return explode("|", $value);
		}

		return $value;
	}

	public function getName()
	{
		$name = parent::getName();

		return $name . "[]";
	}

	public function getPreview()
	{
		$this->setAttribute("type", "checkbox", "input");

		$value   = (array) $this->value;
		$options = $this->getPredefinedValues();
		$this->setVariable('value', $value);
		$this->setVariable('options', $options);

		return $this->fetch('preview.php', __CLASS__);
	}

	public function getInput($fieldValue = null)
	{
		if (!$this->isPublished())
		{
			return "";
		}

		$document = JFactory::getDocument();
		$document->addStyleSheet(JUri::root() . "components/com_juform/fields/" . $this->folder . "/inputstyle.css");

		$this->setAttribute("type", "checkbox", "input");

		$value = !is_null($fieldValue) ? $fieldValue : (!is_null($this->value_input_default) ? $this->value_input_default : $this->value);

		$value = (array) $value;

		$options = $this->getPredefinedValues();

		$this->setVariable('value', $value);
		$this->setVariable('options', $options);

		$this->registerTriggerForm();

		return $this->fetch('input.php', __CLASS__);
	}

	public function getSearchInput($defaultValue = "")
	{
		if (!$this->isPublished())
		{
			return "";
		}

		$this->setAttribute("type", "checkbox", "search");

		$defaultValue = (array) $defaultValue;
		$options      = $this->getPredefinedValues();

		$this->setVariable('value', $defaultValue);
		$this->setVariable('options', $options);

		return $this->fetch('searchinput.php', __CLASS__);
	}

	public function onSave($data)
	{
		$preDefinedValues = $data['predefined_values'];
		$preDefinedValues = array_values($preDefinedValues);
		$i                = 0;
		foreach ($preDefinedValues AS $key => $preDefinedValue)
		{
			
			if (($preDefinedValue["value"] === "" && $i > 0))
			{
				unset($preDefinedValues[$key]);
			}
			
			else
			{
				$preDefinedValues[$key]["value"] = str_replace(array("|", ","), "", trim($this->filterField($preDefinedValue["value"])));
			}

			$i++;
		}

		$data['predefined_values'] = !empty($preDefinedValues) ? json_encode(array_values($preDefinedValues)) : "";

		return $data;
	}

	public function loadDefaultAssets($loadJS = true, $loadCSS = true)
	{
		static $loaded = array();

		if ($this->folder && !isset($loaded[$this->folder]))
		{
			$document = JFactory::getDocument();
			$document->addScript(JUri::root(true) . '/components/com_juform/assets/js/jquery.dragsort.min.js');

			JText::script('COM_JUFORM_OPTION_VALUE');
			JText::script('COM_JUFORM_REMOVE');
			JText::script('COM_JUFORM_CSV_JSON_DATA');
			JText::script('COM_JUFORM_CSV_JSON_DATA_DESC');
			JText::script('COM_JUFORM_CSV_DELIMITER');
			JText::script('COM_JUFORM_CSV_ENCLOSURE');
			JText::script('COM_JUFORM_PROCESSING');
			JText::script('COM_JUFORM_PROCESS');
			JText::script('COM_JUFORM_OPTION_VALUE_MUST_BE_UNIQUE');

			$document = JFactory::getDocument();
			$script   = "jQuery(document).ready(function($){
						$(\"#jform_predefined_values .table tbody\").dragsort({dragSelector: \"td\", placeHolderTemplate: \"<tr><td></td></tr>\", dragSelectorExclude: \"input, .remove-option\"});
					});";
			$document->addScriptDeclaration($script);

			parent::loadDefaultAssets($loadJS, $loadCSS);

			$loaded[$this->folder] = true;
		}
	}

	public function getPredefinedValuesHtml()
	{
		$this->loadDefaultAssets();

		$html = "<div id=\"jform_predefined_values\">";
		$html .= "<div class=\"clearfix\">";
		$html .= "<button type=\"button\" class=\"btn btn-mini add-option\"><i class=\"icon-new\"></i> " . JText::_('COM_JUFORM_ADD_AN_OPTION') . "</button>";
		$html .= "<button type=\"button\" class=\"btn btn-mini fast-add-options\"><i class=\"icon-flash\"></i> " . JText::_('COM_JUFORM_FAST_ADD_OPTIONS') . "</button>";
		$html .= "</div>";
		$html .= "<table class='table table-striped table-bordered'>";
		$html .= "<thead>";
		$html .= "<tr>";
		$html .= "<th>" . JText::_("COM_JUFORM_SORT") . "</th>";
		$html .= "<th>" . JText::_("COM_JUFORM_VALUE") . "</th>";
		$html .= "<th>" . JText::_("COM_JUFORM_TEXT") . "</th>";
		$html .= "<th>" . JText::_("COM_JUFORM_DEFAULT") . "</th>";
		$html .= "<th>" . JText::_("COM_JUFORM_DISABLED") . "</th>";
		$html .= "<th>" . JText::_("COM_JUFORM_REMOVE") . "</th>";
		$html .= "</tr>";
		$html .= "</thead>";
		$html .= "<tbody>";
		$html .= "<tr></tr>";
		$options = $this->getPredefinedValues(1);
		if ($options)
		{
			foreach ($options AS $key => $option)
			{
				$isdefault  = (isset($option->default) && $option->default) ? "checked" : "";
				$isdisabled = (isset($option->disabled) && $option->disabled) ? "checked" : "";
				$text       = $option->text;
				$value      = htmlspecialchars($option->value, ENT_COMPAT, 'UTF-8');
				$html .= "<tr>";
				$html .= '<td><a class="drag-icon"></a></td>';
				$html .= "<td>
							<label style=\"display: none\" for=\"input-value-" . $key . "\">" . JText::_("COM_JUFORM_OPTION_VALUE") . "</label>
							<input id=\"input-value-" . $key . "\" type=\"text\" class=\"validate-value value input-mini\" value=\"$value\" size=\"15\" name=\"jform[predefined_values][$key][value]\"/></td>";
				$html .= "<td><input type=\"text\" class=\"input-medium\" value=\"$text\" size=\"35\" name=\"jform[predefined_values][$key][text]\"/></td>";
				$html .= "<td><input type=\"checkbox\" value=\"1\" name=\"jform[predefined_values][$key][default]\" $isdefault/></td>";
				$html .= "<td><input type=\"checkbox\" value=\"1\" name=\"jform[predefined_values][$key][disabled]\" $isdisabled/></td>";
				$html .= "<td><a href=\"#\" class=\"btn btn-mini btn-danger remove-option\" ><i class=\"icon-minus\"></i> " . JText::_('COM_JUFORM_REMOVE') . "</a>";
				$html .= "</tr>";
			}
		}
		$html .= "</tbody>";
		$html .= "</table>";
		$html .= "</div>";

		return $html;
	}

	public function onSimpleSearch(&$query, &$where, $search, $forceModifyQuery = false)
	{
		
		$matched_options = array();
		$options         = $this->getPredefinedValues();
		foreach ($options AS $option)
		{
			if (strpos(mb_strtolower($search, 'UTF-8'), mb_strtolower($option->text, 'UTF-8')) !== false)
			{
				$matched_options[] = $option->value;
			}
		}

		
		parent::onSimpleSearch($query, $where, $matched_options, $forceModifyQuery);
	}

	public function getOutput($options = array())
	{
		if (!$this->isPublished())
		{
			return "";
		}

		$values = (array) $this->value;

		if (!$values)
		{
			return "";
		}

		$options = $this->getPredefinedValues();

		$this->setVariable('values', $values);
		$this->setVariable('options', $options);

		return $this->fetch('output.php', __CLASS__);
	}

	public function getBackendOutput()
	{
		$html    = '';
		$options = $this->getPredefinedValues();
		$values  = (array) $this->value;
		if ($values)
		{
			$html .= '<ul class="nav">';
			
			foreach ($options AS $option)
			{
				if (in_array($option->value, $values))
				{
					$html .= '<li>' . $option->text . '</li>';
				}
			}
			$html .= '</ul>';
		}

		return $html;
	}

	protected function getRestrictValidateData()
	{
		$restrictType  = $this->params->get('restrict_type', '');
		$restrictValue = $this->params->get('restrict_value', '');
		if ($restrictType && $restrictValue)
		{
			if ($restrictType == 'min' || $restrictType == 'max')
			{
				$restrictValue = (int) $restrictValue;
				if ($restrictValue < 1)
				{
					return '';
				}
			}
			else
			{
				$restrictValue = explode(',', $restrictValue);
				if (count($restrictValue) != 2)
				{
					return '';
				}

				$restrictValue[0] = (int) $restrictValue[0];
				$restrictValue[1] = (int) $restrictValue[1];

				if ($restrictValue[0] < 1 || $restrictValue[1] < 1 || $restrictValue[0] >= $restrictValue[1])
				{
					return '';
				}
			}

			$validateData = array();
			if ($restrictType == 'min')
			{
				$validateData[] = 'data-rule-minlength="' . $restrictValue . '"';
				$validateData[] = 'data-msg-minlength="' . JText::sprintf('COM_JUFORM_PLEASE_SELECT_AT_LEAST_X_OPTIONS', $restrictValue) . '"';
			}
			elseif ($restrictType == 'max')
			{
				$validateData[] = 'data-rule-maxlength="' . $restrictValue . '"';
				$validateData[] = 'data-msg-maxlength="' . JText::sprintf('COM_JUFORM_PLEASE_SELECT_NO_MORE_THAN_X_OPTIONS', $restrictValue) . '"';
			}
			else
			{
				$validateData[] = 'data-rule-rangelength="[' . $restrictValue[0] . ',' . $restrictValue[1] . ']"';
				$validateData[] = 'data-msg-rangelength="' . JText::_('COM_JUFORM_PLEASE_SELECT_FROM_X_TO_Y_OPTIONS', $restrictValue[0], $restrictValue[1]) . '"';
			}

			return implode(' ', $validateData);
		}

		return '';
	}

	public function registerTriggerForm()
	{
		$document = JFactory::getDocument();

		$script = '
			if(typeof JUFormTrigger === "undefined"){
				var	JUFormTrigger = [];
			}

			JUFormTrigger["' . $this->getId() . '"] = function(form, type, result){
				if(type == "reset" || (type == "submit" && result.type == "success")){
					jQuery(\'[name="' . $this->getName() . '"]\').each(function(){
						jQuery(this).prop("checked", false);
					});
				}
			}
		';

		$document->addScriptDeclaration($script);
	}

	public function getPlaceholderValue(&$email = null)
	{
		$values = $this->value;
		if ($values)
		{
			$options = $this->getPredefinedValues();
			$return  = array();
			foreach ($options AS $option)
			{
				if (in_array($option->value, $values))
				{
					$return[] = $option->text;
				}
			}

			return implode(', ', $return);
		}

		return '';
	}
}

?>