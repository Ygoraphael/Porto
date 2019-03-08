<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<div class="page-head col-md-12">
	<div class="col-md-12 col-sm-12">
		<h2 class="col-md-6 col-sm-6"><?php echo $title; ?></h2>
		<button type="button" id="access_maintenance" style="margin-left:15px" class="btn btn-info pull-right">Access's Maintenance</button>
		<?php if($create_user){?>
		<button type="button" id="create_user" class="btn btn-info pull-right">Create user</button>
		<?php }?>
	</div>
</div>
<div class="col-md-12 col-sm-12 clearfix" data-alerts="alerts" data-fade="3000"></div>
<div class="main-content col-sm-12">
	<table id="tab-users" class="table table-striped table-bordered" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th>Sub-ID</th>
				<th>Name</th>
				<th>Address</th>
				<th>Postcode</th>
				<th>City</th>
				<th>Email</th>
				<th>Phone</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
		<?php foreach( $users as $us ) {?>
			<tr>
				<td><?php echo $us["estab"]; ?></td>
				<td><?php echo $us["nome"]; ?></td>
				<td><?php echo $us["morada"]; ?></td>
				<td><?php echo $us["codpost"]; ?></td>
				<td><?php echo $us["local"]; ?></td>
				<td><?php echo $us["email"]; ?></td>
				<td><?php echo $us["telefone"]; ?></td>
				<td class="text-center"><a href="<?php echo base_url(); ?>backoffice/user/<?php echo $us["no"]; ?>/<?php echo $us["estab"]; ?>" class="btn btn-default <?php echo ($view_user)?"":"disabled" ?>"><span class="glyphicon glyphicon-search"></span></a></td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
</div>
<script>
	jQuery("#create_user").click(function() {
		bootbox.prompt("Enter new user's name", function(result) {
			if( result ) {
				$(".loading-overlay").show();
				jQuery.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>backoffice/ajax/create_user",
					data: { 
						"name" : result
					},
					success: function(data) 
					{
						data = JSON.parse(data);

						if( data['success'] == 1) {
							window.location.href = '<?php echo base_url(); ?>backoffice/user/<?php echo $user["no"]; ?>/' + data['estab'];
						}
						else {
							$(".loading-overlay").hide();
							jQuery(document).trigger("add-alerts", [
							{
								"message": "Error creating user",
								"priority": 'error'
							}
							]);
						}
					}
				});
			}
		});
	});
	
	jQuery("#access_maintenance").click(function() {
		bootbox.confirm("Do you really want to do access's maintenance?", function(result) {
			if( result ) {
				$(".loading-overlay").show();
				jQuery.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>backoffice/ajax/access_maintenance",
					success: function(data) 
					{
						data = JSON.parse(data);

						if( data['success'] == 1) {
							$(".loading-overlay").hide();
							jQuery(document).trigger("add-alerts", [
							{
								"message": "Access's maintenance terminated successfully",
								"priority": 'success'
							}
							]);
						}
						else {
							$(".loading-overlay").hide();
							jQuery(document).trigger("add-alerts", [
							{
								"message": "Error doing maintenance",
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