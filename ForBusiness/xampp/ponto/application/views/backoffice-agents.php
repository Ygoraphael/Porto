<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<div class="clearfix page-head col-md-12">
	<div class="col-md-12 col-sm-12">
		<h2 class="col-md-6 col-sm-6"><?php echo $title; ?></h2>
		<?php if($acesso_create){?>
		<a href="<?php echo base_url(); ?>backoffice/locations" id="manage_locations" style="margin-left:15px;" class="btn btn-info pull-right">Manage Locations</a>
		<button type="button" id="create_prod" class="btn btn-info pull-right">Create agent</button>
		<?php }?>
	</div>
</div>
<div class="col-md-12 col-sm-12 clearfix" data-alerts="alerts" data-fade="3000"></div>
<div class="main-content col-sm-12">
	<div class="col-lg-12">
		<table id="tab-products" class="table table-striped table-bordered" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th>ID</th>
					<th>Name</th>
					<th>VAT</th>
					<th>City</th>
					<th>PostCode</th>
					<th>Location</th>
					<th>Phone</th>
					<th>Email</th>
					<th>Status</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			<?php foreach( $agents as $agent ) {?>
				<tr>
					<td><?php echo $agent["no"]; ?></td>
					<td><?php echo $agent["nome"]; ?></td>
					<td><?php echo $agent["ncont"]; ?></td>
					<td><?php echo $agent["local"]; ?></td>
					<td><?php echo $agent["codpost"]; ?></td>
					<td><?php echo $agent["u_local"]; ?></td>
					<td><?php echo $agent["telefone"]; ?></td>
					<td><?php echo $agent["email"]; ?></td>
					<td><?php echo $agent["u_autoriz"] ? 'Approved' : 'Waiting Approval'; ?></td>
					<td class="text-center"><a href="<?php echo base_url(); ?>backoffice/agent/<?php echo $agent["no"]; ?>" class="btn btn-default <?php echo ($acesso_view)?"":"disabled" ?>"><span class="glyphicon glyphicon-search"></span></a></td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
		<script>
			jQuery(document).ready(function() {
				jQuery('#tab-products').DataTable();
			});
			
			jQuery("#create_prod").click(function() {
				bootbox.prompt("Enter agent's VAT", function(result) {
					if( result ) {
						$(".loading-overlay").show();
						jQuery.ajax({
							type: "POST",
							url: "<?php echo base_url(); ?>backoffice/ajax/check_agent_vat",
							data: { 
								"vat" : result
							},
							success: function(data) 
							{
								data = JSON.parse(data);
								
								if( data.length == 0 ) {
									window.location.href = '<?php echo base_url(); ?>backoffice/agent_new/?v='+result;
								}
								else {
									$(".loading-overlay").hide();
									bootbox.confirm({
										message: "This VAT is present in our database with name '" + data[0]['nome'] + "'. Do you want to associate this agent with your account?",
										buttons: {
											confirm: {
												label: 'Yes',
												className: 'btn-success'
											},
											cancel: {
												label: 'No',
												className: 'btn-danger'
											}
										},
										callback: function (result2) {
											if( result2 ) {
												$(".loading-overlay").show();
												jQuery.ajax({
													type: "POST",
													url: "<?php echo base_url(); ?>backoffice/ajax/associate_op_agent",
													data: { 
														"vat" : result
													},
													success: function(data) 
													{
														data = JSON.parse(data);
														if( data['success'] == 1) {
															location.replace('<?php echo base_url(); ?>backoffice/agents');
														}
														else {
															$(".loading-overlay").hide();
															jQuery(document).trigger("add-alerts", [
															{
																"message": data['message'],
																"priority": 'error'
															}
															]);
														}
													}
												});
											}
										}
									});
								}
							}
						});
					}
				});
			});
		</script>
	</div>
</div>