<?php
/*
// Pixel Point Creative "Simple Spotlight" Module for Joomla!
// License: http://www.gnu.org/copyleft/gpl.html
// Copyright (c) Pixel Point Creative LLC.
// More info at http://www.pixelpointcreative.com
// Developer: Daniel Riefstahl
// ***Last update: 5/3/132***
*/
defined('_JEXEC') or die('Restricted access');
if (!defined('DS')) { 
define('DS', DIRECTORY_SEPARATOR); 
}
?>
<script type="text/javascript">
jQuery(document).ready(function($) {
    $('#sp<?php echo $module->id?> ul').cycle({
	fx:     '<?php echo $effect;?>',
	timeout: <?php echo $auto_play ? $timer_speed : 0;?>,
    	speed:  <?php echo $slideshow_speed;?>,
	next:   '#next<?php echo $module->id?>', 
    	prev:   '#prev<?php echo $module->id?>',
	pause:  <?php echo ($pause) ? 1 : 0;?>,
	width:  <?php echo ($width) ?>,
        height: <?php echo $height; ?>,
        fit: 1		
	});		
});

</script>
<div style="background:none;width:<?php echo ($width) ?>px;margin:auto;" >  
<div class="slideshow <?php echo $params->get("moduleclass_sfx");?>" id="sp<?php echo $module->id?>" >
<ul style="background:none;margin:0px;padding:0px;">
	<?php 

        $arr_img = array();

