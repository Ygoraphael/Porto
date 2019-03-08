<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<div style="margin-top:25px;"></div>

<div class="container">
	<div class="row">
		<div class="col-lg-9">
			<form class="form-horizontal">
				<fieldset>
					<!-- Form Name -->
					<legend style="color:white;"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Orders'); ?></legend>
				</fieldset>
				<div class="table-responsive">
					<table class="table table-bordered account-orders-table">
						<thead>
							<tr>
								<th>#</th>
								<th><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Order Date'); ?></th>
								<th><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Reservation Date'); ?></th>
								<th><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Reservation Hour'); ?></th>
								<th><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Price'); ?></th>
								<th class="text-center"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Status'); ?></th>
								<th></th>
							</tr>
						</thead>
						<?php foreach( $orders as $order ) { ?>
						<tbody>
							<tr>
								<td><?php echo $order["obrano"];?></td>
								<td><?php echo substr($order["dataobra"], 0, 10);?></td>
								<td><?php echo substr($order["u_sessdate"], 0, 10);?></td>
								<td><?php echo $order["ihour"];?></td>
								<td><i class="fa"><?php echo $_SESSION["i"];?></i> <?php echo $this->currency->valor($order["etotaldeb"]);?></td>
								<td class="<?php echo $order["class"];?> text-center"><span class="label"><?php echo $order["ngstatus"];?></span></td>
								<td class="text-center nomarginpadding"><button onclick="window.location.href='<?php echo base_url(); ?>wl/<?php echo $op; ?>/account_order/<?php echo $order["bo3stamp"]; ?>'" type="button" class="btn order-details"><span class="glyphicon glyphicon-search"></span> DETAILS</button></td>
							</tr>
						<?php } ?>
						</tbody>
					</table>
				</div>
			</form>
		</div>
	</div>
</div>
	</div>
</div>