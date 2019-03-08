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


class JUFormViewMenuitems extends JUFMViewAdmin
{
	
	public function display($tpl = null)
	{
		
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode('<br />', $errors));

			return false;
		}

		
		$this->items      = $this->get('Items');
		$this->menutypes  = $this->get('Menutypes');
		$this->state      = $this->get('State');
		$this->pagination = $this->get('Pagination');

		$this->setDocument();

		
		parent::display($tpl);
	}

	protected function setDocument()
	{
		$document = JFactory::getDocument();
		JToolBarHelper::title(JText::_('COM_JUFORM_MENUITEMS'), 'menuitems');
		$document->setTitle(JText::_('COM_JUFORM_MENUITEMS'));
	}
}
