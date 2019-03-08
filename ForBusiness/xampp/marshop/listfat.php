<!DOCTYPE html>
<html lang="pt">
<head>
	<?php include("header.php"); ?>
</head>

<body>
		<!-- start: Header -->
	<div class="navbar">
		<div class="navbar-inner">
			<div class="container-fluid">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".top-nav.nav-collapse,.sidebar-nav.nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
				<a class="brand" href="index.php"><span>Marshopping</span></a>
								
				<!-- start: Header Menu -->
				<div class="nav-no-collapse header-nav">
					<ul class="nav pull-right">
						<li class="dropdown hidden-phone">
							<?php include("user_notifications.php"); ?>
						</li>
						<!-- start: Message Dropdown -->
						<li class="dropdown hidden-phone">
							<?php include("user_messages.php"); ?>
						</li>
						<!-- start: User Dropdown -->
						<?php include("user_panel.php"); ?>
						<!-- end: User Dropdown -->
					</ul>
				</div>
				<!-- end: Header Menu -->
			</div>
		</div>
	</div>
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
						$current_page = "";
						include("breadcrumbs.php"); 
					?>

					<div class="row-fluid">
						<form class="form-horizontal">
							<div class="control-group">
								<label class="control-label" for="numero_cliente">Data Inicial</label>
								<div class="controls">
									<input type="date" id="datai" value="<?php echo date('Y-m-d'); ?>">
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="nome_cliente">Data Final</label>
								<div class="controls">
									<input type="date" id="dataf" value="<?php echo date('Y-m-d'); ?>">
								</div>
							</div>
							<div class="control-group">
								<button class="btn btn-large btn-primary span12" onclick="showFT(); return false;"><i class="white halflings-icon search"></i> Mostrar</button>
							</div>
						</form>
					</div>
					<div class="row-fluid">
						<div class="span12">
							<table id="TabDoc" class="table table-striped bootstrap-datatable">
								<thead>
									<tr>
										<th>Documento</th>
										<th>Nº</th>
										<th>NIF</th>
										<th>Data</th>
										<th>Hora</th>
										<th>Total</th>
										<th>Anulado</th>
										<th>Numerário</th>
										<th>Multibanco</th>
										<th>Troco</th>
										<th></th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
				</div>
			</div><!--/.fluid-container-->
				<!-- end: Content -->
		</div><!--/#content.span10-->	
	<script>
		function showFT() {
			ActivateLoading();
			var table = $('#TabDoc').DataTable({
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
				"bDestroy": true
			});
			$('#TabDoc').DataTable().fnClearTable();
			
			var filtro = "ft.fdata between '" + replaceAll(jQuery("#datai").val(), "-", "") + "' and '" + replaceAll(jQuery("#dataf").val(), "-", "") + "'";
			
			jQuery.ajax({
				type: "POST",
				url: "funcoes_gerais.php",
				data: { "action" : "get_docs_cabecalho('ft inner join ft2 on ft.ftstamp = ft2.ft2stamp','ft.nmdoc, ft.fno, ft.ncont, ft.no, ft.nome, convert(varchar(5), ft.usrhora) usrhora, convert(varchar(10), ft.fdata, 105) fdata, (ft.ettiliq+ft.ettiva) total, ft.etotal, ft.ftstamp, anulado, ft2.epaga1, ft2.evdinheiro, ft2.etroco', '" + window.btoa(filtro) + "');"},
				success: function(data) 
				{
					try {
						var obj = JSON.parse(data);
						
						$.each(obj, function(index, value) {
							var dados = new Array();
							dados.push(value["nmdoc"]);
							dados.push(value["fno"]);
							dados.push(value["ncont"]);
							dados.push(value["fdata"]);
							dados.push(value["usrhora"]);
							dados.push(parseFloat(value["total"]).toFixed(2));
							if(value["anulado"] == "1")
								dados.push('Sim');
							else
								dados.push('Não');
							dados.push(parseFloat(value["evdinheiro"]).toFixed(2));
							dados.push(parseFloat(value["epaga1"]).toFixed(2));
							dados.push(parseFloat(value["etroco"]).toFixed(2));
							dados.push('<a class="btn btn-success" href="clientedoc.php?docstamp=' + value["ftstamp"] + '"><i class="halflings-icon white zoom-in"></i></a>');
							
							table.fnAddData(dados);
						});
						
						jQuery("#TabDoc thead tr th").css( "width", "auto");
						DeactivateLoading();
					}
					catch(err) {
						DeactivateLoading();
					}
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
