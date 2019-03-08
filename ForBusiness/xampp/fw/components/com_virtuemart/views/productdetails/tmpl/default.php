<?php
/**
 *
 * Show the product details page
 *
 * @package	VirtueMart
 * @subpackage
 * @author Max Milbers, Eugen Stranz
 * @author RolandD,
 * @todo handle child products
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: default.php 6530 2012-10-12 09:40:36Z alatak $
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

/* Let's see if we found the product */
if (empty($this->product)) {
    echo JText::_('COM_VIRTUEMART_PRODUCT_NOT_FOUND');
    echo '<br /><br />  ' . $this->continue_link_html;
    return;
}

if (JRequest::getInt('print', false)) {
    ?>
    <body onload="javascript:print();">
        <?php
    }

// addon for joomla modal Box
    JHTML::_('behavior.modal');

    $MailLink = 'index.php?option=com_virtuemart&view=productdetails&task=recommend&virtuemart_product_id=' . $this->product->virtuemart_product_id . '&virtuemart_category_id=' . $this->product->virtuemart_category_id . '&tmpl=component';

    $boxFuncReco = '';
    $boxFuncAsk = '';
    if (VmConfig::get('usefancy', 1)) {
        vmJsApi::js('fancybox/jquery.fancybox-1.3.4.pack');
        vmJsApi::css('jquery.fancybox-1.3.4');
        if (VmConfig::get('show_emailfriend', 0)) {
            $boxReco = "jQuery.fancybox({
				href: '" . $MailLink . "',
				type: 'iframe',
				height: '550'
			});";
        }
        if (VmConfig::get('ask_question', 0)) {
            $boxAsk = "jQuery.fancybox({
				href: '" . $this->askquestion_url . "',
				type: 'iframe',
				height: '550'
			});";
        }
    } else {
        vmJsApi::js('facebox');
        vmJsApi::css('facebox');
        if (VmConfig::get('show_emailfriend', 0)) {
            $boxReco = "jQuery.facebox({
				iframe: '" . $MailLink . "',
				rev: 'iframe|550|550'
			});";
        }
        if (VmConfig::get('ask_question', 0)) {
            $boxAsk = "jQuery.facebox({
				iframe: '" . $this->askquestion_url . "',
				rev: 'iframe|550|550'
			});";
        }
    }
    if (VmConfig::get('show_emailfriend', 0)) {
        $boxFuncReco = "jQuery('a.recommened-to-friend').click( function(){
					" . $boxReco . "
			return false ;
		});";
    }
    if (VmConfig::get('ask_question', 0)) {
        $boxFuncAsk = "jQuery('a.ask-a-question').click( function(){
					" . $boxAsk . "
			return false ;
		});";
    }

    if (!empty($boxFuncAsk) or ! empty($boxFuncReco)) {
        $document = JFactory::getDocument();
        $document->addScriptDeclaration("
//<![CDATA[
	jQuery(document).ready(function($) {
		" . $boxFuncReco . "
		" . $boxFuncAsk . "
	/*	$('.additional-images a').mouseover(function() {
			var himg = this.href ;
			var extension=himg.substring(himg.lastIndexOf('.')+1);
			if (extension =='png' || extension =='jpg' || extension =='gif') {
				$('.main-image img').attr('src',himg );
			}
			console.log(extension)
		});*/
	});
//]]>
");
    }
    ?>

    <?php
// Product Navigation
    if (VmConfig::get('product_navigation', 1)) {
        ?>
        <div class="product-neighbours">
            <?php
            if (!empty($this->product->neighbours ['previous'][0])) {
                $prev_link = JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $this->product->neighbours ['previous'][0] ['virtuemart_product_id'] . '&virtuemart_category_id=' . $this->product->virtuemart_category_id, FALSE);
                echo JHTML::_('link', $prev_link, $this->product->neighbours ['previous'][0]
                        ['product_name'], array('rel' => 'prev', 'class' => 'previous-page'));
            }
            if (!empty($this->product->neighbours ['next'][0])) {
                $next_link = JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $this->product->neighbours ['next'][0] ['virtuemart_product_id'] . '&virtuemart_category_id=' . $this->product->virtuemart_category_id, FALSE);
                echo JHTML::_('link', $next_link, $this->product->neighbours ['next'][0] ['product_name'], array('rel' => 'next', 'class' => 'next-page'));
            }
            ?>
            <div class="clear"></div>
        </div>
    <?php } // Product Navigation END
    ?>

    <?php
    // Back To Category Button
    if ($this->product->virtuemart_category_id) {
        $catURL = JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id=' . $this->product->virtuemart_category_id, FALSE);
        $categoryName = $this->product->category_name;
    } else {
        $catURL = JRoute::_('index.php?option=com_virtuemart');
        $categoryName = jText::_('COM_VIRTUEMART_SHOP_HOME');
    }
    ?>
        <div id="articleHeader1" class="row elipse-border-bottom box-shadow-destaques">
        <?php // Product Title   ?>
            <div class="col-md-8 col-xs-12 underSubNavMobile">
                <h2 style="font-size:25px;"><?php echo $this->product->product_name ?></h2>
            <?php // Product Title END    ?>
        </div>
            <div class="col-md-4 col-xs-12" style="margin-top:3%;margin-bottom:1%;; text-align:right;width:100%;padding:0;">
        
                        <a href="<?php echo $catURL ?>" title="<?php echo $categoryName ?>" class="btn btn-primary no-border-radius" style="color:white; width:100%; padding:2.5%">
                            <span><i class="fa fa-chevron-left"></i></span>
                            <?php echo  $categoryName?>
                    </a>
            
            </div>
        </div>
        
        <!--<div id="articleHeader2" class="row elipse-border-bottom box-shadow-destaques" style="
