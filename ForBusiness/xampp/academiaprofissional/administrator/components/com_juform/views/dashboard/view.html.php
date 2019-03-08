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


class JUFormViewDashboard extends JUFMViewAdmin
{
	
	public function display($tpl = null)
	{
		
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode('<br />', $errors));

			return false;
		}

		$app = JFactory::getApplication();

		$this->canDo = JUFormHelper::getActions();

		$saveMessage = $app->getUserState('com_juform.backendpermission.message');
		if ($saveMessage)
		{
			$app->enqueueMessage($saveMessage);
			$app->setUserState('com_juform.backendpermission.message', '');
		}

		
		$this->addToolBar();

		
		parent::display($tpl);

		
		$this->setDocument();
	}

	
	protected function addToolBar()
	{
		JToolBarHelper::title(JText::_('COM_JUFORM_DASHBOARD'), 'dashboard');

		if ($this->canDo->get('core.admin'))
		{
			JToolBarHelper::preferences('com_juform');
			JToolBarHelper::divider();
		}

		$bar = JToolBar::getInstance('toolbar');
		$bar->addButtonPath(JPATH_ADMINISTRATOR . "/components/com_juform/helpers/button");
		$bar->appendButton('JUHelp', 'help', JText::_('JTOOLBAR_HELP'));
	}

	
	protected function setDocument()
	{
		$document = JFactory::getDocument();
		$document->setTitle(JText::_('COM_JUFORM_DASHBOARD'));
	}
}
