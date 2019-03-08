<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<div style="margin-top:25px;"></div>

<div class="container">
	<div class="row">
		<div class="col-lg-9">
			<div class="main-content col-sm-12 col-md-12 col-xs-12">
				<div class="panel panel-default">
					<div class="col-sm-12 col-md-12 col-xs-12">
						<form action="#" class="form-horizontal group-border-dashed clearfix" >
						<br>
							<div class="form-group col-lg-6 col-sm-6  col-md-6 col-xs-12 ">
								<label class="col-lg-6 col-sm-6  col-md-6 col-xs-12 control-label">Name</label>
								<div class="input-group col-lg-6 col-sm-6  col-md-6 col-xs-12" style="margin-right:10px;">
									<input type="text" class="form-control" id="nome_cliente" value="<?php echo $order['nome']; ?>" readonly>
								</div>
								<label class="col-lg-6 col-sm-6  col-md-6  col-xs-12 control-label" style="margin-top:12px">Nº Client</label>
								<div class="input-group col-lg-6 col-sm-6  col-md-6 col-xs-12" style="margin-right:10px; margin-top:10px">
									<input type="text" class="form-control" id="nome_cliente" value="<?php echo $order['no']; ?>" readonly>
								</div>
							</div>
							<div class="form-group col-lg-6 col-sm-6  col-md-6 col-xs-12 ">
								<label class="col-lg-6 col-sm-6  col-md-6  col-xs-12 control-label">Nº Cont</label>
								<div class="input-group col-lg-6 col-sm-6  col-md-6 col-xs-12" style="margin-right:10px;">
									<input type="text" class="form-control" id="nome_cliente" value="<?php echo $order['ncont']; ?>" readonly>
								</div>
								<label class="col-lg-6 col-sm-6  col-md-6  col-xs-12 control-label" style="margin-top:12px">Address</label>
								<div class="input-group col-lg-6 col-sm-6  col-md-6 col-xs-12" style="margin-right:10px; margin-top:10px">
									<input type="text" class="form-control" id="nome_cliente" value="<?php echo $order['morada']; ?>" readonly>
								</div>
							</div>
							<div class="form-group col-lg-6 col-sm-6  col-md-6 col-xs-12 ">
								<label class="col-lg-6 col-sm-6  col-md-6  col-xs-12 control-label" >Postal Code</label>
								<div class="input-group col-lg-6 col-sm-6  col-md-6 col-xs-12" style="margin-right:10px;">
									<input type="text" class="form-control" id="nome_cliente" value="<?php echo $order['codpost']; ?>" readonly>
								</div>
								<label class="col-lg-6 col-sm-6  col-md-6  col-xs-12 control-label" style="margin-top:12px">Local</label>
								<div class="input-group col-lg-6 col-sm-6  col-md-6 col-xs-12" style="margin-right:10px; margin-top:10px">
									<input type="text" class="form-control" id="nome_cliente" value="<?php echo $order['local']; ?>" readonly>
								</div>
							</div>
							<div class="form-group col-lg-6 col-sm-6  col-md-6 col-xs-12 ">
								<label class="col-lg-6 col-sm-6  col-md-6  col-xs-12 control-label" >Order Date</label>
								<div class="input-group col-lg-6 col-sm-6  col-md-6 col-xs-12" style="margin-right:10px;">
									<input type="text" class="form-control" id="nome_cliente" value="<?php echo substr($order['dataobra'], 0, 10); ?>" readonly>
								</div>
							
								<label class="col-lg-6 col-sm-6  col-md-6  col-xs-12 control-label" style="margin-top:12px">Product</label>
								<div class="input-group col-lg-6 col-sm-6  col-md-6 col-xs-12" style="margin-right:10px; margin-top:10px">
									<input type="text" class="form-control" id="nome_cliente" value="<?php echo $order['product']; ?>" readonly>
								</div>
							</div>
							<div class="form-group col-lg-6 col-sm-6  col-md-6 col-xs-12 ">
							<label class="col-lg-6 col-sm-6  col-md-6  col-xs-12 control-label" >Status</label>
								<div class="input-group col-lg-6 col-sm-6  col-md-6 col-xs-12" style="margin-right:10px;">
									<table><tr><td class="<?php echo $order["class"];?> text-center"><span class="label"><?php echo $order["ngstatus"];?></span></td></tr></table>
								</div>

							</div>
							
							<div class="form-group col-lg-6 col-sm-6  col-md-6 col-xs-12 ">
								<label class="col-lg-6 col-sm-6  col-md-6  col-xs-12 control-label">Session</label>
								<div class="input-group col-lg-6 col-sm-6  col-md-6 col-xs-12" style="margin-right:10px; ">
									<input type="text" class="form-control" id="nome_cliente" value="<?php echo substr($order['U_SESSDATE'], 0, 10).' / '.$order['ihour']; ?>" readonly>
								</div>
								<label class="col-lg-6 col-sm-6  col-md-6  col-xs-12 control-label" style="margin-top:12px">Payment type</label>
								<div class="input-group col-lg-6 col-sm-6  col-md-6 col-xs-12" style="margin-right:10px; margin-top:10px">
									<input type="text" class="form-control" id="nome_cliente" value="<?php echo substr($order['IDENTIFICACAO2'], 0, 10); ?>" readonly>
								</div>
							</div>
						</form>
						<table id="DocLinhas" class="table table-striped dataTable no-footer" role="grid">
							<thead>
							  <tr role="row">
								 <th class="sorting_disabled" rowspan="1" colspan="1" style="width: auto;">Ref</th>
								 <th class="sorting_disabled" rowspan="1" colspan="1" style="width: auto;">Seat</th>
								 <th class="sorting_disabled" rowspan="1" colspan="1" style="width: auto;">Ticket Category</th>
								 <th class="sorting_disabled" rowspan="1" colspan="1" style="width: auto;">Description</th>
								 <th class="sorting_disabled" rowspan="1" colspan="1" style="width: auto;">Qtt</th>
								 <th class="sorting_disabled" rowspan="1" colspan="1" style="width: auto;">Price</th>
								 <th class="sorting_disabled" rowspan="1" colspan="1" style="width: auto;">IVA</th>
								 <th class="sorting_disabled" rowspan="1" colspan="1" style="width: auto;">Total</th>
							  </tr>
							</thead>
							<tbody>
							<?php 
							foreach ($order_bi as $value) {
									?>
									<tr role="row" class="odd">
										<td><?php echo $value['ref']; ?></td>
										<td><?php echo ($value['cor'] == "ND")? "":$value['cor']; ?></td>
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
									<label class="col-lg-6 col-sm-6  control-label"style="margin-top:12px">Total (EUR)</label>
									<div class="input-group col-lg-4 col-sm-4" style="margin-right:10px; margin-top:10px">
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
</div>
</div>