display:none">
            <?php // Product Title   ?>
            
              <div class="col-xs-pull-12" style="margin-top:3%;margin-bottom:1%; text-align:right;width:100%;padding:0;">
        
                        <a href="<?php echo $catURL ?>" title="<?php echo $categoryName ?>" class="btn btn-primary no-border-radius" style="color:white; width:100%; padding:2.5%">
                            <span><i class="fa fa-chevron-left"></i></span>
                            <?php echo  $categoryName?>
                        </a>
            
            </div>
            
            
            <div class="col-xs-push-12" style="margin-top:3%;">
                <h2 style="font-size:25px;"><?php echo $this->product->product_name ?></h2>
                <?php // Product Title END    ?>
        </div>
          
    </div>-->
      
        <script>
                /*var w= document.width;
                console.log(document.body.clientWidth);
                var x = document.getElementById("articleHeader1");
                var y = document.getElementById("articleHeader2");
                if (w<767) {
                    x.style.display = "none";
                    y.style.display = "inline-block";
                } else {
                     x.style.display = "inline-block";
                    y.style.display = "none";
                }
           
        */
        </script>
        
        
        
    <?php
    // Product Edit Link
    echo $this->edit_link;
    // Product Edit Link END
    ?>

    <?php
    // PDF - Print - Email Icon
    if (VmConfig::get('show_emailfriend') || VmConfig::get('show_printicon') || VmConfig::get('pdf_icon')) {
        ?>
        <div class="icons">
            <?php
            //$link = (JVM_VERSION===1) ? 'index2.php' : 'index.php';
            $link = 'index.php?tmpl=component&option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $this->product->virtuemart_product_id;

            echo $this->linkIcon($link . '&format=pdf', 'COM_VIRTUEMART_PDF', 'pdf_button', 'pdf_icon', false);
            echo $this->linkIcon($link . '&print=1', 'COM_VIRTUEMART_PRINT', 'printButton', 'show_printicon');
            echo $this->linkIcon($MailLink, 'COM_VIRTUEMART_EMAIL', 'emailButton', 'show_emailfriend', false, true, false, 'class="recommened-to-friend"');
            ?>
            <div class="clear"></div>
        </div>
    <?php } // PDF - Print - Email Icon END
    ?>

    <?php
    $pieces = explode("|||", $this->product->product_sku);


    if (!empty($this->product->customfieldsSorted['ontop'])) {
        $this->position = 'ontop';
        echo $this->loadTemplate('customfields');
    } // Product Custom ontop end
    ?>

    <div class="row" style="margin-top:4%">
        <div class="col-xs-12 col-md-6 main-image-holder" style="padding:0">
            <?php
            echo $this->loadTemplate('images');
            ?>
        </div>

        <?php
        $language = & JFactory::getLanguage();
        $language->load('mod_virtuemart_product');

        $db = JFactory::getDbo();
        $sql = "";

        $sql .= "	select A.virtuemart_product_id, B.product_name, B.product_s_desc, B.slug, A.desconto, A.novidade, ";
        $sql .= "	ifnull(( select file_url from e506s_virtuemart_product_medias C inner join e506s_virtuemart_medias D on C.virtuemart_media_id = D.virtuemart_media_id where C.virtuemart_product_id = A.virtuemart_product_id limit 1), 'images/stories/virtuemart/product/logotipo.png') file_url, ";
        $sql .= "	C.Modalidade, C.Genero, C.Linha, C.Categoria,";
        $sql .= "	A.antibact, A.aqueci, A.carbono, A.confort, A.cortaven, A.dryclim,";
        $sql .= "	A.drystorm, A.elastic, A.flatlock, A.fresc, A.frio, A.ikk,";
        $sql .= "	A.imperme, A.multicam, A.reflet, A.respir, A.silico, A.termoreg, A.imgtam";
        $sql .= "	from e506s_virtuemart_products A ";
        $sql .= "		inner join e506s_virtuemart_products_" . str_replace('-', '_', strtolower(strval($language->getTag()))) . " B on A.virtuemart_product_id = B.virtuemart_product_id ";
        $sql .= "		inner join e506s_fastseller_product_type_4 C on A.virtuemart_product_id = C.product_id ";
        $sql .= "	where A.virtuemart_product_id = " . $this->product->virtuemart_product_id;

        $db->setQuery($sql);
        $result = $db->loadObjectList();
        ?>

        <div class="col-xs-12 col-md-6 r-padding-left">
            <div class="titulo_fundo">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td class="titulo2">
                            <span style="padding-left:11px;" class="titulo2">&nbsp;<?php echo $this->product->product_name; ?> &nbsp;
                                <span class="texto_pequeno2">
                                    <em>#<?php echo nl2br($pieces[0]); ?></em>
                                </span>
                            </span>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="prod_details_bar">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr align="center">
                        <td width="20">&nbsp;</td>
                        <td>
                            <?php
                            echo '<a style="color:#F30; padding:2px; font-weight: bold; margin-top:5px;">';

                            $query = $db->getQuery(true);
                            $query->select($db->quoteName(array(strtolower(str_replace("-", "_", $language->getTag())))));
                            $query->from($db->quoteName('#__filtros'));
                            $query->where($db->quoteName('pt_pt') . ' = ' . $db->quote($result[0]->Categoria) . ' AND ' . $db->quoteName('nome') . ' = ' . $db->quote('categoria'));

                            $db->setQuery($query);
                            $db->execute();
                            $num_rows = $db->getNumRows();

                            if ($num_rows > 0) {
                                $results = $db->loadRowList();
                                echo $results[0][0];
                            } else {
                                echo $result[0]->Categoria;
                            }

                            echo '</a>&nbsp;';
                            ?>

                            <?php
                            echo '<a style="color:#F30; padding:2px; font-weight: bold;">';

                            $query = $db->getQuery(true);
                            $query->select($db->quoteName(array(strtolower(str_replace("-", "_", $language->getTag())))));
                            $query->from($db->quoteName('#__filtros'));
                            $query->where($db->quoteName('pt_pt') . ' = ' . $db->quote($result[0]->Modalidade) . ' AND ' . $db->quoteName('nome') . ' = ' . $db->quote('modalidade'));

                            $db->setQuery($query);
                            $db->execute();
                            $num_rows = $db->getNumRows();

                            if ($num_rows > 0) {
                                $results = $db->loadRowList();
                                echo $results[0][0];
                            } else {
                                echo $result[0]->Modalidade;
                            }

                            echo '</a>&nbsp;';
                            ?>

                            <?php
                            echo '<a style="color:#F30; padding:2px; font-weight: bold;">';
                            $query = $db->getQuery(true);
                            $query->select($db->quoteName(array(strtolower(str_replace("-", "_", $language->getTag())))));
                            $query->from($db->quoteName('#__filtros'));
                            $query->where($db->quoteName('pt_pt') . ' = ' . $db->quote($result[0]->Genero) . ' AND ' . $db->quoteName('nome') . ' = ' . $db->quote('genero'));

                            $db->setQuery($query);
                            $db->execute();
                            $num_rows = $db->getNumRows();

                            if ($num_rows > 0) {
                                $results = $db->loadRowList();
                                $tmp_genero = $results[0][0];
                            } else {
                                $tmp_genero = $result[0]->Genero;
                            }

                            if ($tmp_genero == "MASCULINO;FEMININO")
                                echo JText::_("NC_UNISEX");
                            else
                                echo $tmp_genero;

                            echo '</a>&nbsp;';
                            ?>

                            <?php
                            echo '<a style="color:#F30; padding:2px; font-weight: bold;">';

                            $query = $db->getQuery(true);
                            $query->select($db->quoteName(array(strtolower(str_replace("-", "_", $language->getTag())))));
                            $query->from($db->quoteName('#__filtros'));
                            $query->where($db->quoteName('pt_pt') . ' = ' . $db->quote($result[0]->Linha) . ' AND ' . $db->quoteName('nome') . ' = ' . $db->quote('linha'));

                            $db->setQuery($query);
                            $db->execute();
                            $num_rows = $db->getNumRows();

                            if ($num_rows > 0) {
                                $results = $db->loadRowList();
                                echo $results[0][0];
                            } else {
                                echo $result[0]->Linha;
                            }

                            echo '</a>&nbsp;';
                            ?>
                        </td>
                        <td width="20">&nbsp;</td>
                    </tr>
                </table>
            </div>
            <div class="prod_details_bar">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr align="center">
                        <td width="20">&nbsp;</td>
                        <td><?php echo $this->product->product_s_desc; ?></td>
                        <td width="20">&nbsp;</td>
                    </tr>
                </table>
            </div>
            <div class="prod_details_bar">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr align="center">
                        <td width="20">&nbsp;</td>
                        <td class="row justify-content-center">
                            <?php
                            if ($result[0]->antibact) {
                                echo '<img style="margin-top:1%" src="imagens/produtos/simbolos/antibacteriano.gif" title="' . JText::_('COMPONENTES_ANTI_BACTERIANOS') . '" style="cursor:help;">&nbsp;&nbsp;';
                            }
                            if ($result[0]->aqueci) {
                                echo '<img style="margin-top:1%" src="imagens/produtos/simbolos/aquecimento.gif" title="' . JText::_('FUNCAO_DE_AQUECIMENTO') . '" style="cursor:help;">&nbsp;&nbsp;';
                            }
                            if ($result[0]->carbono) {
                                echo '<img style="margin-top:1%" src="imagens/produtos/simbolos/carbono.gif" title="' . JText::_('AJUSTES_TECIDO_AMETISTA') . '" style="cursor:help;">&nbsp;&nbsp;';
                            }
                            if ($result[0]->confort) {
                                echo '<img style="margin-top:1%" src="imagens/produtos/simbolos/confortavel.gif" title="' . JText::_('MAXIMO_CONFORTO') . '" style="cursor:help;">&nbsp;&nbsp;';
                            }
                            if ($result[0]->cortaven) {
                                echo '<img style="margin-top:1%" src="imagens/produtos/simbolos/cortavento.gif" title="' . JText::_('CORTA_VENTO') . '" style="cursor:help;">&nbsp;&nbsp;';
                            }
                            if ($result[0]->dryclim) {
                                echo '<img style="margin-top:1%" src="imagens/produtos/simbolos/dryclim.gif" title="' . JText::_('TECIDO_TECNICO_DRYCLIM') . '" style="cursor:help;">&nbsp;&nbsp;';
                            }
                            if ($result[0]->drystorm) {
                                echo '<img style="margin-top:1%" src="imagens/produtos/simbolos/drystorm.gif" title="' . JText::_('TECIDO_TECNICO_WIND_TEX') . '" style="cursor:help;">&nbsp;&nbsp;';
                            }
                            if ($result[0]->elastic) {
                                echo '<img style="margin-top:1%" src="imagens/produtos/simbolos/elastico.gif" title="' . JText::_('ELASTICIDADE') . '" style="cursor:help;">&nbsp;&nbsp;';
                            }
                            if ($result[0]->flatlock) {
                                echo '<img style="margin-top:1%" src="imagens/produtos/simbolos/flatlock.gif" title="' . JText::_('COSTURAS_PLANAS_FLAT_LOCK') . '" style="cursor:help;">&nbsp;&nbsp;';
                            }
                            if ($result[0]->fresc) {
                                echo '<img style="margin-top:1%" src="imagens/produtos/simbolos/frescura.gif" title="' . JText::_('MAXIMA_FRESCURA') . '" style="cursor:help;">&nbsp;&nbsp;';
                            }
                            if ($result[0]->frio) {
                                echo '<img style="margin-top:1%" src="imagens/produtos/simbolos/frio.gif" title="' . JText::_('INDICADO_CLIMAS_MAIS_FRIOS') . '" style="cursor:help;">&nbsp;&nbsp;';
                            }
                            if ($result[0]->ikk) {
                                echo '<img style="margin-top:1%" src="imagens/produtos/simbolos/ikk.gif" title="' . JText::_('FECHO_ALTA_QUALIDADE_IKK') . '" style="cursor:help;">&nbsp;&nbsp;';
                            }
                            if ($result[0]->imperme) {
                                echo '<img style="margin-top:1%" src="imagens/produtos/simbolos/impermeavel.gif" title="' . JText::_('TECIDO_REPELENTE_AGUA') . '" style="cursor:help;">&nbsp;&nbsp;';
                            }
                            if ($result[0]->multicam) {
                                echo '<img style="margin-top:1%" src="imagens/produtos/simbolos/multicamada.gif" title="' . JText::_('MULTI_CAMADA') . '" style="cursor:help;">&nbsp;&nbsp;';
                            }
                            if ($result[0]->reflet) {
                                echo '<img style="margin-top:1%" src="imagens/produtos/simbolos/refletor.gif" title="' . JText::_('COMPONENTE_REFLETOR_PARA_MELHOR_VISIBILIDADE') . '" style="cursor:help;">&nbsp;&nbsp;';
                            }
                            if ($result[0]->respir) {
                                echo '<img style="margin-top:1%" src="imagens/produtos/simbolos/respiravel.gif" title="' . JText::_('TECIDO_RESPIRAVEL') . '" style="cursor:help;">&nbsp;&nbsp;';
                            }
                            if ($result[0]->silico) {
                                echo '<img style="margin-top:1%" src="imagens/produtos/simbolos/silicone.gif" title="' . JText::_('BAINHAS_SILICONE') . '" style="cursor:help;">&nbsp;&nbsp;';
                            }
                            if ($result[0]->termoreg) {
                                echo '<img style="margin-top:1%" src="imagens/produtos/simbolos/termoregulador.gif" title="' . JText::_('FUNCAO_TERMOREGULADOR') . '" style="cursor:help;">&nbsp;&nbsp;';
                            }
                            ?>
                        </td>
                        <td width="20">&nbsp;</td>
                    </tr>
                </table>
            </div>
            <div class="spacer-buy-area">

                <?php
                if ($this->showRating) {
                    $maxrating = VmConfig::get('vm_maximum_rating_scale', 5);

                    if (empty($this->rating)) {
                        ?>
                        <span class="vote"><?php echo JText::_('COM_VIRTUEMART_RATING') . ' ' . JText::_('COM_VIRTUEMART_UNRATED') ?></span>
                        <?php
                    } else {
                        $ratingwidth = $this->rating->rating * 24; //I don't use round as percetntage with works perfect, as for me
                        ?>
                        <span class="vote">
                            <?php echo JText::_('COM_VIRTUEMART_RATING') . ' ' . round($this->rating->rating) . '/' . $maxrating; ?><br/>
                            <span title=" <?php echo (JText::_("COM_VIRTUEMART_RATING_TITLE") . round($this->rating->rating) . '/' . $maxrating) ?>" class="ratingbox" style="display:inline-block;">
                                <span class="stars-orange" style="width:<?php echo $ratingwidth . 'px'; ?>">
                                </span>
                            </span>
                        </span>
                        <?php
                    }
                }

                echo $this->loadTemplate('showprices');
                echo $this->loadTemplate('addtocart');
                ?>

                <?php
