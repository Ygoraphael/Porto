<?php
/**
 *
 * Layout for the add to cart popup
 *
 * @package	VirtueMart
 * @subpackage Cart
 * @author Max Milbers
 *
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2013 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: cart.php 2551 2010-09-30 18:52:40Z milbo $
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

$db = JFactory::getDbo();
$language = & JFactory::getLanguage();

$sql = "select calc_value from e506s_virtuemart_calcs where virtuemart_calc_id = 1";
$db->setQuery($sql);
$db->execute();
$num_rows = $db->getNumRows();
$field_prod = $db->loadRowList();

if ($num_rows > 0) {
    $taxa_iva = $field_prod[0][0];
} else {
    $taxa_iva = 0;
}

$sql = "	select A.virtuemart_product_id, B.product_name, B.product_s_desc, B.slug, A.desconto, A.novidade, ";
$sql .= "	ifnull(( select file_url from e506s_virtuemart_product_medias C inner join e506s_virtuemart_medias D on C.virtuemart_media_id = D.virtuemart_media_id where C.virtuemart_product_id = A.virtuemart_product_id limit 1), 'images/stories/virtuemart/product/logotipo.png') file_url, ";
$sql .= "	C.Modalidade, C.Genero, C.Linha, C.Categoria";
$sql .= "	from e506s_virtuemart_products A ";
$sql .= "		inner join e506s_virtuemart_products_" . str_replace('-', '_', strtolower(strval($language->getTag()))) . " B on A.virtuemart_product_id = B.virtuemart_product_id ";
$sql .= "		inner join e506s_fastseller_product_type_4 C on A.virtuemart_product_id = C.product_id ";
$sql .= "	where A.virtuemart_product_id = " . $this->product->virtuemart_product_id;

$db->setQuery($sql);
$result = $db->loadObjectList();
if( count($result) ) {
    $desconto = $result[0]->desconto;
    $desconto_valor = ($this->product->product_price / (1 - $desconto / 100)) - $this->product->product_price;
    $desconto_valor = str_replace('.', ',', number_format($desconto_valor * (1 + ($taxa_iva / 100)), 2));
}
else {
    $desconto = 0;
    $desconto_valor = 0;
}
?>

<div class="modal-cart text-center">
    <div class="modal-cart-content">
        <div class="row">
            <div class= "modal-cart-container text-center">
                <h2><?= JText::_('COM_VIRTUEMART_PRODUCT_ADDED_SUCCESSFULLY'); ?></h2><br>
                <h3><?= $this->product->product_name ?></h3>
                <?php if ($this->tamanho != "" && $this->cor != ""): ?>
                <h3><?= JText::_( 'NC_SIZE' ); ?>: <?= $this->tamanho ?> | <?= JText::_( 'NC_COLOR' ); ?>: <?= $this->cor ?></h3>
                <?php endif ?>
                <h3><?= JText::_( 'NC_PRICE' ); ?>: <?= str_replace('.', ',', number_format(($this->product->product_price) * (1 + ($taxa_iva / 100)), 2)) ?> € <?= $desconto ? "- " . JText::_( 'NC_YOUSAVED' ) . " " . $desconto_valor . " € (" . $desconto . "%)" : "" ?></h3>
                <h3><?= JText::_( 'NC_QTT' ); ?>: <?= $this->product->quantity ?></h3>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="modal-cart-container text-center">
                <a class="btn btn-primary" href="<?= $this->continue_link ?>" role="button"><?= JText::_('COM_VIRTUEMART_CONTINUE_SHOPPING') ?></a>
                <a class="btn btn-primary" href="<?= $this->cart_link ?>" role="button"><?= JText::_('COM_VIRTUEMART_CART_SHOW') ?></a>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="modal-cart-container text-center">
                <h3><?= JText::_('COM_VIRTUEMART_RELATED_PRODUCTS_HEADING') ?></h3>
            </div>
        </div>
        <br>
        <div class="row">
            <?php
            $language = & JFactory::getLanguage();
            $language->load('mod_virtuemart_product');
            $cur_fam = explode("|||", $this->product->product_sku);
            $cur_fam = $cur_fam[1];

            $db = JFactory::getDbo();

            $sql = "	select A.virtuemart_product_id, B.product_name, B.product_s_desc, B.slug, A.desconto, A.novidade, ";
            $sql .= "	ifnull(( select file_url from e506s_virtuemart_product_medias C inner join e506s_virtuemart_medias D on C.virtuemart_media_id = D.virtuemart_media_id where C.virtuemart_product_id = A.virtuemart_product_id order by C.ordering limit 1), 'images/stories/virtuemart/product/logotipo.png') file_url, ";
            $sql .= "	C.Modalidade, C.Genero, C.Linha, C.Categoria";
            $sql .= "	from e506s_virtuemart_products A ";
            $sql .= "		inner join e506s_virtuemart_products_" . str_replace('-', '_', strtolower(strval($language->getTag()))) . " B on A.virtuemart_product_id = B.virtuemart_product_id ";
            $sql .= "		inner join e506s_fastseller_product_type_4 C on A.virtuemart_product_id = C.product_id ";
            $sql .= "	where A.phc_ref like '%|||$cur_fam' and A.virtuemart_product_id <> " . $this->product->virtuemart_product_id;
            $sql .= "	limit 10 ";

            $db->setQuery($sql);
            $result = $db->loadObjectList();
            shuffle($result);
            $cur_cell = 0;
            $productModel = VmModel::getModel('Product');

            while ($cur_cell < min(2, sizeof($result))) {

                $product_rel = $productModel->getProduct($result[$cur_cell]->virtuemart_product_id);
                $imagem = JURI::base() . $result[$cur_cell]->file_url;

                if (strpos($product_rel->link, "en/produtos") === false) {
                    $p_link = $product_rel->link;
                } else {
                    $p_link = str_replace("en/produtos", "en/products", $product_rel->link);
                }

                switch ($result[$cur_cell]->Linha) {
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
                <div class="col-xs-12 col-sm-5">
                    <div class="product is-gray">
                        <div class="image d-flex align-items-center justify-content-center">
                            <img src="<?= $imagem ?>" alt="<?= $product_rel->product_name ?>" class="img-fluid">
                            <div class="hover-overlay d-flex align-items-center justify-content-center">
                                <div class="CTA d-flex align-items-center justify-content-center">
                                    <a href="<?= $p_link ?>" class="visit-product active">
                                        <i class="icon-search"></i>VER
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="title text-center info_title">
                            <a href="<?= $p_link ?>">
                                <h3 class="h6 text-uppercase"><?= $product_rel->product_name ?></h3>
                                <h4 class="h8 text-uppercase"><?= $product_rel->category_name ?></h4>
                            </a>
                            <span class="price text-muted">€ <?= number_format($product_rel->prices["basePriceWithTax"], 2) ?></span>
                        </div>
                    </div>
                </div>
                <?php
                $cur_cell++;
            }
            ?>
        </div>
    </div>
</div>
