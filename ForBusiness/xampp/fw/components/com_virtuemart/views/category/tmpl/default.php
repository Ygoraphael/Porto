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
defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.modal');
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
if (!empty($this->category) && $this->category->virtuemart_category_id == 0 && empty($this->category->children)) {
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

$document = JFactory::getDocument();
$document->addScriptDeclaration($js);
?>
<script>
    function setfocus(e) {
        if (e.hasClass("focus"))
            e.removeClass("focus");
        else
            e.addClass("focus");
    }
</script>
<div class="container">
    <br>
    <div class="row">
        <div class="col-md-10">

        </div>
        <div class="col-md-2">
       <div class="btn-holder">
       <div>
         <a href="#menu-toggle" style="background-color:#eb4800;width:100%; padding-left:1%; color:white;" class="btn btn-primary no-border-radius" id="menu-toggle">
           <span class="round"><i class="fa fa-plus-circle"></i>
       </span>
           <span class="txt"><?php echo JText::_('NOVOSCANAIS_FILTERS'); ?></span>
         </a>
       </div>
    </div>
        </div>
    </div>

    <!-- vm pagination -->
    <div class="orderby-displaynumber">
        <div class="width70 floatleft">
            <?php echo $this->orderByList['orderby']; ?>
            <?php echo $this->orderByList['manufacturer']; ?>
        </div>
        <div class="width30 text-align:center; floatright display-number"><?php echo $this->vmPagination->getResultsCounter(); ?><br/><?php echo $this->vmPagination->getLimitBox($this->category->limit_list_step); ?></div>
        <div class="clear"></div>
    </div>
    <!-- end of orderby-displaynumber -->

    <?php
    if (!empty($this->keyword) and 0) {

        $category_id = JRequest::getInt('virtuemart_category_id', 0);
        ?>
        <form action="<?php echo JRoute::_('index.php?option=com_virtuemart&view=category&limitstart=0', FALSE); ?>" method="get">
            <!--BEGIN Search Box -->
            <div class="search-query cfc-h-tx center-text tt-upper">
                <?php echo $this->searchcustom ?>
                <br/>
                <?php echo $this->searchcustomvalues ?>
                <input name="keyword" class="search-query cfc-h-tx center-text tt-upper" type="text" size="20" value="<?php echo $this->keyword ?>"/>
                <input type="submit" value="<?php echo JText::_('COM_VIRTUEMART_SEARCH') ?>" class="button" onclick="this.form.keyword.focus();"/>
            </div>
            <input type="hidden" name="search" value="true"/>
            <input type="hidden" name="view" value="category"/>
            <input type="hidden" name="option" value="com_virtuemart"/>
            <input type="hidden" name="virtuemart_category_id" value="<?php echo $category_id; ?>"/>
        </form>
        <!-- End Search Box -->
    <?php } ?>
    <?php
    // Show child categories
    $language = & JFactory::getLanguage();
    $db = JFactory::getDbo();

    if (!empty($this->products)) {
        ?>
        <h1><?php echo $this->category->category_name; ?></h1>
        <?php
        // Category and Columns Counter
        $iBrowseCol = 1;
        $iBrowseProduct = 1;

        // Calculating Products Per Row
        $BrowseProducts_per_row = 4;
        $Browsecellwidth = ' width' . floor(100 / $BrowseProducts_per_row);

        // Separator
        $verticalseparator = " vertical-separator";

        $BrowseTotalProducts = count($this->products);

        // Start the Output
        foreach ($this->products as $product) {

            // Show the horizontal seperator
            if ($iBrowseCol == 1 && $iBrowseProduct > $BrowseProducts_per_row) {
                ?>
                <?php
            }

            // this is an indicator wether a row needs to be opened or not
            if ($iBrowseCol == 1) {
                ?>
                <div class="row" style="margin-bottom:30px;">
                    <?php
                }
                if ($product->images[0]->file_url != 'images/stories/virtuemart/product/') {
                    $imagem = $product->images[0]->file_url;
                } else {
                    $imagem = $product->images[0]->file_url . "logotipo.png";
                }

                // Show Products
                if (strpos($product->link, "en/produtos") === false) {
                    $p_link = $product->link;
                } else {
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

                if ($num_rows > 0) {
                    $desconto = $field_prod[0][1];
                    $novidade = $field_prod[0][0];
                } else {
                    $desconto = 0;
                    $novidade = 0;
                }

                $sql = "	select A.virtuemart_product_id, B.product_name, B.product_s_desc, B.slug, A.desconto, A.novidade, ";
                $sql .= "	ifnull(( select file_url from #__virtuemart_product_medias C inner join #__virtuemart_medias D on C.virtuemart_media_id = D.virtuemart_media_id where C.virtuemart_product_id = A.virtuemart_product_id limit 1), 'images/stories/virtuemart/product/logotipo.png') file_url, ";
                $sql .= "	C.Modalidade, C.Genero, C.Linha, C.Categoria";
                $sql .= "	from #__virtuemart_products A ";
                $sql .= "		inner join #__virtuemart_products_" . str_replace('-', '_', strtolower(strval($language->getTag()))) . " B on A.virtuemart_product_id = B.virtuemart_product_id ";
                $sql .= "		inner join #__fastseller_product_type_4 C on A.virtuemart_product_id = C.product_id ";
                $sql .= "	where A.virtuemart_product_id = " . $product->virtuemart_product_id;

                $db->setQuery($sql);
                $result = $db->loadObjectList();
                ?>
                <div class="col-md-3 col-md-offset-1">
                    <div class="wrapper">
                        <div class="product-item widget-box drop-shadow" onclick="setfocus(jQuery(this))" >
                            <img class="img-fluid" src="<?php echo $imagem; ?>" alt="<?php echo $product->product_name ?>">
                            <div style="width:100%;background:white;padding-top:10px;" class="text-center">
                                <a href="<?php echo $p_link; ?>" title="<?php echo $product->product_name ?>" class="hidden-sizes">
                                    <p style="text-align:center; color:black;">
                                        <?php echo $product->category_name; ?><br>
                                        <?php echo $product->product_name ?> <br>
                                        € <?php echo number_format($product->prices["basePriceWithTax"], 2); ?>
                                    </p>
                                </a>
                            </div>
                            <div class="item-buy">
                                <div class="hidden-sizes">
                                    <?php
                                    $query = $db->getQuery(true);
                                    $query->select($db->quoteName(array('virtuemart_product_id', 'product_parent_id', 'product_sku', 'product_in_stock', 'product_ordered')));
                                    $query->from($db->quoteName('#__virtuemart_products'));
                                    $query->where($db->quoteName('product_parent_id') . ' = ' . $db->quote($product->virtuemart_product_id));
                                    $query->where($db->quoteName('published') . ' = 1');

                                    $db->setQuery($query);
                                    $stocks = $db->loadObjectList();

                                    $stock_tam = array(
                                        'XS' => 0,
                                        'S' => 0,
                                        'M' => 0,
                                        'L' => 0,
                                        'XL' => 0,
                                        '2XL' => 0,
                                        '3XL' => 0,
                                        '4XL' => 0
                                    );

                                    foreach ($stocks as $stock) {
                                        $cur_sku = explode("|||", $stock->product_sku);

                                        if (count($cur_sku) == 4) {
                                            if ($cur_sku[2] == 'XS') {
                                                $stock_tam["XS"] += $stock->product_in_stock - $stock->product_ordered;
                                            }
                                            if ($cur_sku[2] == 'S') {
                                                $stock_tam["S"] += $stock->product_in_stock - $stock->product_ordered;
                                            }
                                            if ($cur_sku[2] == 'M') {
                                                $stock_tam["M"] += $stock->product_in_stock - $stock->product_ordered;
                                            }
                                            if ($cur_sku[2] == 'L') {
                                                $stock_tam["L"] += $stock->product_in_stock - $stock->product_ordered;
                                            }
                                            if ($cur_sku[2] == 'XL') {
                                                $stock_tam["XL"] += $stock->product_in_stock - $stock->product_ordered;
                                            }
                                            if ($cur_sku[2] == '2XL') {
                                                $stock_tam["2XL"] += $stock->product_in_stock - $stock->product_ordered;
                                            }
                                            if ($cur_sku[2] == '3XL') {
                                                $stock_tam["3XL"] += $stock->product_in_stock - $stock->product_ordered;
                                            }
                                            if ($cur_sku[2] == '4XL') {
                                                $stock_tam["4XL"] += $stock->product_in_stock - $stock->product_ordered;
                                            }
                                        }
                                    }
                                    ?>
                                    <ul>
                                        <li class="<?= $stock_tam["XS"] ? "btn-success" : "btn-danger" ?>">XS</li>
                                        <li class="<?= $stock_tam["S"] ? "btn-success" : "btn-danger" ?>">S</li>
                                        <li class="<?= $stock_tam["M"] ? "btn-success" : "btn-danger" ?>">M</li>
                                        <li class="<?= $stock_tam["L"] ? "btn-success" : "btn-danger" ?>">L</li>
                                        <li class="<?= $stock_tam["XL"] ? "btn-success" : "btn-danger" ?>">XL</li>
                                        <li class="<?= $stock_tam["2XL"] ? "btn-success" : "btn-danger" ?>">2XL</li>
                                        <li class="<?= $stock_tam["3XL"] ? "btn-success" : "btn-danger" ?>">3XL</li>
                                        <li class="<?= $stock_tam["4XL"] ? "btn-success" : "btn-danger" ?>">4XL</li>
                                    </ul>
                                    <div class="container">
                                        <div class="row">
                                            <div class=" col-xs-12 col-md-5">
                                                <div style="margin-left:10px;">
                                                    <div class="row">
                                        
                                                        <div class=""><?php echo JText::_('NOVOSCANAIS_INSTOCK'); ?></div>
                                                    </div>
                                                    <div class="row align-items-center" style="margin-bottom:4%">
                                                        <div class="rcorners2"></div>
                                                        <div class="stock-lines"><?php echo JText::_('NOVOSCANAIS_OUTSTOCK'); ?></div>
                                                    </div>
                                                </div>
                                            </div>

                           <div class="col-xs-12 col-md-7">
                             <div class="" style="right:60px; bottom:-5px;">
                               <a href="<?php echo $p_link; ?>" style="color:white; width:100%; background-color:#eb4800" class=" btn btn-primary no-border-radius" title="<?php echo $product->product_name ?>">
                                 <span class="round"s><i class="fa fa-shopping-cart" style="margin-left:-7px;"></i></span>
                                 <span class="txt"><?php echo JText::_('NOVOSCANAIS_SHOP'); ?></span>
                               </a>
                             </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        switch ($result[0]->Linha) {
                            case 'PRO':
                                $linha_cor = 'back_black';
                                break;
                            case 'RACE':
                                $linha_cor = 'back_red';
                                break;
                            case 'SPORT':
                                $linha_cor = 'back_orange';
                                break;
                            default:
                                $linha_cor = '';
                                break;
                        }
                        ?>
                        <div class="ribbons-left">
                            <div class="ribbon-class-holder">
                                <div class="ribbon ribbon-class <?= $linha_cor ?>">
                                    <div class="ribbon-stitches-top"></div>
                                    <p class="h3-ribbons"><?= $result[0]->Linha ?></p>
                                    <div class="ribbon-stitches-bottom"></div>
                                    <div class="triangle"></div>
                                </div>
                            </div>
                            <?php if ($result[0]->novidade > 0) { ?>
                                <div class="ribbon-new-holder">
                                    <div class="ribbon ribbon-new">
                                        <div class="ribbon-stitches-top"></div>
                                        <p class="h3-ribbons"><?php echo JText::_('NOVOS_CANAIS_NEW'); ?></p>
                                        <div class="ribbon-stitches-bottom"></div>
                                        <div class="triangle"></div>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if ($desconto > 0) { ?>
                                <div class = "ribbon-discount-holder">
                                    <div class = "ribbon ribbon-discount">
                                        <div class = "ribbon-stitches-top"></div>
                                        <p class="h3-ribbons"><?= $desconto; ?> %</p>
                                        <div class = "ribbon-stitches-bottom"></div>
                                        <div class = "triangle"></div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <?php
                // Do we need to close the current row now?
                if ($iBrowseCol == $BrowseProducts_per_row || $iBrowseProduct == $BrowseTotalProducts) {
                    ?>
                    <div class="clear"></div>
                </div>
                <!-- end of row -->
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
        <?php
    } elseif (!empty($this->keyword)) {
        echo JText::_('COM_VIRTUEMART_NO_RESULT') . ($this->keyword ? ' : (' . $this->keyword . ')' : '');
    }
    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-md-8 ">
                <div class="d-flex justify-content-center"><?php echo $this->vmPagination->getPagesLinks(); ?></div>
            </div>
            <div class="col-md-2">
                <span style="right:0; position:absolute; bottom:10px;"><?php echo $this->vmPagination->getPagesCounter(); ?></span>
            </div>
        </div>
    </div>
</div>
<!-- end browse-view -->
