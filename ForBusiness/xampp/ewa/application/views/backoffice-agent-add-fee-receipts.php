<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<div class="clearfix page-head col-md-12">
	<div class="col-md-12 col-sm-12">
		<h2 class="col-md-6 col-sm-6"><?php echo $this->translation->Translation_key($title, $_SESSION['lang_u']); ?></h2>
		<a onclick="window.history.back(); return false;" type="button" class="btn btn-primary pull-right"	style="margin-right:15px;"><span class="glyphicon glyphicon-chevron-left"></span> <?php echo $this->translation->Translation_key("BACK", $_SESSION['lang_u']); ?></a>
	</div>
</div>

<div class="main-content col-sm-12">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="col-sm-12 col-md-12 col-xs-12">
				<form action="#" class="form-horizontal group-border-dashed clearfix" >
					<div class="form-group">
						<label class="col-lg-2 col-sm-3 col-md-2  col-xs-12 control-label"><?php echo $this->translation->Translation_key("Document Number", $_SESSION['lang_u']); ?></label>
						<div class="input-group col-lg-3 col-sm-3 col-md-3  col-xs-12" style="margin-right:10px">
							<input type="text" class="form-control" id="no" value="" placeholder="Document Number" required >
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 col-sm-3 col-md-2 col-xs-12 control-label"><?php echo $this->translation->Translation_key("Value", $_SESSION['lang_u']); ?> (€)</label>
						<div class="input-group col-lg-3 col-sm-3 col-md-3  col-xs-12" style="margin-right:10px">
							<input type="text" class="form-control" id="value" value=""placeholder="0.00" required >
						</div>
						<label class="col-lg-2 col-sm-3 col-md-2  col-xs-12 control-label"><?php echo $this->translation->Translation_key("Date", $_SESSION['lang_u']); ?></label>
						<div class="input-group col-lg-3 col-sm-3 col-md-3  col-xs-12" style="margin-right:10px">
							<input type="date" class="form-control" id="date" value="" required >
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 col-sm-3 col-md-2  col-xs-12 control-label"><?php echo $this->translation->Translation_key("Description", $_SESSION['lang_u']); ?></label>
						<div class="input-group col-lg-8 col-sm-8 col-md-8  col-xs-12" style="margin-right:10px">
							<input type="text" class="form-control" id="description"  maxlength="60" placeholder="Limit: 60 characters" required>
						</div>
					</div>
					<div class="form-group">
						<label class="col-lg-2 col-sm-3 col-md-2  col-xs-12 control-label"><?php echo $this->translation->Translation_key("File", $_SESSION['lang_u']); ?></label>
						<div class="input-group col-lg-8 col-sm-8 col-md-8  col-xs-12" style="margin-right:10px">
							<input type="file" class="form-control" id="file" value="" required >
						</div>
					</div>
					<div class="clearfix" data-alerts="alerts" data-fade="3000"></div>
					<div class="form-group">
						<button onclick="save(); return false;" class="btn btn-info btn-lg col-sm-12 col-md-12 col-xs-12"><?php echo $this->translation->Translation_key("SAVE", $_SESSION['lang_u']); ?></button>
					</div>
				</form>
			</div>
		</div>

	</div>
</div>

<script>
function save(){
	
	var f = document.getElementsByTagName('form')[0];
	if( f.checkValidity() ) {
		
		jQuery.ajax({
			url: "<?php echo base_url(); ?>backoffice/ajax/get_adoc",
			data: { 
				"adoc" : $('#no').val(),
				"date" : $('#date').val()
			},
			type: 'POST',
			success: function( result ) {
				if( result == 0 ) {
					var data = new FormData();
					jQuery.each($('input[type=file]')[0].files, function(i, file) {
						data.append('file-'+i, file);
					});
					
					jQuery.ajax({
						url: "<?php echo base_url(); ?>backoffice/ajax/upload_file_fee",
						data: data,
						cache: false,
						contentType: false,
						processData: false,
						type: 'POST',
						success: function( result ){
							result = JSON.parse(result);
							
							if( result[0] > 0 ) {
								var no = $('#no').val();
								var value = $('#value').val();
								var date = $('#date').val();
								var description = $('#description').val();
								var file = result[1][0];
								
								jQuery.ajax({
									type: "POST",
									url: "<?php echo base_url(); ?>backoffice/ajax/add_fee_receipts",
									data: { 
										"no" : no,
										"value" : value,
										"date" : date,
										"description" : description,
										"file" : file
									},
									success: function(result) 
									{
										if( result ) {
											$(".loading-overlay").hide();
											jQuery(document).trigger("add-alerts", [
											{
												"message": "Successfully",
												"priority": 'success'
											}
											])
										}
										else{
											$(".loading-overlay").hide();
											jQuery(document).trigger("add-alerts", [
											{
												"message": "Cant create fee receipt. Please try again later",
												"priority": 'error'
											}
											])
										}
									}
								});
							}
							else {
								$(".loading-overlay").hide();
								jQuery(document).trigger("add-alerts", [
								{
									"message": "Cant upload file. Please try again later",
									"priority": 'error'
								}
								])
							}
						}
					});
				}
				else {
					$(".loading-overlay").hide();
					jQuery(document).trigger("add-alerts", [
					{
						"message": "This document has been submited already",
						"priority": 'error'
					}
					])
				}
			}
		});
	} 
	else {
		alert(document.getElementById('example').validationMessage);
	}
	
}

$(document).ready(function() {
    $("#value").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl/cmd+A
            (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
             // Allow: Ctrl/cmd+C
            (e.keyCode == 67 && (e.ctrlKey === true || e.metaKey === true)) ||
             // Allow: Ctrl/cmd+X
            (e.keyCode == 88 && (e.ctrlKey === true || e.metaKey === true)) ||
             // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
})

</script>