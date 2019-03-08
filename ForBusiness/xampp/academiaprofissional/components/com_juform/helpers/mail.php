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

class JUFormFrontHelperMail
{
	
	protected static $cache = array();

	
	public static $sendMailError;

	
	public static $sendMailReportMessage;

	
	protected static function textVersion($html, $fullConvert = true)
	{
		$html = self::absoluteURL($html);

		if ($fullConvert)
		{
			$html = preg_replace('# +#', ' ', $html);
			$html = str_replace(array("\n", "\r", "\t"), '', $html);
		}

		$removepictureslinks    = "#< *a[^>]*> *< *img[^>]*> *< *\/ *a *>#isU";
		$removeScript           = "#< *script(?:(?!< */ *script *>).)*< */ *script *>#isU";
		$removeStyle            = "#< *style(?:(?!< */ *style *>).)*< */ *style *>#isU";
		$removeStrikeTags       = '#< *strike(?:(?!< */ *strike *>).)*< */ *strike *>#iU';
		$replaceByTwoReturnChar = '#< *(h1|h2)[^>]*>#Ui';
		$replaceByStars         = '#< *li[^>]*>#Ui';
		$replaceByReturnChar1   = '#< */ *(li|td|dt|tr|div|p)[^>]*> *< *(li|td|dt|tr|div|p)[^>]*>#Ui';
		$replaceByReturnChar    = '#< */? *(br|p|h1|h2|legend|h3|li|ul|dd|dt|h4|h5|h6|tr|td|div)[^>]*>#Ui';
		$replaceLinks           = '/< *a[^>]*href *= *"([^#][^"]*)"[^>]*>(.+)< *\/ *a *>/Uis';

		$text = preg_replace(array($removepictureslinks, $removeScript, $removeStyle, $removeStrikeTags, $replaceByTwoReturnChar, $replaceByStars, $replaceByReturnChar1, $replaceByReturnChar, $replaceLinks), array('', '', '', '', "\n\n", "\n* ", "\n", "\n", '${2} ( ${1} )'), $html);

		$text = preg_replace('#(&lt;|&\#60;)([^ \n\r\t])#i', '&lt; ${2}', $text);

		$text = str_replace(array(" ", "&nbsp;"), ' ', strip_tags($text));

		$text = trim(@html_entity_decode($text, ENT_QUOTES, 'UTF-8'));

		if ($fullConvert)
		{
			$text = preg_replace('# +#', ' ', $text);
			$text = preg_replace('#\n *\n\s+#', "\n\n", $text);
		}

		return $text;
	}

	protected static function absoluteURL($text)
	{
		$mailling_live = rtrim(JUri::root(), '/') . '/';

		$urls = parse_url($mailling_live);

		if (!empty($urls['path']))
		{
			$mainurl = substr($mailling_live, 0, strrpos($mailling_live, $urls['path'])) . '/';
		}
		else
		{
			$mainurl = $mailling_live;
		}

		$text = str_replace(array('href="../undefined/', 'href="../../undefined/', 'href="../../../undefined//', 'href="undefined/'), array('href="' . $mainurl, 'href="' . $mainurl, 'href="' . $mainurl, 'href="' . $mailling_live), $text);
		$text = preg_replace('#href="(/?administrator)?/({|%7B)#Uis', 'href="$2', $text);

		$replace   = array();
		$replaceBy = array();
		if ($mainurl !== $mailling_live)
		{
			$replace[]   = '#(href|src|action|background)[ ]*=[ ]*\"(?!(\{|%7B|\#|[a-z]{3,7}:|/))(?:\.\./)#i';
			$replaceBy[] = '$1="' . substr($mailling_live, 0, strrpos(rtrim($mailling_live, '/'), '/') + 1);
		}
		$replace[]   = '#(href|src|action|background)[ ]*=[ ]*\"(?!(\{|%7B|\#|[a-z]{3,7}:|/))(?:\.\./|\./)?#i';
		$replaceBy[] = '$1="' . $mailling_live;
		$replace[]   = '#(href|src|action|background)[ ]*=[ ]*\"(?!(\{|%7B|\#|[a-z]{3,7}:))/#i';
		$replaceBy[] = '$1="' . $mainurl;

		$replace[]   = '#((background-image|background)[ ]*:[ ]*url\(\'?"?(?!([a-z]{3,7}:|/|\'|"))(?:\.\./|\./)?)#i';
		$replaceBy[] = '$1' . $mailling_live;

		return preg_replace($replace, $replaceBy, $text);
	}

