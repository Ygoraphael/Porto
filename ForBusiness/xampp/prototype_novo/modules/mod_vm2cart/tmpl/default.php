<?php
/*
 * Created on Feb 23, 2014
 *
 * Author: linelabox.com
 * Project: mod_vm2cart_j25
 */


defined('_JEXEC') or die('Restricted access');

?>
<script type="text/javascript">
var vmCartModule; 
window.addEvent('domready',function() {
	document.id('product_list').setStyle('display', 'block');
	document.id('product_list').setStyle('top', -600);
	vmCartModuleFx=new Fx.Morph('product_list');
	document.id('vmCartModule').addEvent('mouseenter',function(e) {
		e.stop();
		vmCartModuleFx.options.duration = 500;
		vmCartModuleFx.options.transition = Fx.Transitions.Quad.easeOut;
		vmCartModuleFx.stop();
		vmCartModuleFx.start({
			top: 25
		});		
	});
	document.id('vmCartModule').addEvent('mouseleave',function(e) {
		e.stop();
		vmCartModuleFx.options.duration = 1000;
		vmCartModuleFx.options.transition = Fx.Transitions.Quad.easeIn;
		vmCartModuleFx.stop();
		vmCartModuleFx.start({
			top: -600
		});		
	});
	<?php
	if(JRequest::getCmd('view')=='productdetails') {
	    ?>
	    $$('.addtocart-button').addEvent('click',function() {
		    document.id('product_list').addClass('show_products');
		    (function(){document.id('product_list').removeClass('show_products')}).delay(15000);
		    window.location.hash='cart';
	    });
	    <?php
	}
	?>
});

function remove_product_cart(elm) {
	var cart_id=elm.getChildren('span').get('text');
	if(document.id('is_opc')) {
	    remove_product(elm.getChildren('span').get('text'));
	} else {
	new Request.HTML({
		'url':'index.php?option=com_virtuemart&view=cart&task=delete',
		'method':'post',
		'data':'cart_virtuemart_product_id='+cart_id,
		'evalScripts':false,
		'onSuccess':function(tree,elms,html,js) {
			//jQuery(".vmCartModule").productUpdate();
			mod=jQuery(".vmCartModule");
			jQuery.getJSON(vmSiteurl+"index.php?option=com_virtuemart&nosef=1&view=cart&task=viewJS&format=json"+vmLang,
				function(datas, textStatus) {
					if (datas.totalProduct >0) {
						mod.find(".vm_cart_products").html("");
						jQuery.each(datas.products, function(key, val) {
							jQuery("#hiddencontainer .container").clone().appendTo(".vmCartModule .vm_cart_products");
							jQuery.each(val, function(key, val) {
								if (jQuery("#hiddencontainer .container ."+key)) mod.find(".vm_cart_products ."+key+":last").html(val) ;
							});
						});
						mod.find(".total").html(datas.billTotal);
						mod.find(".show_cart").html(datas.cart_show);
					} else {
						mod.find(".vm_cart_products").html("");
						mod.find(".show_cart").html("");
						mod.find(".total").html("Cart empty");
						//mod.find(".total").html(datas.billTotal);
					}
					mod.find(".total_products").html(datas.totalProductTxt);
				}
			);
		}
	}).send();
	}
}
</script>
<style type="text/css">
#product_list {
	position: absolute;
	z-index: 200000;
	width: <?php echo $params->def('width',350); ?>px;
    min-height: 20px;
    padding: 10px;
    position: absolute;
    right: -5px;
}
.vm_cart_products{
    padding: 10px;
}
#vmCartModule{
    position: relative;
    cursor: pointer;
}
#vmCartModule .product_attributes  {
text-align:left;
}
#vmCartModule .image {
    float:right;
}
#vmCartModule .total, #vmCartModule .image {
 padding-left:10px; 
}
#vmCartModule .container{ 
width:300px; 
}
#vmCartModule .product_row  {
min-height: 70px;
text-align: left;   
}
#vmCartModule .image img {
    text-align:center;
    height:60px;     
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.15);
}
#vmCartModule .prices  {
      float: right;
    padding: 0 10px; 
}
#vmCartModule .floatright{
    text-align:center !important;
    float:none;
}
</style>
<a name="cart"></a>
<div class="vmCartModule tblboxname" id="vmCartModule">
	<a class="tblboxname" href="index.php?option=com_virtuemart&view=cart"><i class="icon-shopping-cart icon-large"></i><div class="total" style="display:inline;" id="total">
	 <?php echo count($data->products)?($lang->_('COM_VIRTUEMART_CART_TOTAL').' : <strong>'. $data->billTotal.'</strong>'):Jtext::_('MOD_VM2_CART_CART_EMPTY'); ?>
	</a></div>
	<div style="clear:both;"></div>
	<div id="hiddencontainer" style="display:none">
		<div class="container">
			<!-- Image line -->
			<div class="image"></div>
			<div class="prices" style="display:inline;"></div>
			<div class="product_row">
				<span class="quantity"></span>&nbsp;x&nbsp;<span class="product_name"></span><br />
        	<div class="product_attributes"></div>
				<a onclick="remove_product_cart(this);"><span class="product_cart_id" style="display:none;"></span><i class="icon-trash"></i></a>
			</div>
		</div>
	</div>
		<div id="product_list" class="tbboxname tbtboxname tblboxname show_products" style="display:none;">
			<div class="vm_cart_products" id="vm_cart_products">
				<div class="container">
					<?php
					foreach($data->products as $product) {
						?>
						<!-- Image line -->
						<div class="image"><?php echo $product["image"]; ?></div>
						<div class="prices" style="display:inline;"><?php echo $product["prices"]; ?></div>
						<div class="product_row">
							<span class="quantity"><?php echo $product["quantity"]; ?></span>&nbsp;x&nbsp;<span class="product_name tbtboxname"><?php echo $product["product_name"]; ?></span><br />
						  					<?php
						if(!empty($product["product_attributes"])) {
							?>
							<div class="product_attributes tbtboxname"><?php echo $product["product_attributes"]; ?></div>
							<?php
						}
						?>
	          <a class="tbtboxname" onclick="remove_product_cart(this);"><span class="product_cart_id" style="display:none;"><?php echo $product["product_cart_id"]; ?></span><i class="icon-trash"></i></a>
	          </div>
						<?php
					}
					?>
				</div><div style="clear: both;"></div>
			</div>
			<div class="show_cart">
		<?php
				if($data->totalProduct) {
					echo JHTML::_('link',JRoute::_('index.php?option=com_virtuemart&view=cart'.($data->dataValidated==true?'&task=confirm':''),true,vmConfig::get('useSSL',0)),$lang->_($data->dataValidated==true?'COM_VIRTUEMART_CART_CONFIRM':'COM_VIRTUEMART_CART_SHOW'));
				}
				?>
			</div>
		</div>
	<div style="display:none">
		<div class="total_products"></div>
	</div>
	<input type="hidden" id="extra_cart" value="1" />
</div>