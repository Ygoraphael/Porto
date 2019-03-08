<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
		<div class="page-head col-md-12">
			<div class="col-md-12 col-sm-12">
				<h2 class="col-md-6 col-sm-6"><?php echo $title; ?></h2>
					<a href="<?php echo base_url() . 'backoffice/agent_manual_reimbursement'; ?>" class="btn btn-info btn-lg pull-right">Manual Reimburse</a>
					<a href="<?php echo base_url() . 'backoffice/agent_mb_reimbursement'; ?>" class="btn btn-info btn-lg pull-right">Multibanco Reimburse</a>
			</div>
		</div>
		<div class="clearfix" data-alerts="alerts" data-fade="3000"></div>
		<div class="main-content col-sm-12">
			<div class="panel panel-default">
				<div class="col-xs-12">
					<h3>Last 10 Reimbursements</h3>
					<table id="tab-p" class="table table-striped table-bordered" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th>Operator No</th>
								<th>Operator Name</th>
								<th>Date</th>
								<th>Type</th>
								<th>Total</th>
								<th class="text-center">Status</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($reimbursements as $reimbursement) { ?>
								<tr>
									<td><?php echo $reimbursement["u_opno"]; ?></td>
									<td><?php echo $reimbursement["nome"]; ?></td>
									<td><?php echo substr($reimbursement["data"], 0, 10); ?></td>
									<td>
										<?php
											switch( $reimbursement["formapag"] ) {
												case "1":
													echo "NOT DEFINED";
													break;
												case "2":
													echo "MANUAL";
													break;
												case "4":
													echo "MULTIBANCO";
													break;
											}
										?>
									</td>
									<td><?php echo number_format($reimbursement["etotal"], 2, '.', ''); ?></td>
									<td class="text-center"><?php echo ($reimbursement["aprovado"] == 0 ) ? '<i class="glyphicon glyphicon-remove" style="color:red;"></i>' : '<i class="glyphicon glyphicon-ok" style="color:green;"></i>'; ?></td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	var t;
	
	jQuery(document).ready(function() {
		t = $('#tab-p').DataTable({
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
