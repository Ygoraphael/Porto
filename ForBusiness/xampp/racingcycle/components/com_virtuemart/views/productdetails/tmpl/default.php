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

<div class="productdetails-view productdetails">

    <?php
    // Product Navigation
    if (VmConfig::get('product_navigation', 1)) {
	?>
        <div class="product-neighbours">
	    <?php
	    if (!empty($this->product->neighbours ['previous'][0])) {
		$prev_link = JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $this->product->neighbours ['previous'][0] ['virtuemart_product_id'] . '&virtuemart_category_id=' . $this->product->virtuemart_category_id, FALSE);
		echo JHTML::_('link', $prev_link, $this->product->neighbours ['previous'][0]
			['product_name'], array('rel'=>'prev', 'class' => 'previous-page'));
	    }
	    if (!empty($this->product->neighbours ['next'][0])) {
		$next_link = JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $this->product->neighbours ['next'][0] ['virtuemart_product_id'] . '&virtuemart_category_id=' . $this->product->virtuemart_category_id, FALSE);
		echo JHTML::_('link', $next_link, $this->product->neighbours ['next'][0] ['product_name'], array('rel'=>'next','class' => 'next-page'));
	    }
	    ?>
    	<div class="clear"></div>
        </div>
    <?php } // Product Navigation END
    ?>

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
    	<a href="<?php echo $catURL ?>" class="product-details" title="<?php echo $categoryName ?>"><?php echo JText::sprintf('COM_VIRTUEMART_CATEGORY_BACK_TO',$categoryName) ?></a>
	</div>

    <?php // Product Title   ?>
    <h1><?php //echo $this->product->product_name ?></h1>
    <?php // Product Title END   ?>

    <?php // afterDisplayTitle Event
    echo $this->product->event->afterDisplayTitle ?>

    <?php
    // Product Edit Link
    echo $this->edit_link;
    // Product Edit Link END
    ?>

    <?php
    // PDF - Print - Email Icon
    if (VmConfig::get('show_emailfriend') || VmConfig::get('show_printicon') || VmConfig::get('pdf_icon')) {
	?>
        <div class="icons">
	    <?php
	    //$link = (JVM_VERSION===1) ? 'index2.php' : 'index.php';
	    $link = 'index.php?tmpl=component&option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $this->product->virtuemart_product_id;

		echo $this->linkIcon($link . '&format=pdf', 'COM_VIRTUEMART_PDF', 'pdf_button', 'pdf_icon', false);
	    echo $this->linkIcon($link . '&print=1', 'COM_VIRTUEMART_PRINT', 'printButton', 'show_printicon');
	    echo $this->linkIcon($MailLink, 'COM_VIRTUEMART_EMAIL', 'emailButton', 'show_emailfriend', false,true,false,'class="recommened-to-friend"');
	    ?>
    	<div class="clear"></div>
        </div>
    <?php } // PDF - Print - Email Icon END
    ?>

    <?php
    // Product Short Description
    if (!empty($this->product->product_s_desc)) {
	?>
        <div class="product-short-description">
	    <?php
	    /** @todo Test if content plugins modify the product description */
	    //echo nl2br($this->product->product_s_desc);
	    ?>
        </div>
	<?php
    } // Product Short Description END


    if (!empty($this->product->customfieldsSorted['ontop'])) {
	$this->position = 'ontop';
	echo $this->loadTemplate('customfields');
    } // Product Custom ontop end
    ?>

    <div>
	<div class="width40 floatleft">
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
	
	<div class="width60 floatright">
		<h1 style="padding-left:10px;"><?php echo $this->product->product_name ?></h1>
	    <div class="spacer-buy-area product-view">
			<hr style="color:#ddd;" />
			<div class="short-description">
			 <h2><?php echo JText::_('MOD_VIRTUEMART_QUICKOVERVIEW'); ?></h2> 
			 <p><?php echo nl2br($this->product->product_s_desc); ?></p>
			</div>
			<table class="product-info">
				<tr><td><strong><?php echo strtoupper(JText::_('COM_VIRTUEMART_NC_REF')); ?>:</strong></td><td><?php echo $this->product->product_sku; ?></td></tr>
				<tr><td><strong><?php echo strtoupper(JText::_('COM_VIRTUEMART_NC_REF_MAN')); ?>:</strong></td><td><?php echo $result[0]->product_sku_for; ?></td></tr>
				<tr><td><strong><?php echo JText::_('COM_VIRTUEMART_NC_MARCA'); ?>:</strong></td><td><?php echo $result[0]->marca; ?></td></tr>
				<tr><td><strong><?php echo JText::_('COM_VIRTUEMART_NC_MODELO'); ?>:</strong></td><td><?php echo $result[0]->modelo; ?></td></tr>
				<tr><td><strong><?php echo JText::_('COM_VIRTUEMART_NC_PESO'); ?>:</strong></td><td><?php echo number_format($result[0]->product_weight, 1); ?> gr</td></tr>
				<tr><td><strong><?php echo JText::_('COM_VIRTUEMART_NC_UNIDADE'); ?>:</strong></td><td><?php echo $result[0]->product_unit; ?></td></tr>
				<tr><td><strong><?php echo JText::_('COM_VIRTUEMART_NC_URLFAB'); ?>:</strong></td><td><a href='http://www.<?php echo $result[0]->url4; ?>'><?php if(!empty( $result[0]->url4 )) echo 'www.'.$result[0]->url4; ?></a></td></tr>
				<tr><td><strong><?php echo JText::_('COM_VIRTUEMART_NC_URLART'); ?>:</strong></td><td><a href='http://www.<?php echo $result[0]->url1; ?>'><?php if(!empty( $result[0]->url1 )) echo 'www.'.$result[0]->url1; ?></a></td></tr>
				<tr><td><strong><?php echo JText::_('COM_VIRTUEMART_NC_URLSUPTEC'); ?>:</strong></td><td><a href='http://www.<?php echo $result[0]->url2; ?>'><?php if(!empty( $result[0]->url2 )) echo 'www.'.$result[0]->url2; ?></a></td></tr>
				<tr><td><strong><?php echo JText::_('COM_VIRTUEMART_NC_URLMONT'); ?>:</strong></td><td><a href='http://www.<?php echo $result[0]->url3; ?>'><?php if(!empty( $result[0]->url3 )) echo 'www.'.$result[0]->url3; ?></a></td></tr>
			</table>
		<?php
		// TODO in Multi-Vendor not needed at the moment and just would lead to confusion
		/* $link = JRoute::_('index2.php?option=com_virtuemart&view=virtuemart&task=vendorinfo&virtuemart_vendor_id='.$this->product->virtuemart_vendor_id);
		  $text = JText::_('COM_VIRTUEMART_VENDOR_FORM_INFO_LBL');
		  echo '<span class="bold">'. JText::_('COM_VIRTUEMART_PRODUCT_DETAILS_VENDOR_LBL'). '</span>'; ?><a class="modal" href="<?php echo $link ?>"><?php echo $text ?></a><br />
		 */
		?>
		<?php
		// Product Price
		    // the test is done in show_prices
		//if ($this->show_prices and (empty($this->product->images[0]) or $this->product->images[0]->file_is_downloadable == 0)) {
		    echo $this->loadTemplate('showprices');
		//}
		?>

		<?php
		// Add To Cart Button
