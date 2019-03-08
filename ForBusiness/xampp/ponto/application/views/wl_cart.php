<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>

<div class="checkoutWrap">
	<div class="btn-group checkoutBtnGroup btn-group-justified" data-toggle="buttons">
		<div class="row">
			<div class="col-md-12 clearfix" id="basket">
				<div class="box">
					<div class="table-responsive">
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
									if( sizeof($lastminute_taxes)>0 ) {
										foreach( $lastminute_taxes as $lastminute_tax ) {
											foreach( $checkout_cart as $key => $cart_prod ) {
												if( $lastminute_tax["formula"] == "-%" ) {
													$checkout_cart[$key]["unit_price"] = $cart_prod["unit_price"] = $cart_prod["unit_price"] * ( 1 - ($lastminute_tax["value"]/100) );
												}
												else if( $lastminute_tax["formula"] == "-v" ) {
													$checkout_cart[$key]["unit_price"] = $cart_prod["unit_price"] - $lastminute_tax["value"];
												}
											}
										}
									}
									
									$subtotal = 0;
									foreach( $checkout_cart as $cart_prod ) {
										$subtotal += $cart_prod["qtt"] * $cart_prod["unit_price"];
									}

									//calculo taxaiva
									$taxa_iva = -1;
									foreach( $taxasiva as $taxaiva ) {
										if( $taxaiva["codigo"] == $product["u_tabiva"] )
											$taxa_iva = floatval($taxaiva["taxa"]);
									}
									if( $taxa_iva == -1 )
										$taxa_iva = 23;
									
									$vat = 0;
									$other_taxes = 0;
									$voucher_value = 0;
									
									//taxas de voucher
									if( isset($voucher["code"]) && $voucher["code"] != '' ) {
										switch( $voucher["formula"] ) {
											case '- %':
												$voucher_value -= $subtotal * floatval( $voucher["value"] ) / 100;
												break;
											case '- V':
												$voucher_value -=  floatval( $voucher["value"] );
												break;
										}
									}
									
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
												<p><?php echo (strtoupper($cart_prod["cor"]) != "ND" ) ? $cart_prod["cor"] . " - " : ""; ?><?php echo $cart_prod["tam"]; ?> | <?php echo $cart_prod["date"]; ?> @ <?php echo $cart_prod["session_hour"]; ?></p>
											</td>
											<td>
												<?php echo $cart_prod["qtt"]; ?>
											</td>
											<td class="text-right">€ <?php echo $cart_prod["unit_price"]; ?></td>
											<td class="text-right">€ <?php echo number_format($cart_prod["qtt"] * $cart_prod["unit_price"], 2, '.', ''); ?></td>
											<td class="text-center"><a class="btn btn-warning btn-sm" href="#" title="Remove Item">X</a></td>
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
												<?php echo $cart_prod["qtt"]; ?>
											</td>
											<td class="text-right">€ <?php echo $cart_prod["unit_price"]; ?></td>
											<td class="text-right">€ <?php echo number_format($cart_prod["qtt"] * $cart_prod["unit_price"], 2, '.', ''); ?></td>
											<td class="text-center"><a class="btn btn-warning btn-sm" href="#" title="Remove Item">X</a></td>
										</tr>
									<?php
										}
										
										$vat += round(floatval($cart_prod["qtt"])*floatval($cart_prod["unit_price"]) * ($taxa_iva/100) / (1 + ($taxa_iva/100)), 2);
									}
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
													<input type="text" id="vouchercode" class="form-control" />
													<span class="input-group-btn">
														<button onclick="checkvoucher(); return false;" class="btn btn-template-main" type="button"><i class="fa fa-gift"></i></button>
													</span>
												</div>
											</form>
											<style>
												#voucher_alert {
													margin-top:15px;
												}
												#voucher_alert ul {
													list-style-type: none;
												}
											</style>
											<div class="clearfix" id="voucher_alert" data-ids="voucher_alert" data-alerts="alerts" data-fade="3000"></div>
										</div>
									</td>
								</tr>
								<?php if( isset($voucher["code"]) && $voucher["code"] != '' ) { ?>
								<tr id="voucher_row">
									<th colspan="4">Voucher Code</th>
									<th class="text-center"><?php echo $voucher["code"]; ?></th>
									<th class="text-center"><a class="btn btn-warning btn-sm" href="#" title="Remove Voucher">X</a></th>
								</tr>
								<tr id="voucher_row">
									<th colspan="4">Voucher Discount</th>
									<th class="text-right">€ <?php echo number_format($voucher_value, 2, '.', ','); ; ?></th>
									<th></th>
								</tr>
								<?php } ?>
								
								<?php foreach( $taxes as $tax ) {
								
									//other taxes
									$cur_tax_value = 0;
									switch( $tax["formula"] ) {
										case '+%':
											$cur_tax_value += ($subtotal + $voucher_value) * floatval( $tax["value"] ) / 100;
											break;
										case '-%':
											$cur_tax_value -= ($subtotal + $voucher_value) * floatval( $tax["value"] ) / 100;
											break;
										case '+v':
											$cur_tax_value +=  floatval( $tax["value"] );
											break;
										case '-v':
											$cur_tax_value -=  floatval( $tax["value"] );
											break;
									}
									$other_taxes += $cur_tax_value;
								?>
								<tr>
									<th colspan="4"><?php echo $tax["design"]; ?></th>
									<th class="text-right" colspan="1">€ <?php echo number_format($cur_tax_value, 2, '.', ','); ; ?></th>
									<th></th>
								</tr>
								<?php }

									$vat += round(floatval($other_taxes) * (23/100) / (1 + (23/100)), 2);
									$total = $subtotal + $other_taxes + $voucher_value;
									
								?>
								<tr>
									<th colspan="4">VAT</th>
									<th class="text-right" colspan="1">€ <?php echo number_format($vat, 2, '.', ','); ; ?></th>
									<th></th>
								</tr>
								<tr>
									<th colspan="4">Total (VAT incl.)</th>
									<th class="text-right total_val" total="<?php echo $total - $vat; ?>" colspan="1">€ <?php echo number_format($total, 2, '.', ','); ; ?></th>
									<th></th>
								</tr>
							</tfoot>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php if( $_SESSION['type'] == 'agent') { ?>
	<div class="row info_payment_4 hide">
		<legend>Payment Information</legend>
		<div class="form-group form-pay-4">
			<label for="info_payment_4_val">TPA Transaction ID</label>
			<input type="text" class="form-control" id="info_payment_4_val" required placeholder="TPA Transaction ID">
		</div>
	</div>
	<div class="row info_payment_5 hide">
		<legend>Payment Information</legend>
		<div class="form-group form-pay-5">
			<div class="form-check">
				<label class="form-check-label">
					<input type="checkbox" id="info_payment_5_val" class="form-check-input" required> I declare that I have received the amount of this reservation in cash
				</label>
			</div>
		</div>
	</div>
	<?php } ?>
</div>