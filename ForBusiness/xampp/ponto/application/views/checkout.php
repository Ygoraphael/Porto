<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>

		<div class="col-lg-12">
			<div data-alerts="alerts" data-titles="" data-ids="myid" data-fade="3000"></div>
			<legend style="color:white;">Checkout</legend>
			<div class="col-lg-12">
				<div class="row bs-wizard" style="border-bottom:0;">
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
				</div>
			</div>
			<div class="col-lg-12">
				<div class="row rowStep1">
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
											<div class="method" style="background-image: url('<?php echo $PaymentMethod["img_path"]; ?>');"></div>
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
							<h3 class="headingTop text-center">Confirm your order</h3>	
						</div>
						<div class="checkoutWrap">
							<div class="btn-group checkoutBtnGroup btn-group-justified" data-toggle="buttons">
								<div class="row">
									<div class="col-md-12 clearfix" id="basket">
										<div class="box">
											<div class="table-responsive">
												<style>
													.cart-table tr td p {
														color:#fff;
													}
												</style>
												<table class="table cart-table">
													<thead>
														<tr>
															<th>Product</th>
															<th>Description</th>
															<th>Qtt</th>
															<th class="text-right">Unit Price</th>
															<th class="text-right">Total</th>
															<th class="text-right"></th>
														</tr>
													</thead>
													<tbody>
														<?php
															$subtotal = 0;
															$vat = 0;
															$other_taxes = 0;
															$total = 0;
															
															if ( $reservation_type == "seats" ) {
																$qtt_dis = "disabled";
															}
															else {
																$qtt_dis = "";
															}
															
															foreach( $checkout_cart as $cart_prod ) {
																if( substr($cart_prod["ref"], 0, 2) == "P." ) {
															?>
																<tr>
																	<td><p><?php echo $cart_prod["ref"]; ?></p></td>
																	<td>
																		<p><?php echo $cart_prod["desc"]; ?></p>
																		<p><?php echo $cart_prod["cor"]; ?> - <?php echo $cart_prod["tam"]; ?> | <?php echo $cart_prod["date"]; ?> @ <?php echo $cart_prod["session_hour"]; ?></p>
																	</td>
																	<td>
																		<input onchange="cart_refresh( jQuery(this) );" type="number" <?php echo $qtt_dis; ?> min="0" max="5" value="<?php echo $cart_prod["qtt"]; ?>" class="form-control pull-left cart-qtt">
																		<a class="btn btn-info pull-left cart-qtt-btn" href="#"><span class="glyphicon glyphicon-refresh"></span></a>
																	</td>
																	<td class="text-right">€ <?php echo $cart_prod["unit_price"]; ?></td>
																	<td class="text-right">€ <?php echo number_format($cart_prod["qtt"] * $cart_prod["unit_price"], 2, '.', ''); ?></td>
																	<td><a class="btn btn-warning btn-sm pull-right" href="#" title="Remove Item">X</a></td>
																</tr>
															<?php
																}
																else if( substr($cart_prod["ref"], 0, 2) == "R." ) {
															?>
																<tr>
																	<td><p><?php echo $cart_prod["ref"]; ?></p></td>
																	<td>
																		<p><?php echo $cart_prod["desc"]; ?></p>
																		<p>Optional extra</p>
																	</td>
																	<td>
																		<input onchange="cart_refresh( jQuery(this) );" type="number" <?php echo $qtt_dis; ?> min="0" max="5" value="<?php echo $cart_prod["qtt"]; ?>" class="form-control pull-left cart-qtt">
																		<a class="btn btn-info pull-left cart-qtt-btn" href="#"><span class="glyphicon glyphicon-refresh"></span></a>
																	</td>
																	<td class="text-right">€ <?php echo $cart_prod["unit_price"]; ?></td>
																	<td class="text-right">€ <?php echo number_format($cart_prod["qtt"] * $cart_prod["unit_price"], 2, '.', ''); ?></td>
																	<td><a class="btn btn-warning btn-sm pull-right" href="#" title="Remove Item">X</a></td>
																</tr>
															<?php
																}
																
																$subtotal += $cart_prod["qtt"] * $cart_prod["unit_price"];
															}
															$vat = round($subtotal - ($subtotal/1.23), 2);
															$other_taxes = 0;
															$total = $subtotal + $other_taxes;
														?>
													</tbody>
													<tfoot>
														<tr>
															<td colspan="6">
																<div class="box-header">
																	<h4>Voucher Code</h4>
																	<p class="text-muted">Enter a promotional code here</p>
																	<form>
																		<div class="input-group col-md-6">
																			<input type="text" class="form-control">
																			<span class="input-group-btn">
																			<button class="btn btn-template-main" type="button"><i class="fa fa-gift"></i></button>
																			</span>
																		</div>
																	</form>
																	<br>
																</div>
															</td>
														</tr>
														<tr>
															<th colspan="4">VAT</th>
															<th class="text-right" colspan="1">€ <?php echo number_format($vat, 2, '.', ','); ; ?></th>
															<th></th>
														</tr>
														<tr>
															<th colspan="4">Other Taxes</th>
															<th class="text-right" colspan="1">€ <?php echo number_format($other_taxes, 2, '.', ','); ; ?></th>
															<th></th>
														</tr>
														<tr>
															<th colspan="4">Total (VAT incl.)</th>
															<th class="text-right" colspan="1">€ <?php echo number_format($total, 2, '.', ','); ; ?></th>
															<th></th>
														</tr>
													</tfoot>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="checkoutCont">
						<div class="footerNavWrap clearfix ButStep1">
							<div onclick="GoToStep(2)" class="btn pull-right btn-fyi">CONTINUE <span class="glyphicon glyphicon-chevron-right"></span></div>
						</div>
						<div class="footerNavWrap clearfix ButStep2 hidden">
							<form id="cart-form" method="POST" action="<?php echo base_url(); ?>checkout/confirm">
								<input type="hidden" name="PaymentType" value="<?php echo $def_payment_id; ?>"/>
								<div onclick="$( '#cart-form' ).submit();" class="btn pull-right btn-fyi">CONFIRM <span class="glyphicon glyphicon-ok"></span></div>
							</form>
							<div onclick="GoToStep(1)" class="btn pull-left btn-fyi">BACK <span class="glyphicon glyphicon-chevron-left"></span></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	jQuery("label.paymentMethod").click(function() {
		var pay_meth = jQuery(this).find("input").val();
		jQuery("[name='PaymentType']").val(pay_meth);
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
			
			jQuery(".bs-wizard").children().eq(0).addClass("complete");
			jQuery(".bs-wizard").children().eq(1).addClass("complete");
			
			jQuery(".ContinueStep1").addClass("hidden");
			jQuery(".ContinueStep2").removeClass("hidden");
			
			jQuery(".ButStep1").addClass("hidden");
			jQuery(".ButStep2").removeClass("hidden");
			
			jQuery(".rowStep1").addClass("hidden");
			jQuery(".rowStep2").removeClass("hidden");
		}
	}
</script>