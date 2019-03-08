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


class JUFormViewForm extends JUFMViewAdmin
{
	
	public function display($tpl = null)
	{
		
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode('<br />', $errors));

			return false;
		}

		
		$this->form  = $this->get('Form');
		$this->item  = $this->get('Item');
		$this->model = $this->getModel();
		$this->app   = JFactory::getApplication();
		$this->canDo = JUFormHelper::getActions();

		$this->script = $this->get('Script');

		
		$this->addToolBar();

		
		$this->setDocument();

		
		parent::display($tpl);
	}

	
	protected function addToolBar()
	{
		$app = JFactory::getApplication();
		$app->input->set('hidemainmenu', true);

		$isNew      = ($this->item->id == 0);
		$user       = JFactory::getUser();
		$userId     = $user->id;
		$checkedOut = !($this->item->checked_out == 0 || $this->item->checked_out == $userId);
		$canDo      = JUFormHelper::getActions();
		JToolBarHelper::title(JText::_('COM_JUFORM_PAGE_' . ($checkedOut ? 'VIEW_FORM' : ($isNew ? 'ADD_FORM' : 'EDIT_FORM'))), 'menu-3');

		if ($isNew && $user->authorise('core.create', 'com_juform'))
		{
			JToolBarHelper::apply('form.apply');
			JToolBarHelper::save('form.save');
			JToolBarHelper::save2new('form.save2new');
			JToolBarHelper::cancel('form.cancel');
		}
		else
		{
			
			if (!$checkedOut)
			{
				
				if ($canDo->get('core.edit') || ($canDo->get('core.edit.own') && $this->item->created_by == $userId))
				{
					JToolBarHelper::apply('form.apply');
					JToolBarHelper::save('form.save');
					
					if ($canDo->get('core.create'))
					{
						JToolBarHelper::save2copy('form.save2copy');
						JToolBarHelper::save2new('form.save2new');
					}
				}
			}

			
			if ($this->item->published == 1)
			{
				JToolBarHelper::custom('form.preview', 'screen', '', 'COM_JUFORM_PREVIEW', false);
			}

			
			if ($this->item->published != -1)
			{
				JToolBarHelper::custom('form.submissions', 'stack', '', 'COM_JUFORM_SUBMISSIONS', false);
			}

			JToolBarHelper::cancel('form.cancel', 'JTOOLBAR_CLOSE');
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
		$document->setTitle(JText::_('COM_JUFORM_PAGE_' . ($checkedOut ? 'VIEW_FORM' : ($isNew ? 'ADD_FORM' : 'EDIT_FORM'))));

		$document->addScript(JUri::root(true) . "/" . $this->script);
		$document->addScript(JUri::base(true) . "/components/com_juform/assets/js/spin.min.js");

		$document->addStyleSheet(JUri::root(true) . "/components/com_juform/assets/fancybox/css/jquery.fancybox.css");
		$document->addStyleSheet(JUri::root(true) . "/components/com_juform/assets/fancybox/css/jquery.fancybox-thumbs.css");
		$document->addStyleSheet(JUri::root(true) . "/components/com_juform/assets/fancybox/css/jquery.fancybox-buttons.css");

		$document->addScript(JUri::root(true) . "/components/com_juform/assets/fancybox/js/jquery.mousewheel-3.0.6.pack.js");
		$document->addScript(JUri::root(true) . "/components/com_juform/assets/fancybox/js/jquery.fancybox.pack.js");
		$document->addScript(JUri::root(true) . "/components/com_juform/assets/fancybox/js/jquery.fancybox-thumbs.js");
		$document->addScript(JUri::root(true) . "/components/com_juform/assets/fancybox/js/jquery.fancybox-buttons.js");
		$document->addScript(JUri::root(true) . "/components/com_juform/assets/fancybox/js/jquery.fancybox-media.js");

		$document->addScript(JUri::root(true) . '/administrator/components/com_juform/assets/js/jufilter.js');

		$script = 'jQuery(document).ready(function ($){
						$("#adminForm .jufilter").jufilter();
					});';
		$document->addScriptDeclaration($script);
	}
}