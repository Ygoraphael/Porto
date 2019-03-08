<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<div class="page-head col-md-12">
	<div class="col-md-12 col-sm-12">
		<h2 class="col-md-6 col-sm-6"><?php echo $title; ?></h2>
		<button type="button" id="create_tax" class="btn btn-info pull-right">Create Tax/Fee</button>
	</div>
</div>
<div class="col-md-12 col-sm-12 clearfix" data-alerts="alerts" data-fade="3000"></div>
<div class="main-content col-sm-12">
	<table id="tab-users" class="table table-striped table-bordered" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th>Tax</th>
				<th>Description</th>
				<th>Value</th>
				<th>Formula</th>
				<th></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
		<?php foreach( $taxes as $tax ) {?>
			<tr>
				<td><?php echo $tax["tax"]; ?></td>
				<td><?php echo $tax["design"]; ?></td>
				<td><?php echo number_format($tax["value"], 2, '.', ''); ?></td>
				<td><?php echo $tax["formula"]; ?></td>
				<td class="text-center nopaddingmargin"><a href="#" stamp="<?php echo $tax["u_taxstamp"]; ?>" onclick="delete_tax(jQuery(this)); return false;" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span></a></td>
				<td class="text-center"><a href="<?php echo base_url(); ?>backoffice/tax/<?php echo $tax["u_taxstamp"]; ?>" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></a></td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
</div>
<script>
	jQuery("#create_tax").click(function() {
		bootbox.prompt("Enter new tax's name", function(result) {
			if( result ) {
				$(".loading-overlay").show();
				jQuery.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>backoffice/ajax/create_tax",
					data: { 
						"name" : result
					},
					success: function(data) 
					{
						data = JSON.parse(data);

						if( data['success'] == 1) {
							window.location.href = '<?php echo base_url(); ?>backoffice/tax/' + data['u_taxstamp'];
						}
						else {
							$(".loading-overlay").hide();
							jQuery(document).trigger("add-alerts", [
							{
								"message": "Error creating tax/fee",
								"priority": 'error'
							}
							]);
						}
					}
				});
			}
		});
	});
	
	function delete_tax( obj ) {
		bootbox.confirm("Do you really want to remove this tax?", function(result) {
			if( result ) {
				$(".loading-overlay").show();
				jQuery.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>backoffice/ajax/delete_tax",
					data: { 
						"stamp" : obj.attr("stamp")
					},
					success: function(data) 
					{
						if( data == 1 ) {
							location.replace('<?php echo base_url(); ?>backoffice/settings_taxes');
						}
						else {
							$(".loading-overlay").hide();
							jQuery(document).trigger("add-alerts", [
							{
								"message": "Error removing this tax!",
								"priority": 'error'
							}
							]);
						}
					}
				});
			}
		});
	};
</script>