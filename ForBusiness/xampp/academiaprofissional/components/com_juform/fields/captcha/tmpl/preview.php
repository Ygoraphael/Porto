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

if($this->params->get('captcha_type', 'securimage') == 'recaptcha')
{ ?>
	<div class="g-recaptcha" data-sitekey="<?php echo $recaptchaSitekey; ?>" data-theme="<?php echo $recaptchaTheme; ?>" data-size="<?php echo $recaptchaSize; ?>"></div>
	<?php
}
else
{
	$captchaNameSpaceValue = md5(time());
	?>
	<div class="jufm-captcha pull-left">
		<div class="clearfix" style="margin-bottom: 5px">
			<img class="captcha-image" alt="<?php echo JText::_('COM_JUFORM_CAPTCHA'); ?>"
			     src="<?php echo JUri::root(true) . '/index.php?option=com_juform&task=rawdata&field_id=' . $this->id . '&captcha_namespace=' . $captchaNameSpaceValue . '&tmpl=component'; ?>"
			     width="<?php echo $this->params->get('captcha_width', '155'); ?>px"
			     height="<?php echo $this->params->get('captcha_height', '40') ?>px"/>
			<input type="hidden" class="captcha-namespace" name="captcha_namespace_<?php echo $this->id; ?>"
			       value="<?php echo $captchaNameSpaceValue; ?>"/>
		</div>
		<div class="input-append">
			<input type="text" id="<?php echo $this->getId(); ?>" name="<?php echo $this->getName(); ?>"
			       class="security_code input-medium" <?php echo $this->getValidateData(); ?> autocomplete="off"/>
			<span class="add-on btn reload-captcha" title="<?php echo JText::_('COM_JUFORM_RELOAD_CAPTCHA'); ?>"><i
					class="icon-refresh"></i></span>
		</div>
	</div>
	<?php
} ?>