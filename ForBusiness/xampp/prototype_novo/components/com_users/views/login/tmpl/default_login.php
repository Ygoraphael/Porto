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

<div class="row">
  <div class="col-xs-6">
	  <div class="well">
		  <form id="login-form" action="<?php echo JRoute::_('index.php?option=com_users&task=user.login'); ?>" method="post">
			  <div class="form-group">
				  <label for="username" class="control-label">
				  <?php
					if($lang->getTag()=='pt-PT')
					{
						$username_l = "Nome de Utilizador";
					}
					if($lang->getTag()=='en-GB')
					{
						$username_l = "Username";
					}
					
					echo $username_l;
				  ?>
				  </label>
				  <input type="text" class="form-control" id="username" name="username" value="" required="" title="Please enter you username" placeholder="<?php echo $username_l; ?>">
				  <span class="help-block"></span>
			  </div>
			  <div class="form-group">
				  <label for="password" class="control-label">Password</label>
				  <input type="password" class="form-control" id="password" name="password" value="" required="" title="Password">
				  <span class="help-block"></span>
			  </div>
			  <div id="loginErrorMsg" class="alert alert-error hide">
			  <?php
					if($lang->getTag()=='pt-PT')
					{
						$pw_l = "Nome ou password inválida";
					}
					if($lang->getTag()=='en-GB')
					{
						$pw_l = "Wrong username og password";
					}
					
					echo $pw_l;
				  ?>
			  </div>
			  <div class="checkbox">
				  <?php if (JPluginHelper::isEnabled('system', 'remember')) : ?>
					<div class="login-fields">
						<label id="remember-lbl" for="remember">
							<input id="remember" type="checkbox" name="remember" class="inputbox" value="yes"  alt="<?php echo JText::_('JGLOBAL_REMEMBER_ME') ?>" />
							<?php echo JText::_('JGLOBAL_REMEMBER_ME') ?>
						</label>
					</div>
				  <?php endif; ?>
			  </div>
			  <button type="submit" class="button form-submit btn btn-block"><?php echo JText::_('JLOGIN'); ?></button>
				<input type="hidden" name="return" value="<?php echo base64_encode($this->params->get('login_redirect_url', $this->form->getValue('return'))); ?>" />
				<?php echo JHtml::_('form.token'); ?>
		  </form>
	  </div>
  </div>
  <div class="col-xs-6">
	  <p class="lead">
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
	  </p>
	  <p>
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
	  </p>
	  <p><a class="button form-submit btn btn-block" href="<?php 
					if($lang->getTag()=='pt-PT')
					{
						echo "index.php/pt/registo";
					} 
					if($lang->getTag()=='en-GB')
					{
						echo "index.php/pt/registration";
					}
				?>" class="btn btn-info btn-block"><?php
						if($lang->getTag()=='pt-PT')
						{
							echo "Criar uma Conta";
						}
						if($lang->getTag()=='en-GB')
						{
							echo "Create an Account";
						}
						?></a></p>
  </div>
</div>