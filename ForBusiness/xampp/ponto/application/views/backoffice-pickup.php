<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
		<div class="page-head col-md-12">
			<div class="col-md-12 col-sm-12">
				<h2 class="col-md-6 col-sm-6"><?php echo $title; ?></h2>
				<button type="button" id="save" class="btn btn-info pull-right">SAVE</button>
				<a onclick="window.history.back(); return false;" type="button" class="btn btn-primary pull-right" style="margin-right:15px;"><span class="glyphicon glyphicon-chevron-left"></span> BACK</a>				
			</div>
		</div>
		<p style="margin-bottom:5px"></p>
		<div class="clearfix" data-alerts="alerts" data-fade="3000"></div>
		<div class="main-content col-sm-12">
		   <div class="panel panel-default">
			  <div class="col-md-11">
				<div class="panel panel-default">
				<form>
					<div class="form-group col-sm-6" style="height: 68px;">
					   <label class="col-sm-4 control-label">Name</label>
					   <div class="col-sm-8"><input id="" type="text" name="" class="form-control activeInput" value="<?php echo $u_pickup['name'];?>" readonly></div>
					</div>
					<div class="form-group col-sm-6" style="height: 68px;">
					   <label class="col-sm-4 control-label">Address</label>
					   <div class="col-sm-8"><input id="u_pickup.address" type="text" name="u_pickup.address" class="form-control activeInput" value="<?php echo $u_pickup['address'];?>"></div>
					</div>
					<div class="form-group col-sm-6" style="height: 68px;">
					   <label class="col-sm-4 control-label">Postcode</label>
					   <div class="col-sm-8"><input id="u_pickup.postcode" type="text" name="u_pickup.postcode" class="form-control activeInput" value="<?php echo $u_pickup['postcode'];?>"></div>
					</div>
					<div class="form-group col-sm-6" style="height: 68px;">
					   <label class="col-sm-4 control-label">City</label>
					   <div class="col-sm-8"><input id="u_pickup.city" type="text" name="u_pickup.city" class="form-control activeInput" value="<?php echo $u_pickup['city'];?>"></div>
					</div>
					<div class="form-group col-sm-6" style="height: 68px;">
					   <label class="col-sm-4 control-label">Country</label>
					   <div class="col-sm-8">
							<select class="form-control" id="u_pickup.country" name="u_pickup.country">
								<option value=""></option>
								<?php foreach( $countries as $country ) { ?>
								<option value="<?php echo trim($country["printable_name"]); ?>" <?php echo trim($country["printable_name"]) == $u_pickup["country"] ? "selected": ""; ?>><?php echo trim($country["printable_name"]); ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
				</form>
				</div>
			  </div>
		   </div>
		</div>
	</div>
</div>

<script>
jQuery( "#save" ).click(function() {
	$(".loading-overlay").show();

	jQuery.ajax({
		type: "POST",
		url: "<?php echo base_url(); ?>backoffice/ajax/update_pickup",
		data: {
			"input" : JSON.stringify(jQuery("form").serializeToJSON()),
			"u_pickupstamp" : '<?php echo $u_pickup['u_pickupstamp'];?>'
		},
		success: function(data) 
		{
			if( data == 1) {
				$(".loading-overlay").hide();
				jQuery(document).trigger("add-alerts", [
				{
					"message": "Pickup updated successfully",
					"priority": 'success'
				}
				]);
			}
			else {
				$(".loading-overlay").hide();
				jQuery(document).trigger("add-alerts", [
				{
					"message": "Error updating pickup",
					"priority": 'error'
				}
				]);
			}
		}
	});
});
</script>
