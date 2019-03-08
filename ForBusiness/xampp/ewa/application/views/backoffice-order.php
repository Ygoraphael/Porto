<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
		<div class="page-head col-md-12">
			<div class="col-md-12 col-sm-12">
				<h2 class="col-md-6 col-sm-6 col-xs-6"><?php echo $this->translation->Translation_key($title, $_SESSION['lang_u']); ?></h2>
				<button type="button" onclick="mudar_session(); return false;" type="button" class="btn btn-info pull-right"><?php echo $this->translation->Translation_key("SAVE", $_SESSION['lang_u']); ?></button>
				<?php if( $order["ngstatus"] == "PARTIAL" ) { ?>
					<button type="button" onclick="window.location.href = '<?php echo base_url() . 'backoffice/partialorder/' . $order['obrano'] ?>'; return false;" type="button" class="btn btn-info pull-right" style="margin-right:15px;"><?php echo $this->translation->Translation_key("MISSING AMOUNT PAYMENT", $_SESSION['lang_u']); ?></button>				
				<?php } ?>
				<a onclick="window.history.back(); return false;" type="button" class="btn btn-primary pull-right"	style="margin-right:15px;"><span class="glyphicon glyphicon-chevron-left"></span><?php echo $this->translation->Translation_key("BACK", $_SESSION['lang_u']); ?> </a>
				</div>
		</div>
		<p style="margin-bottom:5px"></p>
		<div class="clearfix" data-alerts="alerts" data-fade="3000"></div>
		<div class="main-content col-sm-12 col-md-12 col-xs-12">
			<div class="panel panel-default">
				<div class="col-sm-12 col-md-12 col-xs-12">
					<form action="#" class="form-horizontal group-border-dashed clearfix" >
						<div class="form-group">
							<label class="col-lg-2 col-sm-3 col-md-2 col-xs-12 control-label"><?php echo $this->translation->Translation_key("Name", $_SESSION['lang_u']); ?></label>
							<div class="input-group col-lg-3 col-sm-3 col-md-3  col-xs-12" style="margin-right:10px">
								<input type="text" class="form-control" id="" value="<?php echo $order['nome']; ?>" readonly>
							</div>
							<label class="col-lg-2 col-sm-3 col-md-2  col-xs-12 control-label">Nº <?php echo $this->translation->Translation_key("Client", $_SESSION['lang_u']); ?></label>
							<div class="input-group col-lg-3 col-sm-3 col-md-3  col-xs-12" style="margin-right:10px">
								<input type="text" class="form-control" id="" value="<?php echo $order['no']; ?>" readonly>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-2 col-sm-3 col-md-2  col-xs-12 control-label">Nº <?php echo $this->translation->Translation_key("Cont", $_SESSION['lang_u']); ?></label>
							<div class="input-group col-lg-3 col-sm-3 col-md-3  col-xs-12" style="margin-right:10px">
								<input type="text" class="form-control" id="" value="<?php echo $order['ncont']; ?>" readonly>
							</div>
							<label class="col-lg-2 col-sm-3 col-md-2  col-xs-12 control-label"><?php echo $this->translation->Translation_key("Address", $_SESSION['lang_u']); ?> </label>
							<div class="input-group col-lg-3 col-sm-3 col-md-3  col-xs-12" style="margin-right:10px">
								<input type="text" class="form-control" id="" value="<?php echo $order['morada']; ?>" readonly>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-2 col-sm-3 col-md-2  col-xs-12 control-label"><?php echo $this->translation->Translation_key("PostalCode", $_SESSION['lang_u']); ?></label>
							<div class="input-group col-lg-3 col-sm-3 col-md-3  col-xs-12" style="margin-right:10px">
								<input type="text" class="form-control" id="" value="<?php echo $order['codpost']; ?>" readonly>
							</div>
							<label class="col-lg-2 col-sm-3 col-md-2  col-xs-12 control-label"><?php echo $this->translation->Translation_key("Local", $_SESSION['lang_u']); ?></label>
							<div class="input-group col-lg-3 col-sm-3 col-md-3  col-xs-12" style="margin-right:10px">
								<input type="text" class="form-control" id="" value="<?php echo $order['local']; ?>" readonly>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-2 col-sm-3 col-md-2  control-label"><?php echo $this->translation->Translation_key("Estab", $_SESSION['lang_u']); ?>.</label>
							<div class="input-group col-lg-3 col-sm-3 col-md-3 " style="margin-right:10px">
								<input type="text" class="form-control" id="" value="<?php echo $order['estab']; ?>" readonly>
							</div>
							<label class="col-lg-2 col-sm-3 col-md-2  col-xs-12 control-label"><?php echo $this->translation->Translation_key("Order Date", $_SESSION['lang_u']); ?></label>
							<div class="input-group col-lg-3 col-sm-3 col-md-3  col-xs-12" style="margin-right:10px">
								<input type="text" class="form-control" id="" value="<?php echo $order['datahora']; ?>" readonly>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-2 col-sm-3 col-md-2  col-xs-12 control-label"><?php echo $this->translation->Translation_key("Email", $_SESSION['lang_u']); ?></label>
							<div class="input-group col-lg-3 col-sm-3 col-md-3  col-xs-12" style="margin-right:10px">
								<input type="text" class="form-control" id="" value="<?php echo $order['email']; ?>" readonly>
							</div>
							<label class="col-lg-2 col-sm-3 col-md-2  col-xs-12 control-label"><?php echo $this->translation->Translation_key("Telefone", $_SESSION['lang_u']); ?></label>
							<div class="input-group col-lg-3 col-sm-3 col-md-3  col-xs-12" style="margin-right:10px">
								<input type="text" class="form-control" id="" value="<?php echo $order['telefone']; ?>" readonly>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-2 col-sm-3 col-md-2  col-xs-12 control-label"><?php echo $this->translation->Translation_key("Product", $_SESSION['lang_u']); ?></label>
							<div class="input-group col-lg-3 col-sm-3 col-md-3  col-xs-12" style="margin-right:10px">
								<input type="text" class="form-control" id="" value="<?php echo $order['product']; ?>" readonly>
							</div>
							<?php  if( $user["u_operador"] == 'Sim' ) { ?>
							<label class="col-lg-2 col-sm-3 col-md-2  col-xs-12 control-label"><?php echo $this->translation->Translation_key("Agent", $_SESSION['lang_u']); ?></label>
							<div class="input-group col-lg-3 col-sm-3 col-md-3  col-xs-12" style="margin-right:10px">
								<input type="text" class="form-control" id="" value="<?php echo $order['agent']; ?>" readonly>
							</div>
							<?php }else{ ?>
							<label class="col-lg-2 col-sm-3 col-md-2  col-xs-12 control-label"><?php echo $this->translation->Translation_key("Operator", $_SESSION['lang_u']); ?></label>
							<div class="input-group col-lg-3 col-sm-3 col-md-3  col-xs-12" style="margin-right:10px">
								<input type="text" class="form-control" id="" value="<?php echo $order['NOMECTS']; ?>" readonly>
							</div>
							<?php }?>
						</div>
						<div class="form-group">
							<label class="col-lg-2 col-sm-3 col-md-2  col-xs-12 control-label"><?php echo $this->translation->Translation_key("Payment method", $_SESSION['lang_u']); ?></label>
							<div class="input-group col-lg-3 col-sm-3 col-md-3  col-xs-12" style="margin-right:10px">
								<input type="text" class="form-control" id="" value="<?php echo substr($order['IDENTIFICACAO2'], 0, 10); ?>" readonly>
							</div>
							<label class="col-lg-2 col-sm-3 col-md-2  col-xs-12 control-label"><?php echo $this->translation->Translation_key("Payment type", $_SESSION['lang_u']); ?></label>
							<div class="input-group col-lg-3 col-sm-3 col-md-3  col-xs-12" style="margin-right:10px">
								<input type="text" class="form-control" id="" value="<?php echo $order['logi7'] ? "PARTIAL" : "FULL"; ?>" readonly>
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-2 col-sm-3 col-md-2  col-xs-12 control-label"><?php echo $this->translation->Translation_key("Partial advance amount", $_SESSION['lang_u']); ?></label>
							<div class="input-group col-lg-3 col-sm-3 col-md-3  col-xs-12" style="margin-right:10px">
								<input type="text" class="form-control" id="" value="<?php echo number_format($order['u_etotalp'], 2, '.', ''); ?>" readonly>
							</div>
							<label class="col-lg-2 col-sm-3 col-md-2  col-xs-12 control-label"><?php echo $this->translation->Translation_key("Partial missing amount", $_SESSION['lang_u']); ?></label>
							<div class="input-group col-lg-3 col-sm-3 col-md-3  col-xs-12" style="margin-right:10px">
								<?php
									$missing_amount = 0;
									if( $order["ngstatus"] == "PARTIAL" ) {
										$missing_amount = floatval($order['etotal']) - floatval($order['u_etotalp']);
									}
								?>
								<input type="text" class="form-control" id="" value="<?php echo number_format($missing_amount, 2, '.', ''); ?>" readonly>
							</div>
						</div>
						<div class="form-group">
							<?php //echo (substr(trim($order['U_SESSDATE']), 0, 10))." 23:00:00.000";?>
							<label class="col-lg-2 col-sm-3 col-md-2  col-xs-12 control-label"><?php echo $this->translation->Translation_key("Session", $_SESSION['lang_u']); ?> </label>
							<div class="input-group col-lg-3 col-sm-3 col-md-3  col-xs-8" style="margin-right:2px">
								<input type="date" id="day" class="form-control" value="<?php echo (substr(trim($order['U_SESSDATE']), 0, 10) == "1900-01-01") ? "" : substr(trim($order['U_SESSDATE']), 0, 10); ?>">
							</div>
							<select id="hour" class="form-control" data-inputmask="'mask': '29:59'" style="width:100px" type="text">
								<option value=""></option>
								<?php foreach( $hour as $loc ) { ?>
								<option  value="<?php echo $loc["u_psessstamp"]; ?>" <?php echo $loc["ihour"] ==  $order['ihour'] ? "selected": ""; ?>><?php echo $loc["ihour"]; ?></option>
								<?php } ?>
							</select>
						</div>
					</form>
				</div>
					<table id="DocLinhas" class="table table-striped dataTable no-footer" role="grid">
						<thead>
						  <tr role="row">
							 <th class="sorting_disabled" rowspan="1" colspan="1" style="width: auto;"><?php echo $this->translation->Translation_key("Ref", $_SESSION['lang_u']); ?></th>
							 <th class="sorting_disabled" rowspan="1" colspan="1" style="width: auto;"><?php echo $this->translation->Translation_key("Seat", $_SESSION['lang_u']); ?></th>
							 <th class="sorting_disabled" rowspan="1" colspan="1" style="width: auto;"><?php echo $this->translation->Translation_key("Ticket Category", $_SESSION['lang_u']); ?></th>
							 <th class="sorting_disabled" rowspan="1" colspan="1" style="width: auto;"><?php echo $this->translation->Translation_key("Description", $_SESSION['lang_u']); ?></th>
							 <th class="sorting_disabled" rowspan="1" colspan="1" style="width: auto;">Qtt</th>
							 <th class="sorting_disabled" rowspan="1" colspan="1" style="width: auto;"><?php echo $this->translation->Translation_key("Price", $_SESSION['lang_u']); ?></th>
							 <th class="sorting_disabled" rowspan="1" colspan="1" style="width: auto;"><?php echo $this->translation->Translation_key("IVA", $_SESSION['lang_u']); ?></th>
							 <th class="sorting_disabled" rowspan="1" colspan="1" style="width: auto;"><?php echo $this->translation->Translation_key("Total", $_SESSION['lang_u']); ?></th>
						  </tr>
						</thead>
						<tbody>
						<?php 
						foreach ($order_bi as $value) {
								?>
								<tr role="row" class="odd">
									<td><?php echo $value['ref']; ?></td>
									<td><?php echo $value['cor']; ?></td>
									<td><?php echo $value['tam']; ?></td>
									<td><?php echo $value['design']; ?></td>
									<td><?php echo number_format($value['qtt'], 2, '.', ' '); ?></td>
									<td><?php echo number_format($value['epu'], 2, '.', ' '); ?></td>
									<td><?php echo $value['iva']; ?></td>
									<td><?php echo number_format($value['ettdeb'], 2, '.', ' '); ?></td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
					<div class="col-sm-12">
						<form action="#" class="form-horizontal group-border-dashed clearfix" >
							<div class="form-group pull-right">
								<label class="col-lg-6 col-sm-6 control-label"><?php echo $this->translation->Translation_key("Total", $_SESSION['lang_u']); ?> (EUR)</label>
								<div class="input-group col-lg-4 col-sm-4" style="margin-right:10px">
									<input type="text" class="form-control" id="nome_cliente" value="<?php echo number_format($order['etotal'], 2, '.', ' '); ?>" readonly>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>


<script>
	function resend_tickets() {
		$(".loading-overlay").show();
		var bostamp = '<?php echo $order['bostamp'];?>';
		
		jQuery.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>backoffice/ajax/resend_tickets",
			data: { 
				"bostamp" : bostamp
			},
			success: function(data) 
			{
				if( data != " ") {
					$(".loading-overlay").hide();
					jQuery(document).trigger("add-alerts", [
					{
						"message": "Tickets sent to client and operator email",
						"priority": 'success'
					}
					]);
				}
				else {
					$(".loading-overlay").hide();
					jQuery(document).trigger("add-alerts", [
					{
						"message": "Error resending tickets ",
						"priority": 'error'
					}
					]);
				}
			}
		});
	}

	function mudar_session()
	{
		$(".loading-overlay").show();
		var bostamp = '<?php echo $order['bostamp'];?>';
		var u_psessstamp = $('#hour').val();
		var day = $('#day').val();
		
		jQuery.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>backoffice/ajax/mud_session",
			data: { 
				"bostamp" : bostamp,
				"u_psessstamp" : u_psessstamp,
				"day" : day
				
				
			},
			success: function(data) 
			{
				if( data != " ") {
					$(".loading-overlay").hide();
					jQuery(document).trigger("add-alerts", [
					{
						"message": "Order updated successfully",
						"priority": 'success'
					}
					]);
				}
				else {
					$(".loading-overlay").hide();
					jQuery(document).trigger("add-alerts", [
					{
						"message": "Error updating Order ",
						"priority": 'error'
					}
					]);
				}
			}
		});
	}

</script>