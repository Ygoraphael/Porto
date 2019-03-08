<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<div class="page-head col-md-12">
	<div class="col-md-12 col-sm-12">
		<h2 class="col-md-6 col-sm-6"><?php echo $title; ?></h2>
		<?php if($acesso_resources_usase){?>
		<a href="<?php echo base_url() . "backoffice/extras_usage"; ?>" type="button" class="btn btn-info pull-right" style="margin-right:15px;">Resources Usage</a>
		<?php } ?>
	</div>
</div>
<div class="col-md-12 col-sm-12 clearfix" data-alerts="alerts" data-fade="3000"></div>
<div class="main-content col-sm-12">
	<div class="col-lg-12">
		<table id="tab-extras" class="table table-striped table-bordered" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th>ID</th>
					<th>Name</th>
					<th>Qtt</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			<?php
				$row = 1;
				foreach( $extras as $extra ) { ?>
				<tr>
					<td row="<?php echo $row; ?>"><?php echo trim(str_replace("R.".$user["no"].".", "", $extra["ref"])); ?></td>
					<td class="nopaddingmargin"><input type="text" class="form-control" value="<?php echo trim($extra["design"]); ?>"></td>
					<td class="nopaddingmargin"><input type="number" step="0.01" class="form-control" name="bo.u_qttmin" value="<?php echo number_format($extra["qtt"], 2, '.', ''); ?>"></td>
					<td class="text-center nopaddingmargin"><a href="#" onclick="delete_extra(jQuery(this)); return false;" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span></a></td>
				</tr>
			<?php
				$row++;
				}
			?>
			</tbody>
		</table>
		<button type="button" id="extra_add" class="btn btn-info btn-lg pull-left">ADD EXTRA</button>
		<button data-step-control="save" class="btn btn-info btn-lg pull-left">SAVE</button>
	</div>
</div>

<script>
	function delete_extra(obj) {
		bootbox.confirm("Do you really want to delete this extra?", function(result){ 
			if( result ) {
				$(".loading-overlay").show();
				var id = obj.parent().parent().children().eq(0).html();

				jQuery.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>backoffice/ajax/delete_extra",
					data: { 
						"id" : id
					},
					success: function(data) 
					{
						if( data ) {
							obj.parent().parent().remove();
							$(".loading-overlay").hide();
							jQuery(document).trigger("add-alerts", [
							{
								"message": "Extra deleted successfully",
								"priority": 'success'
							}
							]);
						}
						else {
							$(".loading-overlay").hide();
							jQuery(document).trigger("add-alerts", [
							{
								"message": "Error deleting extra",
								"priority": 'error'
							}
							]);
						}
					}
				});
			}
		});
	}
	
	jQuery('#extra_add').on( 'click', function () {
		var max_row = 0;
		jQuery( "#tab-extras tbody tr" ).each(function() {
			var row = parseFloat( jQuery(this).children().eq(0).attr("row") );
			
			if( row > max_row ) {
				max_row = row;
			}
		});
		max_row = max_row + 1;
		
		var row = '';
		row += '<tr>';
		row += '	<td row="'+max_row+'"></td>';
		row += '	<td class="nopaddingmargin"><input type="text" class="form-control" value=""></td>';
		row += '	<td class="nopaddingmargin"><input type="number" step="0.01" class="form-control" name="bo.u_qttmin" value="0.00"></td>';
		row += '	<td class="text-center nopaddingmargin"><a href="#" onclick="delete_extra(jQuery(this)); return false;" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span></a></td>';
		row += '</tr>';
		
		jQuery('#tab-extras tbody').append(row);
	});
	
	jQuery( "[data-step-control='save']" ).click(function() {
		$(".loading-overlay").show();
		//check if all extras have name
		var must_stop = 0;
		$('#tab-extras > tbody > tr').each(function() {
			if( jQuery(this).children().eq(1).find('input').val().toString().trim() == '' ) must_stop = 1;
		});
		if( must_stop ) {
			$(".loading-overlay").hide();
			jQuery(document).trigger("add-alerts", [
			{
				"message": "You have to fill the name in all extras",
				"priority": 'error'
			}
			]);
			return;
		}
		
		var extras = Array();

		jQuery( "#tab-extras tbody tr" ).each(function() {
			var extras_tmp = new Array();
			//row
			extras_tmp.push( jQuery(this).children().eq(0).attr("row") );
			//id
			extras_tmp.push( jQuery(this).children().eq(0).html() );
			//name
			extras_tmp.push( jQuery(this).children().eq(1).find("input").val() );
			//qtt
			extras_tmp.push( jQuery(this).children().eq(2).find("input").val() );
			
			extras.push( extras_tmp );
		});

		jQuery.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>backoffice/ajax/update_extras",
			data: { 
				"extras" : JSON.stringify( extras )
			},
			success: function(data) 
			{
				data = JSON.parse(data);
				
				//atualizar id
				data.forEach(function(entry) {
					jQuery( "#tab-extras tbody tr" ).each(function() {
						if( jQuery(this).children().eq(0).attr("row") == entry["row"] ) {
							jQuery(this).children().eq(0).html(entry["id"]);
						}
					});
				});
				
				$(".loading-overlay").hide();
				jQuery(document).trigger("add-alerts", [
				{
					"message": "Extras updated successfully",
					"priority": 'success'
				}
				]);
			}
		});
	});
</script>