if ($params->get('show1')){
	if ($spotlightImage) $getlink = '';
                   if ($params->get('nolink')) {$getlink = '<a href="'.$link.'" target="'.$window.'"><img src="'.JURI::base().$spotlightImage.'" width="'.$width.'px" height="'.$height.'px" border="0" alt="'.$alt.'" title="'.$alt.'" /></a>';
                    } else {
                   $getlink = '<img src="'.JURI::base().$spotlightImage.'" width="'.$width.'px" height="'.$height.'px" border="0" alt="'.$alt.'" title="'.$alt.'" />';
                    }
                    $arr_img[]='<li style="background:none;margin:0px;padding:0px">'. $getlink .'</li>';
}
if ($params->get('show2')){
        if ($spotlightImage2) $getlink2 = '';
                   if ($params->get('nolink2')) {$getlink2 = '<a href="'.$link2.'" target="'.$window2.'"><img src="'.JURI::base().$spotlightImage2.'" width="'.$width.'px" height="'.$height.'px" border="0" alt="'.$alt2.'" title="'.$alt2.'" /></a>';
                    } else {
                   $getlink2 = '<img src="'.JURI::base().$spotlightImage2.'" width="'.$width.'px" height="'.$height.'px" border="0" alt="'.$alt2.'" title="'.$alt2.'" />';
                    }
                    $arr_img[]='<li style="background:none;margin:0px;padding:0px">'. $getlink2 .'</li>';
}
if ($params->get('show3')){
	        if ($spotlightImage3) $getlink3 = '';
                   if ($params->get('nolink3')) {$getlink3 = '<a href="'.$link3.'" target="'.$window3.'"><img src="'.JURI::base().$spotlightImage3.'" width="'.$width.'px" height="'.$height.'px" border="0" alt="'.$alt3.'" title="'.$alt3.'" /></a>';
                    } else {
                   $getlink3 = '<img src="'.JURI::base().$spotlightImage3.'" width="'.$width.'px" height="'.$height.'px" border="0" alt="'.$alt3.'" title="'.$alt3.'" />';
                    }
                    $arr_img[]='<li style="background:none;margin:0px;padding:0px">'. $getlink3 .'</li>';
}	
if ($params->get('show4')){				
        if ($spotlightImage4) $getlink4 = '';
                   if ($params->get('nolink4')) {$getlink4 = '<a href="'.$link4.'" target="'.$window4.'"><img src="'.JURI::base().$spotlightImage4.'" width="'.$width.'px" height="'.$height.'px" border="0" alt="'.$alt4.'" title="'.$alt4.'" /></a>';
                    } else {
                   $getlink4 = '<img src="'.JURI::base().$spotlightImage4.'" width="'.$width.'px" height="'.$height.'px" border="0" alt="'.$alt4.'" title="'.$alt4.'" />';
                    }
                    $arr_img[]='<li style="background:none;margin:0px;padding:0px">'. $getlink4 .'</li>';
}	
if ($params->get('show5')){	
        if ($spotlightImage5) $getlink5 = '';
                   if ($params->get('nolink5')) {$getlink5 = '<a href="'.$link5.'" target="'.$window5.'"><img src="'.JURI::base().$spotlightImage5.'" width="'.$width.'px" height="'.$height.'px" border="0" alt="'.$alt5.'" title="'.$alt5.'" /></a>';
                    } else {
                   $getlink5 = '<img src="'.JURI::base().$spotlightImage5.'" width="'.$width.'px" height="'.$height.'px" border="0" alt="'.$alt5.'" title="'.$alt5.'" />';
                    }
                    $arr_img[]='<li style="background:none;margin:0px;padding:0px">'. $getlink5 .'</li>';
}	
if ($params->get('show6')){		
        if ($spotlightImage6) $getlink6 = '';
                   if ($params->get('nolink6')) {$getlink6 = '<a href="'.$link6.'" target="'.$window6.'"><img src="'.JURI::base().$spotlightImage6.'" width="'.$width.'px" height="'.$height.'px" border="0" alt="'.$alt6.'" title="'.$alt6.'" /></a>';
                    } else {
                   $getlink6 = '<img src="'.JURI::base().$spotlightImage6.'" width="'.$width.'px" height="'.$height.'px" border="0" alt="'.$alt6.'" title="'.$alt6.'" />';
                    }
                    $arr_img[]='<li style="background:none;margin:0px;padding:0px">'. $getlink6 .'</li>';
}	
if ($params->get('show7')){		
        if ($spotlightImage7) $getlink7 = '';
                   if ($params->get('nolink7')) {$getlink7 = '<a href="'.$link7.'" target="'.$window7.'"><img src="'.JURI::base().$spotlightImage7.'" width="'.$width.'px" height="'.$height.'px" border="0" alt="'.$alt7.'" title="'.$alt7.'" /></a>';
                    } else {
                   $getlink7 = '<img src="'.JURI::base().$spotlightImage7.'" width="'.$width.'px" height="'.$height.'px" border="0" alt="'.$alt7.'" title="'.$alt7.'" />';
                    }
                    $arr_img[]='<li style="background:none;margin:0px;padding:0px">'. $getlink7 .'</li>';
}	
if ($params->get('show8')){		
        if ($spotlightImage8) $getlink8 = '';
                   if ($params->get('nolink8')) {$getlink8 = '<a href="'.$link8.'" target="'.$window8.'"><img src="'.JURI::base().$spotlightImage8.'" width="'.$width.'px" height="'.$height.'px" border="0" alt="'.$alt8.'" title="'.$alt8.'" /></a>';
                    } else {
                   $getlink8 = '<img src="'.JURI::base().$spotlightImage8.'" width="'.$width.'px" height="'.$height.'px" border="0" alt="'.$alt8.'" title="'.$alt8.'" />';
                    }
                    $arr_img[]='<li style="background:none;margin:0px;padding:0px">'. $getlink8 .'</li>';
}	
if ($params->get('show9')){			
        if ($spotlightImage9) $getlink9 = '';
                   if ($params->get('nolink9')) {$getlink9 = '<a href="'.$link9.'" target="'.$window9.'"><img src="'.JURI::base().$spotlightImage9.'" width="'.$width.'px" height="'.$height.'px" border="0" alt="'.$alt9.'" title="'.$alt9.'" /></a>';
                    } else {
                   $getlink9 = '<img src="'.JURI::base().$spotlightImage9.'" width="'.$width.'px" height="'.$height.'px" border="0" alt="'.$alt9.'" title="'.$alt9.'" />';
                    }
                    $arr_img[]='<li style="background:none;margin:0px;padding:0px">'. $getlink9 .'</li>';
}	
if ($params->get('show10')){		
        if ($spotlightImage10) $getlink10 = '';
                   if ($params->get('nolink10')) {$getlink10 = '<a href="'.$link10.'" target="'.$window10.'"><img src="'.JURI::base().$spotlightImage10.'" width="'.$width.'px" height="'.$height.'px" border="0" alt="'.$alt10.'" title="'.$alt10.'" /></a>';
                    } else {
                   $getlink10 = '<img src="'.JURI::base().$spotlightImage10.'" width="'.$width.'px" height="'.$height.'px" border="0" alt="'.$alt10.'" title="'.$alt10.'" />';
                    }
                    $arr_img[]='<li style="background:none;margin:0px;padding:0px">'. $getlink10 .'</li>';
}
if ($params->get('show11')){		
        if ($spotlightImage11) $getlink11 = '';
                   if ($params->get('nolink11')) {$getlink11 = '<a href="'.$link11.'" target="'.$window11.'"><img src="'.JURI::base().$spotlightImage11.'" width="'.$width.'px" height="'.$height.'px" border="0" alt="'.$alt11.'" title="'.$alt11.'" /></a>';
                    } else {
                   $getlink11 = '<img src="'.JURI::base().$spotlightImage11.'" width="'.$width.'px" height="'.$height.'px" border="0" alt="'.$alt11.'" title="'.$alt11.'" />';
                    }
                    $arr_img[]='<li style="background:none;margin:0px;padding:0px">'. $getlink11 .'</li>';
}
if ($params->get('show12')){		
        if ($spotlightImage12) $getlink12 = '';
                   if ($params->get('nolink12')) {$getlink12 = '<a href="'.$link12.'" target="'.$window12.'"><img src="'.JURI::base().$spotlightImage12.'" width="'.$width.'px" height="'.$height.'px" border="0" alt="'.$alt12.'" title="'.$alt12.'" /></a>';
                    } else {
                   $getlink12 = '<img src="'.JURI::base().$spotlightImage12.'" width="'.$width.'px" height="'.$height.'px" border="0" alt="'.$alt12.'" title="'.$alt12.'" />';
                    }
                    $arr_img[]='<li style="background:none;margin:0px;padding:0px">'. $getlink12 .'</li>';
}	
if ($params->get('show13')){		
        if ($spotlightImage13) $getlink13 = '';
                   if ($params->get('nolink13')) {$getlink13 = '<a href="'.$link13.'" target="'.$window13.'"><img src="'.JURI::base().$spotlightImage13.'" width="'.$width.'px" height="'.$height.'px" border="0" alt="'.$alt13.'" title="'.$alt13.'" /></a>';
                    } else {
                   $getlink13 = '<img src="'.JURI::base().$spotlightImage13.'" width="'.$width.'px" height="'.$height.'px" border="0" alt="'.$alt13.'" title="'.$alt13.'" />';
                    }
                    $arr_img[]='<li style="background:none;margin:0px;padding:0px">'. $getlink13 .'</li>';
}	
if ($params->get('show14')){		
        if ($spotlightImage14) $getlink14 = '';
                   if ($params->get('nolink14')) {$getlink14 = '<a href="'.$link14.'" target="'.$window14.'"><img src="'.JURI::base().$spotlightImage14.'" width="'.$width.'px" height="'.$height.'px" border="0" alt="'.$alt14.'" title="'.$alt14.'" /></a>';
                    } else {
                   $getlink14 = '<img src="'.JURI::base().$spotlightImage14.'" width="'.$width.'px" height="'.$height.'px" border="0" alt="'.$alt14.'" title="'.$alt14.'" />';
                    }
                    $arr_img[]='<li style="background:none;margin:0px;padding:0px">'. $getlink14 .'</li>';
}
if ($params->get('show15')){		
        if ($spotlightImage15) $getlink15 = '';
                   if ($params->get('nolink15')) {$getlink15 = '<a href="'.$link15.'" target="'.$window15.'"><img src="'.JURI::base().$spotlightImage15.'" width="'.$width.'px" height="'.$height.'px" border="0" alt="'.$alt15.'" title="'.$alt15.'" /></a>';
                    } else {
                   $getlink15 = '<img src="'.JURI::base().$spotlightImage15.'" width="'.$width.'px" height="'.$height.'px" border="0" alt="'.$alt15.'" title="'.$alt15.'" />';
                    }
                    $arr_img[]='<li style="background:none;margin:0px;padding:0px">'. $getlink15 .'</li>';
}	
if ($params->get('show16')){		
        if ($spotlightImage16) $getlink16 = '';
                   if ($params->get('nolink16')) {$getlink16 = '<a href="'.$link16.'" target="'.$window16.'"><img src="'.JURI::base().$spotlightImage16.'" width="'.$width.'px" height="'.$height.'px" border="0" alt="'.$alt16.'" title="'.$alt16.'" /></a>';
                    } else {
                   $getlink16 = '<img src="'.JURI::base().$spotlightImage16.'" width="'.$width.'px" height="'.$height.'px" border="0" alt="'.$alt16.'" title="'.$alt16.'" />';
                    }
                    $arr_img[]='<li style="background:none;margin:0px;padding:0px">'. $getlink16 .'</li>';
}
if ($params->get('show17')){		
        if ($spotlightImage17) $getlink17 = '';
                   if ($params->get('nolink17')) {$getlink17 = '<a href="'.$link17.'" target="'.$window17.'"><img src="'.JURI::base().$spotlightImage17.'" width="'.$width.'px" height="'.$height.'px" border="0" alt="'.$alt17.'" title="'.$alt17.'" /></a>';
                    } else {
                   $getlink17 = '<img src="'.JURI::base().$spotlightImage17.'" width="'.$width.'px" height="'.$height.'px" border="0" alt="'.$alt17.'" title="'.$alt17.'" />';
                    }
                    $arr_img[]='<li style="background:none;margin:0px;padding:0px">'. $getlink17 .'</li>';
}	
if ($params->get('show18')){		
        if ($spotlightImage18) $getlink18 = '';
                   if ($params->get('nolink18')) {$getlink18 = '<a href="'.$link18.'" target="'.$window18.'"><img src="'.JURI::base().$spotlightImage18.'" width="'.$width.'px" height="'.$height.'px" border="0" alt="'.$alt18.'" title="'.$alt18.'" /></a>';
                    } else {
                   $getlink18 = '<img src="'.JURI::base().$spotlightImage18.'" width="'.$width.'px" height="'.$height.'px" border="0" alt="'.$alt18.'" title="'.$alt18.'" />';
                    }
                    $arr_img[]='<li style="background:none;margin:0px;padding:0px">'. $getlink18 .'</li>';
}
if ($params->get('show19')){		
        if ($spotlightImage19) $getlink19 = '';
                   if ($params->get('nolink19')) {$getlink19 = '<a href="'.$link19.'" target="'.$window19.'"><img src="'.JURI::base().$spotlightImage19.'" width="'.$width.'px" height="'.$height.'px" border="0" alt="'.$alt19.'" title="'.$alt19.'" /></a>';
                    } else {
                   $getlink19 = '<img src="'.JURI::base().$spotlightImage19.'" width="'.$width.'px" height="'.$height.'px" border="0" alt="'.$alt19.'" title="'.$alt19.'" />';
                    }
                    $arr_img[]='<li style="background:none;margin:0px;padding:0px">'. $getlink19 .'</li>';
}
if ($params->get('show20')){		
        if ($spotlightImage20) $getlink20 = '';
                   if ($params->get('nolink20')) {$getlink20 = '<a href="'.$link20.'" target="'.$window20.'"><img src="'.JURI::base().$spotlightImage20.'" width="'.$width.'px" height="'.$height.'px" border="0" alt="'.$alt20.'" title="'.$alt20.'" /></a>';
                    } else {
                   $getlink20 = '<img src="'.JURI::base().$spotlightImage20.'" width="'.$width.'px" height="'.$height.'px" border="0" alt="'.$alt20.'" title="'.$alt20.'" />';
                    }
                    $arr_img[]='<li style="background:none;margin:0px;padding:0px">'. $getlink20 .'</li>';
}	
		
       if($random == 1){

            shuffle($arr_img);

        }

        foreach($arr_img as $item) {
		

            echo $item;

		}


    ?>
	</ul>
	<?php if ($params->get('nav')) : ?>
    
	
	<div class="ssbutton" style="width:<?php echo ($width)-15 ?>px;text-align:<?php echo ($buttons) ?>; bottom:15px; padding: 0 25px 0 10px;  position: absolute;  z-index: 200;">
	<a href="#" class="ssprev"><span id="prev<?php echo $module->id?>"><img src="modules/mod_ppc_simple_spotlight/assets/img/button/prev<?php echo $imgbutton ;?>.png" title="Previous" alt="Previous" /></span></a> 
	<a href="#" class="ssnext"><span id="next<?php echo $module->id?>"><img src="modules/mod_ppc_simple_spotlight/assets/img/button/next<?php echo $imgbutton ;?>.png" title="Next" alt="Next" /></span></a>
    </div>
    <?php endif; ?>
</div>
<?php if($enable_shadow=="true") : ?>
	<div class="bgs_bottom" style="margin:0px auto"><div class="bgs_bottom_left"></div><div class="bgs_bottom_right"></div></div>
	<?php endif; ?>
</div>

<div style="clear: both;"></div> 