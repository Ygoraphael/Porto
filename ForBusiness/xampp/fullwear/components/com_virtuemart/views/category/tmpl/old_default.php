<?php
/**
 *
 * Show the products in a category
 *
 * @package    VirtueMart
 * @subpackage
 * @author RolandD
 * @author Max Milbers
 * @todo add pagination
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: default.php 6556 2012-10-17 18:15:30Z kkmediaproduction $
 */


// Check to ensure this file is included in Joomla!
defined ('_JEXEC') or die('Restricted access');
JHTML::_ ('behavior.modal');
/* javascript for list Slide
  Only here for the order list
  can be changed by the template maker
*/
$js = "
jQuery(document).ready(function () {
	jQuery('.orderlistcontainer').hover(
		function() { jQuery(this).find('.orderlist').stop().show()},
		function() { jQuery(this).find('.orderlist').stop().hide()}
	)
});
";

$document = JFactory::getDocument ();
$document->addScriptDeclaration ($js);

if (empty($this->keyword) and !empty($this->category)) {
	?>
<div class="category_description">
	<?php echo $this->category->category_description; ?>
</div>
<?php
}

/* Show child categories */

if (VmConfig::get ('showCategory', 1) and empty($this->keyword)) {
	if (!empty($this->category->haschildren)) {

		// Category and Columns Counter
		$iCol = 1;
		$iCategory = 1;

		// Calculating Categories Per Row
		$categories_per_row = VmConfig::get ('categories_per_row', 3);
		$category_cellwidth = ' width' . floor (100 / $categories_per_row);

		// Separator
		$verticalseparator = " vertical-separator";
		?>

		<div class="category-view">

		<?php // Start the Output
		if (!empty($this->category->children)) {

			foreach ($this->category->children as $category) {

				// Show the horizontal seperator
				if ($iCol == 1 && $iCategory > $categories_per_row) {
					?>
					<div class="horizontal-separator"></div>
					<?php
				}

				// this is an indicator wether a row needs to be opened or not
				if ($iCol == 1) {
					?>
			<div class="row">
			<?php
				}

				// Show the vertical seperator
				if ($iCategory == $categories_per_row or $iCategory % $categories_per_row == 0) {
					$show_vertical_separator = ' ';
				} else {
					$show_vertical_separator = $verticalseparator;
				}

				// Category Link
				$caturl = JRoute::_ ('index.php?option=com_virtuemart&view=category&virtuemart_category_id=' . $category->virtuemart_category_id, FALSE);

				// Show Category
				?>
				<div class="category floatleft<?php echo $category_cellwidth . $show_vertical_separator ?>">
					<div class="spacer">
						<h2>
							<a href="<?php echo $caturl ?>" title="<?php echo $category->category_name ?>">
								<?php echo $category->category_name ?>
								<br/>
								<?php // if ($category->ids) {
								echo $category->images[0]->displayMediaThumb ("", FALSE);
								//} ?>
							</a>
						</h2>
					</div>
				</div>
				<?php
				$iCategory++;

				// Do we need to close the current row now?
				if ($iCol == $categories_per_row) {
					?>
					<div class="clear"></div>
		</div>
			<?php
					$iCol = 1;
				} else {
					$iCol++;
				}
			}
		}
		// Do we need a final closing row tag?
		if ($iCol != 1) {
			?>
			<div class="clear"></div>
		</div>
	<?php } ?>
	</div>

	<?php
	}
}
?>
<div class="browse-view">
<?php

if (!empty($this->keyword)) {
	?>
<h3><?php echo $this->keyword; ?></h3>
	<?php
} ?>
<?php if (!empty($this->keyword)) {

	$category_id  = JRequest::getInt ('virtuemart_category_id', 0); ?>
<form action="<?php echo JRoute::_ ('index.php?option=com_virtuemart&view=category&limitstart=0', FALSE); ?>" method="get">

	<!--BEGIN Search Box -->
	<div class="virtuemart_search">
		<?php echo $this->searchcustom ?>
		<br/>
		<?php echo $this->searchcustomvalues ?>
		<input name="keyword" class="inputbox" type="text" size="20" value="<?php echo $this->keyword ?>"/>
		<input type="submit" value="<?php echo JText::_ ('COM_VIRTUEMART_SEARCH') ?>" class="button" onclick="this.form.keyword.focus();"/>
	</div>
	<input type="hidden" name="search" value="true"/>
	<input type="hidden" name="view" value="category"/>
	<input type="hidden" name="option" value="com_virtuemart"/>
	<input type="hidden" name="virtuemart_category_id" value="<?php echo $category_id; ?>"/>

</form>
<!-- End Search Box -->
	<?php } ?>

