<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<div class="clearfix page-head col-md-12">
	<div class="col-md-12 col-sm-12">
		<h2 class="col-md-6 col-sm-6"><?php echo $title; ?></h2>
	</div>
</div>
<div class="col-md-12 col-sm-12 clearfix" data-alerts="alerts" data-fade="3000"></div>
<div class="main-content col-sm-12">
	<div class="col-lg-12">
		<table id="tab-customers" class="table table-striped table-bordered" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th>Name</th>
					<th>Email</th>
					<th>Tax identification number</th>
					<th>City</th>
					<th>Phone</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
			<?php foreach( $customers as $customer ) {?>
				<tr>
					<td><?php echo $customer["first_name"]." ".$customer["last_name"]; ?></td>
					<td><?php echo $customer["email"]; ?></td>
					<td><?php echo $customer["tax_number"]; ?></td>
					<td><?php echo $customer["invoice_address_addinfo"]; ?></td>
					<td><?php echo $customer["phone_no"]; ?></td>	
					<td class="text-center"><a href="<?php echo base_url(); ?>backoffice/customer/<?php echo $customer["id"]; ?>" class="btn btn-default <?php echo ($acesso_view)?"":"disabled" ?>"><span class="glyphicon glyphicon-search"></span></a></td>					
				</tr>
			<?php } ?>
			</tbody>
		</table>
		<script>
			jQuery(document).ready(function() {
				jQuery('#tab-customers').DataTable();
			});
			
		</script>
	</div>
</div>