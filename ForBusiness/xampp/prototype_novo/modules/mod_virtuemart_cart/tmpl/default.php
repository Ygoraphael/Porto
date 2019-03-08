<?php // no direct access
defined('_JEXEC') or die('Restricted access');

//dump ($cart,'mod cart');
// Ajax is displayed in vm_cart_products
// ALL THE DISPLAY IS Done by Ajax using "hiddencontainer" ?>

<!-- Virtuemart 2 Ajax Card -->
<div class="vmCartModule <?php echo $params->get('moduleclass_sfx'); ?>" id="vmCartModule">
<?php
	$total_prod = 0;
	foreach ($data->products as $product)
	{
		$total_prod += 1;
	}
?>
<div class="total" style="float: right;">
	<?php 
		if ($total_prod) {
			echo $data->billTotal;
		}
	?>
</div>
<div class="total_products"><?php echo  $data->totalProductTxt ?></div>
<div class="show_cart">
	<?php if ($data->totalProduct) echo  $data->cart_show; ?>
</div>
<div style="clear:both;"></div>
	<div class="payments-signin-button" ></div>

<noscript>
<?php echo JText::_('MOD_VIRTUEMART_CART_AJAX_CART_PLZ_JAVASCRIPT') ?>
</noscript>
</div>

