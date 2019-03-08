<?php 
/*------------------------------------------------------------------------
# Rox Topbar Sliding by http://www.themerox.com
# ------------------------------------------------------------------------
# Author    ThemeRox  http://www.themerox.com
# Copyright (C) 2010 - 2015 http://www.themerox.com All Rights Reserved.
# @license - Copyrighted Commercial
# Websites: http://www.themerox.com
-------------------------------------------------------------------------*/
// no direct access
defined('_JEXEC') or die;
$document = JFactory::getDocument();

$document->addStyleSheet(JURI::root(true).'/modules/mod_rox_topbar_sliding/assets/css/style.css');
if($params->get('load_jquery')==1){

$document->addScript(JURI::root(true).'/modules/mod_rox_topbar_sliding/assets/js/jquery.min.js');
}
require JModuleHelper::getLayoutPath('mod_rox_topbar_sliding', $params->get('layout', 'default'));
?>
<?php
if(($params->get('always_open')==0)){?>
<script>
jQuery.noConflict();
	jQuery(document).ready(function($){
	$("div.rox-close-hide").addClass("mtop");
	$("div.open").click(function () {
	if ($('.rox-close-hide').css("margin-top")!='-48px') {
	$(".rox-close-hide").animate({marginTop: "-48px"},500);
	$("div.open p").removeClass("active");
	} else {
	$(".rox-close-hide").animate({ marginTop: "0px" }, 500);
	$("div.open p").addClass("active");
	}
	});
});
</script>
<?php } else {?>
<script>
jQuery.noConflict();
	jQuery(document).ready(function($){
	$("div.open").click(function () {
	if ($('.rox-close-hide').css("margin-top")!='0px') {
	$(".rox-close-hide").animate({marginTop: "0px"},500);
	$("div.open p").removeClass("active");
	} else {
	$(".rox-close-hide").animate({ marginTop: "-48px" }, 500);
	$("div.open p").addClass("active");
	}
	});
});
</script>
<?php } ?>
