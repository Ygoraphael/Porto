<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<div class="container">
	<div class="row centered">
		<div class="home-widget-section-title"></div>
		<div class="col-lg-12" style="margin-bottom:15px;">
			<?php 
				if(count($products->result_array()) > 0){			
				?>
			<div class="btn-group" style="float:right;">
				<?php $get_string = $this->urlparameters->ArrayUrlChangeParameter($this->input->get(NULL, TRUE), 'list', 'list'); ?>
				<a onclick="window.location.href='<?php echo base_url()."listing". $get_string;  ?>'" id="list" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-th-list"></span></a>
				<?php $get_string = $this->urlparameters->ArrayUrlChangeParameter($this->input->get(NULL, TRUE), 'list', 'grid'); ?>
				<a onclick="window.location.href='<?php echo base_url()."listing". $get_string;  ?>'" id="grid" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-th"></span></a>
			</div>
			<div class="btn-group" style="float:right; margin-right:10px;">
				<div class="dropdown">
					<button class="btn btn-default dropdown-toggle" style="height: 30px;" type="button" id="menu1" data-toggle="dropdown"><?php echo $per_page; ?>
					<span class="caret"></span></button>
					<ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
						<?php $get_string = $this->urlparameters->ArrayUrlChangeParameter($this->input->get(NULL, TRUE), 'per_page', '5'); ?>
						<li role="presentation"><a role="menuitem"onclick="window.location.href='<?php echo base_url()."listing". $get_string;  ?>'">5</a></li>
						<?php $get_string = $this->urlparameters->ArrayUrlChangeParameter($this->input->get(NULL, TRUE), 'per_page', '10'); ?>
						<li role="presentation"><a role="menuitem"onclick="window.location.href='<?php echo base_url()."listing". $get_string;  ?>'">10</a></li>
						<?php $get_string = $this->urlparameters->ArrayUrlChangeParameter($this->input->get(NULL, TRUE), 'per_page', '15'); ?>
						<li role="presentation"><a role="menuitem"  onclick="window.location.href='<?php echo base_url()."listing". $get_string;  ?>'">15</a>
						<?php $get_string = $this->urlparameters->ArrayUrlChangeParameter($this->input->get(NULL, TRUE), 'per_page', 'all'); ?> 
						<li role="presentation"><a role="menuitem"  onclick="window.location.href='<?php echo base_url()."listing". $get_string;  ?>'">All</a>
					</ul>
				</div>
			</div>
			<?php } ?>
		</div>
		<div class="col-lg-3" style="margin:0; padding:0;">
			<div class="col-lg-12 nomarginpadding">
				<?php if(0) {
				?>
				<div class="panel-group listing-menu" id="accordion1">
					<div class="panel panel-default">
						<div class="panel-heading"><h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion1" href="#collapse1">Dates</a></h4></div>
						<div id="collapse1" class="panel-collapse collapse in">
							<div class="panel-body listing-menu-content">
								<table class="table">
									<tr><td><input type="text" class="form-control date-picker-from" placeholder="from"></td></tr>
									<tr><td><input type="text" class="form-control date-picker-to" placeholder="to"></td></tr>
									<tr><td><button type="button" class="btn btn-default col-lg-12" style="background:#86754d; color: white;">CHECK AVAILABILITY</button></td></tr>
								</table>
							</div>
						</div>
					</div>
				</div>
				<script>
					jQuery('.date-picker-from').datepicker({orientation: "bottom auto"});
					jQuery('.date-picker-to').datepicker({orientation: "bottom auto"});
				</script>
				<?php
				}
				?>
				<div class="panel-group listing-menu" id="accordion2">
					<div class="panel panel-default">
						<div class="panel-heading"><h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion2" href="#collapse2">Categories</a></h4></div>
						<div id="collapse2" class="panel-collapse collapse in">
							<div class="panel-body listing-menu-content">
								<table class="table">
								<?php 
									foreach ($filters["categories"] as $category) {
										$filter_checked = "";
										
										if( in_array($category, $filters["categories_filtered"]) ) {
											$filter_checked = "checked";
										}
										
										$get_string = $this->urlparameters->GetArrayToUrl($this->input->get(NULL, TRUE), 'c', $category);
								?>
									<tr><td><div class="checkbox"><label>
									<input <?php echo $filter_checked; ?> type="checkbox" onclick="window.location.href='<?php echo base_url()."listing". $get_string; ?>'" value=""><?php echo $category; ?>
									</label></div></td></tr>
								<?php
									}
								?>
								</table>
							</div>
						</div>
					</div>
				</div>
				<div class="panel-group listing-menu" id="accordion3">
					<div class="panel panel-default">
						<div class="panel-heading"><h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion3" href="#collapse3">Destinations - Country</a></h4></div>
						<div id="collapse3" class="panel-collapse collapse in">
							<div class="panel-body listing-menu-content">
								<table class="table">
								<?php 
									foreach ($filters["destinations"] as $destination) {
										$filter_checked = "";
										
										if( in_array($destination, $filters["destinations_filtered"]) ) {
											$filter_checked = "checked";
										}
										
										$get_string = $this->urlparameters->GetArrayToUrl($this->input->get(NULL, TRUE), 'd', $destination);
								?>
									<tr><td><div class="checkbox"><label>
									<input <?php echo $filter_checked; ?> type="checkbox" onclick="window.location.href='<?php echo base_url()."listing". $get_string; ?>'" value=""><?php echo $destination; ?>
									</label></div></td></tr>
								<?php
									}
								?>
								</table>
							</div>
						</div>
					</div>
				</div>
				<div class="panel-group listing-menu" id="accordion3">
					<div class="panel panel-default">
						<div class="panel-heading"><h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion3" href="#collapse3">Destinations - City</a></h4></div>
						<div id="collapse3" class="panel-collapse collapse in">
							<div class="panel-body listing-menu-content">
								<table class="table">
								<?php 
									foreach ($filters["cities"] as $city) {
										$filter_checked = "";
										
										if( in_array($city, $filters["cities_filtered"]) ) {
											$filter_checked = "checked";
										}
										
										$get_string = $this->urlparameters->GetArrayToUrl($this->input->get(NULL, TRUE), 'dc', $city);
								?>
									<tr><td><div class="checkbox"><label>
									<input <?php echo $filter_checked; ?> type="checkbox" onclick="window.location.href='<?php echo base_url()."listing". $get_string; ?>'" value=""><?php echo $city; ?>
									</label></div></td></tr>
								<?php
									}
								?>
								</table>
							</div>
						</div>
					</div>
				</div>
				<div class="panel-group listing-menu" id="accordion4">
					<div class="panel panel-default">
						<div class="panel-heading"><h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion4" href="#collapse4">Languages</a></h4></div>
						<div id="collapse4" class="panel-collapse collapse in">
							<div class="panel-body listing-menu-content">
								<table class="table">
									<?php 
										foreach ($filters["languages"] as $language) {
											$filter_checked = "";
											
											if( in_array($language, $filters["languages_filtered"]) ) {
												$filter_checked = "checked";
											}
											
											$get_string = $this->urlparameters->GetArrayToUrl($this->input->get(NULL, TRUE), 'l', $language);
									?>
										<tr><td><div class="checkbox"><label>
										<input <?php echo $filter_checked; ?> type="checkbox" onclick="window.location.href='<?php echo base_url()."listing". $get_string; ?>'" value=""><?php echo $language; ?>
										</label></div></td></tr>
									<?php
										}
									?>
								</table>
							</div>
						</div>
					</div>
				</div>
				<div class="panel-group listing-menu" id="accordion5">
					<div class="panel panel-default">
						<div class="panel-heading"><h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion5" href="#collapse5">Duration</a></h4></div>
						<div id="collapse5" class="panel-collapse collapse in">
							<div class="panel-body listing-menu-content">
								<table class="table">
								<?php 
									foreach ($filters["duration"] as $duration) {
										$filter_checked = "";
										
										if( in_array($duration, $filters["duration_filtered"]) ) {
											$filter_checked = "checked";
										}
										
										$get_string = $this->urlparameters->GetArrayToUrl($this->input->get(NULL, TRUE), 'du', $duration);
										switch($duration) {
											case '1':
												$duration = '0-3 hours';
												break;
											case '2':
												$duration = '3-5 hours';
												break;
											case '3':
												$duration = '5-7 hours';
												break;
											case '4':
												$duration = 'Full Day (+7 hours)';
												break;
											case '5':
												$duration = 'Multi-Day';
												break;
										}
								?>
									<tr><td><div class="checkbox"><label>
									<input <?php echo $filter_checked; ?> type="checkbox" onclick="window.location.href='<?php echo base_url()."listing". $get_string; ?>'" value=""><?php echo $duration; ?>
									</label></div></td></tr>
								<?php
									}
								?>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-9">
		<?php 
		if(count($products->result_array()) <= 0){
			echo "No Results Found.";
		}else{
			foreach ($products->result_array() as $row) {
		?>
		<div class="col-lg-12 product" onclick="window.location.href='<?php echo base_url()?>product/<?php echo $row["u_sefurl"]?>'">
			<div class="listing-box clearfix bordershadow" style="width:100%;">
				<div class="col-lg-12 nomarginpadding">
					<div class="pull-left job_listing-entry-thumbnail">
						<a href="<?php echo base_url()?>product/<?php echo $row["u_sefurl"]?>"><div style="background-image: url(<?php echo base_url() . 'image_product/' . $row["img"]; ?>);" class="list-cover has-image"></div></a>
					</div>
					<div class="pull-left job_listing-entry-desc text-left">
						<h1 itemprop="name" class="job_listing-title"><?php echo $row["u_name"]; ?></h1>
						<div class="job_listing-entry-location" itemprop="address" itemscope="" itemtype="http://schema.org/PostalAddress">
						<?php echo $row["u_address"]; ?>
						<?php echo $row["u_postcode"]; ?>
						<?php echo $row["u_city"]; ?>
						</div>
						<div class="job_listing-entry-phone">
							<i class="fa fa-phone" aria-hidden="true" style="margin-right:5px;"></i>
							<a href="tel:351226172715">+351 226 172 715</a>
						</div>
						<?php 
							if( $row["u_estimdur"] > 0 ) {
							?>
								<p style="color:#ffffff; margin-bottom: 0;"><i class="fa fa-clock-o" aria-hidden="true"></i> Duration: <?php echo $row["u_estimdur"] . ' ' . $row["u_estidurt"]; ?></p>
							<?php
							}
						?>
						<div class="btns_info job_listing-entry-info">
							<?php 
								if( $row["u_advprice"] > 0 ) {
								?>
									<li class="text-left" style="color:#86754d; font-size: 14px;">From <span style="color:#ffffff; font-size:20px;"><?php echo $row["u_advprice"]; ?>€</span></li>
								<?php
								}
							?>
						</div>
					</div>
				</div>
				<div class="btns_info">
					<a class="" href="<?php echo base_url() . 'product/' . $row["u_sefurl"]; ?>">
						<div class="tourBtn tourBtn1 btn-list">BOOK NOW</div>
					</a>
				</div>
			</div>
		</div>
		<?php
			//$row->title
			}
		}
		?>
		</div>
		<p><?php echo $links; ?></p>
	</div>
</div>

<script>
<?php
if(isset($_GET['list']))
{
	if($_GET['list'] == 'grid'){
	?>
		$('.product').addClass('grid-group');
		$('.tourBtn1').removeClass('btn-list');
	<?php	
	}else{
	?>
		$('.product').removeClass('grid-group');
		$('.tourBtn1').addClass('btn-list');
	<?php	
	}
}
?>
/*
$(document).ready(function() {
    $('#list').click(function(event){
		event.preventDefault();
		$('.product').removeClass('grid-group');
	});
	
    $('#grid').click(function(event){
		event.preventDefault();
		$('.product').addClass('grid-group');
	});
});*/
</script>