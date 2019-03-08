<?php
/**
 * @version		$Id: $
 * @author		Codextension
 * @package		Joomla!
 * @subpackage	Module
 * @copyright	Copyright (C) 2008 - 2012 by Codextension. All rights reserved.
 * @license		GNU/GPL, see LICENSE
 */
defined('_JEXEC') or die('Restricted access');
echo '<style>
			#vmQuickCartModule #jlcart div.cart_content{
				width:'.$widthdropdown.'px!important;
			}
			#vmQuickCartModule #jlcart div.cart_content ul.innerItems{
				
			}
	</style>';
?>

<div class="vmCartModule <?php echo $params->get('moduleclass_sfx'); ?>" id="vmQuickCartModule">
	<div id="jlcart">
		<a href="index.php/component/virtuemart/cart" class="cart_dropdown">
			<?php echo  $data->totalProductTxt ?><?php if ($data->totalProduct) echo  ': '.$data->billTotal; ?>
		</a>
		
		<?php
		$show_product_list = 0;
		if ($show_product_list) {
			?>
			<div class="cart_content">
				<?php if(count($data->products)){?>
				<ul class="innerItems">
					<?php 
					foreach ($data->products as $product){
						//getProduct
						?>
							<li class="clearfix <?php echo 'item-'.preg_replace('/[^a-zA-Z0-9\']/', '-', $product['cart_item_id']);?>">
								<div class="cart_product_name">
									<span>
										<?php if ( $show_desc && !empty($product['desc']) ) { ?> 
										<span class="product_desc">
											<?php echo $product['desc']; ?>
										</span>
										<br/>
										<?php }?>
										<?php 
											if ( $show_attr && !empty($product['product_attributes']) ) { 
										?>
											<span class="product_attributes"><?php echo $product['product_attributes'] ?></span>
										<?php 	
											}
										?>
									</span>
								</div>
								<div class="cart_product_price">
									<span>
										<?php 
											if($show_price){
										?>
										<strong><?php echo  $product['quantity'] ?>x - <?php echo $product['prices']; ?></strong><br>
										<?php }?>
									</span>
								</div>
							</li>	
					<?php 
					}
				?>
				</ul>
				<?php }?>
			</div>
		<?php }?>
		
	</div>

</div>

