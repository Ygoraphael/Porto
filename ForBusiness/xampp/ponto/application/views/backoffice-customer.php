<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<div class="clearfix page-head col-md-12">
	<div class="col-md-12 col-sm-12">
		<h2 class="col-md-6 col-sm-6"><?php echo $title; ?></h2>
		<button  onclick="history.go(-1);" class="btn btn-primary btn-lg pull-right"><span class="glyphicon glyphicon-chevron-left"></span> BACK</button>
	</div>
	

</div>
<div class="col-md-12 col-sm-12 clearfix" data-alerts="alerts" data-fade="3000"></div>
<div class="main-content col-sm-12">
		<form class="form-horizontal">
			<fieldset>
				<!-- Form Name -->
				<legend >Personal Information</legend>
				<!-- Text input-->
				<div class="form-group">
					<label class="col-md-4 control-label" for="First Name">First Name</label>  
					<div class="col-md-6">
						<div class="input-group col-md-12">
							<input disabled id="First Name" name="First Name" type="text" value="<?php echo $customer["first_name"]; ?>" placeholder="First Name" class="form-control">
						</div>
					</div>
				</div>
				<!-- Text input-->
				<div class="form-group">
					<label class="col-md-4 control-label" for="Last Name">Last Name</label>  
					<div class="col-md-6">
						<div class="input-group col-md-12">
							<input disabled id="Last Name" name="Last Name" type="text" value="<?php echo $customer["last_name"]; ?>" placeholder="Last Name" class="form-control">
						</div>
					</div>
				</div>
				<!-- Text input-->
				<div class="form-group">
					<label class="col-md-4 control-label" for="Tax identification number">Tax identification number</label>  
					<div class="col-md-6">
						<div class="input-group col-md-12">
							<input disabled id="Tax identification number" name="Tax identification number" type="text" value="<?php echo $customer["tax_number"]; ?>" placeholder="Tax identification number" class="form-control">
						</div>
					</div>
				</div>
				<!-- Text input-->
				<div class="form-group">
					<label class="col-md-4 control-label" for="Date Of Birth">Date Of Birth</label>  
					<div class="col-md-6">
						<div class="input-group col-md-12">
							<input disabled id="dob" name="Date Of Birth" type="date" value="<?php echo $customer["date_birth"]; ?>" placeholder="Date Of Birth" class="form-control input-md">
						</div>
					</div>
				</div>
				<!-- Multiple Radios (inline) -->
				<div class="form-group">
					<label class="col-md-4 control-label" for="Gender">Gender</label>
					<div class="col-md-4"> 
						<label class="radio-inline" for="Gender-0">
						<input disabled type="radio" name="Gender" id="Gender-0" value="male" <?php if( $customer["gender"] == "male" ) { echo 'checked="checked"'; } ?>>
						Male
						</label> 
						<label class="radio-inline" for="Gender-1">
						<input disabled type="radio" name="Gender" id="Gender-1" value="female" <?php if( $customer["gender"] == "female" ) { echo 'checked="checked"'; } ?>>
						Female
						</label> 
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-4 control-label" for="Street">Invoice Address</label>  
					<div class="col-md-6">
						<input disabled id="Street" name="Street" type="text" value="<?php echo $customer["invoice_address_street"]; ?>" placeholder="Street" class="form-control input-md ">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-4 control-label col-xs-12" for=""></label>  
					<div class="col-md-3 col-xs-4">
						<input disabled id="Aditional Info" name="Aditional Info" type="text" value="<?php echo $customer["invoice_address_addinfo"]; ?>" placeholder="City" class="form-control input-md ">
					</div>
					<div class="col-md-3 col-xs-4">
						<input disabled id="Residence Number" name="Residence Number" type="text" value="<?php echo $customer["invoice_address_resnumber"]; ?>" placeholder="Residence Number" class="form-control input-md ">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-4 control-label" for="Postcode"></label>  
					<div class="col-md-6">
						<input disabled id="Postcode" name="Postcode" type="text" value="<?php echo $customer["invoice_address_postcode"]; ?>" placeholder="Postcode" class="form-control input-md ">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-4 control-label" for="Country"></label>  
					<div class="col-md-6">
						<input disabled id="Country" name="Country" type="text" value="<?php echo $customer["invoice_address_country"]; ?>" placeholder="Country" class="form-control input-md">
					</div>
				</div>
				<!-- Text input-->
				<div class="form-group">
					<label class="col-md-4 control-label" for="Email Address">Phone No</label>  
					<div class="col-md-6">
						<div class="input-group col-md-12">
							<input disabled id="phoneno" name="phoneno" type="text" value="<?php echo $customer["phone_no"]; ?>" placeholder="Phone No" class="form-control input-md">
						</div>
					</div>
				</div>
				<!-- Text input-->
				<div class="form-group">
					<label class="col-md-4 control-label" for="Email Address">Email Address</label>  
					<div class="col-md-6">
						<div class="input-group col-md-12">
							<input disabled id="Email Address" value="<?php echo $customer["email"]; ?>" name="Email Address" type="text"  class="form-control input-md">
						</div>
					</div>
				</div>
			
			</fieldset>
		</form>
	</div>
</div>