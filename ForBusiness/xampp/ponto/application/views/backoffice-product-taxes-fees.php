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
							<h3>TAXES/FEES</h3>
						</span>
						<table id="tax_table" class="table table-striped table-bordered" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th class="text-center">Tax</th>
									<th class="text-center">Description</th>
									<th class="text-center">Value</th>
									<th class="text-center">Formula</th>
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
								foreach( $taxes as $tax ) 
								{
									if( $tax["formula"] == '+%' || $tax["formula"] == '+v' ) {
										foreach( $ptaxes as $ptax ) 
										{ 
											if(trim($ptax["tax"]) == trim($tax["tax"])){ 
												$variable = true;
											}
										}?>									
										<tr>
											<td stamp="<?php echo $tax["u_taxstamp"]; ?>"><?php echo $tax["tax"]; ?></td>
											<td><?php echo $tax["design"]; ?></td>
											<td><?php echo number_format($tax["value"], 2, ".", ""); ?></td>
											<td><?php echo $tax["formula"]; ?></td>
											<td class="nopaddingmargin">
												<div class="am-checkbox" style="text-align: -webkit-center;">
													<input type="checkbox" id="<?php echo $tax["u_taxstamp"]; ?>" <?php echo ($variable) ? "checked": ""; ?>>
													<label for="<?php echo $tax["u_taxstamp"]; ?>"></label>							
												</div>
											</td>
										</tr>
								<?php 
										$variable = false;
									}
								}
								?>
							</tbody>
						</table>
						<div class="col-lg-12 col-sm-12">
							<div class="form-group">
								<label class="col-lg-2 col-sm-3 control-label">Legal Tax</label>
								<div class="input-group col-lg-6 col-sm-6">
									<select class="form-control" id="bo3.tabiva" name="bo3.u_tabiva">
										<?php foreach( $legal_taxes as $legal_tax ) { ?>
										<option value="<?php echo $legal_tax["codigo"]; ?>" <?php echo ($legal_tax["codigo"] == $product["u_tabiva"]) ? "selected" : ""; ?>><?php echo number_format($legal_tax["taxa"], 2, '.', ''); ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
						</div>
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