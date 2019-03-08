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

class JUFormFieldMultipleSelect extends JUFormFieldCheckboxes
{
	public function getPreview()
	{
		$options       = $this->getPredefinedValues();
		$selectOptions = array();
		$value         = $this->value;
		if ($options)
		{
			$optGroupState = "close";
			foreach ($options AS $option)
			{
				if ($option->text == strtoupper($option->text))
				{
					$text = JText::_($option->text);
				}
				else
				{
					$text = $option->text;
				}

				$selectOptionItem['text']  = htmlspecialchars($text, ENT_COMPAT, 'UTF-8');
				$selectOptionItem['value'] = htmlspecialchars($option->value, ENT_COMPAT, 'UTF-8');

				if (strtoupper($option->value) == "<OPTGROUP>")
				{
					if ($optGroupState == "open")
					{
						$selectOptions[] = JHtml::_('select.option', '</OPTGROUP>');
						$optGroupState   = "close";
					}
					$selectOptions[] = JHtml::_('select.option', '<OPTGROUP>', $selectOptionItem['text']);
					$optGroupState   = "open";
				}
				elseif (strtoupper($option->value) == "</OPTGROUP>")
				{
					$selectOptions[] = JHtml::_('select.option', '</OPTGROUP>');
					$optGroupState   = "close";
				}
				else
				{
					if (isset($option->disabled) && $option->disabled)
					{
						$selectOptions[] = JHtml::_('select.option', $selectOptionItem['value'], $selectOptionItem['text'], "value", "text", true);
					}
					else
					{
						$selectOptions[] = JHtml::_('select.option', $selectOptionItem['value'], $selectOptionItem['text']);
					}
				}
			}
		}

		$this->setAttribute("multiple", "multiple", "input");
		if ((int) $this->params->get("size", 5))
		{
			$this->setAttribute("size", (int) $this->params->get("size", 5), "input");
		}

		$this->setVariable('value', $value);
		$this->setVariable('options', $selectOptions);

		return $this->fetch('preview.php', __CLASS__);
	}

	public function getInput($fieldValue = null)
	{
		if (!$this->isPublished())
		{
			return "";
		}

		$options       = $this->getPredefinedValues();
		$selectOptions = array();
		$value         = !is_null($fieldValue) ? $fieldValue : !is_null($this->value_input_default) ? $this->value_input_default : $this->value;
		if ($options)
		{
			$optGroupState = "close";
			foreach ($options AS $option)
			{
				if ($option->text == strtoupper($option->text))
				{
					$text = JText::_($option->text);
				}
				else
				{
					$text = $option->text;
				}

				$selectOptionItem['text']  = htmlspecialchars($text, ENT_COMPAT, 'UTF-8');
				$selectOptionItem['value'] = htmlspecialchars($option->value, ENT_COMPAT, 'UTF-8');

				if (strtoupper($option->value) == "<OPTGROUP>")
				{
					if ($optGroupState == "open")
					{
						$selectOptions[] = JHtml::_('select.option', '</OPTGROUP>');
						$optGroupState   = "close";
					}
					$selectOptions[] = JHtml::_('select.option', '<OPTGROUP>', $selectOptionItem['text']);
					$optGroupState   = "open";
				}
				elseif (strtoupper($option->value) == "</OPTGROUP>")
				{
					$selectOptions[] = JHtml::_('select.option', '</OPTGROUP>');
					$optGroupState   = "close";
				}
				else
				{
					if (isset($option->disabled) && $option->disabled)
					{
						$selectOptions[] = JHtml::_('select.option', $selectOptionItem['value'], $selectOptionItem['text'], "value", "text", true);
					}
					else
					{
						$selectOptions[] = JHtml::_('select.option', $selectOptionItem['value'], $selectOptionItem['text']);
					}
				}
			}
		}

		$this->setAttribute("multiple", "multiple", "input");
		if ((int) $this->params->get("size", 5))
		{
			$this->setAttribute("size", (int) $this->params->get("size", 5), "input");
		}

		$this->setVariable('value', $value);
		$this->setVariable('options', $selectOptions);

		$this->registerTriggerForm();

		return $this->fetch('input.php', __CLASS__);
	}

	public function getSearchInput($defaultValue = "")
	{
		if (!$this->isPublished())
		{
			return "";
		}

		$options       = $this->getPredefinedValues();
		$selectOptions = array();
		if ($options)
		{
			$optgroupState = "close";
			foreach ($options AS $option)
			{
				if ($option->text == strtoupper($option->text))
				{
					$text = JText::_($option->text);
				}
				else
				{
					$text = $option->text;
				}

				$selectOptionItem['text']  = htmlspecialchars($text, ENT_COMPAT, 'UTF-8');
				$selectOptionItem['value'] = htmlspecialchars($option->value, ENT_COMPAT, 'UTF-8');

				if (strtoupper($option->value) == "<OPTGROUP>")
				{
					if ($optgroupState == "open")
					{
						$selectOptions[] = JHtml::_('select.option', '</OPTGROUP>');
						$optgroupState   = "close";
					}
					$selectOptions[] = JHtml::_('select.option', '<OPTGROUP>', $selectOptionItem['text']);
					$optgroupState   = "open";
				}
				elseif (strtoupper($option->value) == "</OPTGROUP>")
				{
					$selectOptions[] = JHtml::_('select.option', '</OPTGROUP>');
					$optgroupState   = "close";
				}
				else
				{
					if (isset($option->disabled) && $option->disabled)
					{
						$selectOptions[] = JHtml::_('select.option', $selectOptionItem['value'], $selectOptionItem['text'], "value", "text", true);
					}
					else
					{
						$selectOptions[] = JHtml::_('select.option', $selectOptionItem['value'], $selectOptionItem['text']);
					}
				}
			}
		}

		if (!isset($options[0]->value) || $options[0]->value != "")
		{
			array_unshift($selectOptions, array("text" => "", "value" => ""));
		}

		$this->setAttribute("multiple", "multiple", "search");
		$this->addAttribute("class", $this->getInputClass(), "search");
		if ((int) $this->params->get("search_size", 5))
		{
			$this->setAttribute("size", (int) $this->params->get("search_size", 5), "search");
		}

		$this->setVariable('value', $defaultValue);
		$this->setVariable('options', $selectOptions);

		return $this->fetch('searchinput.php', __CLASS__);
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
					jQuery("[name=\'' . $this->getName() . '\']").find("option:selected").removeAttr("selected");
				}
			}
		';

		$document->addScriptDeclaration($script);
	}
}