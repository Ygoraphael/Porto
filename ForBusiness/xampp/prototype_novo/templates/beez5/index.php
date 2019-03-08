<!DOCTYPE html>
<html lang="pt">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Prototype</title>
		<meta name="viewport" content="">
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="robots" content="INDEX,FOLLOW" />
		<jdoc:include type="head" />
		<script>var $jq = jQuery.noConflict();</script>
		<link rel="icon" href="images/favicon.ico" type="image/x-icon" />
		<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,300,700,800,400,600' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:200,300,400,500,600,700,800' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="js/calendar/calendar-win2k-1.css" />
		<link rel="stylesheet" type="text/css" href="css/widgets.css" media="all" />
		<link rel="stylesheet" type="text/css" href="css/main.css" media="all" />
		<link rel="stylesheet" type="text/css" href="js/growler.css" media="all" />
		<link rel="stylesheet" type="text/css" href="js/modalbox.css" media="all" />
		<link rel="stylesheet" type="text/css" href="css/all.css" media="all" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="css/fancybox.css" media="all" />
		<link rel="stylesheet" type="text/css" href="css/scrollingcart/scroll.css" media="all" />
		<link rel="stylesheet" type="text/css" href="css/print.css" media="print" />
		<script type="text/javascript" src="js/prototype/prototype.js"></script>
		<script type="text/javascript" src="js/lib/ccard.js"></script>
		<script type="text/javascript" src="js/prototype/validation.js"></script>
		<script type="text/javascript" src="js/scriptaculous/builder.js"></script>
		<script type="text/javascript" src="js/scriptaculous/effects.js"></script>
		<script type="text/javascript" src="js/scriptaculous/dragdrop.js"></script>
		<script type="text/javascript" src="js/scriptaculous/controls.js"></script>
		<script type="text/javascript" src="js/scriptaculous/slider.js"></script>
		<script type="text/javascript" src="js/varien/js.js"></script>
		<script type="text/javascript" src="js/varien/form.js"></script>
		<script type="text/javascript" src="js/varien/menu.js"></script>
		<script type="text/javascript" src="js/mage/translate.js"></script>
		<script type="text/javascript" src="js/mage/cookies.js"></script>
		<script type="text/javascript" src="js/varien/product.js"></script>
		<script type="text/javascript" src="js/varien/configurable.js"></script>
		<script type="text/javascript" src="js/calendar/calendar.js"></script>
		<script type="text/javascript" src="js/calendar/calendar-setup.js"></script>
		<script type="text/javascript" src="js/growler.js"></script>
		<script type="text/javascript" src="js/modalbox.js"></script>
		<script type="text/javascript" src="js/ajaxcart.js"></script>
		<script type="text/javascript" src="js/bundle.js"></script>
		<script type="text/javascript" src="js/all.js"></script>
		<script type="text/javascript" src="js/banner.js"></script>
		<script type="text/javascript" src="js/nav.js"></script>
		<script type="text/javascript" src="js/cart.js"></script>
		<script type="text/javascript" src="js/totop.js"></script>
		<script type="text/javascript" src="js/products-slider.js"></script>
		<script type="text/javascript" src="js/left-nav.js"></script>
		<script type="text/javascript" src="js/cat-slides.js"></script>
		<script type="text/javascript" src="js/mob-nav.js"></script>
		<script type="text/javascript" src="js/pro-img-slider.js"></script>
		<script type="text/javascript" src="js/toggle.js"></script>
		<script type="text/javascript" src="js/cloud-zoom.js"></script>
		<script type="text/javascript" src="js/jquery.fancybox-1.3.4.pack.js"></script>
		<script type="text/javascript" src="js/jquery.lettering.js"></script>
		<script type="text/javascript" src="js/easing.js"></script>
		<script type="text/javascript" src="js/eislideshow.js"></script>
		<script type="text/javascript" src="js/jquery.elevatezoom.js"></script>
		<link rel="stylesheet" href="css/styles-fixed.css" type="text/css" />
		<link rel="stylesheet" href="css/responsive-fixed.css" type="text/css" />
		<?php
			$lang = JFactory::getLanguage();
		?>
	</head>
	<body class="cms-index-index cms-absolut-home">
		<header>
			<div class="top-links">
				<div class="inner">
					<div class="lang-switcher">
						<jdoc:include type="modules" name="position-4" />
					</div>
					<p class="welcome-msg"><jdoc:include type="modules" name="position-6" /></p>
					<div class="toplinks">
						<div class="links">
							<jdoc:include type="modules" name="position-5" />
						</div>
					</div>
				</div>
			</div>
			<div class="header">
				<?php if (JFactory::getUser()->id > 0) { ?>
				<div class="top-cart-contain">
					<div class="mini-cart">
						<div class="basket dropdown-toggle" data-hover="dropdown" data-toggle="dropdown">
							<jdoc:include type="modules" name="position-16" />
						</div>
					</div>
				</div>
				<?php }?>
				<div class="logo">
					<a href="index.php" title="Prototype">
						<div>
							<img alt="Prototype" src="images/logo.png" />
						</div>
					</a>
				</div>
			</div>
		</header>
		<nav>
			<div class="nav-inner">
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery('.toggle').click(function() {
						if (jQuery('.submenu').is(":hidden")) {
							jQuery('.submenu').slideDown("fast");
						} else {
							jQuery('.submenu').slideUp("fast");
						}
						return false;
					});
				});
				
				/*Phone Menu*/
				jQuery(document).ready(function() {
					jQuery(".topnav").accordion({
						accordion:false,
						speed: 300,
						closedSign: '+',
						openedSign: '-'
					});
				});
			</script>
			<ul id="nav">
				<jdoc:include type="modules" name="position-2" />
			</ul>
			<!--nav-->
			<script type="text/javascript">
				//<![CDATA[
				
				jQuery(function($) {
				$("#nav > li").hover(function() {
				var el = $(this).find(".level0-wrapper");
				el.hide();
				el.css("left", "0");
				el.stop(true, true).delay(150).fadeIn(300, "easeOutCubic");
				}, function() {
				$(this).find(".level0-wrapper").stop(true, true).delay(300).fadeOut(300, "easeInCubic");
				});
				});
				
				var isTouchDevice = ('ontouchstart' in window) || (navigator.msMaxTouchPoints > 0);
				jQuery(window).on("load", function() {
				
				if (isTouchDevice)
				{
				jQuery('#nav a.level-top').click(function(e) {
				$t = jQuery(this);
				$parent = $t.parent();
				if ($parent.hasClass('parent'))
				{
				if ( !$t.hasClass('menu-ready'))
				{                    
				jQuery('#nav a.level-top').removeClass('menu-ready');
				$t.addClass('menu-ready');
				return false;
				}
				else
				{
				$t.removeClass('menu-ready');
				}
				}
				});
				}
				
				}); //end: on load
				
				//]]>
			</script>
			<script type="text/javascript">
				//<![CDATA[
				jQuery(document).ready(function(){
				var scrolled = false;
				jQuery("#nav li.level0.drop-menu").mouseover(function(){
				if(jQuery(window).width() >= 740){
				jQuery(this).children('ul.level1').fadeIn(100);
				}
				return false;
				}).mouseleave(function(){
				if(jQuery(window).width() >= 740){
				jQuery(this).children('ul.level1').fadeOut(100);
				}
				return false;
				});
				jQuery("#nav li.level0.drop-menu li").mouseover(function(){
				if(jQuery(window).width() >= 740){
				jQuery(this).children('ul').css({top:0,left:"165px"});
				var offset = jQuery(this).offset();
				if(offset && (jQuery(window).width() < offset.left+325)){
				jQuery(this).children('ul').removeClass("right-sub");
				jQuery(this).children('ul').addClass("left-sub");
				jQuery(this).children('ul').css({top:0,left:"-167px"});
				} else {
				jQuery(this).children('ul').removeClass("left-sub");
				jQuery(this).children('ul').addClass("right-sub");
				}
				jQuery(this).children('ul').fadeIn(100);
				}
				}).mouseleave(function(){
				if(jQuery(window).width() >= 740){
				jQuery(this).children('ul').fadeOut(100);
				}
				});
				
				jQuery("#nav ul.level0 > li").mouseover(function(){
				var nav = jQuery('#nav div.level0-wrapper');
				var sub = jQuery(this);
				var subdd = sub.find('ul.level1');
				
				var crossedHeight = (parseInt(sub.position().top) + parseInt(subdd.outerHeight())) - nav.outerHeight() + 10;
				var crossedWidth = (parseInt(sub.position().left) + parseInt(subdd.outerWidth())) - nav.outerWidth() + 75;		
				if (crossedHeight > 0){
				subdd.css({ top: (crossedHeight * -1) + 'px' });
				} else {
				subdd.css({ top:'-5px' });
				}
				
				if (crossedWidth > 0){
				subdd.css({ left: (parseInt(subdd.outerWidth()) * -1) + 'px' });
				} else {
				subdd.css({ left: (parseInt(subdd.parent().outerWidth() - 20)) + 'px' });
				}
				
				});
				
				(function($) {
				var num_cols = 2,
				container = $('#nav ul.level1'),
				listItem = 'li',
				listClass = 'sub-list';
				container.each(function() {
				var items_per_col = new Array(),
				items = $(this).find(listItem),
				min_items_per_col = Math.floor(items.length / num_cols),
				difference = items.length - (min_items_per_col * num_cols);
				
				if (items.length > 18) {
				items.parent('ul').addClass('col2');
				for (var i = 0; i < num_cols; i++) {
				if (i < difference) {
				items_per_col[i] = min_items_per_col + 1;
				} else {
				items_per_col[i] = min_items_per_col;
				}
				}
				for (var i = 0; i < num_cols; i++) {
				$(this).append($('<li></li>').addClass(listClass).append($('<ul></ul>')));
				for (var j = 0; j < items_per_col[i]; j++) {
				var pointer = 0;
				for (var k = 0; k < i; k++) {
				pointer += items_per_col[k];
				}
				$(this).find('.' + listClass + ' > ul').last().append(items[j + pointer]);
				}
				}
				}
				
				});
				})(jQuery);		
				
				
				
				});
				//]]>
			</script>
			<div class="search-box">
				<form id="search_mini_form" action="" method="get">
					<jdoc:include type="modules" name="position-15" />  
				</form>
			</div> <!--search-box-->  </div> <!--nav-inner-->
		</nav>
		<?php
			$app = JFactory::getApplication();
			$menu = $app->getMenu();
			if ( $menu->getActive() == $menu->getDefault( 'en-GB' ) || $menu->getActive() == $menu->getDefault( 'pt-PT' ) ) {
			?>
				<div class="ei-slider" >
					<jdoc:include type="modules" name="position-1" />
				</div>
				<section class="main-col">
					<jdoc:include type="modules" name="position-7" />
				</section>
			<?php
			}
			else {
			?>
			<section class="main-col col2-left-layout">
				<div class="main-container-inner">
					<jdoc:include type="modules" name="position-3" />
					<article class="col-main" style="margin-top: 5px; <?php if(!$this->countModules( 'position-9' ) and !$this->countModules( 'position-13' )) echo "width:100%;"; ?>">
						<jdoc:include type="modules" name="position-10" />
						<jdoc:include type="message" />
						<jdoc:include type="modules" name="position-11" />
						<jdoc:include type="component" />
						<jdoc:include type="modules" name="position-12" />
						
						<div id="mgkquickview"><div id="magikloading" style="display:none;text-align:center;margin-top:400px;"><img src="images/mgkloading.gif" alt="loading"></div></div>
						<script type="text/javascript">
							function callQuickView(qurl) { 
								jQuery('#mgkquickview').show();
								jQuery('#magikloading').show();
								jQuery.get(qurl, function(data) {
									jQuery.fancybox(data);
									jQuery('#magikloading').hide();
									jQuery('#mgkquickview').hide();
								});
							 }
							
							if (document.URL.indexOf('catalogsearch') > -1){
								Mage.Cookies.set('catalogsearchUrl', document.URL);	
								jQuery('.products-list li a').each(function(){
									var href = jQuery(this).attr('href');
									href += (href.indexOf('?') > -1) ? '&s=true' : '?s=true'; 
									jQuery(this).attr('href', href);
								});
							} else {
								Mage.Cookies.set('catalogsearchUrl', '');	
							}
						</script>                   
					</article>
					<?php if ($this->countModules( 'position-9' ) or $this->countModules( 'position-13' ) or $this->countModules( 'position-14' )) : ?>
					<aside class="col-left sidebar">
						<jdoc:include type="modules" name="position-9" />
						<div class="block block-layered-nav">
							<div class="block-title">
								<?php echo JText::_("MOD_VIRTUEMART_NC_COMPRARPOR"); ?>...
							</div>
							<div class="block-content">
								<dl id="narrow-by-list">
									<jdoc:include type="modules" name="position-14" />
									<jdoc:include type="modules" name="position-13" />
								</dl>
								<script type="text/javascript">decorateDataList('narrow-by-list')</script>
							</div>
						</div>
					</aside>
					<?php endif; ?>
				</div>
			</section>
			<?php
			}
		?>
		<div class="offer-banner-section">
			<jdoc:include type="modules" name="position-8" />
		</div>
		<footer>
			<div class="footer informative">
				<div class="footer-bottom">
					<div class="inner">
						<div class="coppyright">&copy; <?php echo date('Y'); ?> <a href="http://www.novoscanais.pt">novoscanais.pt</a></div>
						<div class="bottom_links">
							<ul class="links">
								<?php
								if( $lang->getTag() == 'pt-PT' ) {
								?>
									<li><a title="Termos e condições" href="index.php/termos-e-condicoes">Termos e condições</a></li>
									<li class="last"><a title="Privacidade" href="index.php/privacidade">Privacidade</a></li>
								<?php
								}
								else if( $lang->getTag() == 'en-GB' ) {
								?>
									<li><a title="Terms and Conditions" href="index.php/terms-and-conditions">Terms and Conditions</a></li>
									<li class="last"><a title="Privacy" href="index.php/privacy">Privacy</a></li>
								<?php
								}
								?>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</footer>
		<script language=javascript type='text/javascript'>
			jQuery('.show_hide').click(function(){
				jQuery("#hideShow").show(); 
				jQuery("#hideShow1").hide();
			});
			
			jQuery('.show_hide1').click(function(){
				jQuery("#hideShow1").show();
				jQuery("#hideShow").hide(); 
			});
			
			jQuery('#hideDiv').click(function(){
				jQuery("#hideShow").hide(); 
			});
			
			jQuery('#hideDiv1').click(function(){
				jQuery("#hideShow1").hide(); 
			});
			
			jQuery('ul#nav ul.level0').listsplit({
				columns:5,
				list_class:'level0'
			});
			
			jQuery('.fancybox').fancybox();
		</script>
		<div id="wc-overlay" class="wc-overlay">
			<div class="wc-overlay-loading"></div>
		</div>
	</body>
</html>