<?php // Show child categories
if (!empty($this->products)) {
	?>
<div class="orderby-displaynumber">
	<div class="width70 floatleft">
		<?php echo $this->orderByList['orderby']; ?>
		<?php echo $this->orderByList['manufacturer']; ?>
	</div>
	<div class="width30 floatright display-number"><?php echo $this->vmPagination->getResultsCounter ();?><br/><?php echo $this->vmPagination->getLimitBox ($this->category->limit_list_step); ?></div>
	<div class="vm-pagination">
		<?php echo $this->vmPagination->getPagesLinks (); ?>
		<span style="float:right"><?php echo $this->vmPagination->getPagesCounter (); ?></span>
	</div>

	<div class="clear"></div>
</div> <!-- end of orderby-displaynumber -->

<h1><?php echo $this->category->category_name; ?></h1>

	<?php
	// Category and Columns Counter
	$iBrowseCol = 1;
	$iBrowseProduct = 1;

	// Calculating Products Per Row
	$BrowseProducts_per_row = 4;
	$Browsecellwidth = ' width' . floor (100 / $BrowseProducts_per_row);

	// Separator
	$verticalseparator = " vertical-separator";

	$BrowseTotalProducts = count($this->products);

	// Start the Output
	foreach ($this->products as $product) {

		// Show the horizontal seperator
		if ($iBrowseCol == 1 && $iBrowseProduct > $BrowseProducts_per_row) {
			?>
		<div class="horizontal-separator"></div>
			<?php
		}

		// this is an indicator wether a row needs to be opened or not
		if ($iBrowseCol == 1) {
			?>
	<div class="row">
	<?php
		}

		// Show the vertical seperator
		if ($iBrowseProduct == $BrowseProducts_per_row or $iBrowseProduct % $BrowseProducts_per_row == 0) {
			$show_vertical_separator = ' ';
		} else {
			$show_vertical_separator = $verticalseparator;
		}

		// Show Products
		?>
		<div class="product floatleft <?php echo $show_vertical_separator ?> product_detail_item">
			<a href="<?php echo $product->link; ?>" title="<?php echo $product->product_name ?>" class="product-image"><img src="<?php echo $product->images[0]->file_url; ?>" width="150" height="150" alt="<?php echo $product->product_name ?>"></a>
			<h2 class="product-name"><a href="<?php echo $product->link; ?>" title="<?php echo $product->product_name ?>"><?php echo $product->product_name ?></a></h2>
			<div class="price-box">
				<p class="special-price">
					<span class="price" id="product-price-1197"><?php echo number_format($product->prices["basePrice"],2); ?>&nbsp;€</span>
				</p>
			</div>
			<div class="actions">
				<button onclick="location.href='<?php echo $product->link; ?>'" type="button" class="button btn-cart" data-original-title="<?php echo JText::_ ('COM_VIRTUEMART_PRODUCT_DETAILS'); ?>" rel="tooltip"><span><span><?php echo JText::_ ('COM_VIRTUEMART_PRODUCT_DETAILS'); ?></span></span></button>
			</div>
		</div>
		<!-- end of product -->
		<?php

		// Do we need to close the current row now?
		if ($iBrowseCol == $BrowseProducts_per_row || $iBrowseProduct == $BrowseTotalProducts) {
			?>
			<div class="clear"></div>
   </div> <!-- end of row -->
			<?php
			$iBrowseCol = 1;
		} else {
			$iBrowseCol++;
		}

		$iBrowseProduct++;
	} // end of foreach ( $this->products as $product )
	// Do we need a final closing row tag?
	if ($iBrowseCol != 1) {
		?>
	<div class="clear"></div>

		<?php
	}
	?>

<div class="vm-pagination"><?php echo $this->vmPagination->getPagesLinks (); ?><span style="float:right"><?php echo $this->vmPagination->getPagesCounter (); ?></span></div>

	<?php
} elseif (!empty($this->keyword)) {
	echo JText::_ ('COM_VIRTUEMART_NO_RESULT') . ($this->keyword ? ' : (' . $this->keyword . ')' : '');
}
?>
</div><!-- end browse-view -->