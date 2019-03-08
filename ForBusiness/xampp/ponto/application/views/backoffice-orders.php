<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
		<div class="col-sm-12 col-md-12 col-xs-12">
			<div class="row setup-content">
				<div class="col-sm-12 col-md-12 col-xs-12">
					<div class="col-sm-12 col-md-12 col-xs-12 well text-center">
						<form action="#" class="form-horizontal group-border-dashed clearfix" >
							<div class="form-group">
								<label class="col-lg-2 col-sm-3 col-md-2 col-xs-12 control-label">Initial Date</label>
								<div class="input-group col-lg-3 col-sm-3 col-md-2 col-xs-12 " style="margin-right:10px">
									<input type="date" class="form-control" id="date_i" value="<?php echo date("Y-m-d"); ?>">
								</div>
								<?php  if( $user["u_operador"] == 'Sim' ) { ?>
								<label class="col-lg-2 col-sm-3 col-md-2 col-xs-12 control-label">Agents</label>
								<?php }else{ ?>
								<label class="col-lg-2 col-sm-3 col-md-2 col-xs-12 control-label">Operators</label>
								<?php } ?>
								<div class="input-group col-lg-3 col-sm-3 col-md-2 col-xs-12 " style="margin-right:10px">
									<select class="form-control" id="agen" name="">
										<option value=""></option>
										<?php foreach($agents as $agent) { ?>
										<option value="<?php echo $agent["no"]; ?>"><?php echo $agent["nome"]; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-lg-2 col-sm-3 col-md-2 col-xs-12 control-label">Final Date</label>
								<div class="input-group col-lg-3 col-sm-3 col-md-2 col-xs-12" style="margin-right:10px">
									<input type="date" class="form-control" id="date_f" value="<?php echo date("Y-m-d"); ?>">
								</div>
								<label class="col-lg-2 col-sm-3 col-md-2 col-xs-12 control-label">Product</label>
								<div class="input-group col-lg-3 col-sm-3 col-md-2 col-xs-12 col-md-2 col-xs-12" style="margin-right:10px">
									<select class="form-control" id="prod" name="">
										<option value=""></option>
										<?php foreach($products as $product) { ?>
										<option value="<?php echo $product["bostamp"]; ?>"><?php echo $product["u_name"]; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-2 col-sm-3 col-md-2 col-xs-12 control-label">Payment type</label>
								<div class="input-group col-lg-3 col-sm-3 col-md-2 col-xs-12 style="margin-right:10px">
										<select class="form-control" id="payment" name="">
											<?php foreach($payments as $payment) { ?>
											<option value="<?php echo $payment["payment"]; ?>"><?php echo $payment["payment"]; ?></option>
											<?php } ?>
										</select>
								</div>
								<label class="col-lg-2 col-sm-3 col-md-2 col-xs-12 control-label">Local</label>
								<div class="input-group col-lg-3 col-sm-3 col-md-2 col-xs-12" style="margin-right:10px">
									<select class="form-control" id="local" name="">
										<option value=""></option>
										<?php foreach($locals as $local) { ?>
										<option value="<?php echo $local["campo"]; ?>"><?php echo $local["campo"]; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<button class="btn btn-primary col-sm-12 col-md-12 col-xs-12" onclick="atualiza_tabela(); return false;"><i class="white halflings-icon search"></i>SHOW</button>
							</div>
						</form>
						<table id="tab-p" class="table table-striped table-bordered" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>Order Number</th>
									<th>Client Name</th>
									<th>Product</th>
									<th>Date</th>
									<th>Status</th>
									<th></th>
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
<form method="post" id="theForm" action="orders">
<input id="theFormid" type="hidden" name="id" value="1">
</form>

<script>
	var t;
	
	jQuery(document).ready(function() {
		t = $('#tab-p').DataTable();
		atualiza_tabela();
	})

	function atualiza_tabela()
	{
		$(".loading-overlay").show();
		
		jQuery.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>backoffice/ajax/get_orders",
			data: { 
				"date_i" : jQuery("#date_i").val().replace(/\-/g,''),
				"date_f" : jQuery("#date_f").val().replace(/\-/g,''),
				"agen" : jQuery("#agen").val(),
				"prod" : jQuery("#prod").val(),
				"payment" : jQuery("#payment").val(),
				"local" : jQuery("#local").val(),
				"user_type" : '<?php  echo $user["u_operador"]; ?>'
			},
			success: function(data) 
			{
				data = JSON.parse(data);
				t.clear().draw();
				
				
				$.each(data, function(index, value) {
					var dados = new Array();
					
					dados.push(value["orderno"]);
					dados.push(value["name"]);
					dados.push(value["product"]);
					dados.push(value["date"].substring(0,10));
					dados.push(value["status"]);
					dados.push('<a onclick="edit_item(\''+value["bostamp"]+'\')" class="<?php echo ($order_view)?"":"disabled" ?> btn btn-default"><span class="glyphicon glyphicon-search"></span></a>');
					;
					
					t.row.add(dados).draw();
				});

				
				$(".loading-overlay").hide();
			}
		});
	}
	
	function edit_item(id){
	$('#theFormid').val(id);
	$('#theForm').submit()
	}
</script>
