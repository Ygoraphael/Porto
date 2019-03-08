<?php
/**
 *
 * Show the product details page
 *
 * @package	VirtueMart
 * @subpackage
 * @author Max Milbers, Eugen Stranz
 * @author RolandD,
 * @todo handle child products
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: default.php 6530 2012-10-12 09:40:36Z alatak $
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

/* Let's see if we found the product */
if (empty($this->product)) {
	echo JText::_('COM_VIRTUEMART_PRODUCT_NOT_FOUND');
	echo '<br /><br />  ' . $this->continue_link_html;
	return;
}

if(JRequest::getInt('print',false)){
?>
<body onload="javascript:print();">
<?php }

// addon for joomla modal Box
JHTML::_('behavior.modal');

$MailLink = 'index.php?option=com_virtuemart&view=productdetails&task=recommend&virtuemart_product_id=' . $this->product->virtuemart_product_id . '&virtuemart_category_id=' . $this->product->virtuemart_category_id . '&tmpl=component';

$boxFuncReco = '';
$boxFuncAsk = '';
if(VmConfig::get('usefancy',1)){
	vmJsApi::js( 'fancybox/jquery.fancybox-1.3.4.pack');
	vmJsApi::css('jquery.fancybox-1.3.4');
	if(VmConfig::get('show_emailfriend',0)){
		$boxReco = "jQuery.fancybox({
				href: '" . $MailLink . "',
				type: 'iframe',
				height: '550'
			});";
	}
	if(VmConfig::get('ask_question', 0)){
		$boxAsk = "jQuery.fancybox({
				href: '" . $this->askquestion_url . "',
				type: 'iframe',
				height: '550'
			});";
	}

} else {
	vmJsApi::js( 'facebox' );
	vmJsApi::css( 'facebox' );
	if(VmConfig::get('show_emailfriend',0)){
		$boxReco = "jQuery.facebox({
				iframe: '" . $MailLink . "',
				rev: 'iframe|550|550'
			});";
	}
	if(VmConfig::get('ask_question', 0)){
		$boxAsk = "jQuery.facebox({
				iframe: '" . $this->askquestion_url . "',
				rev: 'iframe|550|550'
			});";
	}
}
if(VmConfig::get('show_emailfriend',0) ){
	$boxFuncReco = "jQuery('a.recommened-to-friend').click( function(){
					".$boxReco."
			return false ;
		});";
}
if(VmConfig::get('ask_question', 0)){
	$boxFuncAsk = "jQuery('a.ask-a-question').click( function(){
					".$boxAsk."
			return false ;
		});";
}

