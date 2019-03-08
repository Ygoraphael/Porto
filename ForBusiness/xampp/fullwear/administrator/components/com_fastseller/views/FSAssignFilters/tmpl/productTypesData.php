<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

$currentRow = self::getCurrentRow();
$newPTUniqueId = 'ptNew_'. self::getCurrentNewProductTypeIndex();

//$tabs = '<div class="product-types-tabs" id="ptTabs_'. $currentRow .'" data-row="'. $currentRow .'">'.
//	'<span class="pt-tab" data-ptuniqueid="all">All</span>'.
//	'<span class="pt-tab pt-tab-selected" data-ptuniqueid="'. $newPTUniqueId .'">[New Product Type]</span>'.
//	'<span class="pt-tab-addnew">Add New</span></div>';

//$cont = '<div class="pt-cont-outer"><div class="pt-cont-inner" id="ptContInner_'. $currentRow .'">'.
$cont =	'<div class="pt-container" id="ptCont_'. $newPTUniqueId .'">';

$cont .= '<div class="ptnew-container">';
$cont .= '<button type="button" class="pt-select-button" data-row="'. $currentRow .'">Select Product Type</button>';
$cont .= '</div>';

$cont .= '</div>';



//echo $tabs;

//echo $cont;




?>