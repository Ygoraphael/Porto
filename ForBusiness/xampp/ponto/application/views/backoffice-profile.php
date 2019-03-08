<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
		<div class="page-head col-md-12">
			<div class="col-md-12 col-sm-12">
				<h2 class="col-md-6 col-sm-6 col-xs-6"><?php echo $title; ?></h2>			
				<button type="button" id="save" class="btn btn-info pull-right">SAVE</button>
				<a onclick="window.history.back(); return false;" type="button" class="btn btn-primary pull-right"	style="margin-right:15px;"><span class="glyphicon glyphicon-chevron-left"></span> BACK</a>
			</div>
		</div>
		<div class="clearfix" data-alerts="alerts" data-fade="3000"></div>
		<div class="main-content col-sm-12 col-md-12 col-xs-12">
			<div class="panel panel-default">
				<div class="col-sm-12 col-md-12 col-xs-12">
					<form action="#" class="form-horizontal group-border-dashed clearfix" >
						<div class="form-group">
							<label class="col-lg-2 col-sm-3 col-md-2 col-xs-12 control-label">Name</label>
							<div class="input-group col-lg-3 col-sm-3 col-md-3  col-xs-12" style="margin-right:10px">
								<input type="text" class="form-control" id="nome_cliente" value="<?php echo $profile['nome'];?>" readonly>
							</div>
							<label class="col-lg-2 col-sm-3 col-md-2  col-xs-12 control-label">Nº </label>
							<div class="input-group col-lg-3 col-sm-3 col-md-3  col-xs-12" style="margin-right:10px">
								<input type="text" class="form-control" id="no" value="<?php echo $profile['no'];?>" readonly>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-2 col-sm-3 col-md-2  col-xs-12 control-label">Nº Cont</label>
							<div class="input-group col-lg-3 col-sm-3 col-md-3  col-xs-12" style="margin-right:10px">
								<input type="text" class="form-control" id="ncont" value="<?php echo $profile['ncont'];?>" readonly>
							</div>
							<label class="col-lg-2 col-sm-3 col-md-2  col-xs-12 control-label">Address</label>
							<div class="input-group col-lg-3 col-sm-3 col-md-3  col-xs-12" style="margin-right:10px">
								<input type="text" class="form-control" id="morada" value="<?php echo $profile['morada'];?>" readonly>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-2 col-sm-3 col-md-2  col-xs-12 control-label">Postal Code</label>
							<div class="input-group col-lg-3 col-sm-3 col-md-3  col-xs-12" style="margin-right:10px">
								<input type="text" class="form-control" id="codpost" value="<?php echo $profile['codpost'];?>" readonly>
							</div>
							<label class="col-lg-2 col-sm-3 col-md-2  col-xs-12 control-label">Local</label>
							<div class="input-group col-lg-3 col-sm-3 col-md-3  col-xs-12" style="margin-right:10px">
								<input type="text" class="form-control" id="local" value="<?php echo $profile['local'];?>" readonly>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-2 col-sm-3 col-md-2  col-xs-12 control-label">Phone</label>
							<div class="input-group col-lg-3 col-sm-3 col-md-3  col-xs-12" style="margin-right:10px">
								<input type="text" class="form-control" id="telefone" value="<?php echo $profile['telefone'];?>" readonly>
							</div>
						</div>
						<?php if( $profile["u_operador"] == "Sim" ) { ?>
						<div class="form-group">
							<label class="col-lg-2 col-sm-3 control-label"></label>
							<div class="input-group col-lg-8 col-sm-6">
								<div class="am-checkbox clearfix">
									<input name="fl.u_ewadisab" id="u_ewadisab" type="checkbox" <?php echo $profile["u_ewadisab"] ? "checked": ""; ?>>
									<label class="pull-left" for="u_ewadisab">Disable all products in EWA page</label>
								</div>
							</div>
						</div>
						<?php } ?>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
jQuery( "#save" ).click(function() {
	$(".loading-overlay").show();
	
	//checkboxes
	var checkbox = new Array();
	$('input[type=checkbox]').each(function() {
		var checkbox_tmp = new Array();
		checkbox_tmp.push(this.name);
		if (!this.checked) {
			checkbox_tmp.push(0);
		}
		else {
			checkbox_tmp.push(1);
		}
		checkbox.push(checkbox_tmp);
	});
		
	jQuery.ajax({
		type: "POST",
		url: "<?php echo base_url(); ?>backoffice/ajax/update_profile_data",
		data: { 
			"checkbox" : JSON.stringify(checkbox)
		},
		success: function(data) 
		{
			if( data == 1) {
				$(".loading-overlay").hide();
				jQuery(document).trigger("add-alerts", [
				{
					"message": "Profile updated successfully",
					"priority": 'success'
				}
				]);
			}
			else {
				$(".loading-overlay").hide();
				jQuery(document).trigger("add-alerts", [
				{
					"message": "Error updating profile",
					"priority": 'error'
				}
				]);
			}
		}
	});
});
</script>


