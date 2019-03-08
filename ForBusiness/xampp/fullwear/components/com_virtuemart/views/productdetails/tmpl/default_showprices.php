<?php
/**
 *
 * Show the product details page
 *
 * @package    VirtueMart
 * @subpackage
 * @author Max Milbers, Valerie Isaksen
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: default_showprices.php 6556 2012-10-17 18:15:30Z kkmediaproduction $
 */
// Check to ensure this file is included in Joomla!
defined ('_JEXEC') or die('Restricted access');

$language =& JFactory::getLanguage();
$language->load('mod_virtuemart_product');

$db = JFactory::getDbo();
$sql = "";

$sql .= "	select A.virtuemart_product_id, B.product_name, B.product_s_desc, B.slug, A.desconto, A.novidade, ";
$sql .= "	ifnull(( select file_url from e506s_virtuemart_product_medias C inner join e506s_virtuemart_medias D on C.virtuemart_media_id = D.virtuemart_media_id where C.virtuemart_product_id = A.virtuemart_product_id limit 1), 'images/stories/virtuemart/product/logotipo.png') file_url, ";
$sql .= "	C.Modalidade, C.Genero, C.Linha, C.Categoria";
$sql .= "	from e506s_virtuemart_products A ";
$sql .= "		inner join e506s_virtuemart_products_".str_replace('-', '_', strtolower(strval($language->getTag())))." B on A.virtuemart_product_id = B.virtuemart_product_id ";
$sql .= "		inner join e506s_fastseller_product_type_4 C on A.virtuemart_product_id = C.product_id ";
$sql .= "	where A.virtuemart_product_id = ".$this->product->virtuemart_product_id;

$db->setQuery($sql);  
$result = $db->loadObjectList();
$desconto = $result[0]->desconto;

$sql = "select calc_value from e506s_virtuemart_calcs where virtuemart_calc_id = 1";

$db->setQuery($sql); 
$db->execute();
$num_rows = $db->getNumRows();		
$field_prod = $db->loadRowList();

if( $num_rows > 0 ) {
	$taxa_iva = $field_prod[0][0];
}
else {
	$taxa_iva = 0;
}

?>
<div align='center' class="product-price" id="productPrice<?php echo $this->product->virtuemart_product_id ?>">
	<?php
	if (!empty($this->product->prices['salesPrice'])) {
		//echo "<strong>" . JText::_ ('COM_VIRTUEMART_CART_PRICE') . "</strong>";
	}

	//echo "<strong>" . JText::_ ('COM_VIRTUEMART_CART_PRICE') . "</strong>";
	
	if ($this->product->prices['salesPrice']<=0 and VmConfig::get ('askprice', 1) and isset($this->product->images[0]) and !$this->product->images[0]->file_is_downloadable) {
		?>
		<a class="ask-a-question bold" href="<?php echo $this->askquestion_url ?>" rel="nofollow" ><?php echo JText::_ ('COM_VIRTUEMART_PRODUCT_ASKPRICE') ?></a>
		<?php
	} else {
	if ($this->showBasePrice) {
		//echo $this->currency->createPriceDiv ('basePrice', 'COM_VIRTUEMART_PRODUCT_BASEPRICE', $this->product->prices);
		if (round($this->product->prices['basePrice'],$this->currency->_priceConfig['basePriceVariant'][1]) != $this->product->prices['basePriceVariant']) {
			//echo $this->currency->createPriceDiv ('basePriceVariant', 'COM_VIRTUEMART_PRODUCT_BASEPRICE_VARIANT', $this->product->prices);
		}
	}
	//echo $this->currency->createPriceDiv ('variantModification', 'COM_VIRTUEMART_PRODUCT_VARIANT_MOD', $this->product->prices);
	if (round($this->product->prices['basePriceWithTax'],$this->currency->_priceConfig['salesPrice'][1]) != $this->product->prices['salesPrice']) {
		//echo '<span class="price-crossed" >' . $this->currency->createPriceDiv ('basePriceWithTax', 'COM_VIRTUEMART_PRODUCT_BASEPRICE_WITHTAX', $this->product->prices) . "</span>";
	}
	if (round($this->product->prices['salesPriceWithDiscount'],$this->currency->_priceConfig['salesPrice'][1]) != $this->product->prices['salesPrice']) {
		//echo $this->currency->createPriceDiv ('salesPriceWithDiscount', 'COM_VIRTUEMART_PRODUCT_SALESPRICE_WITH_DISCOUNT', $this->product->prices);
	}
	//echo $this->currency->createPriceDiv ('salesPrice', 'COM_VIRTUEMART_PRODUCT_SALESPRICE', $this->product->prices);
	if ($this->product->prices['discountedPriceWithoutTax'] != $this->product->prices['priceWithoutTax']) {
		//echo $this->currency->createPriceDiv ('discountedPriceWithoutTax', 'COM_VIRTUEMART_PRODUCT_SALESPRICE_WITHOUT_TAX', $this->product->prices);
	} else {
		//echo $this->currency->createPriceDiv ('priceWithoutTax', 'COM_VIRTUEMART_PRODUCT_SALESPRICE_WITHOUT_TAX', $this->product->prices);
	}
	//echo $this->currency->createPriceDiv ('discountAmount', 'COM_VIRTUEMART_PRODUCT_DISCOUNT_AMOUNT', $this->product->prices);
	//echo $this->currency->createPriceDiv ('taxAmount', 'COM_VIRTUEMART_PRODUCT_TAX_AMOUNT', $this->product->prices);
	//$unitPriceDescription = JText::sprintf ('COM_VIRTUEMART_PRODUCT_UNITPRICE', JText::_('COM_VIRTUEMART_UNIT_SYMBOL_'.$this->product->product_unit));
	//echo $this->currency->createPriceDiv ('unitPrice', $unitPriceDescription, $this->product->prices);
	
		echo "<div>";
		if ( $desconto > 0 ) { ?>
			<span class="discount-ras"><strike><?php echo str_replace('.', ',', number_format(($this->product->prices["discountedPriceWithoutTax"]/(1-$desconto/100))*(1+($taxa_iva/100)), 2)); ?> €</strike></span>
		<?php
		}
		echo "<a class='PriceProdDet'>".str_replace('.', ',', number_format(($this->product->prices["discountedPriceWithoutTax"])*(1+($taxa_iva/100)),2))." €</a></div>";
		}
	?>
</div>
