<?php
/*
// Pixel Point Creative "Simple Spotlight" Module for Joomla!
// License: http://www.gnu.org/copyleft/gpl.html
// Copyright (c) Pixel Point Creative LLC.
// More info at http://www.pixelpointcreative.com
// Developer: Daniel Riefstahl
// ***Last update: 5/8/13***
*/
defined('_JEXEC') or die('Restricted access');
//Parameters for Simple Spotlight
$spotlightImage = $params->get('spotlightImage');
$spotlightImage2 = $params->get('spotlightImage2');
$spotlightImage3 = $params->get('spotlightImage3');
$spotlightImage4 = $params->get('spotlightImage4');
$spotlightImage5 = $params->get('spotlightImage5');
$spotlightImage6 = $params->get('spotlightImage6');
$spotlightImage7 = $params->get('spotlightImage7');
$spotlightImage8 = $params->get('spotlightImage8');
$spotlightImage9 = $params->get('spotlightImage9');
$spotlightImage10 = $params->get('spotlightImage10');
$spotlightImage11 = $params->get('spotlightImage11');
$spotlightImage12 = $params->get('spotlightImage12');
$spotlightImage13 = $params->get('spotlightImage13');
$spotlightImage14 = $params->get('spotlightImage14');
$spotlightImage15 = $params->get('spotlightImage15');
$spotlightImage16 = $params->get('spotlightImage16');
$spotlightImage17 = $params->get('spotlightImage17');
$spotlightImage18 = $params->get('spotlightImage18');
$spotlightImage19 = $params->get('spotlightImage19');
$spotlightImage20 = $params->get('spotlightImage20');
$alt = $params->get('alt');
$alt2 = $params->get('alt2');
$alt3 = $params->get('alt3');
$alt4 = $params->get('alt4');
$alt5 = $params->get('alt5');
$alt6 = $params->get('alt6');
$alt7 = $params->get('alt7');
$alt8 = $params->get('alt8');
$alt9 = $params->get('alt9');
$alt10 = $params->get('alt10');
$alt11 = $params->get('alt11');
$alt12 = $params->get('alt12');
$alt13 = $params->get('alt13');
$alt14 = $params->get('alt14');
$alt15 = $params->get('alt15');
$alt16 = $params->get('alt16');
$alt17 = $params->get('alt17');
$alt18 = $params->get('alt18');
$alt19 = $params->get('alt19');
$alt20 = $params->get('alt20');
$window = $params->get('window');
$window2 = $params->get('window2');
$window3 = $params->get('window3');
$window4 = $params->get('window4');
$window5 = $params->get('window5');
$window6 = $params->get('window6');
$window7 = $params->get('window7');
$window8 = $params->get('window8');
$window9 = $params->get('window9');
$window10 = $params->get('window10');
$window11 = $params->get('window11');
$window12 = $params->get('window12');
$window13 = $params->get('window13');
$window14 = $params->get('window14');
$window15 = $params->get('window15');
$window16 = $params->get('window16');
$window17 = $params->get('window17');
$window18 = $params->get('window18');
$window19 = $params->get('window19');
$window20 = $params->get('window20');
$link = $params->get('link');
$link2 = $params->get('link2');
$link3 = $params->get('link3');
$link4 = $params->get('link4');
$link5 = $params->get('link5');
$link6 = $params->get('link6');
$link7 = $params->get('link7');
$link8 = $params->get('link8');
$link9 = $params->get('link9');
$link10 = $params->get('link10');
$link11 = $params->get('link11');
$link12 = $params->get('link12');
$link13 = $params->get('link13');
$link14 = $params->get('link14');
$link15 = $params->get('link15');
$link16 = $params->get('link16');
$link17 = $params->get('link17');
$link18 = $params->get('link18');
$link19 = $params->get('link19');
$link20 = $params->get('link20');
$width = $params->get('width');
$height = $params->get('height');
$auto = $params->get('auto');
$easing = $params->get('easing');
$sides = $params->get("sides", 8);
$speed = $params->get("speed", '5');
$effect = $params->get('effect');
$random = $params->get('random','0');
$buttons = $params->get('buttons','right');
$jquery	= $params->get('jquery', '1');
$pause			= $params->get("pause", 'true');
$play 			= $params->get("play", 'true');
$effect 		= $params->get("effect", 'fade');
$slideshow_speed 	= $params->get("slideshow_speed", 800);
$timer_speed 		= $params->get("timer_speed", 4000);
$auto_play		= $params->get('play', 1);
$enable_shadow          = ($params->get("enableshadow", 1) == 0)?"false":"true";
$imgbutton 		= $params->get('imgbutton');


if( !defined('SMART_JQUERY') && $jquery ){
	JHtml::script('modules/'.$module->module.'/assets/js/jquery-1.8.2.min.js');
	JHtml::script('modules/'.$module->module.'/assets/js/jquery-noconflict.js');
	define('SMART_JQUERY', 1);
	} 
JHtml::script('modules/'.$module->module.'/assets/js/jquery.cycle.all.js');
/* Add css*/	
JHtml::stylesheet('modules/'.$module->module.'/assets/css/style.css');

$path = JModuleHelper::getLayoutPath( 'mod_ppc_simple_spotlight', 'default' );
if (file_exists($path)) {
	require($path);
}
?>