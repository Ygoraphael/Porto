<?php
/**
 *
 * Show the products in a category
 *
 * @package    VirtueMart
 * @subpackage
 * @author RolandD
 * @author Max Milbers
 * @todo add pagination
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: default.php 6556 2012-10-17 18:15:30Z kkmediaproduction $
 */


// Check to ensure this file is included in Joomla!
defined ('_JEXEC') or die('Restricted access');
JHTML::_ ('behavior.modal');
/* javascript for list Slide
  Only here for the order list
  can be changed by the template maker
*/
$js = "
jQuery(document).ready(function () {
	jQuery('.orderlistcontainer').hover(
		function() { jQuery(this).find('.orderlist').stop().show()},
		function() { jQuery(this).find('.orderlist').stop().hide()}
	)
});
";

$document = JFactory::getDocument ();
$document->addScriptDeclaration ($js);

if (empty($this->keyword) and !empty($this->category)) {
	?>
<div class="category_description">
	<?php echo $this->category->category_description; ?>
</div>
<?php
}

/* Show child categories */

if (VmConfig::get ('showCategory', 1) and empty($this->keyword)) {
	if (!empty($this->category->haschildren)) {

		// Category and Columns Counter
		$iCol = 1;
		$iCategory = 1;

		// Calculating Categories Per Row
		$categories_per_row = VmConfig::get ('categories_per_row', 3);
		$category_cellwidth = ' width' . floor (100 / $categories_per_row);

		// Separator
		$verticalseparator = " vertical-separator";
		?>

		<div class="category-view">

		<?php // Start the Output
		if (!empty($this->category->children)) {

			foreach ($this->category->children as $category) {

				// Show the horizontal seperator
				if ($iCol == 1 && $iCategory > $categories_per_row) {
					?>
					<div class="horizontal-separator"></div>
					<?php
				}

				// this is an indicator wether a row needs to be opened or not
				if ($iCol == 1) {
					?>
			<div class="row">
			<?php
				}

				// Show the vertical seperator
				if ($iCategory == $categories_per_row or $iCategory % $categories_per_row == 0) {
					$show_vertical_separator = ' ';
				} else {
					$show_vertical_separator = $verticalseparator;
				}

				// Category Link
				$caturl = JRoute::_ ('index.php?option=com_virtuemart&view=category&virtuemart_category_id=' . $category->virtuemart_category_id, FALSE);

				// Show Category
				?>
				<div class="category floatleft<?php echo $category_cellwidth . $show_vertical_separator ?>">
					<div class="spacer">
						<h2>
							<a href="<?php echo $caturl ?>" title="<?php echo $category->category_name ?>">
								<?php echo $category->category_name ?>
								<br/>
								<?php // if ($category->ids) {
								echo $category->images[0]->displayMediaThumb ("", FALSE);
								//} ?>
							</a>
						</h2>
					</div>
				</div>
				<?php
				$iCategory++;

				// Do we need to close the current row now?
				if ($iCol == $categories_per_row) {
					?>
					<div class="clear"></div>
		</div>
			<?php
					$iCol = 1;
				} else {
					$iCol++;
				}
			}
		}
		// Do we need a final closing row tag?
		if ($iCol != 1) {
			?>
			<div class="clear"></div>
		</div>
	<?php } ?>
	</div>

	<?php
	}
}
?>
<div class="browse-view">
<?php if (!empty($this->keyword)) {

	$category_id  = JRequest::getInt ('virtuemart_category_id', 0); ?>
<form action="<?php echo JRoute::_ ('index.php?option=com_virtuemart&view=category&limitstart=0', FALSE); ?>" method="get">

	<!--BEGIN Search Box -->
	<div class="virtuemart_search">
		<?php echo $this->searchcustom ?>
		<br/>
		<?php echo $this->searchcustomvalues ?>
		<input name="keyword" class="inputbox" type="text" size="20" value="<?php echo $this->keyword ?>"/>
		<input type="submit" value="<?php echo JText::_ ('COM_VIRTUEMART_SEARCH') ?>" class="button" onclick="this.form.keyword.focus();"/>
	</div>
	<input type="hidden" name="search" value="true"/>
	<input type="hidden" name="view" value="category"/>
	<input type="hidden" name="option" value="com_virtuemart"/>
	<input type="hidden" name="virtuemart_category_id" value="<?php echo $category_id; ?>"/>

</form>
<!-- End Search Box -->
	<?php } ?>

