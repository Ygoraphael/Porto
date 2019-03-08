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

class JUFormFieldCaptcha extends JUFormFieldBase
{

	public function __construct($field = null, $submission = null)
	{
		parent::__construct($field, $submission);
		$this->required = true;
	}

	public function getPreview()
	{
		if($this->params->get('captcha_type', 'securimage') == 'recaptcha')
		{
			$document = JFactory::getDocument();

			
			$document->addScript("https://www.google.com/recaptcha/api.js?hl=" . $this->params->get('recaptcha_language', 'en'));
			
			$this->setVariable('recaptchaSitekey', $this->params->get('recaptcha_sitekey', ''));
			$this->setVariable('recaptchaTheme', $this->params->get('recaptcha_theme', ''));
			$this->setVariable('recaptchaSize', $this->params->get('recaptcha_size', ''));
		}

		return $this->fetch('preview.php', __CLASS__);
	}

	public function getInput($fieldValue = null)
	{
		if (!$this->isPublished())
		{
			return "";
		}

		$app = JFactory::getApplication();
		if ($app->isAdmin())
		{
			return "";
		}

		$document = JFactory::getDocument();

		if($this->params->get('captcha_type', 'securimage') == 'recaptcha')
		{
			
			$document->addScript("https://www.google.com/recaptcha/api.js?hl=" . $this->params->get('recaptcha_language', 'en'));
			
			$this->setVariable('recaptchaSitekey', $this->params->get('recaptcha_sitekey', ''));
			$this->setVariable('recaptchaTheme', $this->params->get('recaptcha_theme', ''));
			$this->setVariable('recaptchaSize', $this->params->get('recaptcha_size', ''));

			
			$script = 'jQuery(document).ready(function($){
				setTimeout(function(){
					$("#g-recaptcha-response").rules("add", {
															  required: true,
															  messages: {
															    required: "' . $this->getValidateMessage('required') . '"
															  }
															});
					$("#g-recaptcha-response").attr("aria-describedby", "' . $this->getId() . '-error");
				}, 1000);
			});';

