<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<div class="clearfix page-head col-md-12">
	<div class="col-md-12 col-sm-12">
		<h2 class="col-md-6 col-sm-6"><?php echo $this->translation->Translation_key($title, $_SESSION['lang_u']); ?></h2>
	</div>
</div>
<div class="col-md-12 col-sm-12 clearfix" data-alerts="alerts" data-fade="3000"></div>
<div class="main-content col-sm-12">
	<div class="col-lg-12">
		<style>
			th.dt-center, td.dt-center { 
				text-align: center; 
			}
		</style>
		<table id="tab-lastminute" class="table table-striped table-bordered" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th><?php echo $this->translation->Translation_key("Order", $_SESSION['lang_u']); ?></th>
					<th><?php echo $this->translation->Translation_key("Product", $_SESSION['lang_u']); ?></th>
					<th><?php echo $this->translation->Translation_key("Tax", $_SESSION['lang_u']); ?></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			<?php
				$cur_id = 1;
				foreach( $lastminute as $lastmin ) { 
			?>
				<tr>
					<td stamp="<?php echo $lastmin["u_lastminutestamp"]; ?>"><?php echo $cur_id; ?></td>
					<td>
						<select class='form-control' style='min-width: 100%'>
							<?php foreach( $products as $product ) { ?>
								<option <?php echo ($lastmin["bostamp"] == $product["bostamp"]) ? "selected" : ""; ?> value='<?php echo $product["bostamp"]; ?>'><?php echo $product["u_name"]; ?></option>
							<?php } ?>
						</select>
					</td>
					<td>
						<select class='form-control' style='min-width: 100%'>
							<option></option>
							<?php 
								foreach( $taxes as $tax ) { 
									if( $tax["formula"] == '-%' || $tax["formula"] == '-v' ) {
							?>
								<option <?php echo ($lastmin["u_taxstamp"] == $tax["u_taxstamp"]) ? "selected" : ""; ?> value='<?php echo $tax["u_taxstamp"]; ?>'><?php echo $tax["tax"]; ?></option>
							<?php 	} 
								}
							?>
						</select>
					</td>
					<td><a href="#" class="btn btn-default"><span onclick="delete_lastminute(jQuery(this)); return false;" class="glyphicon glyphicon-remove"></span></a></td>
				</tr>
			<?php
					$cur_id++;
				} 
			?>
			</tbody>
		</table>
		<button type="button" id="lastminute_add" class="btn btn-info btn-lg pull-left"><?php echo $this->translation->Translation_key("ADD LASTMINUTE", $_SESSION['lang_u']); ?></button>
		<button data-step-control="save" class="btn btn-info btn-lg pull-left"><?php echo $this->translation->Translation_key("SAVE", $_SESSION['lang_u']); ?></button>
		<script>
			var s_t;
			jQuery(document).ready(function() {
				s_t = jQuery('#tab-lastminute').DataTable({
					rowReorder: true,
					responsive: true,
					"paging": false,
					"searching": false,
					"columnDefs": [
						{"className": "dt-center", "targets": "_all"}
					]
				});
			});
						
			var select_products = "<select class='form-control' style='min-width: 100%'>";
			<?php foreach( $products as $product ) { ?>
				select_products += "<option value='<?php echo $product["bostamp"]; ?>'><?php echo str_replace("'", "\'", str_replace('"', '\"', $product["u_name"])); ?></option>";
			<?php } ?>
			select_products += "</select>";
			
			var select_taxes = "<select class='form-control' style='min-width: 100%'>";
			select_taxes += "<option></option>";
			<?php foreach( $taxes as $tax ) { ?>
				select_taxes += "<option value='<?php echo $tax["u_taxstamp"]; ?>'><?php echo $tax["tax"]; ?></option>";
			<?php } ?>
			select_taxes += "</select>";
			
			jQuery('#lastminute_add').on( 'click', function () {
				var max_id = 0;
				
				s_t.rows().every( function ( rowIdx, tableLoop, rowLoop ) {
					var data = this.data();
					var id = parseFloat(data[0]);
					if( id > max_id ) {
						max_id = id;
					}
				});
				
				s_t.row.add( [
					max_id+1,
					select_products,
					select_taxes,
					'<a href="#" class="btn btn-default"><span onclick="delete_lastminute(jQuery(this)); return false;" class="glyphicon glyphicon-remove"></span></a>'
				] ).draw( false );
			});
			
			function delete_lastminute( obj ) {
				obj.parent().parent().parent().addClass("selected_row");
				s_t.row('.selected_row').remove().draw( false );
			}
			
			function save() {
				$(".loading-overlay").show();
				
				var lastmin = new Array();
				var lorder = 0;
				
				$('#tab-lastminute tbody tr').each(function() {
					if( $(this).find(".dataTables_empty").length == 0 ) {
						var lastmin_tmp = {};
						lastmin_tmp["lorder"] = lorder;
						lastmin_tmp["bostamp"] = $(this).children().eq(1).find("select").val();
						lastmin_tmp["u_taxstamp"] = $(this).children().eq(2).find("select").val();
						lastmin.push(lastmin_tmp);
						lorder++;
					}
				});

				var rep_found = 0;
				var rep_name = 0;
				
				//check repetition
				$('#tab-lastminute tbody tr').each(function() {
					if( $(this).find(".dataTables_empty").length == 0 ) {
						var parent_bostamp = $(this).children().eq(1).find("select").val();
						var parent_stamp = $(this).children().eq(0).attr("stamp");
						
						$('#tab-lastminute tbody tr').each(function() {
							var child_bostamp = $(this).children().eq(1).find("select").val();
							var child_stamp = $(this).children().eq(0).attr("stamp");
							var child_name = $(this).children().eq(1).find("select option:selected").text();
							
							if( parent_bostamp == child_bostamp && parent_stamp != child_stamp ) {
								$(".loading-overlay").hide();
								
								rep_found = 1;
								rep_name = child_name;
							}
						});
					}
				});
				
				if( rep_found ) {
					bootbox.alert("Product '" + rep_name + "' is selected more than once!");
				}
				else {
					jQuery.ajax({
						type: "POST",
						url: "<?php echo base_url(); ?>backoffice/ajax/create_lastminute",
						data: {
							"lastmin" : JSON.stringify(lastmin)
						},
						success: function(data) 
						{
							if( data == 1) {
								$(".loading-overlay").hide();
								jQuery(document).trigger("add-alerts", [
								{
									"message": "Product Order / Last Minute updated successfully",
									"priority": 'success'
								}
								]);
							}
							else {
								$(".loading-overlay").hide();
								jQuery(document).trigger("add-alerts", [
								{
									"message": "Error updating product order / last minute",
									"priority": 'error'
								}
								]);
							}
						}
					});
				}
			}
			
			jQuery( "[data-step-control='save']" ).click(function() {
				save();
			});
		</script>
	</div>
</div>