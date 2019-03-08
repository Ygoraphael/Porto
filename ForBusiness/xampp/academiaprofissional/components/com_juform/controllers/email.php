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

class JUFormControllerEmail extends JControllerForm
{
	public function downloadAttachment()
	{
		$app   = JFactory::getApplication();
		$input = $app->input;

		
		$mailId = $input->getInt('mail_id', 0);
		$fileId = $input->getString('file_id', '');
		$code   = $input->getString('code', '');

		if ($mailId == 0 || empty($fileId))
		{
			return false;
		}

		$secretKey = md5($mailId . JFactory::getApplication()->get('secret'));

		if ($secretKey != $code)
		{
			return false;
		}

		$attachDir = JPATH_ROOT . "/media/com_juform/email_attachments/" . $mailId . "/";

		$email = JUFormFrontHelper::getEmail($mailId);
		if (!$email || !$email->attachments)
		{
			return false;
		}

		$attachments = json_decode($email->attachments);
		$filePath    = $fileName = '';
		foreach ($attachments AS $attachment)
		{
			if ($attachment->id === $fileId)
			{
				$filePath = $attachDir . $attachment->target;
				$fileName = $attachment->name;
				break;
			}
		}

		if (!JFile::exists($filePath))
		{
			return false;
		}

		JUFormHelper::downloadFile($filePath, $fileName, 500);

		return true;
	}
}