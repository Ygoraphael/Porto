<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<div class="page-head col-md-12">
	<div class="col-md-12 col-sm-12">
		<h2 class="col-md-6 col-sm-6"><?php echo $title; ?></h2>
	</div>
</div>
<div class="col-md-12 col-sm-12 clearfix" data-alerts="alerts" data-fade="3000"></div>
<div class="main-content col-sm-12">
	<form>
		<div class="form-group">
			<label for="exampleInputEmail1">Year</label>
			<input type="text" class="form-control bfh-number" data-min="2016" data-max="2100" id="year" value="<?php echo date('Y'); ?>">
		</div>
		<div class="form-group">
			<label for="exampleInputEmail1">Month</label>
			<select class="form-control" id="month">
				<option <?php echo (date('m') == "02" ? "selected" : ""); ?> value="01">January</option>
				<option <?php echo (date('m') == "03" ? "selected" : ""); ?> value="02">February</option>
				<option <?php echo (date('m') == "04" ? "selected" : ""); ?> value="03">March</option>
				<option <?php echo (date('m') == "05" ? "selected" : ""); ?> value="04">April</option>
				<option <?php echo (date('m') == "06" ? "selected" : ""); ?> value="05">May</option>
				<option <?php echo (date('m') == "07" ? "selected" : ""); ?> value="06">June</option>
				<option <?php echo (date('m') == "08" ? "selected" : ""); ?> value="07">July</option>
				<option <?php echo (date('m') == "09" ? "selected" : ""); ?> value="08">August</option>
				<option <?php echo (date('m') == "10" ? "selected" : ""); ?> value="09">September</option>
				<option <?php echo (date('m') == "11" ? "selected" : ""); ?> value="10">October</option>
				<option <?php echo (date('m') == "12" ? "selected" : ""); ?> value="11">November</option>
				<option <?php echo (date('m') == "01" ? "selected" : ""); ?> value="12">December</option>
			</select>
		</div>
		<button type="submit" class="btn btn-primary form-submit">DOWNLOAD</button>
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