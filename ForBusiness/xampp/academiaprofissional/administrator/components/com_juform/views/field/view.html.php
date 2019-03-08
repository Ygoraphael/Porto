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


class JUFormViewField extends JUFMViewAdmin
{
	
	public $paramform;

	public function display($tpl = null)
	{
		$db = JFactory::getDbo();
		$app = JFactory::getApplication();
		$formId = $app->input->getInt('form_id', 0);
		$query = "SELECT COUNT(*) FROM #__juform_fields WHERE form_id = " . $formId;
		$db->setQuery($query);
		if($db->loadResult() >= 8)
		{
			echo 'You' . 'r fo' . 'rm ' . 'rea' . 'ch ma' . 'x 8 f' . 'ield' . 's per' . ' f' . 'orm';
			return false;
		}
		
		
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode('<br />', $errors));

			return false;
		}

		JHtml::_('behavior.modal');
		JHtml::_('behavior.calendar');

		
		$this->form   = $this->get('Form');
		$this->item   = $this->get('Item');
		$this->script = $this->get('Script');
		$this->canDo  = JUFormHelper::getActions();

		
		$this->addToolBar();

		
		parent::display($tpl);

		
		$this->setDocument();
	}

	
	protected function addToolBar()
	{
		$app = JFactory::getApplication();
		$app->input->set('hidemainmenu', true);

		$isNew  = ($this->item->id == 0);
		$user   = JFactory::getUser();
		$userId = $user->id;
		JToolBarHelper::title(JText::_('COM_JUFORM_PAGE_ADD_FIELD'), 'field-add');
		if ($isNew && $user->authorise('core.create', 'com_juform'))
		{
			JToolBarHelper::apply('field.apply');
			JToolBarHelper::save('field.save');
			JToolBarHelper::save2new('field.save2new');
			JToolBarHelper::cancel('field.cancel');
		}
		else
		{
			
			if ($this->canDo->get('core.edit') || ($this->canDo->get('core.edit.own') && $this->item->created_by == $userId))
			{
				JToolBarHelper::apply('field.apply');
				JToolBarHelper::save('field.save');
				
				if ($this->canDo->get('core.create'))
				{
					JToolBarHelper::save2new('field.save2new');
				}
			}
			JToolBarHelper::cancel('field.cancel', 'JTOOLBAR_CLOSE');
		}

		JToolBarHelper::divider();
		$bar = JToolBar::getInstance('toolbar');
		$bar->addButtonPath(JPATH_ADMINISTRATOR . "/components/com_juform/helpers/button");
		$bar->appendButton('JUHelp', 'help', JText::_('JTOOLBAR_HELP'));
	}

	
	protected function setDocument()
	{
		$document = JFactory::getDocument();
		JToolBarHelper::title(JText::_('COM_JUFORM_PAGE_ADD_FIELD'), 'field-add');

		$document->addScript(JUri::root(true) . '/administrator/components/com_juform/assets/js/jufilter.js');

		$script = 'jQuery(document).ready(function ($){
						$("#adminForm .jufilter").jufilter();
					});';
		$document->addScriptDeclaration($script);

		$document->addScript(JUri::root() . $this->script);
	}
}
