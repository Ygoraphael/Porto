<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<div class="clearfix page-head col-md-12">
	<div class="col-md-12 col-sm-12">
		<h2 class="col-md-6 col-sm-6"><?php echo $this->translation->Translation_key($title, $_SESSION['lang_u']); ?></h2>
		<a onclick="window.history.back(); return false;" type="button" class="btn btn-primary pull-right"	style="margin-right:15px;"><span class="glyphicon glyphicon-chevron-left"></span><?php echo $this->translation->Translation_key("VAT", $_SESSION['lang_u']); ?> BACK</a>
		<a onclick="delete_vouch(); return false;" type="button" class="btn btn-default pull-right"	style="margin-right:15px;"><span class="glyphicon glyphicon-trash"></span><?php echo $this->translation->Translation_key("VAT", $_SESSION['lang_u']); ?> DELETE</a>
	</div>
</div>
<div class="col-md-12 col-sm-12 clearfix" data-alerts="alerts" data-fade="3000"></div>
<div class="main-content col-sm-12">
	<form data-toggle="validator" role="form" action="#" style="border-radius: 0px;" class="form-horizontal group-border-dashed clearfix" novalidate="true">
		<div class="col-lg-12">
			<div class="col-lg-6">
			<div class="row setup-content">
				<div class="col-md-12 well text-center" id="details" >
						<span>
							<h3><?php echo $this->translation->Translation_key("DETAILS", $_SESSION['lang_u']); ?></h3>
							<div class="form-group">
								<label class="col-lg-2 col-sm-3 control-label"><?php echo $this->translation->Translation_key("Code", $_SESSION['lang_u']); ?></label>
								<div class="input-group col-lg-8 col-sm-6">
									<input type="text" class="form-control" data-limit="true" maxlength="180" id="code" name="u_vouch.code" value="<?php echo $voucher['code']; ?>"required="">
									<span class="char-counter" data-limit-holder="code"></span>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 col-sm-3 control-label"><?php echo $this->translation->Translation_key("Description", $_SESSION['lang_u']); ?></label>
								<div class="input-group col-lg-8 col-sm-6">
									<input type="text" class="form-control" data-limit="true" maxlength="60" id="design" name="u_vouch.design" value="<?php echo $voucher['design']; ?>">
									<span class="char-counter" data-limit-holder="design"></span>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 col-sm-3 control-label"><?php echo $this->translation->Translation_key("Type", $_SESSION['lang_u']); ?></label>
								<div class="input-group col-lg-8 col-sm-6">
									<?php $types = array("- %", "- V");?>
									<select class="form-control" id="type" name="u_vouch.type" required>
										<option value="" ></option>
										<?php foreach($types as $type){ ?>
											<option value="<?php echo $type; ?>" <?php echo ($type == $voucher['type'])? "selected" : ""; ?> ><?php echo $type; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 col-sm-3 control-label"><?php echo $this->translation->Translation_key("Value", $_SESSION['lang_u']); ?></label>
								<div class="input-group col-lg-8 col-sm-6">
									<input type="number" step="0.01" class="form-control" data-limit="true" maxlength="180" id="value" name="u_vouch.value" value="<?php echo number_format($voucher["value"], 2, '.', ''); ?>" required="">
									<span class="char-counter" data-limit-holder="value"></span>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 col-sm-3 control-label">Qtt Use</label>
								<div class="input-group col-lg-8 col-sm-6">
									<input type="number" step="1" class="form-control" data-limit="true" maxlength="180" id="useqtt" name="u_vouch.useqtt" value="<?php echo $voucher['useqtt']; ?>" required="">
									<span class="char-counter" data-limit-holder="useqtt"></span>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 col-sm-3 control-label"><?php echo $this->translation->Translation_key("Validity", $_SESSION['lang_u']); ?></label>
								<div class="input-group col-lg-8 col-sm-6">
									<input type="date" class="form-control" data-limit="true" maxlength="180" id="validity" name="u_vouch.validity" value="<?php echo substr($voucher['validity'], 0, 10); ?>" required="">
									<span class="char-counter" data-limit-holder="validity"></span>
								</div>
							</div>
						</span>
					</div>
				</div>
				<button data-step-control="save" class="btn btn-info btn-lg pull-left"><?php echo $this->translation->Translation_key("SAVE VOUCHER", $_SESSION['lang_u']); ?></button>
				<p style="margin-bottom:50px"></p>
			</div>
			<div class="col-lg-6" >
				<div class="col-md-12 well text-center" id="products">
					<span>
						<h3>Products</h3>
						<table id="vouch_table" class="table table-striped table-bordered" cellspacing="0" width="100%">
							<thead>
							<td>
							</td>
							<td>
								<input type="checkbox" id="select_all">
							</td>
							</thead>
							<tbody>
								<?php
								$row = 1;
								$variable = false;									
								foreach( $products as $product ) { ?>
									<tr>
										<td stamp="<?php echo $product['bostamp']; ?>" row="<?php echo $row; ?>"><?php echo $product['u_name']; ?></td>
										<?php 
										foreach( $pvoucher as $pv ) { 
											if($pv["bostamp"] == $product['bostamp']){ 
												$variable = true;
											}
										}
										?>
										<td row="<?php echo $row; ?>"><input type="checkbox" <?php echo ($variable)? "checked":""; ?> ></td>
									</tr>
								<?php
								$variable = false;
								$row++;
								}
								?>
							</tbody>
						</table>
					</span>
				</div>
			</div>
		</div>
	</form>
</div>

<script>
	var details_height= 0;
	details_height= $( '#details' ).height();
	$( '#products' ).height( details_height ).css({
		    overflow: "auto",
	});
	jQuery('form').validator().on('submit', function (e) {
		if (e.isDefaultPrevented()) {
			// handle the invalid form...
		} else {
			e.preventDefault();
			$(".loading-overlay").show();
			
			var vouch_table = Array();

			jQuery( "#vouch_table tbody tr" ).each(function() {
				var vouch_num_table_tmp = new Array();
				
				//stamp
				var attr = jQuery(this).children().eq(0).attr("stamp");
				if (typeof attr !== typeof undefined && attr !== false) {
					vouch_num_table_tmp.push( jQuery(this).children().eq(0).attr("stamp") );
				}
				else {
					vouch_num_table_tmp.push( '' );
				}
				//is selected
				var selected = "0";
				if( jQuery(this).children().eq(1).find("input").is(":checked")){
					selected = "1";
				}else{
					selected = "0";
				}
				vouch_num_table_tmp.push( selected );
				
				//row id
				var row = jQuery(this).children().eq(0).attr("row");
				vouch_num_table_tmp.push( row );
				
				vouch_table.push( vouch_num_table_tmp );
			});
			
			jQuery.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>backoffice/ajax/update_vouch",
				data: { 
					"input" : JSON.stringify(jQuery("form").serializeToJSON()),
					"stamp" : "<?php echo $voucher['u_vouchstamp'];?>",
					"vouch_table" : JSON.stringify( vouch_table )
				},
				success: function(data) 
				{
					$(".loading-overlay").hide();
						jQuery(document).trigger("add-alerts", [
						{
							"message": "Voucher updated successfully",
							"priority": 'success'
						}
						]);
				}
			});
			
			
			
		}
	});
	
	var datevalidity = "<?php echo substr($voucher['validity'], 0, 10);?>";
	var atualdate = new Date($.now()).toISOString().substr(0, 10);
	
	//apagar voucher
	function delete_vouch(){
		bootbox.confirm({
			message: "Do you really want to delete this voucher with your account? This procedure is irreversible!",
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
					if( datevalidity >= atualdate) {
						bootbox.confirm({
							message: "The date of this voucher is still valid, are you sure?",
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
							callback: function (result3) {
								if( result3 ) {
									delete_function();
								}
							}
						});	
					}else{
						delete_function();
					}
				}
			}
		});			
	}
	
	
	function delete_function(){
			
			$(".loading-overlay").show();
			
			var vouch_table = Array();

			jQuery( "#vouch_table tbody tr" ).each(function() {
				var vouch_num_table_tmp = new Array();
				
				//stamp
				var attr = jQuery(this).children().eq(0).attr("stamp");
				if (typeof attr !== typeof undefined && attr !== false) {
					vouch_num_table_tmp.push( jQuery(this).children().eq(0).attr("stamp") );
				}
				else {
					vouch_num_table_tmp.push( '' );
				}
				//is selected
				var selected = "0";
				if( jQuery(this).children().eq(1).find("input").is(":checked")){
					selected = "1";
				}else{
					selected = "0";
				}
				vouch_num_table_tmp.push( selected );
				
				//row id
				var row = jQuery(this).children().eq(0).attr("row");
				vouch_num_table_tmp.push( row );
				
				vouch_table.push( vouch_num_table_tmp );
			});
			
			jQuery.ajax({
				type: "POST",
				url: "<?php echo base_url(); ?>backoffice/ajax/delete_vouch",
				data: { 
					"stamp" : "<?php echo $voucher['u_vouchstamp'];?>",
					"vouch_table" : JSON.stringify( vouch_table )
				},
				success: function(data) 
				{
					$(".loading-overlay").hide();
						jQuery(document).trigger("add-alerts", [
						{
							"message": "Voucher Delete successfully",
							"priority": 'success'
						}
						]);
						window.location.href = '<?php echo base_url(); ?>backoffice/vouchers';
				}
			});
			
	}
	$('#select_all').change(function() {
		var checkboxes = $(this).closest('form').find(':checkbox');
		if($(this).is(':checked')) {
			checkboxes.prop('checked', true);
		} else {
			checkboxes.prop('checked', false);
		}
	});
	
</script>
