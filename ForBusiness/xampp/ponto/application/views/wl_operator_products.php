<div style="background:<?php echo $bg_content_color; ?>;">
<?php
	if( $filtersactive == 1 ) {
?>
<div class="col-lg-3" style="margin:0; padding:0;">
	<div class="col-lg-12 nomarginpadding">
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
							<input <?php echo $filter_checked; ?> type="checkbox" onclick="window.location.href='<?php echo base_url() . 'wl/' . $op . $get_string; ?>'" value=""></label><?php echo $category; ?>
							</div></td></tr>
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
							<input <?php echo $filter_checked; ?> type="checkbox" onclick="window.location.href='<?php echo base_url() . 'wl/' . $op . $get_string; ?>'" value=""></label><?php echo $destination; ?>
							</div></td></tr>
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
							<input <?php echo $filter_checked; ?> type="checkbox" onclick="window.location.href='<?php echo base_url() . 'wl/' . $op . $get_string; ?>'" value=""></label><?php echo $city; ?>
							</div></td></tr>
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
								<input <?php echo $filter_checked; ?> type="checkbox" onclick="window.location.href='<?php echo base_url() . 'wl/' . $op . $get_string; ?>'" value=""></label><?php echo $language; ?>
								</div></td></tr>
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
							<input <?php echo $filter_checked; ?> type="checkbox" onclick="window.location.href='<?php echo base_url() . 'wl/' . $op . $get_string; ?>'" value=""></label><?php echo $duration; ?>
							</div></td></tr>
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
<?php
	}
?>

