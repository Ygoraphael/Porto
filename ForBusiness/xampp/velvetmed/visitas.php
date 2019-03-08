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
					$current_page = "Visitas";
					include("breadcrumbs.php"); 
				?>
				<div class="row-fluid" style="margin-bottom:10px">
					<button type="submit" class="btn btn-primary" onclick="location.href = 'novavisita.php'; return false;"><i class="white halflings-icon plus-sign"></i> NOVA VISITA</button><br><br>
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
						<div class="controls">
							<a onclick="filtra_visitas();" class="quick-button blue span8">
								<p style="color:white; font-size:1.9vh;">FILTRAR</p>
							</a>
						</div>
					</form>
				</div>
				<div class="row-fluid">
					<table id="TabVisitas" class="table table-striped">
						<thead>
							<tr>
								<th>Cliente</th>
								<th>Data</th>
								<th>Hora</th>
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
			table = $('#TabVisitas').DataTable({
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
			
			filtra_visitas();
		});
		
		function filtra_visitas() {
			ActivateLoading();
			
			jQuery.ajax({
				type: "POST",
				url: "funcoes_gerais.php",
				data: { "action" : "tabela_visitas('"+jQuery("#Cliente").val()+"', '"+jQuery("#DataI").val()+"', '"+jQuery("#DataF").val()+"', '<?php echo $_SESSION['user']['id']; ?>');"},
				success: function(data) 
				{
					var obj = JSON.parse(data);

					table.rows().remove().draw();
					
					$.each(obj, function(index, value) {
						var dados = new Array();
						dados.push(value["clnome"]);
						dados.push(value["data"].substr(0, 10));
						dados.push(value["hinicio"])

						dados.push("<a class='btn btn-success' href='mx.php?mxstamp=" + value["mxstamp"] + "'><i class='halflings-icon white zoom-in'></i></a>");
						
						table.row.add(dados).draw();
					});
					table.columns.adjust();
					
					jQuery("#TabVisitas thead tr th").css( "width", "auto");
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