// Availability
                $stockhandle = VmConfig::get('stockhandle', 'none');
                $product_available_date = substr($this->product->product_available_date, 0, 10);
                $current_date = date("Y-m-d");
                if (($this->product->product_in_stock - $this->product->product_ordered) < 1) {
                    if ($product_available_date != '0000-00-00' and $current_date < $product_available_date) {
                        ?>	<div class="availability">
                        <?php echo JText::_('COM_VIRTUEMART_PRODUCT_AVAILABLE_DATE') . ': ' . JHTML::_('date', $this->product->product_available_date, JText::_('DATE_FORMAT_LC4')); ?>
                        </div>
                        <?php
                    } else if ($stockhandle == 'risetime' and VmConfig::get('rised_availability') and empty($this->product->product_availability)) {
                        ?>	<div class="availability">
                        <?php echo (file_exists(JPATH_BASE . DS . VmConfig::get('assets_general_path') . 'images/availability/' . VmConfig::get('rised_availability'))) ? JHTML::image(JURI::root() . VmConfig::get('assets_general_path') . 'images/availability/' . VmConfig::get('rised_availability', '7d.gif'), VmConfig::get('rised_availability', '7d.gif'), array('class' => 'availability')) : JText::_(VmConfig::get('rised_availability')); ?>
                        </div>
                        <?php
                    } else if (!empty($this->product->product_availability)) {
                        ?>
                        <div class="availability">
                            <?php echo (file_exists(JPATH_BASE . DS . VmConfig::get('assets_general_path') . 'images/availability/' . $this->product->product_availability)) ? JHTML::image(JURI::root() . VmConfig::get('assets_general_path') . 'images/availability/' . $this->product->product_availability, $this->product->product_availability, array('class' => 'availability')) : JText::_($this->product->product_availability); ?>
                        </div>
                        <?php
                    }
                } else if ($product_available_date != '0000-00-00' and $current_date < $product_available_date) {
                    ?>	<div class="availability">
                    <?php echo JText::_('COM_VIRTUEMART_PRODUCT_AVAILABLE_DATE') . ': ' . JHTML::_('date', $this->product->product_available_date, JText::_('DATE_FORMAT_LC4')); ?>
                    </div>
                    <?php
                }
                ?>

                <?php