<?php // Show child categories
$language =& JFactory::getLanguage();
$language->load('mod_virtuemart_product');

if (!empty($this->products)) {
	?>
<div class="toolbar">
	<div class="pager" style="float:left;">
		<div class="pages">
			<?php echo $this->vmPagination->getPagesLinksol (); ?>
		</div>
	</div>
	<span style="float:right; margin-top:15px;"><?php echo $this->vmPagination->getPagesCounter (); ?></span>
	<div class="clear"></div>
</div>

<div class="toolbar" style="">
	<div class="sorter">
		<div class="view-mode">
			<?php 
				$NewProductView = JRequest::getVar('NewProductView', '');
				$NewPriceView = JRequest::getVar('NewPriceView', '');
				
				$inputCookie  = JFactory::getApplication()->input->cookie;
				
				$view_type    = $inputCookie->get($name = 'DefaultProductView', $defaultValue = null);
				$cookieExists1 = !($view_type === null);

				if(!$cookieExists1) {
					$inputCookie->set($name = 'DefaultProductView', $view_type = 'list', $expire = 0, $path = '/');
				} 
				else {
					if($NewProductView!="") {
						$inputCookie->set($name = 'DefaultProductView', $view_type = $NewProductView, $expire = 0, $path = '/');
					}
				}
				
				$value        = $inputCookie->get($name = 'DefaultPriceView', $defaultValue = null);
				$cookieExists = !($value === null);

				if(!$cookieExists) {
					$inputCookie->set($name = 'DefaultPriceView', $value = 'PCL', $expire = 0, $path = '/');
				} 
				else {
					if($NewPriceView!="") {
						$inputCookie->set($name = 'DefaultPriceView', $value = $NewPriceView, $expire = 0, $path = '/');
					}
				}
				
				if( $view_type=="list" ) {
				?>
					<span title="<?php echo JText::_ ('MOD_VIRTUEMART_LIST') ?>" class="button button-active button-list first"><?php echo JText::_ ('MOD_VIRTUEMART_LIST') ?></span>
					<form method="post" id="ViewControl1" style="float:right; margin-left:5px;">
						<input type="hidden" name="NewProductView" value="
							<?php 									
								if( $view_type=="grid" ) {
									echo "list";
								}
								else {
									echo "grid";
								}
							?>" />
						<a onclick="jQuery('form#ViewControl1').submit();" title="<?php echo JText::_ ('MOD_VIRTUEMART_GRID') ?>" class="button button-grid last"><?php echo JText::_ ('MOD_VIRTUEMART_GRID') ?></a>
					</form>
				<?php
				}
				else {
				?>
					<form method="post" id="ViewControl2" style="float:left; margin-right:5px;">
						<input type="hidden" name="NewProductView" value="
							<?php 
								if( $view_type=="grid" ) {
									echo "list";
								}
								else {
									echo "grid";
								}
							?>" />
						<a onclick="jQuery('form#ViewControl2').submit();" title="<?php echo JText::_ ('MOD_VIRTUEMART_LIST') ?>" class="button button-grid last"><?php echo JText::_ ('MOD_VIRTUEMART_LIST') ?></a>
					</form>
					<span title="<?php echo JText::_ ('MOD_VIRTUEMART_GRID') ?>" class="button button-active button-grid first"><?php echo JText::_ ('MOD_VIRTUEMART_GRID') ?></span>
				<?php
				}
			?>
		</div>
	</div>
	<div class="pager">
		<div id="limiter">
			<?php echo $this->vmPagination->getResultsCounter ();?>
			<?php echo $this->vmPagination->getLimitBox ($this->category->limit_list_step); ?>
		</div>
	</div>
	<div id="sort-by" style="margin-right:25px;">
		<?php echo $this->orderByList['orderby']; ?>
	</div>
</div>
<br>
	<script>
		function MostraPrecos() {
			if( jQuery(".clPricesalesPrice").css("display") == "none" ) {
				jQuery(".clPricesalesPrice").css("display", "inline");
				jQuery(".clsalesPrice").css("display", "none");
			}
			else {
				jQuery(".clPricesalesPrice").css("display", "none");
				jQuery(".clsalesPrice").css("display", "inline");
			}
		}
	</script>
	<style>
		.zoom_img img{
			-moz-transition:-moz-transform 0.5s ease-in; 
			-webkit-transition:-webkit-transform 0.5s ease-in; 
			-o-transition:-o-transform 0.5s ease-in;
		}
		.zoom_img img:hover{
			-moz-transform:scale(2); 
			-webkit-transform:scale(2);
			-o-transform:scale(2);
			transition-duration: 0.3s;
		}
		.button:active {
			vertical-align: top;
			padding: 1px 1px 1px;
		}
	</style>
	<?php
		$user =& JFactory::getUser(); 
		if( $user->id ){
	?>
	<div style="float:left; width:75%;"><h1><?php echo $this->category->category_name; ?></h1></div>
	
	<form id="PricesForm" method="post">
		<input type="hidden" name="NewPriceView" value="
			<?php 
				if( $value=="PVP" ) {
					echo "PCL";
				}
				else {
					echo "PVP";
				}
			?>" />
		<script>
			function ChangePrices() {
				setTimeout(function() {
					jQuery( "#PricesForm" ).submit();
				}, 300);
			}
		</script>
		<div class="onoffswitch" style="float:right;">
			<input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" onclick="ChangePrices()" id="myonoffswitch" <?php if( $value=="PVP" ) { echo "checked"; } ?> />
			<label class="onoffswitch-label" for="myonoffswitch">
				<span class="onoffswitch-inner"></span>
				<span class="onoffswitch-switch"></span>
			</label>
		</div>
	</form>
	<?php
		}
		else {
	?>
	<div><h1><?php echo $this->category->category_name; ?></h1></div>
	<?php
		}
	?>
	<div class="clear"></div>
	
	
	<div class="category-products">
		<?php
			if( $view_type=="list" ) {
		?>
		<ol class="products-list" id="products-list">
			<?php
				// Category and Columns Counter
				$iBrowseCol = 1;
				$iBrowseProduct = 1;

				// Calculating Products Per Row
				$BrowseProducts_per_row = $this->perRow;
				$Browsecellwidth = ' width' . floor (100 / $BrowseProducts_per_row);

				// Separator
				$verticalseparator = " vertical-separator";
				$BrowseTotalProducts = count($this->products);

				$even_odd = "odd";
				
				// Start the Output
				foreach ($this->products as $product) {
			?>
			<li class="item <?php echo $even_odd; ?>">
				<div class="listimg product-image">
					<?php
						if ($product->file_url == "images/stories/virtuemart/product/") {
							$prod_img = "images/logo_256_322.png";
						}
						else {
							$prod_img = $product->file_url;
						}
					?>
					<a href="<?php echo $product->link; ?>" title="<?php echo $product->product_name; ?>" class="">
					<img src="<?php echo $prod_img; ?>" class="small-image" alt="<?php echo $product->product_name; ?>">
					</a>
				</div>
				<div class="product-shop">
					<div class="product-shop-left">
						<h2 class="product-name">
							<a href="<?php echo $product->link; ?>" title="<?php echo $product->product_name; ?>"><?php echo $product->product_name; ?></a>
						</h2>
						<div class="ratings">
							<div class="rating-box">
								<div style="width:0%" class="rating"></div>
							</div>
						</div>
						<div class="listtext desc std">
							<p><?php echo $product->product_s_desc; ?></p>
						</div>
						<div style="margin-top:7px!important; border-top: 1px solid #efefef; padding-top: 5px;" class="avaible_stock">
							<span class="sku"><?php echo JText::_ ('MOD_VIRTUEMART_SKU'); ?>:&nbsp;<?php echo $product->product_sku; ?></span>
							<?php if (JFactory::getUser()->id > 0) { ?>
							<span class="stock">
								<?php 
									$db = JFactory::getDbo();
									$query = $db->getQuery(true);
									$query->select('baixr');
									$query->from($db->quoteName('#__virtuemart_products'));
									$query->where($db->quoteName('virtuemart_product_id')." = ".$db->quote($product->virtuemart_product_id));
									$db->setQuery($query);
									$row = $db->loadRow();
									
									if( $row[0] == 1 && $product->product_in_stock == 0) {
										echo '<b>' . JText::_('STOCK_04') . '</b>';
									}
									else {
										if( $product->product_in_stock <= 0 ) {
											echo "<div id='circle1' class='stock_3'></div>" . JText::_('STOCK_03');
										}
										else if ( $product->product_in_stock < $product->low_stock_notification ) {
											echo "<div id='circle1' class='stock_2'></div>" . JText::_('STOCK_02');
										}
										else {
											echo "<div id='circle1' class='stock_1'></div>" . JText::_('STOCK_01');
										}
									}
								?>
							</span>
							<?php } ?> 
						</div>
					</div>
					<div class="product-shop-right">
						<?php if (JFactory::getUser()->id > 0) { ?>
						<div class="lictact actions clear" style="float:right;">
							<div style="float:right; width:100%; height:30px; margin-bottom:10px; ">
								<center>
								<?php
								if ($this->show_prices == '1') {
									if ($product->prices['salesPrice']<=0 and VmConfig::get ('askprice', 1) and  !$product->images[0]->file_is_downloadable) {
										echo JText::_ ('COM_VIRTUEMART_PRODUCT_ASKPRICE');
									}
									else {
										$db = JFactory::getDbo();
										$query = $db->getQuery(true);
										$query->select('product_price');
										$query->from($db->quoteName('#__virtuemart_product_prices'));
										$query->where($db->quoteName('virtuemart_product_id')." = ".$db->quote($product->virtuemart_product_id));
										$query->where($db->quoteName('virtuemart_shoppergroup_id')." = 1");
										$db->setQuery($query);
										$row = $db->loadRow();
										
										if( $value=="PVP" ) {
											echo '<div class="clsalesPrice" style="font-size:1.2rem; display:inline;">'.JText::_ ('MOD_VIRTUEMART_PVP').': <span class="PricesalesPrice">' . number_format(round($row['0']*1.23, 2), 2) . ' €' . '</span></div>';
											echo '<div class="clPricesalesPrice" style="font-size:1.2rem; display:none;">'.JText::_ ('MOD_VIRTUEMART_PRICEV').': <span class="PricesalesPrice">' . number_format(round($product->prices["priceWithoutTax"], 2),2) . ' €' . '</span></div>';
										}
										else {
											echo '<div class="clsalesPrice" style="font-size:1.2rem; display:none;">'.JText::_ ('MOD_VIRTUEMART_PVP').': <span class="PricesalesPrice">' . number_format(round($row['0']*1.23, 2),2) . ' €' . '</span></div>';
											echo '<div class="clPricesalesPrice" style="font-size:1.2rem; display:inline;">'.JText::_ ('MOD_VIRTUEMART_PRICEV').': <span class="PricesalesPrice">' . number_format(round($product->prices["priceWithoutTax"], 2),2) . ' €' . '</span></div>';
										}
									}
								} 
								?>
								</center>
							</div>
							<div class="width100" style="float:right;">
								
								<?php // Add To Cart Button
								if (!VmConfig::get('use_as_catalog', 0) and !empty($product->prices)) {?>
								<div class="addtocart-area">
									<form method="post" class="product js-recalculate" action="index.php">
										<div class="addtocart-bar">
											<?php // Display the quantity box ?>
											<span class="quantity-box" style="margin-top:2px;">
												<input type="text" class="quantity-input js-recalculate" name="quantity[]" value="<?php if (isset($product->min_order_level) && (int)$product->min_order_level > 0) {
												echo $product->min_order_level;
												} else {
												echo '1';
												} ?>"/>
											</span>
											<span class="quantity-controls js-recalculate" style="margin-top:2px;">
												<input type="button" class="quantity-controls quantity-plus"/>
												<input type="button" class="quantity-controls quantity-minus"/>
											</span>
											<!-- Display the quantity box END -->

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
												<input name="<?php echo $button_name ?>" class="<?php echo $button_cls ?> button btn-cart list" value="<?php echo $button_lbl ?>" title="<?php echo $button_lbl ?>" style="float:right; margin-left:2%; width:79%;" type="submit" />
											<?php } ?>
											
											<div class="clear"> </div>
											</label>
										</div>

										<?php // Display the add to cart button END ?>
										<input class="pname" value="<?php echo $product->product_name ?>" type="hidden" />
										<input name="option" value="com_virtuemart" type="hidden" />
										<input name="view" value="cart" type="hidden" />
										<input name="virtuemart_product_id[]" value="<?php echo $product->virtuemart_product_id ?>" type="hidden" />
										<?php /** @todo Handle the manufacturer view */ ?>
										
										<input name="virtuemart_category_id[]" value="<?php echo $product->virtuemart_category_id ?>" type="hidden" />
									</form>
								</div>
								<?php }  // Add To Cart Button END ?>
							</div>
							<button type="button" title="<?php echo JText::_ ('MOD_VIRTUEMART_DETAILS'); ?>" class="button btn-cart list" style="width:100%; margin-top:5px;" onclick="javascript:location.href='<?php echo $product->link; ?>'">
								<span><?php echo JText::_ ('MOD_VIRTUEMART_DETAILS'); ?></span>
							</button>
						</div>
						<?php
						}
						else {
						?>
							<button type="button" title="<?php echo JText::_ ('MOD_VIRTUEMART_DETAILS'); ?>" class="button btn-cart list" style="width:100%; margin-top:20px;" onclick="javascript:location.href='<?php echo $product->link; ?>'">
								<span><?php echo JText::_ ('MOD_VIRTUEMART_DETAILS'); ?></span>
							</button>
							<button type="button" title="<?php echo JText::_ ('MOD_VIRTUEMART_LOGIN'); ?>" class="button btn-cart list" style="width:100%; margin-top:5px;" onclick="javascript:location.href='<?php echo JURI::base(); ?>index.php/<?php echo strtolower(JText::_ ('MOD_VIRTUEMART_LOGIN')); ?>'">
								<span><?php echo JText::_ ('MOD_VIRTUEMART_LOGIN'); ?></span>
							</button>
						<?php
						}
						?>
					</div>
				</div>
			</li>
			<?php
				if ( $even_odd == "even" ) 
					$even_odd = "odd";
				else 
					$even_odd = "even";
				}
			?>
		</ol>
		<script type="text/javascript">decorateList('products-list', 'none-recursive')</script>
		<?php
			}
			else if ( $view_type=="grid" ) {
		?>
		<ul class="products-grid first last odd">
			<?php
				// Category and Columns Counter
				$iBrowseCol = 1;
				$iBrowseProduct = 1;

				// Calculating Products Per Row
				$BrowseProducts_per_row = $this->perRow;
				$Browsecellwidth = ' width' . floor (100 / $BrowseProducts_per_row);

				// Separator
				$verticalseparator = " vertical-separator";
				$BrowseTotalProducts = count($this->products);

				// Start the Output
				foreach ($this->products as $product) {
			?>
			<?php
				if ($product->file_url == "images/stories/virtuemart/product/") {
					$prod_img = "images/logo_256_322.png";
				}
				else {
					$prod_img = $product->file_url;
				}
			?>
				<li class="item">
					<div class="item-inner">
						<div class="item-img">
							<div class="item-img-info">
								<a href="<?php echo $product->link; ?>" title="<?php echo $product->product_name ?>" class="product-image">
									<img src="<?php echo $prod_img; ?>" alt="<?php echo $product->product_name ?>">                 
								</a>
								<div class="item-box-hover">
									<div class="box-inner">
										<div class="product-detail-bnt">   
											<a data-fancybox-type="ajax" onclick="callQuickView('<?php echo JURI::base()?>quickview.php?id=<?php echo $product->virtuemart_product_id?>');" title="<?php echo JText::_ ('MOD_VIRTUEMART_QUICKVIEW'); ?>" class="button detail-bnt">
												<span><?php echo JText::_ ('MOD_VIRTUEMART_QUICKVIEW'); ?></span>
											</a>                    
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="item-info">
							<div class="info-inner">
								<div class="item-title">
									<a class="" href="<?php echo $product->link; ?>" title="<?php echo $product->product_s_desc; ?>"><?php echo $product->product_name ?></a>
								</div>
								<div class="item-content">
									<div class="ratings">
										<div class="rating-box">
											<div style="width:0%" class="rating"></div>
										</div>
									</div>
									<div class="item-price" style="margin-bottom:0px;">
										<?php
										if ($this->show_prices == '1' && JFactory::getUser()->id > 0) {
											if ($product->prices['salesPrice']<=0 and VmConfig::get ('askprice', 1) and  !$product->images[0]->file_is_downloadable) {
												echo JText::_ ('COM_VIRTUEMART_PRODUCT_ASKPRICE');
											}
											else {
												$db = JFactory::getDbo();
												$query = $db->getQuery(true);
												$query->select('product_price');
												$query->from($db->quoteName('#__virtuemart_product_prices'));
												$query->where($db->quoteName('virtuemart_product_id')." = ".$db->quote($product->virtuemart_product_id));
												$query->where($db->quoteName('virtuemart_shoppergroup_id')." = 1");
												$db->setQuery($query);
												$row = $db->loadRow();
												
												if( $value=="PVP" ) {
													echo '<div class="clsalesPrice" style="display:inline;">'.JText::_ ('MOD_VIRTUEMART_PVP').': <span class="PricesalesPrice">' . number_format(round($row['0']*1.23, 2),2) . ' €' . '</span></div>';
													echo '<div class="clPricesalesPrice" style="display:none;">'.JText::_ ('MOD_VIRTUEMART_PRICEV').': <span class="PricesalesPrice">' . number_format(round($product->prices["priceWithoutTax"], 2),2) . ' €' . '</span></div>';
												}
												else {
													echo '<div class="clsalesPrice" style="display:none;">'.JText::_ ('MOD_VIRTUEMART_PVP').': <span class="PricesalesPrice">' . number_format(round($row['0']*1.23, 2),2) . ' €' . '</span></div>';
													echo '<div class="clPricesalesPrice" style="display:inline;">'.JText::_ ('MOD_VIRTUEMART_PRICEV').': <span class="PricesalesPrice">' . number_format(round($product->prices["priceWithoutTax"], 2),2) . ' €' . '</span></div>';
												}
											}
										} 
										?>
									</div>
									
									<?php if (JFactory::getUser()->id > 0) { ?>
									<span class="stock_grid">
										<?php 
											$db = JFactory::getDbo();
											$query = $db->getQuery(true);
											$query->select('baixr');
											$query->from($db->quoteName('#__virtuemart_products'));
											$query->where($db->quoteName('virtuemart_product_id')." = ".$db->quote($product->virtuemart_product_id));
											$db->setQuery($query);
											$row = $db->loadRow();
											
											if( $row[0] == 1) {
												echo '<b>' . JText::_('STOCK_04') . '</b>';
											}
											else {
												if( $product->product_in_stock <= 0 ) {
													echo "<div id='circle1' class='stock_3'></div>" . JText::_('STOCK_03');
												}
												else if ( $product->product_in_stock < $product->low_stock_notification ) {
													echo "<div id='circle1' class='stock_2'></div>" . JText::_('STOCK_02');
												}
												else {
													echo "<div id='circle1' class='stock_1'></div>" . JText::_('STOCK_01');
												}
											}
										?>
									</span>
									<?php } ?> 
								</div>
							</div>
						</div>
						<div class="actions" style="margin-top:5px;">
							<span class="add-to-links">
							<button type="button" title="<?php echo JText::_ ('MOD_VIRTUEMART_DETAILS'); ?>" class="button btn-cart" onclick="javascript:location.href='<?php echo $product->link; ?>'"><span><?php echo JText::_ ('MOD_VIRTUEMART_DETAILS'); ?></span></button>          	
							</span>
						</div>
					</div>
				</li>
			<?php
				}
			?>
		</ul>
		<?php
			}
		?>
	</div>
	<div class="clear"></div>
	<div class="toolbar">
		<div class="pager" style="float:left;">
			<div class="pages">
				<?php echo $this->vmPagination->getPagesLinksol (); ?>
			</div>
		</div>
		<span style="float:right; margin-top:15px;"><?php echo $this->vmPagination->getPagesCounter (); ?></span>
		<div class="clear"></div>
	</div>

	<?php
} elseif (!empty($this->keyword)) {
	echo JText::_ ('COM_VIRTUEMART_NO_RESULT') . ($this->keyword ? ' : (' . $this->keyword . ')' : '');
}
?>
</div><!-- end browse-view -->