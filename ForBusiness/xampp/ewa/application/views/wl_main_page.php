<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>

<div class="row centered">
	<div class="home-widget-section-title">
		<h2 class="home-widget-title"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Available Tours') ?></h2>
		<h2 class="home-widget-description"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'See our available tours') ?></h2>
	</div>
	<ul class="job_listings">
	<?php
		foreach($products as $product){
	?>
		<li itemscope="" id="job_listing-622" data-grid-columns="col-xs-12 col-sm-6 col-md-4" data-rating="0 Stars" class="col-xs-12 col-sm-6 col-md-4 style-grid post-622 job_listing type-job_listing status-publish hentry card-style--default">
			<div class="content-box">
				<?php
					if($product["lastminute"]=='1'){
				?>
					<span class="badge"><?php echo $product["lastminute_formula"]; ?></span>
					<div id="arp_ribbon_container" class="arp_ribbon_container arp_ribbon_right arp_ribbon_1 " style="">
						<div class="arp_ribbon_content arp_ribbon_right"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'LAST MINUTE') ?>
						</div>
					</div>
				<?php
					}
				?>
				<a href="<?php echo base_url(); ?>wl/<?php echo $op; ?>/product/<?php echo $product["u_sefurl"];?>" class="job_listing-clickbox"></a>
				<header style="background-image: url(<?php echo base_url() . 'image_product/' . $product["img"]; ?>)" class="job_listing-entry-header listing-cover has-image">
					<div class="job_listing-entry-header-wrapper cover-wrapper">
						<div class="job_listing-entry-thumbnail">
							<div style="background-image: url(<?php echo base_url() . 'image_product/' . $product["img"]; ?>)" class="list-cover has-image"></div>
						</div>
						<div class="job_listing-entry-meta">
							<h2 itemprop="name" class="job_listing-title">
							  <?php echo $product['u_name'];?>	
							</h2>
							<div class="job_listing-location job_listing-location-formatted" itemprop="address" itemscope="">
								<a class="google_map_link" target="_blank"><span itemprop="addressLocality"><?php echo $product['u_city'].", ".$product['u_country'];?></span></a>
								<p class="col-lg-12 nomarginpadding" style="height:20px;"><?php if( $product["u_estimdur"] > 0 ) { ?> <?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Duration'); ?>: <?php echo $product["u_estimdur"] . ' ' . $product["u_estidurt"]; } ?></p>
							</div>
						</div>
					</div>
				</header>
				<!-- .entry-header -->
				<footer class="job_listing-entry-footer" style="text-align:center;">
					<a class="btn btn-primary" href="<?php echo base_url() . 'product/' . $product["u_sefurl"]; ?>">
						<div class="tourBtn"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'BOOK NOW'); ?></div>
					</a>
				</footer>
			  <!-- .entry-footer -->
		   </div>
		</li>
		
	
	<?php
		
	}
	?>
	</ul>
</div>
<div class="row centered" >
	<div class="home-widget-section-title"><h2 class="home-widget-title"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'What to do') ?></h2><h2 class="home-widget-description"></h2></div>
	<?php
	foreach($pcateg as $cat){
	?>
		<div id="image-grid-term-downtown-core" class="col-xs-12 col-sm-4 col-md-4 image-grid-item">
			<div style="background-image:url(<?php echo base_url() . 'image_product/' . $cat["img"]; ?>);" class="col-xs-12 col-sm-12 col-md-12 entry-cover image-grid-cover has-image">
				<a href="<?php echo base_url(); ?>wl/<?php echo $op.'/listing?c=' . $cat["category"]; ?>" class="image-grid-clickbox"></a>
				<a href="<?php echo base_url(); ?>wl/<?php echo $op.'/listing?c=' . $cat["category"]; ?>" class="cover-wrapper"><?php echo $this->googletranslate->translate($_SESSION["language_code"], $cat['category']) ?></a>
			</div>
		</div>
	
	<?php
		
	}
	?> 
</div>
<div class="row centered" style="margin-top:50px;">
	<div class="home-widget-section-title">
		<h2 class="home-widget-title"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Cities that you can visit') ?></h2>
		<h2 class="home-widget-description"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'The Best Tours to be in') ?></h2>
	</div>
	<?php
	$a=array(6,7,8,12);
	$num=0;
	foreach($topdest as $td){
		$num++;
		if($num == 1){
			$rand= $a[array_rand($a)];
			if($rand == 12){
				$num=0;
			}
		}else if($num == 2){
			$rand = (12 - $rand);
			$num=0;
		}
		else{
			
		}
	?>
		<section id="image-grid-term-golf" class="col-xs-12 col-sm-6 col-md-<?php echo $rand; ?> image-grid-item">
			<div style="background-image:url(<?php echo base_url() . 'image_product/' . $td["img"]; ?>);" class="col-xs-12 col-sm-12 col-md- image-grid-cover entry-cover has-image">
			<a href="<?php echo base_url(); ?>wl/<?php echo $op.'/listing?dc=' . $td["u_city"]; ?>" class="image-grid-clickbox"></a>
				<a href="<?php echo base_url(); ?>wl/<?php echo $op.'/listing?dc=' . $td["u_city"]; ?>" class="cover-wrapper"><?php echo $td['u_city']; ?></a>
			</div>
		</section>
	<?php
	}
	?>
	
</div>

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
		right: -3px;
		top: -3px; 
		z-index: 2;
	}
	.badge {
		/*background: green;*/
		position: absolute;
		height: 40px;
		width: 70px;
		border-radius: 0;
		line-height: 35px;
		font-weight: 300;
		font-size: 14px;
		top: 16px;
		left: 0;
		display: inline-block;
		min-width: 10px;
		padding: 3px 7px;
		color: #fff;
		text-align: center;
		white-space: nowrap;
		z-index: 22;
	}
</style>
