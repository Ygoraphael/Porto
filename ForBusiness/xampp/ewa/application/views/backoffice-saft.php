<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<div class="page-head col-md-12">
	<div class="col-md-12 col-sm-12">
		<h2 class="col-md-6 col-sm-6"><?php echo $this->translation->Translation_key($title, $_SESSION['lang_u']); ?></h2>
	</div>
</div>
<div class="col-md-12 col-sm-12 clearfix" data-alerts="alerts" data-fade="3000"></div>
<div class="main-content col-sm-12">
	<form>
		<div class="form-group">
			<label for="exampleInputEmail1"><?php echo $this->translation->Translation_key("Year", $_SESSION['lang_u']); ?></label>
			<input type="text" class="form-control bfh-number" data-min="2016" data-max="2100" id="year" value="<?php echo date('Y'); ?>">
		</div>
		<div class="form-group">
			<label for="exampleInputEmail1">Month</label>
			<select class="form-control" id="month">
				<option <?php echo (date('m') == "02" ? "selected" : ""); ?> value="01"><?php echo $this->translation->Translation_key("January", $_SESSION['lang_u']); ?></option>
				<option <?php echo (date('m') == "03" ? "selected" : ""); ?> value="02"><?php echo $this->translation->Translation_key("February", $_SESSION['lang_u']); ?></option>
				<option <?php echo (date('m') == "04" ? "selected" : ""); ?> value="03"><?php echo $this->translation->Translation_key("March", $_SESSION['lang_u']); ?></option>
				<option <?php echo (date('m') == "05" ? "selected" : ""); ?> value="04"><?php echo $this->translation->Translation_key("April", $_SESSION['lang_u']); ?></option>
				<option <?php echo (date('m') == "06" ? "selected" : ""); ?> value="05"><?php echo $this->translation->Translation_key("May", $_SESSION['lang_u']); ?></option>
				<option <?php echo (date('m') == "07" ? "selected" : ""); ?> value="06"><?php echo $this->translation->Translation_key("June", $_SESSION['lang_u']); ?></option>
				<option <?php echo (date('m') == "08" ? "selected" : ""); ?> value="07"><?php echo $this->translation->Translation_key("July", $_SESSION['lang_u']); ?></option>
				<option <?php echo (date('m') == "09" ? "selected" : ""); ?> value="08"><?php echo $this->translation->Translation_key("August", $_SESSION['lang_u']); ?></option>
				<option <?php echo (date('m') == "10" ? "selected" : ""); ?> value="09"><?php echo $this->translation->Translation_key("September", $_SESSION['lang_u']); ?></option>
				<option <?php echo (date('m') == "11" ? "selected" : ""); ?> value="10"><?php echo $this->translation->Translation_key("October", $_SESSION['lang_u']); ?></option>
				<option <?php echo (date('m') == "12" ? "selected" : ""); ?> value="11"><?php echo $this->translation->Translation_key("November", $_SESSION['lang_u']); ?></option>
				<option <?php echo (date('m') == "01" ? "selected" : ""); ?> value="12"><?php echo $this->translation->Translation_key("December", $_SESSION['lang_u']); ?></option>
			</select>
		</div>
		<button type="submit" class="btn btn-primary form-submit"><?php echo $this->translation->Translation_key("DOWNLOAD", $_SESSION['lang_u']); ?></button>
	</form>
	<script>
		jQuery(".form-submit").click(function() {
			var win = window.open('<?php echo base_url()?>backoffice/get_saft/' + jQuery("#year").val() + '/' + jQuery("#month").val(), '_blank');
			if ( win ) {
				win.focus();
			} else {
				alert('Please allow popups for this website');
			}
			return false;
		})
	</script>
</div>