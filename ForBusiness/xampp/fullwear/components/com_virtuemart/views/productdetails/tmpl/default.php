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

if(JRequest::getInt('print',false)){
?>
<body onload="javascript:print();">
<?php }

// addon for joomla modal Box
JHTML::_('behavior.modal');

$MailLink = 'index.php?option=com_virtuemart&view=productdetails&task=recommend&virtuemart_product_id=' . $this->product->virtuemart_product_id . '&virtuemart_category_id=' . $this->product->virtuemart_category_id . '&tmpl=component';

$boxFuncReco = '';
$boxFuncAsk = '';
if(VmConfig::get('usefancy',1)){
	vmJsApi::js( 'fancybox/jquery.fancybox-1.3.4.pack');
	vmJsApi::css('jquery.fancybox-1.3.4');
	if(VmConfig::get('show_emailfriend',0)){
		$boxReco = "jQuery.fancybox({
				href: '" . $MailLink . "',
				type: 'iframe',
				height: '550'
			});";
	}
	if(VmConfig::get('ask_question', 0)){
		$boxAsk = "jQuery.fancybox({
				href: '" . $this->askquestion_url . "',
				type: 'iframe',
				height: '550'
			});";
	}

} else {
	vmJsApi::js( 'facebox' );
	vmJsApi::css( 'facebox' );
	if(VmConfig::get('show_emailfriend',0)){
		$boxReco = "jQuery.facebox({
				iframe: '" . $MailLink . "',
				rev: 'iframe|550|550'
			});";
	}
	if(VmConfig::get('ask_question', 0)){
		$boxAsk = "jQuery.facebox({
				iframe: '" . $this->askquestion_url . "',
				rev: 'iframe|550|550'
			});";
	}
}
if(VmConfig::get('show_emailfriend',0) ){
	$boxFuncReco = "jQuery('a.recommened-to-friend').click( function(){
					".$boxReco."
			return false ;
		});";
}
if(VmConfig::get('ask_question', 0)){
	$boxFuncAsk = "jQuery('a.ask-a-question').click( function(){
					".$boxAsk."
			return false ;
		});";
}

