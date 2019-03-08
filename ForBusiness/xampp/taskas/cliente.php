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
						$current_page = "Cliente";
						include("breadcrumbs.php"); 
						$info = get_cliente_data($_GET['id']);
					?>
					
					<div class="row-fluid">
						<div class="span6">
							<form class="form-horizontal">
								<button type="submit" class="btn btn-primary" onclick="window.history.go(-1); return false;" ><i class="white halflings-icon circle-arrow-left"></i> Voltar</button>
								<br><br>
								<div class="control-group">
									<label class="control-label" for="numero_cliente">Número</label>
									<div class="controls">
										<input type="text" class="span8" value='<?php echo $info["no"]; ?>' id="numero_cliente">
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="nome_cliente">Nome</label>
									<div class="controls">
										<input type="text" class="span8" value='<?php echo $info["nome"]; ?>' id="nome_cliente">
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="nome_cliente">Nº Contribuinte</label>
									<div class="controls">
										<input type="text" class="span8" value='<?php echo $info["ncont"];?>' id="nome_cliente">
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="nome_cliente">Saldo em Aberto</label>
									<div class="controls">
										<input type="text" class="span8" value='€ <?php echo round($info["esaldo"], 2);?>' id="nome_cliente">
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="nome_cliente">Morada</label>
									<div class="controls">
										<input type="text" class="span8" value='<?php echo $info["morada"];?>' id="nome_cliente">
										<button class="btn" type="button" onclick="AbreMaps('<?php echo str_replace("/", "%2F", str_replace(" ", "+", $info["morada"]) . ",+" . $info["codpost"]);?>'); return false;"><i class="halflings-icon screenshot white"></i></button>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="nome_cliente">Localidade</label>
									<div class="controls">
										<input type="text" class="span8" value='<?php echo $info["local"];?>' id="nome_cliente">
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="nome_cliente">Cód. Postal</label>
									<div class="controls">
										<input type="text" class="span8" value='<?php echo $info["codpost"];?>' id="nome_cliente">
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="nome_cliente">Telefone</label>
									<div class="controls">
										<input type="text" class="span8" value='<?php echo $info["telefone"];?>' id="nome_cliente">
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="nome_cliente">Telemóvel</label>
									<div class="controls">
										<input type="text" class="span8" value='<?php echo $info["tlmvl"];?>' id="nome_cliente">
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="nome_cliente">Fax</label>
									<div class="controls">
										<input type="text" class="span8" value='<?php echo $info["fax"];?>' id="nome_cliente">
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="nome_cliente">Email</label>
									<div class="controls">
										<input type="text" class="span8" value='<?php echo $info["email"];?>' id="nome_cliente">
										<button class="btn" type="button" onclick="EnviaEmail('<?php echo $info["email"];?>')"><i class="halflings-icon white envelope"></i></button>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="nome_cliente">Versão PHC</label>
									<div class="controls">
										<input type="text" class="span8" value='<?php echo $info["u_vphc"];?>' id="nome_cliente">
									</div>
								</div>
							</form>
						</div>
						<div class="span6 noMarginLeft">
							<form class="form-horizontal">
								<textarea class="span12" style="height:62vh; background:white;" readonly><?php 
										echo "****Observações****\n\n" . $info["obs"] . "\n\n";
										echo "****Backup****\n\n";
										echo $info["u_bakdesc"] . "\n\n";
										echo "****Acessos****\n\n" . $info["u_acessos"]; 
									?>
								</textarea>
							</form>
						</div>
						<div class="row-fluid">
							<div class="span4">
								<h3>Não Regularizado</h3>
							</div>
							<table id="TabDocumentos" class="table table-striped">
								<thead>
									<tr>
										<th>Documento</th>
										<th>Número</th>
										<th>Débito (€)</th>
										<th>Crédito (€)</th>
										<th>Data Documento</th>
										<th>Data Vencimento</th>
										<th></th>
									</tr>
								</thead>   
								<tbody>
								</tbody>
							</table>
						</div>
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
		function EnviaEmail(email) {
			window.location = "mailto:" + email;
		}
		
		function AbreMaps(address) {
			var win = window.open("https://www.google.pt/maps/search/" + address, '_blank');
			win.focus();
		}
	</script>
	<script>
		$(document).ready(function () {	
			var table;
			
			function getDocCC() {
				jQuery.ajax({
					type: "POST",
					url: "funcoes_gerais.php",
					data: { "action" : "get_cliente_faturacao_atraso('<?php echo $_GET['id']; ?>');"},
					success: function(data) 
					{
						var obj = JSON.parse(data);
						
						$.each(obj, function(index, value) {
							var dados = new Array();
							dados.push(value["cmdesc"]);
							dados.push(value["nrdoc"]);
							dados.push(parseFloat(Math.round(value["edeb"] * 100) / 100).toFixed(2));
							dados.push(parseFloat(Math.round(value["ecred"] * 100) / 100).toFixed(2));
							dados.push(value["datalc"].toString().substr(0, 10));
							dados.push(value["dataven"].toString().substr(0, 10));
							dados.push("<a class='btn btn-success' href='clientedoc.php?docstamp=" + value["ftstamp"] + "'><i class='halflings-icon white zoom-in'></i></a>");
							//$('#TabDocumentos').dataTable().fnAddData(dados);
							table.row.add(dados).draw();
						});
						
						jQuery("#TabDocumentos thead tr th").css( "width", "auto");
					}
				});
			}
			
			table = $('#TabDocumentos').DataTable({
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
					{ "type": "numeric-comma", targets: 2 }
				]
			});
			
			getDocCC();
		
		});
	</script>
	<!-- end: JavaScript-->
</body>
</html>