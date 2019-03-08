<?php 
/*------------------------------------------------------------------------
# Rox Scroll Sliding by http://www.themerox.com
# ------------------------------------------------------------------------
# Author    ThemeRox  http://www.themerox.com
# Copyright (C) 2010 - 2015 http://www.themerox.com All Rights Reserved.
# @license - Copyrighted Commercial
# Websites: http://www.themerox.com
-------------------------------------------------------------------------*/
// no direct access
defined('_JEXEC') or die;
$document = JFactory::getDocument();

$document->addStyleSheet(JURI::root(true).'templates/rox_bestshop/html/modules/mod_rox_scroll_sliding/assets/css/style.css');
if($params->get('load_jquery')==1){
$document->addScript(JURI::root(true).'templates/rox_bestshop/html/modules/mod_rox_scroll_sliding/assets/js/jquery-1.8.2.min.js');
}
$document->addScript(JURI::root(true).'templates/rox_bestshop/html/modules/mod_rox_scroll_sliding/assets/js/jquery.carouFredSel-6.2.0-packed.js');
$document->addScript(JURI::root(true).'templates/rox_bestshop/html/modules/mod_rox_scroll_sliding/assets/js/jquery.touchSwipe.min.js');
require JModuleHelper::getLayoutPath('mod_rox_scroll_sliding', $params->get('layout', 'default'));
?>
<script>
jQuery.noConflict();
	jQuery(document).ready(function($){
	$("div.rox-carousel-open").click(function () {
	if ($('.rox-carousel-hidden').css("margin-bottom")!='-81px') {
	$(".rox-carousel-hidden").animate({marginBottom: "-81px"},500);
	$("div.rox-carousel-open p").removeClass("active");
	} else {
	$(".rox-carousel-hidden").animate({ marginBottom: "0px" }, 500);
	$("div.rox-carousel-open p").addClass("active");
	}
	});
});
</script>
<script type="text/javascript" language="javascript">
jQuery.noConflict();
	jQuery(document).ready(function($){
        /*  
		//	Basic carousel, no options
		$('#foo0').carouFredSel();

		//	Basic carousel + timer, using CSS-transitions
		$('#foo1').carouFredSel({
			auto: {
				pauseOnHover: 'resume',
				progress: '#timer1'
			}
		}, {
			transition: true
		});
		*/

		//	Scrolled by user interaction
		$('#foo2').carouFredSel({
			auto: false,
			prev: '#prev2',
			next: '#next2',
			pagination: "#pager2",
			mousewheel: true,
			swipe: {
				onMouse: true,
				onTouch: true
			}
		});
        /*
		//	Variable number of visible items with variable sizes
		$('#foo3').carouFredSel({
			width: 360,
			height: 'auto',
			prev: '#prev3',
			next: '#next3',
			auto: false
		});

		//	Responsive layout, resizing the items
		$('#foo4').carouFredSel({
			responsive: true,
			prev: '#prev3',
			next: '#next3',
			width: '100%',
			scroll: 2,
			items: {
				width: 400,
			//	height: '30%',	//	optionally resize item-height
				visible: {
					min: 2,
					max: 6
				}
			}
		});

		//	Fuild layout, centering the items
		$('#foo5').carouFredSel({
			width: '100%',
			scroll: 2
		});
		*/

	});
</script>