// Ask a question about this product
                if (VmConfig::get('ask_question', 0) == 1) {
                    ?>
                    <div class="ask-a-question">
                        <a class="ask-a-question" href="<?php echo $this->askquestion_url ?>" rel="nofollow" ><?php echo JText::_('COM_VIRTUEMART_PRODUCT_ENQUIRY_LBL') ?></a>
                        <!--<a class="ask-a-question modal" rel="{handler: 'iframe', size: {x: 700, y: 550}}" href="<?php echo $this->askquestion_url ?>"><?php echo JText::_('COM_VIRTUEMART_PRODUCT_ENQUIRY_LBL') ?></a>-->
                    </div>
                <?php }
                ?>

                <?php
                // Manufacturer of the Product
                if (VmConfig::get('show_manufacturers', 1) && !empty($this->product->virtuemart_manufacturer_id)) {
                    echo $this->loadTemplate('manufacturer');
                }
                ?>

            </div>
        </div>
    </div>
    <div class="clear"></div>

    <?php
// event onContentBeforeDisplay
    echo $this->product->event->beforeDisplayContent;
    ?>

    <?php
// Product Description
    if (!empty($result[0]->imgtam)) {
        ?>
        <header class="text-center info_title">
            <header class="text-center info_title elipse-border-top box-shadow-destaques" style="padding-top:20px; margin-top:20px;">
                <h2 class="text-uppercase elipse-border-bottom" style="padding-bottom:20px;"><?php echo JText::_('COM_VIRTUEMART_PRODUCT_TABLE_SIZE') ?></h2>
            </header>
        </header>
        <div class="product-description col-xs-12" align="center">
            <img src="imagens/produtos/tabelas_tamanhos/<?php echo strtolower($result[0]->imgtam); ?>" style="cursor:help;">
        </div>
        <?php
    } // Product Description END

    if (!empty($this->product->customfieldsSorted['normal'])) {
        $this->position = 'normal';
        echo $this->loadTemplate('customfields');
    } // Product custom_fields END
