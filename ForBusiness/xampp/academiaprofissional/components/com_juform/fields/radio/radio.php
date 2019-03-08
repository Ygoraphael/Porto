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

class JUFormFieldRadio extends JUFormFieldBase
{
	public function getDefaultPredefinedValues()
	{
		$options = $this->getPredefinedValues();
		if (is_array($options) && count($options) > 0)
		{
			foreach ($options AS $option)
			{
				if (isset($option->default) && $option->default == 1)
				{
					return $option->value;
				}
			}
		}

		return "";
	}

	public function getPreview()
	{
		$options = $this->getPredefinedValues();
		$value   = $this->value;

		$this->setAttribute("type", "radio", "input");

		$this->setVariable('options', $options);
		$this->setVariable('value', $value);

		return $this->fetch('preview.php', __CLASS__);
	}

	public function getInput($fieldValue = null)
	{
		if (!$this->isPublished())
		{
			return "";
		}

		$this->loadDefaultAssets(false, true);

		$options = $this->getPredefinedValues();
		$value   = !is_null($fieldValue) ? $fieldValue : !is_null($this->value_input_default) ? $this->value_input_default : $this->value;

		$this->setAttribute("type", "radio", "input");

		$this->setVariable('options', $options);
		$this->setVariable('value', $value);

		$this->registerTriggerForm();

		return $this->fetch('input.php', __CLASS__);
	}

	public function getSearchInput($defaultValue = "")
	{
		if (!$this->isPublished())
		{
			return "";
		}

		$defaultValue = (array) $defaultValue;
		$options      = $this->getPredefinedValues();

		$this->setVariable('value', $defaultValue);
		$this->setVariable('options', $options);

		return $this->fetch('searchinput.php', __CLASS__);
	}

	public function onSave($data)
	{
		$preDefinedValues = $data['predefined_values'];
		if ($preDefinedValues)
		{
			$default = $preDefinedValues['default'];
			unset($preDefinedValues['default']);
			if (isset($preDefinedValues[$default]['value']))
			{
				$preDefinedValues[$default]['default'] = 1;
			}
			else
			{
				$preDefinedValues[0]['default'] = 1;
			}
			$preDefinedValues = array_values($preDefinedValues);
		}

		$i = 0;
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
				$html .= "<td><input type=\"radio\" value=\"" . $key . "\" name=\"jform[predefined_values][default]\" $isdefault/></td>";
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

	public function onSearch(&$query, &$where, $search, $forceModifyQuery = false)
	{
		if ($search === "" || empty($search))
		{
			return "";
		}

		$db     = JFactory::getDbo();
		$_where = array();
		foreach ($search AS $value)
		{
			if ($value !== "")
			{
				$_where[] = $this->fieldvalue_column . " = " . $db->quote($value);
			}
		}

		if (!empty($_where))
		{
			
			$storeId = md5(__METHOD__ . "::" . $this->id);
			if (!isset(self::$cache[$storeId]) || $forceModifyQuery)
			{
				$query->JOIN('LEFT', '#__juform_fields_values AS field_values_' . $this->id . ' ON (form.id = field_values_' . $this->id . '.submission_id AND field_values_' . $this->id . '.field_id = ' . $this->id . ')');

				self::$cache[$storeId] = true;
			}

			$where[] = "(" . implode(" OR ", $_where) . ")";
		}
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

		$_value = $this->value;

		if ($_value === "")
		{
			return "";
		}
		else
		{
			$value = '';
			$predefined_values = $this->getPredefinedValues();

			
			foreach ($predefined_values AS $option)
			{
				if ($option->value === $_value)
				{
					$value = $option->text;
					break;
				}
			}
		}

		$this->setVariable('value', $value);

		return $this->fetch('output.php', __CLASS__);
	}

	public function getBackendOutput()
	{
		$options = $this->getPredefinedValues();
		if ($this->value)
		{
			
			foreach ($options AS $option)
			{
				if ($option->value == $this->value)
				{
					return $option->text;
				}
			}
		}

		return "";
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
		$value = $this->value;
		if ($value)
		{
			$options = $this->getPredefinedValues();
			foreach ($options AS $option)
			{
				if ($option->value == $value)
				{
					return $value;
				}
			}
		}

		return '';
	}
}

?>