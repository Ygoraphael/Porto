<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php 
	if( isset($row) ) {
?>
<div class="col-lg-12 top-bar">
	<h4 class="pull-left"><?php echo $row["u_name"]; ?> <i class="fa fa-check-circle" aria-hidden="true"></i></h4>
</div>
<div class="col-lg-12 top-2-bar">
	<?php echo $row["u_city"]; ?> - <?php echo $row["u_country"]; ?>
</div>
<div class="col-lg-8 img-bar">
	<div class="col-lg-12 img-inner-bar">
	<?php if( sizeof($product_img)>0 ) { ?>
		<img data-remote="<?php echo base_url() . 'image_product/' . $product_img[0]["img"]; ?>" data-toggle="lightbox" data-gallery="product-gallery" src="<?php echo base_url() . 'image_product/' . $product_img[0]["img"]; ?>" class="center-block product_main_img" style="height:400px; min-width:100%; max-width:100%" />
	<?php } ?>
	</div>
	<div class="col-lg-12 product-thumb-container">
	<?php foreach ($product_img as $img) { ?>
		<img width="95" height="95" data-remote="<?php echo base_url() . 'image_product/' . $img["img"]; ?>" src="<?php echo base_url() . 'image_product/' . $img["img"]; ?>" data-gallery="product-gallery" class="product_thumb" />
	<?php } ?>
	</div>
</div>
<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery('.product-thumb-container').slick({
			lazyLoad: 'ondemand',
			infinite: true,
			slidesToShow: 6,
			slidesToScroll: 6,
			dots: true,
			arrows: true
		});
	});
	
	jQuery(".product_thumb").on('click', function() {
		var img_src = jQuery(this).attr("src");
		jQuery('.product_main_img').fadeOut(100, function() {
			jQuery(".product_main_img").attr("src", img_src);
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
<div class="col-lg-4 noleftrightmargin">	
	<?php
		if( sizeof($seats) == 0 && $row["u_quicksel"] == 0 ) {
			echo $this->template->partial->view('wl_operator_product_lotation');
		}
		else if( sizeof($seats) > 0 && $row["u_quicksel"] == 0 ) {
			echo $this->template->partial->view('wl_operator_product_seats');
		}
		else if( sizeof($seats) == 0 && $row["u_quicksel"] == 1 ) {
			echo $this->template->partial->view('wl_operator_product_lotation_quick');
		}
		else if( sizeof($seats) > 0 && $row["u_quicksel"] == 1 ) {
			echo $this->template->partial->view('wl_operator_product_seats_quick');
		}
	?>
</div>
<div class="col-lg-8 product-desc desc-bar">
	<?php echo $row["u_lngdesc"]; ?>
	<?php 
	if($row["u_temscond"] != ""){
		echo "<h2>Terms and conditions</h2><br>".$row["u_temscond"]."<p></p>";
	}
	?>
</div>
<?php } 
if(sizeof($related_products) > 0){
?>
	<div class="col-lg-12 product-desc desc-bar">
	<h2>RELATED PRODUCTS</h2>
	<?php
	foreach($related_products as $rp){
		?>
		<div class="col-sm-3">
			<?php
			if($rp["lastminute"]=='1'){
			?>
				<span class="badge"><?php echo $rp["lastminute_formula"]; ?></span>
				<div id="arp_ribbon_container" class="arp_ribbon_container arp_ribbon_right arp_ribbon_1 " style="">
					<div class="arp_ribbon_content arp_ribbon_right">LAST MINUTE</div>
				</div>
			<?php
			}
			?>  
			<article class="col-item">
				<div class="photo">
					<div class="options-cart-round">
						<a href="<?php echo base_url() . "wl/".$op."/product/".$rp["u_sefurl"]; ?>" class="btn btn-default" title="BOOK NOW">
							<span >BOOK NOW</span>
						</a>
					</div>
					<a href="<?php echo base_url() . "wl/".$op."/product/".$rp["u_sefurl"]; ?>"> 
						<img style="height:162px" src="<?php echo base_url() . 'image_product/' . $rp["img"]; ?>" class="img-responsive" alt="Product Image" /> 
					</a>
				</div>
				<div class="info" style="height:90px">
					<div class="row">
						<div class="price-details col-md-6">
							<a href="<?php echo base_url() . "wl/".$op."/product/".$rp["u_sefurl"]; ?>"><h1><?php echo $rp['u_name']; ?></h1></a>
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
<?php } ?>
<button onclick="topFunction()" id="myBtn" title="Go to">BOOK NOW</button>

<style type="text/css">
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
	letter-spacing: 3px;
	/*width:29%;*/
    display: none; /* Hidden by default */
    position: fixed; /* Fixed/sticky position */
    top: 100px; /* Place the button at the bottom of the page */
     /*right: 7%; Place the button 30px from the right */
    z-index: 99; /* Make sure it does not overlap */
    border: none; /* Remove borders */
    outline: none; /* Remove outline */
    background-color:<?php if($headfoot_color == ""){echo "gray";}else{ echo $headfoot_color; } ?>; /* Set a background color */
    color: white; /* Text color */
    cursor: pointer; /* Add a mouse pointer on hover */
    padding: 15px; /* Some padding */
    border-radius: 10px; /* Rounded corners */
	box-shadow: 0px 3px 12px rgba(2, 2, 2, 0.76);
}

#myBtn:hover {
    background-color: #555; /* Add a dark-grey background on hover */
}
.alert>p, .alert>ul {
    list-style-type: none;
}
</style>

<script>
var calendar_width = $(".calendar-top-container").width();
var calendar_left = $(".calendar-top-container").offset().left;
var primary_header = $(".primary-header").height();
$("#myBtn").width(calendar_width);
$("#myBtn").css({left: calendar_left,top: primary_header + 20});

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