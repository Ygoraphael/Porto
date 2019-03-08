<?php
if (JFactory::getUser()->id > 0) { ?>
    <div class="container">
        <div class="row text-center" style="width:100%; padding-right:0px; margin-right:0px; margin-left:0px;">
            <div class="col-xs-12" style="width:100%; padding-right:0px; margin-right:0px; margin-left:0px;">
                <h5><?= JText::_('NOVOSCANAIS_WELCOME') ?></h5>
            </div>
        </div>
        <div class="row text-center" style="width:100%; padding-right:0px; margin-right:0px; margin-left:0px;">
            <div class="col-xs-12" style="width:100%; padding-right:0px; margin-right:0px; margin-left:0px;">
                <h5><?= JFactory::getUser()->name ?></h5>
            </div>
        </div>
        <br>
        <div class="row">
            <a href="index.php/<?= JText::_('NOVOSCANAIS_CLIENTAREA_LINK') ?>" class="btn btn-primary btn-block no-border-radius"><?= JText::_('NOVOSCANAIS_CLIENTAREA') ?></a>
            <a href="index.php?option=com_virtuemart&view=orders&layout=list" class="btn btn-primary btn-block no-border-radius"><?php echo JText::_('NOVOSCANAIS_ENCOMENDAS'); ?></a>
            <a href="index.php?option=com_users&task=user.logout&<?php echo JUtility::getToken(); ?>=1" class="btn btn-primary btn-block no-border-radius"><?php echo JText::_('NOVOSCANAIS_EXIT'); ?></a>
        </div>
    </div>
    <?php
} else {
    ?>
    <div class="container">
        <div class="row">
            <a href="index.php/<?php echo JText::_('NOVOSCANAIS_LOGIN'); ?>" class="btn btn-primary btn-block no-border-radius"><?= JText::_('NOVOSCANAIS_LOGIN'); ?></a>
            <a href="<?= JRoute::_('index.php?option=com_users&view=registration'); ?>" class="btn btn-primary btn-block no-border-radius"><?= JText::_('COM_USERS_LOGIN_REGISTER'); ?></a>
            <a href="<?= JRoute::_('index.php?option=com_users&view=reset'); ?>" class="btn btn-primary btn-block no-border-radius"><?= JText::_('COM_USERS_LOGIN_RESET'); ?></a>
            <a href="<?= JRoute::_('index.php?option=com_users&view=remind'); ?>" class="btn btn-primary btn-block no-border-radius"><?= JText::_('COM_USERS_LOGIN_REMIND'); ?></a>
        </div>
    </div>
    <?php
}
?>