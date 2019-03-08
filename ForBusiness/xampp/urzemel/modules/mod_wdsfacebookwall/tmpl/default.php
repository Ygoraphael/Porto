
<?php
/**------------------------------------------------------------------------
03.# mod_wdsfacebookwall - WDS Facebook Wall for Joomla! 2.5, 3.X
04.# ------------------------------------------------------------------------
05.# author    Robert Long
06.# copyright Copyright (C) 2013 Webdesignservices.net. All Rights Reserved.
07.# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
08.# Websites: http://www.webdesignservices.net
09.# Technical Support:  Support - https://www.webdesignservices.net/support/customer-support.html
10.------------------------------------------------------------------*/
// no direct access
defined('_JEXEC') or die;

	try {

	$db = JFactory::getDBO();

$query = "SELECT * from `#__wdsfacebookkeywords_select`";

$db->setQuery($query);

$row = $db->loadRow();

} catch (Exception $e) {

  $row=0; 

}


?>

<?php
if(($params->get('more_code', 1)==5)) { 

?>

<script src="<?php echo JURI::root();?>modules/mod_wdsfacebookwall/js/jquery.min.js" ></script>

<!--<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>-->
<script type="text/javascript">

jQuery.noConflict();       
window.addEvent("load", function(){

// The height of the content block when it's not expanded
var adjustheight = 80;
// The "more" link text
var moreText = "<?php echo trim($params->get('see_more'));?>";
// The "less" link text
var lessText = "<?php echo trim($params->get('see_less'));?>";

// Sets the .more-block div to the specified height and hides any content that overflows
jQuery(".more-less .more-block").css('height', adjustheight).css('overflow', 'hidden');

// The section added to the bottom of the "more-less" div
jQuery(".more-less").append('<a href="#" class="adjust"></a>');

jQuery("a.adjust").text(moreText);

jQuery(".adjust").toggle(function() {
		jQuery(this).parents("div:first").find(".more-block").css('height', 'auto').css('overflow', 'visible');
		// Hide the [...] when expanded
		jQuery(this).parents("div:first").find("p.continued").css('display', 'none');
		jQuery(this).text(lessText);
	}, function() {
		jQuery(this).parents("div:first").find(".more-block").css('height', adjustheight).css('overflow', 'hidden');
		jQuery(this).parents("div:first").find("p.continued").css('display', 'block');
		jQuery(this).text(moreText);
});
});

</script>

<?php } ?>
<?php if(($params->get('more_code', 1)==1) || ($params->get('more_code', 1)==3)) { ?>
<?php
$document = JFactory::getDocument();
$document->addScriptDeclaration('
jQuery.noConflict();    
 window.addEvent("load", function(){

var adjustheight = 80;

var moreText = "'.$params->get(see_more).'";
var lessText = "'.$params->get(see_less).'";

jQuery(".more-less .more-block").css("height", adjustheight).css("overflow", "hidden");

jQuery(".more-less").append("<a href="#" class="adjust"></a>");

jQuery("a.adjust").text(moreText);

jQuery(".adjust").toggle(function() {
		jQuery(this).parents("div:first").find(".more-block").css("height", "auto").css("overflow", "visible");
		jQuery(this).parents("div:first").find("p.continued").css("display", "none");
		jQuery(this).text(lessText);
	}, function() {
		jQuery(this).parents("div:first").find(".more-block").css("height", adjustheight).css("overflow", "hidden");
		jQuery(this).parents("div:first").find("p.continued").css("display", "block");
		jQuery(this).text(moreText);
});
});

');

?>
<?php }else{ if(($params->get('more_code', 1)==2) || ($params->get('more_code', 1)==4)){?>
<script type="text/javascript">
var $s = jQuery.noConflict();           
$s(document).ready(function() {
   
// The height of the content block when it's not expanded
var adjustheight = 80;
// The "more" link text
var moreText = "<?php echo trim($params->get('see_more'));?>";
// The "less" link text
var lessText = "<?php echo trim($params->get('see_less'));?>";

// Sets the .more-block div to the specified height and hides any content that overflows
$s(".more-less .more-block").css('height', adjustheight).css('overflow', 'hidden');

// The section added to the bottom of the "more-less" div
$s(".more-less").append('<a href="#" class="adjust"></a>');

$s("a.adjust").text(moreText);

$s(".adjust").toggle(function() {
		$s(this).parents("div:first").find(".more-block").css('height', 'auto').css('overflow', 'visible');
		// Hide the [...] when expanded
		$s(this).parents("div:first").find("p.continued").css('display', 'none');
		$s(this).text(lessText);
	}, function() {
		$s(this).parents("div:first").find(".more-block").css('height', adjustheight).css('overflow', 'hidden');
		$s(this).parents("div:first").find("p.continued").css('display', 'block');
		$s(this).text(moreText);
});
});
</script>
<?php }} ?>



<style>
	
	#container{
		width:700px;
		margin:auto;
	}
	a.adjust{
		padding:2px;
		display:block;
		font-weight:bold;
		background:#eee;
		color:#333;
		border-radius:12px;
		-webkit-border-radius:12px;
		-moz-border-radius:12px;
		width:50px;
		text-align:center;
		text-decoration:none;
		font-size:11px;
	}
		a.adjust:hover{
			background:#d98313;
			color:#FFF;
			-webkit-transition: all 400ms; /*safari and chrome */
			-moz-transition: all 400ms ease; /* firefox */
			-o-transition: all 400ms ease; /* opera */
			transition: all 400ms ease;
		}
	p.continued{
		margin-top:0;
	}
	
</style>
<div id="wds-container">
   <?php if($params->get('topheader', 1)==1) {?>
    <div id="wds-header">
    <h2><a href="<?php echo trim($params->get('headertext_link'));?>" target="_blank"><?php echo trim($params->get('header_text'));?></a></h2>
   
      <div style="clear: both;"></div>
    </div>
    <?php }?>
    <?php if($params->get('like_Box', 1)==1) {

		echo "<iframe src='//www.facebook.com/plugins/likebox.php?href=http://www.facebook.com/".$params->get('Like_ID', '')."&amp;width=200&amp;height=180&amp;colorscheme=light&amp;show_faces=true&amp;border_color&amp;stream=false&amp;header=false' scrolling='no' frameborder='0' style='border:none; overflow:hidden; width:100%; height:180px;' allowTransparency='true'></iframe>";

	} 
  ?>
  <div id="wds">
 
    <div id="wds-tweets">
      <div class="wds-tweet-container">
        <ul style="list-style:none;margin: 0;padding: 0;">
        		<div>  
          <?php foreach ($FBdata->data as $news) 
    {   ?>
    
    
    
          <li> 
          <?php
		  
		   //link for particular comment 
		 if(isset($news->actions))
		 {
        $p = $news->actions; 
       }
        //ap fb page name 
        $apname = $news->from; 
		
        //print_r($apname->name); 
        //print_r($apname[0]->name); 
            
        //Check for empty status (for example on shared link only) 
        
                          

			

					
		   
		   
			echo   '<div class="fb-wall-box">';  
			
	if($params->get('show_avatar', 1)==1) {	
 echo '<div class="avatar"><a href="http://www.facebook.com/profile.php?id='.$news->from->id.'"><img class="fb-wall-avatar" style="width:22px" src="https://graph.facebook.com/'.$news->from->id.'/picture?type=square"  /></a>';
 }
echo ' <div class="fb-wall-message"><a href="http://www.facebook.com/profile.php?id='.$news->from->id.'" class="fb-wall-message-from" target="_blank">'.$news->from->name.' </a>';
 
 


 echo '</div></div>';
  if(isset($news->story))
 {
  echo $news->story;
 }
 
 if(isset($news->message))
 {
  echo $news->message;
 }
 
 echo '<div class="fb-wall-data"><div class="fb-wall-media1">';
 
 if($params->get('media_img', 1)==1) {
 if(isset($news->picture))
 {
 echo '<a href="'.$news->link.'" target="_blank" class="fb-wall-media-link1">
 
 <img class="fb-wall-picture" src="'.$news->picture.'">
 
 </a>';
 }
 }
 
echo ' <div class="fb-wall-media-container"> <div class="more-less">
    
    	<div class="more-block">
          <p>';

 if(isset($news->name)&& isset($news->caption) && isset($news->link) && isset($news->description))
 {
echo '<a class="fb-wall-name" href="'.$news->link.'" target="_blank">

'.$news->description.'

</a>
<br>
<a class="fb-wall-caption" href="'.$news->caption.'" target="_blank">'.$news->caption.'</a><span class="fb-wall-description">'.$news->description.'</span>
';
}
else
{
if(isset($news->link) && isset($news->description))
 {
 echo '<a class="fb-wall-name" href="'.$news->link.'" target="_blank">

'.$news->description.'
`
</a>

';
 }
 
 
 
 

}




echo '</p>
    	</div>
 	</div></div></div> ';
?>





<div>
<?php if(isset($news->icon)){

echo "<span class='fb-wall-date'><img class='fb-wall-icon' src='".$news->icon."' title='".$news->type."' alt='' />";
echo $news->created_time."<span>";
}
?>


</div>













      <?php if($params->get('show_groupurl', 1)==1) {?>
		<div><a target="<?php echo $params->get('show_window', '');?>" href="<?php echo $params->get('group_url', '');?>"> goto group </a></div>   <?php }?>
        <?php if($params->get('show_pageurl', 1)==1) {?>
		<div><a target="<?php echo $params->get('show_window', '');?>" href="<?php echo $params->get('page_url', '');?>"> goto page </a> </div>     <?php }?> 
<?php
echo '</div><div style="clear:both"></div>';
//------------------------------------------------------------------------------------------------------------------------------------
 if($params->get('comments', 1)==1) {
if(isset($news->likes)){

							if(count($news->likes->data)==1){
							

//echo count($news->likes->data);
echo '<div class="fb-wall-likes">


<div>
<span>
'.$news->likes->data[0]->name.'</span>
 '.$params->get('like_format', '').'</div>
  </div>';
								

							} else {

								echo '<div class="fb-wall-likes"><div><span>'.count($news->likes->data).'</span>'.$params->get('people_format', '').' '.$params->get('likes_format', '').'</div> </div><div style="clear:both"></div>';
								echo '</div><div style="clear:both"></div>';

							}

						}
//---------------------------------------------------------------------------

if(isset($news->comments)){

if(count($news->comments->data)==1){

echo'<div class="fb-wall-comments"><span class="fb-wall-comment">
<a href="http://www.facebook.com/profile.php?id='.$news->comments->data[0]->from->id.'" class="fb-wall-comment-avatar" target="_blank"><img src="https://graph.facebook.com/'.$news->comments->data[0]->from->id.'/picture?type=square"></a><span class="fb-wall-comment-message"><a class="fb-wall-comment-from-name" href="http://www.facebook.com/profile.php?id='.$news->comments->data[0]->from->id.'" target="_blank">'.$news->comments->data[0]->from->name.'</a> '.$news->comments->data[0]->message.'<span class="fb-wall-comment-from-date">'.$news->comments->data[0]->created_time.'</span></span></span></div>';
		   }
		   
		   else
		   
		   {
		   for($i=0;$i<count($news->comments->data);$i)
		   
		   {
		   
		   
		   echo'<div class="fb-wall-comments"><span class="fb-wall-comment">
<a href="http://www.facebook.com/profile.php?id='.$news->comments->data[$i]->from->id.'" class="fb-wall-comment-avatar" target="_blank"><img src="https://graph.facebook.com/'.$news->comments->data[$i]->from->id.'/picture?type=square"></a><span class="fb-wall-comment-message"><a class="fb-wall-comment-from-name" href="http://www.facebook.com/profile.php?id='.$news->comments->data[$i]->from->id.'" target="_blank">'.$news->comments->data[$i]->from->name.'</a> '.$news->comments->data[$i]->message.'<span class="fb-wall-comment-from-date">'.$news->comments->data[$i]->created_time.'</span></span></span></div>';
$i=$i+1;
		   
		   }
		   
	//-----------------------------------------------------------------------------------------------
	}	   
		   }
		} 
		?>
  
	<?php	   
	echo '</div><div style="clear:both"></div>   </li>';
	}
		  
		  
		  ?>
          
          
    </ul>
        <div style="clear:both"></div>
      </div>
    </div>
  </div>
  <?php if($params->get('fblike_button', 1)==1) {?>
  <div style="word-wrap: break-word; width: 100%;overflow: hidden;"> <br /><iframe src="https://www.facebook.com/plugins/like.php?href=https://www.facebook.com/<?php echo $params->get('Like_ID', '');?>&amp;width=450&amp;height=80&amp;colorscheme=light&amp;layout=standard&amp;action=like&amp;show_faces=<?php echo trim($params->get('show_faces'));?>&amp;send=true&amp;appId=1375417049347542" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:inherit; height:30px;" allowTransparency="true"></iframe></div>
   <?php }?>
 <?php if($params->get('show_link', 1)) : ?>

	<div class="wds-copyright">

    <?php if($row) {?>

		<a href="<?php echo $row[1]; ?>" title="<?php echo $row[0]; ?>" target="_blank"><?php echo $row[0]; ?></a>

         <?php } else {?>

         <a href="http://www.webdesignservices.net" title="web design services" target="_blank">web design services</a>

         <?php } ?>

        	</div>

	<?php endif; ?>
</div>
