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
	$categoryModel->addImages($this->category->children, 1);
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
		$categories_per_row = 4;//VmConfig::get ('categories_per_row', 3);
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

				if($category->images[0]->file_url != 'images/stories/virtuemart/category/') {
					$imagem_cat = $category->images[0]->file_url;
				}
				else {
					$imagem_cat = $category->images[0]->file_url . "logotipo.png";
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

<div class="SearchBarTop">
	<div class="SearchRes">
	<?php
	if (!empty($this->keyword)) {
	?>
		<?php echo JText::_ ('COM_VIRTUEMART_SEARCH_TEXT') ?> <b><?php echo $this->keyword; ?></b>
	<?php
	} ?>
	</div>
</div>

<div class="browse-view">

<?php if (!empty($this->keyword) and 0) {

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
$language =& JFactory::getLanguage();
$db = JFactory::getDbo();

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

		if($product->images[0]->file_url != 'images/stories/virtuemart/product/') {
			$imagem = $product->images[0]->file_url;
		}
		else {
			$imagem = $product->images[0]->file_url . "logotipo.png";
		}
		
		// Show Products
		if ( strpos($product->link, "en/produtos") === false ) {
			$p_link = $product->link;
		}
		else {
			$p_link = str_replace("en/produtos", "en/products", $product->link);
		}
		
		$sql = "";
		$sql .= "	select novidade, desconto ";
		$sql .= "	from e506s_virtuemart_products";
		$sql .= "	where virtuemart_product_id = " . $db->quote($product->virtuemart_product_id);
		$sql .= "	limit 1 ";
		
		$db->setQuery($sql); 
		$db->execute();
		$num_rows = $db->getNumRows();		
		$field_prod = $db->loadRowList();
		
		if( $num_rows > 0 ) {
			$desconto = $field_prod[0][1];
			$novidade = $field_prod[0][0];
		}
		else {
			$desconto = 0;
			$novidade = 0;
		}
		
		$sql = "";
					
		$sql .= "	select A.virtuemart_product_id, B.product_name, B.product_s_desc, B.slug, A.desconto, A.novidade, ";
		$sql .= "	ifnull(( select file_url from e506s_virtuemart_product_medias C inner join e506s_virtuemart_medias D on C.virtuemart_media_id = D.virtuemart_media_id where C.virtuemart_product_id = A.virtuemart_product_id limit 1), 'images/stories/virtuemart/product/logotipo.png') file_url, ";
		$sql .= "	C.Modalidade, C.Genero, C.Linha, C.Categoria";
		$sql .= "	from e506s_virtuemart_products A ";
		$sql .= "		inner join e506s_virtuemart_products_".str_replace('-', '_', strtolower(strval($language->getTag())))." B on A.virtuemart_product_id = B.virtuemart_product_id ";
		$sql .= "		inner join e506s_fastseller_product_type_4 C on A.virtuemart_product_id = C.product_id ";
		$sql .= "	where A.virtuemart_product_id = " . $product->virtuemart_product_id;
		
		$db->setQuery($sql);  
		$result = $db->loadObjectList();
		
		?>
		<div class="product floatleft <?php echo $show_vertical_separator ?> product_detail_item">
			<?php
				if ( $desconto > 0 ) {
			?>
				<div class="promotion"><span class="discount">- <?php echo $desconto; ?>%</span></div>
			<?php
				}
				switch( $result[0]->Linha ) {
					case 'PRO':
						$linha_cor = 'back_black';
						break;
					case 'RACE':
						$linha_cor = 'back_red';
						break;
					case 'SPORT':
						$linha_cor = 'back_orange';
						break;
				}
			?>
			<div class="linha_label"><span class="linha_label_txt <?php echo $linha_cor; ?>"><?php echo $result[0]->Linha; ?></span></div>
			<a href="<?php echo $p_link; ?>" title="<?php echo $product->product_name ?>" class="product-image">
				<img src="<?php echo $imagem; ?>" width="150" height="200" alt="<?php echo $product->product_name ?>">
			</a>
			<h2 class="product-name">
				<a href="<?php echo $p_link; ?>" title="<?php echo $product->category_name . ' - ' . $product->product_name ?>">
				<?php 
					echo $product->category_name;
					echo '<br>';
					if ( $result[0]->novidade > 0 ) {
					?>
						<div class="new_prod"><span class="new_prod_label"><?php echo JText::_ ('COM_VIRTUEMART_NEW'); ?></span></div>
					<?php
					}
					echo $product->product_name 
				?>
				</a>
				</a>
			</h2>
			<div class="price-box">
				<p class="special-price">
					<span class="price" id="product-price-1197">
						<?php echo number_format($product->prices["basePriceWithTax"],2); ?>&nbsp;€
					</span>
				</p>
			</div>
			<div class="actions">
				<?php					
					if ( $language->getTag() == "en-GB" ) {
						$query = $db->getQuery(true);
						$query->select($db->quoteName(array('en_gb')));
						$query->from($db->quoteName('#__filtros'));
						$query->where($db->quoteName('pt_pt') . ' = '. $db->quote($result[0]->Categoria) . ' AND ' . $db->quoteName('nome') . ' = '. $db->quote('categoria') );
						
						$db->setQuery($query);
						$db->execute();
						$num_rows = $db->getNumRows();
						
						if( $num_rows > 0 ) {
							$results = $db->loadRowList();
							echo '<span style="font-size:10px">'. $results[0][0] .'</span> &#8226;';
						}
						else {
						?>
							<span style="font-size:10px"><?php echo $result[0]->Categoria; ?></span> &#8226;
						<?php
						}
					}
					else {
					?>
						<span style="font-size:10px"><?php echo $result[0]->Categoria; ?></span> &#8226;
					<?php
					}
				?>
				<?php
					if ( $language->getTag() == "en-GB" ) {
						$query = $db->getQuery(true);
						$query->select($db->quoteName(array('en_gb')));
						$query->from($db->quoteName('#__filtros'));
						$query->where($db->quoteName('pt_pt') . ' = '. $db->quote($result[0]->Modalidade) . ' AND ' . $db->quoteName('nome') . ' = '. $db->quote('modalidade') );
						
						$db->setQuery($query);
						$db->execute();
						$num_rows = $db->getNumRows();
						
						if( $num_rows > 0 ) {
							$results = $db->loadRowList();
							echo '<span style="font-size:10px">'. $results[0][0] .'</span> &#8226;';
						}
						else {
						?>
							<span style="font-size:10px"><?php echo $result[0]->Modalidade; ?></span> &#8226;
						<?php
						}
					}
					else {
					?>
						<span style="font-size:10px"><?php echo $result[0]->Modalidade; ?></span> &#8226;
					<?php
					}
				?>
				<span style="font-size:10px">
				<?php 
					if( $result[0]->Genero == "MALE;FEMALE" or $result[0]->Genero == "MASCULINO;FEMININO" ) {
						if ( $language->getTag() == "en-GB" ) {
							echo "GENDERLESS";
						}
						else {
							echo "UNISSEXO";
						}
					}
					else {
						if ( $language->getTag() == "en-GB" ) {
							if( $result[0]->Genero == "MASCULINO" )
								echo "MALE";
							if( $result[0]->Genero == "FEMININO" )
								echo "FEMALE";
						}
						else {
							echo $result[0]->Genero;
						}
					}
				?></span> &#8226;
				<?php
					if ( $language->getTag() == "en-GB" ) {
						$query = $db->getQuery(true);
						$query->select($db->quoteName(array('en_gb')));
						$query->from($db->quoteName('#__filtros'));
						$query->where($db->quoteName('pt_pt') . ' = '. $db->quote($result[0]->Linha) . ' AND ' . $db->quoteName('nome') . ' = '. $db->quote('linha') );
						
						$db->setQuery($query);
						$db->execute();
						$num_rows = $db->getNumRows();
						
						if( $num_rows > 0 ) {
							$results = $db->loadRowList();
							echo '<span style="font-size:10px">'. $results[0][0] .'</span>';
						}
						else {
						?>
							<span style="font-size:10px"><?php echo $result[0]->Linha; ?></span>
						<?php
						}
					}
					else {
					?>
						<span style="font-size:10px"><?php echo $result[0]->Linha; ?></span>
					<?php
					}
				?>
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