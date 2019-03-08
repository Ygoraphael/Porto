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
				<div class="col-md-12">
					<div class="col-md-12 well text-center">
						<form data-toggle="validator" role="form" action="#" style="border-radius: 0px;" class="form-horizontal group-border-dashed clearfix" novalidate="true">
							<span>
								<div class="form-group">
									<label class="col-lg-2 col-sm-3 control-label">Operator</label>
									<div class="input-group col-lg-8 col-sm-6">
										<select class="form-control" id="operator">
											<?php foreach($operators as $operator) { ?>
											<option value="<?php echo $operator["no"]; ?>"><?php echo $operator["nome"]; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-2 col-sm-3 control-label">Amount to Reimburse</label>
									<div class="input-group col-lg-3 col-sm-6">
										<span class="input-group-addon">€</span>
										<input type="number" step="0.01" class="form-control" id="amount" value="0.00">
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-2 col-sm-3 control-label"></label>
									<div class="input-group col-lg-3 col-sm-6">
										<small class="pull-left">This reimbursement will be processed when operator validate it</small>
									</div>
								</div>
							</span>
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
		url: "<?php echo base_url(); ?>backoffice/ajax/agent_insert_reimbursement",
		data: { 
			"operator" : jQuery("#operator").val(),
			"amount" : jQuery("#amount").val(),
			"formapag" : '2'
		},
		success: function(data) 
		{
			if( data == 1) {
				location.replace("<?php echo base_url()?>backoffice/agent_reimbursement");
			}
			else {
				$(".loading-overlay").hide();
				jQuery(document).trigger("add-alerts", [
				{
					"message": "Error inserting reimbursement",
					"priority": 'error'
				}
				]);
			}
		}
	});
});
</script>