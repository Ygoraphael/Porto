<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<div class="page-head col-md-12">
	<div class="col-md-12 col-sm-12">
		<h2 class="col-md-6 col-sm-6"><?php echo $this->translation->Translation_key($title, $_SESSION['lang_u']); ?></h2>
		<button type="button" id="create_pickup_zone" class="btn btn-info pull-right"><?php echo $this->translation->Translation_key("Create Pickup Zone", $_SESSION['lang_u']); ?></button>
		<button type="button" id="create_pickup" class="btn btn-info pull-right" style="margin-right:15px;"><?php echo $this->translation->Translation_key("Create Pickup", $_SESSION['lang_u']); ?></button>
	</div>
</div>
<div class="col-md-12 col-sm-12 clearfix" data-alerts="alerts" data-fade="3000"></div>
<div class="main-content col-sm-12">
	<div class="col-lg-9">
		<h3><?php echo $this->translation->Translation_key("Pickups", $_SESSION['lang_u']); ?></h3>
		<table id="tab-pickup" class="table table-striped table-bordered" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th><?php echo $this->translation->Translation_key("Name", $_SESSION['lang_u']); ?></th>
					<th><?php echo $this->translation->Translation_key("Address", $_SESSION['lang_u']); ?></th>
					<th><?php echo $this->translation->Translation_key("Postcode", $_SESSION['lang_u']); ?></th>
					<th><?php echo $this->translation->Translation_key("City", $_SESSION['lang_u']); ?></th>
					<th><?php echo $this->translation->Translation_key("Country", $_SESSION['lang_u']); ?></th>
					<th><?php echo $this->translation->Translation_key("Zone", $_SESSION['lang_u']); ?></th>
					<th></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			<?php
				foreach( $pickups as $pickup ) { ?>
				<tr>
					<td stamp="<?php echo trim($pickup["u_pickupstamp"]); ?>"><?php echo trim($pickup["name"]); ?></td>
					<td><?php echo trim($pickup["address"]); ?></td>
					<td><?php echo trim($pickup["postcode"]); ?></td>
					<td><?php echo trim($pickup["city"]); ?></td>
					<td><?php echo trim($pickup["country"]); ?></td>
					<td><?php echo trim($pickup["zone_name"]); ?></td>
					<td class="text-center"><a href="#" onclick="delete_pickup(jQuery(this)); return false;" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span></a></td>
					<td class="text-center"><a href="<?php echo base_url() ?>backoffice/pickup/<?php echo trim($pickup["u_pickupstamp"]); ?>" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></a></td>
				</tr>
			<?php
				}
			?>
			</tbody>
		</table>
	</div>
	<div class="col-lg-3">
		<h3><?php echo $this->translation->Translation_key("Zones", $_SESSION['lang_u']); ?></h3>
		<table id="tab-pickup" class="table table-striped table-bordered" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th><?php echo $this->translation->Translation_key("Name", $_SESSION['lang_u']); ?></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			<?php
				foreach( $pickups_zones as $pickups_zone ) { ?>
				<tr>
					<td stamp="<?php echo trim($pickups_zone["u_pickup_zonestamp"]); ?>"><?php echo trim($pickups_zone["name"]); ?></td>
					<td class="text-center"><a href="#" onclick="delete_pickup_zone(jQuery(this)); return false;" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span></a></td>
				</tr>
			<?php
				}
			?>
			</tbody>
		</table>
	</div>
</div>

<script>
	jQuery("#create_pickup").click(function() {
		bootbox.prompt("Enter new pickup's name", function(result) {
			if( result ) {
				$(".loading-overlay").show();
				jQuery.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>backoffice/ajax/create_pickup",
					data: { 
						"name" : result
					},
					success: function(data) 
					{
						data = JSON.parse(data);

						if( data['success'] == 1) {
							window.location.href = '<?php echo base_url(); ?>backoffice/pickup/' + data['u_pickupstamp'];
						}
						else if( data['success'] == 0) {
							$(".loading-overlay").hide();
							jQuery(document).trigger("add-alerts", [
							{
								"message": "Error creating pickup",
								"priority": 'error'
							}
							]);
						}
						else {
							$(".loading-overlay").hide();
							jQuery(document).trigger("add-alerts", [
							{
								"message": "Pickup name already exists",
								"priority": 'error'
							}
							]);
						}
					}
				});
			}
		});
	});
	
	jQuery("#create_pickup_zone").click(function() {
		bootbox.prompt("Enter new pickup zone's name", function(result) {
			if( result ) {
				$(".loading-overlay").show();
				jQuery.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>backoffice/ajax/create_pickup_zone",
					data: { 
						"name" : result
					},
					success: function(data) 
					{
						data = JSON.parse(data);

						if( data['success'] == 1) {
							location.reload();
						}
						else if( data['success'] == 0) {
							$(".loading-overlay").hide();
							jQuery(document).trigger("add-alerts", [
							{
								"message": "Error creating pickup zone",
								"priority": 'error'
							}
							]);
						}
						else {
							$(".loading-overlay").hide();
							jQuery(document).trigger("add-alerts", [
							{
								"message": "Pickup zone name already exists",
								"priority": 'error'
							}
							]);
						}
					}
				});
			}
		});
	});

	function delete_pickup(obj) {
		bootbox.confirm("Do you really want to delete this pickup?", function(result){ 
			if( result ) {
				$(".loading-overlay").show();
				var stamp = obj.parent().parent().children().eq(0).attr("stamp");

				jQuery.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>backoffice/ajax/delete_pickup",
					data: { 
						"stamp" : stamp
					},
					success: function(data) 
					{
						if( data ) {
							obj.parent().parent().remove();
							$(".loading-overlay").hide();
							jQuery(document).trigger("add-alerts", [
							{
								"message": "Pickup deleted successfully",
								"priority": 'success'
							}
							]);
						}
						else {
							$(".loading-overlay").hide();
							jQuery(document).trigger("add-alerts", [
							{
								"message": "Error deleting pickup",
								"priority": 'error'
							}
							]);
						}
					}
				});
			}
		});
	}
	
	function delete_pickup_zone(obj) {
		bootbox.confirm("Do you really want to delete this pickup zone?", function(result){ 
			if( result ) {
				$(".loading-overlay").show();
				var stamp = obj.parent().parent().children().eq(0).attr("stamp");

				jQuery.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>backoffice/ajax/delete_pickup_zone",
					data: { 
						"stamp" : stamp
					},
					success: function(data) 
					{
						if( data ) {
							location.reload();
						}
						else {
							$(".loading-overlay").hide();
							jQuery(document).trigger("add-alerts", [
							{
								"message": "Error deleting pickup zone",
								"priority": 'error'
							}
							]);
						}
					}
				});
			}
		});
	}
</script>