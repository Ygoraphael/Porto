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
						$current_page = "Enciclopédia";
						include("breadcrumbs.php"); 
					?>
					<div class="box-content">
						<button type="submit" class="btn btn-primary" onclick="window.history.go(-1); return false;"><i class="white halflings-icon circle-arrow-left"></i> Voltar</button>
					</div>
					<div class="row-fluid">
						<table id="TabEncic" class="table table-striped bootstrap-datatable datatable">
							<thead>
								<tr>
									<th>Descrição</th>
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
	
	<div class="clearfix"></div>
	
	<?php include("footer.php"); ?>
	
	<!-- start: JavaScript-->
	<?php include("footer_code.php"); ?>
	<script>
		$(document).ready(function () { 
			$('#TabEncic').DataTable({
				"bDestroy": true,
				"bPaginate":   false,
				"bInfo":     false,
				"bFilter":     false
			});
		});
		function filtra_cl() {
			jQuery.ajax({
				type: "POST",
				url: "funcoes_gerais.php",
				data: { "action" : "tabela_enciclopedia('<?php echo $_GET['i']; ?>');"},
				success: function(data) 
				{
					var obj = JSON.parse(data);
					
					$('#TabEncic').DataTable({
						"bDestroy": true,
						"bPaginate":   false,
						"bInfo":     false,
						"bFilter":     true
					});
					
					$('#TabEncic').DataTable().fnClearTable();
					
					$.each(obj, function(index, value) {
						var dados = new Array();
						dados.push(value["title"]);
						
						dados.push("<a class='btn btn-success' href='codeview.php?id=" + value["id"] + "'><i class='halflings-icon white zoom-in'></i></a>");
						$('#TabEncic').dataTable().fnAddData(dados);
					});
					
					jQuery("#TabEncic thead tr th").css( "width", "auto");
				}
			});
		}
		
		filtra_cl();
	</script>
	<!-- end: JavaScript-->
</body>
</html>
