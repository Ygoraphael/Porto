<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>" >
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>FULLWEAR :: equipamentos de ciclismo : downhill : triatlo : duatlo</title>
		<link rel="shortcut icon" href="<?php echo $this->baseurl ?>/imagens/layout/icon.ico">
		<link href="<?php echo $this->baseurl ?>/CSS/CSS.css" rel="stylesheet" type="text/css">
		<link href="<?php echo $this->baseurl ?>/CSS/fontes.css" rel="stylesheet" type="text/css">
		<link href="<?php echo $this->baseurl ?>/CSS/buttons.min.css" rel="stylesheet" type="text/css">
		<script src="<?php echo $this->baseurl ?>/js/jquery.min.js"></script>
		<script src="<?php echo $this->baseurl ?>/js/jquery.PrintArea.js"></script>
		<link rel="stylesheet" type="text/css" href="<?php echo $this->baseurl ?>/css/menu_horizontal.css" />
		<jdoc:include type="head" />
		<script type="text/javascript" src="<?php echo $this->baseurl ?>/media/system/js/mootools-more.js"></script>
	</head>
	<body leftmargin="0" topmargin="0" rightmargin="0" bottommargin="0">
		<div class="tab_main">
			<div id="popup" class="modal-box">  
				<header>
					<a href="#" class="js-modal-close close">×</a>
					<h3><?php echo JText::_( 'NavegarPara' ); ?></h3>
				</header>
				<div class="modal-body">
					<center>
						<button type="submit" class="cp-apply-filters button button-caution" onclick="window.location.replace('<?php echo JURI::base(); ?>');"><?php echo JText::_( 'InicioLoja' ); ?></button>
						<button type="submit" class="cp-apply-filters button button-caution" onclick="window.location.replace('http://fullwear.pt');"><?php echo JText::_( 'PaginaFullwear' ); ?></button>
					</center>
				</div>
			</div>
			<table width="100%" border="0" cellspacing="0" cellpadding="0" style="">
				<tr>
					<td>&nbsp;</td>
					<td width="1024" align="center" valign="top">
						<div style="float:right; width:200px; margin-top:11px;">
							<jdoc:include type="modules" name="position-1" />
						</div>
						<div style="float:right; width:150px; margin-top:11px;"></div>
						<div style="float:right; width:400px; margin-top:11px;">
							<jdoc:include type="modules" name="position-5" />
						</div>
						<div style="float:right; width:50px; margin-top:11px;">
							<jdoc:include type="modules" name="position-3" />
						</div>
						<div class="logoi" style="float:right; width:224px; margin-top:11px;">
							<img class="logoi" src="./imagens/layout/logo_fw.jpg" width="220" data-modal-id="popup" />
						</div>
					</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td width="1024" align="right" valign="top"></td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td valign="top">
						<table width="100%" border="0" cellspacing="0" cellpadding="12">
							<tr>
								<td bgcolor="#222222" class="titulo_fundo">
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td width="35">&nbsp;</td>
											<td><span class='titulo2'><jdoc:include type="modules" name="position-2" /></span></td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td valign="top">
						<div id="sidebar" style="width:210px; float:left; margin-top:15px;">
							<jdoc:include type="modules" name="position-4"   />
						</div>
						<div id="main" style="width:804px; float:left; margin-left:10px;">
							<div style="color:red; font-weight:bold;">
								<jdoc:include type="message" />
							</div>
							<div class="SearchBarTop"><div class="SearchBar"><jdoc:include type="modules" name="position-9" /></div></div>
							<jdoc:include type="modules" name="position-6"   />
							<jdoc:include type="component" />
							<img src="./imagens/layout/transparente.gif" width="10" height="5">
						</div>
					</td>
					<td>&nbsp;</td>
				</tr>
			</table>
		</div>
		<table class="tab_foot" width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td>&nbsp;</td>
				<td width="1024" align="center" height="35" class="texto_pequeno2" valign="bottom"><jdoc:include type="modules" name="position-8"   /></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td height="35" align="center" class="texto_pequeno2" valign="bottom">copyright &copy; fullsport &#8226; all rights reserved &#8226; 2015</td>
				<td>&nbsp;</td>
			</tr>
		</table>
	</body>
	<script>
		jQuery(document).ready(function() {
			
			if (typeof tabinit_h === 'undefined' || tabinit_h === null) {
				tabinit_h = jQuery(".tab_main").height();
			}
			
			jQuery(window).on('resize', function(){
				var win = jQuery(this);
				var tabfoot_h = jQuery(".tab_foot").height();

				if( tabinit_h+tabfoot_h < win.height() ) {
					jQuery(".tab_main").css("height", win.height() - tabfoot_h);
				}
			});
			
			if( jQuery("#sidebar").html().trim() == '' ) {
				jQuery("#sidebar").css("width", "0px");
				jQuery("#main").css("width", "1024px");
				jQuery("#main").css("margin-left", "0px");
			}
		
			var native_width = 0;
			var native_height = 0;

			jQuery(".magnify").mousemove(function(e){
				if ( jQuery(this).css("display") != "none" )
				{
					if(!native_width && !native_height)
					{
						var image_object = new Image();
						image_object.src = jQuery(".small").attr("src");
						native_width = image_object.width;
						native_height = image_object.height;
					}
					else
					{
						var magnify_offset = jQuery(this).offset();
						var mx = e.pageX - magnify_offset.left;
						var my = e.pageY - magnify_offset.top;
						
						if(mx < jQuery(this).width() && my < jQuery(this).height() && mx > 0 && my > 0) { jQuery(".large").fadeIn(100); }
						else { jQuery(".large").fadeOut(100); }
						if(jQuery(".large").is(":visible"))
						{
							var rx = Math.round(mx/jQuery(".small").width()*native_width - jQuery(".large").width()/2)*-1;
							var ry = Math.round(my/jQuery(".small").height()*native_height - jQuery(".large").height()/2)*-1;
							var bgp = rx + "px " + ry + "px";
							
							var px = mx - jQuery(".large").width()/2;
							var py = my - jQuery(".large").height()/2;
							jQuery(".large").css({left: px, top: py, backgroundPosition: bgp});
						}
					}
				}
			})
			
			jQuery(function(){
				var appendthis =  ("<div class='modal-overlay js-modal-close'></div>");

				  jQuery('img[data-modal-id]').click(function(e) {
					e.preventDefault();
					jQuery("body").append(appendthis);
					jQuery(".modal-overlay").fadeTo(500, 0.7);
					//$(".js-modalbox").fadeIn(500);
					var modalBox = jQuery(this).attr('data-modal-id');
					jQuery('#'+modalBox).fadeIn(jQuery(this).data());
				  });  
				  
				  
				jQuery(".js-modal-close, .modal-overlay").click(function() {
				  jQuery(".modal-box, .modal-overlay").fadeOut(500, function() {
					jQuery(".modal-overlay").remove();
				  });
				});
				 
				jQuery(window).resize(function() {
				  jQuery(".modal-box").css({
					top: (jQuery(window).height() - jQuery(".modal-box").outerHeight()) / 2,
					left: (jQuery(window).width() - jQuery(".modal-box").outerWidth()) / 2
				  });
				});
				 
				jQuery(window).resize();
				 
			});
		})
	</script>
	<script src="http://thecodeplayer.com/uploads/js/prefixfree.js" type="text/javascript"></script>
</html>