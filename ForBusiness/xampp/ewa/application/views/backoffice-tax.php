<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
		<div class="page-head col-md-12">
			<div class="col-md-12 col-sm-12">
				<h2 class="col-md-6 col-sm-6"><?php echo $this->translation->Translation_key($title, $_SESSION['lang_u']); ?></h2>
				<button type="button" id="save" class="btn btn-info pull-right"><?php echo $this->translation->Translation_key("SAVE", $_SESSION['lang_u']); ?></button>
				<a onclick="window.history.back(); return false;" type="button" class="btn btn-primary pull-right" style="margin-right:15px;"><span class="glyphicon glyphicon-chevron-left"></span><?php echo $this->translation->Translation_key("BACK", $_SESSION['lang_u']); ?> </a>				
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
					   <label class="col-sm-4 control-label"><?php echo $this->translation->Translation_key("Tax", $_SESSION['lang_u']); ?></label>
					   <div class="col-sm-8"><input id="u_tax.tax" type="text" name="" class="form-control activeInput" value="<?php echo $tax['tax'];?>" readonly></div>
					</div>
					<div class="form-group col-sm-6" style="height: 68px;">
					   <label class="col-sm-4 control-label"><?php echo $this->translation->Translation_key("Description", $_SESSION['lang_u']); ?></label>
					   <div class="col-sm-8"><input id="u_tax.design" type="text" name="u_tax.design" class="form-control activeInput" value="<?php echo $tax['design'];?>"></div>
					</div>
					<div class="form-group col-sm-6" style="height: 68px;">
					   <label class="col-sm-4 control-label"><?php echo $this->translation->Translation_key("Formula", $_SESSION['lang_u']); ?></label>
					   <div class="col-sm-8">
						   <select class="form-control" id="u_tax.formula" name="u_tax.formula">
								<option value=""></option>
								<option <?php echo trim($tax["formula"]) == "+v" ? "selected": ""; ?> value="+v">+V</option>
								<option <?php echo trim($tax["formula"]) == "-v" ? "selected": ""; ?> value="-v">-V</option>
								<option <?php echo trim($tax["formula"]) == "+%" ? "selected": ""; ?> value="+%">+%</option>
								<option <?php echo trim($tax["formula"]) == "-%" ? "selected": ""; ?> value="-%">-%</option>
							</select>
						</div>
					</div>
					<div class="form-group col-sm-6" style="height: 68px;">
					   <label class="col-sm-4 control-label"><?php echo $this->translation->Translation_key("Value", $_SESSION['lang_u']); ?></label>
					   <div class="col-sm-8"><input id="u_tax.value" type="number" step="0.01" name="u_tax.value" class="form-control activeInput" value="<?php echo number_format($tax['value'], 2, '.', '');?>"></div>
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

	input_var = jQuery("form").serializeToJSON();

	jQuery.ajax({
		type: "POST",
		url: "<?php echo base_url(); ?>backoffice/ajax/update_tax",
		data: {
			"input" : JSON.stringify(input_var),
			"u_taxstamp" : '<?php echo $tax['u_taxstamp'];?>'
		},
		success: function(data) 
		{
			if( data == 1) {
				$(".loading-overlay").hide();
				jQuery(document).trigger("add-alerts", [
				{
					"message": "Tax updated successfully",
					"priority": 'success'
				}
				]);
			}
			else {
				$(".loading-overlay").hide();
				jQuery(document).trigger("add-alerts", [
				{
					"message": "Error updating tax",
					"priority": 'error'
				}
				]);
			}
		}
	});
});
</script>
