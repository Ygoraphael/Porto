<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<div class="page-head col-md-12">
	<div class="col-md-12 col-sm-12">
		<h2 class="col-md-6 col-sm-6"><?php echo $title; ?></h2>
	</div>
</div>
<div class="main-content col-sm-12">
	<div class="col-lg-12">
		<div class="row setup-content" id="step-1">
			<div class="col-xs-12">
				<div class="col-md-12 well text-center">
					<form data-toggle="validator" role="form" action="#" style="border-radius: 0px;" class="form-horizontal group-border-dashed">
						<span>
							<h3>PRODUCT PRICING</h3>
							<?php if( sizeof($u_pseat) ) { ?>
							<table id="pricing_table" class="table table-striped table-bordered" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th>Seat</th>
										<?php foreach( $u_ptick as $ticket ) { ?>
											<th><?php echo $ticket["name"] ?></th>
										<?php } ?>
									</tr>
								</thead>
								<tbody>
								<?php foreach( $u_pseat as $seat ) { ?>
									<tr>
								<td stamp="<?php echo $seat["seat"]; ?>"><?php echo $seat["seat"]; ?></td>
										<?php foreach( $u_ptick as $ticket ) {
												$value = 0;
												foreach( $prices as $price ) { 
													if( trim($price["cor"]) == trim($seat["seat"]) && trim($price["tam"]) == trim($ticket["ticket"]) )
														$value = number_format($price["epv1"], 2, '.', '');
												}
										?>
											<td><input type="number" step="0.01" cor="<?php echo trim($seat["seat"]); ?>" tam="<?php echo trim($ticket["ticket"]); ?>" class="form-control" value="<?php echo $value; ?>"></td>
										<?php } ?>
									</tr>
								<?php } ?>
								</tbody>
							</table>
							<?php } 
							else {
							?>
							<table id="pricing_table" class="table table-striped table-bordered" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th></th>
										<?php foreach( $u_ptick as $ticket ) { ?>
											<th><?php echo $ticket["name"] ?></th>
										<?php } ?>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td stamp="<?php echo ''; ?>">ND</td>
										<?php foreach( $u_ptick as $ticket ) {
												$value = 0;
												foreach( $prices as $price ) { 
													if( trim($price["cor"]) == 'ND' && trim($price["tam"]) == trim($ticket["ticket"]) )
														$value = number_format($price["epv1"], 2, '.', '');
												}
										?>
										<td><input type="number" step="0.01" cor="ND" tam="<?php echo trim($ticket["ticket"]); ?>" class="form-control" value="<?php echo $value; ?>"></td>
										<?php } ?>
									</tr>
								</tbody>
							</table>
							<?php } ?>
						</span>
					</form>
					<p style="margin-bottom:50px"></p>
					<div data-alerts="alerts" data-fade="3000"></div>
					<button onclick="location.replace(document.referrer);" class="btn btn-primary btn-lg pull-left"><span class="glyphicon glyphicon-chevron-left"></span> BACK</button>
					<button data-step-control="save"  class="btn btn-info btn-lg pull-left">SAVE PRICES</button>
				</div>
			</div>
		</div>
	</div>
	<script>
		function initialize() {
			jQuery('form').validator();
		}
		
		jQuery( document ).ready(function() {
			initialize();
		});
				
		jQuery('form').validator().on('submit', function (e) {
			if (e.isDefaultPrevented()) {
				// handle the invalid form...
			} else {
				e.preventDefault();
				
				var price_table = Array();
				
				jQuery( "#pricing_table tbody tr td input" ).each(function() {
					var price_table_tmp = Array();
					price_table_tmp.push( jQuery(this).attr("cor") );
					price_table_tmp.push( jQuery(this).attr("tam") );
					price_table_tmp.push( jQuery(this).val() );
					price_table.push( price_table_tmp );
				});
				
				jQuery.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>backoffice/ajax/update_product_price",
					data: { 
						"ref" : "<?php echo "P." . $product["obrano"] . "." . $price_id; ?>",
						"prices" : JSON.stringify(price_table)
					},
					success: function(data) 
					{
						data = JSON.parse(data);
						
						if( data["success"] ) {
							jQuery(document).trigger("add-alerts", [
							{
								"message": data["message"],
								"priority": 'success'
							}
							]);
						}
						else {
							jQuery(document).trigger("add-alerts", [
							{
								"message": data["message"],
								"priority": 'error'
							}
							]);
						}
					}
				});
			}
		})
		
		jQuery( "[data-step-control='save']" ).click(function() {
			jQuery("form").submit();
		});
	</script>
</div>