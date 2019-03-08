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


jimport('joomla.application.component.controlleradmin');


class JUFormControllerDashboard extends JControllerAdmin
{
	
	protected $text_prefix = 'COM_JUFORM_DASHBOARD';

	
	public function getModel($name = 'Dashboard', $prefix = 'JUFormModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);

		return $model;
	}

	public function show()
	{
		$this->setRedirect("index.php?option=com_juform&view=dashboard");
	}

	public function getChartData()
	{
		$app  = JFactory::getApplication();
		$type = $app->input->get('type');

		$model = $this->getModel();
		$data  = $model->getSubmissionData($type);

		$app = JFactory::getApplication();
		$app->setUserState('com_juform.dashboard.chart.type', $type);

		JUFormHelper::obCleanData();
		echo json_encode($data);
		exit;
	}
}
