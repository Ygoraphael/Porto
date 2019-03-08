<!DOCTYPE html>
<html lang="pt">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>RacingCycle</title>
	</head>
	<body class="cms-index-index">
		<div class="product-view">
			<?php
				// Set flag that this is a parent file
				define( '_JEXEC', 1 );
				define('JPATH_BASE', dirname(__FILE__) );
				define( 'DS', DIRECTORY_SEPARATOR );
				require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' );
				require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' );
				require('libraries/joomla/factory.php');

				$mainframe =& JFactory::getApplication('site');
				$mainframe->initialise();
				$language =& JFactory::getLanguage();

				$user =& JFactory::getUser();
				$user_id = $user->get('id');
				
				if (isset($_GET["id"])) {
					
					if( $prod_id = intval($_GET["id"]) ) {
						
						$db = JFactory::getDbo();
						$query = $db->getQuery(true);
						
						$query->select($db->quoteName(array('A.product_sku', 'B.product_s_desc', 'B.product_name', 'D.file_url', 'B.slug')));
						$query->from($db->quoteName('#__virtuemart_products', 'A'));
						$query->join('INNER', $db->quoteName("#__virtuemart_products_".str_replace('-', '_', strtolower(strval($language->getTag()))), 'B') . ' ON (' . $db->quoteName('A.virtuemart_product_id') . ' = ' . $db->quoteName('B.virtuemart_product_id') . ')');
						$query->join('LEFT', $db->quoteName('#__virtuemart_product_medias', 'C') . ' ON (' . $db->quoteName('A.virtuemart_product_id') . ' = ' . $db->quoteName('C.virtuemart_product_id') . ')');
						$query->join('LEFT', $db->quoteName('#__virtuemart_medias', 'D') . ' ON (' . $db->quoteName('C.virtuemart_media_id') . ' = ' . $db->quoteName('D.virtuemart_media_id') . ')');
						$query->where($db->quoteName('A.virtuemart_product_id') . ' = '. $db->quote($prod_id));
						
						$db->setQuery($query);
						$db->execute();
						$num_rows = $db->getNumRows();
						$result = $db->loadAssoc();
						
						if( $num_rows ) {
							$language->load('mod_virtuemart_product');
							$language->load('com_virtuemart');
							if (!class_exists( 'VmConfig' )) require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart'.DS.'helpers'.DS.'config.php');
							VmConfig::loadConfig();
							if (!class_exists( 'VmModel' )) require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart'.DS.'helpers'.DS.'vmmodel.php');
							$productModel = VmModel::getModel('Product');
							$product = $productModel->getProduct($prod_id);
							
							$NewPriceView = JRequest::getVar('NewPriceView', '');
							$inputCookie  = JFactory::getApplication()->input->cookie;
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
							
						?>
						<div class="product-essential products-list">
							<div class="product-img-box">
								<div class="product-image">
									<a href="<?php echo JURI::base().'index.php/component/virtuemart/'.$result["slug"].'-detail'?>" class="cloud-zoom" id="zoom2" rel="position: 'inside' , showTitle: false, adjustX:-4, adjustY:-4">
									<?php 
										if ($result["file_url"] == "") {
											$prod_img = "images/logo_256_322.png";
										}
										else {
											$prod_img = $result["file_url"];
										}
									?>
									<img itemprop="image" id="image" src="<?php echo JURI::base() . $prod_img; ?>" alt="<?php echo $result["product_name"]; ?>" title="<?php echo $result["product_name"]; ?>"></a> 
								</div>
								<!--product-image-->
								<script type="text/javascript">
									jQuery(document).ready(function() {
										jQuery('#more1').jcarousel({
											wrap: 'circular',
													scroll:1,
									itemFallbackDimension: 300
										});
									});
								</script>
							</div>
							<div class="product-shop">
								<div class="product-name">
									<h1 itemprop="name"><?php echo $result["product_name"]; ?></h1>
								</div>
								<table class="product-info">
									<tbody>
										<tr>
											<td><strong><?php echo JText::_('MOD_VIRTUEMART_SKU'); ?>:</strong></td>
											<td><?php echo $result["product_sku"]; ?></td>
										</tr>
										<?php
											if (JFactory::getUser()->id > 0) {
												if ($product->prices['salesPrice']<=0 and VmConfig::get ('askprice', 1) and  !$product->images[0]->file_is_downloadable) {
													echo JText::_ ('COM_VIRTUEMART_PRODUCT_ASKPRICE');
												}
												else {
													$query = $db->getQuery(true);
													$query->select('product_price');
													$query->from($db->quoteName('#__virtuemart_product_prices'));
													$query->where($db->quoteName('virtuemart_product_id')." = ".$db->quote($product->virtuemart_product_id));
													$query->where($db->quoteName('virtuemart_shoppergroup_id')." = 1");
													$db->setQuery($query);
													$row = $db->loadRow();
													
													if( $value=="PVP" ) {
													?>
														<tr><td><strong><?php echo JText::_('MOD_VIRTUEMART_PVP'); ?>:</strong></td><td><?php echo number_format(round($row['0']*1.23, 2), 2) . ' €'; ?></td></tr>
													<?php
													}
													else {
													?>
														<tr><td><strong><?php echo JText::_('MOD_VIRTUEMART_PRICEV'); ?>:</strong></td><td><?php echo number_format(round($product->prices["priceWithoutTax"], 2),2) . ' €'; ?></td></tr>
													<?php
													}
												}
											}
										?>
									</tbody>
								</table>
								<div class="short-description">
									<h2><?php echo JText::_ ('MOD_VIRTUEMART_QUICKOVERVIEW'); ?></h2>
									<p><?php echo $result["product_s_desc"]; ?></p>
								</div>
							</div>
						</div>
			<?php
						}
					}
				}
			?>
		</div>
	</body>
</html>