	protected static function changeEmailCharset($data, $input, $output)
	{
		$input  = strtoupper(trim($input));
		$output = strtoupper(trim($output));

		if ($input == $output)
		{
			return $data;
		}

		if ($input == 'UTF-8' && $output == 'ISO-8859-1')
		{
			$data = str_replace(array('€', '„', '“'), array('EUR', '"', '"'), $data);
		}

		if (function_exists('iconv'))
		{
			$encodedData = iconv($input, $output . "//IGNORE", $data);
			if (!empty($encodedData))
			{
				return $encodedData;
			}
		}

		if (function_exists('mb_convert_encoding'))
		{
			return mb_convert_encoding($data, $output, $input);
		}

		if ($input == 'UTF-8' && $output == 'ISO-8859-1')
		{
			return utf8_decode($data);
		}

		if ($input == 'ISO-8859-1' && $output == 'UTF-8')
		{
			return utf8_encode($data);
		}

		return $data;
	}

	protected static function getEmailById($emailId)
	{
		$storeId = md5(__METHOD__ . "::" . $emailId);
		if (!isset(self::$cache[$storeId]))
		{
			$db    = JFactory::getDbo();
			$query = "SELECT * FROM #__juform_emails WHERE id=" . intval($emailId);
			$db->setQuery($query);
			self::$cache[$storeId] = $db->loadObject();
		}

		return clone self::$cache[$storeId];
	}

	
	public static function replaceEmailTags(&$email, $submission)
	{
		
		$formObj = JUFormHelper::getFormById($email->form_id);
		if (!$email || !$submission || !$formObj)
		{
			return false;
		}

		
		$allowFields = array("from", "from_name", "recipients", "cc", "bcc", "reply_to", "reply_to_name", "subject", "message");

		
		foreach ($email AS $key => $value)
		{
			if (!in_array($key, $allowFields))
			{
				continue;
			}

			$email->$key = self::replaceTags($email->$key, $formObj, $submission, $email);
		}
	}

	
	public static function replaceTags($content, $formObj, $submission, $email = null)
	{
		$app = JFactory::getApplication();

		$hasPlaceHolder = 0;
		$replaceValues  = array();
		$replaceTags    = array();

		if (is_string($content))
		{
			$hasPlaceHolder = preg_match_all('/{(\w+)}/', $content, $matches);
		}

		$result = $content;

		
		if ($hasPlaceHolder)
		{
			$realTags = $matches[0];

			foreach ($realTags AS $subKey => $tag)
			{
				
				$replaceBy = false;

				switch ($tag)
				{
					
					case '{site_name}' :
						$replaceBy = $app->get('sitename');
						break;

					
					case '{admin_email}' :
						$replaceBy = $app->get('mailfrom');
						break;

					
					case '{admin_name}' :
						$replaceBy = $app->get('fromname');
						break;

					case '{ip_address}':
						$replaceBy = JUFormFrontHelper::getIpAddress();
						break;

					case '{browser}':
						require_once JPATH_SITE . '/components/com_juform/libs/browser.php';
						$browser    = new Browser();
						$_browser   = array();
						$_browser[] = $browser->getBrowser();
						$_browser[] = $browser->getVersion();

						$replaceBy = implode(" ", $_browser);
						break;

					case '{platform}':
						require_once JPATH_SITE . '/components/com_juform/libs/browser.php';
						$browser    = new Browser();
						$user_agent = $browser->getUserAgent();

						$replaceBy = JUFormFrontHelper::getPlatform($user_agent);
						break;

					
					case '{user_email}' :
						$user      = JFactory::getUser();
						$replaceBy = $user->email;
						break;

					
					case '{user_name}' :
						$user      = JFactory::getUser();
						$replaceBy = $user->name;

						if (!$replaceBy)
						{
							$replaceBy = JText::_('COM_JUFORM_GUEST');
						}
						break;

					
					case '{user_username}' :
						$user      = JFactory::getUser();
						$replaceBy = $user->username;

						if (!$replaceBy)
						{
							$replaceBy = JText::_('COM_JUFORM_GUEST');
						}
						break;

					case '{form_title}' :
						$replaceBy = $formObj->title;
						break;

					case '{form_link}' :
						$replaceBy = JUFormHelper::emailLinkRouter(JUFormHelperRoute::getFormRoute($formObj->id), false, -1);
						break;

					default :
						$fieldName = $matches[1][$subKey];
						$fieldObj  = JUFormFrontHelperField::getFieldByFieldName($fieldName, $formObj->id);
						$field     = JUFormFrontHelperField::getField($fieldObj, $submission);
						if ($field)
						{
							$replaceBy = $field->getPlaceholderValue($email);
						}
				}

				
				if ($replaceBy !== false)
				{
					$replaceTags[]   = $tag;
					$replaceValues[] = (string) $replaceBy;
				}
			}

			if ($replaceValues)
			{
				$result = str_replace($replaceTags, $replaceValues, $content);
			}
		}

		return $result;
	}

