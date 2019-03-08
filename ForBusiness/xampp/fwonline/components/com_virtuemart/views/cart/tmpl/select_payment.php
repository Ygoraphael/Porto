<?php
/**
 *
 * Layout for the payment selection
 *
 * @package	VirtueMart
 * @subpackage Cart
 * @author Max Milbers
 *
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: select_payment.php 5451 2012-02-15 22:40:08Z alatak $
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
$addClass="";


if (VmConfig::get('oncheckout_show_steps', 1)) {
    echo '<div class="checkoutStep" id="checkoutStep3">' . JText::_('COM_VIRTUEMART_USER_FORM_CART_STEP3') . '</div>';
}

if ($this->layoutName!='default') {
	$headerLevel = 1;
	if($this->cart->getInCheckOut()){
		$buttonclass = '';
	} else {
		$buttonclass = 'default';
	}
?>
	<form method="post" id="paymentForm" name="choosePaymentRate" action="<?php echo JRoute::_('index.php'); ?>" class="form-validate <?php echo $addClass ?>">
<?php } else {
		$headerLevel = 3;
		$buttonclass = '';
	}


	echo "
  <div class='container'>
  <div class='row' style='margin-top:4%;'>
  <div class='col-md-2'></div>
  <div class='col-md-8 text-center elipse-border-bottom  box-shadow-destaques'>
  <h4 style='margin-top:0;'>".JText::_('COM_VIRTUEMART_CART_SELECT_PAYMENT')."</h4></div>
  <div class='col-md-2'></div>
  </div><br>";

?>


<?php
     if ($this->found_payment_method) {

    echo "<div class='row' style='padding-left:37px;'><fieldset style=' width:100%; margin:0 auto; font-size:18px;'>";
		foreach ($this->paymentplugins_payments as $paymentplugin_payments) {
		    if (is_array($paymentplugin_payments)) {
			foreach ($paymentplugin_payments as $paymentplugin_payment) {
			    echo "<div class='col-md-12 text-center' style='height:4vh'>" . $paymentplugin_payment.'</div>';
			}
		    }
		}
    echo "</fieldset></div><br><br>";

    } else {
	 echo "<h3>".$this->payment_not_found_text."</h3>";
    }

if ($this->layoutName!='default') {
?>

<div style=" width:60%; margin: 0 auto; margin-top:2vh;">

    <div class="row">
    
        <div class="col-md-2"></div>
        <div class="col-md-4">
        
            <button name="setpayment" class="btn btn-primary no-border-radius" style="background:#eb4800; width:100%;display:inline-block" type="submit"><?php echo JText::_('COM_VIRTUEMART_SAVE'); ?></button>
     &nbsp;
   <?php   if ($this->layoutName!='default') { ?>
            
        </div>
        
        <div class="col-md-4">
        
            <button class="btn btn-primary btn-block no-border-radius" type="reset" style="background:#eb4800; width:100%;display:inline-block" onClick="window.location.href='<?php echo JRoute::_('index.php?option=com_virtuemart&view=cart'); ?>'" ><?php echo JText::_('COM_VIRTUEMART_CANCEL'); ?></button>
	<?php  } ?>
        
        </div>
        <div class="col-md-2"></div>
        
    </div>


    </div>


    <input type="hidden" name="option" value="com_virtuemart" />
    <input type="hidden" name="view" value="cart" />
    <input type="hidden" name="task" value="setpayment" />
    <input type="hidden" name="controller" value="cart" />
</div>
</form>
<?php
}
?>
