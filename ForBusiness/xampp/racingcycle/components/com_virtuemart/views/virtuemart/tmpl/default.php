<?php
/**
*
* Description
*
* @package	VirtueMart
* @subpackage
* @author
* @link http://www.virtuemart.net
* @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* @version $Id: default.php 6461 2012-09-16 21:49:03Z Milbo $
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
JHTML::_( 'behavior.modal' );
if (!class_exists( 'VmConfig' )) require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart'.DS.'helpers'.DS.'config.php');
VmConfig::loadConfig();
if (!class_exists( 'VmModel' )) require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart'.DS.'helpers'.DS.'vmmodel.php');
?>

<?php # Vendor Store Description
if (!empty($this->vendor->vendor_store_desc) and VmConfig::get('show_store_desc', 1)) { ?>
<div class="vendor-store-desc">
	<?php echo $this->vendor->vendor_store_desc; ?>
</div>
<?php } ?>

<?php
	$db = JFactory::getDbo();
	$tipo = JRequest::getVar('viewtype');
	$query = $db->getQuery(true);
	$language = JFactory::getLanguage();
	
	$sql = "select A.virtuemart_category_id, A.category_name, A.slug, ifnull(E.file_url, '/images/logo_256_322.png') file_url ";
	$sql .= "
			from #__virtuemart_categories_".str_replace('-', '_', strtolower(strval($language->getTag())))." A
			inner join #__virtuemart_category_categories B on A.virtuemart_category_id = B.category_child_id
			inner join #__virtuemart_categories C on B.category_parent_id = C.virtuemart_category_id 
			left join d2e0b_virtuemart_category_medias D on A.virtuemart_category_id = D.virtuemart_category_id
			left join d2e0b_virtuemart_medias E on E.virtuemart_media_id = D.virtuemart_media_id
			";

	if( $tipo == "products" )
		$sql .= "where C.phc_ref = 'PRODUTOS'";
	else
		$sql .= "where C.phc_ref = 'MARCAS'";
	
	$sql .= "
		order by A.category_name
	";
	
	$db->setQuery($sql);  
	$result = $db->loadObjectList();
	
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
		foreach ($result as $category) {

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
			$caturl = "index.php/component/virtuemart/". $category->slug;

			// Show Category
			?>
			<div class="category floatleft<?php echo $category_cellwidth . $show_vertical_separator ?>">
				<div class="spacer">
					<h2>
						<a href="<?php echo $caturl ?>" title="<?php echo $category->category_name ?>">
							<?php echo $category->category_name ?>
							<br/>
							<?php // if ($category->ids) {
								echo '<img style="max-height:123px;" src="'.JURI::base().'/'.$category->file_url.'" alt="sta4818">';
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
	// Do we need a final closing row tag?
	if ($iCol != 1) {
		?>
		<div class="clear"></div>
	</div>
<?php } ?>
</div>

<?php
# load categories from front_categories if exist
if ($this->categories and VmConfig::get('show_categories', 1)) //echo $this->loadTemplate('categories');

# Show template for : topten,Featured, Latest Products if selected in config BE
if (!empty($this->products) ) { ?>
	<?php //echo $this->loadTemplate('products');
}

?>