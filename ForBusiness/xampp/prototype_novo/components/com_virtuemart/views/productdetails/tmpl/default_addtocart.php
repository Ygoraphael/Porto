<?php
/**
 *
 * Show the product details page
 *
 * @package    VirtueMart
 * @subpackage
 * @author Max Milbers, Valerie Isaksen
 * @todo handle child products
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: default_addtocart.php 6433 2012-09-12 15:08:50Z openglobal $
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
if (isset($this->product->step_order_level))
	$step=$this->product->step_order_level;
else
	$step=1;
if($step==0)
	$step=1;
$alert=JText::sprintf ('COM_VIRTUEMART_WRONG_AMOUNT_ADDED', $step);
if (JFactory::getUser()->id > 0) {
?>
<form method="post" class="product js-recalculate" action="<?php echo JRoute::_ ('index.php',false); ?>">
	<input name="quantity" type="hidden" value="<?php echo $step ?>" />
	<script type="text/javascript">
		function check(obj) {
			remainder=obj.value % <?php echo $step?>;
			quantity=obj.value;
			if (remainder  != 0) {
				alert('<?php echo $alert?>!');
				obj.value = quantity-remainder;
				return false;
				}
			return true;
		}
	</script> 

	<?php 
		$stockhandle = VmConfig::get ('stockhandle', 'none');
		if (($stockhandle == 'disableit' or $stockhandle == 'disableadd') and ($this->product->product_in_stock - $this->product->product_ordered) < 1) {
			?>
			<a href="<?php echo JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&layout=notify&virtuemart_product_id=' . $this->product->virtuemart_product_id); ?>" class="notify"><?php echo JText::_ ('COM_VIRTUEMART_CART_NOTIFY') ?></a>
			<?php
		} else {
			$tmpPrice = (float) $this->product->prices['costPrice'];
			if (!( VmConfig::get('askprice', 0) and empty($tmpPrice) ) ) {
				?>
				<!-- <label for="quantity<?php echo $this->product->virtuemart_product_id; ?>" class="quantity_box"><?php echo JText::_ ('COM_VIRTUEMART_CART_QUANTITY'); ?>: </label> -->
				
				
				 
				<?php // Add the button
				$button_lbl = JText::_('COM_VIRTUEMART_CART_ADD_TO');
				$button_cls = 'addtocart-button'; //$button_cls = 'addtocart_button';
				$button_name = 'addtocart'; //$button_cls = 'addtocart_button';

				// Display the add to cart button
				$stockhandle = VmConfig::get('stockhandle','none');
				if(($stockhandle=='disableit' or $stockhandle=='disableadd') and ($product->product_in_stock - $product->product_ordered)<1){
				$button_lbl = JText::_('COM_VIRTUEMART_CART_NOTIFY');
				$button_cls = 'notify-button';
				$button_name = 'notifycustomer';
				}
				vmdebug('$stockhandle '.$stockhandle.' and stock '.$product->product_in_stock.' ordered '.$product->product_ordered);
				?>										

				<?php if ($button_cls == "notify-button") { ?>
					<span class="outofstock"><?php echo JText::_('COM_VIRTUEMART_CART_PRODUCT_OUT_OF_STOCK'); ?></span>
				<?php } else {?>
					<div class="col-lg-6 col-xs-12 col-sm-8 pull-right">
						<div class="pull-left nopadding">
							<span class="quantity-box top-price">
								<input type="text" class="quantity-input js-recalculate" name="quantity[]" onblur="check(this);"
									   value="<?php if (isset($this->product->step_order_level) && (int)$this->product->step_order_level > 0) {
											echo $this->product->step_order_level;
										} else if(!empty($this->product->min_order_level)){
											echo $this->product->min_order_level;
										}else {
											echo '1';
										} ?>"/>
							</span>
							<span class="quantity-controls js-recalculate top-price">
								<input type="button" class="quantity-controls quantity-plus"  />
								<input type="button" class="quantity-controls quantity-minus" />
							</span>
						</div>
						<div class="<?php echo $button_cls ?> pull-left top-price" style="width:300px; height:50px; background-image: url(images/bg-button1.png); background-size: cover; background-repeat: no-repeat; background-position: center center;">
							<div class="pull-left" style="padding-left:10px; padding-top:10px; width:250px; color:#fee202; font-size:1.3em;"><?php echo $button_lbl ?></div>
							<div class="pull-right" style="width:50px; font-size:2.1em;"><center><i class="fa fa-cart-plus" aria-hidden="true"></i></center></div>
						</div>
					</div>
				<?php } ?>
				 
				<noscript><input type="hidden" name="task" value="add"/></noscript>
				
			<?php
			}
			?>
		<?php
		}
		?>
	<div class="clear"></div>
	<input type="hidden" name="option" value="com_virtuemart"/>
	<input type="hidden" name="view" value="cart"/>
	<input type="hidden" name="virtuemart_product_id[]" value="<?php echo $this->product->virtuemart_product_id ?>"/>
	<input type="hidden" class="pname" value="<?php echo htmlentities($this->product->product_name, ENT_QUOTES, 'utf-8') ?>"/>
	<?php
	$itemId=vRequest::getInt('Itemid',false);
	if($itemId){
		echo '<input type="hidden" name="Itemid" value="'.$itemId.'"/>';
	} ?>
</form>
<div class="clear"></div>
<?php
}
?>