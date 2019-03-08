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


abstract class JHtmlJUFormAdministrator
{

	
	public static function calendar($value, $name, $id, $format = '%Y-%m-%d', $attribs = null)
	{
		static $done;

		if ($done === null)
		{
			$done = array();
		}

		$readonly = isset($attribs['readonly']) && $attribs['readonly'] == 'readonly';
		$disabled = isset($attribs['disabled']) && $attribs['disabled'] == 'disabled';
		if (is_array($attribs))
		{
			$attribs = JArrayHelper::toString($attribs);
		}

		if (!$readonly && !$disabled)
		{
			
			JHtml::_('behavior.calendar');
			JHtml::_('behavior.tooltip');

			
			if (!in_array($id, $done))
			{
				$document = JFactory::getDocument();
				$script   =
					'window.addEvent(\'domready\', function() {
						Calendar.setup({
							
							inputField: "' . $id . '",
								
								ifFormat: "' . $format . '",
								
								button: "' . $id . '_img",
								
								align: "Tl",
								singleClick: true,
								firstDay: ' . JFactory::getLanguage()->getFirstDay() . '
							});
						});';
				$document->addScriptDeclaration($script);
				$done[] = $id;
			}

			$html = '<div class="input-append">';
			$html .= '<input type="text" title="' . (0 !== (int) $value ? JHtml::_('date', $value, null, null) : '') . '" name="' . $name . '" id="' . $id
				. '" value="' . htmlspecialchars($value, ENT_COMPAT, 'UTF-8') . '" ' . $attribs . ' />'
				. '<span class="add-on icon-calendar fa fa-calendar" id="' . $id . '_img"></span>';
			$html .= '</div>';

