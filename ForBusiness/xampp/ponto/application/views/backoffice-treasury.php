<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
		<div class="col-lg-12">
			<div class="row setup-content">
				<div class="col-xs-12">
					<div class="col-md-12 well text-center">
						<form action="#" class="form-horizontal group-border-dashed clearfix" >
							<div class="form-group">
								<label class="col-lg-2 col-sm-3 control-label">Initial Date</label>
								<div class="input-group col-lg-3 col-sm-3" style="margin-right:10px">
									<input type="date" class="form-control" id="date_i" value="<?php echo date("Y-m-d"); ?>">
								</div>
								<label class="col-lg-2 col-sm-3 control-label">Agent</label>
								<div class="input-group col-lg-3 col-sm-3" style="margin-right:10px">
									<select class="form-control" id="agen" name="">
										<option value=""></option>
										<?php foreach($agents as $agent) { ?>
										<option value="<?php echo $agent["no"]; ?>"><?php echo $agent["nome"]; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 col-sm-3 control-label">Final Date</label>
								<div class="input-group col-lg-3 col-sm-3" style="margin-right:10px">
									<input type="date" class="form-control" id="date_f" value="<?php echo date("Y-m-d"); ?>">
								</div>
								<label class="col-lg-2 col-sm-3 control-label">Location</label>
								<div class="input-group col-lg-3 col-sm-3" style="margin-right:10px">
									<select class="form-control" id="local" name="">
										<option value=""></option>
										<?php foreach($locations as $location) { ?>
										<option value="<?php echo $location["name"]; ?>"><?php echo $location["name"]; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<button class="btn btn-primary col-lg-12" onclick="atualiza_tabela(); return false;"><i class="white halflings-icon search"></i> Mostrar</button>
							</div>
						</form>
						<style>
							#tab-p * {
								font-size: 11px;
							}
							
							#tab-p tr {
								padding:0;
							}
							
							#tab-p_wrapper .col-sm-12 {
								margin:0;
								padding:0;
							}
						</style>
						<table id="tab-p" class="table table-striped table-bordered" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>Date</th>
									<th>Product</th>
									<th>Qtt</th>
									<th>Payment</th>
									<th>Dest. Account</th>
									<th>Agent</th>
									<th>Unit Price</th>
									<th>Value</th>
									<th>EWA Value</th>
									<th>Operator Value</th>
									<th>Agent Value</th>
									<th>EWA Balance</th>
									<th>Operator Balance</th>
									<th>Agent Balance</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
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
			],
			"autoWidth": false,
			"ordering": false
		});
		atualiza_tabela();
	})

	function atualiza_tabela()
	{
		$(".loading-overlay").show();
		
		jQuery.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>backoffice/ajax/get_treasury",
			data: { 
				"date_i" : jQuery("#date_i").val().replace(/\-/g,''),
				"date_f" : jQuery("#date_f").val().replace(/\-/g,''),
				"agen" : jQuery("#agen").val(),
				"local" : jQuery("#local").val()
			},
			success: function(data) 
			{
				data = JSON.parse(data);
				
				t.clear().draw();
				// total_qtt = 0;
				// total_avg = 0;
				// total_sales = 0;
				// ag_fees = 0;
				// book_fees = 0;
				// trans_fees = 0;
				// total_pay = 0;
				// total_rec = 0;
				
				$.each(data, function(index, value) {
					var dados = new Array();
					
					dados.push(value["data"].substr(0, 10));
					dados.push(value["produto"]);
					dados.push(parseFloat(value["qtt"]).toFixed(2));
					dados.push(value["formapag"]);
					dados.push(value["conta_destino"]);
					dados.push(value["agno"]);
					dados.push(parseFloat(value["epv"]).toFixed(2));
					dados.push(parseFloat(value["valor"]).toFixed(2));
					dados.push(parseFloat(value["ewa"]).toFixed(2));
					dados.push(parseFloat(value["operador"]).toFixed(2));
					dados.push(parseFloat(value["agente"]).toFixed(2));
					dados.push(parseFloat(value["saldo_ewa"]).toFixed(2));
					dados.push(parseFloat(value["saldo_op"]).toFixed(2));
					dados.push(parseFloat(value["saldo_ag"]).toFixed(2));
					if( value["status"] == "UNPROCESSED" )
						dados.push('<i class="glyphicon glyphicon-remove" style="color:red;"></i>');
					else
						dados.push('<i class="glyphicon glyphicon-ok" style="color:green;"></i>');
					
					// total_qtt += parseFloat(value["qtt"]);
					// total_sales += parseFloat(value["ettiliq"]);
					// ag_fees += parseFloat(value["agcom"]);
					// book_fees += parseFloat(value["s4bcom"]);
					// trans_fees += parseFloat(value["s4pcom"]);
					// total_pay += parseFloat(value["tpag"]);
					// total_rec += parseFloat(value["trec"]);
					
					t.row.add(dados).draw();
				});
				
				// jQuery("#total_qtt").html(total_qtt.toFixed(2));
				// jQuery("#total_sales").html(total_sales.toFixed(2));
				// if( total_qtt != 0 )
					// jQuery("#total_avg").html((total_sales/total_qtt).toFixed(2));
				// else
					// jQuery("#total_avg").html((0).toFixed(2));
				// jQuery("#ag_fees").html(ag_fees.toFixed(2));
				// jQuery("#book_fees").html(book_fees.toFixed(2));
				// jQuery("#trans_fees").html(trans_fees.toFixed(2));
				// jQuery("#total_pay").html(total_pay.toFixed(2));
				// jQuery("#total_rec").html(total_rec.toFixed(2));
				
				$(".loading-overlay").hide();
			}
		});
	}
</script>
