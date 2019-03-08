<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>

<div class="col-lg-12">
	<div data-alerts="alerts" data-titles="" data-ids="myid" data-fade="3000"></div>
	<legend>Checkout</legend>
	<div class="col-lg-12">
		<div class="row bs-wizard" style="border-bottom:0;">
		<?php if( $_SESSION['type'] == 'client' ) { ?>
			<div class="col-xs-6 bs-wizard-step complete">
				<div class="text-center bs-wizard-stepnum">Step 1</div>
				<div class="progress"><div class="progress-bar"></div></div>
				<a href="#" class="bs-wizard-dot"></a>
				<div class="bs-wizard-info text-center">Payment</div>
			</div>
			<div class="col-xs-6 bs-wizard-step disabled">
				<div class="text-center bs-wizard-stepnum">Step 2</div>
				<div class="progress"><div class="progress-bar"></div></div>
				<a href="#" class="bs-wizard-dot"></a>
				<div class="bs-wizard-info text-center">Confirmation</div>
			</div>
		<?php } 
			else if( $_SESSION['type'] == 'agent' ) { ?>
			<div class="col-xs-4 bs-wizard-step complete">
				<div class="text-center bs-wizard-stepnum">Step 1</div>
				<div class="progress"><div class="progress-bar"></div></div>
				<a href="#" class="bs-wizard-dot"></a>
				<div class="bs-wizard-info text-center">Client Data</div>
			</div>
			<div class="col-xs-4 bs-wizard-step disabled">
				<div class="text-center bs-wizard-stepnum">Step 2</div>
				<div class="progress"><div class="progress-bar"></div></div>
				<a href="#" class="bs-wizard-dot"></a>
				<div class="bs-wizard-info text-center">Payment</div>
			</div>
			<div class="col-xs-4 bs-wizard-step disabled">
				<div class="text-center bs-wizard-stepnum">Step 3</div>
				<div class="progress"><div class="progress-bar"></div></div>
				<a href="#" class="bs-wizard-dot"></a>
				<div class="bs-wizard-info text-center">Confirmation</div>
			</div>
		<?php } ?>
		</div>
	</div>
	<div class="col-lg-12">
		<?php if( $_SESSION['type'] == 'agent' ) { ?>
		<div class="row rowStep1">
			<div class="checkoutCont">
				<div class="headingWrap">
					<h3 class="headingTop text-center">Insert Client Personal Data</h3>	
				</div>
				<form id='client_data_form' data-toggle="validator" role="form">
					<div class="form-group">
						<label for="client_name">Name</label>
						<input type="text" class="form-control" id="client_name" placeholder="Name">
					</div>
					<div class="form-group">
						<label for="client_address">Address</label>
						<input type="text" class="form-control" id="client_address" placeholder="Address">
					</div>
					<div class="form-group">
						<label for="client_postcode">Post Code</label>
						<input type="text" class="form-control" id="client_postcode" placeholder="Post Code">
					</div>
					<div class="form-group">
						<label for="client_city">City</label>
						<input type="text" class="form-control" id="client_city" placeholder="City">
					</div>
					<div class="form-group">
						<label for="client_country">Country</label>
						<select id="client_country" name="client_country" class="input-medium bfh-countries form-control input-md" data-country="PT"></select>
					</div>
					<div class="form-group">
						<label for="client_vat">Tax identification number</label>
						<input type="text" class="form-control" id="client_vat" placeholder="Tax identification number">
					</div>
					<div class="form-group">
						<label for="client_email">Email address</label>
						<input type="email" class="form-control" id="client_email" required placeholder="Email address">
					</div>
				</form>
			</div>
		</div>
		<?php } ?>
		
		<?php if( $_SESSION['type'] == 'agent' ) { ?>
		<div class="row rowStep2 hidden">
		<?php } ?>
		<?php if( $_SESSION['type'] == 'client' ) { ?>
		<div class="row rowStep1">
		<?php } ?>
			<div class="checkoutCont">
				<div class="headingWrap">
					<h3 class="headingTop text-center">Select Your Payment Method</h3>	
				</div>
				<div class="checkoutWrap">
					<div class="btn-group checkoutBtnGroup btn-group-justified" data-toggle="buttons">
					<?php
						$active = "active";
						$def_payment_id = "";
						foreach( $PaymentMethods as $PaymentMethod ) {
							if( $def_payment_id == "" )
								$def_payment_id = $PaymentMethod["id"];
					?>
						<div class="col-lg-12 nomarginpadding">
							<div class="col-lg-2 centered">
								<label payment_id="<?php echo $PaymentMethod["id"]; ?>" class="btn paymentMethod <?php echo $active; ?>">
									<div class="method" style="background-image: url('<?php echo base_url() .$PaymentMethod["img_path"]; ?>'); max-width:100%;"></div>
									<input type="radio" name="payment_method" value="<?php echo $PaymentMethod["id"]; ?>" checked> 
								</label>
							</div>
							<div class="col-lg-10 text-left nomarginpadding">
								<div class="col-lg-12 text-left PaymentName nomarginpadding">
									<b><?php echo $PaymentMethod["name"]; ?></b>
								</div>
								<div style="margin-top:15px;" class="col-lg-12 text-left nomarginpadding">
									<?php echo $PaymentMethod["desc"]; ?>
								</div>
							</div>
						</div>
					<?php
						$active='';
						}

						if( $_SESSION['type'] == 'agent' ) {
					?>
						<div class="col-lg-12 nomarginpadding">
							<div class="col-lg-2 centered">
								<label payment_id="4" class="btn paymentMethod">
									<div class="method" style="background-image: url('<?php echo base_url(); ?>img/multibanco.png'); max-width:100%;"></div>
									<input type="radio" name="payment_method" value="4" checked> 
								</label>
							</div>
							<div class="col-lg-10 text-left nomarginpadding">
								<div class="col-lg-12 text-left PaymentName nomarginpadding">
									<b>Multibanco - TPA</b>
								</div>
								<div style="margin-top:15px;" class="col-lg-12 text-left nomarginpadding">
									Multibanco - TPA
								</div>
							</div>
						</div>
						<div class="col-lg-12 nomarginpadding">
							<div class="col-lg-2 centered">
								<label payment_id="5" class="btn paymentMethod">
									<div class="method" style="background-image: url('<?php echo base_url(); ?>img/cash.png'); max-width:100%;"></div>
									<input type="radio" name="payment_method" value="5" checked> 
								</label>
							</div>
							<div class="col-lg-10 text-left nomarginpadding">
								<div class="col-lg-12 text-left PaymentName nomarginpadding">
									<b>Cash</b>
								</div>
								<div style="margin-top:15px;" class="col-lg-12 text-left nomarginpadding">
									Cash
								</div>
							</div>
						</div>
					<?php
						}
					?>
					</div>
				</div>
			</div>
		</div>
		<script>
			function cart_refresh( obj ) {
				obj.parent().children().eq(1).fadeIn('slow');
			}
		</script>
		
		<?php if( $_SESSION['type'] == 'agent' ) { ?>
		<div class="row rowStep3 hidden">
		<?php } ?>
		<?php if( $_SESSION['type'] == 'client' ) { ?>
		<div class="row rowStep2 hidden">
		<?php } ?>
			<div class="checkoutCont">
				<div class="headingWrap">
					<h3 class="headingTop text-center">Confirm your order</h3>	
				</div>
				<div class="ajaxcart">
				<?php echo $this->template->partial->view('wl_cart', $data = array(), $overwrite = true); ?>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="checkoutCont">
				<div class="footerNavWrap clearfix ButStep1">
					<div onclick="GoToStep(2)" class="btn pull-right btn-fyi">CONTINUE <span class="glyphicon glyphicon-chevron-right"></span></div>
				</div>
				<?php if( $_SESSION['type'] == 'agent' ) { ?>
					<div class="footerNavWrap clearfix ButStep2 hidden">
						<div onclick="GoToStep(3)" class="btn pull-right btn-fyi">CONTINUE <span class="glyphicon glyphicon-chevron-right"></span></div>
						<div onclick="GoToStep(1)" class="btn pull-left btn-fyi">BACK <span class="glyphicon glyphicon-chevron-left"></span></div>
					</div>
					<div class="footerNavWrap clearfix ButStep3 hidden">
						<form id="cart-form" method="POST" accept-charset="UTF-8" action="<?php echo base_url(); ?>wl/<?php echo $op; ?>/checkout_confirm">
							<input type="hidden" name="PaymentType" value="<?php echo $def_payment_id; ?>"/>
							<input type="hidden" name="pay_client_name" value=""/>
							<input type="hidden" name="pay_client_address" value=""/>
							<input type="hidden" name="pay_client_postcode" value=""/>
							<input type="hidden" name="pay_client_city" value=""/>
							<input type="hidden" name="pay_client_country" value=""/>
							<input type="hidden" name="pay_client_vat" value=""/>
							<input type="hidden" name="pay_client_email" value=""/>
							<input type="hidden" name="pay_transaction_id" value=""/>
							<input type="hidden" name="pay_checked_cash" value=""/>
							<div onclick="agent_payment_validation();" class="btn pull-right btn-fyi">CONFIRM <span class="glyphicon glyphicon-ok"></span></div>
						</form>
						<div onclick="GoToStep(2)" class="btn pull-left btn-fyi">BACK <span class="glyphicon glyphicon-chevron-left"></span></div>
					</div>
				<?php } ?>
				<?php if( $_SESSION['type'] == 'client' ) { ?>
					<div class="footerNavWrap clearfix ButStep2 hidden">
						<form id="cart-form" method="POST" accept-charset="UTF-8" action="<?php echo base_url(); ?>wl/<?php echo $op; ?>/checkout_confirm">
							<input type="hidden" name="PaymentType" value="<?php echo $def_payment_id; ?>"/>
							<div onclick="$( '#cart-form' ).submit();" class="btn pull-right btn-fyi">CONFIRM <span class="glyphicon glyphicon-ok"></span></div>
						</form>
						<div onclick="GoToStep(1)" class="btn pull-left btn-fyi">BACK <span class="glyphicon glyphicon-chevron-left"></span></div>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>

<script>
	function checkvoucher() {
		var voucher_code = jQuery("#vouchercode").val().toString().trim();

		if( voucher_code != "" ) {
			
			$("body").LoadingOverlay("show");
			
			$.ajax({
				method : 'POST',
				data : { "bostamp":"<?php echo $reservation_bostamp; ?>", "voucher":voucher_code, "op":<?php echo $op; ?> },
				datatype: "json",
				url: '<?php echo base_url(); ?>calendar/check_voucher_wl',
				success : function(data) {
					data = JSON.parse(data);
					
					if( data['success'] == 1) {
						$("body").LoadingOverlay("hide");
						
						jQuery("#voucher_row").css("display", "table-row");
						jQuery("#voucher_row").children().eq(1).html(voucher_code);
						
						jQuery(document).trigger("set-alert-id-voucher_alert", [
						{
							"message": data['message'],
							"priority": 'success'
						}
						]);
						
						$.ajax({
							method : 'POST',
							data : {},
							url: '<?php echo base_url(); ?>wl/7/print_cart',
							success : function(data) {
								$( ".ajaxcart" ).html(data);
							}
						});
					}
					else {
						$("body").LoadingOverlay("hide");
						
						jQuery("#voucher_row").css("display", "none");
						jQuery("#voucher_row").children().eq(1).html("");
						
						jQuery(document).trigger("set-alert-id-voucher_alert", [
						{
							"message": data['message'],
							"priority": 'error'
						}
						]);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					jQuery("#voucher_row").css("display", "none");
					jQuery("#voucher_row").children().eq(1).html("");
					$("body").LoadingOverlay("hide");
				}
			});
		}
		else {
			jQuery(document).trigger("set-alert-id-voucher_alert", [
			{
				"message": "You must enter a voucher's code",
				"priority": 'error'
			}
			]);
		}
	}

	function agent_payment_validation() {
		var payment_id = jQuery("input[name='PaymentType']").val();
		
		jQuery("input[name='pay_client_name']").val( jQuery("#client_name").val() );
		jQuery("input[name='pay_client_address']").val( jQuery("#client_address").val() );
		jQuery("input[name='pay_client_postcode']").val( jQuery("#client_postcode").val() );
		jQuery("input[name='pay_client_city']").val( jQuery("#client_city").val() );
		jQuery("input[name='pay_client_country']").val( jQuery("#client_country").val() );
		jQuery("input[name='pay_client_vat']").val( jQuery("#client_vat").val() );
		jQuery("input[name='pay_client_email']").val( jQuery("#client_email").val() );
		jQuery("input[name='pay_transaction_id']").val( jQuery("#info_payment_4_val").val() );
		jQuery("input[name='pay_checked_cash']").val( jQuery("#info_payment_5_val").val() );
		
		if( payment_id == 4 ) {
			jQuery("#cart-form").attr("action", "<?php echo base_url(); ?>wl/<?php echo $op; ?>/checkout_confirm_tpa_cash");
			$('.info_payment_4').validator()
			result = true;
			$('.info_payment_4').validator('validate');
			$('.info_payment_4 .form-group').each(function(){
				if($(this).hasClass('has-error')){
					result = false;
				}
			});
			if( result ) {
				$( '#cart-form' ).submit();
			}
		}
		else if( payment_id == 5 ) {
			jQuery("#cart-form").attr("action", "<?php echo base_url(); ?>wl/<?php echo $op; ?>/checkout_confirm_tpa_cash");
			$('.info_payment_5').validator()
			result = true;
			$('.info_payment_5').validator('validate');
			$('.info_payment_5 .form-group').each(function(){
				if($(this).hasClass('has-error')){
					result = false;
				}
			});
			if( result ) {
				$( '#cart-form' ).submit();
			}
		}
		else if( payment_id == 1 || payment_id == 3 ) {
			jQuery("#cart-form").attr("action", "<?php echo base_url(); ?>wl/<?php echo $op; ?>/checkout_confirm_agent");
			$( '#cart-form' ).submit();
		}
	}

	jQuery("label.paymentMethod").click(function() {
		var pay_meth = jQuery(this).find("input").val();
		jQuery("[name='PaymentType']").val(pay_meth);
		if( pay_meth == 4 ) {
			jQuery(".info_payment_4").removeClass("hide");
			jQuery(".info_payment_5").addClass("hide");
		}
		else if( pay_meth == 5 ) {
			jQuery(".info_payment_4").addClass("hide");
			jQuery(".info_payment_5").removeClass("hide");
		}
		else {
			jQuery(".info_payment_4").addClass("hide");
			jQuery(".info_payment_5").addClass("hide");
		}
	})
	
	jQuery(document).ready(function() {
		$('#client_data_form').validator()
		$("#cart-form").on("submit", function() {
			<?php if( isset($_SESSION["type"]) && $_SESSION["type"] == "client" ) { ?>
			if( parseFloat( $(".total_val").attr("total") ) >= 1000 && '<?php echo trim($user["invoice_address_street"]); ?>' == '' ) {
				alert( "Sorry, you can not finalize the purchase because you must have filled in the address when the purchase value is greater than or equal to 1000." );
				return false;
			}
			<?php }
			else if( isset($_SESSION["type"]) && $_SESSION["type"] == "agent" ) { ?>
			if( parseFloat( $(".total_val").attr("total") ) >= 1000 && jQuery("#client_address").val().toString().trim() == '' ) {
				alert( "Sorry, you can not finalize the purchase because you must have filled in the address when the purchase value is greater than or equal to 1000." );
				return false;
			}
			<?php } 
			else { ?>
			return false;
			<?php }?>
		})
	})
	
	function GoToStep(num) {
		if ( num == 1 ) {
			jQuery(".bs-wizard").children().eq(0).removeClass("disabled");
			jQuery(".bs-wizard").children().eq(0).removeClass("complete");
			jQuery(".bs-wizard").children().eq(1).removeClass("disabled");
			jQuery(".bs-wizard").children().eq(1).removeClass("complete");
			
			jQuery(".bs-wizard").children().eq(0).addClass("complete");
			jQuery(".bs-wizard").children().eq(1).addClass("disabled");
			
			jQuery(".ButStep1").removeClass("hidden");
			jQuery(".ButStep2").addClass("hidden");
			
			jQuery(".rowStep1").removeClass("hidden");
			jQuery(".rowStep2").addClass("hidden");
		}
		else if ( num == 2 ) {
			<?php
				if( $_SESSION['type'] == 'agent' ) {
			?>
				result = true;
				$('#client_data_form').validator('validate');
				$('#client_data_form .form-group').each(function(){
					if($(this).hasClass('has-error')){
						result = false;
					}
				});
				if( result ) {
			<?php
				}
			?>
			jQuery(".bs-wizard").children().eq(0).removeClass("disabled");
			jQuery(".bs-wizard").children().eq(0).removeClass("complete");
			jQuery(".bs-wizard").children().eq(1).removeClass("disabled");
			jQuery(".bs-wizard").children().eq(1).removeClass("complete");
			jQuery(".bs-wizard").children().eq(2).removeClass("disabled");
			jQuery(".bs-wizard").children().eq(2).removeClass("complete");
			
			jQuery(".bs-wizard").children().eq(0).addClass("complete");
			jQuery(".bs-wizard").children().eq(1).addClass("complete");
			jQuery(".bs-wizard").children().eq(2).addClass("disabled");
			
			jQuery(".ContinueStep1").addClass("hidden");
			jQuery(".ContinueStep2").removeClass("hidden");
			jQuery(".ContinueStep3").addClass("hidden");
			
			jQuery(".ButStep1").addClass("hidden");
			jQuery(".ButStep2").removeClass("hidden");
			jQuery(".ButStep3").addClass("hidden");
			
			jQuery(".rowStep1").addClass("hidden");
			jQuery(".rowStep2").removeClass("hidden");
			jQuery(".rowStep3").addClass("hidden");
			<?php
				if( $_SESSION['type'] == 'agent' ) {
			?>
				}
			<?php
				}
			?>
		}
		else if ( num == 3 ) {
			jQuery(".bs-wizard").children().eq(0).removeClass("disabled");
			jQuery(".bs-wizard").children().eq(0).removeClass("complete");
			jQuery(".bs-wizard").children().eq(1).removeClass("disabled");
			jQuery(".bs-wizard").children().eq(1).removeClass("complete");
			jQuery(".bs-wizard").children().eq(2).removeClass("disabled");
			jQuery(".bs-wizard").children().eq(2).removeClass("complete");
			
			jQuery(".bs-wizard").children().eq(0).addClass("complete");
			jQuery(".bs-wizard").children().eq(1).addClass("complete");
			jQuery(".bs-wizard").children().eq(2).addClass("complete");
			
			jQuery(".ContinueStep1").addClass("hidden");
			jQuery(".ContinueStep2").addClass("hidden");
			jQuery(".ContinueStep3").removeClass("hidden");
			
			jQuery(".ButStep1").addClass("hidden");
			jQuery(".ButStep2").addClass("hidden");
			jQuery(".ButStep3").removeClass("hidden");
			
			jQuery(".rowStep1").addClass("hidden");
			jQuery(".rowStep2").addClass("hidden");
			jQuery(".rowStep3").removeClass("hidden");
		}
	}
</script>