<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

// define('CP_ROOT', dirname(__FILE__) .'/');
define('CP_ROOT', JPATH_BASE . DIRECTORY_SEPARATOR .'modules'. DIRECTORY_SEPARATOR .'mod_vm_cherry_picker/');

defined('CP_SINGLE_SELECT_MODE') or define('CP_SINGLE_SELECT_MODE', 0);
defined('CP_MULTI_SELECT_MODE') or define('CP_MULTI_SELECT_MODE', 1);
defined('CP_SHOW_SPECIFIC_PTS') or define('CP_SHOW_SPECIFIC_PTS', 2);

defined('CP_LAYOUT_SIMPLE_LIST') or define('CP_LAYOUT_SIMPLE_LIST', 0);
defined('CP_LAYOUT_CHECKBOX_LIST') or define('CP_LAYOUT_CHECKBOX_LIST', 1);
defined('CP_LAYOUT_DROPDOWN') or define('CP_LAYOUT_DROPDOWN', 2);
defined('CP_LAYOUT_SIMPLE_DROPDOWN') or define('CP_LAYOUT_SIMPLE_DROPDOWN', 3);

defined('CP_DONOT_SHOW_TITLE') or define('CP_DONOT_SHOW_TITLE', 0);
defined('CP_SHOW_DYNAMIC_TITLE') or define('CP_SHOW_DYNAMIC_TITLE', 1);

defined('CP_ANCHOR_TOP') or define('CP_ANCHOR_TOP', 0);
defined('CP_PRICE_TOP') or define('CP_PRICE_TOP', 0);
defined('CP_INCLUDE_PRODUCT_PRICE_ADJUSTMENT') or define('CP_INCLUDE_PRODUCT_PRICE_ADJUSTMENT', 1);
defined('CP_INCLUDE_MANUFACTURERS_PRICE_ADJUSTMENT') or define('CP_INCLUDE_MANUFACTURERS_PRICE_ADJUSTMENT', 2);


//define('PROD_COUNT_NOT_CALC', 0);
defined('PROD_COUNT_SHOW') or define('PROD_COUNT_SHOW', 2);

defined('CP_DEFAULT_PARAMETER') or define('CP_DEFAULT_PARAMETER', 0);
//define('CP_PARAMETER_ONE_SLIDER', 1);
defined('CP_TRACKBAR_ONE_KNOB_EXACT') or define('CP_TRACKBAR_ONE_KNOB_EXACT', 1);
defined('CP_TRACKBAR_ONE_KNOB_COMPARE') or define('CP_TRACKBAR_ONE_KNOB_COMPARE', 4);
//define('CP_PARAMETER_TWO_SLIDERS', 2);
defined('CP_TRACKBAR_TWO_KNOBS') or define('CP_TRACKBAR_TWO_KNOBS', 2);
defined('CP_COLOR_PALETTE_PARAMETER') or define('CP_COLOR_PALETTE_PARAMETER', 3);

defined('CP_SIMPLEDROPDOWN_DEFAULT') or define('CP_SIMPLEDROPDOWN_DEFAULT', 0);
defined('CP_SIMPLEDROPDOWN_SELFUPDATE') or define('CP_SIMPLEDROPDOWN_SELFUPDATE', 1);
defined('CP_SIMPLEDROPDOWN_PROGRESSIVE_LOAD') or define('CP_SIMPLEDROPDOWN_PROGRESSIVE_LOAD', 2);

defined('CP_HIDE_FILTERS_USING_SEEMORE') or define('CP_HIDE_FILTERS_USING_SEEMORE', 1);
defined('CP_HIDE_FILTERS_USING_SCROLL') or define('CP_HIDE_FILTERS_USING_SCROLL', 2);
defined('CP_PARAMETER_HIDING_GLOBAL') or define('CP_PARAMETER_HIDING_GLOBAL', 0);
defined('CP_PARAMETER_DO_NOT_HIDE') or define('CP_PARAMETER_DO_NOT_HIDE', 1);
defined('CP_PARAMETER_HIDE_USING_SEEMORE') or define('CP_PARAMETER_HIDE_USING_SEEMORE', 2);
defined('CP_PARAMETER_HIDE_USING_SCROLL') or define('CP_PARAMETER_HIDE_USING_SCROLL', 3);

defined('CP_COLLAPSE_GROUP_GLOBAL') or define('CP_COLLAPSE_GROUP_GLOBAL', 0);
defined('CP_COLLAPSE_GROUP_YES') or define('CP_COLLAPSE_GROUP_YES', 1);
defined('CP_COLLAPSE_GROUP_NO') or define('CP_COLLAPSE_GROUP_NO', 2);

defined('CP_URL_PRICES') or define('CP_URL_PRICES', 0x01);
defined('CP_URL_FILTERS') or define('CP_URL_FILTERS', 0x02);
defined('CP_URL_MANUFACTURERS') or define('CP_URL_MANUFACTURERS', 0x04);
defined('CP_URL_INSTOCK_FILTER') or define('CP_URL_INSTOCK_FILTER', 0x08);

defined('CP_MASK_PRICES') or define('CP_MASK_PRICES', 0x01);
defined('CP_MASK_FILTERS') or define('CP_MASK_FILTERS', 0x02);
defined('CP_MASK_MANUFACTURERS') or define('CP_MASK_MANUFACTURERS', 0x04);
defined('CP_MASK_INSTOCK_FILTER') or define('CP_MASK_INSTOCK_FILTER', 0x08);

defined('CP_JOINED_MANUFACTURERS') or define('CP_JOINED_MANUFACTURERS', 0x01);

$get_vmlang = JRequest::getVar('cp_vmlang', null);
$vmlang = (defined('VMLANG')) ? VMLANG : ($get_vmlang ? $get_vmlang : strtolower(JFactory::getLanguage()->getTag()));
$replaceChars = array("-", " ");
$vmlang = str_replace($replaceChars, "_", $vmlang);
defined('CP_VMLANG') or define('CP_VMLANG', $vmlang);


// define('CP_FETCH_FILTERS_AUTOMATICALLY', true);

?>
