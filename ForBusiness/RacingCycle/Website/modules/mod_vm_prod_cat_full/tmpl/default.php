<?php // no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

/**
 * Outputs one level of categories and calls itself for any subcategories
 *
 * @access	public
 * @param int $catPId (the category_id of current parent category)
 * @param int $level (the current category level [main cats are 0, 1st subcats are 1])
 * @param object $params (the params object containing all params for this module)
 * @param int $current_cat (category_id from the request array, if it exists)
 * @return nothing - echos html directly
 **/
// Because this function is declared in the view, need to make sure it hasn't already been declared:

?>
<script>
function prepareList() {
  $('#expList').find('li:has(ul)')
  	.click( function(event) {
  		if (this == event.target) {
  			$(this).toggleClass('expanded');
  			$(this).children('ul').toggle('medium');
  		}
  		return false;
  	})
  	.addClass('collapsed')
  	.children('ul').hide();
  };
 
  $(document).ready( function() {
      prepareList();
  });
</script>
<?php

if ( ! function_exists( 'vmFCLBuildMenu' ) ) {
	function vmFCLBuildMenu($catPId = 0, $level = 1, $settings, $current_cat = 0, $active = array()) {
		if ( (!$settings['level_end'] || $level < $settings['level_end']) && $rows = modVMFullCategoryList::getCatChildren($catPId) ) {
			if ( $level >= $settings['level_start'] ) { ?>
				<ul id="expList" class="" style="width:100%; background:#e0e0e0; list-style-type: none; margin:0; padding:0;">
			<?php }
			foreach( $rows as $row ) {
				$cat_active = in_array( $row->virtuemart_category_id, $active );
				if ( $settings['current_filter'] && $level < count( $active ) && ! $cat_active )
					continue;
				
				if ( $level >= $settings['level_start'] ) {
					$itemid = modVMFullCategoryList::getVMItemId($row->virtuemart_category_id);
					$itemid = ($itemid ? '&Itemid='.$itemid : '');
					$link =	JFilterOutput::ampReplace( JRoute::_( 'index.php?option=com_virtuemart' . '&view=category&virtuemart_category_id=' . $row->virtuemart_category_id . $itemid ) );
					$pad_level = $level * 5;
					?>
					<li class="" style="margin:0; padding:0; background:<?php if($level % 2 == 0) echo "#0063AE"; else echo "#004984"; ?>; margin-bottom:1px;" <?php echo ' class=" '; if ( $cat_active ) echo 'active"'; else echo '""'; ?>>
						<a style="padding-left:<?php echo $pad_level."px"; ?>; " href="<?php echo $link ?>">
							<span class="gw-menu-text"><?php echo htmlspecialchars(stripslashes($row->category_name), ENT_COMPAT, 'UTF-8') ?></span>
							<b class="gw-arrow"></b>
						</a>
			<?php }

				// Check for sub categories
				vmFCLBuildMenu( $row->virtuemart_category_id, $level + 1, $settings, $current_cat, $active );
				if ($level >= $settings['level_start']) { ?>
				</li>
			<?php }
			}
			if ($level >= $settings['level_start']) { ?>
			</ul>
			<?php }
			}
	}
}

// With what category, if any, do we start?
// Default to cat filter param:
$catid = $cat_filter;
$level = 1;
// Set up current category array (for displaying '.active' class and for current category filter, if applicable)
$active = array();
if ( $current_cat ) {
	$active = modVMFullCategoryList::getCatParentIds( $current_cat );
	if ( $settings['current_filter'] ) {
		$catid = $current_cat;
		$level = count( $active );
		if ( $settings['level_start'] ) {
			// Adjust the starting point
			array_unshift( $active, 0 );
			$catid = $active[$settings['level_start']-1];
			$level = $settings['level_start'];
		}
	}
}
if ( $cat_filter && ! $settings['current_filter'] ) {
	$parents = modVMFullCategoryList::getCatParentIds( $cat_filter );
	$level = count( $parents );
}
// Call the display function for the first menu item:
vmFCLBuildMenu( $catid, $level, $settings, $current_cat, $active );
// Are there any better ways to make this follow joomla's MVC pattern
// (by outputting a tree structure returned by helper class, for ex)? like:
// while ($item) {
	// output
	// $item = $item->child;
//}
// Probably way out of the scope of this module...
// see mod_mainmenu if you don't believe it
?>
