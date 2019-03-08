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
									<th><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Product'); ?></th>
									<th><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Description'); ?></th>
									<th>Qtt</th>
									<th class="text-right"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Unit Price'); ?></th>
									<th class="text-right"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Total'); ?></th>
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
												<p><?php echo (strtoupper($cart_prod["cor"]) != "ND" ) ? $cart_prod["cor"] . " - " : ""; ?><?php echo $this->googletranslate->translate($_SESSION["language_code"], $cart_prod["tam"]); ?>  | <?php echo $cart_prod["date"]; ?> @ <?php echo $cart_prod["session_hour"]; ;?></p>
											</td>
											<td>
												<?php echo number_format($cart_prod["qtt"], 2, '.', ''); ?>
											</td>
											<td class="text-right"><i class="fa"><?php echo $_SESSION["i"];?></i> <?php echo $this->currency->valor($cart_prod["unit_price"]); ?></td>
											<td class="text-right"><i class="fa"><?php echo $_SESSION["i"];?></i><?php echo  $this->currency->valor(number_format(floatval($cart_prod["qtt"]) * floatval($cart_prod["unit_price"]), 2, '.', '')); ;?></td>
										</tr>
									<?php
										}
										else if( substr($cart_prod["ref"], 0, 2) == "R." ) {
									?>
										<tr>
											<td><p><?php echo $cart_prod["ref"]; ?></p></td>
											<td>
												<p><?php echo $this->googletranslate->translate($_SESSION["language_code"], $cart_prod["desc"]); ?> </p>
												<p><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Optional extra'); ?></p>
											</td>
											<td>
												<?php echo number_format($cart_prod["qtt"], 2, '.', ''); ?>
											</td>
											<td class="text-right"><i class="fa"><?php echo $_SESSION["i"];?></i> <?php echo  $this->currency->valor($cart_prod["unit_price"]); ;?></td>
											<td class="text-right"><i class="fa"><?php echo $_SESSION["i"];?></i> <?php echo $this->currency->valor(number_format(floatval($cart_prod["qtt"]) * floatval($cart_prod["unit_price"]), 2, '.', '')); ;?></td>
										</tr>
									<?php
										}
										
										$vat += round(floatval($cart_prod["qtt"])*floatval($cart_prod["unit_price"]) * ($taxa_iva/100) / (1 + ($taxa_iva/100)), 2);
									}
								?>
							</tbody>
							<tfoot>
								<tr>
									<td colspan="5">
										<div class="box-header">
											<h4><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Voucher Code'); ?></h4>
											<p class="text-muted"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Enter a promotional code here'); ?></p>
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
									<th colspan="3"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Voucher Code'); ?></th>
									<th class="text-center"><?php echo $voucher["code"]; ?></th>
									<th class="text-center"><a class="btn btn-warning btn-sm" href="#" title="Remove Voucher">X</a></th>
								</tr>
								<tr id="voucher_row">
									<th colspan="4"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Voucher Discount'); ?></th>
									<th class="text-right"><i class="fa"><?php echo $_SESSION["i"];?></i> <?php echo $this->currency->valor(number_format($voucher_value, 2, '.', '')); ;?></th>
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
									<th class="text-right" colspan="1"><i class="fa"><?php echo $_SESSION["i"];?></i> <?php echo $this->currency->valor(number_format($cur_tax_value, 2, '.', '')); ;?></th>
								</tr>
								<?php }

									$vat += round(floatval($other_taxes) * (23/100) / (1 + (23/100)), 2);
									$total = $subtotal + $other_taxes + $voucher_value;
									
								?>
								<tr>
									<th colspan="4">VAT</th>
									<th class="text-right" colspan="1"><i class="fa"><?php echo $_SESSION["i"];?></i> <?php echo $this->currency->valor(number_format($vat, 2, '.', '')); ; ?></th>
								</tr>
								<tr>
									<th colspan="4"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Total'); ?> (VAT incl.)</th>
									<th class="text-right total_val" total="<?php echo $total - $vat; ?>" colspan="1"><i class="fa"><?php echo $_SESSION["i"];?></i> <?php echo $this->currency->valor(number_format($total, 2, '.', '')); ;?></th>
								</tr>
								<?php if( isset($_SESSION["type_currency"]) && $_SESSION["type_currency"] != "EURO" ) { ?>
								<tr>
									<th colspan="4"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Total'); ?> (VAT incl.) - <?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Original Currency'); ?></th>
									<th class="text-right total_val" total="<?php echo $total - $vat; ?>" colspan="1">€ <?php echo number_format($total, 2, '.', ''); ; ?></th>
								</tr>
								<?php } ?>
							</tfoot>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php if( $_SESSION['type'] == 'agent') { ?>
	<div class="row info_payment_4 hide">
		<legend><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Payment Information'); ?></legend>
		<div class="form-group form-pay-4">
			<label for="info_payment_4_val">TPA <?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Transaction'); ?> ID</label>
			<input type="text" class="form-control" id="info_payment_4_val" required placeholder="TPA Transaction ID">
		</div>
	</div>
	<div class="row info_payment_5 hide">
		<legend><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Payment Information'); ?></legend>
		<div class="form-group form-pay-5">
			<div class="form-check">
				<label class="form-check-label">
					<input type="checkbox" id="info_payment_5_val" class="form-check-input" required style="line-height: 1px;" /> <?php echo $this->googletranslate->translate($_SESSION["language_code"], 'I declare that I have received the amount of this reservation in cash'); ?>
				</label>
			</div>
		</div>
		<style>
			.btn-togon_perparcial {
				background: #A28D5D;
				width:100px;
			}
		</style>
		<?php if( $agent_product_percentage_parcial > 0 ) { ?>
		<div class="form-group">
			<label class="col-lg-2 col-sm-3 control-label"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Payment Type'); ?></label>
			<div class="input-group col-lg-3 col-sm-6">
				<input type="checkbox" class="perparcial" data-toggle="toggle" data-onstyle="togon_perparcial" data-on="Partial" data-off="Full" />
			</div>
		</div>
		<div class="form-group hide perparcialvalue">
			<label class="col-lg-2 col-sm-3 control-label"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Value to pay'); ?> (<?php echo number_format($agent_product_percentage_parcial, 2, '.', ''); ?> %)</label>
			<div class="input-group col-lg-3 col-sm-6">
				<span class="input-group-addon">€</span>
				<input type="number" disabled class="form-control" value="<?php echo number_format($total*$agent_product_percentage_parcial/100, 2, '.', ''); ?>">
			</div>
		</div>
		<script>
			$(function() {
				$('.perparcial').change(function() {
					if( $(this).prop('checked') ) {
						jQuery(".perparcialvalue").removeClass("hide");
						jQuery("[name='pay_parcial']").val(1);
					}
					else {
						jQuery(".perparcialvalue").addClass("hide");
						jQuery("[name='pay_parcial']").val(0);
					}
				})
			})
		</script>
		<?php } ?>
		<?php if( $agent_max_plafond > 0 ) { ?>
		<div class="form-group">
			<label class="col-lg-2 col-sm-3 control-label"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Available Cash Plafond'); ?></label>
			<div class="input-group col-lg-3 col-sm-6">
				<input type="text" disabled class="form-control" value="&euro; <?php echo ( $agent_plafond < 0 ) ? 0 : number_format($agent_plafond, 2, '.', ''); ?>">
			</div>
		</div>
		<?php } ?>
		<?php if( $agent_sell_limit > 0 ) { ?>
		<div class="form-group">
			<label class="col-lg-2 col-sm-3 control-label"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Selling limit'); ?></label>
			<div class="input-group col-lg-3 col-sm-6">
				<input type="text" disabled class="form-control" value="&euro; <?php echo number_format($agent_sell_limit, 2, '.', ''); ?>">
			</div>
		</div>
		<?php } ?>
		<script>
			function checkplafond() {
				result = true;
				if( <?php echo $agent_max_plafond; ?> > 0 ) {
					if( <?php echo $agent_product_percentage_parcial; ?> > 0 && jQuery("[name='pay_parcial']").val() == 1 ) {
						if( <?php echo $total*$agent_product_percentage_parcial/100; ?> > <?php echo $agent_plafond; ?> ) {
							result = false;
						}
					}
					else {
						if( <?php echo $total; ?> > <?php echo $agent_plafond; ?> ) {
							result = false;
						}
					}
				}
				
				if( <?php echo $agent_sell_limit; ?> > 0 ) {
					if( <?php echo $agent_product_percentage_parcial; ?> > 0 && jQuery("[name='pay_parcial']").val() == 1 ) {
						if( <?php echo $total*$agent_product_percentage_parcial/100; ?> > <?php echo $agent_sell_limit; ?> ) {
							result = false;
						}
					}
					else {
						if( <?php echo $total; ?> > <?php echo $agent_sell_limit; ?> ) {
							result = false;
						}
					}
				}

				return result;
			}
		</script>
	</div>
	<?php } ?>
	<script>		
		function checkOrderAmount() {
			result = false;
			if( <?php echo $total; ?> <= 0 ) {
				result = true;
			}
			return result;
		}
	</script>
</div>