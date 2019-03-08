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

jimport('joomla.application.component.controllerform');

class JUFormControllerCSVProcess extends JControllerForm
{
	public function getModel($name = 'CSVProcess', $prefix = 'JUFormModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);

		return $model;
	}

	public function cancel($key = null)
	{
		$app = JFactory::getApplication();
		$app->setUserState('csv.exportFormId', '');
		$this->setRedirect(JRoute::_('index.php?option=com_juform&view=csvprocess', false));

		return true;
	}

	public function export()
	{
		$this->setRedirect('index.php?option=com_juform&view=csvprocess&layout=selectform');

		return true;
	}

	public function selectForm()
	{
		$app    = JFactory::getApplication();
		$formId = $app->input->get('form_id', 0);
		if ($formId <= 0)
		{
			$this->setRedirect('index.php?option=com_juform&view=csvprocess&layout=selectform');
		}
		else
		{
			$app->setUserState('csv.exportFormId', $formId);
			$this->setRedirect('index.php?option=com_juform&view=csvprocess&layout=export');
		}

		return true;
	}

	public function exportProcessing()
	{
		
		JSession::checkToken() or die(JText::_('JINVALID_TOKEN'));

		$model = $this->getModel();
		$model->export();

		return true;
	}
}