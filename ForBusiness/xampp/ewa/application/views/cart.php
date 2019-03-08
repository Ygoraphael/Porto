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
									<th><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Product')?></th>
									<th><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Description')?></th>
									<th>Qtt</th>
									<th class="text-right"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Unit Price')?></th>
									<th class="text-right"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Total')?></th>
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
												<p><?php echo (strtoupper($cart_prod["cor"]) != "ND" ) ? $cart_prod["cor"] . " - " : ""; ?><?php echo $this->googletranslate->translate($_SESSION["language_code"], $cart_prod["tam"]); ?> | <?php echo $cart_prod["date"]; ?> @ <?php echo $cart_prod["session_hour"]; ?></p>
											</td>
											<td>
												<?php echo number_format($cart_prod["qtt"], 2, '.', ''); ?>
											</td>
											<td class="text-right"><i class="fa"><?php echo $_SESSION["i"];?></i><?php echo $this->currency->valor($cart_prod["unit_price"]); ?></td>
											<td class="text-right"><i class="fa"><?php echo $_SESSION["i"];?></i> <?php echo  $this->currency->valor(number_format(floatval($cart_prod["qtt"]) * floatval($cart_prod["unit_price"]), 2, '.', '')); ;?></td>
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
												<?php echo number_format($cart_prod["qtt"], 2, '.', ''); ?>
											</td>
											<td class="text-right"><i class="fa"><?php echo $_SESSION["i"];?></i> <?php echo number_format($cart_prod["unit_price"], 2, '.', ''); ?></td>
											<td class="text-right"><i class="fa"><?php echo $_SESSION["i"];?></i> <?php echo number_format(floatval($cart_prod["qtt"]) * floatval($cart_prod["unit_price"]), 2, '.', ''); ?></td>
										</tr>
									<?php
										}
										
										$vat += round(floatval($cart_prod["qtt"])*floatval($cart_prod["unit_price"]) * ($taxa_iva/100) / (1 + ($taxa_iva/100)), 2);
									}
								?>
							</tbody>
							<tfoot>
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
						<style>
							table tr td, table tr td p {
								color:white;
							}
						</style>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	function checkOrderAmount() {
		result = false;
		if( <?php echo $total; ?> <= 0 ) {
			result = true;
		}
		return result;
	}
</script>