<?php defined ('_JEXEC') or die('Restricted access');
/**
 *
 * Layout for the shopping cart
 *
 * @package    VirtueMart
 * @subpackage Cart
 * @author Max Milbers
 * @author Patrick Kohl
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 Sören, 2010 - 2014 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 *
 */
?>
<div class="billto-shipto clearfix" >
	<div class="width50 floatleft">
		<div>
			<span><span class="vmicon vm2-billto-icon"></span>
				<?php echo JText::_ ('COM_VIRTUEMART_USER_FORM_BILLTO_LBL'); ?></span>
			<?php // Output Bill To Address ?>
			<div class="output-billto" id="output-billto">
				<?php

				foreach ($this->cart->BTaddress['fields'] as $item) {
					if (!empty($item['value'])) {
						if ($item['name'] === 'agreed') {
							$item['value'] = ($item['value'] === 0) ? JText::_ ('COM_VIRTUEMART_USER_FORM_BILLTO_TOS_NO') : JText::_ ('COM_VIRTUEMART_USER_FORM_BILLTO_TOS_YES');
						}
						?><!-- span class="titles"><?php echo $item['title'] ?></span -->
						<span class="values vm2<?php echo '-' . $item['name'] ?>"><?php echo $this->escape ($item['value']) ?></span>
						<?php if ($item['name'] != 'title' and $item['name'] != 'first_name' and $item['name'] != 'middle_name' and $item['name'] != 'zip') { ?>
							<br class="clear"/>
							<?php
						}
					}
				} ?>
				<div class="clear"></div>
			</div>
		</div>
		<a class="details output-billto-edit" id="output-billto-edit" href="<?php echo JRoute::_ ('index.php?option=com_virtuemart&view=user&task=editaddresscart&addrtype=BT', $this->useXHTML, $this->useSSL) ?>" rel="nofollow">
			<?php echo JText::_ ('COM_VIRTUEMART_USER_FORM_EDIT_BILLTO_LBL'); ?>
		</a>
		<input type="hidden" name="billto" value="<?php echo $this->cart->lists['billTo']; ?>"/>
	</div>

	<div class="width50 floatleft">
		<div>
			<span><span class="vmicon vm2-shipto-icon"></span>
				<?php echo JText::_ ('COM_VIRTUEMART_USER_FORM_SHIPTO_LBL'); ?></span>
			<?php // Output Bill To Address ?>
			<div class="output-shipto" id="output-shipto">
				<?php
				if (empty($this->cart->STaddress['fields'])) {
					echo JText::sprintf ('COM_VIRTUEMART_USER_FORM_EDIT_BILLTO_EXPLAIN', JText::_ ('COM_VIRTUEMART_USER_FORM_ADD_SHIPTO_LBL'));
				} else {
					if (!class_exists ('VmHtml')) {
						require(JPATH_VM_ADMINISTRATOR . DS . 'helpers' . DS . 'html.php');
					}
					echo JText::_ ('COM_VIRTUEMART_USER_FORM_ST_SAME_AS_BT');
					echo VmHtml::checkbox ('STsameAsBTjs', $this->cart->STsameAsBT) . '<br />';
					?>
					<div id="output-shipto-display">
						<?php
						foreach ($this->cart->STaddress['fields'] as $item) {
							if (!empty($item['value'])) {
								?>
								<!-- <span class="titles"><?php echo $item['title'] ?></span> -->
								<?php
								if ($item['name'] == 'first_name' || $item['name'] == 'middle_name' || $item['name'] == 'zip') {
									?>
									<span class="values<?php echo '-' . $item['name'] ?>"><?php echo $this->escape ($item['value']) ?></span>
									<?php } else { ?>
									<span class="values"><?php echo $this->escape ($item['value']) ?></span>
									<br class="clear"/>
									<?php
								}
							}
						}
						?>
					</div>
					<?php
				}
				?>
				<div class="clear"></div>
			</div>
			<?php if (!isset($this->cart->lists['current_id'])) {
				$this->cart->lists['current_id'] = 0;
			} ?>
		</div>
		<a class="details output-shipto-add" id="output-shipto-add" href="<?php echo JRoute::_ ('index.php?option=com_virtuemart&view=user&task=editaddresscart&addrtype=ST&virtuemart_user_id[]=' . $this->cart->lists['current_id'], $this->useXHTML, $this->useSSL) ?>" rel="nofollow">
			<?php echo JText::_ ('COM_VIRTUEMART_USER_FORM_ADD_SHIPTO_LBL'); ?>
		</a>
	</div>

	<div class="clear"></div>
