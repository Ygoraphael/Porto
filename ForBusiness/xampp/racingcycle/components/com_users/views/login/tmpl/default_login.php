<?php
/**
 * @package		Joomla.Site
 * @subpackage	com_users
 * @copyright	Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @since		1.5
 */

defined('_JEXEC') or die;
JHtml::_('behavior.keepalive');

$lang = JFactory::getLanguage();
?>
<fieldset class="col2-set login-page">  
	<div class="col-1 new-users"> 
		<strong style="font-size:13px; font-weight:bold;">
		<?php
		if($lang->getTag()=='pt-PT')
		{
			echo "NOVOS CLIENTES";
		}
		if($lang->getTag()=='en-GB')
		{
			echo "NEW CUSTOMERS";
		}
		?>
		</strong>    
		<div class="content">
			<?php
				if($lang->getTag()=='pt-PT')
				{
				?>
				<p>Os nossos produtos são vendidos apenas para distribuidores registados. Terá de criar uma conta para aceder aos nossos produtos.</p><br>
				<p><b>Nota:</b> O seu registo será ativado durante o nosso horário de funcionamento. Iremos informá-lo assim que o registo foi ativado.</p>
				<?php
				}
				if($lang->getTag()=='en-GB')
				{
				?>
				<p>Our products are sold to registered dealers only. You have to create an account to access our products.</p><br>
				<p><b>Note:</b> Your registration will be activated during our opening hours. We will inform you as soon as the registration has been activated.</p>
				<?php
				}
			?>
			<div class="buttons-set">
				<button type="button" title="Create an Account" class="button create-account" onclick="window.location='<?php 
					if($lang->getTag()=='pt-PT')
					{
						echo "registo";
					} 
					if($lang->getTag()=='en-GB')
					{
						echo "registration";
					}?>';">
					<span>
						<span>
						<?php
						if($lang->getTag()=='pt-PT')
						{
							echo "Criar uma Conta";
						}
						if($lang->getTag()=='en-GB')
						{
							echo "Create an Account";
						}
						?>
						</span>
					</span>
				</button>
			</div>
		</div>
	</div>
	<div class="col-2 registered-users">
		<div class="login<?php echo $this->pageclass_sfx?>">
			<?php if ($this->params->get('show_page_heading')) : ?>
			<h1>
				<?php echo $this->escape($this->params->get('page_heading')); ?>
			</h1>
			<?php endif; ?>

			<?php if (($this->params->get('logindescription_show') == 1 && str_replace(' ', '', $this->params->get('login_description')) != '') || $this->params->get('login_image') != '') : ?>
			<div class="login-description">
			<?php endif ; ?>

				<?php if($this->params->get('logindescription_show') == 1) : ?>
					<?php echo $this->params->get('login_description'); ?>
				<?php endif; ?>

				<?php if (($this->params->get('login_image')!='')) :?>
					<img src="<?php echo $this->escape($this->params->get('login_image')); ?>" class="login-image" alt="<?php echo JTEXT::_('COM_USER_LOGIN_IMAGE_ALT')?>"/>
				<?php endif; ?>

			<?php if (($this->params->get('logindescription_show') == 1 && str_replace(' ', '', $this->params->get('login_description')) != '') || $this->params->get('login_image') != '') : ?>
			</div>
			<?php endif ; ?>

			<form id="login-form" action="<?php echo JRoute::_('index.php?option=com_users&task=user.login'); ?>" method="post">

				<fieldset class="login-page">
					<ul class="form-list">
						<li>
						<?php foreach ($this->form->getFieldset('credentials') as $field): ?>
							<?php if (!$field->hidden): ?>
								<?php echo $field->label; ?>
								<div class="input-box login-fields"><?php echo str_replace('class="', 'class="input-text ', $field->input); ?></div>
							<?php endif; ?>
						<?php endforeach; ?>
						</li>
					</ul>
					
					<?php if (JPluginHelper::isEnabled('system', 'remember')) : ?>
					<div class="login-fields">
						<label id="remember-lbl" for="remember"><?php echo JText::_('JGLOBAL_REMEMBER_ME') ?></label>
						<input id="remember" type="checkbox" name="remember" class="inputbox" value="yes"  alt="<?php echo JText::_('JGLOBAL_REMEMBER_ME') ?>" />
					</div>
					<?php endif; ?>
					<button type="submit" class="button form-submit"><?php echo JText::_('JLOGIN'); ?></button>
					<input type="hidden" name="return" value="<?php echo base64_encode($this->params->get('login_redirect_url', $this->form->getValue('return'))); ?>" />
					<?php echo JHtml::_('form.token'); ?>
				</fieldset>
			</form>
		</div>
	</div>
</fieldset>