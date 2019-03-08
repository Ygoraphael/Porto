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


class JUFormViewSubmissions extends JUFMViewAdmin
{
	
	public function display($tpl = null)
	{
		
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode('<br />', $errors));

			return false;
		}
		
		$this->model            = $this->getModel();
		$this->items            = $this->get('Items');
		$this->state            = $this->get('State');
		$this->pagination       = $this->get('Pagination');
		$this->canDo            = JUFormHelper::getActions();
		$this->groupCanDoManage = JUFormHelper::checkGroupPermission("submission.edit");
		$this->groupCanDoDelete = JUFormHelper::checkGroupPermission("submissions.delete");

		$this->addToolBar();

		
		$this->filterForm    = $this->get('FilterForm');
		$this->activeFilters = $this->get('ActiveFilters');

		$this->setDocument();

		
		parent::display($tpl);
	}

	protected function setDocument()
	{
		$document = JFactory::getDocument();
		JToolBarHelper::title(JText::_('COM_JUFORM_SUBMISSIONS'), 'stack');
		$document->setTitle(JText::_('COM_JUFORM_SUBMISSIONS'));

		$document->addStyleSheet(JUri::root(true) . "/components/com_juform/assets/fancybox/css/jquery.fancybox.css");
		$document->addStyleSheet(JUri::root(true) . "/components/com_juform/assets/fancybox/css/jquery.fancybox-thumbs.css");
		$document->addStyleSheet(JUri::root(true) . "/components/com_juform/assets/fancybox/css/jquery.fancybox-buttons.css");

		$document->addScript(JUri::root(true) . "/components/com_juform/assets/fancybox/js/jquery.mousewheel-3.0.6.pack.js");
		$document->addScript(JUri::root(true) . "/components/com_juform/assets/fancybox/js/jquery.fancybox.pack.js");
		$document->addScript(JUri::root(true) . "/components/com_juform/assets/fancybox/js/jquery.fancybox-thumbs.js");
		$document->addScript(JUri::root(true) . "/components/com_juform/assets/fancybox/js/jquery.fancybox-buttons.js");
		$document->addScript(JUri::root(true) . "/components/com_juform/assets/fancybox/js/jquery.fancybox-media.js");
	}

	
	protected function addToolBar()
	{
		JToolBarHelper::title(JText::_('COM_JUFORM_MANAGER_SUBMISSIONS'), 'submissions');

		if ($this->groupCanDoManage)
		{
			if ($this->canDo->get('core.edit') || $this->canDo->get('core.edit.own'))
			{
				JToolBarHelper::editList('submission.edit');
			}

			if ($this->canDo->get('core.edit.state'))
			{
				JToolbarHelper::checkin('submissions.checkin');
			}
		}

		if ($this->groupCanDoDelete)
		{
			if ($this->canDo->get('core.delete'))
			{
				JToolBarHelper::deleteList('COM_JUFORM_ARE_YOU_SURE_YOU_WANT_TO_DELETE_THESE_ITEMS', 'submissions.delete');
			}
		}

		if (JUFormHelper::checkGroupPermission("csvprocess.export"))
		{
			JToolBarHelper::custom('submissions.export', 'upload', 'upload', 'COM_JUFORM_EXPORT', false);
		}

		JToolBarHelper::divider();
		$bar = JToolBar::getInstance('toolbar');
		$bar->addButtonPath(JPATH_ADMINISTRATOR . "/components/com_juform/helpers/button");
		$bar->appendButton('JUHelp', 'help', JText::_('JTOOLBAR_HELP'));
	}
}
