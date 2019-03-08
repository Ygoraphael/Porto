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
?>
<!-- login -->
<div style="width:100%;">
    <?php if ($this->params->get('show_page_heading')) : ?>
        <h1>
            <?php echo $this->escape($this->params->get('page_heading')); ?>
        </h1>
    <?php endif; ?>

    <?php if (($this->params->get('logindescription_show') == 1 && str_replace(' ', '', $this->params->get('login_description')) != '') || $this->params->get('login_image') != '') : ?>

    <?php endif; ?>

    <?php if ($this->params->get('logindescription_show') == 1) : ?>
        <?php echo $this->params->get('login_description'); ?>
    <?php endif; ?>

    <?php if (($this->params->get('login_image') != '')) : ?>
        <img src="<?php echo $this->escape($this->params->get('login_image')); ?>" class="login-image" alt="<?php echo JTEXT::_('COM_USER_LOGIN_IMAGE_ALT') ?>"/>
    <?php endif; ?>

    <?php if (($this->params->get('logindescription_show') == 1 && str_replace(' ', '', $this->params->get('login_description')) != '') || $this->params->get('login_image') != '') : ?>

    <?php
    endif;

    //tiago hack
    $lang = JFactory::getLanguage();
    if ($lang->getTag() == "en-GB")
        $lang = "en";
    else
        $lang = "pt";
    //tiago hack
    ?>
    <form style="padding:20px;" action="<?php echo JRoute::_('index.php/?option=com_users&task=user.login') . "&lang=$lang"; ?>" method="post" class="formLogin">
        <div class="imgcontainer">
            <img src="http://www.fenixaerocarga.com.br/img/avatar.png" alt="Avatar" class="avatar">
        </div>
        <?php foreach ($this->form->getFieldset('credentials') as $field): ?>
            <?php if (!$field->hidden): ?>
                <?php echo $field->label; ?><br>
                <?php echo $field->input; ?><br>
            <?php endif; ?>
        <?php endforeach; ?>
        <?php if (JPluginHelper::isEnabled('system', 'remember')) : ?>
            <label id="remember-lbl" for="remember"><?php echo JText::_('JGLOBAL_REMEMBER_ME') ?></label>
            <input id="remember" type="checkbox" name="remember" class="inputbox" value="yes"  alt="<?php echo JText::_('JGLOBAL_REMEMBER_ME') ?>" />
        <?php endif; ?>
        <button type="submit" class="btn btn-primary btn-block no-border-radius"><?php echo JText::_('JLOGIN'); ?></button><br>
        <input type="hidden" name="return" value="<?php echo base64_encode($this->params->get('login_redirect_url', $this->form->getValue('return'))); ?>" />
        <button type="submit" class="validate btn btn-primary btn-block no-border-radius">
            <a href="<?php echo JRoute::_(''); ?>" style="pointer-events:none; color:white;"><?php echo JText::_('JCANCEL'); ?></a></button>

        <input type="hidden" name="option" value="com_users" />
        <?php echo JHtml::_('form.token'); ?>

    </form>
    <ul class="loginUL">
        <li>
            <a href="<?php echo JRoute::_('index.php?option=com_users&view=reset'); ?>">
                <?php echo JText::_('COM_USERS_LOGIN_RESET'); ?></a>
        </li>
        <li>
            <a href="<?php echo JRoute::_('index.php?option=com_users&view=remind'); ?>">
                <?php echo JText::_('COM_USERS_LOGIN_REMIND'); ?></a>
        </li>
        <?php
        $usersConfig = JComponentHelper::getParams('com_users');
        if ($usersConfig->get('allowUserRegistration')) :
            ?>
            <li>
                <a href="<?php echo JRoute::_('index.php?option=com_users&view=registration'); ?>">
            <?php echo JText::_('COM_USERS_LOGIN_REGISTER'); ?></a>
            </li>
<?php endif; ?>
    </ul>
</div>
<!-- /login -->
