<?php
/**
 *
 * Template for the shipment selection
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
 * @version $Id: cart.php 2400 2010-05-11 19:30:47Z milbo $
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');


if (VmConfig::get('oncheckout_show_steps', 1)) {
    echo '<div class="checkoutStep" id="checkoutStep2">' . JText::_('COM_VIRTUEMART_USER_FORM_CART_STEP2') . '</div>';
}

if ($this->layoutName != 'default') {
    $headerLevel = 1;
    if ($this->cart->getInCheckOut()) {
        $buttonclass = 'button vm-button-correct';
    } else {
        $buttonclass = 'default';
    }
    ?>
    <form method="post" id="userForm" name="chooseShipmentRate" action="<?php echo JRoute::_('index.php'); ?>" class="form-validate">
        <?php
    } else {
        $headerLevel = 3;
        $buttonclass = 'vm-button-correct';
    }

    echo "<div class='container'>
    <div class='row' style='margin-top:4%;'>
    <div class='col-md-2'></div>
    <div class='col-md-8 text-center elipse-border-bottom  box-shadow-destaques'>
    <h4>" . JText::_('COM_VIRTUEMART_CART_SELECT_SHIPMENT') . "</h4>
    </div>
    <div class='col-md-2'></div>
    </div> ";
    ?>


    <?php
    if ($this->found_shipment_method) {
        
        echo "<br><div class='row' style='padding-left:35px;'><fieldset style=' width:100%; margin:0 auto; font-size:18px;'>";
        // if only one Shipment , should be checked by default
        foreach ($this->shipments_shipment_rates as $shipment_shipment_rates) {
            if (is_array($shipment_shipment_rates)) {
                foreach ($shipment_shipment_rates as $shipment_shipment_rate) {
                    echo "<div class='col-md-12 text-center' style='height:4vh'>" . $shipment_shipment_rate . "</div>";
                }
            }
        }
        echo "</fieldset></div><br><br>";
    } else {
        echo "<h3>" . $this->shipment_not_found_text . "</h3>";
    }


    if ($this->layoutName != 'default') {
        ?>
        <div class="container text-center" style=" width:60%; margin: 0 auto; margin-top:2vh;">
            <div class="row">
            
                <div class="col-md-2"></div>
                <div class="col-md-4">
                
                    <button  name="setshipment" class="btn btn-primary no-border-radius" style="background:#eb4800; width:100%;display:inline-block" type="submit" ><?php echo JText::_('COM_VIRTUEMART_SAVE'); ?></button>  &nbsp;
                <?php if ($this->layoutName != 'default') { ?>
                    
                
                </div>
                
                <div class="col-md-4">
                
                    <button class="btn btn-primary no-border-radius" style="background:#eb4800; width:100%;display:inline-block" type="reset" onClick="window.location.href = '<?php echo JRoute::_('index.php?option=com_virtuemart&view=cart'); ?>'" ><?php echo JText::_('COM_VIRTUEMART_CANCEL'); ?></button>
                <?php } ?>
                
                </div>
                
                <div class="col-md-2"></div>
                
                
            
            </div>
            
        </div>

        <input type="hidden" name="option" value="com_virtuemart" />
        <input type="hidden" name="view" value="cart" />
        <input type="hidden" name="task" value="setshipment" />
        <input type="hidden" name="controller" value="cart" />
</div>
    </form>
    <?php
}
?>
