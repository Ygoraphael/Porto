<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>

	
		<div class="col-lg-9">
			<div data-alerts="alerts" data-titles="" data-ids="myid" data-fade="3000"></div>
			<form class="form-horizontal">
				<fieldset>
					<!-- Form Name -->
					<legend style="color:white;">Personal Information</legend>
					<!-- Text input-->
					<div class="form-group">
						<label class="col-md-4 control-label" for="First Name">First Name</label>  
						<div class="col-md-6">
							<div class="input-group col-md-12">
								<input id="First Name" name="First Name" type="text" value="<?php echo $user["first_name"]; ?>" placeholder="First Name" class="form-control">
							</div>
						</div>
					</div>
					<!-- Text input-->
					<div class="form-group">
						<label class="col-md-4 control-label" for="Last Name">Last Name</label>  
						<div class="col-md-6">
							<div class="input-group col-md-12">
								<input id="Last Name" name="Last Name" type="text" value="<?php echo $user["last_name"]; ?>" placeholder="Last Name" class="form-control">
							</div>
						</div>
					</div>
					<!-- Text input-->
					<div class="form-group">
						<label class="col-md-4 control-label" for="Tax identification number">Tax identification number</label>  
						<div class="col-md-6">
							<div class="input-group col-md-12">
								<input id="Tax identification number" name="Tax identification number" type="text" value="<?php echo $user["tax_number"]; ?>" placeholder="Tax identification number" class="form-control">
							</div>
						</div>
					</div>
					<!-- Text input-->
					<div class="form-group">
						<label class="col-md-4 control-label" for="Date Of Birth">Date Of Birth</label>  
						<div class="col-md-6">
							<div class="input-group col-md-12">
								<input id="dob" name="Date Of Birth" type="date" value="<?php echo $user["date_birth"]; ?>" placeholder="Date Of Birth" class="form-control input-md">
							</div>
						</div>
					</div>
					<!-- Multiple Radios (inline) -->
					<div class="form-group">
						<label class="col-md-4 control-label" for="Gender">Gender</label>
						<div class="col-md-4"> 
							<label class="radio-inline" for="Gender-0">
							<input type="radio" name="Gender" id="Gender-0" value="male" <?php if( $user["gender"] == "male" ) { echo 'checked="checked"'; } ?>>
							Male
							</label> 
							<label class="radio-inline" for="Gender-1">
							<input type="radio" name="Gender" id="Gender-1" value="female" <?php if( $user["gender"] == "female" ) { echo 'checked="checked"'; } ?>>
							Female
							</label> 
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-4 control-label" for="Street">Invoice Address</label>  
						<div class="col-md-6">
							<input id="Street" name="Street" type="text" value="<?php echo $user["invoice_address_street"]; ?>" placeholder="Street" class="form-control input-md ">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-4 control-label col-xs-12" for=""></label>  
						<div class="col-md-3 col-xs-4">
							<input id="Aditional Info" name="Aditional Info" type="text" value="<?php echo $user["invoice_address_addinfo"]; ?>" placeholder="City" class="form-control input-md ">
						</div>
						<div class="col-md-3 col-xs-4">
							<input id="Residence Number" name="Residence Number" type="text" value="<?php echo $user["invoice_address_resnumber"]; ?>" placeholder="Residence Number" class="form-control input-md ">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-4 control-label" for="Postcode"></label>  
						<div class="col-md-6">
							<input id="Postcode" name="Postcode" type="text" value="<?php echo $user["invoice_address_postcode"]; ?>" placeholder="Postcode" class="form-control input-md ">
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
						<label class="col-md-4 control-label" for="Email Address">Phone No</label>  
						<div class="col-md-6">
							<div class="input-group col-md-12">
								<input id="phoneno" name="phoneno" type="text" value="<?php echo $user["phone_no"]; ?>" placeholder="Phone No" class="form-control input-md">
							</div>
						</div>
					</div>
					<!-- Text input-->
					<div class="form-group">
						<label class="col-md-4 control-label" for="Email Address">Email Address</label>  
						<div class="col-md-6">
							<div class="input-group col-md-12">
								<input disabled id="Email Address" value="<?php echo $_SESSION["email"]; ?>" name="Email Address" type="text" placeholder="<?php echo $_SESSION["email"]; ?>" class="form-control input-md">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-4 control-label" ></label>  
						<div class="col-md-4">
							<a href="#" class="btn btn-success"><span class="glyphicon glyphicon-thumbs-up"></span> Submit</a>
							<a href="#" class="btn btn-danger" value=""><span class="glyphicon glyphicon-remove-sign"></span> Clear</a>
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