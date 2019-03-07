<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

$showPDescButton = FSConf::get('show_pdesc_button');
$showSKU = FSConf::get('show_sku');
$numberOfProductsOnPage = FSConf::get('products_num_on_page');
$showProductImage = FSConf::get('show_product_image');

$q = JRequest::getVar('q', null);
$skip = JRequest::getVar('skip', 0);
$showonpage = JRequest::getVar('showonpage', $numberOfProductsOnPage);
$urlptid = JRequest::getVar('ptid', null);
$ppid = JRequest::getVar('ppid', null);
$orderby = JRequest::getVar('orderby', 'cat');


?>
<div id="productDetailsList">
<table cellspacing="0" cellpadding="0" width="100%" id="fsProductListTable">
<?php

if ($orderby == 'cat') $current_category = -1;

if ($productsData) {
	foreach ($productsData as $i => $product) {

		if ($orderby == 'cat' && !$ppid && $current_category != $product['cid']) {
			$current_category = $product['cid'];
			echo '<tr><td colspan="3" class="fs-cell-catdelim">';
			echo ($product['category_name'])? $product['category_name'] : 'Without category';
			echo '</td></tr>';
		}

		$currentRow = 'r-'. $i;
		FSAssignFiltersView::setCurrentRow($currentRow);

?>
	<tr id="<?php echo $currentRow ?>-row" class="fs-row" data-row="<?php echo $currentRow ?>"
		data-ptid="<?php echo (isset($ptid)) ? $ptid : 'none' ?>">
		<td class="fs-cell-tick row-cell-border" align="center" valign="top" data-row="<?php echo $currentRow ?>">
			<div style="color:#AAAAAA;font-size:11px;"><?php echo ($skip + $i + 1) ."." ?></div>
			<div class="row-checkbox-img"> </div>
		</td>
		<td class="fs-cell-name row-cell-border" valign="top" data-row="<?php echo $currentRow ?>">
		<div class="ui-namecell-pid"><?php echo 'id: '. $product['pid'] ?></div>
<?php

	if ($product['published'] == 0) echo '<div class="ui-namecell-unpublish">unpublished</div>';

	if ($showPDescButton) {
?>
		<button type="button" id="<?php echo $currentRow ?>-pdesc" class="ui-namecell-pdesc"
			data-pid="<?php echo $product['pid'] ?>">i</button>
<?php
	}

	if ($ppid) {
		if ($ppid == $product['pid'])
			echo '<div class="ui-namecell-showchildren" data-pid="'. $product['pid'] .
				'" data-skip="'. $skip .'">&larr; Back</div>';
	} else if (FSAssignFiltersModel::product_has_children($product['pid']))
		echo '<div class="ui-namecell-showchildren" data-pid="'. $product['pid'] .
			'" data-skip="'. $skip .'">Parent</div>';

?>
	<div class="clear"></div>
<?php

if ($showProductImage) {
	if ($product['thumb_image'])
		echo '<img src="'. FS_BASE_URL . $product['thumb_image'] .
			'" class="ui-namecell-product-image" data-pid="'. $product['pid'] .'" />';
	else if ($product['image'])
		echo '<img src="'. FS_BASE_URL . $product['image'] .
			'" class="ui-namecell-product-image" data-pid="'. $product['pid'] .'" />';
}

?>
	<div class="ui-namecell-name<?php if ($product['published'] == 0) echo ' grayed' ?>">
<?php

	// sanitize search keyword
	if ($q) {
		$remove = array("(", ")");
		$q = str_replace($remove, "", $q);
	}

	if ($q) {
		echo preg_replace("/($q)/i", '<b>$1</b>', $product['product_name']);
	} else {
		echo $product['product_name'];
	}

	// show SKU
	if ($showSKU) {
		echo '<div class="ui-namecell-sku">';
		if ($q) {
			echo preg_replace("/($q)/i", '<b>$1</b>', $product['product_sku']);
		} else {
			echo $product['product_sku'];
		}
		echo '</div>';
	}

?>
	</div></td>
	<td id="<?php echo $currentRow ?>-filters-cell" valign="top" class="fs-cell-params row-cell-border">
		<form name="<?php echo $currentRow ?>-form">
			<input type="hidden" name="i" value="ASSIGN" />
			<input type="hidden" name="pid" value="<?php echo $product['pid'] ?>" />
			<input type="hidden" name="row" value="<?php echo $currentRow ?>" />
			<input type="hidden" name="urlptid" value="<?php echo $urlptid ?>" />
			<div id="<?php echo $currentRow ?>-dynamic-container" style="padding:0 0 0 5px">
<?php

$rowsExpanded = false;
$outerContExpandedClass = '';
$curtainExpandedClass = '';
if (isset($_COOKIE['rows-expanded']) && $_COOKIE['rows-expanded']) {
	$rowsExpanded = true;
	$outerContExpandedClass = ' expanded';
	$curtainExpandedClass = ' hid';
}

$tabs = '<div class="product-types-tabs" id="ptTabs_'. $currentRow .'" data-row="'. $currentRow .'">';

$cont = '<div class="pt-cont-outer'. $outerContExpandedClass .'"><div class="pt-cont-inner" id="ptContInner_'. $currentRow .'">';


if ($assignedFilters = $product['assigned_filters']) {

	$tabSelected = ($urlptid) ? '' : ' pt-tab-selected';
	$tabs .= '<span class="pt-tab'. $tabSelected .'" data-contid="all">All</span>';

	foreach ($assignedFilters as $i => $pt) {
		$ptid = $pt['ptid'];
		$ptName = FSAssignFiltersModel::getProductTypeName($ptid);
		$recordId = $pt['id'];
		$ptUniqueId = $ptid .'_'. $recordId;

		$tabSelected = ($urlptid && $urlptid == $ptid) ? ' pt-tab-selected' : '';

		$tabs .= '<span class="pt-tab'. $tabSelected .'" id="tab_ptCont_'. $ptUniqueId .'" data-contid="ptCont_'.
			$ptUniqueId .'">'. $ptName .'</span>';
	}

	$cont .= self::getProductFilterData($assignedFilters);

} else {

	$newPTUniqueId = 'ptNew_'. self::getNextNewProductTypeIndex();
	$tabs .= '<span class="pt-tab" data-contid="all">All</span>'.
		'<span class="pt-tab pt-tab-selected" id="tab_ptCont_'. $newPTUniqueId .'" data-contid="ptCont_'.
		$newPTUniqueId .'">[New Product Type]</span>';

	$cont .= self::getProductTypesSelectContainer();

}

$tabs .= '<span class="pt-tab-addnew">Add New</span></div>';

$cont .= '<div class="pt-curtain'. $curtainExpandedClass .'"></div></div>';

echo $tabs;

echo $cont;

?>
			</div>
		</form>
	</td>
</tr>
<?php

	} // end for foreach

} else	{
	$urlcid = JRequest::getVar('cid', null);
	echo '<div style="margin:10px 0;text-align:center;font:italic 14px Tahoma, Arial;">No products</div>';

	if (!$urlcid && !$urlptid && !$q) {
		echo '<div style="margin:15px 0 0;text-align:center;font:14px Arial;">';
		echo '<div>Most likely you need to specify Virtuemart\'s Language Suffix in Fast Seller Options.';
		echo ' <a href="http://www.galt.md/index.php?option=com_blog&a=88&Itemid=84" '.
			'style="text-decoration:underline;color:blue">Follow this guide.</a>';
		echo '</div></div>';
	}
}


