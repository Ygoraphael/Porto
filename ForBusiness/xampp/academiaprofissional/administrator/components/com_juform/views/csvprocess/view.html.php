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
JHtml::addIncludePath(JPATH_ADMINISTRATOR . '/components/com_juform/helpers/html');

class JUFormViewCSVProcess extends JUFMViewAdmin
{
	public $fieldsOption = array();

	public function display($tpl = null)
	{
		JHtml::_('behavior.calendar');
		$this->addToolBar();
		$this->model = $this->getModel();

		if ($this->getLayout() == "selectform")
		{
			$this->formOptions = $this->model->getFormOptions();
		}

		
		if ($this->getLayout() == "export")
		{
			$this->exportForm = $this->get("Form");
		}

		parent::display($tpl);
	}

	public function addToolBar()
	{
		JToolBarHelper::title(JText::_('COM_JUFORM_CSV_PROCESS'), 'csv-process');
		switch ($this->getLayout())
		{
			case 'export':
				JToolBarHelper::back();
				JToolBarHelper::custom('csvprocess.exportProcessing', 'upload', 'upload', 'COM_JUFORM_EXPORT', false);
				break;

			case 'selectform':
				JToolBarHelper::custom('csvprocess.selectForm', 'next', 'next', 'COM_JUFORM_NEXT', false);
				JToolBarHelper::cancel('csvprocess.cancel', 'JTOOLBAR_CANCEL');
				break;
		}

		JToolBarHelper::divider();
		$bar = JToolBar::getInstance('toolbar');
		$bar->addButtonPath(JPATH_ADMINISTRATOR . "/components/com_juform/helpers/button");
		$bar->appendButton('JUHelp', 'help', JText::_('JTOOLBAR_HELP'));
	}
}