if(!empty($boxFuncAsk) or !empty($boxFuncReco)){
	$document = JFactory::getDocument();
	$document->addScriptDeclaration("
//<![CDATA[
	jQuery(document).ready(function($) {
		".$boxFuncReco."
		".$boxFuncAsk."
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

<div class="productdetails-view productdetails">

    <?php
    // Product Navigation
    if (VmConfig::get('product_navigation', 1)) {
	?>
        <div class="product-neighbours">
	    <?php
	    if (!empty($this->product->neighbours ['previous'][0])) {
		$prev_link = JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $this->product->neighbours ['previous'][0] ['virtuemart_product_id'] . '&virtuemart_category_id=' . $this->product->virtuemart_category_id, FALSE);
		echo JHTML::_('link', $prev_link, $this->product->neighbours ['previous'][0]
			['product_name'], array('rel'=>'prev', 'class' => 'previous-page'));
	    }
	    if (!empty($this->product->neighbours ['next'][0])) {
		$next_link = JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $this->product->neighbours ['next'][0] ['virtuemart_product_id'] . '&virtuemart_category_id=' . $this->product->virtuemart_category_id, FALSE);
		echo JHTML::_('link', $next_link, $this->product->neighbours ['next'][0] ['product_name'], array('rel'=>'next','class' => 'next-page'));
	    }
	    ?>
    	<div class="clear"></div>
        </div>
    <?php } // Product Navigation END
    ?>

	<?php // Back To Category Button
	if ($this->product->virtuemart_category_id) {
		$catURL =  JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id='.$this->product->virtuemart_category_id, FALSE);
		$categoryName = $this->product->category_name ;
	} else {
		$catURL =  JRoute::_('index.php?option=com_virtuemart');
		$categoryName = jText::_('COM_VIRTUEMART_SHOP_HOME') ;
	}
	?>
	<div class="back-to-category">
    	<a href="<?php echo $catURL ?>" class="product-details" title="<?php echo $categoryName ?>"><?php echo JText::sprintf('COM_VIRTUEMART_CATEGORY_BACK_TO',$categoryName) ?></a>
	</div>

    <?php // Product Title   ?>
    <h1><?php echo $this->product->product_name ?></h1>
    <?php // Product Title END   ?>

    <?php // afterDisplayTitle Event
    echo $this->product->event->afterDisplayTitle ?>
	
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
	    echo $this->linkIcon($MailLink, 'COM_VIRTUEMART_EMAIL', 'emailButton', 'show_emailfriend', false,true,false,'class="recommened-to-friend"');
	    ?>
    	<div class="clear"></div>
        </div>
    <?php } // PDF - Print - Email Icon END
    ?>

    <?php
    // Product Short Description
    if (!empty($this->product->product_s_desc)) {
	?>
        <div class="product-short-description">
	    <?php
	    /** @todo Test if content plugins modify the product description */
		$pieces = explode("|||", $this->product->product_sku);
	    echo nl2br($pieces[0]);
	    ?>
        </div>
	<?php
    } // Product Short Description END


    if (!empty($this->product->customfieldsSorted['ontop'])) {
	$this->position = 'ontop';
	echo $this->loadTemplate('customfields');
    } // Product Custom ontop end
    ?>

    <div>
	<div class="width50 floatleft">
<?php
echo $this->loadTemplate('images');
?>
	</div>

	<?php
		$language =& JFactory::getLanguage();
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
		$sql .= "		inner join e506s_virtuemart_products_".str_replace('-', '_', strtolower(strval($language->getTag())))." B on A.virtuemart_product_id = B.virtuemart_product_id ";
		$sql .= "		inner join e506s_fastseller_product_type_4 C on A.virtuemart_product_id = C.product_id ";
		$sql .= "	where A.virtuemart_product_id = " . $this->product->virtuemart_product_id;
		
		$db->setQuery($sql);  
		$result = $db->loadObjectList();
	?>
	
	<div class="width50 floatright">
		<div class="titulo_fundo">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="45">&nbsp;</td>
					<td class="titulo2">
						<span class="titulo2">&nbsp;<?php echo $this->product->product_name; ?> &nbsp;
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
							echo '<a style="color:#F30; padding:2px; border: 1px solid #F30; font-weight: bold;">';
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
									echo $results[0][0];
								}
								else {
									echo $result[0]->Categoria;
								}
							}
							else {
								echo $result[0]->Categoria;
							}
							echo '</a>&nbsp;';
						?>
						<?php
							echo '<a style="color:#F30; padding:2px; border: 1px solid #F30; font-weight: bold;">';
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
									echo $results[0][0];
								}
								else {
									echo $result[0]->Modalidade;
								}
							}
							else {
								echo $result[0]->Modalidade;
							}
							echo '</a>&nbsp;';
						?>
						<?php
							echo '<a style="color:#F30; padding:2px; border: 1px solid #F30; font-weight: bold;">';
							if ( $language->getTag() == "en-GB" ) {
								$query = $db->getQuery(true);
								$query->select($db->quoteName(array('en_gb')));
								$query->from($db->quoteName('#__filtros'));
								$query->where($db->quoteName('pt_pt') . ' = '. $db->quote($result[0]->Genero) . ' AND ' . $db->quoteName('nome') . ' = '. $db->quote('genero') );
								
								$db->setQuery($query);
								$db->execute();
								$num_rows = $db->getNumRows();
								
								if( $num_rows > 0 ) {
									$results = $db->loadRowList();
									echo $results[0][0];
								}
								else {
									echo $result[0]->Genero;
								}
							}
							else {
								if( $result[0]->Genero == "MASCULINO;FEMININO" )
									echo "UNISSEXO";
								else
									echo $result[0]->Genero;
							}
							echo '</a>&nbsp;';
						?>
						<?php
							echo '<a style="color:#F30; padding:2px; border: 1px solid #F30; font-weight: bold;">';
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
									echo $results[0][0];
								}
								else {
									echo $result[0]->Linha;
								}
							}
							else {
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
					<td>
						<?php
							if( $language->getTag() == "en-GB" ) {
								if( $result[0]->antibact ) { echo '<img src="imagens/produtos/simbolos/antibacteriano.gif" title="Anti-Bacterial treatment" style="cursor:help;">&nbsp;&nbsp;'; } 
								if( $result[0]->aqueci ) { echo '<img src="imagens/produtos/simbolos/aquecimento.gif" title="For cold weather cycling, thermal fabric" style="cursor:help;">&nbsp;&nbsp;'; } 
								if( $result[0]->carbono ) { echo '<img src="imagens/produtos/simbolos/carbono.gif" title="Fit carbon Lycra provide maximum comfort" style="cursor:help;">&nbsp;&nbsp;'; } 
								if( $result[0]->confort ) { echo '<img src="imagens/produtos/simbolos/confortavel.gif" title="Maximum comfort and performance for the athlete" style="cursor:help;">&nbsp;&nbsp;'; } 
								if( $result[0]->cortaven ) { echo '<img src="imagens/produtos/simbolos/cortavento.gif" title="High Performance Repel TEFLON®" style="cursor:help;">&nbsp;&nbsp;'; } 
								if( $result[0]->dryclim ) { echo '<img src="imagens/produtos/simbolos/dryclim.gif" title="Expel sweat ,provide  comfort for the athlete" style="cursor:help;">&nbsp;&nbsp;'; } 
								if( $result[0]->drystorm ) { echo '<img src="imagens/produtos/simbolos/drystorm.gif" title="A lightweight waterproof and windproof membrane" style="cursor:help;">&nbsp;&nbsp;'; } 
								if( $result[0]->elastic ) { echo '<img src="imagens/produtos/simbolos/elastico.gif" title="Stretch fabrics keep your clothes Fit" style="cursor:help;">&nbsp;&nbsp;'; } 
								if( $result[0]->flatlock ) { echo '<img src="imagens/produtos/simbolos/flatlock.gif" title="Flat-lock Seams ,provide maximum comfort" style="cursor:help;">&nbsp;&nbsp;'; } 
								if( $result[0]->fresc ) { echo '<img src="imagens/produtos/simbolos/frescura.gif" title="For warm weather cycling, Coolmax®" style="cursor:help;">&nbsp;&nbsp;'; } 
								if( $result[0]->frio ) { echo '<img src="imagens/produtos/simbolos/frio.gif" title="For cold weather cycling" style="cursor:help;">&nbsp;&nbsp;'; } 
								if( $result[0]->ikk ) { echo '<img src="imagens/produtos/simbolos/ikk.gif" title="All zippers used  are industry leader YKK" style="cursor:help;">&nbsp;&nbsp;'; } 
								if( $result[0]->imperme ) { echo '<img src="imagens/produtos/simbolos/impermeavel.gif" title="Hydrophobic finish to repel water and spray" style="cursor:help;">&nbsp;&nbsp;'; } 
								if( $result[0]->multicam ) { echo '<img src="imagens/produtos/simbolos/multicamada.gif" title="Multilayer fabrics fitting the shape" style="cursor:help;">&nbsp;&nbsp;'; } 
								if( $result[0]->reflet ) { echo '<img src="imagens/produtos/simbolos/refletor.gif" title="Reflective inserts for high vision" style="cursor:help;">&nbsp;&nbsp;'; } 
								if( $result[0]->respir ) { echo '<img src="imagens/produtos/simbolos/respiravel.gif" title="Breathability, expel sweat" style="cursor:help;">&nbsp;&nbsp;'; } 
								if( $result[0]->silico ) { echo '<img src="imagens/produtos/simbolos/silicone.gif" title="Silicone strip provide maximum comfort" style="cursor:help;">&nbsp;&nbsp;'; } 
								if( $result[0]->termoreg ) { echo '<img src="imagens/produtos/simbolos/termoregulador.gif" title="Ideal for cold weather cycling, Thermolite®" style="cursor:help;">&nbsp;&nbsp;'; } 
							}
							else {
								if( $result[0]->antibact ) { echo '<img src="imagens/produtos/simbolos/antibacteriano.gif" title="Componentes Anti-Bacterianos" style="cursor:help;">&nbsp;&nbsp;'; } 
								if( $result[0]->aqueci ) { echo '<img src="imagens/produtos/simbolos/aquecimento.gif" title="Função de aquecimento" style="cursor:help;">&nbsp;&nbsp;'; } 
								if( $result[0]->carbono ) { echo '<img src="imagens/produtos/simbolos/carbono.gif" title="Ajustes em tecido Ametista" style="cursor:help;">&nbsp;&nbsp;'; } 
								if( $result[0]->confort ) { echo '<img src="imagens/produtos/simbolos/confortavel.gif" title="Máximo Conforto" style="cursor:help;">&nbsp;&nbsp;'; } 
								if( $result[0]->cortaven ) { echo '<img src="imagens/produtos/simbolos/cortavento.gif" title="Corta-Vento" style="cursor:help;">&nbsp;&nbsp;'; } 
								if( $result[0]->dryclim ) { echo '<img src="imagens/produtos/simbolos/dryclim.gif" title="Tecido técnico DryCLim" style="cursor:help;">&nbsp;&nbsp;'; } 
								if( $result[0]->drystorm ) { echo '<img src="imagens/produtos/simbolos/drystorm.gif" title="Tecido técnico Wind tex " style="cursor:help;">&nbsp;&nbsp;'; } 
								if( $result[0]->elastic ) { echo '<img src="imagens/produtos/simbolos/elastico.gif" title="Elasticidade" style="cursor:help;">&nbsp;&nbsp;'; } 
								if( $result[0]->flatlock ) { echo '<img src="imagens/produtos/simbolos/flatlock.gif" title="Costuras planas em Flat Lock" style="cursor:help;">&nbsp;&nbsp;'; } 
								if( $result[0]->fresc ) { echo '<img src="imagens/produtos/simbolos/frescura.gif" title="Máxima frescura" style="cursor:help;">&nbsp;&nbsp;'; } 
								if( $result[0]->frio ) { echo '<img src="imagens/produtos/simbolos/frio.gif" title="Indicado para climas mais frios" style="cursor:help;">&nbsp;&nbsp;'; } 
								if( $result[0]->ikk ) { echo '<img src="imagens/produtos/simbolos/ikk.gif" title="Fecho de alta qualidade IKK" style="cursor:help;">&nbsp;&nbsp;'; } 
								if( $result[0]->imperme ) { echo '<img src="imagens/produtos/simbolos/impermeavel.gif" title="Tecido repelente à água" style="cursor:help;">&nbsp;&nbsp;'; } 
								if( $result[0]->multicam ) { echo '<img src="imagens/produtos/simbolos/multicamada.gif" title="Multi Camada" style="cursor:help;">&nbsp;&nbsp;'; } 
								if( $result[0]->reflet ) { echo '<img src="imagens/produtos/simbolos/refletor.gif" title="Componente refletor para melhor visibilidade" style="cursor:help;">&nbsp;&nbsp;'; } 
								if( $result[0]->respir ) { echo '<img src="imagens/produtos/simbolos/respiravel.gif" title="Tecido respirável" style="cursor:help;">&nbsp;&nbsp;'; } 
								if( $result[0]->silico ) { echo '<img src="imagens/produtos/simbolos/silicone.gif" title="Baínhas de silicone" style="cursor:help;">&nbsp;&nbsp;'; } 
								if( $result[0]->termoreg ) { echo '<img src="imagens/produtos/simbolos/termoregulador.gif" title="Função termoregulador" style="cursor:help;">&nbsp;&nbsp;'; } 
							}
						?>
					</td>
					<td width="20">&nbsp;</td>
				</tr>
			</table>
		</div>
	    <div class="spacer-buy-area">

		<?php
		// TODO in Multi-Vendor not needed at the moment and just would lead to confusion
		/* $link = JRoute::_('index2.php?option=com_virtuemart&view=virtuemart&task=vendorinfo&virtuemart_vendor_id='.$this->product->virtuemart_vendor_id);
		  $text = JText::_('COM_VIRTUEMART_VENDOR_FORM_INFO_LBL');
		  echo '<span class="bold">'. JText::_('COM_VIRTUEMART_PRODUCT_DETAILS_VENDOR_LBL'). '</span>'; ?><a class="modal" href="<?php echo $link ?>"><?php echo $text ?></a><br />
		 */
		?>

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
				<span class="stars-orange" style="width:<?php echo $ratingwidth.'px'; ?>">
				</span>
			    </span>
			</span>
			<?php
		    }
		}
		// if (is_array($this->productDisplayShipments)) {
		    // foreach ($this->productDisplayShipments as $productDisplayShipment) {
			// echo $productDisplayShipment . '<br />';
		    // }
		// }
		// if (is_array($this->productDisplayPayments)) {
		    // foreach ($this->productDisplayPayments as $productDisplayPayment) {
			// echo $productDisplayPayment . '<br />';
		    // }
		// }
		// Product Price
		    // the test is done in show_prices
		//if ($this->show_prices and (empty($this->product->images[0]) or $this->product->images[0]->file_is_downloadable == 0)) {
		    echo $this->loadTemplate('showprices');
		//}
		?>

		<?php
		// Add To Cart Button
