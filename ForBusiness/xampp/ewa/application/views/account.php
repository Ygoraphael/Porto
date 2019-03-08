<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>

	
		<div class="col-lg-9">
			<div data-alerts="alerts" data-titles="" data-ids="myid" data-fade="3000"></div>
			<form class="form-horizontal">
				<fieldset>
					<!-- Form Name -->
					<legend style="color:white;"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Personal Information'); ?></legend>
					<!-- Text input-->
					<div class="form-group">
						<label class="col-md-4 control-label" for="First Name"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'First Name'); ?></label>  
						<div class="col-md-6">
							<div class="input-group col-md-12">
								<input id="First Name" name="First Name" type="text" value="<?php echo $user["first_name"]; ?>" placeholder="<?php echo $this->googletranslate->translate($_SESSION["language_code"], 'First Name'); ?>" class="form-control">
							</div>
						</div>
					</div>
					<!-- Text input-->
					<div class="form-group">
						<label class="col-md-4 control-label" for="Last Name"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Last Name'); ?></label>  
						<div class="col-md-6">
							<div class="input-group col-md-12">
								<input id="Last Name" name="Last Name" type="text" value="<?php echo $user["last_name"]; ?>" placeholder="<?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Last Name'); ?>" class="form-control">
							</div>
						</div>
					</div>
					<!-- Text input-->
					<div class="form-group">
						<label class="col-md-4 control-label" for="Tax identification number"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Tax identification number'); ?></label>  
						<div class="col-md-6">
							<div class="input-group col-md-12">
								<input id="Tax identification number" name="Tax identification number" type="text" value="<?php echo $user["tax_number"]; ?>" placeholder="<?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Tax identification number'); ?>" class="form-control">
							</div>
						</div>
					</div>
					<!-- Text input-->
					<div class="form-group">
						<label class="col-md-4 control-label" for="Date Of Birth"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Date Of Birth'); ?></label>  
						<div class="col-md-6">
							<div class="input-group col-md-12">
								<input id="dob" name="Date Of Birth" type="date" value="<?php echo $user["date_birth"]; ?>" placeholder="<?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Date Of Birth'); ?>" class="form-control input-md">
							</div>
						</div>
					</div>
					<!-- Multiple Radios (inline) -->
					<div class="form-group">
						<label class="col-md-4 control-label" for="Gender"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Gender'); ?></label>
						<div class="col-md-4"> 
							<label class="radio-inline" for="Gender-0">
							<input type="radio" name="Gender" id="Gender-0" value="male" <?php if( $user["gender"] == "male" ) { echo 'checked="checked"'; } ?>>
							<?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Male'); ?>
							</label> 
							<label class="radio-inline" for="Gender-1">
							<input type="radio" name="Gender" id="Gender-1" value="female" <?php if( $user["gender"] == "female" ) { echo 'checked="checked"'; } ?>>
							<?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Female'); ?>
							</label> 
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-4 control-label" for="Street"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Invoice Address'); ?></label>  
						<div class="col-md-6">
							<input id="Street" name="Street" type="text" value="<?php echo $user["invoice_address_street"]; ?>" placeholder="<?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Street'); ?>" class="form-control input-md ">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-4 control-label col-xs-12" for=""></label>  
						<div class="col-md-3 col-xs-4">
							<input id="Aditional Info" name="Aditional Info" type="text" value="<?php echo $user["invoice_address_addinfo"]; ?>" placeholder="<?php echo $this->googletranslate->translate($_SESSION["language_code"], 'City'); ?>" class="form-control input-md ">
						</div>
						<div class="col-md-3 col-xs-4">
							<input id="Residence Number" name="Residence Number" type="text" value="<?php echo $user["invoice_address_resnumber"]; ?>" placeholder="<?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Residence Number'); ?>" class="form-control input-md ">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-4 control-label" for="Postcode"></label>  
						<div class="col-md-6">
							<input id="Postcode" name="Postcode" type="text" value="<?php echo $user["invoice_address_postcode"]; ?>" placeholder="<?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Postcode'); ?>" class="form-control input-md ">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-4 control-label" for="Country"></label>  
						<div class="col-md-6">
							<select id="Country" name="Country" class="input-medium bfh-countries form-control input-md" data-country="<?php echo $user["invoice_address_country"]; ?>"></select>
						</div>
					</div>
					<!-- Text input-->
					<div class="form-group">
						<label class="col-md-4 control-label" for="Email Address"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Phone Nº'); ?></label>  
						<div class="col-md-6">
							<div class="input-group col-md-12">
								<input id="phoneno" name="phoneno" type="text" value="<?php echo $user["phone_no"]; ?>" placeholder="<?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Phone Nº'); ?>" class="form-control input-md">
							</div>
						</div>
					</div>
					<!-- Text input-->
					<div class="form-group">
						<label class="col-md-4 control-label" for="Email Address"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Email Address'); ?></label>  
						<div class="col-md-6">
							<div class="input-group col-md-12">
								<input disabled id="Email Address" value="<?php echo $_SESSION["email"]; ?>" name="Email Address" type="text" placeholder="<?php echo $_SESSION["email"]; ?>" class="form-control input-md">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-4 control-label" ></label>  
						<div class="col-md-4">
							<a href="#" class="btn btn-success"><span class="glyphicon glyphicon-thumbs-up"></span><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Submit'); ?> </a>
							<a href="#" class="btn btn-danger" value=""><span class="glyphicon glyphicon-remove-sign"></span><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Clean'); ?> </a>
							<?php if( $this->input->get("rdr") == "c" ) { ?>
							<a href="#" onclick="window.location.href = '<?php echo base_url()?>checkout';" class="btn btn-primary" value=""><span class="glyphicon glyphicon glyphicon-menu-left"></span><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Back to checkout'); ?> </a>
							<?php } ?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-4 control-label" ></label>  
						<div class="col-md-6">
							<small><b><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'It is important that you keep your information constantly updated.'); ?></b></small>
						</div>
					</div>
				</fieldset>
			</form>
		</div>
	</div>
</div>

<script>
	jQuery(document).ready(function(){
		jQuery(document).on('click','.btn-success',function() {
			var url = "<?php echo base_url(); ?>account/updateaccount";
			//if(jQuery('#login_form').valid()){
				jQuery.ajax({
					type: "POST",
					url: url,
					data: jQuery(".form-horizontal").serialize(),
					success: function(data)
					{
						var objData = jQuery.parseJSON(data);
						if( objData.success ) {
							$(document).trigger("add-alerts", [
							{
								'message': "Data updated successfully",
								'priority': 'success'
							}
							]);
						}
						else {
						}
					}
				});
			//}
			return false;
		});
		
		jQuery(document).on('click','.btn-danger',function(){
			var url = "<?php echo base_url(); ?>account";
			window.location.replace(url);
			return false;
		});
	});
</script>