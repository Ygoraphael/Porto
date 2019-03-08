<?php
/**
 * @version		$Id: $
 * @author		Codextension
 * @package		Joomla!
 * @subpackage	Module
 * @copyright	Copyright (C) 2008 - 2012 by Codextension. All rights reserved.
 * @license		GNU/GPL, see LICENSE
 */
defined('_JEXEC') or  die( 'Direct Access to '.basename(__FILE__).' is not allowed.' );

// move mvm_quickcart_ajax.php to root website
if( !JFile::exists(JPATH_SITE.DS.'mvm_quickcart_ajax.php') ){
	JFile::move(dirname(__FILE__).DS.'mvm_quickcart_ajax.php', JPATH_SITE.DS.'mvm_quickcart_ajax.php');
}

$GLOBALS['module'] = $module;
require_once (dirname(__FILE__).DS.'libraries'.DS.'images.php');
require_once (dirname(__FILE__) . DS . 'helper.php');

$jsVars  = ' jQuery(document).ready(function(){
	jQuery(".vmCartModule").productUpdate();

});' ;

if (!class_exists( 'VmConfig' )) require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart'.DS.'helpers'.DS.'config.php');

if(!class_exists('VirtueMartCart')) require(JPATH_VM_SITE.DS.'helpers'.DS.'cart.php');
$cart = VirtueMartCart::getCart(false);
//$data = $cart->prepareAjaxData();
$modVmQuickCartHelper  	= new modVmQuickCartHelper($params);
$data 					= $modVmQuickCartHelper->prepareAjaxData($cart);

$lang = JFactory::getLanguage();
$extension = 'com_virtuemart';
$lang->load($extension);//  when AJAX it needs to be loaded manually here >> in case you are outside virtuemart !!!
if ($data->totalProduct>1) $data->totalProductTxt = JText::sprintf('COM_VIRTUEMART_CART_X_PRODUCTS', $data->totalProduct);
else if ($data->totalProduct == 1) $data->totalProductTxt = JText::_('COM_VIRTUEMART_CART_ONE_PRODUCT');
else $data->totalProductTxt = JText::_('COM_VIRTUEMART_EMPTY_CART');
if (false && $data->dataValidated == true) {
	$taskRoute = '&task=confirm';
	$linkName = JText::_('COM_VIRTUEMART_CART_CONFIRM');
} else {
	$taskRoute = '';
	$linkName = JText::_('COM_VIRTUEMART_CART_SHOW');
}
$useSSL = VmConfig::get('useSSL',0);
$useXHTML = true;
$data->cart_show = '<a class="gray_btn" href="'.JRoute::_("index.php?option=com_virtuemart&view=cart".$taskRoute,$useXHTML,$useSSL).'">'.$linkName.'</a>';
$data->billTotal = $data->billTotal;

JHTML::_('behavior.modal');
vmJsApi::jPrice();
vmJsApi::cssSite();
$document = JFactory::getDocument();
//$document->addScriptDeclaration($jsVars);

$document->addScript(JUri::base().'modules/mod_virtuemart_quickcart/assets/jquery.mCustomScrollbar.js');
$document->addScript(JUri::base().'modules/mod_virtuemart_quickcart/assets/jlscript.js');
$document->addStyleSheet(JUri::base().'modules/mod_virtuemart_quickcart/assets/jlstyle.css');
$document->addStyleSheet(JUri::base().'modules/mod_virtuemart_quickcart/assets/jquery.mCustomScrollbar.css');

$moduleclass_sfx 	= $params->get('moduleclass_sfx', '');
$show_price 		= (bool)$params->get( 'show_price', '1' ); // Display the Product Price?
$show_product_list 	= (bool)$params->get( 'show_product_list', '1' ); // Display the Product Price?
$show_imgs 			= (bool)$params->get( 'show_imgs', '1' );
$show_title			= (bool)$params->get( 'show_title', '1' );
$show_attr			= (bool)$params->get( 'show_attr', '1' );
$show_desc			= (bool)$params->get( 'show_desc', '1' );
$widthdropdown		= (float)$params->get( 'widthdropdown', '420' );
$show_scrollbar		= (bool)$params->get( 'show_scrollbar', '1' );
$height_scrollbar	= (float)$params->get( 'height_scrollbar', '250' );

$document->addScriptDeclaration('var mvmquickcart = "'.$module->id.'";var show_scrollbar="'.$show_scrollbar.'";var height_scrollbar="'.$height_scrollbar.'";');
if(!$show_scrollbar){
	$height_scrollbar = 'auto';
}else{
	$height_scrollbar = $height_scrollbar.'px';
}
$target_window		= (float)$params->get( 'target_window', '1' );
if( $target_window ){
	$target_window ='target="_blank"';
}else{
	$target_window ='';
}

require(JModuleHelper::getLayoutPath($module->module));
 ?>
