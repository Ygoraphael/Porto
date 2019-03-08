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

class JUFormViewSubmission extends JUFMViewAdmin
{
	public function display($tpl = null)
	{
		
		$this->app   = JFactory::getApplication();
		$this->model = $this->getModel();
		$this->item  = $this->get('Item');
		$this->state = $this->get('State');
		$this->form  = JUFormFrontHelperForm::getForm($this->item->form_id);

		$this->script = $this->get('Script');
		$this->fields = JUFormFrontHelperField::getFields($this->item->form_id, $this->item);
		$app          = JFactory::getApplication();
		if ($app->input->get('layout') == 'edit')
		{
			$this->fieldsData     = $this->app->getUserState('com_juform.edit.submission.fieldsdata.' . $this->item->id, array());
			$this->JUFormTemplate = new JUFormTemplate($this->form);

			$pages      = JUFormFrontHelperField::getFieldPages($this->fields);
			$totalPages = 0;
			foreach ($pages AS $page)
			{
				if ($page['beginfield'] || $page['endfield'])
				{
					$totalPages++;
				}
			}

			$this->pages      = $pages;
			$this->totalPages = $totalPages;


			
			if (count($errors = $this->get('Errors')))
			{
				JError::raiseError(500, implode("\n", $errors));

				return false;
			}
		}

		
		$this->addToolBar();

		
		$this->setDocument();

		
		parent::display($tpl);
	}

	
	protected function addToolBar()
	{
		$app = JFactory::getApplication();
		$app->input->set('hidemainmenu', true);

		$canDo      = JUFormHelper::getActions();
		$user       = JFactory::getUser();
		$userId     = $user->id;
		$checkedOut = !($this->item->checked_out == 0 || $this->item->checked_out == $userId);
		JToolBarHelper::title(JText::_('COM_JUFORM_PAGE_' . ($checkedOut ? 'VIEW_SUBMISSION' : 'EDIT_SUBMISSION')), 'file-2');

		if ($app->input->get('layout') == 'edit')
		{
			
			if ($canDo->get('core.edit'))
			{
				
				JToolBarHelper::apply('submission.apply', 'JTOOLBAR_APPLY');
				JToolBarHelper::save('submission.save', 'JTOOLBAR_SAVE');
			}
			JToolBarHelper::cancel('submission.cancel', 'JTOOLBAR_CLOSE');
		}
		else
		{
			JToolBarHelper::back();
		}

		JToolBarHelper::divider();
		$bar = JToolBar::getInstance('toolbar');
		$bar->addButtonPath(JPATH_ADMINISTRATOR . "/components/com_juform/helpers/button");
		$bar->appendButton('JUHelp', 'help', JText::_('JTOOLBAR_HELP'));
	}

	
	protected function setDocument()
	{
		$userId     = JFactory::getUser()->id;
		$document   = JFactory::getDocument();
		$checkedOut = !($this->item->checked_out == 0 || $this->item->checked_out == $userId);
		$document->setTitle(JText::_('COM_JUFORM_PAGE_' . ($checkedOut ? 'VIEW_SUBMISSION' : 'EDIT_SUBMISSION')));
	}

} 