<?php defined('_JEXEC') or die('Restricted access');
vmJsApi::jPrice();
?>
<div class="front_pdetails_tab">
            <ul id="myTab" class="nav nav-tabs">
              
					<?php
					// Separator
					$verticalseparator = " vertical-separator";

					foreach ($this->products as $type => $productList ) {
					// Calculating Products Per Row
					$products_per_row = VmConfig::get ( 'homepage_products_per_row', 3 ) ;
					$cellwidth = ' width'.floor ( 100 / $products_per_row );

					// Category and Columns Counter
					$col = 1;
					$nb = 1;

					$productTitle = JText::_('COM_VIRTUEMART_'.$type.'_PRODUCT')

					?>
			        <li class="<?php if ($type==featured) { ?> <?php echo "active";}?>"><a href="#<?php echo $type ?>" data-toggle="tab"><span class="rox_title"><?php echo $productTitle ?></span></a></li>
			        <?php } ?> 
            </ul>
            <div id="myTabContent" class="tab-content">
			<?php
					// Separator
					$verticalseparator = " vertical-separator";

					foreach ($this->products as $type => $productList ) {
					// Calculating Products Per Row
					$products_per_row = VmConfig::get ( 'homepage_products_per_row', 3 ) ;
					$cellwidth = ' width'.floor ( 100 / $products_per_row );

					// Category and Columns Counter
					$col = 1;
					$nb = 1;

					$productTitle = JText::_('COM_VIRTUEMART_'.$type.'_PRODUCT')

			?>
              <div class="tab-pane fade <?php if ($type==featured) { ?> <?php echo "active in";}?>" id="<?php echo $type ?>">
			  <p> 
					<div class="<?php echo $type ?>-view">
						
					
					<?php if(empty($productList)){?>
					
					<?php echo "There is no Products In this category";
                    }
					?>					
						
						<?php // Start the Output
						
						foreach ( $productList as $product ) {

							// Show the horizontal seperator
							if ($col == 1 && $nb > $products_per_row) { ?>
							<div class="horizontal-separator"></div>
							<?php }

							// this is an indicator wether a row needs to be opened or not
							if ($col == 1) { ?>
							<div class="row">
							<?php }

							// Show the vertical seperator
							if ($nb == $products_per_row or $nb % $products_per_row == 0) {
								$show_vertical_separator = ' ';
							} else {
								$show_vertical_separator = $verticalseparator;
							}

								// Show Products ?>
								<div class="product floatleft<?php echo $cellwidth . $show_vertical_separator ?>">
									<div class="spacer rox_spacer">
										<div class="spacer_overly">Overly</div>


											

											<div>
											<?php // Product Image
											if ($product->images) {
												echo JHTML::_ ( 'link', JRoute::_ ( 'index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' . $product->virtuemart_category_id ), $product->images[0]->displayMediaThumb( 'class="featuredProductImage" border="0"',true,'class="modal"' ) );
											}
											?>
											</div>

											<h3 class="product_title">
											<?php // Product Name
											echo JHTML::link ( JRoute::_ ( 'index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' . $product->virtuemart_category_id ), $product->product_name, array ('title' => $product->product_name ) ); ?>
											</h3>
											
											<div class="product-price">
												<?php
												if (VmConfig::get ( 'show_prices' ) == '1') {
												//				if( $featProduct->product_unit && VmConfig::get('vm_price_show_packaging_pricelabel')) {
												//						echo "<strong>". JText::_('COM_VIRTUEMART_CART_PRICE_PER_UNIT').' ('.$featProduct->product_unit."):</strong>";
												//					} else echo "<strong>". JText::_('COM_VIRTUEMART_CART_PRICE'). ": </strong>";

												
												
												
												echo $this->currency->createPriceDiv( 'salesPrice', '', $product->prices );
												echo $this->currency->createPriceDiv( 'discountAmount', '', $product->prices );
												
												}

												?>
												</div>
											
											<form method="post" class="product" action="index.php" id="addtocartproduct<?php echo $product->virtuemart_product_id ?>">
								<div class="width_sope2 addtocart-bar">
										<?php // Display the quantity box ?>
										<!-- <label for="quantity<?php echo $this->product->virtuemart_product_id;?>" class="quantity_box"><?php echo JText::_('COM_VIRTUEMART_CART_QUANTITY'); ?>: </label> -->
										<span class="quantity-box">
											<input style="display:none;" type="text" class="quantity-input" name="quantity[]" value="1" />
										</span>
										
										<?php // Display the quantity box END ?>

										<?php // Add the button
										$button_lbl = JText::_('ROX_COM_VIRTUEMART_CART_ADD_TO');
										$button_cls = ''; //$button_cls = 'addtocart_button';
										if (VmConfig::get('check_stock') == '1' && !$this->product->product_in_stock) {
											$button_lbl = JText::_('COM_VIRTUEMART_CART_NOTIFY');
											$button_cls = 'notify-button';
										} ?>

										<?php // Display the add to cart button ?>
										<span class="addtocart-button">
											<input type="submit" name="addtocart"  class="addtocart-button" value="<?php echo $button_lbl ?>" title="<?php echo $button_lbl ?>" />
										</span>

									<div class="clear"></div>
									</div>

									<?php // Display the add to cart button END ?>
									<input type="hidden" class="pname" value="<?php echo $product->product_name ?>">
									<input type="hidden" name="option" value="com_virtuemart" />
									<input type="hidden" name="view" value="cart" />
									<noscript><input type="hidden" name="task" value="add" /></noscript>
									<input type="hidden" name="virtuemart_product_id[]" value="<?php echo $product->virtuemart_product_id ?>" />
									
								</form>
											
								<div class="product_details">
									<?php // Product Details Button
									echo JHTML::link ($product->link, JText::_ ('COM_VIRTUEMART_PRODUCT_DETAILS'), array('title' => $product->product_name, 'class' => 'product-details'));
									?>
								</div>			
											
											
										
									</div>
								</div>
							<?php
							$nb ++;

							// Do we need to close the current row now?
							if ($col == $products_per_row) { ?>
							<div class="clear"></div>
							</div>
								<?php
								$col = 1;
							} else {
								$col ++;
							}
							
						}
						// Do we need a final closing row tag?
						if ($col != 1) { ?>
							<div class="clear"></div>
					
							
							
					</div>
					<?php
					}
					?>
					</div>
						

			  </p>
              </div>
			<?php } ?>
            </div>
</div>