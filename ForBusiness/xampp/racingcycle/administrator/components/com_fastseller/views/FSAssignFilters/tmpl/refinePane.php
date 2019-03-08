<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

$cid= (int)JRequest::getVar('cid', null);
$ptid = JRequest::getVar('ptid', null);

// this will be executed only when browser fully reloaded
if ($cid) {
	$categoryName = FSAssignFiltersModel::getCategoryName($cid);
	$categoryNameForButton = self::squeeze($categoryName, 18);
	$categoryNameForMenuTitle = self::squeeze($categoryName, 21);
}

if ($ptid) {
	if ($ptid == 'wopt') {
		$ptNameForButton = 'w/o Product Type';
		$ptNameForMenuTitle = 'w/o Product Type';
	} else {
		$ptName = FSAssignFiltersModel::getProductTypeName($ptid);
		$ptNameForButton = self::squeeze($ptName, 18);
		$ptNameForMenuTitle = self::squeeze($ptName, 21);
	}
}

$orderby = JRequest::getVar('orderby','cat');
$scending = JRequest::getVar('sc','Asc');

$rowsExpanded = (isset($_COOKIE['rows-expanded'])) ? $_COOKIE['rows-expanded'] : 0;

?>
<div id="notificationBox" class="hid"></div>
<div id="refinePane">
	<button type="button" id="refinePaneMutliSelectButton"
			class="refine-pane-button multi-select-control-button"
			data="select-groups-menu">
		<div class="ui-select-groups-img" id="selGrpImg" style="vertical-align:top;"> </div>
		<div  class="down-arrow" style="margin-top:4px"> </div>
	</button>
	<div id="refinePaneMutliSelectMenu" class="refine-pane-simple-menu hid" style="padding:3px 0;">
		<div class="rps-menu-element" data-select="all">All</div>
		<div class="rps-menu-element" data-select="none">None</div>
		<div class="rps-menu-element" data-select="wpt">w/ PT</div>
		<div class="rps-menu-element" data-select="wopt">w/o PT</div>
	</div>

	<button id="refinePaneCategoriesButton"
			class="refine-pane-button cat-refine-btn"
			type="button"
			data="showcat-menu"
			data-branchid="category-branch">
		<span style="line-height:16px;"><?php echo ($cid) ? $categoryNameForButton : 'Category' ?></span>
		<div class="down-arrow"> </div>
	</button>

	<div id="refinePaneCategoriesMenu" class="popmenu hid">
		<div id="cat-mhead"><span><?php echo ($cid) ? $categoryNameForMenuTitle : 'Category';?></span>
			<span id="removeCategorySelection" class="remove<?php echo ($cid) ? '' : ' hid' ?>"
					data-catid="" data-catname="Category"> -
				<span style="border-bottom:1px dashed #444444;">remove</span>
			</span>
		</div>
		<div id="category-branch"><div id="category-branch-loader" class="hid" style="padding:15px 0;" align="center">
			<img src="<?php echo FS_URL ?>static/img/ajax-loader.gif" width="16" height="11" /></div>
		</div>
		<div width="100%" style="border-top:1px solid #BBBBBB;margin:3px 5px 8px;padding:3px 5px 0;">
			<span class="help" onclick="$('cat-help-content').toggleClass('hid');">Help and Tips</span>
			<div id="cat-help-content" class="hid" style="padding-top:5px;">
				&rsaquo; Click <b>Go</b> to choose a category.
				<br/>&rsaquo; Click on a Category name to expand it's children.
				<br/>&rsaquo;
				<span class="grayed">Unpublished</span> categories marked in light gray color.
			</div>
		</div>
	</div>

	<button id="refinePaneProductTypesButton" class="refine-pane-button pt-refine-btn" type="button" data="showpt-menu">
		<span style="line-height:16px;"><?php echo ($ptid) ? $ptNameForButton : 'Product Type' ?></span>
		<div class="down-arrow"> </div>
	</button>

	<div id="refinePaneProductTypesMenu" class="popmenu hid">
		<div id="pt-mhead"><span><?php echo ($ptid) ? $ptNameForMenuTitle : 'Product Type' ?></span>
			<span id="removeProductTypeSelection" class="remove<?php echo ($ptid) ? '' : ' hid' ?>"
					data-ptid=""
					data-ptname="Product Type"> -
				<span style="border-bottom:1px dashed #444444;">remove</span></span>
		</div>
		<div id="product-type-branch"><div style="padding:15px 0;" align="center">
			<img src="<?php echo FS_URL ?>static/img/ajax-loader.gif" width="16" height="11" /></div>
		</div>

	</div>


	<button id="refinePaneOrderByButton"
			class="refine-pane-button orderby-btn"
			data="orderby-menu"
			type="button">Order By
		<div class="down-arrow-sm"> </div>
	</button>
	<div id="refinePaneOrderByMenu" class="refine-pane-simple-menu hid" style="padding:3px 0;">
		<div class="rps-menu-element" data-order="cat">Category<?php if ($orderby == 'cat') echo '*' ?></div>
		<div class="rps-menu-element" data-order="pname">Product name<?php if ($orderby == 'pname') echo '*' ?></div>
		<div class="rps-menu-element" data-order="pid">Product ID<?php if ($orderby == 'pid') echo '*' ?></div>
		<div class="rps-menu-element" data-order="ptid">Product Type ID<?php if ($orderby == 'ptid') echo '*' ?></div>
	</div>

	<button id="refinePaneAscDescButton" type="button" class="refine-pane-button orderby-sc-btn"
		title="Current ordering: <?php echo $scending ?>"><?php echo $scending ?>
	</button>

	<button id="refinePaneDeletePTFromSelected"
			class="refine-pane-button delete-pt-from-selected-button hid"
			type="button">Delete Product Types from selected products
	</button>
	<div id="refinePaneDeletePTFromSelectedMenu" class="refine-pane-simple-menu hid" style="padding:3px 0">
	</div>

	<button id="refinePaneExpandCollapseButton" type="button" class="refine-pane-button expand-collapse-all-btn"
		title="Expand or Collapse all Rows" data-expanded="<?php echo $rowsExpanded ?>">
		<?php echo ($rowsExpanded) ? 'Collapse' : 'Expand' ?> </button>

	<br clear="all" />
</div>
