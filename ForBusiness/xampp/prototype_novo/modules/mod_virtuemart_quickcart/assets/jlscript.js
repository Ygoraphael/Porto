/**
 * @version		jQueryId: jQuery
 * @author		Codextension
 * @package		Joomla!
 * @subpackage	Module
 * @copyright	Copyright (C) 2008 - 2012 by Codextension. All rights reserved.
 * @license		GNU/GPL, see LICENSE
 */
var mQuickCart = jQuery.noConflict();

mQuickCart(document).ready(function(jQuery){
		jQuery('#vmQuickCartModule #jlcart').hover(
			function(){
				if( jQuery.trim(jQuery(this).children('div.cart_content').html()) && jQuery(this).children('div.cart_content').css('display')=='none' ){
					jQuery(this).children('div.cart_content').slideDown(160);
					jQuery(".cart_content ul.innerItems").mCustomScrollbar("update");
				}
			},
			function(){
				jQuery(this).children('div.cart_content').slideUp(160);
			}
		);
		customScrollbar();
});
function customScrollbar(){
	var module_height = mQuickCart('#vmQuickCartModule #jlcart .cart_content').outerHeight();
	
	if( show_scrollbar && module_height>height_scrollbar){
		mQuickCart(".cart_content ul.innerItems").css('height',height_scrollbar+'px');
		mQuickCart(".cart_content ul.innerItems").mCustomScrollbar({
			scrollButtons:{
				enable:true
			}
		});
	}else{
		mQuickCart(".cart_content ul.innerItems").css('height','auto');
	}
}
function jlremoveitem(id){
	var newstr = id.replace(/[^a-zA-Z0-9]/g,'-');
	//&tmpl=component
	mQuickCart.ajax({
		  url: "index.php?option=com_virtuemart&view=cart&task=delete&cart_virtuemart_product_id="+id,
		  type: "POST",
		  data: { mid: mvmquickcart},
		  error: function ( jqXHR, textStatus, errorThrown ) {
			 alert('Error loading Ajax');
		  },
		  beforeSend: function ( xhr ) {
			  mQuickCart('#vmQuickCartModule #jlcart ul.innerItems li.'+'item-'+newstr+' a.remove_item').html('<img src="'+window.vmSiteurl+'modules/mod_virtuemart_quickcart/assets/images/ajax-loader.gif'+'" alt="loading..."/>');
		  }
	}).done(function( html ) {
		//mQuickCart('#vmQuickCartModule #jlcart ul.innerItems li.'+'item-'+newstr).remove();
		Virtuemart.productUpdate();
	});
}


	var Virtuemart = {
		setproducttype : function (form, id) {
			form.view = null;
			datas = form.serialize();
			var prices = form.parents(".productdetails").find(".product-price");
			if (0 == prices.length) {
				prices = mQuickCart("#productPrice" + id);
			}
			datas = datas.replace("&view=cart", "");
			prices.fadeTo("fast", 0.75);
			mQuickCart.getJSON(window.vmSiteurl + 'index.php?option=com_virtuemart&nosef=1&view=productdetails&task=recalculate&virtuemart_product_id='+id+'&format=json' + window.vmLang, encodeURIComponent(datas),
				function (datas, textStatus) {
					prices.fadeTo("fast", 1);
					// refresh price
					for (var key in datas) {
						var value = datas[key];
						if (value!=0) prices.find("span.Price"+key).show().html(value);
						else prices.find(".Price"+key).html(0).hide();
					}
				});
			return false; // prevent reload
		},
		productUpdate : function(mod) {
			//var jQuery = jQuery ;
			mQuickCart.ajaxSetup({ cache: false });
			
			/*mQuickCart.getJSON(window.vmSiteurl+"modules/mod_virtuemart_quickcart/ajax.php?mid="+mvmquickcart,
				function(datas, textStatus) {
					if (datas.totalProduct >0) {
						mod.find(".vm_cart_products").html("");
						mQuickCart.each(datas.products, function(key, val) {
							mQuickCart("#hiddencontainer .container").clone().appendTo(".vmCartModule .vm_cart_products");
							mQuickCart.each(val, function(key, val) {
								if (mQuickCart("#hiddencontainer .container ."+key)) mod.find(".vm_cart_products ."+key+":last").html(val) ;
							});
						});
						mod.find(".total").html(datas.billTotal);
						mod.find(".show_cart").html(datas.cart_show);
					}
					mod.find(".total_products").html(datas.totalProductTxt);
				}
			);*/
			mQuickCart.ajax({
				  url: window.vmSiteurl+"mvm_quickcart_ajax.php",
				  type: "POST",
				  data: { mid: mvmquickcart},
				  error: function ( jqXHR, textStatus, errorThrown ) {
					 alert('Error loading Ajax');
				  }
			}).done(function( html ) {
				mQuickCart('#vmQuickCartModule #jlcart').html(html);
				 	SqueezeBox.initialize({});
					SqueezeBox.assign(jQuery('a.modal'), {
						parse: 'rel'
					});
					customScrollbar();
			});
		},
		sendtocart : function (form){
			if (Virtuemart.addtocart_popup ==1) {
				Virtuemart.cartEffect(form) ;
			} else {
				form.append('<input type="hidden" name="task" value="add" />');
				form.submit();
			}
		},
		cartEffect : function(form) {
		
				var $ = jQuery;
				mQuickCart.ajaxSetup({ cache: false })
				var datas = form.serialize();
				mQuickCart.getJSON(vmSiteurl+'index.php?option=com_virtuemart&nosef=1&view=cart&task=addJS&format=json'+vmLang,encodeURIComponent(datas),
				function(datas, textStatus) {
					if(datas.stat ==1){

                        var txt = datas.msg;
					} else if(datas.stat ==2){
                        var txt = datas.msg +"<H4>"+form.find(".pname").val()+"</H4>";
                    } else {
                        var txt = "<H4>"+vmCartError+"</H4>"+datas.msg;
                    }
					if(usefancy){
                        $.fancybox({
                                "titlePosition" : 	"inside",
                                "transitionIn"	:	"fade",
                                "transitionOut"	:	"fade",
                                "changeFade"    :   "fast",
                                "type"			:	"html",
                                "autoCenter"    :   true,
                                "closeBtn"      :   false,
                                "closeClick"    :   false,
                                "content"       :   txt
                            }
                        );
                    } else {
                        $.facebox.settings.closeImage = closeImage;
                        $.facebox.settings.loadingImage = loadingImage;
                        //$.facebox.settings.faceboxHtml = faceboxHtml;
                        $.facebox({ text: txt }, 'my-groovy-style');
                    }
					if (mQuickCart(".vmCartModule")[0]) {
						Virtuemart.productUpdate(mQuickCart(".vmCartModule"));
					}
				});
				mQuickCart.ajaxSetup({ cache: true });
		},
		product : function(carts) {
			carts.each(function(){
				var cart = jQuery(this),
				step=cart.find('input[name="quantity"]'),
				addtocart = cart.find('.addtocart-button'),
				plus   = cart.find('.quantity-plus'),
				minus  = cart.find('.quantity-minus'),
				select = cart.find('select'),
				radio = cart.find('input:radio'),
				virtuemart_product_id = cart.find('input[name="virtuemart_product_id[]"]').val(),
				quantity = cart.find('.quantity-input');

                var Ste = parseInt(step.val());
                //Fallback for layouts lower than 2.0.18b
                if(isNaN(Ste)){
                    Ste = 1;
                }
				addtocart.click(function(e) { 
					Virtuemart.sendtocart(cart);
					return false;
				});
				plus.click(function() {
					var Qtt = parseInt(quantity.val());
					if (!isNaN(Qtt)) {
						quantity.val(Qtt + Ste);
					Virtuemart.setproducttype(cart,virtuemart_product_id);
					}
					
				});
				minus.click(function() {
					var Qtt = parseInt(quantity.val());
					if (!isNaN(Qtt) && Qtt>Ste) {
						quantity.val(Qtt - Ste);
					} else quantity.val(Ste);
					Virtuemart.setproducttype(cart,virtuemart_product_id);
				});
				select.change(function() {
					Virtuemart.setproducttype(cart,virtuemart_product_id);
				});
				radio.change(function() {
					Virtuemart.setproducttype(cart,virtuemart_product_id);
				});
				quantity.keyup(function() {
					Virtuemart.setproducttype(cart,virtuemart_product_id);
				});
			});

		}
	};
	/*jQuery.noConflict();
	jQuery(document).ready(function(jQuery) {

		Virtuemart.product(jQuery("form.product"));

		jQuery("form.js-recalculate").each(function(){
			if (jQuery(this).find(".product-fields").length) {
				var id= jQuery(this).find('input[name="virtuemart_product_id[]"]').val();
				Virtuemart.setproducttype(jQuery(this),id);

			}
		});
	});*/

