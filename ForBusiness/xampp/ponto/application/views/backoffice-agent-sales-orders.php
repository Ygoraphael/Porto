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
								<label class="col-lg-2 col-sm-3 control-label">Operator</label>
								<div class="input-group col-lg-3 col-sm-3" style="margin-right:10px">
									<select class="form-control" id="agen" name="">
										<option value=""></option>
										<?php foreach($agents as $agent) { ?>
										<option value="<?php echo $agent["flstamp"]; ?>"><?php echo $agent["nome"]; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 col-sm-3 control-label">Final Date</label>
								<div class="input-group col-lg-3 col-sm-3" style="margin-right:10px">
									<input type="date" class="form-control" id="date_f" value="<?php echo date("Y-m-d"); ?>">
								</div>
								<label class="col-lg-2 col-sm-3 control-label">Product</label>
								<div class="input-group col-lg-3 col-sm-3" style="margin-right:10px">
									<select class="form-control" id="prod" name="">
										<option value=""></option>
										<?php foreach($products as $product) { ?>
										<option value="<?php echo $product["bostamp"]; ?>"><?php echo $product["u_name"]; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<button class="btn btn-primary col-lg-12" onclick="atualiza_tabela(); return false;"><i class="white halflings-icon search"></i> Mostrar</button>
							</div>
						</form>
						<table id="tab-p" class="table table-striped table-bordered" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>Client Name</th>
									<th>Operator No</th>
									<th>Operator Name</th>
									<th>Date</th>
									<th>Qtt</th>
									<th>Product Name</th>
									<th>Unit Price Avg.</th>
									<th>Total Sales</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
							<tfoot>
								<tr>
									<th></th>
									<th></th>
									<th></th>
									<th></th>
									<th class="text-center" id="total_qtt">Qtt</th>
									<th></th>
									<th class="text-center" id="total_avg">Total Sales</th>
									<th class="text-center" id="total_sales">Total Sales</th>
								</tr>
							</tfoot>
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
			]
		});
		atualiza_tabela();
	})

	function atualiza_tabela()
	{
		$(".loading-overlay").show();
		
		jQuery.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>backoffice/ajax/get_agent_sales",
			data: { 
				"date_i" : jQuery("#date_i").val().replace(/\-/g,''),
				"date_f" : jQuery("#date_f").val().replace(/\-/g,''),
				"agen" : jQuery("#agen").val(),
				"prod" : jQuery("#prod").val()
			},
			success: function(data) 
			{
				data = JSON.parse(data);
				t.clear().draw();
				total_qtt = 0;
				total_sales = 0;
				total_avg = 0;
				
				$.each(data, function(index, value) {
					var dados = new Array();
					
					dados.push(value["email"]);
					dados.push(value["opno"]);
					dados.push(value["opnome"]);
					dados.push(value["fdata"].substring(0, 10));
					dados.push(parseFloat(value["qtt"]).toFixed(2));
					dados.push(value["pdnome"]);
					dados.push(parseFloat(value["epv"]).toFixed(2));
					dados.push(parseFloat(value["ettiliq"]).toFixed(2));
						
					total_qtt += parseFloat(value["qtt"]);
					total_sales += parseFloat(value["ettiliq"]);
					
					t.row.add(dados).draw();
				});

				jQuery("#total_qtt").html(total_qtt.toFixed(2));
				jQuery("#total_sales").html(total_sales.toFixed(2));
				if( total_qtt != 0 )
					jQuery("#total_avg").html((total_sales/total_qtt).toFixed(2));
				else
					jQuery("#total_avg").html((0).toFixed(2));
				
				$(".loading-overlay").hide();
			}
		});
	}
</script>
