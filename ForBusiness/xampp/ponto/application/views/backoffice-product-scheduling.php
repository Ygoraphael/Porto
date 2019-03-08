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
				<?php echo $this->template->partial->view('backoffice-product-menu', $data = array(), $overwrite = false); ?>
			</div>
		</div>
		<div class="row setup-content" id="step-1">
			<div class="col-xs-12">
				<div class="col-md-12 well text-center">
					<form data-toggle="validator" role="form" action="#" style="border-radius: 0px;" class="form-horizontal group-border-dashed clearfix">
						<span>
							<h3>SCHEDULING</h3>
							<table id="scheduling_table" class="table table-striped table-bordered" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th>Id</th>
										<th>Alt. Price</th>
										<th>Max. Lot.</th>
										<th>Starting hour</th>
										<th>Fixed date</th>
										<th>Fixed date end</th>
										<th>Mon</th>
										<th>Tue</th>
										<th>Wed</th>
										<th>Thu</th>
										<th>Fri</th>
										<th>Sat</th>
										<th>Sun</th>
										<th></th>
										<th></th>
									</tr>
								</thead>
								<tbody>
								<?php foreach( $u_psess as $session ) {?>
									<tr>
										<td stamp="<?php echo $session["u_psessstamp"]; ?>"><?php echo $session["id"]; ?></td>
										<td><input type="checkbox" <?php echo $session["price"] ? "checked": ""; ?>></td>
										<td><input type="number" style="width:100px" step="1" class="form-control" value="<?php echo number_format($session["lotation"], 0, ".", ""); ?>"></td>
										<td><input data-inputmask="'mask': '29:59'" style="width:100px" type="text" class="form-control" value="<?php echo $session["ihour"]; ?>"></td>
										<td><input type="date" class="form-control" value="<?php echo ($session["fixday"] == "1900-01-01") ? "" : $session["fixday"]; ?>"></td>
										<td><input type="date" class="form-control" value="<?php echo ($session["fixday_end"] == "1900-01-01") ? "" : $session["fixday_end"]; ?>"></td>
										<td><input type="checkbox" <?php echo $session["mon"] ? "checked": ""; ?>></td>
										<td><input type="checkbox" <?php echo $session["tue"] ? "checked": ""; ?>></td>
										<td><input type="checkbox" <?php echo $session["wed"] ? "checked": ""; ?>></td>
										<td><input type="checkbox" <?php echo $session["thu"] ? "checked": ""; ?>></td>
										<td><input type="checkbox" <?php echo $session["fri"] ? "checked": ""; ?>></td>
										<td><input type="checkbox" <?php echo $session["sat"] ? "checked": ""; ?>></td>
										<td><input type="checkbox" <?php echo $session["sun"] ? "checked": ""; ?>></td>
										<td class="text-center"><a href="#" onclick="delete_session(jQuery(this)); return false;" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span></a></td>
										<?php if( $session["price"] ) { ?>
										<td class="text-center"><a href="<?php echo base_url()."backoffice/product_price/".$product["u_sefurl"]."/".$session["id"]; ?>" onclick="" class="btn btn-default"><span class="glyphicon glyphicon-euro"></span></a></td>
										<?php } else { ?>
										<td class="text-center"></td>
										<?php } ?>
									</tr>
								<?php } ?>
								</tbody>
							</table>
							<div class="col-lg-12 col-sm-12">
								<button type="button" id="scheduling_table_add" class="btn btn-default btn-lg pull-left">Add session</button>
								<a href="<?php echo base_url()."backoffice/product_price/".$product["u_sefurl"]."/0"; ?>" id="scheduling_table_price" class="btn btn-default btn-lg pull-left" >Product Pricing</a>
							</div>
							
							<h3>DATE EXCLUSIONS</h3>
							<table id="exclusion_table" class="table table-striped table-bordered" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th>Starting Month</th>
										<th>Starting Day</th>
										<th>Ending Month</th>
										<th>Ending Day</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
								<?php 
									$excl_id = 0; 
									$year = 2016;
									foreach( $u_pexcl as $exclusion ) {?>
									<tr>
										<td stamp="<?php echo $exclusion["u_pexclstamp"]; ?>" excl_id="<?php echo $excl_id; ?>"><input type="number" id="smonth<?php echo $excl_id; ?>" min="1" max="12" step="1" class="form-control" value="<?php echo number_format($exclusion["imonth"], 0, ".", ""); ?>"></td>
										<td><input type="number" min="1" max="<?php echo date('t', strtotime($year.'-'.$exclusion["imonth"].'-01'));?>"  step="1" id="sday<?php echo $excl_id; ?>" class="form-control" value="<?php echo number_format($exclusion["iday"], 0, ".", ""); ?>"></td>
										<td><input type="number" min="1" max="12" step="1" id="fmonth<?php echo $excl_id; ?>" class="form-control" value="<?php echo number_format($exclusion["fmonth"], 0, ".", ""); ?>"></td>
										<td><input type="number" min="1" max="<?php echo date('t', strtotime($year.'-'.$exclusion["fmonth"].'-01'));?>" step="1"id="fday<?php echo $excl_id; ?>" class="form-control" value="<?php echo number_format($exclusion["fday"], 0, ".", ""); ?>"></td>
										<td class="text-center"><a href="#" onclick="delete_exclusion(jQuery(this)); return false;" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span></a></td>
									</tr>
								<?php 
									$excl_id++; 
									} ?>
								</tbody>
							</table>
							<div class="col-lg-12 col-sm-12">
								<button type="button" id="exclusion_table_add" class="btn btn-default btn-lg pull-left">Add exclusion</button> 
							</div>
							
							<div class="col-lg-12 col-sm-12">
								<div class="form-group">
									<label class="col-lg-2 col-sm-3 control-label"></label>
									<div class="input-group col-lg-8 col-sm-6">
										<?php if( false ) { ?>
										<div class="am-checkbox clearfix">
											<input name="bo3.u_showavai" id="u_showavai" type="checkbox" <?php echo $product["u_showavai"] ? "checked": ""; ?>>
											<label class="pull-left" for="u_showavai">Show availability details to customers</label>
										</div>
										<div class="am-checkbox clearfix">
											<input name="bo3.u_waitlist" id="u_waitlist" type="checkbox" <?php echo $product["u_waitlist"] ? "checked": ""; ?>>
											<label class="pull-left" for="u_waitlist">Enable waiting list for this product</label>
										</div>
										<?php } ?>
										<div class="am-checkbox clearfix">
											<input name="bo3.u_quicksel" id="u_quicksel" type="checkbox" <?php echo $product["u_quicksel"] ? "checked": ""; ?>>
											<label class="pull-left" for="u_quicksel">Quick-sell product</label>
										</div>
										<small class="pull-left">No day selection (current day selected), no session selection, no stock calculation and main product's pricing used</small>
									</div>
								</div>
								<?php if( false ) { ?>
								<div class="form-group">
									<label class="col-lg-2 col-sm-3 control-label">Availability</label>
									<div class="input-group col-lg-6 col-sm-6">
										<select class="form-control" id="u_availaby" name="bo3.u_availaby">
											<option value="" <?php echo trim($product["u_availaby"]) == "" ? "selected": ""; ?>></option>
											<option value="Fixed limit per session" <?php echo trim($product["u_availaby"]) == "Fixed limit per session" ? "selected": ""; ?>>Fixed limit per session</option>
											<option value="Limited by resources" <?php echo trim($product["u_availaby"]) == "Limited by resources" ? "selected": ""; ?>>Limited by resources</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-2 col-sm-3 control-label">Confirm bookings</label>
									<div class="input-group col-lg-6 col-sm-6">
										<select class="form-control" id="u_confbook" name="bo3.u_confbook">
											<option value="" <?php echo trim($product["u_confbook"]) == "" ? "selected": ""; ?>></option>
											<option value="Automatically" <?php echo trim($product["u_confbook"]) == "Automatically" ? "selected": ""; ?>>Automatically</option>
											<option value="Manually" <?php echo trim($product["u_confbook"]) == "Manually" ? "selected": ""; ?>>Manually</option>
											<option value="Start manual then automatic" <?php echo trim($product["u_confbook"]) == "Start manual then automatic" ? "selected": ""; ?>>Start manual then automatic</option>
											<option value="Start automatic then manual" <?php echo trim($product["u_confbook"]) == "Start automatic then manual" ? "selected": ""; ?>>Start automatic then manual</option>
										</select>
									</div>
								</div>
								<?php } ?>
								<div class="form-group">
									<label class="col-lg-2 col-sm-3 control-label">Minimum notice</label>
									<div class="input-group col-lg-2 col-sm-2">
										<input type="number" step="0.01" class="form-control" id="u_minnotic" name="bo3.u_minnotic" value="<?php echo $product["u_minnotic"]; ?>">
									</div>
									<div class="input-group col-lg-4 col-sm-3">
										<select class="form-control" id="u_minnott" name="bo3.u_minnott">
											<option value="" <?php echo trim($product["u_minnott"]) == "" ? "selected": ""; ?>></option>
											<option value="Hours" <?php echo trim($product["u_minnott"]) == "Hours" ? "selected": ""; ?>>Hours</option>
											<option value="Minutes" <?php echo trim($product["u_minnott"]) == "Minutes" ? "selected": ""; ?>>Minutes</option>
											<option value="Days" <?php echo trim($product["u_minnott"]) == "Days" ? "selected": ""; ?>>Days</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-2 col-sm-3 control-label">Estimated duration</label>
									<div class="input-group col-lg-2 col-sm-2">
										<input type="number" step="0.01" class="form-control" id="u_estimdur" name="bo3.u_estimdur" value="<?php echo $product["u_estimdur"]; ?>">
									</div>
									<div class="input-group col-lg-4 col-sm-3">
										<select class="form-control" id="u_estidurt" name="bo3.u_estidurt">
											<option value="" <?php echo trim($product["u_estidurt"]) == "" ? "selected": ""; ?>></option>
											<option value="Hours" <?php echo trim($product["u_estidurt"]) == "Hours" ? "selected": ""; ?>>Hours</option>
											<option value="Minutes" <?php echo trim($product["u_estidurt"]) == "Minutes" ? "selected": ""; ?>>Minutes</option>
											<option value="Days" <?php echo trim($product["u_estidurt"]) == "Days" ? "selected": ""; ?>>Days</option>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-2 col-sm-3 control-label">Product color</label>
									<div id="cp2" class="input-group col-lg-8 col-sm-6 colorpicker-component">
										<input type="text" class="form-control" id="u_color" name="bo3.u_color" value="<?php echo $product["u_color"]; ?>">
										<span class="input-group-addon"><i></i></span>
									</div>
								</div>
							</div>
						</span>
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