// 			if (!empty($this->product->prices) and !empty($this->product->images[0]) and $this->product->images[0]->file_is_downloadable==0 ) {
//		if (!VmConfig::get('use_as_catalog', 0) and !empty($this->product->prices['salesPrice'])) {
		    echo $this->loadTemplate('addtocart');
//		}  // Add To Cart Button END
		?>

		<?php
		// Availability
		$stockhandle = VmConfig::get('stockhandle', 'none');
		$product_available_date = substr($this->product->product_available_date,0,10);
		$current_date = date("Y-m-d");
		if (($this->product->product_in_stock - $this->product->product_ordered) < 1) {
			if ($product_available_date != '0000-00-00' and $current_date < $product_available_date) {
			?>	<div class="availability">
					<?php echo JText::_('COM_VIRTUEMART_PRODUCT_AVAILABLE_DATE') .': '. JHTML::_('date', $this->product->product_available_date, JText::_('DATE_FORMAT_LC4')); ?>
				</div>
		    <?php
			} else if ($stockhandle == 'risetime' and VmConfig::get('rised_availability') and empty($this->product->product_availability)) {
			?>	<div class="availability">
			    <?php echo (file_exists(JPATH_BASE . DS . VmConfig::get('assets_general_path') . 'images/availability/' . VmConfig::get('rised_availability'))) ? JHTML::image(JURI::root() . VmConfig::get('assets_general_path') . 'images/availability/' . VmConfig::get('rised_availability', '7d.gif'), VmConfig::get('rised_availability', '7d.gif'), array('class' => 'availability')) : JText::_(VmConfig::get('rised_availability')); ?>
			</div>
		    <?php
			} else if (!empty($this->product->product_availability)) {
			?>
			<div class="availability">
			<?php echo (file_exists(JPATH_BASE . DS . VmConfig::get('assets_general_path') . 'images/availability/' . $this->product->product_availability)) ? JHTML::image(JURI::root() . VmConfig::get('assets_general_path') . 'images/availability/' . $this->product->product_availability, $this->product->product_availability, array('class' => 'availability')) : JText::_($this->product->product_availability); ?>
			</div>
			<?php
			}
		}
		else if ($product_available_date != '0000-00-00' and $current_date < $product_available_date) {
		?>	<div class="availability">
				<?php echo JText::_('COM_VIRTUEMART_PRODUCT_AVAILABLE_DATE') .': '. JHTML::_('date', $this->product->product_available_date, JText::_('DATE_FORMAT_LC4')); ?>
			</div>
		<?php
		}
		?>

		<?php
		// Ask a question about this product
		if (VmConfig::get('ask_question', 0) == 1) {
		?>
    		<div class="ask-a-question">
    		    <a class="ask-a-question" href="<?php echo $this->askquestion_url ?>" rel="nofollow" ><?php echo JText::_('COM_VIRTUEMART_PRODUCT_ENQUIRY_LBL') ?></a>
    		    <!--<a class="ask-a-question modal" rel="{handler: 'iframe', size: {x: 700, y: 550}}" href="<?php echo $this->askquestion_url ?>"><?php echo JText::_('COM_VIRTUEMART_PRODUCT_ENQUIRY_LBL') ?></a>-->
    		</div>
		<?php 
		}
		?>

		<?php
		// Manufacturer of the Product
		if (VmConfig::get('show_manufacturers', 1) && !empty($this->product->virtuemart_manufacturer_id)) {
		    echo $this->loadTemplate('manufacturer');
		}
		?>

	    </div>
	</div>
	<div class="clear"></div>
    </div>

	<div class="product-collateral">
		<div class="addtional-info" id="horizontalTab">
			<div class="tab-box">
				<ul class="product-tabs">
					<li id="product_tabs_description_tabbed" class="tabLink first activeLink"><a href="javascript:void(0)"><?php echo JText::_('COM_VIRTUEMART_NC_DESCPROD'); ?></a></li>
					<li id="product_tabs_alt_tabbed" class="tabLink"><a href="javascript:void(0)"><?php echo JText::_('COM_VIRTUEMART_NC_PECALT'); ?></a></li>
				</ul>
			</div>
			<div class="tabcontent" id="product_tabs_description_tabbed_contents">
				<div class="product-tabs-content-inner clearfix">
					<div class="std">
						<?php echo $this->product->product_desc; ?>
					</div>
				</div>
			</div>
			<div class="tabcontent" id="product_tabs_alt_tabbed_contents" style="display: none;">
				<div class="product-tabs-content-inner clearfix">
					<div class="box-collateral box-tags">
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
										A.published = 1 and A.product_sku in (".$result[0]->ref_alternativa.")";
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
								echo "<table class='product-rel'>";
								echo "<th></th><th>".JText::_('COM_VIRTUEMART_NC_REF')."</th><th>".JText::_('COM_VIRTUEMART_CART_NAME')."</th>";
								if (JFactory::getUser()->id > 0) {
									echo "<th>".JText::_('COM_VIRTUEMART_NC_PRICE')."</th><th>".JText::_('COM_VIRTUEMART_NC_PVP')."</th>";
								}
								foreach( $res_art as $artigo ) {
									echo "<tr onclick='".'window.location.href = "'.JURI::base().'index.php/component/virtuemart/'.$artigo->slug.'-detail"'."'>";
									echo "<td style='width:80px;'><img src='" . JURI::base() . $artigo->imagem . "' class='product-rel-img' alt='" . $artigo->product_name . "'></td>";
									echo "<td>" . $artigo->product_sku . "</td>";
									echo "<td>" . $artigo->product_name . "</td>";
									if (JFactory::getUser()->id > 0) {
										echo "<td>" . '€ ' . number_format($this->product->prices["priceWithoutTax"], 2) . "</td>";
										echo "<td>" . '€ ' . number_format(round($row['0']*1.23, 2), 2) . "</td>";
									}
									echo "</tr>";
								}
								echo "</table>";
							}
						?>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript">
			Varien.Tabs = Class.create();
			Varien.Tabs.prototype = {
			  initialize: function(selector) {
				var self=this;
				$$(selector+' a').each(this.initTab.bind(this));
			  },

			  initTab: function(el) {
				  el.href = 'javascript:void(0)';
				  if ($(el.parentNode).hasClassName('activeLink')) {
					this.showContent(el);
				  }
				  el.observe('click', this.showContent.bind(this, el));
			  },

			  showContent: function(a) {
				var li = $(a.parentNode), ul = $(li.parentNode);
				ul.select('li', 'ol').each(function(el){
				  var contents = $(el.id+'_contents');
				  if (el==li) {
					el.addClassName('activeLink');
					contents.show();
				  } else {
					el.removeClassName('activeLink');
					contents.hide();
				  }
				});
			  }
			}
			new Varien.Tabs('.product-tabs');
		</script>
	</div>
	<div class="box-additional"></div>
	
	<?php // event onContentBeforeDisplay
	echo $this->product->event->beforeDisplayContent;

    if (!empty($this->product->customfieldsSorted['normal'])) {
	$this->position = 'normal';
	echo $this->loadTemplate('customfields');
    } // Product custom_fields END
    // Product Packaging
    $product_packaging = '';
    if ($this->product->product_box) {
	?>
        <div class="product-box">
	    <?php
	        echo JText::_('COM_VIRTUEMART_PRODUCT_UNITS_IN_BOX') .$this->product->product_box;
	    ?>
        </div>
    <?php } // Product Packaging END
    ?>

    <?php
    // Product Files
    // foreach ($this->product->images as $fkey => $file) {
    // Todo add downloadable files again
    // if( $file->filesize > 0.5) $filesize_display = ' ('. number_format($file->filesize, 2,',','.')." MB)";
    // else $filesize_display = ' ('. number_format($file->filesize*1024, 2,',','.')." KB)";

    /* Show pdf in a new Window, other file types will be offered as download */
    // $target = stristr($file->file_mimetype, "pdf") ? "_blank" : "_self";
    // $link = JRoute::_('index.php?view=productdetails&task=getfile&virtuemart_media_id='.$file->virtuemart_media_id.'&virtuemart_product_id='.$this->product->virtuemart_product_id);
    // echo JHTMl::_('link', $link, $file->file_title.$filesize_display, array('target' => $target));
    // }
    if (!empty($this->product->customfieldsRelatedProducts)) {
	echo $this->loadTemplate('relatedproducts');
    } // Product customfieldsRelatedProducts END

    if (!empty($this->product->customfieldsRelatedCategories)) {
	echo $this->loadTemplate('relatedcategories');
    } // Product customfieldsRelatedCategories END
    // Show child categories
    if (VmConfig::get('showCategory', 1)) {
	echo $this->loadTemplate('showcategory');
    }
    if (!empty($this->product->customfieldsSorted['onbot'])) {
    	$this->position='onbot';
    	echo $this->loadTemplate('customfields');
    } // Product Custom ontop end
    ?>

<?php // onContentAfterDisplay event
echo $this->product->event->afterDisplayContent; ?>

<?php
echo $this->loadTemplate('reviews');

echo vmJsApi::writeJS();

?>
</div>
