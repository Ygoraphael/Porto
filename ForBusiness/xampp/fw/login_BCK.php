<?php
   if (JFactory::getUser()->id > 0) {
   	echo JText::_('NOVOSCANAIS_WELCOME') . ' ' . JFactory::getUser()->name;
   ?>
   <br><br><br>
<div class="container">
<div class="row">
  <div class="col-md-12">
   <a class="linkColor" href="index.php/<?php echo JText::_('NOVOSCANAIS_CLIENTAREA_LINK'); ?>">
   <span><?php echo JText::_('NOVOSCANAIS_CLIENTAREA'); ?></span>
   </a>
   <br>
</div>
</div>

<div class="row">
  <div class="col-md-12">
   <a class="linkColor" href="index.php?option=com_virtuemart&view=orders&layout=list">
   <span><?php echo JText::_('NOVOSCANAIS_ENCOMENDAS'); ?></span>
   </a>
</div>
</div>

  <div class="row" style="position:absolute; bottom:50px; margin:0 auto;">
   <div class="col-md-12">
     <div class="btn-holder">
       <div>
         <a  class="custom-a custom-btn" style="color:white;" href="index.php?option=com_users&task=user.logout&<?php echo JUtility::getToken(); ?>=1">
           <span class="round"><i class="fa fa-sign-in" aria-hidden="true"></i></i></span>
           <span><?php echo JText::_('NOVOSCANAIS_EXIT'); ?></span>
         </a>
       </div>
    </div>
   </div>
  </div>
</div>
<?php
   }
   else {
   ?>
   <div class="container">
     <div class="row">
       <div class="col-md-1"></div>
      <div class="col-md-10">
        <div class="btn-holder">
          <div>
            <a class="custom-a custom-btn width100" href="index.php/<?php echo JText::_('NOVOSCANAIS_LOGIN'); ?>">
              <span class="round"><i class="fa fa-sign-in" aria-hidden="true"></i></i></span>
            <span><?php echo JText::_('NOVOSCANAIS_LOGIN'); ?></span>
            </a>
          </div>
       </div>
      </div>
        <div class="col-md-1"></div>
     </div>
   </div>
<br><br><br>
<a class="linkColor" href="<?php echo JRoute::_('index.php?option=com_users&view=registration'); ?>">
<span><?php echo JText::_('COM_USERS_LOGIN_REGISTER'); ?></span>
</a>
<br>
<a class="linkColor" href="<?php echo JRoute::_('index.php?option=com_users&view=reset'); ?>">
<span><?php echo JText::_('COM_USERS_LOGIN_RESET'); ?></span>
</a>
<div>
   <a class="linkColor" href="<?php echo JRoute::_('index.php?option=com_users&view=remind'); ?>">
   <span>
   <?php echo JText::_('COM_USERS_LOGIN_REMIND'); ?>
   </span>
   </a>
</div>
<?php
   }
   ?>