// Product Packaging
    $product_packaging = '';
    if ($this->product->product_box) {
        ?>
        <div class="product-box">
            <?php
            echo JText::_('COM_VIRTUEMART_PRODUCT_UNITS_IN_BOX') . $this->product->product_box;
            ?>
        </div>
    <?php } // Product Packaging END
    ?>

    <?php
    if (!empty($this->product->customfieldsRelatedProducts)) {
        echo $this->loadTemplate('relatedproducts');
    } // Product customfieldsRelatedProducts END

    if (!empty($this->product->customfieldsRelatedCategories)) {
        echo $this->loadTemplate('relatedcategories');
    } // Product customfieldsRelatedCategories END
    // Show child categories
    if (VmConfig::get('showCategory', 1)) {
        echo $this->loadTemplate('showcategory');
    }
    if (!empty($this->product->customfieldsSorted['onbot'])) {
        $this->position = 'onbot';
        echo $this->loadTemplate('customfields');
    } // Product Custom ontop end
    ?>

    <?php
    // onContentAfterDisplay event
    echo $this->product->event->afterDisplayContent;
    ?>

    <?php
    echo $this->loadTemplate('reviews');
    ?>
    <script>
        function setfocus(e) {
            if (e.hasClass("focus"))
                e.removeClass("focus");
            else
                e.addClass("focus");
        }
    </script>
    <header class="text-center info_title">
        <header class="text-center info_title elipse-border-top box-shadow-destaques" style="padding-top:20px; margin-top:20px;">
            <h2 class="text-uppercase elipse-border-bottom" style="padding-bottom:20px;"><small><?php echo JText::_('NOVOSCANAIS_PRODUCTS'); ?></small><?php echo JText::_('NOVOSCANAIS_RELATED'); ?></h2>
        </header>
        <div class="owl-carousel owl-theme products-slider owl-loaded owl-drag">
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

            while ($cur_cell < min(10, sizeof($result))) {

                $product_rel = $productModel->getProduct($result[$cur_cell]->virtuemart_product_id);
                $imagem = $result[$cur_cell]->file_url;

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
                <div class="item">
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
                        <div class="title text-center">
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
    </section>
</div>
