<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<div class="clearfix page-head col-md-12">
	<div class="col-md-12 col-sm-12">
		<h2 class="col-md-6 col-sm-6"><?php echo $title; ?></h2>
		<?php if($acesso_create){?>
		<button type="button" id="create_prod" class="btn btn-info pull-right">Create product</button>
		<?php } ?>
	</div>
</div>
<div class="col-md-12 col-sm-12 clearfix" data-alerts="alerts" data-fade="3000"></div>
<div class="main-content col-sm-12">
	<div class="col-lg-12">
		<table id="tab-products" class="table table-striped table-bordered" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th>Code</th>
					<th>Name</th>
					<th>City</th>
					<th>Country</th>
					<th>Adv. Price</th>
					<th>Status</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			<?php foreach( $products as $product ) {?>
				<tr>
					<td><?php echo $product["u_uniqcode"]; ?></td>
					<td><?php echo $product["u_name"]; ?></td>
					<td><?php echo $product["u_city"]; ?></td>
					<td><?php echo $product["u_country"]; ?></td>
					<td><?php echo $product["u_advprice"]; ?></td>
					<td>Approved</td>
					<td class="text-center"><a href="<?php echo base_url(); ?>backoffice/product/<?php echo $product["u_sefurl"]; ?>" class="btn btn-default <?php echo ($acesso_view)?"":"disabled" ?>"><span class="glyphicon glyphicon-search"></span></a></td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
		<script>
			jQuery(document).ready(function() {
				jQuery('#tab-products').DataTable();
			});
			
			jQuery("#create_prod").click(function() {
				bootbox.prompt("Enter product's name", function(result) {
					if( result ) {
						$(".loading-overlay").show();
						jQuery.ajax({
							type: "POST",
							url: "<?php echo base_url(); ?>backoffice/ajax/create_product",
							data: { 
								"name" : result
							},
							success: function(data) 
							{
								data = JSON.parse(data);
								
								if( data['success'] ) {
									window.location.href = '<?php echo base_url(); ?>backoffice/product/'+data['sefurl'];
								}
								else {
									$(".loading-overlay").hide();
									jQuery(document).trigger("add-alerts", [
									{
										"message": "Error creating product",
										"priority": 'error'
									}
									]);
								}
							}
						});
					}
				});
			});
		</script>
	</div>
</div>