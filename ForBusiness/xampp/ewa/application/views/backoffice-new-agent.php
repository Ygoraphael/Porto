<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<div class="clearfix page-head col-md-12">
	<div class="col-md-12 col-sm-12">
		<h2 class="col-md-6 col-sm-6"><?php echo $this->translation->Translation_key($title, $_SESSION['lang_u']); ?></h2>
		<button type="button" id="create_prod" class="btn btn-info pull-right"><?php echo $this->translation->Translation_key("New agent", $_SESSION['lang_u']); ?></button>
	</div>
</div>
<div class="main-content col-sm-12">
	<div class="col-lg-12">
		<form>
			<div class="form-group">
				<label for="ncont"><?php echo $this->translation->Translation_key("VAT", $_SESSION['lang_u']); ?></label>
				<input type="text" class="form-control" id="ncont" name="fl.ncont" required value="<?php echo $ag_vat; ?>" disabled placeholder="VAT">
			</div>
			<div class="form-group">
				<label for="nome"><?php echo $this->translation->Translation_key("Name", $_SESSION['lang_u']); ?></label>
				<input type="text" class="form-control" id="nome" name="fl.nome" required placeholder="<?php echo $this->translation->Translation_key("Name", $_SESSION['lang_u']); ?>">
			</div>
			<div class="form-group">
				<label for="email"><?php echo $this->translation->Translation_key("Email", $_SESSION['lang_u']); ?></label>
				<input type="email" class="form-control" id="email" name="fl.email" aria-describedby="emailHelp" required placeholder="<?php echo $this->translation->Translation_key("Email", $_SESSION['lang_u']); ?>">
			</div>
			<div class="form-group">
				<label for="telefone"><?php echo $this->translation->Translation_key("Phone", $_SESSION['lang_u']); ?></label>
				<input type="text" class="form-control" id="telefone" name="fl.telefone" required placeholder="<?php echo $this->translation->Translation_key("Phone", $_SESSION['lang_u']); ?>">
			</div>
			<div class="form-group">
				<label for="location"><?php echo $this->translation->Translation_key("Local", $_SESSION['lang_u']); ?></label>
				<input type="text" class="form-control" id="location" name="fl.u_local" required placeholder="<?php echo $this->translation->Translation_key("Location", $_SESSION['lang_u']); ?>">
			</div>
		</form>
		<p style="margin-bottom:25px"></p>
		<div class="clearfix" data-alerts="alerts" data-fade="3000"></div>
		<button data-step-control="save" class="btn btn-info btn-lg pull-left"><?php echo $this->translation->Translation_key("SAVE", $_SESSION['lang_u']); ?></button>
		<button data-step-control="cancel" class="btn btn-default btn-lg pull-left"><?php echo $this->translation->Translation_key("CANCEL", $_SESSION['lang_u']); ?></button>
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