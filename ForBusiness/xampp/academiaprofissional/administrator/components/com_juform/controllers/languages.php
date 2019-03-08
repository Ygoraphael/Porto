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


jimport('joomla.application.component.controller');


class JUFormControllerLanguages extends JControllerLegacy
{
	
	protected $text_prefix = 'COM_JUFORM_LANGUAGES';

	public function save($key = null, $urlVar = null)
	{
		
		JSession::checkToken() or die(JText::_('JINVALID_TOKEN'));

		$data  = $_POST;
		$model = $this->getModel();
		$model->save($data);
		$this->setRedirect("index.php?option=com_juform&view=languages&site=" .
			$data['site'] . '&lang=' . $data['lang'] . '&item=' . $data['item'],
			JText::_('COM_JUFORM_LANGUAGE_SAVED'));
	}

	
	public function saveAjax()
	{
		$app  = JFactory::getApplication();
		$key  = $app->input->get('key', '', 'string');
		$val  = $app->input->get('value', '', 'raw');
		$site = $app->input->get('site', '', 'string');
		$file = $app->input->get('file', '', 'string');
		$lang = $app->input->get('lang', '', 'string');

		if ($site == 'frontend')
		{
			$filePath = JPATH_ROOT . "/language/" . $lang . "/" . $lang . $file;
		}

		if ($site == 'backend')
		{
			$filePath = JPATH_ADMINISTRATOR . "/language/" . $lang . "/" . $lang . $file;
		}

		JUFormHelper::obCleanData();
		if (JFile::exists($filePath))
		{
			$model = $this->getModel();
			echo $model->saveLanguageKey($key, $val, $filePath);
		}
		else
		{
			echo JText::_('COM_JUFORM_LANGUAGE_FILE_DOES_NOT_EXIST');
		}
		exit;
	}

	
	public function removeAjax()
	{
		$app  = JFactory::getApplication();
		$data = $app->input->getArray($_REQUEST);
		$file = $data['file'];
		$site = $data['site'];
		$lang = $data['lang'];

		if ($site == 'frontend')
		{
			$filePath = JPATH_ROOT . "/language/" . $lang . "/" . $lang . $file;
		}

		if ($site == 'backend')
		{
			$filePath = JPATH_ADMINISTRATOR . "/language/" . $lang . "/" . $lang . $file;
		}

		JUFormHelper::obCleanData();
		if (JFile::exists($filePath))
		{
			$model = $this->getModel();
			echo $model->removeLanguageKey($data, $filePath);
		}
		else
		{
			echo JText::_('COM_JUFORM_LANGUAGE_FILE_DOES_NOT_EXIST');
		}
		exit;
	}

	public function share()
	{
		
		JSession::checkToken() or die(JText::_('JINVALID_TOKEN'));
		$app  = JFactory::getApplication();
		$site = $app->input->getString('share', '');
		$cid  = $app->input->post->get('cid', array(), 'array');

		if (count($cid) > 0)
		{
			$model = $this->getModel();
			$model->share($cid, $site);
			$this->setRedirect("index.php?option=com_juform&view=languages&layout=modal&tmpl=component", JText::_('COM_JUFORM_LANGUAGE_FILES_HAS_BEEN_SENT'));
		}
		else
		{
			$this->setRedirect("index.php?option=com_juform&view=languages&layout=modal&tmpl=component", JText::_('COM_JUFORM_PLEASE_SELECT_LANGUAGE_FILE'), 'error');
		}
	}

	public function getModel($name = 'Languages', $prefix = 'JUFormModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);

		return $model;
	}
}