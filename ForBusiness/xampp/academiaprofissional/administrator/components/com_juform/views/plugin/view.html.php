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


class JUFormViewPlugin extends JUFMViewAdmin
{
	
	public function display($tpl = null)
	{
		
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode('<br />', $errors));

			return false;
		}

		
		$this->item  = $this->get('Item');
		$this->form  = $this->get('Form');
		$this->canDo = JUFormHelper::getActions();

		
		$this->addToolBar();

		
		parent::display($tpl);

		
		$this->setDocument();
	}

	
	protected function addToolBar()
	{
		$app = JFactory::getApplication();
		$app->input->set('hidemainmenu', true);

		$isNew      = ($this->item->id == 0);
		$user       = JFactory::getUser();
		$userId     = $user->id;
		$checkedOut = !($this->item->checked_out == 0 || $this->item->checked_out == $userId);
		JToolBarHelper::title(JText::_('COM_JUFORM_PAGE_' . ($checkedOut ? 'VIEW_PLUGIN' : ($isNew ? 'ADD_PLUGIN' : 'EDIT_PLUGIN'))), 'puzzle');

		if ($isNew && $this->canDo->get('core.create'))
		{
			if ($this->getLayout() == 'install')
			{
				
				JToolBarHelper::back('JTOOLBAR_BACK', 'index.php?option=com_juform&view=plugins');
			}
			else
			{
				JToolBarHelper::apply('plugin.apply');
				JToolBarHelper::save('plugin.save');
				JToolBarHelper::cancel('plugin.cancel');
			}
		}
		else
		{
			if (!$checkedOut)
			{
				
				if ($this->canDo->get('core.edit') || ($this->canDo->get('core.edit.own') && $this->item->created_by == $userId))
				{
					JToolBarHelper::apply('plugin.apply');
					JToolBarHelper::save('plugin.save');
				}
			}

			JToolBarHelper::cancel('plugin.cancel', 'JTOOLBAR_CLOSE');
		}

		JToolBarHelper::divider();
		$bar = JToolBar::getInstance('toolbar');
		$bar->addButtonPath(JPATH_ADMINISTRATOR . "/components/com_juform/helpers/button");
		$bar->appendButton('JUHelp', 'help', JText::_('JTOOLBAR_HELP'));
	}

	
	protected function setDocument()
	{
		$isNew      = ($this->item->id == 0);
		$userId     = JFactory::getUser()->id;
		$document   = JFactory::getDocument();
		$checkedOut = !($this->item->checked_out == 0 || $this->item->checked_out == $userId);
		$document->setTitle(JText::_('COM_JUFORM_PAGE_' . ($checkedOut ? 'VIEW_PLUGIN' : ($isNew ? 'ADD_PLUGIN' : 'EDIT_PLUGIN'))));

		JHtml::_('script', 'system/core.js', false, true);
	}
}