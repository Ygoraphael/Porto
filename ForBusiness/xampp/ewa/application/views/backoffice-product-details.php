<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<?php echo $this->template->partial->view('backoffice-product-top-bar', $data = array(), $overwrite = false); ?>
<div class="main-content col-sm-12">
	<div class="col-lg-12">
		<div class="row form-group">
			<div class="col-xs-12">
				<?php echo $this->template->partial->view('backoffice-product-menu', $data = array(), $overwrite = true); ?>
			</div>
		</div>
		<div class="row setup-content" id="step-1">
			<div class="col-xs-12">
				<div class="col-md-12 well text-center">
					<form data-toggle="validator" role="form" action="#" style="border-radius: 0px;" class="form-horizontal group-border-dashed clearfix">
						<span>
							<h3><?php echo $this->translation->Translation_key("DETAILS", $_SESSION['lang_u']); ?></h3>
							<div class="form-group">							
								<label class="col-lg-2 col-sm-3 control-label"><?php echo $this->translation->Translation_key("Product name", $_SESSION['lang_u']); ?></label>
								<div class="input-group col-lg-8 col-sm-6">
									<input type="text" class="form-control" data-limit="true" maxlength="180" id="u_name" name="bo.u_name" required value="<?php echo $product["u_name"]; ?>">
									<span class="char-counter" data-limit-holder="u_name"></span>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 col-sm-3 control-label"><?php echo $this->translation->Translation_key("Unique code", $_SESSION['lang_u']); ?></label>
								<div class="input-group col-lg-5 col-sm-6">
									<input type="text" class="form-control" name="bo.u_uniqcode" value="<?php echo $product["u_uniqcode"]; ?>">
								</div>
								<div class="input-group col-lg-4 col-sm-6">
									<div class="am-checkbox clearfix">
										<input  name="bo.logi8" id="logi8" type="checkbox" <?php echo $product["logi8"] ? "checked": ""; ?>>
										<label class="" for="logi8"><?php echo $this->translation->Translation_key("Disabled", $_SESSION['lang_u']); ?></label>
									</div>
								</div>
							
							</div>
							<div class="form-group">
								<label class="col-lg-2 col-sm-3 control-label"><?php echo $this->translation->Translation_key("Advertised price", $_SESSION['lang_u']); ?></label>
								<div class="input-group col-lg-3 col-sm-6">
									<span class="input-group-addon">&euro;</span>
									<input type="number" step="0.01" class="form-control" name="bo.u_advprice" value="<?php echo $product["u_advprice"]; ?>">
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 col-sm-3 control-label"><?php echo $this->translation->Translation_key("Quantity", $_SESSION['lang_u']); ?></label>
								<div class="input-group col-lg-3 col-sm-3" style="margin-right:10px">
									<span class="input-group-addon"><?php echo $this->translation->Translation_key("Min", $_SESSION['lang_u']); ?></span>
									<input type="number" step="0.01" class="form-control" name="bo.u_qttmin" value="<?php echo $product["u_qttmin"]; ?>">
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 col-sm-3 control-label"><?php echo $this->translation->Translation_key("Brief description", $_SESSION['lang_u']); ?></label>
								<div class="input-group col-lg-8 col-sm-6">
									<textarea name="bo.u_smdesc" data-limit="true" maxlength="240" class="form-control" id="u_smdesc"><?php echo $product["u_smdesc"]; ?></textarea>
									<span class="char-counter" data-limit-holder="u_smdesc"></span>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 col-sm-3 control-label"><?php echo $this->translation->Translation_key("Long description", $_SESSION['lang_u']); ?></label>
								<div class="input-group col-lg-8 col-sm-6">
									<textarea name="bo.u_lngdesc" id="u_lngdesc" class="form-control mce-control"><?php echo $product["u_lngdesc"]; ?></textarea>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 col-sm-3 control-label"><?php echo $this->translation->Translation_key("Images", $_SESSION['lang_u']); ?></label>
								<div class="input-group col-lg-8 col-sm-6">
									<div id="dZUpload" class="dropzone">
										<div class="dz-default dz-message"><div class="icon"><span style="font-size: 50px;" class="s7-cloud-upload"></span></div></div>
										<div class="dz-message needsclick">
										<?php echo $this->translation->Translation_key("Drop files here or click to upload", $_SESSION['lang_u']); ?>.<br>
									  </div>
									</div>
								</div>
							</div>
							<small>Max filesize: 700kb</small>
							<div class="form-group">
								<label class="col-lg-2 col-sm-3 control-label"><?php echo $this->translation->Translation_key("Image for Voucher", $_SESSION['lang_u']); ?></label>
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
								<label class="col-lg-2 col-sm-3 control-label"><?php echo $this->translation->Translation_key("Meta Tags", $_SESSION['lang_u']); ?></label>
								<div class="input-group col-lg-8 col-sm-6">
									<textarea name="bo3.u_metatags" data-limit="true" maxlength="150" class="form-control" id="u_metatags"><?php echo $product["u_metatags"]; ?></textarea>
									<span class="char-counter" data-limit-holder="u_smdesc"></span>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 col-sm-3 control-label"><?php echo $this->translation->Translation_key("Day Sales Limit", $_SESSION['lang_u']); ?></label>
								<div class="input-group col-lg-2 col-sm-3">
									<input type="date" name="bo3.u_dtlim" class="form-control"  min=<?php $hoy=date("Y-m-d"); echo $hoy;?>  value="<?php echo strlen($day_sl == '1990-01-01' ? '' : substr($product["u_dtlim"], 0, 10)); ?>">
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 col-sm-3 control-label"></label>
								<div class="input-group col-lg-8 col-sm-6">
									<div class="am-checkbox clearfix">
										<input name="bo.u_purcgift" id="u_purcgift" type="checkbox" <?php echo $product["u_purcgift"] ? "checked": ""; ?>>
										<label class="pull-left" for="u_purcgift"><?php echo $this->translation->Translation_key("Can be purchased as a gift", $_SESSION['lang_u']); ?></label>
									</div>
									<div class="am-checkbox clearfix">
										<input name="bo.u_privtour" id="u_privtour" type="checkbox" <?php echo $product["u_privtour"] ? "checked": ""; ?>>
										<label class="pull-left" for="u_privtour"><?php echo $this->translation->Translation_key("Private tour / Charter", $_SESSION['lang_u']); ?></label>
									</div>
									<div class="am-checkbox clearfix">
										<input name="bo.u_specruls" id="u_specruls" type="checkbox" <?php echo $product["u_specruls"] ? "checked": ""; ?>>
										<label class="pull-left" for="u_specruls"><?php echo $this->translation->Translation_key("Use special deposit rules", $_SESSION['lang_u']); ?></label>
									</div>
									<div class="am-checkbox clearfix">
										<input name="bo.u_speccond" id="u_speccond" type="checkbox" <?php echo $product["u_speccond"] ? "checked": ""; ?>>
										<label class="pull-left" for="u_speccond"><?php echo $this->translation->Translation_key("Add product-specific terms and conditions", $_SESSION['lang_u']); ?></label>
									</div> 
									<div class="am-checkbox clearfix">
										<input name="bo3.u_listtop" id="u_listtop" type="checkbox" <?php echo $product["u_listtop"] ? "checked": ""; ?>>
										<label class="pull-left" for="u_listtop"><?php echo $this->translation->Translation_key("Show product in Available Tours", $_SESSION['lang_u']); ?></label>
									</div>
									<div class="am-checkbox clearfix">
										<input name="bo3.u_ewadisab" id="u_ewadisab" type="checkbox" <?php echo $product["u_ewadisab"] ? "checked": ""; ?>>
										<label class="pull-left" for="u_ewadisab"><?php echo $this->translation->Translation_key("Product disabled in EWA page", $_SESSION['lang_u']); ?></label>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 col-sm-3 control-label"><?php echo $this->translation->Translation_key("Terms and conditions", $_SESSION['lang_u']); ?></label>
								<div class="input-group col-lg-8 col-sm-6">
									<textarea data-limit="true" maxlength="240" name="bo.u_temscond" id="u_temscond" class="form-control"><?php echo $product["u_temscond"]; ?></textarea>
									<span class="char-counter" data-limit-holder="u_temscond"></span>
								</div>
							</div>
							<small>To show PDF file in Terms and conditions, use: <?php echo htmlspecialchars('<a href="http://example.com/test.pdf">PDF</a>'); ?></small>
						</span>
					</form> 
					<p style="margin-bottom:50px"></p>
					<div class="clearfix" data-alerts="alerts" data-fade="3000"></div>
					<a href="<?php echo base_url() . "backoffice/product/".$product["u_sefurl"]."/".$back; ?>" class="btn btn-primary btn-lg pull-left"><span class="glyphicon glyphicon-chevron-left"></span><?php echo $this->translation->Translation_key("BACK", $_SESSION['lang_u']); ?> </a>
					<button data-step-control="save"  class="btn btn-info btn-lg pull-left"><?php echo $this->translation->Translation_key("SAVE PRODUCT", $_SESSION['lang_u']); ?></button>
					<button data-step-control="cancel"  class="btn btn-default btn-lg pull-left"><?php echo $this->translation->Translation_key("CANCEL", $_SESSION['lang_u']); ?></button>
					<a href="<?php echo base_url() . "backoffice/product/".$product["u_sefurl"]."/".$next; ?>"  class="btn btn-primary btn-lg pull-right"><?php echo $this->translation->Translation_key("NEXT", $_SESSION['lang_u']); ?> <span class="glyphicon glyphicon-chevron-right"></span></a>
				</div>
			</div>
		</div>
	</div>
	<?php echo $this->template->partial->view('backoffice-product-script', $data = array(), $overwrite = true); ?>
</div>