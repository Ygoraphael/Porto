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

class JFormFieldLayoutCode extends JFormField
{
	
	protected $type = 'layoutcode';

	protected function getInput()
	{
		$editor = JEditor::getInstance('codemirror');

		$editor_html = $editor->display($this->name, htmlspecialchars($this->value, ENT_COMPAT, 'UTF-8'), 400, 300, 50, 5, '', $this->id);

		
		if(!$editor_html)
		{
			JFactory::getApplication()->enqueueMessage('You should enable <a href="index.php?option=com_plugins&view=plugins&filter[search]=CodeMirror" target="_blank">CodeMirror Editor plugin</a> to edit code easier', 'notice');

			$editor = JEditor::getInstance();

			$editor_html = $editor->display($this->name, htmlspecialchars($this->value, ENT_COMPAT, 'UTF-8'), 400, 300, 50, 5, '', $this->id);
		}

		echo $editor_html;
	}

	protected function getLabel()
	{
		return '';
	}
}
