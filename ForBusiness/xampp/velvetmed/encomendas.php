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
					$current_page = "Encomendas";
					include("breadcrumbs.php"); 
				?>
				<div class="row-fluid" style="margin-bottom:10px">
					<button type="submit" class="btn btn-primary" onclick="location.href = 'novaencomenda.php'; return false;"><i class="white halflings-icon plus-sign"></i> NOVA ENCOMENDA</button><br><br>
				</div>
				<div class="row-fluid">
					<form class="form-horizontal span6">
						<div class="control-group">
							<label class="control-label" for="Cliente">Cliente</label>
							<div class="controls">
								<input type="text" class="span8" value="" id="Cliente">
							</div>
						</div>
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
							<label class="control-label" for="num_encomenda">Nº Encomenda</label>
							<div class="controls">
								<input type="text" class="span8" value="" id="num_encomenda">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="Estado">Estado</label>
							<div class="controls">
								<select name="Estado" id="Estado" aria-controls="Estado" class="span8">
									<option value=""></option>
									<option value="0">Em Aberto</option>
									<option value="1">Fechado</option>
								</select>
							</div>
						</div>
						<div class="control-group">
						<div class="controls">
							<a onclick="filtra_encomendas();" class="quick-button blue span8">
								<p style="color:white; font-size:1.9vh;">FILTRAR</p>
							</a>
						</div>
					</form>
				</div>
				<div class="row-fluid">
					<table id="TabEncomendas" class="table table-striped">
						<thead>
							<tr>
								<th>Nº Encomenda</th>
								<th>Cliente</th>
								<th>Data</th>
								<th>Estado</th>
								<th>Total</th>
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
			table = $('#TabEncomendas').DataTable({
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
			
			filtra_encomendas();
		})
		
		function filtra_encomendas() {
			ActivateLoading();
			
			jQuery.ajax({
				type: "POST",
				url: "funcoes_gerais.php",
				data: { "action" : "tabela_encomendas('"+jQuery("#Cliente").val()+"', '"+jQuery("#DataI").val()+"', '"+jQuery("#DataF").val()+"', '"+jQuery("#num_encomenda").val()+"', '"+jQuery("#Estado").val()+"');"},
				success: function(data) 
				{
					var obj = JSON.parse(data);
					table.rows().remove().draw();
					
					$.each(obj, function(index, value) {
						var dados = new Array();
						dados.push(value["obrano"]);
						dados.push(value["nome"]);
						
						dados.push(value["dataobra"].substr(0, 10))
						
						if( value["fechada"] == "1" ) {
							dados.push("Fechado");
						}
						else {
							dados.push("Em Aberto");
						}

						dados.push(parseFloat(value["etotaldeb"]).toFixed(2));
						
						dados.push("<a class='btn btn-success' href='bo.php?bostamp=" + value["bostamp"] + "'><i class='halflings-icon white zoom-in'></i></a>");
						
						table.row.add(dados).draw();
					});
					table.columns.adjust();
					
					jQuery("#TabContratos thead tr th").css( "width", "auto");
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
