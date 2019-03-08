<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
		<div class="page-head col-md-12">
			<div class="col-md-12 col-sm-12">
				<h2 class="col-md-6 col-sm-6"><?php echo $title; ?></h2>
				<button type="button" id="save" class="btn btn-info pull-right">SAVE</button>
				<?php if($acesso_assign_products){?>
				<a onclick="edit_item(2); return false;" type="button" class="btn btn-info pull-right"	style="margin-right:15px;">Assign Products</a>
				<?php }
				if($dissociate_op_agent){?>
				<a onclick="dissociate_op_agent(); return false;" type="button" class="btn btn-info pull-right"	style="margin-right:15px;">Dissociate Agent</a>
				<?php }
				if($acesso_manage_fees){?>
				<a onclick="edit_item(1)" type="button" class="btn btn-info pull-right" style="margin-right:15px;">Manage Fees</a>
				<?php }?>
				<a onclick="window.history.back(); return false;" type="button" class="btn btn-primary pull-right" style="margin-right:15px;"><span class="glyphicon glyphicon-chevron-left"></span> BACK</a>				
			</div>
		</div>
		<p style="margin-bottom:5px"></p>
		<div class="clearfix" data-alerts="alerts" data-fade="3000"></div>
		<div class="main-content col-sm-12">
		   <div class="panel panel-default">
			  <div class="col-md-11">
				 <div class="panel panel-default">
					<div class="form-group col-sm-6" style="height: 68px;">
					   <label class="col-sm-4 control-label">Name</label>
					   <div class="col-sm-8"><input id="nome" type="text" name="nome" class="form-control activeInput" value="<?php echo $agent[0]['nome'];?>" readonly></div>
					</div>
					<div class="form-group col-sm-6" style="height: 68px;">
					   <label class="col-sm-4 control-label">VAT</label>
					   <div class="col-sm-8"><input id="ncont" type="text" name="ncont" class="form-control activeInput" value="<?php echo $agent[0]['ncont'];?>" readonly></div>
					</div>
					<div class="form-group col-sm-6" style="height: 68px;">
					   <label class="col-sm-4 control-label">Adress</label>
					   <div class="col-sm-8"><input id="morada" type="text" name="morada" class="form-control activeInput" value="<?php echo $agent[0]['morada'];?>" readonly></div>
					</div>
					<div class="form-group col-sm-6" style="height: 68px;">
					   <label class="col-sm-4 control-label">City</label>
					   <div class="col-sm-8"><input id="local" type="text" name="local" class="form-control activeInput" value="<?php echo $agent[0]['local'];?>" readonly></div>
					</div>
					<div class="form-group col-sm-6" style="height: 68px;">
					   <label class="col-sm-4 control-label">Post Code</label>
					   <div class="col-sm-8"><input id="codpost" type="text" name="local" class="form-control activeInput" value="<?php echo $agent[0]['codpost'];?>" readonly></div>
					</div>
					<div class="form-group col-sm-6" style="height: 68px;">
					   <label class="col-sm-4 control-label">Email</label>
					   <div class="col-sm-8"><input id="email" type="text" name="email" class="form-control activeInput" value="<?php echo $agent[0]['email'];?>" readonly></div>
					</div>
					<div class="form-group col-sm-6" style="height: 68px;">
					   <label class="col-sm-4 control-label">Phone</label>
					   <div class="col-sm-8"><input id="tlmvl" type="TEXT" name="tlmvl" class="form-control activeInput" value="<?php echo $agent[0]['tlmvl'];?>" readonly></div>
					</div>
					<div class="form-group col-sm-6" style="height: 68px;">
					   <label class="col-sm-4 control-label">Location</label>
					   <div class="col-sm-8">
						   <select class="form-control" id="u_local" name="u_local">
								<option value=""></option>
								<?php foreach( $locations as $location ) { ?>
								<option value="<?php echo trim($location["u_locationstamp"]); ?>" <?php echo trim($location["u_locationstamp"]) == trim($agent[0]["gsecstamp"]) ? "selected": ""; ?>><?php echo trim($location["name"]); ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
				 </div>
			  </div>
		   </div>
		</div>
	</div>
</div>

<form method="post" id="theForm" action="">
	<input id="theFormid" type="hidden" name="id" value="1">
</form>
<script>
function edit_item(id){
	$('#theFormid').val(id);
	$('#theForm').submit()
}

jQuery( "#save" ).click(function() {
	$(".loading-overlay").show();
	jQuery.ajax({
		type: "POST",
		url: "<?php echo base_url(); ?>backoffice/ajax/update_agent",
		data: { 
			"u_locationstamp" : jQuery("#u_local").val(),
			"agent" : '<?php echo $agent[0]['no'];?>'
		},
		success: function(data) 
		{
			if( data == 1) {
				$(".loading-overlay").hide();
				jQuery(document).trigger("add-alerts", [
				{
					"message": "Agent updated successfully",
					"priority": 'success'
				}
				]);
			}
			else {
				$(".loading-overlay").hide();
				jQuery(document).trigger("add-alerts", [
				{
					"message": "Error updating agent",
					"priority": 'error'
				}
				]);
			}
		}
	});
});

function dissociate_op_agent() {
	bootbox.confirm({
		message: "Do you really want to dissociate this agent with your account? This procedure is irreversible!",
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
					url: "<?php echo base_url(); ?>backoffice/ajax/dissociate_op_agent",
					data: { 
						"vat" : '<?php echo $agent[0]['ncont'];?>'
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
</script>
