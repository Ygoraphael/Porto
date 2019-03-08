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
jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');
class modVmQuickCartHelper{
	var $data 	= null;
	var $model 	= null;
	var $params = null;
	
	function __construct($params){
		global $module;
		JModel::addIncludePath(JPATH_VM_ADMINISTRATOR . DS . 'models');
		$model = JModel::getInstance('Product', 'VirtueMartModel');
		$this->model = $model;
		$this->params = $params;
		
		$this->_baseurl 			= str_replace('modules/mod_virtuemart_quickcart/', '', JURI::base());
		$this->_pathimg 			= str_replace('modules/mod_virtuemart_quickcart/', '', JURI::base()).'modules/'.$module->module.'/libraries/timthumb.php';
		$this->_dir					= JPATH::clean(JPATH_ROOT . '/cache/' .$module->module.'_'.$module->id.'/images');
		$this->_pathCacheImage		= str_replace('modules/mod_virtuemart_quickcart/', '', JURI::base()).'cache/'.$module->module.'_'.$module->id.'/images/';
	}
	function prepareAjaxData($cart){
		// Added for the zone shipment module
		//$vars["zone_qty"] = 0;
		$cart->prepareCartData(false);
		$weight_total = 0;
		$weight_subtotal = 0;
		//of course, some may argue that the $this->data->products should be generated in the view.html.php, but
		//
		if(empty($this->data)){
			$this->data = new stdClass();
		}
		$this->data->products = array();
		$this->data->totalProduct = 0;
		$i=0;
		//OSP when prices removed needed to format billTotal for AJAX
		if (!class_exists('CurrencyDisplay'))
			require(JPATH_VM_ADMINISTRATOR . DS . 'helpers' . DS . 'currencydisplay.php');
		$currency = CurrencyDisplay::getInstance();
		foreach ($cart->products as $priceKey=>$product){

			//$vars["zone_qty"] += $product["quantity"];
			$category_id = $cart->getCardCategoryId($product->virtuemart_product_id);
			//Create product URL
			$url = JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$category_id);

			// @todo Add variants
			$this->data->products[$i]['product_name'] = JHTML::link($url, $product->product_name);

			// Add the variants
			if (!is_numeric($priceKey)) {
				if(!class_exists('VirtueMartModelCustomfields'))require(JPATH_VM_ADMINISTRATOR.DS.'models'.DS.'customfields.php');
				//  custom product fields display for cart
				$this->data->products[$i]['product_attributes'] = VirtueMartModelCustomfields::CustomsFieldCartModDisplay($priceKey,$product);

			}
			$this->data->products[$i]['product_sku'] = $product->product_sku;

			//** @todo WEIGHT CALCULATION
			//$weight_subtotal = vmShipmentMethod::get_weight($product["virtuemart_product_id"]) * $product->quantity'];
			//$weight_total += $weight_subtotal;


			// product Price total for ajax cart
// 			$this->data->products[$i]['prices'] = $this->prices[$priceKey]['subtotal_with_tax'];
			$this->data->products[$i]['pricesUnformatted'] = $cart->pricesUnformatted[$priceKey]['subtotal_with_tax'];
			$this->data->products[$i]['prices'] = $currency->priceDisplay( $cart->pricesUnformatted[$priceKey]['subtotal_with_tax'] );

			// other possible option to use for display
			$this->data->products[$i]['subtotal'] = $cart->pricesUnformatted[$priceKey]['subtotal'];
			$this->data->products[$i]['subtotal_tax_amount'] = $cart->pricesUnformatted[$priceKey]['subtotal_tax_amount'];
			$this->data->products[$i]['subtotal_discount'] = $cart->pricesUnformatted[$priceKey]['subtotal_discount'];
			$this->data->products[$i]['subtotal_with_tax'] = $cart->pricesUnformatted[$priceKey]['subtotal_with_tax'];

			// UPDATE CART / DELETE FROM CART
			$this->data->products[$i]['quantity'] = $product->quantity;
			$this->data->totalProduct += $product->quantity ;
			
			$product_images = $this->model->getProduct($product->virtuemart_product_id, true, false,true,$product->quantity);
			$this->model->addImages($product_images,1);
			if( isset($product_images->images[0]->file_url) && $product_images->images[0]->file_url ){
				$this->data->products[$i]['image']		= $product_images->images[0]->file_url;
			}else{
				$this->data->products[$i]['image']		= 'modules/mod_virtuemart_quickcart/assets/images/demo.jpg';
			}
			$this->data->products[$i]['realimage']		= $this->createRealImage($this->data->products[$i],$this->params);
			$this->data->products[$i]['image']			= $this->_baseurl.$product_images->images[0]->file_url;
			
			$textcount									= $this->params->get('jl_limit_desc','100');
			$jl_readmore								= $this->params->get('jl_readmore','1');
			$titleMaxChars								= $this->params->get( 'title_max_chars', '100' );
			$replacer									= $this->params->get('replacer','...');
			$introtext									= strip_tags($product->product_s_desc);
			$url										= JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$product->virtuemart_category_id);
			if( $textcount ) {
				$this->data->products[$i]['desc']		= $this->cutstr($introtext,$textcount,$url,$jl_readmore);
			}
			$this->data->products[$i]['subtitle']		= $this->substring( $product->product_name, $titleMaxChars, $replacer );
			$this->data->products[$i]['url']			= $url;
			$this->data->products[$i]['cart_item_id']	= $priceKey;
			
			$i++;
		}
		$this->data->billTotal = $currency->priceDisplay( $cart->pricesUnformatted['billTotal'] );
		$this->data->dataValidated = $cart->_dataValidated ;
		return $this->data ;
	}
	function createRealImage($row,$params){
		global $module;
		if( !JFolder::exists($this->_dir) ){
			JFolder::create($this->_dir);
		}
		$fileurl = JFile::getName($this->_baseurl.$row['image']);
		JLImageHelper::createImage(JPath::clean(JPATH_ROOT.'/'.$row['image']), JPath::clean($this->_dir.'/'.$fileurl), $params->get('thumbwidth','75'), $params->get('thumbheight','61'));
		$result	= $this->_pathCacheImage.$fileurl;
		return $result;
	}
	function substring( $text, $length = 100, $replacer='...', $isAutoStripsTag = true ){
		$string =  $isAutoStripsTag?  strip_tags( $text ):$text;
		return JString::strlen( $string ) > $length ?  JHtml::_('string.truncate', $string, $length ): $string;
	}
	function cutStr($str,$limit,$link,$jl_readmore){
	    if(strlen($str)<=$limit){
			if( $jl_readmore ){
				$str.= "";
			}
	        return $str;
	    }
	    else{
	        if(strpos($str," ",$limit) > $limit){
	            $new_limit 	= strpos($str," ",$limit);
	            $new_str 	= substr($str,0,$new_limit);
	            return $new_str;
	        }
	        $new_str = substr($str,0,$limit);
	        return $new_str;
	    }
	}
}
?>