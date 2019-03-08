<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
		<div class="page-head col-md-12">
			<div class="col-md-12 col-sm-12">
				<h2 class="col-md-6 col-sm-6 col-xs-6"><?php echo $title; ?></h2>			
				<a onclick="window.history.back(); return false;" type="button" class="btn btn-primary pull-right"	style="margin-right:15px;"><span class="glyphicon glyphicon-chevron-left"></span> BACK</a>
			</div>
		</div>

		<div class="main-content col-sm-12 col-md-12 col-xs-12">
			<div class="panel panel-default">
				<div class="col-sm-12 col-md-12 col-xs-12">
					<form action="#" class="form-horizontal group-border-dashed clearfix" >
						<div class="form-group">
							<label class="col-lg-2 col-sm-3 col-md-2  col-xs-12 control-label">Language</label>
							<div class="input-group col-lg-8 col-sm-8 col-md-3  col-xs-12" style="margin-right:10px">
								<select class="form-control" id="lang" name="">
										<option value=""></option>
										<?php foreach($languages as $language) { 
											if($language["language"] == trim($profile['lang'])){
												?>
												<option value="<?php echo $language["language"]; ?>" selected ><?php echo $language["language"]; ?></option>
												<?php
											}else{
										?>
										<option value="<?php echo $language["language"]; ?>" ><?php echo $language["language"]; ?></option>
											<?php }
											} ?>
									</select>
							</div>							
						</div>
					</form>
					<p style="margin-bottom:25px"></p>
				   <div class="clearfix" data-alerts="alerts" data-fade="3000"></div>
				   	<button style="margin-bottom:25px" onclick="save(); return false;" class="btn btn-info btn-lg pull-left">SAVE</button>
				</div>
			</div>
		</div>
	</div>

</div>


<script>
function save(){
	$(".loading-overlay").show();
	var lang = $("#lang").val();	

	
	jQuery.ajax({
		type: "POST",
		url: "<?php echo base_url(); ?>backoffice/ajax/update_profile",
		data: { 
			"lang" : lang
		},
		success: function(data) 
		{
		
			$(".loading-overlay").hide();
			jQuery(document).trigger("add-alerts", [
			{
				"message": "Product's Fee updated successfully",
				"priority": 'success'
			}
			]);
		}
	});
	
}
</script>