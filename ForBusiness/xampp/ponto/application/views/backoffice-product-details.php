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
							<h3>DETAILS</h3>
							<div class="form-group">
								<label class="col-lg-2 col-sm-3 control-label">Product name</label>
								<div class="input-group col-lg-8 col-sm-6">
									<input type="text" class="form-control" data-limit="true" maxlength="180" id="u_name" name="bo.u_name" required value="<?php echo $product["u_name"]; ?>">
									<span class="char-counter" data-limit-holder="u_name"></span>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 col-sm-3 control-label">Unique code</label>
								<div class="input-group col-lg-8 col-sm-6">
									<input type="text" class="form-control" name="bo.u_uniqcode" value="<?php echo $product["u_uniqcode"]; ?>">
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 col-sm-3 control-label">Advertised price</label>
								<div class="input-group col-lg-3 col-sm-6">
									<span class="input-group-addon">€</span>
									<input type="number" step="0.01" class="form-control" name="bo.u_advprice" value="<?php echo $product["u_advprice"]; ?>">
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 col-sm-3 control-label">Quantity</label>
								<div class="input-group col-lg-3 col-sm-3" style="margin-right:10px">
									<span class="input-group-addon">Min</span>
									<input type="number" step="0.01" class="form-control" name="bo.u_qttmin" value="<?php echo $product["u_qttmin"]; ?>">
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 col-sm-3 control-label">Brief description</label>
								<div class="input-group col-lg-8 col-sm-6">
									<textarea name="bo.u_smdesc" data-limit="true" maxlength="240" class="form-control" id="u_smdesc"><?php echo $product["u_smdesc"]; ?></textarea>
									<span class="char-counter" data-limit-holder="u_smdesc"></span>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 col-sm-3 control-label">Long description</label>
								<div class="input-group col-lg-8 col-sm-6">
									<textarea name="bo.u_lngdesc" id="u_lngdesc" class="form-control mce-control"><?php echo $product["u_lngdesc"]; ?></textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 col-sm-3 control-label">Images</label>
								<div class="input-group col-lg-8 col-sm-6">
									<div id="dZUpload" class="dropzone">
										<div class="dz-default dz-message"><div class="icon"><span style="font-size: 50px;" class="s7-cloud-upload"></span></div></div>
										<div class="dz-message needsclick">
										Drop files here or click to upload.<br>
									  </div>
									</div>
								</div>
							</div>
							<small>Max filesize: 700kb</small>
							<div class="form-group">
								<label class="col-lg-2 col-sm-3 control-label">Image for Voucher</label>
								<div class="input-group col-lg-8 col-sm-6">
									<div id="dZUpload2" class="dropzone" style="width:50%;">
										<div class="dz-default dz-message">
											<div class="icon">
												<span style="font-size: 50px;" class="s7-cloud-upload"></span>
											</div>
										</div>										
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 col-sm-3 control-label"></label>
								<div class="input-group col-lg-8 col-sm-6">
									<div class="am-checkbox clearfix">
										<input name="bo.u_purcgift" id="u_purcgift" type="checkbox" <?php echo $product["u_purcgift"] ? "checked": ""; ?>>
										<label class="pull-left" for="u_purcgift">Can be purchased as a gift</label>
									</div>
									<div class="am-checkbox clearfix">
										<input name="bo.u_privtour" id="u_privtour" type="checkbox" <?php echo $product["u_privtour"] ? "checked": ""; ?>>
										<label class="pull-left" for="u_privtour">Private tour / Charter</label>
									</div>
									<div class="am-checkbox clearfix">
										<input name="bo.u_specruls" id="u_specruls" type="checkbox" <?php echo $product["u_specruls"] ? "checked": ""; ?>>
										<label class="pull-left" for="u_specruls">Use special deposit rules</label>
									</div>
									<div class="am-checkbox clearfix">
										<input name="bo.u_speccond" id="u_speccond" type="checkbox" <?php echo $product["u_speccond"] ? "checked": ""; ?>>
										<label class="pull-left" for="u_speccond">Add product-specific terms and conditions</label>
									</div> 
									<div class="am-checkbox clearfix">
										<input name="bo3.u_listtop" id="u_listtop" type="checkbox" <?php echo $product["u_listtop"] ? "checked": ""; ?>>
										<label class="pull-left" for="u_listtop">Show product in Available Tours</label>
									</div>
									<div class="am-checkbox clearfix">
										<input name="bo3.u_ewadisab" id="u_ewadisab" type="checkbox" <?php echo $product["u_ewadisab"] ? "checked": ""; ?>>
										<label class="pull-left" for="u_ewadisab">Product disabled in EWA page</label>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 col-sm-3 control-label">Terms and conditions</label>
								<div class="input-group col-lg-8 col-sm-6">
									<textarea data-limit="true" maxlength="240" name="bo.u_temscond" id="u_temscond" class="form-control"><?php echo $product["u_temscond"]; ?></textarea>
									<span class="char-counter" data-limit-holder="u_temscond"></span>
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