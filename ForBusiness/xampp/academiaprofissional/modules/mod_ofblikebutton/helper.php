<?php
/*------------------------------------------------------------------------
# mod_ofblikebutton - Optimized Facebook Like Button

# ------------------------------------------------------------------------

# author:    Optimized Sense

# copyright: Copyright (C) 2013 http://www.o-sense.com. All Rights Reserved.

# @license: http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL

# Websites: http://www.o-sense.com

# Technical Support:  http://www.o-sense.com/contacts/technical-support-inquiries.html

-------------------------------------------------------------------------*/
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
class oFBLikeButton{
	public static function getData(&$params ){		
	
		$oFlink	= $params->get('olink');///
		$oFshowSend	= $params->get('oshowSend');///
		$oFstyle	= $params->get('ostyle');
		$oFwidth	= $params->get('owidth', '400');///
		$oFfaces	= $params->get('ofaces');///		
		$oFfont	= $params->get('ofont');///
		$oFcolor	= $params->get('ocolor');///
		$oFverb	= $params->get('overb');///
		$oFsource	= $params->get('osource');///
		$oFlang	    = $params->get('olang');///
		
		if($oFfaces == '1'){
			$oFfaces	= 'true';
		}else{
			$oFfaces	= 'false';
		}
		
		if($oFshowSend == '1'){
			$oFshowSend	= 'true';
		}else{
			$oFshowSend	= 'false';
		}
		
		$data ='';
		
		if($oFsource == '1'){
			//HTML5			
			$data = '<div id="fb-root"></div><script language="javascript" type="text/javascript">(function(d, s, id) {  var js, fjs = d.getElementsByTagName(s)[0];  if (d.getElementById(id)) {return;}  js = d.createElement(s); js.id = id;  js.src = "//connect.facebook.net/'.$oFlang.'/all.js#xfbml=1";  fjs.parentNode.insertBefore(js, fjs);}(document, \'script\', \'facebook-jssdk\'));</script>';
			$data = $data.'<script language="javascript" type="text/javascript">//<![CDATA[ 
																						   document.write(\'<div class="fb-like" data-href="'.$oFlink.'" data-width="'.$oFwidth.'" data-colorscheme="'.$oFcolor.'" data-show-faces="'.$oFfaces.'" data-send="'.$oFshowSend.'" data-font="'.$oFfont.'" data-action="'.$oFverb.'" data-layout="'.$oFstyle.'"></div> \'); 
																						   //]]>
			</script>              <div style="display:none; position: relative; height: 15px; width: 100%; font-size: 10px; color: #808080; font-weight: normal; font-family: \'lucida grande\',tahoma,verdana,arial,sans-serif; line-height: 1.28; text-align: right; direction: ltr;"></div>';
		}else if($oFsource == '2'){
			//XFBML
			$data = '<div id="fb-root"></div><script language="javascript" type="text/javascript">(function(d, s, id) {  var js, fjs = d.getElementsByTagName(s)[0];  if (d.getElementById(id)) {return;}  js = d.createElement(s); js.id = id;  js.src = "//connect.facebook.net/'.$oFlang.'/all.js#xfbml=1";  fjs.parentNode.insertBefore(js, fjs);}(document, \'script\', \'facebook-jssdk\'));</script>';
			$data = $data.'<script language="javascript" type="text/javascript">//<![CDATA[ 
																						   document.write(\'<fb:like href="'.$oFlink.'" width="'.$oFwidth.'" colorscheme="'.$oFcolor.'" show_faces="'.$oFfaces.'" font="'.$oFfont.'" send="'.$oFshowSend.'" layout="'.$oFstyle.'" action="'.$oFverb.'"></fb:like> \'); 
																						   //]]>
			</script>           <div style="display:none; position: relative; height: 15px; width: 100%; font-size: 10px; color: #808080; font-weight: normal; font-family: \'lucida grande\',tahoma,verdana,arial,sans-serif; line-height: 1.28; text-align: right; direction: ltr;"></div>';
		}else { 
			//iFrame			
			$oFsource	="http://www.facebook.com/plugins/like.php?locale=".$oFlang."&amp;href=".$oFlink."&amp;width=".$oFwidth .
					"&amp;colorscheme=".$oFcolor."&amp;show_faces=".$oFfaces .
					"&amp;send=".$oFshowSend."&amp;layout=".$oFstyle."&amp;font=".$oFfont."&amp;action=".$oFverb."&amp;height=26";

			$data = '<iframe src="'.$oFsource.'" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:'.$oFwidth.'px; height:26px;" allowTransparency="true"></iframe>      <div style="display:none; position: relative; height: 15px; width: 100%; font-size: 10px; color: #808080; font-weight: normal; font-family: \'lucida grande\',tahoma,verdana,arial,sans-serif; line-height: 1.28; text-align: right; direction: ltr;"></div>';
		}

		return $data;
	}
}