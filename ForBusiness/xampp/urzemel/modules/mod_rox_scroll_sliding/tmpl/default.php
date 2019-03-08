<?php 
/*------------------------------------------------------------------------
# Rox carouseloll Sliding by http://www.themerox.com
# ------------------------------------------------------------------------
# Author    ThemeRox  http://www.themerox.com
# Copyright (C) 2010 - 2015 http://www.themerox.com All Rights Reserved.
# @license - Copyrighted Commercial
# Websites: http://www.themerox.com
-------------------------------------------------------------------------*/
?>
<div class="module<?php echo $moduleclass_sfx;?>">
	<div class="rox-carousel-hidden">
		<div class="rox-wrapper">
			<div class="rox-carousel-left">
			<img class="" src="<?php if($params->get('carousel_slide_img1')!=null)
				{echo $params->get('carousel_slide_img1');}
					else 
				{ echo JURI::root(true).'/modules/mod_rox_scroll_sliding/assets/images/banner.png';}?>"/>
			</div>		
			<div class="rox-carousel-right">
			<div class="carousel_wrapper">
					
			<div class="list_carousel">
			<ul id="foo2">
			<li><img src="<?php if($params->get('carousel_slide_img2')!=null)
				{echo $params->get('carousel_slide_img2');}
					else 
				{ echo JURI::root(true).'/modules/mod_rox_scroll_sliding/assets/images/1.png';}?>" width="85px" height="35px"/></li>
			<li><img src="<?php if($params->get('carousel_slide_img3')!=null)
				{echo $params->get('carousel_slide_img3');}
					else 
				{ echo JURI::root(true).'/modules/mod_rox_scroll_sliding/assets/images/2.png';}?>"width="85px" height="35px"/></li>
			<li><img src="<?php if($params->get('carousel_slide_img4')!=null)
				{echo $params->get('carousel_slide_img4');}
					else 
				{ echo JURI::root(true).'/modules/mod_rox_scroll_sliding/assets/images/3.png';}?>"width="85px" height="35px"/></li>
			<li><img src="<?php if($params->get('carousel_slide_img5')!=null)
				{echo $params->get('carousel_slide_img5');}
					else 
				{ echo JURI::root(true).'/modules/mod_rox_scroll_sliding/assets/images/4.png';}?>"width="85px" height="35px"/></li>
			<li><img src="<?php if($params->get('carousel_slide_img6')!=null)
				{echo $params->get('carousel_slide_img6');}
					else 
				{ echo JURI::root(true).'/modules/mod_rox_scroll_sliding/assets/images/5.png';}?>"width="85px" height="35px"/></li>
			<li><img src="<?php if($params->get('carousel_slide_img7')!=null)
				{echo $params->get('carousel_slide_img7');}
					else 
				{ echo JURI::root(true).'/modules/mod_rox_scroll_sliding/assets/images/1.png';}?>"width="85px" height="35px"/></li>
			<li><img src="<?php if($params->get('carousel_slide_img8')!=null)
				{echo $params->get('carousel_slide_img8');}
					else 
				{ echo JURI::root(true).'/modules/mod_rox_scroll_sliding/assets/images/2.png';}?>"width="85px" height="35px"/></li>
			<li><img src="<?php if($params->get('carousel_slide_img9')!=null)
				{echo $params->get('carousel_slide_img9');}
					else 
				{ echo JURI::root(true).'/modules/mod_rox_scroll_sliding/assets/images/3.png';}?>"width="85px" height="35px"/></li>
			<li><img src="<?php if($params->get('carousel_slide_img10')!=null)
				{echo $params->get('carousel_slide_img10');}
					else 
				{ echo JURI::root(true).'/modules/mod_rox_scroll_sliding/assets/images/4.png';}?>"width="85px" height="35px"/></li>
			<li><img src="<?php if($params->get('carousel_slide_img11')!=null)
				{echo $params->get('carousel_slide_img11');}
					else 
				{ echo JURI::root(true).'/modules/mod_rox_scroll_sliding/assets/images/5.png';}?>"width="85px" height="35px"/></li>
			</ul>
			</div>
			<div class="rox_carousel_pagination">
				<a id="prev2" class="prev" href="#"></a>
				<a id="next2" class="next" href="#"></a>
			</div>
			</div>
			</div>
		</div>
	</div>
</div>
<div class="rox-carousel-open"><div class="rox-wrapper"><p class="">Click</p></div></div>
