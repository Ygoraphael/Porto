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
								<label class="col-lg-2 col-sm-3 control-label"><?php echo $this->translation->Translation_key("Initial Date", $_SESSION['lang_u']); ?></label>
								<div class="input-group col-lg-3 col-sm-3" style="margin-right:10px">
									<input type="date" class="form-control" id="date_i" value="<?php echo date("Y-m-d"); ?>">
								</div>
								<label class="col-lg-2 col-sm-3 control-label"><?php echo $this->translation->Translation_key("Operator", $_SESSION['lang_u']); ?></label>
								<div class="input-group col-lg-3 col-sm-3" style="margin-right:10px">
									<select class="form-control" id="op" name="">
										<option value=""></option>
										<?php foreach($operators as $operator) { ?>
										<option value="<?php echo $operator["no"]; ?>"><?php echo $operator["nome"]; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 col-sm-3 control-label"><?php echo $this->translation->Translation_key("Final Date", $_SESSION['lang_u']); ?></label>
								<div class="input-group col-lg-3 col-sm-3" style="margin-right:10px">
									<input type="date" class="form-control" id="date_f" value="<?php echo date("Y-m-d"); ?>">
								</div>
							</div>
							<div class="form-group">
								<button class="btn btn-primary col-lg-12" onclick="atualiza_tabela(); return false;"><i class="white halflings-icon search"></i><?php echo $this->translation->Translation_key("Mostrar", $_SESSION['lang_u']); ?> </button>
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
									<th><?php echo $this->translation->Translation_key("Date", $_SESSION['lang_u']); ?></th>
									<th><?php echo $this->translation->Translation_key("Product", $_SESSION['lang_u']); ?></th>
									<th>Qtt</th>
									<th><?php echo $this->translation->Translation_key("Payment", $_SESSION['lang_u']); ?></th>
									<th><?php echo $this->translation->Translation_key("Dest. Account", $_SESSION['lang_u']); ?></th>
									<th><?php echo $this->translation->Translation_key("Operator", $_SESSION['lang_u']); ?></th>
									<th><?php echo $this->translation->Translation_key("Unit Price", $_SESSION['lang_u']); ?></th>
									<th><?php echo $this->translation->Translation_key("Value", $_SESSION['lang_u']); ?></th>
									<th><?php echo $this->translation->Translation_key("EWA Value", $_SESSION['lang_u']); ?></th>
									<th><?php echo $this->translation->Translation_key("Operator Value", $_SESSION['lang_u']); ?></th>
									<th><?php echo $this->translation->Translation_key("Agent Value", $_SESSION['lang_u']); ?></th>
									<th><?php echo $this->translation->Translation_key("EWA Balance", $_SESSION['lang_u']); ?></th>
									<th><?php echo $this->translation->Translation_key("Operator Balance", $_SESSION['lang_u']); ?></th>
									<th><?php echo $this->translation->Translation_key("Agent Balance", $_SESSION['lang_u']); ?></th>
									<th><?php echo $this->translation->Translation_key("Status", $_SESSION['lang_u']); ?></th>
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
		t = $('#tab-p').DataTable( {
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
			url: "<?php echo base_url(); ?>backoffice/ajax/get_agent_treasury",
			data: { 
				"date_i" : jQuery("#date_i").val().replace(/\-/g,''),
				"date_f" : jQuery("#date_f").val().replace(/\-/g,''),
				"opno" : jQuery("#op").val(),
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
