<?php
defined('_JEXEC') or die('');

/**
 *
 * Template for the shopping cart
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
 */
if ($this->display_title) {
    echo "<h3>" . JText::_('COM_VIRTUEMART_CART_ORDERDONE_THANK_YOU') . "</h3>";
}
echo $this->html;
$array = (array) $this->currencyDisplay->_app->input;
$order_number = $array[chr(0) . '*' . chr(0) . "data"]["old_order_number"];
?>

<br>
<div class="row">

     <div class="col-md-2 col-lg-3 "></div>
    <div class="col-md-4 col-lg-3 "><button class="btn btn-primary no-border-radius" name="checkout" style="width:100%;margin-bottom:2%;" class="" onclick="window.open('<?php echo JRoute::_('index.php?option=com_virtuemart&view=orders&layout=details&order_number=' . $order_number); ?>', '_blank');">
    <span><?php echo JText::_('ESTADOENCOMENDA') ?></span>
</button></div>
    <div class="col-md-4 col-lg-3 "><button name="checkout" id="" class="btn btn-primary no-border-radius" style="width:100%;margin-bottom:2%;" onclick="window.open('<?php echo JURI::base(); ?>', '_blank');"><span><?php echo JText::_('VOLTARLOJA') ?></span></button></div>
    <div class="col-md-2 col-lg-3 "></div>
   

</div>

