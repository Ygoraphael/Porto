<?php
/**
 *
 * Show the product details page
 *
 * @package	VirtueMart
 * @subpackage
 * @author Max Milbers, Valerie Isaksen

 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: default_images.php 6188 2012-06-29 09:38:30Z Milbo $
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
if(VmConfig::get('usefancy',1)){
	vmJsApi::js( 'fancybox/jquery.fancybox-1.3.4.pack');
	vmJsApi::css('jquery.fancybox-1.3.4');
	$document = JFactory::getDocument ();
	$imageJS = '
	jQuery(document).ready(function() {
		jQuery("a[rel=vm-additional-images]").fancybox({
			"titlePosition" 	: "inside",
			"transitionIn"	:	"elastic",
			"transitionOut"	:	"elastic"
		});
		jQuery(".additional-images a.product-image.image-0").removeAttr("rel");
		jQuery(".additional-images img.product-image").click(function() {
			jQuery(".additional-images a.product-image").attr("rel","vm-additional-images" );
			jQuery(this).parent().children("a.product-image").removeAttr("rel");
			var src = jQuery(this).parent().children("a.product-image").attr("href");
			jQuery(".main-image img").attr("src",src);
			jQuery(".main-image img").attr("alt",this.alt );
			jQuery(".main-image a").attr("href",src );
			jQuery(".main-image a").attr("title",this.alt );
			jQuery(".main-image .vm-img-desc").html(this.alt);
		}); 
	});
	';
	
} else {
	vmJsApi::js( 'facebox' );
	vmJsApi::css( 'facebox' );
	$document = JFactory::getDocument ();
	$imageJS = '
	jQuery(document).ready(function() {
		jQuery("a[rel=vm-additional-images]").facebox();

		var imgtitle = jQuery("span.vm-img-desc").text();
		jQuery("#facebox span").html(imgtitle);
		
		
	});
	';
}
$document->addScriptDeclaration ($imageJS);

if (!empty($this->product->images)) {
	$count_images = count ($this->product->images);
	
	$image = $this->product->images[0];
	?>
	<div class="main-image">
		<?php 
			
			if( $image->file_url == 'images/stories/virtuemart/product/')
				echo '<img id="imagecont" src="components/com_virtuemart/assets/images/vmgeneral/noimage.gif" id="img_zoom">';
			else
				echo '<img src="'.$image->file_url.'" id="img_zoom">';
		?>
		<script>jQuery("#img_zoom").elevateZoom({zoomWindowPosition: 2});</script>
		<script>
			function glass(id) {
				<?php
					for ($i = 0; $i < $count_images; $i++) {
						$image = $this->product->images[$i];
						if( $image->file_url <> 'images/stories/virtuemart/product/') { 
							$imagem = "'".$this->baseurl."/".$image->file_url."'";
						} 
						else { 
							$imagem = "'".$this->baseurl."/".$image->file_url . "logotipo.png"."'";
						}
						$str = 'if (id == ' . $i . ' ) {';
						$str .= 'jQuery(".zoomWindow").css("background-image", "url('.$imagem.')");';
						$str .= '}';
						echo $str;
					}
				?>
			}
		</script>
		<div class="clear"></div>
	</div>
	<?php
	
	$image_glass = 0;
	if ($count_images > 1) {
		?>
		<div class="additional-images">
			<?php
			$start_image = VmConfig::get('add_img_main', 1) ? 0 : 1;
			for ($i = $start_image; $i < $count_images; $i++) {
				$image = $this->product->images[$i];
				?>
				<div class="floatleft">
					<?php
					if(VmConfig::get('add_img_main', 1)) {
						echo $image->displayMediaThumb('onclick="glass('.$image_glass.');" class="product-image" style="cursor: pointer"',false,"");
						echo '<a href="'. $image->file_url .'" class="product-image image-'. $i .'" style="display:none;" title="'. $image->file_meta .'" rel="vm-additional-images"></a>';
					} else {
						echo $image->displayMediaThumb("",true," rel='vm-additional-images'");
					}
					?>
				</div>
			<?php
				$image_glass++;
			}
			?>
			<div class="clear"></div>
		</div>
	<?php
	}
}
// Showing The Additional Images END ?>