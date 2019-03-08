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
							<h3><?php echo $this->translation->Translation_key("LOCATION", $_SESSION['lang_u']); ?></h3>
							<div class="col-lg-12 col-sm-12">
								<div class="form-group">
									<label class="col-lg-2 col-sm-3 control-label"><?php echo $this->translation->Translation_key("Tourism destination", $_SESSION['lang_u']); ?></label>
									<div class="input-group col-lg-8 col-sm-6">
										<input type="text" class="form-control" id="u_tourdest" name="bo3.u_tourdest" value="<?php echo $product["u_tourdest"]; ?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-2 col-sm-3 control-label"><?php echo $this->translation->Translation_key("Address", $_SESSION['lang_u']); ?></label>
									<div class="input-group col-lg-8 col-sm-6">
										<input type="text" class="form-control" id="u_address" name="bo3.u_address" value="<?php echo $product["u_address"]; ?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-2 col-sm-3 control-label"><?php echo $this->translation->Translation_key("City", $_SESSION['lang_u']); ?></label>
									<div class="input-group col-lg-8 col-sm-6">
										<input type="text" class="form-control" id="u_city" name="bo3.u_city" value="<?php echo $product["u_city"]; ?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-2 col-sm-3 control-label"><?php echo $this->translation->Translation_key("State/County/Region", $_SESSION['lang_u']); ?></label>
									<div class="input-group col-lg-8 col-sm-6">
										<input type="text" class="form-control" id="u_statereg" name="bo3.u_statereg" value="<?php echo $product["u_statereg"]; ?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-2 col-sm-3 control-label"><?php echo $this->translation->Translation_key("Postcode/ZIP", $_SESSION['lang_u']); ?></label>
									<div class="input-group col-lg-8 col-sm-6">
										<input type="text" class="form-control" id="u_postcode" name="bo3.u_postcode" value="<?php echo $product["u_postcode"]; ?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-2 col-sm-3 control-label"><?php echo $this->translation->Translation_key("Country", $_SESSION['lang_u']); ?></label>
									<div class="input-group col-lg-8 col-sm-6">
										<select class="form-control" id="u_country" name="bo3.u_country">
											<?php foreach( $countries as $country ) { ?>
											<option value="<?php echo trim($country["printable_name"]); ?>" <?php echo trim($country["printable_name"]) == $product["u_country"] ? "selected": ""; ?>><?php echo trim($country["printable_name"]); ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<fieldset class="gllpLatlonPicker col-lg-12 col-sm-12">
									<input id="inputmap" type="text" class="gllpSearchField" hidden>
									<input id="btmap" type="button" class="gllpSearchButton" value="search" hidden>
									<div class="gllpMap" style="width:100%; height:400px;"><?php echo $this->translation->Translation_key("Google Maps", $_SESSION['lang_u']); ?></div>
									<div class="form-group">
										<label class="col-lg-2 col-sm-3 control-label"><?php echo $this->translation->Translation_key("Latitude", $_SESSION['lang_u']); ?></label>
										<div class="input-group col-lg-2 col-sm-2">
											<input type="text" class="form-control gllpLatitude" id="u_latitude" name="bo3.u_latitude" value="<?php echo $product["u_latitude"]; ?>">
										</div>
										<label class="col-lg-2 col-sm-3 control-label"><?php echo $this->translation->Translation_key("Longitude", $_SESSION['lang_u']); ?></label>
										<div class="input-group col-lg-2 col-sm-2">
											<input type="text" class="form-control gllpLongitude" id="u_longitud" name="bo3.u_longitud" value="<?php echo $product["u_longitud"]; ?>">
										</div>
									</div>
									<input type="hidden" class="gllpZoom" value="7"/>
								</fieldset>
							</div>
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