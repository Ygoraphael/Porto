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
			<a href="#what-is-claimed" class=""></a>
		</div>
		<div class="row left product_main_text2">
			<?php echo $row["u_city"]; ?> - <?php echo $row["u_country"]; ?>
		</div>
		<div class="row left product_main_text2" style="color:white; font-size:15px; max-width:650px; margin-top:15px;">
			<?php echo (sizeof($categories) > 0) ? $categories[0]["category"] : ""; ?>
		</div>
	</div>
</div>
<div class="row centered">
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
			<div class="col-lg-12">
				<div class="col-lg-12 product-thumb-container">
				<?php 
					foreach ($product_img as $img) {
				?>
				<img width="95" height="95" data-remote="<?php echo base_url() . 'image_product/' . $img["img"]; ?>" src="<?php echo base_url() . 'image_product/' . $img["img"]; ?>" data-gallery="product-gallery" class="product_thumb" />
				<?php
					}
				?>
				</div>
			</div>
			<div class="col-lg-12">
				<div class="row">
					<div class="social2">
						 <ul>
							<li><a class="fb-xfbml-parse-ignore" target="popup" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=<?php echo current_url();?>','popup','width=600,height=500'); return false;" ><i class="fa fa-lg fa-facebook"></i></a></li>
							<li><a  class="fb-xfbml-parse-ignore" target="popup" onclick="window.open('https://twitter.com/intent/tweet?original_referer=tweetbutton&url=<?php echo current_url();?>%20share%20text&hashtags=<?php echo $categories[0]["category"]; ?>%2C<?php echo $row["u_city"]; ?>%2C<?php echo $row["u_country"]; ?>%20<?php echo current_url();?>','popup','width=600,height=500'); return false;"><i class="fa fa-lg fa-twitter"></i></a></li>
							<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
							<li><a  class="fb-xfbml-parse-ignore" target="popup" onclick="window.open('https://plus.google.com/share?url=<?php echo current_url();?>','popup','width=500,height=400'); return false;"><i class="fa fa-lg fa-google-plus"></i></a></li> 
						</ul>
					</div>
				</div>
			</div>
			<style type="text/css">
				.social2 {
					margin: 0;
					padding: 0;
				}

				.social2 ul {
					margin: 0;
					padding: 5px;
				}

				.social2 ul li {
					margin: 12px;
					list-style: none outside none;
					display: inline-block;
				}

				.social2 i {
					width: 40px;
					height: 40px;
					color: #FFF;
					background-color: #909AA0;
					font-size: 22px;
					text-align:center;
					padding-top: 12px;
					border-radius: 50%;
					-moz-border-radius: 50%;
					-webkit-border-radius: 50%;
					-o-border-radius: 50%;
					transition: all ease 0.3s;
					-moz-transition: all ease 0.3s;
					-webkit-transition: all ease 0.3s;
					-o-transition: all ease 0.3s;
					-ms-transition: all ease 0.3s;
				}

				.social2 i:hover {
					color: #FFF;
					text-decoration: none;
					transition: all ease 0.3s;
					-moz-transition: all ease 0.3s;
					-webkit-transition: all ease 0.3s;
					-o-transition: all ease 0.3s;
					-ms-transition: all ease 0.3s;
				}

				.social2 .fa-facebook:hover {
					background: #4060A5;
				}

				.social2 .fa-twitter:hover {
					background: #00ABE3;
				}

				.social2 .fa-google-plus:hover {
					background: #e64522;
				}

				.social2 .fa-github:hover {
					background: #343434;
				}

				.social2 .fa-pinterest:hover {
					background: #cb2027;
				}

				.social2 .fa-linkedin:hover {
					background: #0094BC;
				}

				.social2 .fa-flickr:hover {
					background: #FF57AE;
				}

				.social2 .fa-instagram:hover {
					background: #375989;
				}

				.social2 .fa-vimeo-square:hover {
					background: #83DAEB;
				}

				.social2 .fa-stack-overflow:hover {
					background: #FEA501;
				}

				.social2 .fa-dropbox:hover {
					background: #017FE5;
				}

				.social2 .fa-tumblr:hover {
					background: #3a5876;
				}

				.social2 .fa-dribbble:hover {
					background: #F46899;
				}

				.social2 .fa-skype:hover {
					background: #00C6FF;
				}

				.social2 .fa-stack-exchange:hover {
					background: #4D86C9;
				}

				.social2 .fa-youtube:hover {
					background: #FF1F25;
				}

				.social2 .fa-xing:hover {
					background: #005C5E;
				}

				.social2 .fa-rss:hover {
					background: #e88845;
				}

				.social2 .fa-foursquare:hover {
					background: #09B9E0;
				}

				.social2 .fa-youtube-play:hover {
					background: #DF192A;
				}
			
				.arp_ribbon_right .arp_ribbon_content {
					background: #0c0b0b;
					background-color: #0c0b0b;
					background-image: -moz-linear-gradient(0deg,#0c0b0b,#514e4e,#0c0b0b)background-image:-webkit-gradient(linear, 0 0, 0 0, color-stop(0%,#0c0b0b), color-stop(50%,#514e4e), color-stop(100%,#0c0b0b));
					background-image: -webkit-linear-gradient(left,#0c0b0b 0%, #514e4e 51%, #0c0b0b 100%);
					background-image: -o-linear-gradient(left,#0c0b0b 0%, #514e4e 51%, #0c0b0b 100%);
					background-image: linear-gradient(90deg,#0c0b0b,#514e4e, #0c0b0b);
					background-image: -ms-linear-gradient(left,#0c0b0b,#514e4e, #0c0b0b);
					filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#514e4e', endColorstr='#0c0b0b', GradientType=1);
					-ms-filter: "progid:DXImageTransform.Microsoft.gradient (startColorstr="#514e4e", endColorstr="#0c0b0b", GradientType=1)";
					background-repeat: repeat-x;
					border-top: 1px solid #1a1818;
					box-shadow: 13px 1px 2px rgba(0,0,0,0.6);
					color: #ffffff;
					text-shadow: 0 0 1px rgba(0,0,0,0.4);
					width: 125px;
					font-size: 11px;
					font-weight: 700;
					letter-spacing: 1px;
					position: relative;
					text-align: center;
					z-index: 1;
					padding: 4px 0px 4px 24px;
					text-shadow: 0 0 1px rgba(0,0,0,0.4);
					left: -10px;
					top: 17px;
					transform: rotate(40deg);
					-webkit-transform: rotate(40deg);
					-moz-transform: rotate(40deg);
					-o-transform: rotate(40deg);
					width: 157px;
				}
				.arp_ribbon_container.arp_ribbon_right {
					position: absolute;
					width: 120px;
					height: 95px;
					overflow: hidden;
					right: 16px;
					top: 1px;
					z-index: 2;
				}
				.badge {
					/*background: green;*/
					position: absolute;
					height: 40px;
					width: 70px;
					border-radius: 0;
					line-height: 33px !important;
					font-weight: 300;
					font-size: 14px;
					/*border: 2px solid #FFF;*/
					/*box-shadow: 0 0 0 1px green;*/
					top: 10px;
					left: 16px;
					display: inline-block;
					min-width: 10px;
					padding: 3px 7px;
					color: #fff !important;
					text-align: center;
					white-space: nowrap;
					z-index: 22;
				}

				#myBtn {
					display: none; /* Hidden by default */
					position: fixed; /* Fixed/sticky position */
					bottom: 20px; /* Place the button at the bottom of the page */
					right: 30px; /* Place the button 30px from the right */
					z-index: 99; /* Make sure it does not overlap */
					border: none; /* Remove borders */
					outline: none; /* Remove outline */
					background: #1b2a33;
					color: white;	
					cursor: pointer; /* Add a mouse pointer on hover */
					padding: 15px; /* Some padding */
					box-shadow: 0 0 0 3px #86754d;
					border-radius: 4px;
				}

				#myBtn:hover {
					background-color: #555; /* Add a dark-grey background on hover */
				}

			</style>
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
			<?php
				$original_desc = html_entity_decode($row["u_lngdesc"]);
				$document = new DOMDocument();
				$document->loadHTML($row["u_lngdesc"]);
	
				$elements = $document->getElementsByTagName('html');
				
				if( $elements->length ) {
					$texto_ar = explode("\n", $elements[0]->textContent);
					
					foreach($texto_ar as $texto) {
						if( trim($texto) != '' ) {
							$original_desc = str_replace(trim($texto), $this->googletranslate->translate($_SESSION["language_code"], trim($texto)), $original_desc);
							// log_message("ERROR", print_r($original_desc, true));
				}
			}
		}
	?>
	
	<?php echo $original_desc;?>
				
			</div>
		</div>
		<div class="col-lg-4 noleftrightmargin">
			<?php
				if( sizeof($seats) == 0 ) {
					echo $this->template->partial->view('product_lotation');
				}
				else if( sizeof($seats) > 0 ) {
					echo $this->template->partial->view('product_seats');
				}
			?>
		</div>
	
		<?php
		if(sizeof($related_products) > 0){
		?>
		<div class="col-lg-12 product-desc desc-bar">
		<h2><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'RELATED PRODUCTS'); ?></h2>
		<?php
		foreach($related_products as $rp){
			?>
			<div class="col-sm-3">
				<?php
				if($rp["lastminute"]=='1'){
				?>
					<span class="badge"><?php echo $rp["lastminute_formula"]; ?></span>
					<div id="arp_ribbon_container" class="arp_ribbon_container arp_ribbon_right arp_ribbon_1 " style="">
						<div class="arp_ribbon_content arp_ribbon_right"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'LAST MINUTE'); ?></div>
					</div>
				<?php
				}
				?>  
				<article class="col-item">
					<div class="photo">
						<div class="options-cart-round">
							<a href="<?php echo base_url() . "product/".$rp["u_sefurl"]; ?>" class="btn btn-default" title="BOOK NOW">
								<span ><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'BOOK NOW'); ?></span>
							</a>
						</div>
						<a href="<?php echo base_url() . "product/".$rp["u_sefurl"]; ?>"> 
							<img style="height:162px" src="<?php echo base_url() . 'image_product/' . $rp["img"]; ?>" class="img-responsive" alt="Product Image" /> 
						</a>
					</div>
					<div class="info" style="height:90px">
						<div class="row">
							<div class="price-details col-md-6">
								<a href="<?php echo base_url() . "product/".$rp["u_sefurl"]; ?>"><h1><?php echo $rp['u_name']; ?></h1></a>
								<br>
								<p class="details">
									<?php echo $rp['u_city'].", ".$rp['u_country'];?>
								</p>
							</div>
						</div>
					</div>
				</article>
			</div>
		<?php
		}
		?>
		</div>
		<?php 
		} 
		?>
		<button onclick="topFunction()" id="myBtn" title="Go to" style="padding:15px; height:50px"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'BOOK NOW'); ?></button>
		<script>
			var calendar_width = $(".calendar-top-container").width();
			var calendar_left = $(".calendar-top-container").offset().left;
			var primary_header = $(".primary-header").height();
			$("#myBtn").width(calendar_width);
			$("#myBtn").css({left: calendar_left,top: primary_header + 40});

			window.onscroll = function() {scrollFunction()};

			function scrollFunction() {
				if (document.body.scrollTop >$(".calendar-top-container").offset().top+$(".calendar-top-container").outerHeight(true)-180 || document.documentElement.scrollTop > 5) {
					document.getElementById("myBtn").style.display = "block";
				} else {
					document.getElementById("myBtn").style.display = "none";
				}
			}

			// When the user clicks on the button, scroll to the top of the document
			function topFunction() {
				$('html, body').animate({
					scrollTop: $(".calendar-top-container").offset().top-primary_header-30
				}, 1000);
			}
		</script>
	</div>
<?php } ?>
