<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>

<script>
	function loader( status, position ) {
		if( status == 1 ) {
			if( !jQuery( position ).hasClass( "div-loader" ) ) {
				jQuery( position ).append( "<div class='div-loader'></div>" );
			}
		}
		else {
			jQuery( position ).remove( ".div-loader" );
		}
	}
</script>

<?php 
	if( isset($row) ) {
?>

<div class="col-lg-12 listing-cover listing-cover-product">
	<div class="container">
	<?php
		if( sizeof($product_img) > 0 ) {
			$first_img = base_url() . 'image_product/' . $product_img[0]["img"];
		}
		else {
			$first_img = "http://i1.wp.com/europeanworld.eu/wp-content/uploads/2016/07/capa-1-e1470670577303.jpg";
		}
	?>
		<div id="search-bg" style="background-image:url('<?php echo $first_img; ?>')"></div>
		<div class="row left product_main_text">
			<?php echo $row["u_name"]; ?>
			<span class="claimed-ribbon popup-trigger" aria-hidden="true">
				<i class="fa fa-check-circle" aria-hidden="true"></i>
				<span class="tooltip">Verified Listing</span>
			</span>
			<a href="#what-is-claimed" class="">
				
			</a>
		</div>
		<div class="row left product_main_text2">
			<?php echo $row["u_city"]; ?> - <?php echo $row["u_country"]; ?>
		</div>
		<div class="row left product_main_text2" style="color:white; font-size:15px; max-width:650px; margin-top:15px;">
			<?php echo (sizeof($categories) > 0) ? $categories[0]["category"] : ""; ?>
		</div>
	</div>
</div>
<div class="row centered" style="margin-top:25px">
	<div class="container">
		<div class="col-lg-8 product_height">
			<div class="col-lg-12">
				<?php
					if( sizeof($product_img)>0 ) {
				?>
				<img data-remote="<?php echo base_url() . 'image_product/' . $product_img[0]["img"]; ?>" data-toggle="lightbox" data-gallery="product-gallery" src="<?php echo base_url() . 'image_product/' . $product_img[0]["img"]; ?>" class="product_main_img center-block"/>
				<?php
					}
				?>
			</div>
			<div class="col-lg-12 product-thumb-container">
				<?php 
					foreach ($product_img as $img) {
				?>
				<img width="95" height="95" data-remote="<?php echo base_url() . 'image_product/' . $img["img"]; ?>" src="<?php echo base_url() . 'image_product/' . $img["img"]; ?>" data-gallery="product-gallery" class="product_thumb" />
				<?php
					}
				?>
			</div>
			<script type="text/javascript">
				jQuery(document).ready(function(){
					jQuery('.product-thumb-container').slick({
						lazyLoad: 'ondemand',
						infinite: true,
						slidesToShow: 6,
						slidesToScroll: 6,
						dots: true
					});
				});
				
				jQuery(".product_thumb").on('click', function() {
					var img_src = jQuery(this).attr("src");
					jQuery('.product_main_img').fadeOut(100, function() {
						jQuery(".product_main_img").attr("src", img_src);
						jQuery(".product_main_img").attr("data-remote", img_src);
						jQuery(".product_main_img_a").attr("href", img_src);
						jQuery('.product_main_img').fadeIn(100);
					});
				});
				
				jQuery(document).on('click', '[data-toggle="lightbox"]', function(event) {
					event.preventDefault();
					jQuery(this).ekkoLightbox({
						showArrows: true,
						alwaysShowClose: true
					});
				});
			</script>
			<div class="col-lg-12 product-desc">
				<?php echo $row["u_lngdesc"]; ?>
			</div>
		</div>
		<div class="col-lg-4 noleftrightmargin">	
			<?php
				if( sizeof($seats) == 0 ) {
					echo $this->template->partial->view('product_lotation');
				}
				else {
					echo $this->template->partial->view('product_seats');
				} 
			?>
		</div>
	</div>

<?php } ?>
