<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
		<div class="page-head col-md-12">
			<div class="col-md-12 col-sm-12">
				<h2 class="col-md-6 col-sm-6"><?php echo $title; ?></h2>
				<button type="button" id="process" class="btn btn-info pull-right">SET PROCESSED</button>
			</div>
		</div>
		<div class="clearfix" data-alerts="alerts" data-fade="3000"></div>
		<div class="main-content col-sm-12">
			<div class="panel panel-default">
				<div class="col-xs-12">
					<form action="#" class="form-horizontal group-border-dashed clearfix" >
						<div class="form-group">
							<label class="col-lg-2 col-sm-3 control-label">Initial Date</label>
							<div class="input-group col-lg-3 col-sm-3" style="margin-right:10px">
								<input type="date" class="form-control" id="date_i" value="<?php echo date("Y-m-d"); ?>">
							</div>
							<label class="col-lg-2 col-sm-3 control-label">Agent</label>
							<div class="input-group col-lg-3 col-sm-3" style="margin-right:10px">
								<select class="form-control" id="ag" name="">
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
							<label class="col-lg-2 col-sm-3 control-label">Unprocessed only</label>
							<div class="input-group col-lg-3 col-sm-3" style="margin-right:10px">
								<select class="form-control" id="status" name="">
									<option value=""></option>
									<option value="1">YES</option>
									<option value="0" selected>NO</option>
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
								<th>Agent No</th>
								<th>Agent Name</th>
								<th>Date</th>
								<th>Type</th>
								<th>Total</th>
								<th class="text-center">Status</th>
								<th class="text-center"> 
									<div class="am-checkbox" style="text-align: -webkit-center;">
										<input type="checkbox" id="select_all">
										<label for="select_all"></label>							
									</div>
								</th>
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

<script>
var t;

jQuery(document).ready(function() {
	$('#select_all').change(function() {
		var what = $(this).is(':checked');
		$('.checkboxes').each(function(i, obj) {
			if( what ) {
				$(this).prop('checked', true);
			} else {
				$(this).prop('checked', false);
			}
		});
	});
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
			"ordering": false,
			"columnDefs": [
				{"className": "text-center", "targets": [5, 6]}
			],
	});
	atualiza_tabela();
})

jQuery("#process").click(function() {
	var fostamps = new Array();
	$('.checkboxes').each(function(i, obj) {
		if( $(this).prop('checked') )
			fostamps.push( "'" + $(this).attr('id').toString().trim() + "'");
	});
	
	if( fostamps.length > 0 ) {
		$(".loading-overlay").show();
	
		jQuery.ajax({
			type: "POST",
			url: "<?php echo base_url(); ?>backoffice/ajax/set_reimbursements_processed",
			data: { 
				"fostamps" : JSON.stringify(fostamps)
			},
			success: function(data) 
			{
				if( data == 1)
					atualiza_tabela();
			}
		});
	}
})

function atualiza_tabela()
{
	$(".loading-overlay").show();
	
	jQuery.ajax({
		type: "POST",
		url: "<?php echo base_url(); ?>backoffice/ajax/get_reimbursements",
		data: { 
			"date_i" : jQuery("#date_i").val().replace(/\-/g,''),
			"date_f" : jQuery("#date_f").val().replace(/\-/g,''),
			"ag" : jQuery("#ag").val(),
			"status" : jQuery("#status").val()
		},
		success: function(data) 
		{
			data = JSON.parse(data);
			
			t.clear().draw();

			$.each(data, function(index, value) {
				var dados = new Array();
				dados.push(value["no"]);
				dados.push(value["nome"]);
				dados.push(value["data"].substr(0, 10));
				
				switch( value["formapag"] ) {
					case "1":
						dados.push("NOT DEFINED");
						break;
					case "2":
						dados.push("MANUAL");
						break;
					case "4":
						dados.push("MULTIBANCO");
						break;
				}
				
				dados.push(parseFloat(value["etotal"]).toFixed(2));				
				if( value["aprovado"] == "0" )
					dados.push('<i class="glyphicon glyphicon-remove" style="color:red;"></i>');
				else
					dados.push('<i class="glyphicon glyphicon-ok" style="color:green;"></i>');
				
				var check = '<div class="am-checkbox clearfix">';
				check += '<input name="' + value["fostamp"] + '" class="checkboxes" id="' + value["fostamp"] + '" type="checkbox">';
				check += '<label class="" for="' + value["fostamp"] + '"></label>';
				check += '</div>';
				
				if( value["aprovado"] == "0" ) {
					dados.push(check);
				}
				else {
					dados.push("");
				}
				
				t.row.add(dados).draw();
			});
			
			$("#select_all").prop("checked", false);
			$(".loading-overlay").hide();
		}
	});
}
</script>