<?php
	if( $listgridbut == 1 ) {
	if( $filtersactive == 1 ) {
?>
<div class="col-lg-9">
<?php
	}
	else {
?>
<div class="col-lg-12">
<?php
	} 
?>
	<div class="btn-group clearfix" style='margin-bottom:15px;'>
		<?php $get_string = $this->urlparameters->ArrayUrlChangeParameter($this->input->get(NULL, TRUE), 'list', 'list'); ?>
		<a onclick="window.location.href='<?php echo base_url()."wl/".$op."/listing". $get_string;  ?>'" id="" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-th-list"></span>List</a>
		<?php $get_string = $this->urlparameters->ArrayUrlChangeParameter($this->input->get(NULL, TRUE), 'list', 'grid'); ?>
		<a onclick="window.location.href='<?php echo base_url()."wl/".$op."/listing". $get_string;  ?>'" id="" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-th"></span>Grid</a>
	</div>
	<div class="btn-group" style="margin-left:10px; margin-bottom:15px;">
				<div class="dropdown">
					<button class="btn btn-default dropdown-toggle" style="height: 30px;" type="button" id="menu1" data-toggle="dropdown"><?php echo $per_page; ?>
					<span class="caret"></span></button>
					<ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
						<?php $get_string = $this->urlparameters->ArrayUrlChangeParameter($this->input->get(NULL, TRUE), 'per_page', '5'); ?>
						<li role="presentation"><a role="menuitem"onclick="window.location.href='<?php echo base_url()."wl/".$op."/listing". $get_string;  ?>'">5</a></li>
						<?php $get_string = $this->urlparameters->ArrayUrlChangeParameter($this->input->get(NULL, TRUE), 'per_page', '10'); ?>
						<li role="presentation"><a role="menuitem"onclick="window.location.href='<?php echo base_url()."wl/".$op."/listing". $get_string;  ?>'">10</a></li>
						<?php $get_string = $this->urlparameters->ArrayUrlChangeParameter($this->input->get(NULL, TRUE), 'per_page', '15'); ?>
						<li role="presentation"><a role="menuitem"  onclick="window.location.href='<?php echo base_url()."wl/".$op."/listing". $get_string;  ?>'">15</a>
						<?php $get_string = $this->urlparameters->ArrayUrlChangeParameter($this->input->get(NULL, TRUE), 'per_page', 'All'); ?> 
						<li role="presentation"><a role="menuitem"  onclick="window.location.href='<?php echo base_url()."wl/".$op."/listing". $get_string;  ?>'">All</a>
					</ul>
				</div>
			</div>
</div>
<?php
	}
	if( $filtersactive == 1 ) {
?>
<div id="products" class="col-lg-9 nomarginpadding">
<?php
	}
	else {
?>
<div id="products" class="col-lg-12 nomarginpadding">
<?php
	}

	
	
	if(sizeof($products_ar) <= 0){
		echo '<div class="col-sm-6 col-md-4 col-lg-3 mt-4 boxhover">No Results Found.</div>';
	}
	foreach ($products_ar as $row) { ?>
	<?php if( $booknowproducts == 1 ) { ?>
	<div class="col-sm-6 col-md-4 col-lg-3 mt-4 boxhover">
		<?php
		if($row["lastminute"]=='1'){
		?>
			<span class="badge"><?php echo $row["lastminute_formula"]; ?></span>
			<div id="arp_ribbon_container" class="arp_ribbon_container arp_ribbon_right arp_ribbon_1 " style="">
				<div class="arp_ribbon_content arp_ribbon_right">LAST MINUTE</div>
			</div>
		<?php
		}
		?>
		<div class="box-wrapper">
			
				<img class="group list-group-image" style="background:url('<?php echo base_url() . 'image_product/' . $row["img"]; ?>');background-size: cover;background-position: center;background-repeat: no-repeat; width:267px; height:200px;" alt="">
			<div class="box-content">
				<div class="title"><?php echo $row["u_name"]; ?></div> 
				<div class="desc"><?php if( $row["u_estimdur"] > 0 ) { ?> Duration: <?php echo $row["u_estimdur"] . ' ' . $row["u_estidurt"]; } ?></div>
				<span class="price"><?php echo $row["u_advprice"]; ?>€</span>
				<div class="footer">
					<a href="<?php echo base_url(); ?>wl/<?php echo $op; ?>/product/<?php echo $row["u_sefurl"];?>"class="btn fifth">BOOK NOW</a>
				</div>
			</div>
		</div>
	</div>
	<?php } 
		else {
	?>
	<div class="item  col-xs-4 col-lg-4">
	<?php
				if($row["lastminute"]=='1'){
				?>
					<span class="badge badge2"><?php echo $row["lastminute_formula"]; ?></span>
					<div id="arp_ribbon_container" class="arp_ribbon_container arp_ribbon_right arp_ribbon_1 " >
						<div class="arp_ribbon_content arp_ribbon_right">LAST MINUTE</div>
					</div>
				<?php
				}
				?> 
		<a href="<?php echo base_url(); ?>wl/<?php echo $op; ?>/product/<?php echo $row["u_sefurl"];?>"  style="text-decoration:none; color:black;">
            <div class="thumbnail">
                <img  class="group list-group-image" style="background:url('<?php echo base_url() . 'image_product/' . $row["img"]; ?>');background-size: cover;background-position: center;background-repeat: no-repeat; width:400px; height:180px;"alt="" />
                <div class="caption" >
                    <h4 class="group inner list-group-item-heading">
                       <?php echo $row["u_name"]; ?>
					</h4>
                    <p class="group inner list-group-item-text">
                        <?php if( $row["u_estimdur"] > 0 ) { ?> Duration: <?php echo $row["u_estimdur"] . ' ' . $row["u_estidurt"]; } ?><br/>	
						<?php echo $row["u_address"]; ?><br/>
						<?php echo $row["u_postcode"]; ?>
						<?php echo $row["u_city"]; ?>
					</p>
                    <div class="row">
                        <div class="col-xs-12 col-md-12 capbook">
                            <p class="lead">
								<?php if( $row["u_advprice"] > 0 ) { ?>
								From <?php echo $row["u_advprice"]; ?> €
								<?php } ?>
							</p>
                        </div>
                        <div class="col-xs-12 col-md-12 btnbook" style="">
                            <a class="btn btn-success" href="<?php echo base_url(); ?>wl/<?php echo $op; ?>/product/<?php echo $row["u_sefurl"];?>">BOOK NOW</a>
                        </div>
                    </div>
                </div>
            </div>
		</a>
	</div>
	<?php } ?>
<?php } ?>

</div>
<div style="text-align:center; width:100%;">
	<p><?php echo $links; ?></p>
</div>
</div>
<style>
 input[type=checkbox]{
	padding:0 !important;
	min-height: 22px;
}
.checkbox > label {  
	margin-right: 10px;
}
</style>
<script>
<?php
if(isset($_GET['list']))
{
	if($_GET['list'] == 'grid'){
	?>
		$('#products .item').removeClass('list-group-item');
		$('#products .item').addClass('grid-group-item');
		
		$('#products .boxhover').removeClass('list-group-boxhover');
		$('#products .boxhover').addClass('grid-group-boxhover');
		
		//$('.caption').removeClass('col-lg-6');	
	<?php	
		
	}else{
	?>
		$('#products .item').addClass('list-group-item');;
		
		$('#products .boxhover').addClass('list-group-boxhover');

	<?php	
	}
}
?>


</script>


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
		right: 15px;
		top: 0px;
		z-index: 2;
	}
	.badge {
		position: absolute;
		height: 40px;
		width: 70px;
		border-radius: 0;
		line-height: 33px !important;
		font-weight: 300;
		font-size: 14px;
		top: 10px;
		left: 15px;
		display: inline-block;
		min-width: 10px;
		padding: 3px 7px;
		color: #fff !important;
		text-align: center;
		white-space: nowrap;
		z-index: 22;
	}
	.badge1{
		bottom: 11px;
		right: 15px;
		top: auto;
		left: auto;
	}
</style>