if(!empty($boxFuncAsk) or !empty($boxFuncReco)){
	$document = JFactory::getDocument();
	$document->addScriptDeclaration("
//<![CDATA[
	jQuery(document).ready(function($) {
		".$boxFuncReco."
		".$boxFuncAsk."
	/*	$('.additional-images a').mouseover(function() {
			var himg = this.href ;
			var extension=himg.substring(himg.lastIndexOf('.')+1);
			if (extension =='png' || extension =='jpg' || extension =='gif') {
				$('.main-image img').attr('src',himg );
			}
			console.log(extension)
		});*/
	});
//]]>
");
}


?>

<div class="col-lg-3 col-xs-12 prod-details-img">
	<?php
		echo $this->loadTemplate('images');
		$language =& JFactory::getLanguage();
		$language->load('mod_virtuemart_product');

		$db = JFactory::getDbo();
		$sql = "select 
					A.*, 
					B.*
				from #__virtuemart_products A 
					inner join #__virtuemart_products_".str_replace('-', '_', strtolower(strval($language->getTag())))." B on A.virtuemart_product_id = B.virtuemart_product_id 
				where 
					A.published = 1 and A.virtuemart_product_id = " . $this->product->virtuemart_product_id;
		
		$db->setQuery($sql);  
		$result = $db->loadObjectList();
	?>
</div>
<div class="col-lg-9 col-xs-12  prod-details-grid">
	<div class="productdetails-view productdetails">
		<?php // Back To Category Button
		if ($this->product->virtuemart_category_id) {
			$catURL =  JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id='.$this->product->virtuemart_category_id, FALSE);
			$categoryName = $this->product->category_name ;
		} else {
			$catURL =  JRoute::_('index.php?option=com_virtuemart');
			$categoryName = jText::_('COM_VIRTUEMART_SHOP_HOME') ;
		}
		?>
		<div class="back-to-category">
			<a href="<?php echo $catURL ?>" class="button" title="<?php echo $categoryName ?>"><?php echo JText::sprintf('COM_VIRTUEMART_CATEGORY_BACK_TO',$categoryName) ?></a>
		</div>
	</div>
	<div class="pull-left" style="padding-left:10px; padding-top:45px; width:80%; color:#6A6668; font-size:1.5em;"><b><?php echo $this->product->product_name ?></b></div>
	<div class="pull-right" style="width:20%;"></div>
	<div class="<?php echo $button_cls ?> pull-left top-price" style="width:100%; min-height:5px; height:auto; background-image: url(images/bg-button4.png); background-size: cover; background-repeat: no-repeat; background-position: center center;">
	</div>
	<div class="clearfix"> </div>
	<div class="col-lg-12 prod-details-desc">
		<?php echo $this->product->product_desc; ?>
	</div>
	<div class="clearfix"> </div>
	<div class="col-lg-3 prod-details-grid1 nopadding data-grid-nresp">
		<div class="list-group panel-default">
			<a class="list-group-item panel-heading"><?php echo strtoupper(JText::_('COM_VIRTUEMART_NC_REF')); ?>:</a>
			<a class="list-group-item list-group-item-a"><?php echo JText::_('COM_VIRTUEMART_NC_MODELO'); ?>:</a>
			<a class="list-group-item panel-heading"><?php echo JText::_('COM_VIRTUEMART_NC_PESO'); ?>:</a>
			<a class="list-group-item list-group-item-a"><?php echo JText::_('COM_VIRTUEMART_NC_URLSUPTEC'); ?>:</a>
			<a class="list-group-item panel-heading"><?php echo JText::_('COM_VIRTUEMART_NC_URLMONT'); ?>:</a>
		</div>
	</div>
	<div class="col-lg-9 prod-details-grid1 nopadding data-grid-nresp">
		<div class="list-group panel-default">
			<a class="list-group-item panel-heading"><?php echo $this->product->product_sku; ?></a>
			<a class="list-group-item list-group-item-a"><?php echo $result[0]->modelo; ?></a>
			<a class="list-group-item panel-heading"><?php echo number_format($result[0]->product_weight, 1); ?> gr</a>
			<a <?php if(!empty( $result[0]->url2 )) echo 'href="www.'.$result[0]->url2.'"'; ?> class="list-group-item list-group-item-a"><?php if(!empty( $result[0]->url2 )) echo 'www.'.$result[0]->url2; ?></a>
			<a <?php if(!empty( $result[0]->url3 )) echo 'href="www.'.$result[0]->url3.'"'; ?> class="list-group-item panel-heading"><?php if(!empty( $result[0]->url3 )) echo 'www.'.$result[0]->url3; ?></a>
		</div>
	</div>
	<div class="col-lg-12 prod-details-grid1 nopadding data-grid-resp">
		<div class="list-group panel-default">
			<a class="list-group-item panel-heading"><?php echo strtoupper(JText::_('COM_VIRTUEMART_NC_REF')); ?>:</a>
			<a class="list-group-item "><?php echo $this->product->product_sku; ?></a>
			<a class="list-group-item list-group-item-a panel-heading"><?php echo JText::_('COM_VIRTUEMART_NC_MODELO'); ?>:</a>
			<a class="list-group-item list-group-item-a"><?php echo $result[0]->modelo; ?></a>
			<a class="list-group-item panel-heading"><?php echo JText::_('COM_VIRTUEMART_NC_PESO'); ?>:</a>
			<a class="list-group-item"><?php echo number_format($result[0]->product_weight, 1); ?> gr</a>
			<a class="list-group-item list-group-item-a  panel-heading"><?php echo JText::_('COM_VIRTUEMART_NC_URLSUPTEC'); ?>:</a>
			<a <?php if(!empty( $result[0]->url2 )) echo 'href="www.'.$result[0]->url2.'"'; ?> class="list-group-item list-group-item-a"><?php if(!empty( $result[0]->url2 )) echo 'www.'.$result[0]->url2; ?></a>
			<a class="list-group-item panel-heading"><?php echo JText::_('COM_VIRTUEMART_NC_URLMONT'); ?>:</a>
			<a <?php if(!empty( $result[0]->url3 )) echo 'href="www.'.$result[0]->url3.'"'; ?> class="list-group-item"><?php if(!empty( $result[0]->url3 )) echo 'www.'.$result[0]->url3; ?></a>
		</div>
	</div>
	<div class="clearfix"></div>
	<?php echo $this->loadTemplate('showprices'); ?>
	<?php echo $this->loadTemplate('addtocart');?>
	<div class="col-lg-3 col-xs-12 col-sm-4 pull-right nopadding">
		<script>
			jQuery(document).ready(function() {
				jQuery(".top-price").css("margin-top", jQuery(".product-price").height() / 4);
			});
		</script>
	</div>
</div>
<div class="breadrumb col-lg-12">
	<span class="ftype02"><b><?php echo JText::_('COM_VIRTUEMART_NC_PECALT'); ?></b></span>
</div>
<div class="col-lg-12 sug-prod clearfix">
	<?php 
		$sql = "select 
					A.*, 
					B.*,
					C.*,
					D.*,
					IFNULL( D.file_url, 'images/stories/virtuemart/product/error_150.jpg' ) imagem
				from #__virtuemart_products A 
					inner join #__virtuemart_products_".str_replace('-', '_', strtolower(strval($language->getTag())))." B on A.virtuemart_product_id = B.virtuemart_product_id 
					left join #__virtuemart_product_medias C on A.virtuemart_product_id = C.virtuemart_product_id 
					left join #__virtuemart_medias D on C.virtuemart_media_id = D.virtuemart_media_id 
				where 
					A.published = 1 and A.product_sku in (".$result[0]->ref_alternativa.") and C.ordering = 0";
		
		
		$db->setQuery($sql);  
		$res_art = $db->loadObjectList();
		
		$query = $db->getQuery(true);
		$query->select('a.product_price, b.iva1incl');
		$query->from($db->quoteName('#__virtuemart_product_prices', 'a'));
		$query->join('INNER', $db->quoteName('#__virtuemart_products', 'b') . ' ON (' . $db->quoteName('a.virtuemart_product_id') . ' = ' . $db->quoteName('b.virtuemart_product_id') . ')');
		$query->where($db->quoteName('a.virtuemart_product_id')." = ".$db->quote($this->product->virtuemart_product_id));
		$query->where($db->quoteName('a.virtuemart_shoppergroup_id')." = 1");
		$db->setQuery($query);
		$row = $db->loadRow();
		
		if( sizeof($res_art) ) {
			foreach( $res_art as $artigo ) {
			?>
			<div class="col-lg-6 col-xs-12 sug-prod-item">
				<div class="col-lg-4 col-xs-12 col-sm-12 prod-item">
					<div class="col-lg-12 col-xs-12 prod-img-item" onmouseenter="$(this).addClass('hover')" onmouseleave="$(this).removeClass('hover')">
						<img src="<?php echo JURI::base() . $artigo->imagem?>" />
						<div class="prod-img-overlay">
							<a href="#" class="expand">+</a>
						</div>
					</div>
				</div>
				<div class="col-lg-8 col-xs-12 sug-prod-desc">
					<div class="col-lg-12 col-xs-12 catinfo-main-item">
						<a class="catinfo-item">
							<div class="maininfo-item"><?php echo $artigo->product_sku . ' - ' . $artigo->product_name; ?></div>
							<div class="maininfopplus-item"><center><i class="fa fa-cart-plus" aria-hidden="true"></i></center></div>
						</a>
					</div>
					<div class="col-lg-12 col-xs-12 prod-details-desc">
						<?php 
							echo $artigo->product_desc; 
							if (JFactory::getUser()->id > 0) {
								echo '€ ' . number_format($this->product->prices["priceWithoutTax"], 2); 
								echo '€ ' . number_format(round($row['0']*1.23, 2), 2); 
							}
							?>
					</div>
					<div class="col-lg-12 col-xs-12">
						<a href="<?php echo JURI::base().'index.php/component/virtuemart/'.$artigo->slug.'-detail'; ?>">+ ver mais</a>
					</div>
				</div>
			</div>
			<?php
			}
		}
	?>
</div>

<?php
	echo vmJsApi::writeJS();
?>
