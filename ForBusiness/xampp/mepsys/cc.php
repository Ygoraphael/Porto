<!DOCTYPE html>
<html lang="pt">
<head>
	<?php include("header.php"); ?>
</head>
<body>
	<!-- start: Header -->
	<?php include("nav_bar.php"); ?>
	<!-- start: Header -->
	<div class="container-fluid-full">
		<div class="row-fluid">
			<!-- start: Main Menu -->
			<?php include("menu.php"); ?>
			<!-- end: Main Menu -->
			<noscript>
				<div class="alert alert-block span10">
					<h4 class="alert-heading">Warning!</h4>
					<p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
				</div>
			</noscript>
			<!-- start: Content -->
			<div id="content" class="span10">
				<?php 
					$current_page = "Conta Corrente";
					include("breadcrumbs.php"); 
				?>
				<div class="row-fluid" style="margin-bottom:10px">
					<button type="submit" class="btn btn-primary" onclick="window.history.go(-1); return false;" ><i class="white halflings-icon circle-arrow-left"></i> Voltar</button>
				</div>
				<div class="row-fluid">
					<form class="form-horizontal span6">
						<div class="control-group">
							<label class="control-label" for="DataI">Data Inicial</label>
							<div class="controls">
								<input type="date" class="span8" value="<?php echo date("Y-m-d"); ?>" id="DataI">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="DataF">Data Final</label>
							<div class="controls">
								<input type="date" class="span8" value="<?php echo date("Y-m-d"); ?>" id="DataF">
							</div>
						</div>
						<div class="control-group">
						<div class="controls">
							<a onclick="filtra_cc();" class="quick-button blue span8">
								<p style="color:white; font-size:1.9vh;">FILTRAR</p>
							</a>
						</div>
					</form>
				</div>
				<div class="row-fluid">
					<table id="TabCC" class="table table-striped">
						<thead>
							<tr>
								<th>Data</th>
								<th>Vencimento</th>
								<th>Documento</th>
								<th>Nº Doc.</th>
								<th>Débito</th>
								<th>Crédito</th>
								<th>Saldo</th>
								<th>Obs.</th>
								<th>Inc. Documento</th>
								<th></th>
							</tr>
						</thead>   
						<tbody>
						</tbody>
					</table>
				</div>
			</div>
		</div><!--/.fluid-container-->
			<!-- end: Content -->
	</div><!--/#content.span10-->	
	<script>
		var table;
		
		$(document).ready(function () {
			table = $('#TabCC').DataTable({
				dom: 'lBfrtip',
				buttons: [
					{
						extend:    'copy',
						text:      '<i class="fa fa-copy"></i> Copiar',
						titleAttr: 'Copiar'
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
						text: '<i class="fa fa-print"></i> Imprimir',
						titleAttr: 'Imprimir'
					}
				],
				oLanguage: {
					sSearch: "Procurar:",
					oPaginate: {
						sFirst:		"Primeiro",
						sLast:		"Último",
						sNext:		"Seguinte",
						sPrevious:	"Anterior"
					},
					"sInfo": "A mostrar _START_ até _END_ registos de um total de _TOTAL_ registos",
					"sLengthMenu":     "Mostrar _MENU_ registos"
				},
				"iDisplayLength": 100,
				sPaginationType : "full_numbers",
				"columnDefs": [
					{ "width": "200px", "targets": 7 }
				]
			});
			
			filtra_cc();
		});
		
		function filtra_cc() {
			ActivateLoading();
			
			jQuery.ajax({
				type: "POST",
				url: "funcoes_gerais.php",
				data: { "action" : "getClienteCC(<?php echo $_GET['id']; ?>, '"+jQuery("#DataI").val()+"', '"+jQuery("#DataF").val()+"');"},
				success: function(data) 
				{
					var obj = JSON.parse(data);

					table.rows().remove().draw();
					
					var saldo = 0;
					
					$.each(obj["data2"], function(index, value2) {
						var dados = new Array();
						dados.push("");
						dados.push("");
						dados.push("Saldo Inicial");
						dados.push("");
						dados.push("");
						dados.push("");
						dados.push(parseFloat(value2["saldo"]).toFixed(2));
						dados.push("");
						dados.push("");
						dados.push("");
						
						saldo = parseFloat(value2["saldo"]);
						
						table.row.add(dados).draw();
					});
					
					$.each(obj["data"], function(index, value) {
						var dados = new Array();
						dados.push(value["datalc"].substr(0, 10));
						dados.push(value["dataven"].substr(0, 10));
						dados.push(value["cmdesc"]);
						dados.push(value["nrdoc"]);
						dados.push(parseFloat(value["edeb"]).toFixed(2));
						dados.push(parseFloat(value["ecred"]).toFixed(2));
						
						saldo = saldo - parseFloat(value["ecred"]);
						saldo = saldo + parseFloat(value["edeb"]);
						
						dados.push(parseFloat(saldo).toFixed(2));
						dados.push(value["obs"]);
						dados.push(value["ultdoc"]);
						if( value["ftstamp"].toString().trim() != '' ) {
							dados.push("<a class='btn btn-success' href='clientedoc.php?docstamp=" + value["ftstamp"] + "'><i class='halflings-icon white zoom-in'></i></a>");
						}
						else {
							dados.push("");
						}
						
						table.row.add(dados).draw();
					});
					table.columns.adjust();
					
					DeactivateLoading();
				}
			});
		}
	</script>
	<div class="clearfix"></div>
	<?php include("footer.php"); ?>
	<!-- start: JavaScript-->
	<?php include("footer_code.php"); ?>
	<!-- end: JavaScript-->
</body>
</html>
