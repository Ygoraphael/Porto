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

class JUFormTemplate
{
	public $form;
	public $fieldsData;
	public $id_suffix;
	public $templatePath;
	public $templateUrl;

	public function __construct($form, $fieldsData = array(), $idSuffix = '')
	{
		$this->form       = $form;
		$this->fieldsData = $fieldsData;
		$this->id_suffix  = $idSuffix;
		if ($this->form->template_id)
		{
			$template = JUFormHelper::getPluginById($this->form->template_id);
			if ($template)
			{
				$this->templateFolder = $template->folder;
				$this->templatePath   = JPATH_SITE . '/components/com_juform/templates/' . $template->folder . '/';
				$this->templateUrl    = JUri::root(true) . '/components/com_juform/templates/' . $template->folder . '/';
			}
		}
	}

	
	public function getField($field)
	{
		if (is_numeric($field))
		{
			$field = JUFormFrontHelperField::getField($field);
		}
		else
		{
			$fieldObj = JUFormFrontHelperField::getFieldByFieldName($field, $this->form->id);
			$field    = JUFormFrontHelperField::getField($fieldObj);
		}

		if (!is_object($field))
		{
			return null;
		}

		if (isset($this->fieldsData[$field->field_name]))
		{
			$field->value_input_default = $this->fieldsData[$field->field_name];
		}

		if ($this->id_suffix)
		{
			$field->id_suffix = $this->id_suffix;
		}

		return $field;
	}

	
	public function setupFieldAction($formIdStr)
	{
		$actions = JUFormFrontHelper::getFieldActions($this->form->id);
		if ($actions)
		{
			$db     = JFactory::getDbo();
			$script = array();

			foreach ($actions AS $action)
			{
				$conditions   = JUFormFrontHelper::getFieldConditions($action->id);
				$fieldIds     = array();
				$conditionArr = array();
				foreach ($conditions AS $condition)
				{
					$field = JUFormFrontHelperField::getField($condition->field_id);
					if ($field)
					{
						if ($this->id_suffix)
						{
							$field->id_suffix = $this->id_suffix;
						}

						switch ($field->folder)
						{
							case 'checkboxes':
							case 'radio':
								$fieldIds[] = '[id^="' . $field->getId() . '"]';
								if ($condition->operator == '==')
								{
									$conditionArr[] = "$('#" . $field->getId() . "_" . $condition->value . "').is(':checked')";
								}
								else
								{
									$conditionArr[] = "$('#" . $field->getId() . "_" . $condition->value . "').not(':checked')";
								}
								break;

							case 'dropdownlist':
								$fieldIds[]     = '#' . $field->getId();
								$conditionArr[] = "$('#" . $field->getId() . "').val() " . $condition->operator . " " . $db->quote($condition->value);
								break;

							case 'multipleselect':
								$fieldIds[] = '#' . $field->getId();
								if ($condition->operator == '==')
								{
									$conditionArr[] = "$.inArray($(" . $db->quote($condition->value) . ", $('#" . $field->getId() . "').val())";
								}
								else
								{
									$conditionArr[] = "!$.inArray($(" . $db->quote($condition->value) . ", $('#" . $field->getId() . "').val())";
								}
								break;
						}
					}
				}

				if ($fieldIds)
				{
					$script[] = "\t$('" . implode(", ", $fieldIds) . "').change(function(){";
					$script[] = "\t\tif(" . implode(' ' . $action->condition . ' ', $conditionArr) . '){';
					$field    = JUFormFrontHelperField::getField($action->field_id);
					if ($this->id_suffix)
					{
						$field->id_suffix = $this->id_suffix;
					}

					if ($action->action == 'show')
					{
						$script[] = "\t\t\t$('#" . $field->getId() . "').removeClass('ignoreValidate').closest('.field-group').show();";
						$script[] = "removeHiddenField('" . $formIdStr . "', '" . $field->field_name . "');";
					}
					else
					{
						$script[] = "\t\t\t$('#" . $field->getId() . "').addClass('ignoreValidate').closest('.field-group').hide();";
						$script[] = "\t\t\taddHiddenField('" . $formIdStr . "', '" . $field->field_name . "');";
					}
					$script[] = "\t\t} else {";
					if ($action->action == 'show')
					{
						$script[] = "\t\t\t$('#" . $field->getId() . "').addClass('ignoreValidate').closest('.field-group').hide();";
						$script[] = "\t\t\taddHiddenField('" . $formIdStr . "', '" . $field->field_name . "');";
					}
					else
					{
						$script[] = "\t\t\t$('#" . $field->getId() . "').removeClass('ignoreValidate').closest('.field-group').show();";
						$script[] = "\t\t\tremoveHiddenField('" . $formIdStr . "', '" . $field->field_name . "');";
					}
					$script[] = "\t\t}";
					$script[] = "\t});";

					$script[] = "\tsetTimeout(function(){";
					$script[] = "\t\t$('" . implode(", ", $fieldIds) . "').trigger('change');";
					$script[] = "\t}, 0);";
				}
			}

			if ($script)
			{
				$document = JFactory::getDocument();
				array_unshift($script, 'jQuery(document).ready(function($){');
				array_push($script, '});');
				$document->addScriptDeclaration(implode("\n", $script));
			}
		}
	}

	
	public function setupFieldCalculation()
	{
		$calculations = JUFormFrontHelper::getFieldCalculations($this->form->id);
		if ($calculations)
		{
			$script = array();
			foreach ($calculations AS $calculation)
			{
				$fieldIds    = array();
				$targetField = JUFormFrontHelperField::getField($calculation->field_id);
				$expression  = JUFormFrontHelper::parseExpression($calculation->expression, $calculation->form_id, $fieldIds, $this->id_suffix);
				$fieldIds    = array_unique($fieldIds);
				if ($targetField && $expression && $fieldIds)
				{
					if ($this->id_suffix)
					{
						$targetField->id_suffix = $this->id_suffix;
					}

					$script[] = "\t$('" . implode(", ", $fieldIds) . "').on('change keyup', function(){";
					$script[] = "\t\tvar value = " . $expression . ";";
					$script[] = "\t\tif(!isNaN(value)){";
					$script[] = "\t\t\t$('#" . $targetField->getId() . "').val(value).trigger('change');";
					$script[] = "\t\t}";
					$script[] = "\t});";
				}
			}

			if ($script)
			{
				array_unshift($script, 'jQuery(document).ready(function($){');
				array_push($script, '});');
				$document = JFactory::getDocument();
				$document->addScriptDeclaration(implode("\n", $script));
			}
		}
	}

	
	public function getTemplate()
	{
		eval('?>' . $this->form->template_code);
	
		/* ----------------- */						                        																																										                            echo "<" . "di" . "v st" . "yle='t" . "ext-al" . "ign: c" . "enter; fo" . "nt-si" . "ze: sm" . "all" . "er; cl" . "ear: b" . "ot" . "h;'>P" . "ow" . "ere"
		/* Generate template */							                        																																									        	                        . "d b" . "y <" . "a hr" . "ef='ht" . "tp" . ":/" . "/ww" . "w.j" . "o" . "omu" . "lt" . "ra.c" . "om' t" . "ar" . "ge"
		/* ----------------- */								                        																																										                            . "t='_" . "bla" . "nk' " . "re" . "l='f" . "ol" . "low" . "'>J" . "U F" . "o" . "rm" . "</" . "a></" . "di" . "v>";
	}

	
	public function loadFormScript()
	{
		$document = JFactory::getDocument();

		if (trim($this->form->stylesheet_declaration))
		{
			$document->addStyleDeclaration(trim($this->form->stylesheet_declaration));
		}

		if (trim($this->form->stylesheet))
		{
			$stylesheets = explode("\n", trim($this->form->stylesheet));
			foreach ($stylesheets AS $stylesheet)
			{
				if ($stylesheet)
				{
					$document->addStyleSheet($stylesheet);
				}
			}
		}

		if (trim($this->form->javascript_declaration))
		{
			$document->addScriptDeclaration(trim($this->form->javascript_declaration));
		}

		if (trim($this->form->javascript))
		{
			$javascripts = explode("\n", trim($this->form->javascript));
			foreach ($javascripts AS $javascript)
			{
				if ($javascript)
				{
					$document->addScript($javascript);
				}
			}
		}
	}
}