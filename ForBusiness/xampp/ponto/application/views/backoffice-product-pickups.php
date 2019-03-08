<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<div class="page-head col-md-12">
	<div class="col-md-12 col-sm-12">
		<h2 class="col-md-6 col-sm-6"><?php echo $title; ?></h2>
		<button type="button" class="btn btn-info pull-right">Clone product</button>
		<button type="button" class="btn btn-info pull-right" style="margin-right:15px;">Disable product</button>
		<a target="_blank" href="<?php echo base_url()."product/".$product["u_sefurl"]; ?>" class="btn btn-info pull-right" style="margin-right:15px;">View online</a>
		<a target="_blank" href="<?php echo base_url()."wl/".$_SESSION["backoffice_user_id"]."/product/".$product["u_sefurl"]; ?>" class="btn btn-info pull-right" style="margin-right:15px;">View online WL</a>
	</div>
</div>
<div class="main-content col-sm-12">
	<div class="col-lg-12">
		<div class="row form-group">
			<div class="col-xs-12">
				<?php echo $this->template->partial->view('backoffice-product-menu'); ?>
			</div>
		</div>
		<div class="row setup-content" id="step-1">
			<div class="col-xs-12">
				<div class="col-md-12 well text-center">
					<form data-toggle="validator" role="form" action="#" style="border-radius: 0px;" class="form-horizontal group-border-dashed clearfix">
						<span>
							<h3>PICKUPS</h3>
						</span>
						<table id="pickups_table" class="table table-striped table-bordered" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>Name</th>
									<th>Address</th>
									<th>Postcode</th>
									<th>City</th>
									<th>Country</th>
									<th>
										<div class="am-checkbox" style="text-align: -webkit-center;">
											<input type="checkbox" id="select_all">
											<label for="select_all"></label>							
										</div>
									</th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$variable = false;	
								foreach( $pickups as $pickup ) 
								{
									foreach( $ppickups as $ppickup ) 
									{ 
										if(trim($ppickup["name"]) == trim($pickup["name"])){ 
											$variable = true;
										}
									}?>									
									<tr>
										<td stamp="<?php echo $pickup["u_pickupstamp"]; ?>"><?php echo $pickup["name"]; ?></td>
										<td><?php echo $pickup["address"]; ?></td>
										<td><?php echo $pickup["postcode"]; ?></td>
										<td><?php echo $pickup["city"]; ?></td>
										<td><?php echo $pickup["country"]; ?></td>
										<td class="nopaddingmargin">
											<div class="am-checkbox" style="text-align: -webkit-center;">
												<input type="checkbox" id="<?php echo $pickup["u_pickupstamp"]; ?>" <?php echo ($variable) ? "checked": ""; ?>>
												<label for="<?php echo $pickup["u_pickupstamp"]; ?>"></label>							
											</div>
										</td>
									</tr>
								<?php 
									$variable = false;										
								}?>

							</tbody>
						</table>
					</form>
					<p style="margin-bottom:50px"></p>
					<div class="clearfix" data-alerts="alerts" data-fade="3000"></div>
					<a href="<?php echo base_url() . "backoffice/product/".$product["u_sefurl"]."/".$back; ?>" class="btn btn-primary btn-lg pull-left"><span class="glyphicon glyphicon-chevron-left"></span> BACK</a>
					<button data-step-control="save"  class="btn btn-info btn-lg pull-left">SAVE PRODUCT</button>
					<button data-step-control="cancel"  class="btn btn-default btn-lg pull-left">CANCEL</button>
					<a href="<?php echo base_url() . "backoffice/product/".$product["u_sefurl"]."/".$next; ?>"  class="btn btn-primary btn-lg pull-right">NEXT <span class="glyphicon glyphicon-chevron-right"></span></a>
				</div>
			</div>
		</div>
	</div>
	<?php echo $this->template->partial->view('backoffice-product-script', $data = array(), $overwrite = true); ?>
</div>