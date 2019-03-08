<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
		<div class="page-head col-md-12">
			<div class="col-md-12 col-sm-12">
				<h2 class="col-md-6 col-sm-6 col-xs-6"><?php echo $this->translation->Translation_key($title, $_SESSION['lang_u']); ?></h2>
				<a onclick="window.history.back(); return false;" type="button" class="btn btn-primary pull-right"	style="margin-right:15px;"><span class="glyphicon glyphicon-chevron-left"></span><?php echo $this->translation->Translation_key("BACK", $_SESSION['lang_u']); ?> </a>
			</div>
		</div>
		<p style="margin-bottom:5px"></p>
		<div class="clearfix" data-alerts="alerts" data-fade="3000"></div>
		<div class="main-content col-sm-12 col-md-12 col-xs-12">
			<div class="panel panel-default">
				<div class="container" style="max-width:500px;">
					<div class="col-sm-12 col-md-12 col-xs-12" style="max-width:500px;">
						<form action="#" class="form-horizontal group-border-dashed clearfix mescontent" >
							<div class="form-group text-center">
								<label class=""><?php echo $this->translation->Translation_key("ORDER TOTAL", $_SESSION['lang_u']); ?></label>
								<input type="text" class="form-control text-center" id="" value="<?php echo number_format($order_data['etotal'], 2, '.', ''); ?>" readonly>
							</div>
							<div class="form-group text-center">
								<label class=""><?php echo $this->translation->Translation_key("PAID AMOUNT", $_SESSION['lang_u']); ?></label>
								<input type="text" class="form-control text-center" id="" value="<?php echo number_format($order_data['u_etotalp'], 2, '.', ''); ?>" readonly>
							</div>
							<div class="form-group text-center">
								<label class=""><?php echo $this->translation->Translation_key("MISSING AMOUNT", $_SESSION['lang_u']); ?></label>
								<input type="text" class="form-control text-center" id="" value="<?php echo number_format(floatval($order_data['etotal']) - floatval($order_data['u_etotalp']), 2, '.', ''); ?>" readonly>
							</div>
							<div class="form-group text-center" style="margin-bottom:0; padding-bottom:0;">
								<label class=""><?php echo $this->translation->Translation_key("ISSUE INVOICE", $_SESSION['lang_u']); ?></label>
							</div>
							<div class="form-group text-center" style="margin-top:0; padding-top:0;">
								<input type="checkbox" id="issue_invoice" checked data-toggle="toggle">
							</div>
							<div class="form-group text-center" style="margin-top:0; padding-top:0;">
								<small><?php echo $this->translation->Translation_key("Invoice will be send to customer's email", $_SESSION['lang_u']); ?></small>
							</div>
							<div class="form-group text-center">
								<button type="button" onclick="process_payment(); return false;" class="btn btn-primary col-lg-12"><?php echo $this->translation->Translation_key("PROCESS PAYMENT", $_SESSION['lang_u']); ?></button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	function process_payment() {
		bootbox.confirm("Process this payment?", function(result) {
			if( result ) {
				$(".loading-overlay").show();
				
				var bostamp = '<?php echo $order_data['bostamp'];?>';
				if( $('#issue_invoice').prop('checked') ) {
					var issue_invoice = 1;
				}
				else {
					var issue_invoice = 0;
				}
				
				jQuery.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>backoffice/ajax/process_payment_partial",
					data: { 
						"bostamp" : bostamp,
						"issue_invoice" : issue_invoice
					},
					success: function(data) 
					{
						if( data ) {
							var text = '';
							text += '<div class="form-group text-center">';
							text += '	<label class=""><h2>Payment processed successfully</h2></label>';
							text += '</div>';
							
							jQuery(".mescontent").html( text );
							$(".loading-overlay").hide();
						}
						else {
							$(".loading-overlay").hide();
							jQuery(document).trigger("add-alerts", [
							{
								"message": "Error processing payment",
								"priority": 'error'
							}
							]);
						}
					}
				});
			}
		});
	}
</script>