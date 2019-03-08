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


class JUFormControllerSubmissions extends JControllerAdmin
{
	
	protected $text_prefix = 'COM_JUFORM_SUBMISSIONS';

	
	public function getModel($name = 'Submission', $prefix = 'JUFormModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);

		return $model;
	}

	public function saveOrderingField()
	{
		
		JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		$app           = JFactory::getApplication();
		$fieldOrdering = $app->input->post->get('fieldOrdering', '', 'string');
		if ($fieldOrdering)
		{
			$fieldOrdering = json_decode($fieldOrdering);
			$model         = $this->getModel();
			if ($model->saveOrderingField($fieldOrdering))
			{
				JUFormHelper::obCleanData();
				echo 1;
				exit;
			}
		}
	}
}
