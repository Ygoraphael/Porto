<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<div class="clearfix page-head col-md-12">
	<div class="col-md-12 col-sm-12">
		<h2 class="col-md-6 col-sm-6"><?php echo $title; ?></h2>
		<button type="button" id="create_prod" class="btn btn-info pull-right">New agent</button>
	</div>
</div>
<div class="main-content col-sm-12">
	<div class="col-lg-12">
		<form>
			<div class="form-group">
				<label for="ncont">VAT</label>
				<input type="text" class="form-control" id="ncont" name="fl.ncont" required value="<?php echo $ag_vat; ?>" disabled placeholder="VAT">
			</div>
			<div class="form-group">
				<label for="nome">Name</label>
				<input type="text" class="form-control" id="nome" name="fl.nome" required placeholder="Name">
			</div>
			<div class="form-group">
				<label for="email">Email</label>
				<input type="email" class="form-control" id="email" name="fl.email" aria-describedby="emailHelp" required placeholder="Email">
			</div>
			<div class="form-group">
				<label for="telefone">Phone</label>
				<input type="text" class="form-control" id="telefone" name="fl.telefone" required placeholder="Phone">
			</div>
			<div class="form-group">
				<label for="location">Local</label>
				<input type="text" class="form-control" id="location" name="fl.u_local" required placeholder="Location">
			</div>
		</form>
		<p style="margin-bottom:25px"></p>
		<div class="clearfix" data-alerts="alerts" data-fade="3000"></div>
		<button data-step-control="save" class="btn btn-info btn-lg pull-left">SAVE</button>
		<button data-step-control="cancel" class="btn btn-default btn-lg pull-left">CANCEL</button>
	</div>
</div>

<script>
	jQuery( "[data-step-control='save']" ).click(function() {
		$(".loading-overlay").show();
		var myform = $('form');
		var disabled = myform.find(':input:disabled').removeAttr('disabled');
		
		jQuery.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>backoffice/ajax/create_agent",
			data: {
				"input" : JSON.stringify(jQuery("form").serializeToJSON())
			},
			success: function(data) 
			{
				disabled.attr('disabled','disabled');
				data = JSON.parse(data);
				
				if( data['success'] == 1) {
					$(".loading-overlay").hide();
					bootbox.alert(data['message'], function(){ location.replace('<?php echo base_url(); ?>backoffice/agents'); });
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
	});
	
	jQuery( "[data-step-control='cancel']" ).click(function() {
		location.replace('<?php echo base_url(); ?>backoffice/agents');
	});
</script>