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
?>
<div class="product-price" id="productPrice<?php echo $this->product->virtuemart_product_id ?>">
	<?php

	$inputCookie  = JFactory::getApplication()->input->cookie;
	$value        = $inputCookie->get($name = 'DefaultPriceView', $defaultValue = null);
	$cookieExists = !($value === null);
	
	if ($this->product->prices['salesPrice']<=0 and VmConfig::get ('askprice', 1) and isset($this->product->images[0]) and !$this->product->images[0]->file_is_downloadable) {
		?>
		<a class="ask-a-question bold" href="<?php echo $this->askquestion_url ?>" rel="nofollow" ><?php echo JText::_ ('COM_VIRTUEMART_PRODUCT_ASKPRICE') ?></a>
		<?php
	}
	else {
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('a.product_price, b.iva1incl');
		$query->from($db->quoteName('#__virtuemart_product_prices', 'a'));
		$query->join('INNER', $db->quoteName('#__virtuemart_products', 'b') . ' ON (' . $db->quoteName('a.virtuemart_product_id') . ' = ' . $db->quoteName('b.virtuemart_product_id') . ')');
		$query->where($db->quoteName('a.virtuemart_product_id')." = ".$db->quote($this->product->virtuemart_product_id));
		$query->where($db->quoteName('a.virtuemart_shoppergroup_id')." = 1");
		$db->setQuery($query);
		
		$row = $db->loadRow();
		
		if (JFactory::getUser()->id > 0) {
			echo '
				<div class="clsalesPrice top_price" style="font-size:1.2rem;">
					<span class="PricesalesPrice_pd">€ ' . number_format($this->product->prices["priceWithoutTax"], 2) . '</span>
					<span class="PricesalesPrice_min_pd">' . JText::_('COM_VIRTUEMART_NC_PRECSIVA') . '</span>
				</div>';
			
			echo '<hr/>';
			if( $row['1'] == '1' )
				echo '<div class="clsalesPrice" style="font-size:1.2rem;"><span class="PricesalesPrice_pd">€ ' . number_format(round($row['0'], 2), 2) . ' ' . JText::_('COM_VIRTUEMART_NC_PVP') . '</span></div>';
			else
				echo '<div class="clsalesPrice" style="font-size:1.2rem;"><span class="PricesalesPrice_pd">€ ' . number_format(round($row['0']*1.23, 2), 2) . ' ' . JText::_('COM_VIRTUEMART_NC_PVP') . '</span></div>';
		}
	}
	?>
</div>
