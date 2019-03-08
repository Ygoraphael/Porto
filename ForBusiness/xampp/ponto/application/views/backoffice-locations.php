<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<div class="page-head col-md-12">
	<div class="col-md-12 col-sm-12">
		<h2 class="col-md-6 col-sm-6"><?php echo $title; ?></h2>
		<button class="btn btn-info pull-right" id="create_location" style="margin-left:15px;">CREATE LOCATION</button>
		<a onclick="window.history.back(); return false;" type="button" class="btn btn-primary pull-right"><span class="glyphicon glyphicon-chevron-left"></span> BACK</a>
	</div>
</div>
<div class="col-md-12 col-sm-12 clearfix" data-alerts="alerts" data-fade="3000"></div>
<div class="main-content col-sm-12">
	<table id="tab-locations" class="table table-striped table-bordered" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th>Name</th>
				<th>Address</th>
				<th>PostCode</th>
				<th>City</th>
				<th>Country</th>
				<th></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
		<?php foreach( $locations as $location) {?>
			<tr>
				<td><?php echo $location["name"]; ?></td>
				<td><?php echo $location["address"]; ?></td>
				<td><?php echo $location["postcode"]; ?></td>
				<td><?php echo $location["city"]; ?></td>
				<td><?php echo $location["country"]; ?></td>
				<td class="text-center nopaddingmargin"><a href="#" stamp="<?php echo $location["u_locationstamp"]; ?>" onclick="delete_location(jQuery(this)); return false;" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span></a></td>
				<td class="text-center"><a href="<?php echo base_url(); ?>backoffice/location/<?php echo $location["u_locationstamp"]; ?>" class="btn btn-default "><span class="glyphicon glyphicon-search"></span></a></td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
</div>
<script>
	jQuery(document).ready(function() {
		jQuery('#tab-locations').DataTable();
	});
	
	function delete_location( obj ) {
		bootbox.confirm("Do you really want to remove this location?", function(result) {
			if( result ) {
				$(".loading-overlay").show();
				jQuery.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>backoffice/ajax/delete_location",
					data: { 
						"stamp" : obj.attr("stamp")
					},
					success: function(data) 
					{
						if( data == 1 ) {
							location.replace('<?php echo base_url(); ?>backoffice/locations');
						}
						else {
							$(".loading-overlay").hide();
							jQuery(document).trigger("add-alerts", [
							{
								"message": "Error removing this location!",
								"priority": 'error'
							}
							]);
						}
					}
				});
			}
		});
	};
	
	jQuery("#create_location").click(function() {
		bootbox.prompt("Enter location's name", function(result) {
			if( result ) {
				$(".loading-overlay").show();
				jQuery.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>backoffice/ajax/create_location",
					data: { 
						"name" : result
					},
					success: function(data) 
					{
						data = JSON.parse(data);
						
						if( data["success"] == 1 ) {
							window.location.href = '<?php echo base_url(); ?>backoffice/location/'+data["u_locationstamp"];
						}
						else if( data["success"] == 0 ) {
							$(".loading-overlay").hide();
							jQuery(document).trigger("add-alerts", [
							{
								"message": "Error creating location!",
								"priority": 'error'
							}
							]);
						}
						else {
							$(".loading-overlay").hide();
							jQuery(document).trigger("add-alerts", [
							{
								"message": "This location's name, already exist!",
								"priority": 'error'
							}
							]);
						}
					}
				});
			}
		});
	});
</script>
