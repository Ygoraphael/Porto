<?php
/**
 *
 * Error Layout for the add to cart popup
 *
 * @package	VirtueMart
 * @subpackage Cart
 * @author Max Milbers
 *
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2013 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version $Id: cart.php 2551 2010-09-30 18:52:40Z milbo $
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
?>

<div class="modal-cart text-center">
    <div class="modal-cart-content">
        <div class="row">
            <div class="modal-cart-container text-center">
                <h2><?= JText::_( 'UPS_THIS_IS_STRANGE' ); ?></h2><br>
                <h3><?= JText::_( 'SEEMS_OUT_OF_STOCK' ); ?></h3>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="modal-cart-container text-center">
                <h3><?= JText::_( 'WHY_NOT_ALTERNATIVES' ); ?></h3>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="modal-cart-container text-center">
                <?php
                $lang = JFactory::getLanguage();
                $db = JFactory::getDbo();

                $query = $db->getQuery(true);
                $query->select('*');
                $query->from($db->quoteName('#__fastseller_product_type_4'));
                $query->where($db->quoteName('product_id') . ' = ' . $db->quote($this->productData->virtuemart_product_id));
                $db->setQuery($query);
                $customFields = $db->loadObjectList();

                $query = $db->getQuery(true);
                $query->select('*');
                $query->from($db->quoteName('#__fastseller_product_type_4'));
                $query->where($db->quoteName('product_id') . ' = ' . $db->quote($this->productData->virtuemart_product_id));
                $db->setQuery($query);
                $customFields = $db->loadObjectList();

                if (count($customFields)) {

                    $query = $db->getQuery(true);
                    $query->select($db->quoteName(array(strtolower(str_replace("-", "_", $lang->getTag())))));
                    $query->from($db->quoteName('#__filtros'));
                    $query->where($db->quoteName('pt_pt') . ' = ' . $db->quote($customFields[0]->Modalidade) . ' AND ' . $db->quoteName('nome') . ' = ' . $db->quote('modalidade'));
                    $db->setQuery($query);
                    $mod_traducao = $db->loadRowList();

                    if (count($mod_traducao)) {
                        if ($lang->getTag() == "en-GB") {
                            $modUrl = JURI::base() . "index.php/products/search?Modalidade=" . strtoupper($customFields[0]->Modalidade);
                        } elseif ($lang->getTag() == "es-ES") {
                            $modUrl = JURI::base() . "index.php/productos/search?Modalidade=" . strtoupper($customFields[0]->Modalidade);
                        } else {
                            $modUrl = JURI::base() . "index.php/produtos/search?Modalidade=" . strtoupper($customFields[0]->Modalidade);
                        }
                        ?> <a class="btn btn-primary" href="<?= $modUrl ?>" role="button"><?= $mod_traducao[0][0] ?></a> <?php
                    }

                    $query = $db->getQuery(true);
                    $query->select($db->quoteName(array(strtolower(str_replace("-", "_", $lang->getTag())))));
                    $query->from($db->quoteName('#__filtros'));
                    $query->where($db->quoteName('pt_pt') . ' = ' . $db->quote($customFields[0]->Categoria) . ' AND ' . $db->quoteName('nome') . ' = ' . $db->quote('categoria'));
                    $db->setQuery($query);
                    $cat_traducao = $db->loadRowList();

                    if (count($cat_traducao)) {
                        if ($lang->getTag() == "en-GB") {
                            $catUrl =  JURI::base() . "index.php/products/search?Categoria=" . strtoupper($customFields[0]->Categoria);
                        } elseif ($lang->getTag() == "es-ES") {
                            $catUrl = JURI::base() . "index.php/productos/search?Categoria=" . strtoupper($customFields[0]->Categoria);
                        } else {
                            $catUrl = JURI::base() . "index.php/produtos/search?Categoria=" . strtoupper($customFields[0]->Categoria);
                        }
                        ?> <a class="btn btn-primary" href="<?= $catUrl ?>" role="button"><?= $cat_traducao[0][0] ?></a> <?php
                    }

                    if( $customFields[0]->Genero != 'MASCULINO;FEMININO' ) {
                        $query = $db->getQuery(true);
                        $query->select($db->quoteName(array(strtolower(str_replace("-", "_", $lang->getTag())))));
                        $query->from($db->quoteName('#__filtros'));
                        $query->where($db->quoteName('pt_pt') . ' = ' . $db->quote($customFields[0]->Genero) . ' AND ' . $db->quoteName('nome') . ' = ' . $db->quote('genero'));
                        $db->setQuery($query);
                        $gen_traducao = $db->loadRowList();

                        if (count($gen_traducao)) {
                            if ($lang->getTag() == "en-GB") {
                                $genUrl = JURI::base() . "index.php/products/search?Genero=" . strtoupper($customFields[0]->Genero);
                            } elseif ($lang->getTag() == "es-ES") {
                                $genURL = JURI::base() . "index.php/productos/search?Genero=" . strtoupper($customFields[0]->Genero);
                            } else {
                                $genUrl = JURI::base() . "index.php/produtos/search?Genero=" . strtoupper($customFields[0]->Genero);
                            }
                            ?> <a class="btn btn-primary" href="<?= $genUrl ?>" role="button"><?= $gen_traducao[0][0] ?></a> <?php
                        }
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>
<br style="clear:both">
<?php
//$this->cart->getError()
//$this->productData->product_name
//$this->continue_link
//JText::_('COM_VIRTUEMART_CONTINUE_SHOPPING')
?>