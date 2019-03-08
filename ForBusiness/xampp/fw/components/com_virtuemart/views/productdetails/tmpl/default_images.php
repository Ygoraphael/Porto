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
if (VmConfig::get('usefancy', 1)) {
    vmJsApi::js('fancybox/jquery.fancybox-1.3.4.pack');
    vmJsApi::css('jquery.fancybox-1.3.4');
    $document = JFactory::getDocument();
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
    vmJsApi::js('facebox');
    vmJsApi::css('facebox');
    $document = JFactory::getDocument();
    $imageJS = '
	jQuery(document).ready(function() {
		jQuery("a[rel=vm-additional-images]").facebox();

		var imgtitle = jQuery("span.vm-img-desc").text();
		jQuery("#facebox span").html(imgtitle);
		
		
	});
	';
}
$document->addScriptDeclaration($imageJS);
?>

<?php
$sku = explode("|||", $this->product->product_sku);
if (count($sku) == 2) {
    $img_source = strtolower($sku[0] . '-' . $sku[1]);

    $filename = 'products360/';
    $its_cool = 1;
    for ($i = 1; $i <= 50; $i++) {
        if (!file_exists($filename . $img_source . '_' . $i . '.png')) {
            $its_cool = 0;
        }
    }

    if ($its_cool) {
        ?>
        <link rel="stylesheet" href="<?= JUri::base() ?>CSS/threesixty.css" type="text/css">
        <div id="threesixty" class="threesixty model3d">
            <div class="spinner">
                <span>0%</span>
            </div>
            <ol class="threesixty_images"></ol>
        </div>
        <div class="w-98" style="border-bottom:1px solid #F40;"></div>
        <br>
        <a class="btn btn-primary w-19 custom_previous addtocart-button"><i class="icon-backward"></i><i class="fa fa-backward" aria-hidden="true"></i></a>
        <a class="btn btn-primary w-19 butfull addtocart-button"><i class="fa fa-arrows-alt" aria-hidden="true"></i></a>
        <a class="btn btn-primary w-19 custom_play addtocart-button"><i class="icon-play"></i><i class="fa fa-play" aria-hidden="true"></i></a>
        <a class="btn btn-primary w-19 custom_stop addtocart-button"><i class="icon-pause"></i><i class="fa fa-pause" aria-hidden="true"></i></a>
        <a class="btn btn-primary w-19 custom_next addtocart-button"><i class="fa fa-forward" aria-hidden="true"></i><i class="icon-forward"></i></a>
        <div class="clear"></div>
        <script type="text/javascript" src="<?= JUri::base() ?>js/threesixty.fullscreen.js"></script>
        <script type="text/javascript" src="<?= JUri::base() ?>js/threesixty.min.js"></script>

        <script>
            var mod3d = jQuery('.model3d').ThreeSixty({
                totalFrames: 50, // Total no. of image you have for 360 slider
                endFrame: 50, // end frame for the auto spin animation
                currentFrame: 1, // This the start frame for auto spin
                imgList: '.threesixty_images', // selector for image list
                progress: '.spinner', // selector to show the loading progress
                imagePath: '<?= JUri::base() ?>products360/', // path of the image assets
                filePrefix: '<?= $img_source ?>_', // file prefix if any
                ext: '.png', // extention for the assets
                height: jQuery(".main-image-holder").width() * 600 / 800,
                width: jQuery(".main-image-holder").width(),
                navigation: false,
                plugins: ['ThreeSixtyFullscreen']
            });

            jQuery('.custom_previous').bind('click', function (e) {
                mod3d.previous();
            });
            jQuery('.custom_next').bind('click', function (e) {
                mod3d.next();
            });
            jQuery('.custom_play').bind('click', function (e) {
                mod3d.play();
            });
            jQuery('.custom_stop').bind('click', function (e) {
                mod3d.stop();
            });
        </script>
        <?php
    } else {
        if ($this->product->images[0]->file_url != 'images/stories/virtuemart/product/') {
            $imagem = $this->product->images[0]->file_url;
        } else {
            $imagem = $this->product->images[0]->file_url . "logotipo.png";
        }
        ?>
        <img class="img-fluid" src="<?= $imagem; ?>" alt="<?= $this->product->product_name ?>">
        <?php
    }
}
?>