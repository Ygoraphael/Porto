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

// FIX BEGIN: Load the categories in Top Level Category

if (!empty($this->category) && $this->category->virtuemart_category_id == 0 && empty($this->category->children))
{
	$categoryModel = VmModel::getModel('category');
	$this->category->children = $categoryModel->getChildCategoryList(1, $this->category->virtuemart_category_id, $categoryModel->getDefaultOrdering(), $categoryModel->_selectedOrderingDir);
	$this->category->haschildren = !empty($this->category->children);
}

// FIX END

//limpa cache
$conf = JFactory::getConfig();
$options = array(
	'defaultgroup' => 'com_virtuemart_cats',
	'cachebase' => $conf->get('cache_path', JPATH_SITE . '/cache'));

$cache = JCache::getInstance('callback', $options);
$cache->clean();

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
		$categories_per_row = 6; //VmConfig::get ('categories_per_row', 3);
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

					<?php
				}

				if($category->images[0]->file_url != 'images/stories/virtuemart/category/') {
					$imagem_cat = $category->images[0]->file_url;
				}
				else {
					$imagem_cat = $category->images[0]->file_url . "images/stories/virtuemart/vendor/logotipo.png";

				}

				// this is an indicator wether a row needs to be opened or not
				if ($iCol == 1) {
					?>
			<div class="row">
			<?php
				}

				// Show the vertical seperator
			 //	if ($iCategory == $categories_per_row or $iCategory % $categories_per_row == 0) {
			//		$show_vertical_separator = ' ';
			//	} else {
			//	$show_vertical_separator = $verticalseparator;
			//	}

				// Category Link
				$caturl = JRoute::_ ('index.php?option=com_virtuemart&view=category&virtuemart_category_id=' . $category->virtuemart_category_id, FALSE);
				// Show Category
				?>
				<div class="category floatleft <?php echo $category_cellwidth . $show_vertical_separator ?>">
					<div class="spacer">
						<h2>
							<a href="<?php echo $caturl ?>" title="<?php echo $category->category_name ?>">
								<?php echo $category->category_name ?>
								<br/>
								<img src="<?php echo $imagem_cat ?>" width="150" height="200" />
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
		//if ($iCol != 1) {
			?>
			<div class="clear"></div>
		</div>
	<?php // } ?>
	</div>

	<?php
	}
}
?>
