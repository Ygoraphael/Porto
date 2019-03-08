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
						$current_page = "Contratos";
						include("breadcrumbs.php"); 
					?>
						
					<div class="row-fluid">
						<table id="TabContratos" class="table table-striped bootstrap-datatable">
							<thead>
								<tr>
									<th>Código</th>
									<th>Cliente</th>
									<th>Início</th>
									<th>Fim</th>
									<th>Horas Restantes</th>
									<th>Horas Contrato</th>
									<th>Estado</th>
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
	<div class="clearfix"></div>
	<script>
		$(document).ready(function () {
			ActivateLoading();
			
			var table = $('#TabContratos').DataTable({
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
				sPaginationType : "full_numbers"
			});
			
			jQuery.ajax({
				type: "POST",
				url: "funcoes_gerais.php",
				data: { "action" : "tabela_contratos(-1);"},
				success: function(data) 
				{
					var obj = JSON.parse(data);

					$.each(obj, function(index, value) {
						var dados = new Array();
						dados.push(value["descricao"]);
						dados.push(value["nome"]);
						
						dados.push(value["data_inicial"].substr(0, 10))
						dados.push(value["data_final"].substr(0, 10))
						
						dados.push(parseFloat(value["u_horasres"]).toFixed(2));
						dados.push(parseFloat(value["u_horasc"]).toFixed(2));
						
						var data = value["datap"].substr(0, 10);
						data = new Date(data);
						var datan = Date.now();
						
						if( data < datan ) {
							dados.push("<span class='label red'>Fechado</span>");
						}
						else {
							dados.push("<span class='label green'>Em Aberto</span>");
						}
						dados.push("<a class='btn btn-success' href='contrato.php?csupstamp=" + value["csupstamp"] + "'><i class='halflings-icon white zoom-in'></i></a>");
						
						table.row.add(dados).draw();
					});
					
					jQuery("#TabContratos thead tr th").css( "width", "auto");
					DeactivateLoading();
				}
			});
		});
		
	</script>
	
	<?php include("footer.php"); ?>
	
	<!-- start: JavaScript-->
	<?php include("footer_code.php"); ?>
	<!-- end: JavaScript-->
</body>
</html>
