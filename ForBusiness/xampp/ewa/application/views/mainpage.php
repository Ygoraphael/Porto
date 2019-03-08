 <?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<div class="container">
	<div class="row centered">
		<div class="home-widget-section-title"><h2 class="home-widget-title"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Top attractions around World'); ?></h2><h2 class="home-widget-description"></h2></div>
		<?php
		foreach($products as $product){

		?>
			<div class="col-lg-4" style="margin-bottom:40px;">
				<div class="main-box" style="width:100%;">
					<header style="background-image: url(<?php echo base_url() . 'image_product/' . $product["img"]; ?>); background-position: center; opacity: 0.92; background-size: cover;" class="main-box-header">
						<div style="background: rgba(97, 91, 38, 0.31); width: 100%; height: 100%; position: absolute; margin-top: -10px;">
						</div>
						<div class="job_listing-entry-header-wrapper cover-wrapper" style="width:80%; margin-left:auto; margin-right:auto;position: inherit;">
							<div class="job_listing-entry-meta clearfix text-left">
								<h1 itemprop="name" class="job_listing-title"><?php echo $product['u_name'];?></h1>
								<div class="job_listing-location" itemprop="address" itemscope="" itemtype="http://schema.org/PostalAddress"><?php echo $product['morada'];?>, <?php echo $product['codpost'];?> <?php echo $product['local'];?></div>
								<div class="job_listing-phone clearfix">
									<span itemprop="telephone"><a href="tel:351226172715"><?php echo $product['telefone'];?></a></span>
								</div>
							</div>
						</div>
					</header>
					<footer class="job_listing-entry-footer">
						<div class="btns_info">
							<li class="confidenceaward text-left" style="border-bottom: 3px solid #86754d;">
								<a href="http://europeanworld.eu/confidence-award-by-ewa-europeanworld/">
									<span style="color:#ffffff; line-height: 28px;"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'CONFIDENCE AWARD'); ?></span>
								</a>
							</li>
							<li class="bestPrice text-left">
								<a href="http://www.booking.com/general.en-gb.html?aid=901633;sid=9726c5cfb7a2636f1ef357eb2b329b0f;dcid=12;tmpl=doc/rate_guarantee" target="_blank"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'BEST PRICE GUARANTEED'); ?></a>
							</li>
							<li class="luxurymember text-left">
								<?php $to = "info@soft4booking.com";
									  $subject ="Contact Supplier";
									  $body = "Product: ".$product['nome']." / Nº: ".$product['no'];
									  $body2 = "Operador: ".$_SESSION['backoffice_user_id']." / Nº ".$_SESSION['user_id'];
									  $body3 = "Agent: ".$_SESSION['email']." / Type of Agent: ".$_SESSION['type'];
									if( $_SESSION['type'] == 'Agent'){
										log_message("ERROR",print_r($_SESSION,TRUE));
								  ?>
											<a href="mailto:<?php echo $to; ?>?subject=<?php echo $subject; ?>&body=<?php echo $body;?>%0A<?php echo $body2;?>%0A<?php echo $body3;?> ">
												<span style="color:#ffffff;"><?php  echo $this->googletranslate->translate($_SESSION["language_code"], 'CONTACT SUPLLIER'); ?></span>
											</a>
									<?php }
										else{?>
											<a href="mailto:<?php echo $to; ?>?subject=<?php echo $subject; ?> ">
												<span style="color:#ffffff;"><?php  echo $this->googletranslate->translate($_SESSION["language_code"], 'CONTACT SUPLLIER'); ?></span>
											</a>
									<?php } ?>
							</li>
							<div id="tourBtns">
								<a class="" href="<?php echo base_url() . 'product/' . $product["u_sefurl"]; ?>">
									<div class="tourBtn"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'BOOK NOW'); ?></div>
								</a>
							</div>
						</div>
					</footer>
				</div>
			</div>
		
		<?php
			
		}
		?>
	</div>
	<div class="row centered" style="margin-top:50px;">
		<div class="home-widget-section-title"><h2 class="home-widget-title"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'What to do?'); ?></h2><h2 class="home-widget-description"></h2></div>
		<?php
		foreach($pcateg as $cat){
		?>
			<section id="image-grid-term-golf" class="col-xs-12 col-sm-6 col-md-4 image-grid-item">
                <div style="background-repeat: no-repeat; background-size: cover; background-position: center; background-image:url(<?php echo base_url() . 'image_product/' . $cat["img"]; ?>);" class="col-xs-12 col-sm-12 col-md- image-grid-cover entry-cover has-image">
                <!--<div class="col-xs-12 col-sm-6 col-md- image-grid-cover entry-cover has-image">-->
                    <a href="<?php echo base_url() . 'listing?c=' . $cat["category"]; ?>" class="image-grid-clickbox"></a>
                    <a href="<?php echo base_url() . 'listing?c=' . $cat["category"]; ?>" class="cover-wrapper" style="text-shadow: 2px 2px 1px #000000;"><?php echo $this->googletranslate->translate($_SESSION["language_code"], $cat['category']); ?></a>
                </div>
            </section>
		
		<?php
			
		}
		?>
		
	</div>
	
		<div class="row centered" style="margin-top:50px;">
		<div class="home-widget-section-title"><h2 class="home-widget-title"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Top Destinations'); ?></h2><h2 class="home-widget-description"></h2></div>
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
			}else{
				
			}

		?>
			<section id="image-grid-term-golf" class="col-xs-12 col-sm-6 col-md-<?php echo $rand; ?> image-grid-item">
                <!--<div style="background-image: url(http://i2.wp.com/europeanworld.eu/wp-content/uploads/2015/12/012-Pine-Cliffs-hole-9.jpg?fit=750%2C310);" class="col-xs-12 col-sm-6 col-md- image-grid-cover entry-cover has-image">
                <div class="col-xs-12 col-sm-6 col-md- image-grid-cover entry-cover has-image">-->
				<div style="background-repeat: no-repeat; background-size: cover; background-position: center; background-image:url(<?php echo base_url() . 'image_product/' . $td["img"]; ?>);" class="col-xs-12 col-sm-12 col-md- image-grid-cover entry-cover has-image">
                    <a href="<?php echo base_url() . 'listing?dc=' . $td["u_city"]; ?>" class="image-grid-clickbox"></a>
                    <a href="<?php echo base_url() . 'listing?dc=' . $td["u_city"]; ?>" class="cover-wrapper" style="text-shadow: 2px 2px 1px #000000;"><?php echo $td['u_city']; ?></a>
                </div>
            </section>
		
		<?php
		}
		?>
		
	</div>
	
</div>