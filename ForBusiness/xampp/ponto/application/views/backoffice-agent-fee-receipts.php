<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<div class="clearfix page-head col-md-12">
	<div class="col-md-12 col-sm-12">
		<h2 class="col-md-6 col-sm-6"><?php echo $title; ?></h2>
		<a  id="create_prod" class="btn btn-info pull-right" href="<?php echo base_url(); ?>backoffice/add_fee_receipts">Add Fee Receipts</a>
	</div>
</div>
<div class="col-md-12 col-sm-12 clearfix" data-alerts="alerts" data-fade="3000"></div>
<div class="main-content col-sm-12">
	<div class="col-lg-12">
		<table id="tab-fees" class="table table-striped table-bordered" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th>Date</th>
					<th>Value</th>
					<th>Document Number</th>
					<th>Description</th>
					<th>File</th>
					<th>Status</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach( $fees as $fee ) { ?>
				<tr>
					<td><?php echo substr($fee["data"], 0, 10); ?></td>
					<td><?php echo number_format(floatval($fee["etotal"]), 2, ".", ""); ?></td>
					<td><?php echo $fee["adoc"]; ?></td>
					<td><?php echo $fee["design"]; ?></td>
					<td><a target="_blank" href="<?php echo base_url() . 'pdf_fees/' . $fee["u_docpath"]; ?>"><?php echo $fee["u_docpath"]; ?></a></td>
					<td><?php echo $fee["status"]; ?></td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
	</div>
</div>
<script>
var t;

jQuery(document).ready(function() {
	t = $('#tab-fees').DataTable({
		dom: 'lBfrtip',
		buttons: [
			{
				extend:    'copy',
				text:      '<i class="fa fa-copy"></i> Copy',
				titleAttr: 'Copy'
			},
			{
				extend:    'csv',
				text:      '<i class="fa fa-file-text-o"></i> CSV',
				titleAttr: 'CSV'
			},
			{
				extend:    'excel',
				text:      '<i class="fa fa-file-excel-o"></i> Excel',
				titleAttr: 'Excel'
			},
			{
				extend:    'pdf',
				text:      '<i class="fa fa-file-pdf-o"></i> PDF',
				titleAttr: 'PDF'
			},
			{
				extend:    'print',
				text: '<i class="fa fa-print"></i> Print',
				titleAttr: 'Print'
			}
		]
	});

})
</script>