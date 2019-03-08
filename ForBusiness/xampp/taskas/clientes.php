<!DOCTYPE html>
<html lang="en">
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
						$current_page = "Clientes";
						include("breadcrumbs.php"); 
					?>
					<?php
						if(0) {
					?>
					<div class="row-fluid">
						<form class="form-horizontal">
							<div class="control-group">
								<label class="control-label" for="numero_cliente">Número</label>
								<div class="controls">
									<input type="text" id="numero_cliente">
									<button class="btn" type="button" onclick="filtra_cl()"><i class="halflings-icon white zoom-in"></i></button>
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="nome_cliente">Nome</label>
								<div class="controls">
									<input type="text" id="nome_cliente">
									<button class="btn" type="button" onclick="filtra_cl()"><i class="halflings-icon white zoom-in"></i></button>
								</div>
							</div>
						</form>
					</div>
					<?php
						}
					?>
					<div class="row-fluid">
						<table id="TabClientes" class="table table-striped">
							<thead>
								<tr>
									<th>Número</th>
									<th>Nome</th>
									<th>Por Liquidar (€)</th>
									<th>Com Contrato?</th>
									<th>Contrato Restante</th>
									<th></th>
								</tr>
							</thead>   
							<tbody>
							</tbody>
						</table>
					</div>
				</div>
			</div><!--/.fluid-container-->
		</div><!--/#content.span10-->
		
	<div class="modal hide fade" id="myModal">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">×</button>
			<h3>Settings</h3>
		</div>
		<div class="modal-body">
			<p>Here settings can be configured...</p>
		</div>
		<div class="modal-footer">
			<a href="#" class="btn" data-dismiss="modal">Close</a>
			<a href="#" class="btn btn-primary">Save changes</a>
		</div>
	</div>
	
	<div class="common-modal modal fade" id="common-Modal1" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-content">
			<ul class="list-inline item-details">
				<li><a href="http://themifycloud.com">Admin templates</a></li>
				<li><a href="http://themescloud.org">Bootstrap themes</a></li>
			</ul>
		</div>
	</div>
	
	<div class="clearfix"></div>
	
	<?php include("footer.php"); ?>
	
	<!-- start: JavaScript-->
	<?php include("footer_code.php"); ?>
	<script>
		var dtCl;
		
		$(document).ready(function () {
			dtCl = $('#TabClientes').DataTable({
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
				columnDefs: [
					{ "targets": 2, "type": "num" }
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
				sPaginationType : "full_numbers"
			});
			
		});
		
		$('#nome_cliente').keyup(function(e){
			if(e.keyCode == 13)
			{
				filtra_cl();
			}
		});
		
		$('#numero_cliente').keyup(function(e){
			if(e.keyCode == 13)
			{
				filtra_cl();
			}
		});
		
		function filtra_cl() {
			ActivateLoading();
			jQuery.ajax({
				type: "POST",
				url: "funcoes_gerais.php",
				data: { "action" : "tabela_clientes('', '');"},
				success: function(data) 
				{
					var obj = JSON.parse(data);
					
					dtCl.clear();
					
					$.each(obj, function(index, value) {
						var dados = new Array();
						dados.push(value["no"]);
						dados.push(value["nome"]);
						dados.push(parseFloat(Math.round(value["esaldo"] * 100) / 100).toFixed(2));
						
						if( value["contrato"] ) {
							dados.push("<span class='label green'>Com Contrato</span>");
						}
						else {
							dados.push("<span class='label red'>Sem Contrato</span>");
						}
						
						if( value["contrato"] ) {
							if( value["contrato_hrestantes"] > 0 ) {
								dados.push("<span class='label green'>" + parseFloat(Math.round(value["contrato_hrestantes"] * 100) / 100).toFixed(2) + "</span>");
							}
							else {
								dados.push("<span class='label red'>" + parseFloat(Math.round(value["contrato_hrestantes"] * 100) / 100).toFixed(2) + "</span>");
							}
						}
						else {
							dados.push("");
						}
						
						dados.push("<a class='btn btn-success' href='cliente.php?id=" + value["no"] + "'><i class='halflings-icon white zoom-in'></i></a>");
						$('#TabClientes').dataTable().fnAddData(dados);
					});
					
					jQuery("#TabClientes thead tr th").css( "width", "auto");
					DeactivateLoading();
				}
			});
		}
		
		filtra_cl();
	</script>
	<!-- end: JavaScript-->
</body>
</html>