			return $html;
		}
		else
		{
			$html = '<div class="input-append">';
			$html .= '<input type="text" title="' . (0 !== (int) $value ? JHtml::_('date', $value, null, null) : '')
				. '" value="' . (0 !== (int) $value ? JHtml::_('date', $value, 'Y-m-d H:i:s', null) : '') . '" ' . $attribs
				. ' /><input type="hidden" name="' . $name . '" id="' . $id . '" value="' . htmlspecialchars($value, ENT_COMPAT, 'UTF-8') . '" />';
			$html .= '</div>';

			return $html;
		}
	}

	
	public static function action($i, $task, $prefix = '', $text = '', $active_title = '', $inactive_title = '', $tip = false, $active_class = '',
	                              $inactive_class = '', $enabled = true, $translate = true, $checkbox = 'cb')
	{
		if (is_array($prefix))
		{
			$options        = $prefix;
			$active_title   = array_key_exists('active_title', $options) ? $options['active_title'] : $active_title;
			$inactive_title = array_key_exists('inactive_title', $options) ? $options['inactive_title'] : $inactive_title;
			$tip            = array_key_exists('tip', $options) ? $options['tip'] : $tip;
			$active_class   = array_key_exists('active_class', $options) ? $options['active_class'] : $active_class;
			$inactive_class = array_key_exists('inactive_class', $options) ? $options['inactive_class'] : $inactive_class;
			$enabled        = array_key_exists('enabled', $options) ? $options['enabled'] : $enabled;
			$translate      = array_key_exists('translate', $options) ? $options['translate'] : $translate;
			$checkbox       = array_key_exists('checkbox', $options) ? $options['checkbox'] : $checkbox;
			$prefix         = array_key_exists('prefix', $options) ? $options['prefix'] : '';
		}

		if ($tip)
		{
			JHtml::_('bootstrap.tooltip');

			$title = $enabled ? $active_title : $inactive_title;
			$title = $translate ? JText::_($title) : $title;
			$title = JHtml::tooltipText($title, '', 0);
		}

		if ($enabled)
		{
			$html[] = '<a class="field-publish btn btn-micro' . ($active_class == 'publish' ? ' active' : '') . ($tip ? ' hasTooltip' : '') . '"';
			$html[] = ' href="javascript:void(0);" onclick="return changeFieldPublish(this, ' . $i . ')"';
			$html[] = $tip ? ' title="' . $title . '"' : '';
			$html[] = '>';
			$html[] = '<i class="icon-' . $active_class . '">';
			$html[] = '</i>';
			$html[] = '</a>';
		}
		else
		{
			$html[] = '<a class="btn btn-micro disabled jgrid' . ($tip ? ' hasTooltip' : '') . '"';
			$html[] = $tip ? ' title="' . $title . '"' : '';
			$html[] = '>';

			if ($active_class == "protected")
			{
				$html[] = '<i class="icon-lock"></i>';
			}
			else
			{
				$html[] = '<i class="icon-' . $inactive_class . '"></i>';
			}

			$html[] = '</a>';
		}

		return implode($html);
	}

	
	public static function state($states, $value, $i, $prefix = '', $enabled = true, $translate = true, $checkbox = 'cb')
	{
		if (is_array($prefix))
		{
			$options   = $prefix;
			$enabled   = array_key_exists('enabled', $options) ? $options['enabled'] : $enabled;
			$translate = array_key_exists('translate', $options) ? $options['translate'] : $translate;
			$checkbox  = array_key_exists('checkbox', $options) ? $options['checkbox'] : $checkbox;
			$prefix    = array_key_exists('prefix', $options) ? $options['prefix'] : '';
		}

		$state          = JArrayHelper::getValue($states, (int) $value, $states[0]);
		$task           = array_key_exists('task', $state) ? $state['task'] : $state[0];
		$text           = array_key_exists('text', $state) ? $state['text'] : (array_key_exists(1, $state) ? $state[1] : '');
		$active_title   = array_key_exists('active_title', $state) ? $state['active_title'] : (array_key_exists(2, $state) ? $state[2] : '');
		$inactive_title = array_key_exists('inactive_title', $state) ? $state['inactive_title'] : (array_key_exists(3, $state) ? $state[3] : '');
		$tip            = array_key_exists('tip', $state) ? $state['tip'] : (array_key_exists(4, $state) ? $state[4] : false);
		$active_class   = array_key_exists('active_class', $state) ? $state['active_class'] : (array_key_exists(5, $state) ? $state[5] : '');
		$inactive_class = array_key_exists('inactive_class', $state) ? $state['inactive_class'] : (array_key_exists(6, $state) ? $state[6] : '');

		return static::action(
			$i, $task, $prefix, $text, $active_title, $inactive_title, $tip,
			$active_class, $inactive_class, $enabled, $translate, $checkbox
		);
	}

	
	public static function published($value, $i, $prefix = '', $enabled = true, $checkbox = 'cb', $publish_up = null, $publish_down = null)
	{
		if (is_array($prefix))
		{
			$options  = $prefix;
			$enabled  = array_key_exists('enabled', $options) ? $options['enabled'] : $enabled;
			$checkbox = array_key_exists('checkbox', $options) ? $options['checkbox'] : $checkbox;
			$prefix   = array_key_exists('prefix', $options) ? $options['prefix'] : '';
		}

		$states = array(1  => array('unpublish', 'JPUBLISHED', 'JLIB_HTML_UNPUBLISH_ITEM', 'JPUBLISHED', true, 'publish', 'publish'),
		                0  => array('publish', 'JUNPUBLISHED', 'JLIB_HTML_PUBLISH_ITEM', 'JUNPUBLISHED', true, 'unpublish', 'unpublish'),
		                2  => array('unpublish', 'JARCHIVED', 'JLIB_HTML_UNPUBLISH_ITEM', 'JARCHIVED', true, 'archive', 'archive'),
		                -2 => array('publish', 'JTRASHED', 'JLIB_HTML_PUBLISH_ITEM', 'JTRASHED', true, 'trash', 'trash'));

		
		if ($publish_up || $publish_down)
		{
			$nullDate = JFactory::getDbo()->getNullDate();
			$nowDate  = JFactory::getDate()->toUnix();

			$tz = new DateTimeZone(JFactory::getUser()->getParam('timezone', JFactory::getConfig()->get('offset')));

			$publish_up   = ($publish_up != $nullDate) ? JFactory::getDate($publish_up, 'UTC')->setTimeZone($tz) : false;
			$publish_down = ($publish_down != $nullDate) ? JFactory::getDate($publish_down, 'UTC')->setTimeZone($tz) : false;

			
			$tips = array();

			if ($publish_up)
			{
				$tips[] = JText::sprintf('JLIB_HTML_PUBLISHED_START', $publish_up->format(JDate::$format, true));
			}

			if ($publish_down)
			{
				$tips[] = JText::sprintf('JLIB_HTML_PUBLISHED_FINISHED', $publish_down->format(JDate::$format, true));
			}

			$tip = empty($tips) ? false : implode('<br />', $tips);

			
			foreach ($states as $key => $state)
			{
				
				if ($key == 1)
				{
					$states[$key][2] = $states[$key][3] = 'JLIB_HTML_PUBLISHED_ITEM';

					if ($publish_up > $nullDate && $nowDate < $publish_up->toUnix())
					{
						$states[$key][2] = $states[$key][3] = 'JLIB_HTML_PUBLISHED_PENDING_ITEM';
						$states[$key][5] = $states[$key][6] = 'pending';
					}

					if ($publish_down > $nullDate && $nowDate > $publish_down->toUnix())
					{
						$states[$key][2] = $states[$key][3] = 'JLIB_HTML_PUBLISHED_EXPIRED_ITEM';
						$states[$key][5] = $states[$key][6] = 'expired';
					}
				}

				
				if ($tip)
				{
					$states[$key][1] = JText::_($states[$key][1]);
					$states[$key][2] = JText::_($states[$key][2]) . '<br />' . $tip;
					$states[$key][3] = JText::_($states[$key][3]) . '<br />' . $tip;
					$states[$key][4] = true;
				}
			}

			return static::state($states, $value, $i, array('prefix' => $prefix, 'translate' => !$tip), $enabled, true, $checkbox);
		}

		return static::state($states, $value, $i, $prefix, $enabled, true, $checkbox);
	}
}
