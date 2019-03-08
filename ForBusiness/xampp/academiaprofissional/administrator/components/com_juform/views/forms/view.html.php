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


class JUFormViewForms extends JUFMViewAdmin
{
	
	public function display($tpl = null)
	{
		
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode('<br />', $errors));

			return false;
		}

		
		$this->items            = $this->get('Items');
		$this->state            = $this->get('State');
		$this->authors          = $this->get('Authors');
		$this->pagination       = $this->get('Pagination');
		$this->canDo            = JUFormHelper::getActions();
		$this->groupCanDoManage = JUFormHelper::checkGroupPermission("form.edit");
		$this->groupCanDoDelete = JUFormHelper::checkGroupPermission("forms.delete");

		$this->filterForm    = $this->get('FilterForm');
		$this->activeFilters = $this->get('ActiveFilters');

		$this->addToolBar();

		$this->setDocument();

		
		parent::display($tpl);
	}

	protected function setDocument()
	{
		$document = JFactory::getDocument();
		JToolBarHelper::title(JText::_('COM_JUFORM_FORMS'), 'menu-3');
		$document->setTitle(JText::_('COM_JUFORM_FORMS'));
	}

	
	protected function addToolBar()
	{
		JToolBarHelper::title(JText::_('COM_JUFORM_MANAGER_FORMS'), 'forms');

		if ($this->groupCanDoManage)
		{
			if ($this->canDo->get('core.create'))
			{
				JToolBarHelper::addNew('form.add');
			}

			if ($this->canDo->get('core.edit') || $this->canDo->get('core.edit.own'))
			{
				JToolBarHelper::editList('form.edit');
			}

			if ($this->canDo->get('core.edit.state'))
			{
				JToolbarHelper::publish('forms.publish', 'JTOOLBAR_PUBLISH', true);
				JToolbarHelper::unpublish('forms.unpublish', 'JTOOLBAR_UNPUBLISH', true);
				JToolbarHelper::checkin('forms.checkin');
			}
		}

		if ($this->groupCanDoDelete)
		{
			if ($this->canDo->get('core.delete'))
			{
				JToolBarHelper::deleteList('COM_JUFORM_ARE_YOU_SURE_YOU_WANT_TO_DELETE_THESE_ITEMS', 'forms.delete');
			}
		}

		JToolBarHelper::divider();
		$bar = JToolBar::getInstance('toolbar');
		$bar->addButtonPath(JPATH_ADMINISTRATOR . "/components/com_juform/helpers/button");
		$bar->appendButton('JUHelp', 'help', JText::_('JTOOLBAR_HELP'));
	}
}