			$document->addScriptDeclaration($script);
		}
		else
		{
			$document->addScript(JUri::root(true) . "/components/com_juform/assets/js/captcha.js");
		}

		$this->registerTriggerForm();

		
		return $this->fetch('input.php', __CLASS__);
	}

	public function getBackendOutput()
	{
		return "";
	}

	public function getSearchInput($defaultValue = "")
	{
		return "";
	}

	protected function getValue()
	{
		return null;
	}

	public function isBackendListView()
	{
		return null;
	}

	
	public function canSubmit($userID = null)
	{
		$user = JFactory::getUser();

		if ($user->authorise('core.admin', 'com_juform'))
		{
			return false;
		}

		return parent::canSubmit($userID);
	}

	
	public function canEdit($userID = null)
	{
		$user = JFactory::getUser();

		if ($user->authorise('core.admin', 'com_juform'))
		{
			return false;
		}

		return parent::canEdit($userID);
	}

	public function PHPValidate($values)
	{
		$app = JFactory::getApplication();
		if ($app->isAdmin())
		{
			return true;
		}

		
		if (($values === "" || $values === null) && !$this->isRequired())
		{
			return true;
		}

		if($this->params->get('captcha_type', 'securimage') == 'recaptcha')
		{
			require_once __DIR__ . '/recaptcha/autoload.php';
			
			$recaptcha = new \ReCaptcha\ReCaptcha($this->params->get('recaptcha_secretkey', ''));
			$resp      = $recaptcha->verify($app->input->getString('g-recaptcha-response', ''), $_SERVER['REMOTE_ADDR']);
			$valid = $resp->isSuccess();
		}
		else
		{
			$captchaId = $app->input->getString("captcha_namespace_" . $this->id, "");
			$valid = $this->checkCaptcha($captchaId, $values);
		}

		if (!$valid)
		{
			
			$message = (string) $this->params->get('invalid_message');

			if ($message)
			{
				return JText::sprintf($message, $this->getCaption(true));
			}
			else
			{
				return JText::sprintf('COM_JUFORM_FIELD_VALUE_IS_INVALID', $this->getCaption(true));
			}
		}

		return true;
	}

	
	public function storeValue($value)
	{
		return true;
	}

	public function isPublished()
	{
		$storeId = md5(__METHOD__ . "::" . $this->id);
		if (!isset(self::$cache[$storeId]))
		{
			
			$app = JFactory::getApplication();
			if ($app->isAdmin())
			{
				self::$cache[$storeId] = false;

				return self::$cache[$storeId];
			}

			self::$cache[$storeId] = parent::isPublished();

			return self::$cache[$storeId];
		}

		return self::$cache[$storeId];
	}

	public function canView($options = array())
	{
		return false;
	}

	public function getPlaceholderValue(&$email = null)
	{
		return false;
	}

	public function getRawData()
	{
		$app       = JFactory::getApplication();
		$namespace = $app->input->getString('captcha_namespace', '');
		$this->captchaSecurityImages($namespace);
		exit;
	}


	
	protected function initCaptcha($namespace = null)
	{
		require_once JPATH_SITE . '/components/com_juform/libs/securimage.php';
		$secureImage            = new Securimage();
		$secureImage->namespace = $namespace;

		$params                                    = $this->params;
		$secureImage->image_width                  = $params->get('captcha_width', '155');
		$secureImage->image_height                 = $params->get('captcha_height', '50');
		$secureImage->font_ratio                   = null;
		$secureImage->image_type                   = $secureImage::SI_IMAGE_PNG;
		$secureImage->image_bg_color               = new Securimage_Color($params->get('captcha_bg_color', '#ffffff'));
		$secureImage->text_color                   = new Securimage_Color($params->get('captcha_color', '#050505'));
		$secureImage->line_color                   = new Securimage_Color($params->get('captcha_line_color', '#707070'));
		$secureImage->noise_color                  = new Securimage_Color($params->get('captcha_noise_color', '#707070'));
		$secureImage->use_transparent_text         = true;
		$secureImage->text_transparency_percentage = 20;
		$secureImage->code_length                  = $params->get('captcha_length', '6');
		$secureImage->case_sensitive               = false;
		$secureImage->charset                      = 'ABCDEFGHKLMNPRSTUVWYZabcdefghklmnprstuvwyz23456789';
		$secureImage->expiry_time                  = 900;
		$secureImage->session_name                 = null;
		$secureImage->perturbation                 = $params->get('captcha_perturbation', '5') / 10;
		$secureImage->num_lines                    = $params->get('captcha_num_lines', '3');
		$secureImage->noise_level                  = $params->get('captcha_noise_level', '2');
		$secureImage->image_signature              = '';
		$secureImage->signature_color              = new Securimage_Color('#707070');
		$secureImage->signature_font               = null;
		$secureImage->captcha_type                 = $secureImage::SI_CAPTCHA_STRING;
		$secureImage->ttf_file                     = 'components/com_juform/libs/captcha_fonts/' . $params->get('captcha_font', 'AHGBold.ttf');
		$secureImage->use_wordlist                 = false;
		$secureImage->wordlist_file                = null;
		$secureImage->background_directory         = null;

		return $secureImage;
	}

	
	protected function captchaSecurityImages($namespace = null)
	{
		$secureImage = $this->initCaptcha($namespace);

		JUFormHelper::obCleanData();
		$secureImage->show();
		$secureImage->getCode();
	}

	
	protected function checkCaptcha($namespace = null, $captcha = '')
	{
		if (!$namespace)
		{
			$namespace = JFactory::getApplication()->input->getString('captcha_namespace_' . $this->id, '');
		}

		if (!$captcha)
		{
			$captcha = JFactory::getApplication()->input->getString('security_code_' . $this->id, '');
		}

		if ($captcha && $namespace)
		{
			$secureImage = $this->initCaptcha($namespace);

			if ($secureImage->check($captcha))
			{
				return true;
			}
		}

		return false;
	}

	public function registerTriggerForm()
	{
		$document = JFactory::getDocument();

		$script = '
			if(typeof JUFormTrigger === "undefined"){
				var	JUFormTrigger = [];
			}

			JUFormTrigger["' . $this->getId() . '"] = function(form, type, result){
				if(type == "reset" || (type == "submit" && result.type == "success")){
					jQuery("#' . $this->getId() . '").val("");
					jQuery("#' . $this->getId() . '").closest(".jufm-captcha").find(".reload-captcha").trigger("click");
				}
			}
		';

		$document->addScriptDeclaration($script);
	}

	public function canExport()
	{
		return false;
	}
}

?>