?>
</table>
<div id="blanket" class="blanket hid"></div>
</div>

<div id="filterSelectMenu" class="hid">
	<ul id="filterInputBox" class="filter-input-box">
	<!--	<li class="filter-input-box-elem"><span class="filter-input-box-filter" title="Click to remove">filter1</span></li> -->
		<li class="filter-input-box-elem fib-input"><input type="text" id="filterInputBoxInput" autocomplete="off" style="width:25px" /></li>
	</ul>
	<div id="filterParameterLabel"></div>
	<div id="availableFilters"></div>
</div>

<div id="productTypeSelectMenu" class="hid">
<?php

$ptsData = FSAssignFiltersModel::getAvailableProductTypes();

if ($ptsData) {
	$perColumn = 7;
	$current = 0;
	echo '<ul class="pt-select-menu-list">';
	foreach ($ptsData as $ptData) {
		if ($current != 0 && $current % $perColumn == 0) echo '</ul><ul class="pt-select-menu-list">';
		echo '<li class="pt-select-menu-list-elem" data-ptid="'. $ptData['id'] .'">'. $ptData['name'] .'</li>';
		$current++;
	}
	echo '</ul>';
} else {
	echo '<div style="padding:10px 20px;font:italic 12px Arial">You need to create Product Types first. '.
		'Go to <b>Create Filters</b> tab.</div>';
}

?>
</div>

<div id="productTypeRemoveMenu" class="hid">
	<div>
	<button id="pt-remove-confirm">Delete</button>
	<button id="pt-remove-cancel">Cancel</button>
	</div>
	<div style="text-align:center;padding:5px 0 0;"><div class="pt-remove-menu-arrow"></div></div>
</div>
<?php

	if ($showPDescButton) {
?>
<div id="product-description" class="popwindow hid">
	<div id="pdesc-draghandle">Product Details</div>
	<div id="product-description-inner"><div class="pdesc-preload">
		<img src="<?php echo FS_URL ?>static/img/desc-loader.gif" width="28" height="28" border="0" /></div></div>
	<div style="background-color:#F7F7F7;border-top:1px solid #5EAD2E;text-align:right;">
		<button type="button" class="pdesc-popup-close-button">Close</button>
		<div id="pdesc-resizehandle"></div>
	</div>
</div>
<?php

	}

?>