// 			if (!empty($this->product->prices) and !empty($this->product->images[0]) and $this->product->images[0]->file_is_downloadable==0 ) {
//		if (!VmConfig::get('use_as_catalog', 0) and !empty($this->product->prices['salesPrice'])) {
		    echo $this->loadTemplate('addtocart');
//		}  // Add To Cart Button END
		?>

		<?php
		// Availability
		$stockhandle = VmConfig::get('stockhandle', 'none');
		$product_available_date = substr($this->product->product_available_date,0,10);
		$current_date = date("Y-m-d");
		if (($this->product->product_in_stock - $this->product->product_ordered) < 1) {
			if ($product_available_date != '0000-00-00' and $current_date < $product_available_date) {
			?>	<div class="availability">
					<?php echo JText::_('COM_VIRTUEMART_PRODUCT_AVAILABLE_DATE') .': '. JHTML::_('date', $this->product->product_available_date, JText::_('DATE_FORMAT_LC4')); ?>
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
		}
		else if ($product_available_date != '0000-00-00' and $current_date < $product_available_date) {
		?>	<div class="availability">
				<?php echo JText::_('COM_VIRTUEMART_PRODUCT_AVAILABLE_DATE') .': '. JHTML::_('date', $this->product->product_available_date, JText::_('DATE_FORMAT_LC4')); ?>
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
	<div class="clear"></div>
    </div>

	<?php // event onContentBeforeDisplay
	echo $this->product->event->beforeDisplayContent; ?>

	<?php
	// Product Description
	if (!empty($result[0]->imgtam)) { ?>
        <div class="product-description" align="center">
			<span class="title"><?php echo JText::_('COM_VIRTUEMART_PRODUCT_TABLE_SIZE') ?></span>
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
	        echo JText::_('COM_VIRTUEMART_PRODUCT_UNITS_IN_BOX') .$this->product->product_box;
	    ?>
        </div>
    <?php } // Product Packaging END
    ?>

    <?php
    // Product Files
    // foreach ($this->product->images as $fkey => $file) {
    // Todo add downloadable files again
    // if( $file->filesize > 0.5) $filesize_display = ' ('. number_format($file->filesize, 2,',','.')." MB)";
    // else $filesize_display = ' ('. number_format($file->filesize*1024, 2,',','.')." KB)";

    /* Show pdf in a new Window, other file types will be offered as download */
    // $target = stristr($file->file_mimetype, "pdf") ? "_blank" : "_self";
    // $link = JRoute::_('index.php?view=productdetails&task=getfile&virtuemart_media_id='.$file->virtuemart_media_id.'&virtuemart_product_id='.$this->product->virtuemart_product_id);
    // echo JHTMl::_('link', $link, $file->file_title.$filesize_display, array('target' => $target));
    // }
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
    	$this->position='onbot';
    	echo $this->loadTemplate('customfields');
    } // Product Custom ontop end
    ?>

<?php // onContentAfterDisplay event
echo $this->product->event->afterDisplayContent; ?>

<?php
echo $this->loadTemplate('reviews');
?>
	<div class="related_products">
		<span class="title related_products_title"><?php echo JText::_('COM_VIRTUEMART_RELATED_PRODUCTS') ?></span>
	<?php
		$language =& JFactory::getLanguage();
		$language->load('mod_virtuemart_product');
		$cur_fam = explode("|||", $this->product->product_sku);
		$cur_fam = $cur_fam[1];

		$db = JFactory::getDbo();
		$sql = "";
		
		$sql .= "	select A.virtuemart_product_id, B.product_name, B.product_s_desc, B.slug, A.desconto, A.novidade, ";
		$sql .= "	ifnull(( select file_url from e506s_virtuemart_product_medias C inner join e506s_virtuemart_medias D on C.virtuemart_media_id = D.virtuemart_media_id where C.virtuemart_product_id = A.virtuemart_product_id order by C.ordering limit 1), 'images/stories/virtuemart/product/logotipo.png') file_url, ";
		$sql .= "	C.Modalidade, C.Genero, C.Linha, C.Categoria";
		$sql .= "	from e506s_virtuemart_products A ";
		$sql .= "		inner join e506s_virtuemart_products_".str_replace('-', '_', strtolower(strval($language->getTag())))." B on A.virtuemart_product_id = B.virtuemart_product_id ";
		$sql .= "		inner join e506s_fastseller_product_type_4 C on A.virtuemart_product_id = C.product_id ";
		$sql .= "	where A.phc_ref like '%|||$cur_fam' and A.virtuemart_product_id <> " . $this->product->virtuemart_product_id;
		$sql .= "	limit 10 ";
		
		$db->setQuery($sql);  
		$result = $db->loadObjectList();
		shuffle($result);
		$cur_cell = 0;
		$productModel = VmModel::getModel('Product');
		
		while( $cur_cell < min( 5, sizeof($result) ) ) {
			
			$product_rel = $productModel->getProduct($result[$cur_cell]->virtuemart_product_id);
			
			$imagem = $result[$cur_cell]->file_url;
			
			if ( strpos($product_rel->link, "en/produtos") === false ) {
				$p_link = $product_rel->link;
			}
			else {
				$p_link = str_replace("en/produtos", "en/products", $product_rel->link);
			}
		?>
			<div class="related_products_cell product_detail_item">
				<?php
					if ( $result[$cur_cell]->desconto > 0 ) {
				?>
					<div class="promotion"><span class="discount">- <?php echo $result[$cur_cell]->desconto; ?>%</span></div>
				<?php
					}
					switch( $result[$cur_cell]->Linha ) {
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
				<div class="linha_label"><span class="linha_label_txt <?php echo $linha_cor; ?>"><?php echo $result[$cur_cell]->Linha; ?></span></div>
				<a href="<?php echo $p_link; ?>" title="<?php echo $product_rel->product_name ?>" class="product-image">
					<img src="<?php echo $imagem; ?>" width="150" height="200" alt="<?php echo $product_rel->product_name ?>">
				</a>
				<h2 class="product-name">
					<a href="<?php echo $p_link; ?>" title="<?php echo $product_rel->category_name . ' - ' . $product_rel->product_name ?>">
					<?php 
						echo $product_rel->category_name;
						echo '<br>';
						if ( $result[$cur_cell]->novidade > 0 ) {
						?>
							<div class="new_prod"><span class="new_prod_label"><?php echo JText::_ ('COM_VIRTUEMART_NEW'); ?></span></div>
						<?php
						}
						echo $product_rel->product_name 
					?>
					</a>
				</h2>
				<div class="price-box">
					<p class="special-price">
						<span class="price" id="product-price-1197"><?php echo number_format($product_rel->prices["basePriceWithTax"],2); ?>&nbsp;€</span>
					</p>
				</div>
				<div class="actions">
				<?php
					if ( $language->getTag() == "en-GB" ) {
						$query = $db->getQuery(true);
						$query->select($db->quoteName(array('en_gb')));
						$query->from($db->quoteName('#__filtros'));
						$query->where($db->quoteName('pt_pt') . ' = '. $db->quote($result[$cur_cell]->Categoria) . ' AND ' . $db->quoteName('nome') . ' = '. $db->quote('categoria') );
						
						$db->setQuery($query);
						$db->execute();
						$num_rows = $db->getNumRows();
						
						if( $num_rows > 0 ) {
							$results = $db->loadRowList();
							echo '<span style="font-size:10px">'. $results[0][0] .'</span> &#8226;';
						}
						else {
						?>
							<span style="font-size:10px"><?php echo $result[$cur_cell]->Categoria; ?></span> &#8226;
						<?php
						}
					}
					else {
					?>
						<span style="font-size:10px"><?php echo $result[$cur_cell]->Categoria; ?></span> &#8226;
					<?php
					}
				?>
				<?php
					if ( $language->getTag() == "en-GB" ) {
						$query = $db->getQuery(true);
						$query->select($db->quoteName(array('en_gb')));
						$query->from($db->quoteName('#__filtros'));
						$query->where($db->quoteName('pt_pt') . ' = '. $db->quote($result[$cur_cell]->Modalidade) . ' AND ' . $db->quoteName('nome') . ' = '. $db->quote('modalidade') );
						
						$db->setQuery($query);
						$db->execute();
						$num_rows = $db->getNumRows();
						
						if( $num_rows > 0 ) {
							$results = $db->loadRowList();
							echo '<span style="font-size:10px">'. $results[0][0] .'</span> &#8226;';
						}
						else {
						?>
							<span style="font-size:10px"><?php echo $result[$cur_cell]->Modalidade; ?></span> &#8226;
						<?php
						}
					}
					else {
					?>
						<span style="font-size:10px"><?php echo $result[$cur_cell]->Modalidade; ?></span> &#8226;
					<?php
					}
				?>
				<span style="font-size:10px">
				<?php 
					if( $result[$cur_cell]->Genero == "MALE;FEMALE" or $result[$cur_cell]->Genero == "MASCULINO;FEMININO" ) {
						if ( $language->getTag() == "en-GB" ) {
							echo "GENDERLESS";
						}
						else {
							echo "UNISSEXO";
						}
					}
					else {
						if ( $language->getTag() == "en-GB" ) {
							if( $result[$cur_cell]->Genero == "MASCULINO" )
								echo "MALE";
							if( $result[$cur_cell]->Genero == "FEMININO" )
								echo "FEMALE";
						}
						else {
							echo $result[$cur_cell]->Genero;
						}
					}
				?></span> &#8226;
				<?php
					if ( $language->getTag() == "en-GB" ) {
						$query = $db->getQuery(true);
						$query->select($db->quoteName(array('en_gb')));
						$query->from($db->quoteName('#__filtros'));
						$query->where($db->quoteName('pt_pt') . ' = '. $db->quote($result[$cur_cell]->Linha) . ' AND ' . $db->quoteName('nome') . ' = '. $db->quote('linha') );
						
						$db->setQuery($query);
						$db->execute();
						$num_rows = $db->getNumRows();
						
						if( $num_rows > 0 ) {
							$results = $db->loadRowList();
							echo '<span style="font-size:10px">'. $results[0][0] .'</span>';
						}
						else {
						?>
							<span style="font-size:10px"><?php echo $result[$cur_cell]->Linha; ?></span>
						<?php
						}
					}
					else {
					?>
						<span style="font-size:10px"><?php echo $result[$cur_cell]->Linha; ?></span>
					<?php
					}
				?>
			</div>
			</div>
		<?php
			$cur_cell++;
		}
		
	?>
	</div>
</div>