	public static function prepareSend(&$email)
	{
		$email->recipients    = $email->recipients ? array_filter(array_map('trim', array_unique(explode(',', $email->recipients)))) : array();
		$email->cc            = $email->cc ? array_filter(array_map('trim', array_unique(explode(',', $email->cc)))) : array();
		$email->bcc           = $email->bcc ? array_filter(array_map('trim', array_unique(explode(',', $email->bcc)))) : array();
		$email->reply_to      = $email->reply_to ? array_filter(array_map('trim', array_unique(explode(',', $email->reply_to)))) : array();
		$email->reply_to_name = $email->reply_to_name ? array_filter(array_map('trim', array_unique(explode(',', $email->reply_to_name)))) : array();

		if (is_array($email->attachments) && count($email->attachments))
		{
			$params = JComponentHelper::getParams('com_juform');

			
			if ($params->get('email_attachment_mode', 'link') == 'link')
			{
				$attachStringHTML = '<br/><fieldset><legend>' . JText::_('COM_JUFORM_ATTACHMENTS') . '</legend><table><tbody>';
				$attachStringText = "\n\n" . '------- ' . JText::_('COM_JUFORM_ATTACHMENTS') . ' -------';
				foreach ($email->attachments AS $attachment)
				{
					$attachStringHTML .= '<tr><td><a href="' . $attachment->url . '" target="_blank">' . $attachment->file_name . '</a></td></tr>';
					$attachStringText .= "\n" . '-- ' . $attachment->file_name . ' ( ' . $attachment->url . ' )';
				}
				$attachStringHTML .= '</tbody></table></fieldset>';

				
				$email->attachments = null;

				if ($email->mode == 0)
				{
					$email->message .= $attachStringText;
				}
				else
				{
					$email->message .= $attachStringHTML;
				}
			}
		}

		if ($email->mode == 0)
		{
			$email->message = self::textVersion($email->message, false);
			$email->message = str_replace(" ", ' ', $email->message);
		}
		else
		{
			if (function_exists('mb_convert_encoding'))
			{
				$email->message = mb_convert_encoding($email->message, 'HTML-ENTITIES', 'UTF-8');
				$email->message = str_replace(array('&amp;', '&sigmaf;'), array('&', 'ς'), $email->message);
			}
			$email->message = self::absoluteURL($email->message);
			$email->message = str_replace(" ", ' ', $email->message);
		}

		$email->subject = str_replace(array('’', '“', '”', '–'), array("'", '"', '"', '-'), $email->subject);

		$params  = JComponentHelper::getParams('com_juform');
		$charset = $params->get('email_charset', 'UTF-8');
		if ($charset != 'UTF-8')
		{
			$email->message = self::changeEmailCharset($email->message, 'UTF-8', $charset);
			$email->subject = self::changeEmailCharset($email->subject, 'UTF-8', $charset);
		}
	}

	
	protected static function check($email)
	{
		
		
		self::$sendMailError         = 0;
		self::$sendMailReportMessage = '';

		if (!$email)
		{
			self::$sendMailError         = 2;
			self::$sendMailReportMessage = JText::_('COM_JUFORM_CAN_NOT_LOAD_EMAIL');

			return false;
		}

		if ((count($email->recipients) + count($email->cc) + count($email->bcc)) < 1)
		{
			self::$sendMailError         = 4;
			self::$sendMailReportMessage = JText::_('COM_JUFORM_ERROR_RECIPIENTS_EMPTY');

			return false;
		}

		
		$emailPattern = '/^[\w\.-]+@[\w\.-]+\.[\w\.-]+$/';

		if (!preg_match($emailPattern, $email->from))
		{
			self::$sendMailError         = 5;
			self::$sendMailReportMessage = JText::_('COM_JUFORM_ERROR_INVALID_FROM_EMAIL');

			return false;
		}

		$recipients = array_filter(array_unique(array_merge($email->recipients, $email->cc, $email->bcc)));

		foreach ($recipients AS $recipient)
		{
			if (!preg_match($emailPattern, $recipient))
			{
				self::$sendMailError         = 5;
				self::$sendMailReportMessage = JText::_('COM_JUFORM_ERROR_INVALID_RECIPIENTS_EMAIL');

				return false;
			}
		}

		if (isset($email->reply_to) && $email->reply_to)
		{
			foreach ($email->reply_to AS $reply)
			{
				if (!preg_match($emailPattern, $reply))
				{
					self::$sendMailError         = 5;
					self::$sendMailReportMessage = JText::_('COM_JUFORM_ERROR_INVALID_REPLY_EMAIL');

					return false;
				}
			}
		}

		
		if (empty($email->message))
		{
			self::$sendMailError         = 6;
			self::$sendMailReportMessage = JText::_('COM_JUFORM_ERROR_EMAIL_BODY_EMPTY');

			return false;
		}

		return true;
	}

	
	protected static function send($email)
	{
		
		$mail = JFactory::getMailer();

		
		$mail->setSender(array($email->from, $email->from_name));

		
		if ($email->attachments)
		{
			foreach ($email->attachments AS $attachment)
			{
				$mail->addAttachment($attachment->file_path, $attachment->file_name);
			}
		}

		
		$mail->setSubject($email->subject);
		$mail->addRecipient($email->recipients);
		if ($email->cc)
		{
			$mail->addCC($email->cc);
		}

		if ($email->bcc)
		{
			$mail->addBCC($email->bcc);
		}

		$mail->clearReplyTos();
		if($email->reply_to)
		{
			foreach ($email->reply_to AS $i => $email_reply_to)
			{
				$mail->addReplyTo($email_reply_to, isset($email->reply_to_name[$i]) ? $email->reply_to_name[$i] : '');
			}
		}

		if ($email->mode == 1)
		{
			$mail->isHtml(true);
		}
		$mail->setBody($email->message);

		$mail->send();
	}

	
	protected static function checkEmailCondition($email, $submission)
	{
		$condition         = $email->send_mail_condition;
		$email_conditions  = JUFormFrontHelper::getEmailConditions($email->id);
		$passed_conditions = 0;

		foreach ($email_conditions AS $email_condition)
		{
			$field = JUFormFrontHelperField::getField($email_condition->field_id, $submission);

			
			if (($email_condition->operator == '==' && ((!is_array($field->value) && $email_condition->value == $field->value) || (is_array($field->value) && in_array($email_condition->value, $field->value)))) ||
				($email_condition->operator == '!=' && ((!is_array($field->value) && $email_condition->value != $field->value) || (!is_array($field->value) && in_array($email_condition->value, $field->value))))
			)
			{
				
				if ($condition == '||')
				{
					return true;
				}

				$passed_conditions++;
			}
			
			elseif ($condition == '&&')
			{
				return false;
			}
		}

		
		if (count($email_conditions) && !$passed_conditions)
		{
			return false;
		}

		
		return true;
	}

	
	public static function sendEmail($submission)
	{
		if (!$submission)
		{
			return false;
		}

		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('*')
			->from('#__juform_emails')
			->where('form_id = ' . $submission->form_id)
			->where('published = 1');

		
		$app         = JFactory::getApplication();
		$languageTag = JFactory::getLanguage()->getTag();
		if ($app->getLanguageFilter())
		{
			$query->where("language IN (" . $db->quote($languageTag) . "," . $db->quote('*') . "," . $db->quote('') . ")");
		}

		$query->order('ordering ASC');

		$db->setQuery($query);
		$emails = $db->loadObjectList();
		if ($emails)
		{
			$form = JUFormHelper::getFormById($submission->form_id);

			foreach ($emails AS $email)
			{
				
				if (!self::checkEmailCondition($email, $submission))
				{
					continue;
				}

				if (trim($form->php_onsendemail))
				{
					eval($form->php_onsendemail);
				}

				
				if(is_string($email->attachments))
				{
					$email->attachments = json_decode($email->attachments);
				}

				if (is_array($email->attachments) && count($email->attachments))
				{
					foreach ($email->attachments AS $i => $attachment)
					{
						$code                              = md5($email->id . $app->get('secret'));
						$email->attachments[$i]            = new stdClass();
						$email->attachments[$i]->file_name = $attachment->name;
						$email->attachments[$i]->file_path = JPATH_SITE . "/media/com_juform/email_attachments/" . $email->id . "/" . $attachment->target;
						$email->attachments[$i]->url       = JUFormHelper::emailLinkRouter('index.php?option=com_juform&task=email.downloadattachment&mail_id=' . $email->id . '&file_id=' . $attachment->id . '&code=' . $code, false, -1);
					}
				}

				self::replaceEmailTags($email, $submission);
				self::prepareSend($email);
				
				self::send($email);
			}
		}
	}
}
