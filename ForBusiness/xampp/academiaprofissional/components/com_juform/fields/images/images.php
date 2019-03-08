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

class JUFormFieldImages extends JUFormFieldBase
{
	public function parseValue($value)
	{
		if (!$this->isPublished())
		{
			return null;
		}

		if ($value)
		{
			return json_decode($value);
		}

		return $value;
	}

	public function getPredefinedValuesHtml()
	{
		return '<span class="readonly">' . JText::_('COM_JUFORM_NOT_SET') . '</span>';
	}

	public function getPreview()
	{
		return $this->fetch('preview.php', __CLASS__);
	}

	protected function loadInputAssets()
	{
		$document = JFactory::getDocument();

		$document->addStyleSheet(JUri::root() . 'components/com_juform/assets/plupload/css/jquery.plupload.queue.css');
		$document->addScript(JUri::root() . "components/com_juform/assets/plupload/js/plupload.full.min.js");
		$document->addScript(JUri::root() . "components/com_juform/assets/plupload/js/jquery.plupload.queue.min.js");

		$document->addScript(JUri::root(true) . '/components/com_juform/assets/js/jquery.dragsort.min.js');
		$document->addScript(JUri::root(true) . '/components/com_juform/assets/js/handlebars.min.js');

		$document->addScript(JUri::root(true) . '/components/com_juform/fields/images/assets/js/images.js');
		$document->addStyleSheet(JUri::root(true) . '/components/com_juform/fields/images/assets/css/input.css');

		$maxSize     = $this->params->get("max_size", 2048) * 1024;
		$postMaxSize = JUFormHelper::getPostMaxSize();
		
		if ($maxSize < $postMaxSize)
		{
			$runtimes = 'html5,flash,silverlight,html4';
		}
		else
		{
			$runtimes = 'html5,silverlight,html4';
		}

		$chunkSize = $postMaxSize - 4000;

		$maxFiles = $this->params->get("max_files", 5);

		$extensions = $this->params->get("extensions", "jpg,gif,png,bmp");
		$extensions = str_replace("\n", ",", trim($extensions));
		$mimetypes  = "";
		$time       = time();
		$secret     = JFactory::getConfig()->get('secret');
		$code       = md5($time . $secret);
		$document   = JFactory::getDocument();

		JText::script('COM_JUFORM_CAN_NOT_UPLOAD_FILE_BECAUSE_IT_IS_EMPTY');
		JText::script('COM_JUFORM_CAN_NOT_UPLOAD_THIS_FILE_BECAUSE_FILE_SIZE_EXCEED_MAX_FILE_SIZE_X');
		JText::script('COM_JUFORM_FILE_EXTENSION_IS_NOT_ALLOWED');
		JText::script('COM_JUFORM_CAN_NOT_UPLOAD_THIS_FILE_PLEASE_RECHECK_MIMETYPE_FILE');
		JText::script('COM_JUFORM_CAN_NOT_RESTORE_THIS_FILE_TOTAL_FILES_REACH_MAX_N_FILES');
		JText::script('COM_JUFORM_TOTAL_FILES_REACH_MAX_UPLOAD_N_FILES');
		JText::script('COM_JUFORM_CAN_NOT_UPLOAD_THIS_FILE_TOTAL_FILES_REACH_MAX_UPLOAD_N_FILES');
		JText::script('COM_JUFORM_UPLOADED');

		$app    = JFactory::getApplication();
		$script = 'jQuery(document).ready(function($){
						$("#' . $this->getId() . '_wrap").efimages({
								id     : ' . (int) $this->id . ',
								fieldId: "' . $this->getId() . '",
								newFileTemplateId: "#newfile-template-' . $this->getId() . '",

								juriRoot                : "' . JUri::root() . '",
								runTimes                : "' . $runtimes . '",
								chunkSize               : "' . $chunkSize . '",
								maxFileSize             : ' . $maxSize . ',
								maxFiles                : ' . $maxFiles . ',
								extensions              : "' . $extensions . '",
								mimeTypes              : "' . $mimetypes . '",
								time                    : ' . $time . ',
								code                    : "' . $code . '",
								isSite                  : ' . (int) $app->isSite() . ',
								isRequired              : ' . (int) $this->isRequired() . ',
								autoUpload              : ' . $this->params->get('auto_upload', 0) . '
							});
					});';
		$document->addScriptDeclaration($script);

		$script = "jQuery(document).ready(function($){
					$(\"#" . $this->getId() . "_wrap > ul\").dragsort({ dragSelector: \"li\", placeHolderTemplate: \"<li class='placeHolder'></li>\", dragSelectorExclude: \"input,textarea,.file-remove-btn, .file-publish-btn\" });
				});";
		$document->addScriptDeclaration($script);
	}

	public function getInput($fieldValue = null)
	{
		if (!$this->isPublished())
		{
			return "";
		}

		$this->loadInputAssets();

		$dbFiles = array();
		if ($this->value)
		{
			foreach ($this->value AS $file)
			{
				$dbFiles[] = (array) $file;
			}
		}

		$files = !is_null($fieldValue) ? $fieldValue : !is_null($this->value_input_default) ? $this->value_input_default : $dbFiles;

		$this->setVariable('files', $files);

		return $this->fetch('input.php', __CLASS__);
	}

	protected function loadOutputAssets()
	{
		$document = JFactory::getDocument();
		$document->addStyleSheet(JUri::root(true) . '/components/com_juform/fields/images/assets/css/output.css');
		$this->loadFancyBoxAssets();
	}

	protected function loadFancyBoxAssets()
	{
		
		$storeId = md5(__METHOD__);

		if (!isset(self::$cache[$storeId]))
		{
			$document = JFactory::getDocument();
			$document->addStyleSheet(JUri::root(true) . "/components/com_juform/assets/fancybox/css/jquery.fancybox.css");
			$document->addStyleSheet(JUri::root(true) . "/components/com_juform/assets/fancybox/css/jquery.fancybox-thumbs.css");
			$document->addStyleSheet(JUri::root(true) . "/components/com_juform/assets/fancybox/css/jquery.fancybox-buttons.css");

			$document->addScript(JUri::root(true) . "/components/com_juform/assets/fancybox/js/jquery.mousewheel-3.0.6.pack.js");
			$document->addScript(JUri::root(true) . "/components/com_juform/assets/fancybox/js/jquery.fancybox.pack.js");
			$document->addScript(JUri::root(true) . "/components/com_juform/assets/fancybox/js/jquery.fancybox-thumbs.js");
			$document->addScript(JUri::root(true) . "/components/com_juform/assets/fancybox/js/jquery.fancybox-buttons.js");
			$document->addScript(JUri::root(true) . "/components/com_juform/assets/fancybox/js/jquery.fancybox-media.js");

			$script = "
				jQuery(document).ready(function ($) {
					$('.field-images .item-image').fancybox({
						openEffect  : 'fade',
						closeEffect : 'fade',
						prevEffect : 'fade',
						nextEffect : 'fade',
						helpers : {
							title : {
								type : 'inside'
							},
							buttons	: {
							}
						}
					});
				});";

			$document->addScriptDeclaration($script);

			self::$cache[$storeId] = true;

			return self::$cache[$storeId];
		}

		return self::$cache[$storeId];
	}

	public function getOutput($options = array())
	{
		if (!$this->isPublished())
		{
			return "";
		}

		if (!$this->value)
		{
			return "";
		}

		if ($this->value)
		{
			$this->loadOutputAssets();

			if (!class_exists('jutimthumb'))
			{
				require_once JPATH_ADMINISTRATOR . "/components/com_juform/timthumb/timthumb.php";
			}

			$attach_dir = JUri::root(true) . "/media/com_juform/field_attachments/images/" . $this->id . "_" . $this->submission_id . "/";

			$this->setVariable('attach_dir', $attach_dir);
			$this->setVariable('images', $this->value);

			return $this->fetch('output.php', __CLASS__);
		}

		return '';
	}

	
	protected function renderImages($image, $output = 'timthumb_cache', $output_url = true)
	{
		
		if (preg_match('/^https?:\/\/[^\/]+/i', $image))
		{
			$image = str_replace(JUri::root(), '', $image);
		}

		$timthumb_params        = array();
		$timthumb_params['src'] = $image;
		$timthumb_params['w']   = $this->params->get('width', 60);
		$timthumb_params['h']   = $this->params->get('height', 60);
		$timthumb_params['a']   = $this->params->get('alignment', 'c');
		$timthumb_params['zc']  = $this->params->get('zoomcrop', '1');
		$timthumb_params['q']   = $this->params->get('imagequality', 90);
		if ($this->params->get('customfilters', '') != '')
		{
			$timthumb_params['f'] = $this->params->get('customfilters', '');
		}
		else
		{
			$filters = $this->params->get('imagefilters');
			if (!empty($filters))
			{
				$filters              = implode("|", $filters);
				$timthumb_params['f'] = $filters;
			}
		}
		$timthumb_params['s']      = $this->params->get('sharpen', '0');
		$timthumb_params['cc']     = trim($this->params->get('canvascolour', 'FFFFFF'), '#');
		$timthumb_params['ct']     = $this->params->get('canvastransparency', '1');
		$timthumb_params['output'] = $output;

		$tim    = new jutimthumb($timthumb_params);
		$output = $tim->start();
		if ($output_url)
		{
			$output = str_replace(JPATH_SITE, substr(JUri::root(), 0, -1), $output);
		}

		return $output;
	}

	public function getRawData()
	{
		$app      = JFactory::getApplication();
		$function = $app->input->get("function", "");
		if ($function !== "")
		{
			if ($function == "uploader")
			{
				
				

				if (!JUFormHelper::isValidUploadURL())
				{
					die(json_encode(array(
						'OK'    => 0,
						'error' => array(
							'code'    => -1,
							'message' => JText::_('COM_JUFORM_YOU_ARE_NOT_AUTHORIZED_TO_UPLOAD_FILE')
						)
					)));
				}

				JUFormHelper::obCleanData();

				$targetDir = JPATH_ROOT . "/media/com_juform/tmp_img";
				JUFormHelper::uploader($targetDir, array(__CLASS__, 'canUpload'));
			}
		}

		return false;
	}

	public function filterField($values)
	{
		if ($values)
		{
			$values         = array_values($values);
			$attach_dir_tmp = JPATH_ROOT . "/media/com_juform/tmp_img/";

			$dbFiles = array();
			if ($this->value)
			{
				foreach ($this->value AS $file)
				{
					$dbFiles[$file->id] = $file;
				}
			}

			$error         = array();
			$maxSize       = $this->params->get("max_size", 2048) * 1024;
			$extensions    = $this->params->get("extensions", "jpg,gif,png,bmp");
			$checkMimetype = $this->params->get("check_mimetype", 0);
			$mimeTypes     = "";

			foreach ($values AS $key => $file)
			{
				if (isset($file['target']) && $file['target'])
				{
					$newFile              = array();
					$newFile['name']      = $file['name'];
					$newFile['tmp_name']  = $attach_dir_tmp . $file['target'];
					$newFile['size']      = $file['size'];
					$newFile['mime_type'] = $file['type'];
					if (!JUFormFrontHelper::canUpload($newFile, $error, $extensions, $maxSize, $checkMimetype, $mimeTypes, '', $extensions))
					{
						unset($values[$key]);
						continue;
					}
					$values[$key]['type'] = $newFile['mime_type'];
				}
				elseif (isset($dbFiles[$file['id']]))
				{
					$dbFiles[$file['id']]->title       = $values[$key]['title'];
					$dbFiles[$file['id']]->description = $values[$key]['description'];
					$dbFiles[$file['id']]->remove      = (int) $values[$key]['remove'];
					$dbFiles[$file['id']]->published   = (int) $values[$key]['published'];
					$values[$key]                      = (array) $dbFiles[$file['id']];
				}
				else
				{
					unset($values[$key]);
				}
			}

			if ($error)
			{
				$app = JFactory::getApplication();
				foreach ($error AS $key => $count)
				{
					switch ($key)
					{
						case 'WARN_SOURCE':
						case 'WARN_FILENAME':
						case 'WARN_FILETYPE':
						case 'WARN_FILETOOLARGE' :
						case 'WARN_INVALID_IMG' :
						case 'WARN_INVALID_MIME' :
						case 'WARN_IEXSS' :
							$error_str = JText::plural("COM_JUFORM_N_FILE_" . $key, $count);
							break;
					}

					$app->enqueueMessage($error_str, 'notice');
				}
			}
		}

		return $values;
	}

	public function PHPValidate($values)
	{
		
		if (!$values && $this->isRequired())
		{
			return JText::_('COM_JUFORM_YOU_HAVE_TO_UPLOAD_AT_LEAST_ONE_FILE');
		}


		$maxFiles = $this->params->get('max_files', 0);
		if ($maxFiles > 0 && count($values) > $maxFiles)
		{
			$totalFile = 0;
			foreach ($values AS $file)
			{
				if (!$file['remove'])
				{
					$totalFile++;
				}
			}

			if ($totalFile > $maxFiles)
			{
				
				return JText::_('You can only upload maxfile is ' . $maxFiles);
			}
		}

		return true;
	}

	
	public function onSaveSubmission($value = array())
	{
		$attach_dir     = JPATH_ROOT . "/media/com_juform/field_attachments/images/" . $this->id . "_" . $this->submission_id . "/";
		$attach_dir_tmp = JPATH_ROOT . "/media/com_juform/tmp_img/";
		if ($value)
		{
			if (!JFolder::exists($attach_dir))
			{
				JFolder::create($attach_dir);
				$file_index = $attach_dir . 'index.html';
				$buffer     = "<!DOCTYPE html><title></title>";
				JFile::write($file_index, $buffer);
			}

			foreach ($value AS $key => $file)
			{
				$isNewFile = isset($file['is_new']);
				unset($value[$key]['is_new']);

				if ($isNewFile)
				{
					$targetFile = JFile::makeSafe($file['target']);
					if ($file['remove'])
					{
						if (JFile::exists($attach_dir_tmp . $targetFile))
						{
							JFile::delete($attach_dir_tmp . $targetFile);
						}
						unset($value[$key]);
					}
					else
					{
						$file['name'] = JUFormHelper::fileNameFilter($file['name']);
						$dest         = $attach_dir . $file['name'];
						while (JFile::exists($dest))
						{
							$file['name'] = JUFormHelper::generateRandomString(3) . '_' . $file['name'];
							$dest         = $attach_dir . $file['name'];
						}

						if (JFile::move($attach_dir_tmp . $targetFile, $dest))
						{
							$value[$key] = array(
								'id'          => JUFormHelper::generateRandomString(8),
								'name'        => $file['name'],
								'title'       => $file['title'],
								'description' => $file['description'],
								'published'   => $file['published'],
								'size'        => $file['size'],
								'type'        => $file['type'],
							);
						}
						else
						{
							unset($value[$key]);
						}
					}
				}
				else
				{
					if ($file['remove'])
					{
						if (JFile::exists($attach_dir . $file['name']))
						{
							JFile::delete($attach_dir . $file['name']);
						}
						unset($value[$key]);
					}
				}
			}
		}

		if ($value)
		{
			$value = array_values($value);
			$value = json_encode($value);
		}
		else
		{
			$value = "";
		}

		return $value;
	}


	public function deleteExtraData($submissionId = null)
	{
		$attach_dir = JPATH_ROOT . "/media/com_juform/field_attachments/";
		$attach_dir = $attach_dir . "images/" . $this->id . "_" . $submissionId . "/";
		if (JFolder::exists($attach_dir))
		{
			JFolder::delete($attach_dir);
		}

		return true;
	}

	public function copyExtraData($toSubmissionId)
	{
		$attach_dir     = JPATH_ROOT . "/media/com_juform/field_attachments/";
		$attach_ori_dir = JPath::clean($attach_dir . "images/" . $this->id . "_" . $this->submission_id . "/");
		$attach_new_dir = JPath::clean($attach_dir . "images/" . $this->id . "_" . $toSubmissionId . "/");
		if (JFolder::exists($attach_ori_dir))
		{
			JFolder::copy($attach_ori_dir, $attach_new_dir);
		}

		return true;
	}

	public function getSearchInput($defaultValue = "")
	{
		if (!$this->isPublished())
		{
			return "";
		}

		$options   = array();
		$options[] = array("text" => JText::_('COM_JUFORM_ANY'), "value" => "");
		$options[] = array("text" => JText::_('JYES'), "value" => 1);
		$options[] = array("text" => JText::_('JNO'), "value" => 0);

		$this->setVariable('value', $defaultValue);
		$this->setVariable('options', $options);

		return $this->fetch('searchinput.php', __CLASS__);
	}

	public function onSearch(&$query, &$where, $search, $forceModifyQuery = false)
	{
		if ($search !== "")
		{
			
			$storeId = md5(__METHOD__ . "::" . $this->id);
			if (!isset(self::$cache[$storeId]) || $forceModifyQuery)
			{
				$query->join('LEFT', '#__juform_fields_values AS field_values_' . $this->id . ' ON (listing.id = field_values_' . $this->id . '.submission_id AND field_values_' . $this->id . '.field_id = ' . $this->id . ')');

				self::$cache[$storeId] = true;
			}

			if ($search == 1)
			{
				$where[] = $this->fieldvalue_column . " != ''";
			}
			else
			{
				$where[] = "(" . $this->fieldvalue_column . " = '' OR " . $this->fieldvalue_column . " IS NULL)";
			}
		}
	}

	public function onSimpleSearch(&$query, &$where, $search, $forceModifyQuery = false)
	{
		return true;
	}

	protected function loadBackendOutputAssets()
	{
		$document = JFactory::getDocument();
		$document->addStyleSheet(JUri::root(true) . '/components/com_juform/fields/files/assets/css/backendoutput.css');
	}

	public function getBackendOutput()
	{
		if (!$this->isPublished())
		{
			return "";
		}

		$this->loadBackendOutputAssets();

		$this->setVariable('files', $this->value);

		return $this->fetch('backendoutput.php', __CLASS__);
	}

	protected function formatBytes($a_bytes)
	{
		if ($a_bytes < 1024)
		{
			return $a_bytes . ' B';
		}
		else if ($a_bytes < 1048576)
		{
			return round($a_bytes / 1024 * 100) / 100 . ' KB';
		}
		else if ($a_bytes < 1073741824)
		{
			return round($a_bytes / 1048576 * 100) / 100 . ' MB';
		}
		else if ($a_bytes < 1099511627776)
		{
			return round($a_bytes / 1073741824 * 100) / 100 . ' GB';
		}
		else if ($a_bytes < 1125899906842624)
		{
			return round($a_bytes / 1099511627776 * 100) / 100 . ' TB';
		}
		else if ($a_bytes < 1152921504606846976)
		{
			return round($a_bytes / 1125899906842624 * 100) / 100 . ' PB';
		}
		else if ($a_bytes < 1180591620717411303424)
		{
			return round($a_bytes / 1152921504606846976 * 100) / 100 . ' EB';
		}
		else if ($a_bytes < 1208925819614629174706176)
		{
			return round($a_bytes / 1180591620717411303424 * 100) / 100 . ' ZB';
		}
		else
		{
			return round($a_bytes / 1208925819614629174706176 * 100) / 100 . ' YB';
		}
	}

	public function getValidateData()
	{
		$validateData = array();

		if ($this->isRequired())
		{
			$validateData[] = 'data-rule-requiredFile="true"';

			$message = $this->getValidateMessage();
			if ($message)
			{
				$validateData[] = 'data-msg-requiredFile="' . $message . '"';
			}
		}

		$validateData[] = 'data-rule-finishUpload="true"';

		if ($this->params->get('auto_upload'))
		{
			$validateData[] = 'data-msg-finishUpload="' . JText::_('COM_JUFORM_FILE_IS_UPLOADING_PLEASE_WAIT') . '"';
		}
		else
		{
			$validateData[] = 'data-msg-finishUpload="' . JText::_('COM_JUFORM_PLEASE_UPLOAD_FILE') . '"';
		}

		$validateData[] = 'aria-describedby="' . $this->getId() . '-error"';

		return implode(' ', $validateData);
	}

	public function getValidateMessage($type = 'required')
	{
		if ($type == 'maxFiles')
		{
			$message = (string) $this->params->get('invalid_message');

			if ($message)
			{
				$message = JText::sprintf($message, $this->getCaption(true));
			}
			else
			{
				$message = JText::sprintf('COM_JUFORM_FIELD_REACH_MAX_UPLOAD_FILE', $this->getCaption(true));
			}
			$message = htmlspecialchars($message, ENT_COMPAT, 'UTF-8');
		}
		else
		{
			$message = parent::getValidateMessage($type);
		}

		return $message;
	}

	public function registerTriggerForm()
	{
		$document = JFactory::getDocument();

		$script = '
			if(typeof juCommentFomTrigger === "undefined"){
				var	juCommentFomTrigger = [];
			}

			juCommentFomTrigger["' . $this->getId() . '"] = function(form, type, result){
				if(type == "reset" || (type == "submit" && result.type == "success")){
					jQuery("#' . $this->getId() . '").closest(".field-images").find(".file-list").empty();
				}
			}
		';

		$document->addScriptDeclaration($script);
	}

	public function getPlaceholderValue(&$email = null)
	{
		$files = $this->value;
		if ($files)
		{
			$attach_dir = JUri::root(true) . "/media/com_juform/field_attachments/images/" . $this->id . "_" . $this->submission_id . "/";
			$return     = array();
			foreach ($files AS $file)
			{
				$originalImage = $attach_dir . $file->name;
				$resizedImage  = $this->renderImages($originalImage);
				$return[]      = '<a href="' . $originalImage . '" target="_blank" title="' . htmlspecialchars($file->description, ENT_QUOTES) . '">
										<img src="' . $resizedImage . '" alt="' . htmlspecialchars($file->title, ENT_QUOTES) . '" />
									</a>';
			}

			return implode('', $return);
		}

		return '';
	}
}

?>