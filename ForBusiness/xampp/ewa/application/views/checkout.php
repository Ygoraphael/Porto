<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>

<div class="container">
	<div class="col-lg-12">
		<div data-alerts="alerts" data-titles="" data-ids="myid" data-fade="3000"></div>
		<legend style="color:white"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Checkout')?></legend>
		<div class="col-lg-12">
			<div class="row bs-wizard" style="border-bottom:0;">
				<div class="col-xs-6 bs-wizard-step complete">
					<div class="text-center bs-wizard-stepnum"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Step')?> 1</div>
					<div class="progress"><div class="progress-bar"></div></div>
					<a href="#" class="bs-wizard-dot"></a>
					<div class="bs-wizard-info text-center"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Payment')?></div>
				</div>
				<div class="col-xs-6 bs-wizard-step disabled">
					<div class="text-center bs-wizard-stepnum"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Step 1')?> 2</div>
					<div class="progress"><div class="progress-bar"></div></div>
					<a href="#" class="bs-wizard-dot"></a>
					<div class="bs-wizard-info text-center"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Confirmation')?></div>
				</div>
			</div>
		</div>
		<div class="col-lg-12">	
			<div class="row rowStep1">
				<div class="checkoutCont">
					<div class="headingWrap">
						<h3 class="headingTop text-center"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Select Your Payment Method')?></h3>	
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
								<div class="col-lg-3 centered">
									<label payment_id="<?php echo $PaymentMethod["id"]; ?>" class="btn paymentMethod <?php echo $active; ?>">
										<div class="method" style="background-image: url('<?php echo base_url() .$PaymentMethod["img_path"]; ?>'); max-width:100%;"></div>
										<input type="radio" name="payment_method" value="<?php echo $PaymentMethod["id"]; ?>" checked> 
									</label>
								</div>
								<div class="col-lg-7 text-left nomarginpadding">
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
			
			<div class="row rowStep2 hidden">
				<div class="checkoutCont">
					<div class="headingWrap">
						<h3 class="headingTop text-center"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Confirm your order')?></h3>	
					</div>
					<div class="ajaxcart">
					<?php echo $this->template->partial->view('cart', $data = array(), $overwrite = true); ?>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="checkoutCont">
					<div class="footerNavWrap clearfix ButStep1">
						<div onclick="GoToStep(2)" class="btn pull-right btn-fyi"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'CONTINUE')?> <span class="glyphicon glyphicon-chevron-right"></span></div>
					</div>
					<div class="footerNavWrap clearfix ButStep2 hidden">
						<form id="cart-form" method="POST" accept-charset="UTF-8" action="<?php echo base_url(); ?>checkout/confirm">
							<input type="hidden" name="PaymentType" value="<?php echo $def_payment_id; ?>"/>
							<div onclick="$( '#cart-form' ).submit();" class="btn pull-right btn-fyi"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'CONFIRM')?> <span class="glyphicon glyphicon-ok"></span></div>
						</form>
						<div onclick="GoToStep(1)" class="btn pull-left btn-fyi"><span class="glyphicon glyphicon-chevron-left"></span> <?php echo $this->googletranslate->translate($_SESSION["language_code"], 'GO BACK')?></div>
					</div>
				</div>
			</div>
			<div class="row ButStep2 hidden" style="margin-bottom:15px;">
				<div class="pull-left" style="margin-right:15px;">
					<img src="<?php echo base_url() ?>img/redunicre.png" border="0" style="height:184px">
				</div>
				<div class="pull-left" style="margin-right:15px;">
					<a onclick="verified_popup()"><img class="" src="<?php echo base_url() ?>img/VerifiedByVisa-Learnmore.gif" border="0" style="height:88px;margin-bottom:5px;"></a><br>
					<a onclick="return windowpop('http://www.mastercard.com/us/business/en/corporate/securecode/sc_popup.html?language=pt', 560, 400)">
						<img class="" src="<?php echo base_url() ?>img/sc_learn_156x83.gif" border="0" style="height:88px">
					</a>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	function windowpop(url, width, height) {
		var leftPosition, topPosition;
		//Allow for borders.
		leftPosition = (window.screen.width / 2) - ((width / 2) + 10);
		//Allow for title and status bars.
		topPosition = (window.screen.height / 2) - ((height / 2) + 50);
		//Open the window.
		window.open(url, "Window2", "status=no,height=" + height + ",width=" + width + ",resizable=yes,left=" + leftPosition + ",top=" + topPosition + ",screenX=" + leftPosition + ",screenY=" + topPosition + ",toolbar=no,menubar=no,scrollbars=no,location=no,directories=no");
	}

	function verified_popup() {
		var dialog = bootbox.dialog({
			message: '<p class="text-center"><img class="" src="<?php echo base_url() ?>img/verified1.png" border="0"></p>',
			closeButton: true,
			onEscape:true,
			backdrop: true
		});
	}

	jQuery("label.paymentMethod").click(function() {
		var pay_meth = jQuery(this).find("input").val();
		jQuery("[name='PaymentType']").val(pay_meth);
	})
	
	jQuery(document).ready(function() {
		$("#cart-form").on("submit", function() {
			
			var check_amount = checkOrderAmount();
		
			if( check_amount ) {
				alert( "<?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Sorry, you can not finalize the purchase because the purchase value must be greater than 0.'); ?>" );
				return false;
			}
			else {
				var payment_id = jQuery("input[name='PaymentType']").val();
				<?php 
				if( isset($user) && 
					(
						trim(trim($user["invoice_address_street"]) . " " . trim($user["invoice_address_addinfo"])) == "" || 
						trim($user["phone_no"]) == "" || 
						trim($user["email"]) == "" || 
						trim(trim($user["first_name"]) . " " . trim($user["last_name"])) == "" 
					) ) { ?>
					if( payment_id == 1 ) {
						
						var dialog = bootbox.dialog({
							message: '<p class="text-center"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Sorry, when credit card payment is selected, you must have filled in your name, address, phone number and email address in the customer area.'); ?></p>',
							closeButton: true,
							onEscape : true,
							backdrop : true,
							buttons: {
								confirm: {
									label: 'Client Area',
									className: 'btn-success',
									callback: function (result) {
										window.location.href = "<?php echo base_url()?>account?rdr=c";
									}
								},
								cancel: {
									label: 'Close',
									className: 'btn-danger'
								}
							}
						});

						return false;
					}
				<?php } ?>

				if( parseFloat( $(".total_val").attr("total") ) >= 1000 && '<?php echo trim($user["invoice_address_street"]); ?>' == '' ) {
					alert( "<?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Sorry, you can not finalize the purchase because you must have filled in the address when the purchase value is greater than or equal to 1000.'); ?>" );
					return false;
				}

				<?php if( isset($_SESSION["type"]) && $_SESSION["type"] == "agent" ) { ?>
				return false;
				<?php }?>
			}
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