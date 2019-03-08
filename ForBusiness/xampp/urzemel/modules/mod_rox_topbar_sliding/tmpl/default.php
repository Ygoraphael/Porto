<?php 
/*------------------------------------------------------------------------
# Rox Topbar Sliding by http://www.themerox.com
# ------------------------------------------------------------------------
# Author    ThemeRox  http://www.themerox.com
# Copyright (C) 2010 - 2015 http://www.themerox.com All Rights Reserved.
# @license - Copyrighted Commercial
# Websites: http://www.themerox.com
-------------------------------------------------------------------------*/
?>
<div class="module<?php echo $moduleclass_sfx;?> rox-close-hide" id="Open">
	<div class="rox-close">
		<div class="rox-wrapper">
			<div class="rox-scr-left">
				<img class="" src="<?php if($params->get('topbar_slide_img1')!=null)
				{echo $params->get('topbar_slide_img1');}
					else 
				{ echo JURI::root(true).'/modules/mod_rox_topbar_sliding/assets/images/cell.png';}?>"/>
				<p class="cell"><?php echo $params->get('cell_number') ?></p>
				<img class="rox_topbar_mail" src="<?php if($params->get('topbar_slide_img2')!=null)
				{echo $params->get('topbar_slide_img2');}
					else 
				{ echo JURI::root(true).'/modules/mod_rox_topbar_sliding/assets/images/mail.png';}?>"/>
				<p class="cell"><?php echo $params->get('mail_address') ?></p>
			</div>
			
			
			<div class="rox-scr-right">
				<p><?php echo $params->get('social_caption') ?></p>
				<a href="<?php echo $params->get('topbar_link1') ?>" class="facebook">Facebook</a>
				<a href="<?php echo $params->get('topbar_link2') ?>" class="twitter">Twitter
				</a>
				<a href="<?php echo $params->get('topbar_link3') ?>" class="googlep">Google Plus
				</a>
				<a href="<?php echo $params->get('topbar_link4') ?>" class="flicker">
				Flicker	
				</a>
				<a href="<?php echo $params->get('topbar_link5') ?>" class="pinterest">
				Pinterest	
				</a>
			</div>
		</div>
	</div>
</div>
<div class="open"><div class="rox-wrapper"><p class="">Click</p></div></div>