</div>

<div class="col-lg-12 col-sm-12 col-xs-12 clearfix cart-cab cart-cab-head">
	<div class="col-lg-8 col-sm-8"><?php echo JText::_ ('COM_VIRTUEMART_CART_PRODUCT') ?></div>
	<div class="col-lg-1 col-sm-1"><?php echo JText::_ ('COM_VIRTUEMART_CART_PRICE') ?></div>
	<div class="col-lg-1 col-sm-1"><?php echo JText::_ ('COM_VIRTUEMART_CART_QUANTITY') ?></div>
	<div class="col-lg-1 col-sm-1"><?php  echo JText::_ ('COM_VIRTUEMART_CART_SUBTOTAL_TAX_AMOUNT') ?></div>
	<div class="col-lg-1 col-sm-1"><?php echo JText::_ ('COM_VIRTUEMART_CART_TOTAL') ?></div>
</div>

<?php //cabecalho ?>

<?php //linhas ?>
<?php
$i = 1;
$crow = 1;
$nrows = sizeof($this->cart->products);

foreach ($this->cart->products as $pkey => $prow) {
	if($crow == $nrows) {
		$last = ' cart-cab-last ';
	}
	else {
		$last = ' ';
	}
	$crow++;
	
	$p_image_url = JURI::root() . "images/logo_256_322.png";
	$pid = $prow->virtuemart_product_id;
	$sql="select i.file_url as image from #__virtuemart_medias as i, 
	#__virtuemart_product_medias as mi where 
	i.virtuemart_media_id = mi.virtuemart_media_id and 
	mi.virtuemart_product_id =".$pid."  limit 0,1";
	$dbb = JFactory::getDbo();
	$dbb->setQuery($sql);
	$results = $dbb->loadObjectList();
	if(sizeof($results)) {
		$p_image_url = JURI::root() . $results[0]->image;
	}
	?>

<div class="col-lg-12 col-sm-12 clearfix cart-cab<?php echo $last; ?>cart-cab-line">
	<div class="col-lg-8 col-sm-8" style="padding:0">
		<a href="<?php echo $prow->url; ?>"><img style="width:60px;height:60px" src="<?php echo $p_image_url; ?>" alt="<?php echo $prow->product_name; ?>" /></a>
		<?php echo JHTML::link($prow->url, $prow->product_sku . " - " . $prow->product_name) . $prow->customfields; ?>
	</div>
	<div class="col-lg-1 col-sm-1">
	<?php
		if ($this->cart->pricesUnformatted[$pkey]['discountedPriceWithoutTax']) {
			echo $this->currencyDisplay->createPriceDiv ('discountedPriceWithoutTax', '', $this->cart->pricesUnformatted[$pkey], FALSE, FALSE);
		} else {
			echo $this->currencyDisplay->createPriceDiv ('basePriceVariant', '', $this->cart->pricesUnformatted[$pkey], FALSE, FALSE);
		}
	?>
	</div>
	<div class="col-lg-1 col-sm-1">
		<?php

			if ($prow->step_order_level)
				$step=$prow->step_order_level;
			else
				$step=1;
			if($step==0)
				$step=1;
			$alert=JText::sprintf ('COM_VIRTUEMART_WRONG_AMOUNT_ADDED', $step);
			?>
			<script type="text/javascript">
			function check<?php echo $step?>(obj) {
			// use the modulus operator '%' to see if there is a remainder
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

			<!--<input type="text" title="<?php echo  JText::_('COM_VIRTUEMART_CART_UPDATE') ?>" class="inputbox" size="3" maxlength="4" name="quantity" value="<?php echo $prow->quantity ?>" /> -->
		<input type="text"
			   onblur="check<?php echo $step?>(this);"
			   onclick="check<?php echo $step?>(this);"
			   onchange="check<?php echo $step?>(this);"
			   onsubmit="check<?php echo $step?>(this);"
			   style="vertical-align:bottom;height:24px;" 
			   title="<?php echo  JText::_('COM_VIRTUEMART_CART_UPDATE') ?>" class="quantity-input js-recalculate" size="3" maxlength="4" name="quantity[<?php echo $prow->cart_item_id ?>]" value="<?php echo $prow->quantity ?>" />
		<input type="submit" class="vmicon vm2-add_quantity_cart" name="update[<?php echo $prow->cart_item_id ?>]" title="<?php echo  JText::_ ('COM_VIRTUEMART_CART_UPDATE') ?>" align="middle" value=""/>

		<a class="vmicon vm2-remove_from_cart" title="<?php echo JText::_ ('COM_VIRTUEMART_CART_DELETE') ?>" href="<?php echo JRoute::_ ('index.php?option=com_virtuemart&view=cart&task=delete&cart_virtuemart_product_id=' . $prow->cart_item_id) ?>" rel="nofollow"> </a>
	</div>
	<div class="col-lg-1 col-sm-1">
		<?php echo "<span class='priceColor2'>" . $this->currencyDisplay->createPriceDiv ('taxAmount', '', $this->cart->pricesUnformatted[$pkey], FALSE, FALSE, $prow->quantity) . "</span>" ?>
	</div>
	<div class="col-lg-1 col-sm-1">
		<?php
		// if (VmConfig::get ('checkout_show_origprice', 1) && !empty($this->cart->pricesUnformatted[$pkey]['basePriceWithTax']) && $this->cart->pricesUnformatted[$pkey]['basePriceWithTax'] != $this->cart->pricesUnformatted[$pkey]['salesPrice']) {
			// echo '<span class="line-through">' . $this->currencyDisplay->createPriceDiv ('basePriceWithTax', '', $this->cart->pricesUnformatted[$pkey], TRUE, FALSE, $prow->quantity) . '</span><br />';
		// }
		if (VmConfig::get ('checkout_show_origprice', 1) && empty($this->cart->pricesUnformatted[$pkey]['basePriceWithTax']) && $this->cart->pricesUnformatted[$pkey]['basePriceVariant'] != $this->cart->pricesUnformatted[$pkey]['salesPrice']) {
			echo '<span class="line-through">' . $this->currencyDisplay->createPriceDiv ('basePriceVariant', '', $this->cart->pricesUnformatted[$pkey], TRUE, FALSE, $prow->quantity) . '</span><br />';
		}
		echo $this->currencyDisplay->createPriceDiv ('salesPrice', '', $this->cart->pricesUnformatted[$pkey], FALSE, FALSE, $prow->quantity) ?>
	</div>
</div>

<div class="col-xs-12 cart-cab-resp cart-cab-line-resp">
	<div class="col-xs-12 clearfix center" style="padding:0; padding-bottom:20px">
		<a href="<?php echo $prow->url; ?>">
			<div class="col-xs-12" >
				<img style="width:70%;" src="<?php echo $p_image_url; ?>" alt="<?php echo $prow->product_name; ?>" />
			</div>
			<div class="col-xs-12" style="padding:0">
				<?php echo JHTML::link($prow->url, $prow->product_sku . " - " . $prow->product_name) . $prow->customfields; ?>
			</div>
		</a>
	</div>
	<div class="col-xs-12 clearfix" style="padding:0">
		<div class="col-xs-6" style="padding:0">
			<?php echo JText::_ ('COM_VIRTUEMART_CART_QUANTITY') ?>
		</div>
		<div class="col-xs-6 right" style="padding:0">
			<?php
				if ($prow->step_order_level)
					$step=$prow->step_order_level;
				else
					$step=1;
				if($step==0)
					$step=1;
				$alert=JText::sprintf ('COM_VIRTUEMART_WRONG_AMOUNT_ADDED', $step);
				?>
				<script type="text/javascript">
				function check<?php echo $step?>(obj) {
				// use the modulus operator '%' to see if there is a remainder
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

				<!--<input type="text" title="<?php echo  JText::_('COM_VIRTUEMART_CART_UPDATE') ?>" class="inputbox" size="3" maxlength="4" name="quantity" value="<?php echo $prow->quantity ?>" /> -->
			<input type="text"
				   onblur="check<?php echo $step?>(this);"
				   onclick="check<?php echo $step?>(this);"
				   onchange="check<?php echo $step?>(this);"
				   onsubmit="check<?php echo $step?>(this);"
				   style="vertical-align:bottom;height:24px;" 
				   title="<?php echo  JText::_('COM_VIRTUEMART_CART_UPDATE') ?>" class="quantity-input js-recalculate" size="3" maxlength="4" name="quantity[<?php echo $prow->cart_item_id ?>]" value="<?php echo $prow->quantity ?>" />
			<input type="submit" class="vmicon vm2-add_quantity_cart" name="update[<?php echo $prow->cart_item_id ?>]" title="<?php echo  JText::_ ('COM_VIRTUEMART_CART_UPDATE') ?>" align="middle" value=""/>

			<a class="vmicon vm2-remove_from_cart" title="<?php echo JText::_ ('COM_VIRTUEMART_CART_DELETE') ?>" href="<?php echo JRoute::_ ('index.php?option=com_virtuemart&view=cart&task=delete&cart_virtuemart_product_id=' . $prow->cart_item_id) ?>" rel="nofollow"> </a>
		</div>
	</div>
	<div class="col-xs-12 clearfix" style="padding:0">
		<div class="col-xs-6" style="padding:0">
			<?php echo JText::_ ('COM_VIRTUEMART_CART_PRICE') ?>
		</div>
		<div class="col-xs-6 right" style="padding:0">
			<?php
				if ($this->cart->pricesUnformatted[$pkey]['discountedPriceWithoutTax']) {
					echo $this->currencyDisplay->createPriceDiv ('discountedPriceWithoutTax', '', $this->cart->pricesUnformatted[$pkey], FALSE, FALSE);
				} else {
					echo $this->currencyDisplay->createPriceDiv ('basePriceVariant', '', $this->cart->pricesUnformatted[$pkey], FALSE, FALSE);
				}
			?>
		</div>
	</div>
	<div class="col-xs-12 clearfix" style="padding:0">
		<div class="col-xs-6" style="padding:0">
			<?php echo JText::_ ('COM_VIRTUEMART_CART_SUBTOTAL_TAX_AMOUNT') ?>
		</div>
		<div class="col-xs-6 right" style="padding:0">
			<?php echo "<span class='priceColor2'>" . $this->currencyDisplay->createPriceDiv ('taxAmount', '', $this->cart->pricesUnformatted[$pkey], FALSE, FALSE, $prow->quantity) . "</span>" ?>
		</div>
	</div>
	<div class="col-xs-12 clearfix" style="padding:0">
		<div class="col-xs-6" style="padding:0">
			<?php echo JText::_ ('COM_VIRTUEMART_CART_TOTAL') ?>
		</div>
		<div class="col-xs-6 right" style="padding:0">
			<?php
				if (VmConfig::get ('checkout_show_origprice', 1) && empty($this->cart->pricesUnformatted[$pkey]['basePriceWithTax']) && $this->cart->pricesUnformatted[$pkey]['basePriceVariant'] != $this->cart->pricesUnformatted[$pkey]['salesPrice']) {
					echo '<span class="line-through">' . $this->currencyDisplay->createPriceDiv ('basePriceVariant', '', $this->cart->pricesUnformatted[$pkey], TRUE, FALSE, $prow->quantity) . '</span><br />';
				}
				echo $this->currencyDisplay->createPriceDiv ('salesPrice', '', $this->cart->pricesUnformatted[$pkey], FALSE, FALSE, $prow->quantity) 
			?>
		</div>
	</div>
</div>

<?php
} 
?>
<?php //linha branco?>
<div class="col-lg-12 col-sm-12 clearfix">
	<div class="col-lg-10 col-sm-10"></div>
	<div class="col-lg-2 col-sm-2"><hr/></div>
</div>
<?php //subtotal?>
<div class="col-lg-12 col-sm-12 clearfix cart-cab-head nopadding">
	<div class="col-lg-10 col-sm-10 right">
		<?php echo JText::_ ('COM_VIRTUEMART_ORDER_PRINT_PRODUCT_PRICES_TOTAL'); ?>
	</div>
	<div class="col-lg-1 col-sm-1 right">
		<?php echo "<span  class='priceColor2'>" . $this->currencyDisplay->createPriceDiv ('taxAmount', '', $this->cart->pricesUnformatted, FALSE) . "</span>" ?>
	</div>
	<div class="col-lg-1 col-sm-1 right">
		<?php echo $this->currencyDisplay->createPriceDiv ('salesPrice', '', $this->cart->pricesUnformatted, FALSE) ?>
	</div>
</div>

<?php //cupoes?>
<?php
if (VmConfig::get ('coupons_enable')) {
	?>
<tr class="sectiontableentry2">
<td colspan="4" align="left">
	<?php if (!empty($this->layoutName) && $this->layoutName == 'default') {
	// echo JHTML::_('link', JRoute::_('index.php?view=cart&task=edit_coupon',$this->useXHTML,$this->useSSL), JText::_('COM_VIRTUEMART_CART_EDIT_COUPON'));
	echo $this->loadTemplate ('coupon');
}
	?>

	<?php if (!empty($this->cart->cartData['couponCode'])) { ?>
	<?php
	echo $this->cart->cartData['couponCode'];
	echo $this->cart->cartData['couponDescr'] ? (' (' . $this->cart->cartData['couponDescr'] . ')') : '';
	?>

				</td>

					 <?php if (VmConfig::get ('show_tax')) { ?>
		<td align="right"><?php echo $this->currencyDisplay->createPriceDiv ('couponTax', '', $this->cart->pricesUnformatted['couponTax'], FALSE); ?> </td>
		<?php } ?>
	<td align="right"> </td>
	<td align="right"><?php echo $this->currencyDisplay->createPriceDiv ('salesPriceCoupon', '', $this->cart->pricesUnformatted['salesPriceCoupon'], FALSE); ?> </td>
	<?php } else { ?>
	</td><td colspan="3" align="left">&nbsp;</td>
	<?php
}

	?>
</tr>
	<?php } ?>

<?php //metodos envio?>
<div class="col-lg-12 col-sm-12 clearfix nopadding">
	<h3><?php echo JText::_ ('COM_VIRTUEMART_SHIPMENT'); ?></h3>
</div>
<?php if ( 	VmConfig::get('oncheckout_opc',true) or !VmConfig::get('oncheckout_show_steps',false) or (!VmConfig::get('oncheckout_opc',true) and VmConfig::get('oncheckout_show_steps',false) and !empty($this->cart->virtuemart_shipmentmethod_id) )) { ?>
<div class="col-lg-12 col-sm-12 clearfix nopadding cart-cab-head">
	<div class="col-lg-10 col-sm-10 left nopadding">
		<?php if (!$this->cart->automaticSelectedShipment) {
			echo $this->cart->cartData['shipmentName']; ?>
			<br/>
			<?php
			if (!empty($this->layoutName) && $this->layoutName == 'default' && !$this->cart->automaticSelectedShipment)	{
				if (VmConfig::get('oncheckout_opc', 1)) {
					$previouslayout = $this->setLayout('select');
					echo $this->loadTemplate('shipment');
					$this->setLayout($previouslayout);
				} else {
					echo JHTML::_('link', JRoute::_('index.php?view=cart&task=edit_shipment', $this->useXHTML, $this->useSSL), $this->select_shipment_text, 'class=""');
				}
			} else {
				echo JText::_ ('COM_VIRTUEMART_CART_SHIPPING');
			}
		}
		else {
			echo $this->cart->cartData['shipmentName'];
		}
		?>
	</div>
	<div class="col-lg-1 col-sm-1 right">
		<?php echo "<span  class='priceColor2'>" . $this->currencyDisplay->createPriceDiv ('shipmentTax', '', $this->cart->pricesUnformatted['shipmentTax'], FALSE) . "</span>"; ?>
	</div>
	<div class="col-lg-1 col-sm-1 right">
		<?php echo $this->currencyDisplay->createPriceDiv ('salesPriceShipment', '', $this->cart->pricesUnformatted['salesPriceShipment'], FALSE); ?>
	</div>
</div>
<div class="col-xs-12 show-resp clearfix" style="padding:0">
	<div class="col-xs-9 nopadding">
		<?php if (!$this->cart->automaticSelectedShipment) {
			echo $this->cart->cartData['shipmentName']; ?>
			<br/>
			<?php
			if (!empty($this->layoutName) && $this->layoutName == 'default' && !$this->cart->automaticSelectedShipment)	{
				if (VmConfig::get('oncheckout_opc', 1)) {
					$previouslayout = $this->setLayout('select');
					echo $this->loadTemplate('shipment');
					$this->setLayout($previouslayout);
				} else {
					echo JHTML::_('link', JRoute::_('index.php?view=cart&task=edit_shipment', $this->useXHTML, $this->useSSL), $this->select_shipment_text, 'class=""');
				}
			} else {
				echo JText::_ ('COM_VIRTUEMART_CART_SHIPPING');
			}
		}
		else {
			echo $this->cart->cartData['shipmentName'];
		}
		?>
	</div>
	<div class="col-xs-3 right">
		<?php echo $this->currencyDisplay->createPriceDiv ('salesPriceShipment', '', $this->cart->pricesUnformatted['salesPriceShipment'], FALSE); ?>
	</div>
</div>
<?php 
}
?>
<?php //metodos pagamento?>
<div class="col-lg-12 col-sm-12 clearfix nopadding">
	<h3><?php echo JText::_ ('COM_VIRTUEMART_PAYMENT'); ?></h3>
</div>
<?php if ($this->cart->pricesUnformatted['salesPrice']>0.0 and (VmConfig::get('oncheckout_opc',true) or !VmConfig::get('oncheckout_show_steps',false) or ((!VmConfig::get('oncheckout_opc',true) and VmConfig::get('oncheckout_show_steps',false) ) and !empty($this->cart->virtuemart_paymentmethod_id)))) { ?>
	<div class="col-lg-12 col-sm-12 clearfix nopadding cart-cab-head">
		<div class="col-lg-10 col-sm-10 left nopadding">
		<?php if (!$this->cart->automaticSelectedPayment) { ?>
			<?php echo $this->cart->cartData['paymentName']; ?>
			<br/>
			<?php if (!empty($this->layoutName) && $this->layoutName == 'default' && !$this->cart->automaticSelectedPayment) {
				if (VmConfig::get('oncheckout_opc', 1)) {
					$previouslayout = $this->setLayout('select');
					echo $this->loadTemplate('payment');
					$this->setLayout($previouslayout);
				} else {
					echo JHTML::_('link', JRoute::_('index.php?view=cart&task=editpayment', $this->useXHTML, $this->useSSL), $this->select_payment_text, 'class=""');
				}
			} else {
				echo JText::_ ('COM_VIRTUEMART_CART_PAYMENT');
			} 
		} 
		else {
			echo $this->cart->cartData['paymentName']; 
		}
		?>
		</div>
		<div class="col-lg-1 col-sm-1 right">
			<?php echo "<span  class='priceColor2'>" . $this->currencyDisplay->createPriceDiv ('paymentTax', '', $this->cart->pricesUnformatted['paymentTax'], FALSE) . "</span>"; ?>
		</div>
		<div class="col-lg-1 col-sm-1 right">
			<?php echo $this->currencyDisplay->createPriceDiv ('salesPricePayment', '', $this->cart->pricesUnformatted['salesPricePayment'], FALSE); ?>
		</div>
	</div>
	<div class="col-xs-12 show-resp clearfix" style="padding:0">
		<div class="col-xs-9 nopadding">
			<?php if (!$this->cart->automaticSelectedPayment) { ?>
				<?php echo $this->cart->cartData['paymentName']; ?>
				<br/>
				<?php if (!empty($this->layoutName) && $this->layoutName == 'default' && !$this->cart->automaticSelectedPayment) {
					if (VmConfig::get('oncheckout_opc', 1)) {
						$previouslayout = $this->setLayout('select');
						echo $this->loadTemplate('payment');
						$this->setLayout($previouslayout);
					} else {
						echo JHTML::_('link', JRoute::_('index.php?view=cart&task=editpayment', $this->useXHTML, $this->useSSL), $this->select_payment_text, 'class=""');
					}
				} else {
					echo JText::_ ('COM_VIRTUEMART_CART_PAYMENT');
				} 
			} 
			else {
				echo $this->cart->cartData['paymentName']; 
			}
			?>
		</div>
		<div class="col-xs-3 right">
			<?php echo $this->currencyDisplay->createPriceDiv ('salesPricePayment', '', $this->cart->pricesUnformatted['salesPricePayment'], FALSE); ?>
		</div>
	</div>
<?php 
	}
?>
<?php //linha branco?>
<div class="col-lg-12 col-sm-12 clearfix">
	<div class="col-lg-10 col-sm-10"></div>
	<div class="col-lg-2 col-sm-2"><hr/></div>
</div>
<?php //totais?>
<div class="col-lg-12 col-sm-12 clearfix cart-cab-head">
	<div class="col-lg-10 col-sm-10 right"><?php echo JText::_ ('COM_VIRTUEMART_CART_TOTAL') ?>:</div>
	<div class="col-lg-1 col-sm-1 right">
	<?php 
		if( $this->cart->virtuemart_paymentmethod_id == 1 ) {
			$user = JFactory::getUser();
			$db = JFactory::getDbo();
			$sql = "
				select discount_pp 
				from #__virtuemart_vmusers
				where virtuemart_user_id = " . $user->get('id');
			$db->setQuery($sql);
			$result = $db->loadObjectList();
			
			if( sizeof($result) > 0 ) {
				$iva = -($result[0]->discount_pp);
				$iva = $this->cart->pricesUnformatted['billTaxAmount'] - ($this->cart->pricesUnformatted['billTaxAmount'] - ($this->cart->pricesUnformatted['billTaxAmount'] * (1 +($iva * 0.01))));
				echo "<span  class='priceColor2'>" . $this->currencyDisplay->createPriceDiv ('billTaxAmount', '', $iva, FALSE) . "</span>";
			}
			else {
				echo "<span  class='priceColor2'>" . $this->currencyDisplay->createPriceDiv ('billTaxAmount', '', 1, FALSE) . "</span>";
			}
		}
		else {
			echo "<span  class='priceColor2'>" . $this->currencyDisplay->createPriceDiv ('billTaxAmount', '', $this->cart->pricesUnformatted['billTaxAmount'], FALSE) . "</span>";
		}
	?> 
	</div>
	<div class="col-lg-1 col-sm-1 right">
		<div class="bold"><?php echo $this->currencyDisplay->createPriceDiv ('billTotal', '', $this->cart->pricesUnformatted['billTotal'], FALSE); ?></div>
	</div>
</div>
<div class="col-xs-12 show-resp clearfix totalbox">
	<div class="col-xs-6 nopadding right">
		<?php echo JText::_ ('COM_VIRTUEMART_CART_TOTAL') ?> <?php echo JText::_ ('COM_VIRTUEMART_CART_SUBTOTAL_TAX_AMOUNT') ?>
	</div>
	<div class="col-xs-6 right">
		<?php 
			if( $this->cart->virtuemart_paymentmethod_id == 1 ) {
				$user = JFactory::getUser();
				$db = JFactory::getDbo();
				$sql = "
					select discount_pp 
					from #__virtuemart_vmusers
					where virtuemart_user_id = " . $user->get('id');
				$db->setQuery($sql);
				$result = $db->loadObjectList();
				
				if( sizeof($result) > 0 ) {
					$iva = -($result[0]->discount_pp);
					$iva = $this->cart->pricesUnformatted['billTaxAmount'] - ($this->cart->pricesUnformatted['billTaxAmount'] - ($this->cart->pricesUnformatted['billTaxAmount'] * (1 +($iva * 0.01))));
					echo "<span  class='priceColor2'>" . $this->currencyDisplay->createPriceDiv ('billTaxAmount', '', $iva, FALSE) . "</span>";
				}
				else {
					echo "<span  class='priceColor2'>" . $this->currencyDisplay->createPriceDiv ('billTaxAmount', '', 1, FALSE) . "</span>";
				}
			}
			else {
				echo "<span  class='priceColor2'>" . $this->currencyDisplay->createPriceDiv ('billTaxAmount', '', $this->cart->pricesUnformatted['billTaxAmount'], FALSE) . "</span>";
			}
		?>
	</div>
	<div class="col-xs-12 nopadding">
		<hr>
	</div>
	<div class="col-xs-6 nopadding right">
		<?php echo JText::_ ('COM_VIRTUEMART_CART_TOTAL') ?>
	</div>
	<div class="col-xs-6 right">
		<b><?php echo $this->currencyDisplay->createPriceDiv ('billTotal', '', $this->cart->pricesUnformatted['billTotal'], FALSE); ?></b>
	</div>
</div>
