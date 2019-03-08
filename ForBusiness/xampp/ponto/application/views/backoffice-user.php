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
<div class="col-md-12 col-sm-12 clearfix" data-alerts="alerts" data-fade="3000"></div>
<div class="main-content col-lg-12 col-sm-12">
	<div class="col-lg-6 col-sm-12">
		<form action="#" class="form-horizontal group-border-dashed clearfix">
			<div class="form-group">
				<label class="col-lg-2 col-sm-3 col-md-2 col-xs-12 control-label">Name</label>
				<div class="input-group col-lg-8 col-sm-3 col-md-3 col-xs-12" style="margin-right:10px">
					<input type="text" class="form-control" name="fl.nome" value="<?php echo $user_data["nome"]; ?>" >
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-2 col-sm-3 col-md-2 col-xs-12 control-label">Nº</label>
				<div class="input-group col-lg-8 col-sm-3 col-md-3  col-xs-12" style="margin-right:10px">
					<input type="text" class="form-control" id="estab" value="<?php echo $user_data["estab"]; ?>" readonly="">
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-2 col-sm-3 col-md-2 col-xs-12 control-label">Address</label>
				<div class="input-group col-lg-8 col-sm-3 col-md-3  col-xs-12" style="margin-right:10px">
					<input type="text" class="form-control" name="fl.morada" value="<?php echo $user_data["morada"]; ?>" >
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-2 col-sm-3 col-md-2 col-xs-12 control-label">Postal Code</label>
				<div class="input-group col-lg-8 col-sm-3 col-md-3  col-xs-12" style="margin-right:10px">
					<input type="text" class="form-control" name="fl.codpost" value="<?php echo $user_data["codpost"]; ?>" >
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-2 col-sm-3 col-md-2 col-xs-12 control-label">City</label>
				<div class="input-group col-lg-8 col-sm-3 col-md-3  col-xs-12" style="margin-right:10px">
					<input type="text" class="form-control" name="fl.local" value="<?php echo $user_data["local"]; ?>" >
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-2 col-sm-3 col-md-2 col-xs-12 control-label">Phone</label>
				<div class="input-group col-lg-8 col-sm-3 col-md-3  col-xs-12" style="margin-right:10px">
					<input type="text" class="form-control" name="fl.telefone" value="<?php echo $user_data["telefone"]; ?>" >
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-2 col-sm-3 col-md-2 col-xs-12 control-label">Email</label>
				<div class="input-group col-lg-8 col-sm-3 col-md-3  col-xs-12" style="margin-right:10px">
					<input type="text" class="form-control" name="fl.email" value="<?php echo $user_data["email"]; ?>" >
				</div>
			</div>
			<div class="form-group">
				<label class="col-lg-2 col-sm-3 col-md-2 col-xs-12 control-label">Password (login)</label>
				<div class="input-group col-lg-8 col-sm-3 col-md-3  col-xs-12" style="margin-right:10px">
					<input type="text" class="form-control" id="user_pw" name="fl.u_pass" value="<?php echo $user_data["u_pass"]; ?>" >
					<a onclick="jQuery('#user_pw').val(Math.random().toString(36).slice(-8)); return false;" class="form-control btn btn-primary">Generate Random Password</a>
				</div>
			</div>
		</form>
	</div>
	<div class="col-lg-6 col-sm-12">
		<table id="tab-access" class="table table-striped table-bordered col-lg-12 col-sm-12" cellspacing="0" >
			<thead>
				<tr>
					<th>Group</th>
					<th>Permission</th>
					<th>Access</th>
				</tr>
			</thead>
			<tbody>
			<?php 
				$groups = array();
				foreach( $access_list as $access ) {?>
				<tr>
					<td style="width:150px"><b><?php echo ( !in_array($access["group"], $groups) ) ? $access["group"] : ""; ?></b></td>
					<td><?php echo $access["permission"]; ?></td>
					<td class="nopaddingmargin">
						<div class="am-checkbox" style="text-align: -webkit-center;">
							<input type="checkbox" id="<?php echo $access["u_accessstamp"]; ?>" <?php echo ( $access["access"] == 1 ) ? "checked=''" : "" ?>>
							<label for="<?php echo $access["u_accessstamp"]; ?>"></label>									
						</div>
					</td>
				</tr>
			<?php 
				if( !in_array($access["group"], $groups) )
					$groups[] = $access["group"];
				} ?>
			</tbody>
		</table>
	</div>
</div>
<script>
	jQuery( "#save" ).click(function() {
		$(".loading-overlay").show();
		
		var access_list = Array();

		jQuery( "#tab-access tbody tr" ).each(function() {
			var access_tmp = new Array();
			access_tmp.push( jQuery(this).children().eq(2).find("input").attr("id") );
			if( jQuery(this).children().eq(2).find("input").is(':checked') )
				access_tmp.push( 1 );
			else
				access_tmp.push( 0 );
			
			access_list.push( access_tmp );
		});

		jQuery.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>backoffice/ajax/update_user",
			data: { 
				"access" : JSON.stringify( access_list ),
				"input" : JSON.stringify(jQuery("form").serializeToJSON()),
				"estab" : <?php echo $user_data["estab"]; ?>
			},
			success: function(data) 
			{
				data = JSON.parse(data);

				if( data['success'] == 1) {
					$(".loading-overlay").hide();
					jQuery(document).trigger("add-alerts", [
					{
						"message": "User updated successfully",
						"priority": 'success'
					}
					]);
				}
				else {
					$(".loading-overlay").hide();
					jQuery(document).trigger("add-alerts", [
					{
						"message": "Error updating user",
						"priority": 'error'
					}
					]);
				}
			}
		});
	});
</script>