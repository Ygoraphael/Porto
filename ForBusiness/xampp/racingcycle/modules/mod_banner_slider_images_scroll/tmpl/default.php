<?php
/**
* @title		banner slider images scroll
* @website		http://www.joombig.com
* @copyright	Copyright (C) 2014 joombig.com. All rights reserved.
* @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
?>

<script type="text/javascript" src="<?php echo $mosConfig_live_site; ?>/modules/mod_banner_slider_images_scroll/assets/js/jssor.slider.mini.js"></script>

<script>
	jQuery(document).ready(function ($) {
            
		var jssor_1_options = {
		  $AutoPlay: true,
		  $Idle: 0,
		  $AutoPlaySteps: 4,
		  $SlideDuration: 1600,
		  $SlideEasing: $Jease$.$Linear,
		  $PauseOnHover: 4,
		  $SlideWidth: 200,
		  $Cols: 7
		};
		
		var jssor_1_slider = new $JssorSlider$("jssor_1", jssor_1_options);
	});
</script>

<div id="jssor_1" style="position: relative; top: 0px; left: 0px; width: 1170px; height: 100px; overflow: hidden; visibility: hidden;">
	<!-- Loading Screen -->
	<div data-u="loading" style="position: absolute; top: 0px; left: 0px;">
		<div style="filter: alpha(opacity=70); opacity: 0.7; position: absolute; display: block; top: 0px; left: 0px; width: 100%; height: 100%;"></div>
		<div style="position:absolute;display:block;background:url('images/loading.gif') no-repeat center center;top:0px;left:0px;width:100%;height:100%;"></div>
	</div>
	<div data-u="slides" style="cursor: default; position: relative; top: 0px; left: 0px; width: 1170px; height: 100px; overflow: hidden;">
	<?php foreach($lists as $item) { ?>
		<div style="display: none;">
			<img data-u="image" title="<?php echo $item->title ?>" src="<?php echo $item->image ?>" />
		</div>
	 <?php } ?>	   
	</div>
</div>
		