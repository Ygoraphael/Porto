 <?php
defined( '_JEXEC' ) or die( 'Restricted access' );

if (!$productData) {
	echo 'No info about this product.';
	die();
}

?>
<div class="pdesc-details">
	<div style="padding:3px 5px 5px 5px;"><?php echo $productData['product_name'] ?></div>
	<div><img src="/<?php echo $productData['image'] ?>" style="max-width:100%" /></div>
	<div class="pdesc-devider">Short Description</div>
	<div style="padding:3px 0 3px 5px;"><?php
		echo ($productData['product_s_desc']) ?
			$productData['product_s_desc'] : '<div class="grayed">- There is no Short Description -</div>'; ?>
	</div>
	<div class="pdesc-devider">Full Description</div><div style="padding:4px 0 4px 7px;"><?php
		echo ($productData['product_desc']) ?
			$productData['product_desc'] : '<div class="grayed">- There is no Full Description -</div>'; ?>
	</div>
</div>
