<!DOCTYPE html>
<html lang="en">
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
						$current_page = "Clientes";
						include("breadcrumbs.php"); 
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
					<div class="row-fluid">
						<table id="TabClientes" class="table table-striped bootstrap-datatable datatable">
							<thead>
								<tr>
									<th>Número</th>
									<th>Nome</th>
									<th>Por Liquidar (€)</th>
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
		$(document).ready(function () {
			$('#TabClientes').DataTable({
				"bDestroy": true,
				"bPaginate":   false,
				"bInfo":     false,
				"bFilter":     false
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
				data: { "action" : "tabela_clientes('" + jQuery("#numero_cliente").val() + "', '" + jQuery("#nome_cliente").val() + "');"},
				success: function(data) 
				{
					var obj = JSON.parse(data);
					
					$('#TabClientes').DataTable({
						"bDestroy": true,
						"bPaginate":   false,
						"bInfo":     false,
						"bFilter":     false,
						"columnDefs": [
							{ "type": "numeric-comma", targets: 2 }
						]
					});
					
					$('#TabClientes').DataTable().fnClearTable();
					
					$.each(obj, function(index, value) {
						var dados = new Array();
						dados.push(value["no"]);
						dados.push(value["nome"]);
						dados.push(parseFloat(Math.round(value["esaldo"] * 100) / 100).toFixed(2));
						
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
