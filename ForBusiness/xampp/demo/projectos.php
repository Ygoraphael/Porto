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
				<a class="brand" href="index.php"><span>TasKas</span></a>
								
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
						$current_page = "Projectos";
						include("breadcrumbs.php"); 
					?>
						
					<div class="row-fluid">
						<table id="TabProjetos" class="table table-striped bootstrap-datatable">
							<thead>
								<tr>
									<th>Código</th>
									<th>Descrição</th>
									<th>Cliente</th>
									<th>Tipo</th>
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
			
			var table = $('#TabProjetos').DataTable({
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
				sPaginationType : "full_numbers"
			});
			
			jQuery.ajax({
				type: "POST",
				url: "funcoes_gerais.php",
				data: { "action" : "tabela_projetos(0);"},
				success: function(data) 
				{
					var obj = JSON.parse(data);
									
					//$('#TabProjetos').DataTable().fnClearTable();
					
					$.each(obj, function(index, value) {
						var dados = new Array();
						dados.push(value["fref"]);
						dados.push(value["nmfref"]);
						dados.push(value["u_nome"]);
						dados.push(value["u_tipo"]);
						if( value["u_fechado"] == "1" ) {
							dados.push("Fechado");
						}
						else {
							dados.push("Em Aberto");
						}
						dados.push("<a class='btn btn-success' href='projeto.php?frefstamp=" + value["frefstamp"] + "'><i class='halflings-icon white zoom-in'></i></a>");
						
						table.fnAddData(dados);
					});
					
					jQuery("#TabProjetos thead tr th").css( "width", "auto");
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
