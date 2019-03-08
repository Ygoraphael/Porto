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
						$current_page = "Documento de Cliente";
						include("breadcrumbs.php"); 
						$info = get_doc_data($_GET['docstamp']);
					?>
					
					<div class="row-fluid">
						<form class="form-horizontal">
							<button type="submit" class="btn btn-primary" onclick="window.history.go(-1); return false;" ><i class="white halflings-icon circle-arrow-left"></i> Voltar</button>
							<br><br>
						</form>
						<div class="span5">
							<form class="form-horizontal">
								<label for="nome_cliente" class="control-label">Nome</label>
								<div class="controls">
									<input disabled type="text" id="nome_cliente" class="span12" value='<?php echo $info["nome"]; ?>'>
								</div><br>
								<label for="num_cliente" class="control-label">Nº Cliente</label>
								<div class="controls">
									<input disabled type="text" id="num_cliente" class="span3" value='<?php echo $info["no"]; ?>'>
								</div><br>
								<label class="control-label">Estabelecimento</label>
								<div class="controls">
									<input disabled type="text" class="span3" value='<?php echo $info["estab"]; ?>'>
								</div><br>
								<label class="control-label">Data Documento</label>
								<div class="controls">
									<input disabled type="text" class="span3" value='<?php echo substr($info["fdata"], 0, 10); ?>'>
								</div><br>
								<label class="control-label">Data Vencimento</label>
								<div class="controls">
									<input disabled type="text" class="span3" value='<?php echo substr($info["pdata"], 0, 10); ?>'>
								</div>
							</form>
						</div>
						<div class="span5">
							<form class="form-horizontal">
								<label for="" class="control-label">Nº Cont.</label>
								<div class="controls">
									<input disabled type="text" id="" class="span12" value='<?php echo $info["ncont"]; ?>'>
								</div><br>
								<label for="" class="control-label">Morada</label>
								<div class="controls">
									<input disabled type="text" id="" class="span12" value='<?php echo $info["morada"]; ?>'>
								</div><br>
								<label for="" class="control-label">Cód. Postal</label>
								<div class="controls">
									<input disabled type="text" id="" class="span12" value='<?php echo $info["codpost"]; ?>'>
								</div><br>
								<label class="control-label">Localidade</label>
								<div class="controls">
									<input disabled type="text" class="span12" value='<?php echo $info["local"]; ?>'>
								</div>
							</form>
						</div>
					</div>
					<div class="row-fluid">
						<table id="DocLinhas" class="table table-striped bootstrap-datatable datatable">
							<thead>
								<tr>
									<th>Ref</th>
									<th>Designação</th>
									<th>Qtd</th>
									<th>Preço Unit.</th>
									<th>Desc. 1</th>
									<th>Desc. 2</th>
									<th>IVA</th>
									<th>Total</th>
								</tr>
							</thead>   
							<tbody>
							</tbody>
						</table>
					</div>
					<div class="row-fluid">
						<form class="form-horizontal">
							<label class="control-label">Total Iliquido</label>
							<div class="controls">
								<input disabled type="text" class="span1" value='<?php echo number_format($info["ettiliq"], 2); ?>'>
							</div><br>
							<label class="control-label">Total Desconto Financeiro</label>
							<div class="controls">
								<input disabled type="text" class="span1" value='<?php echo number_format($info["efinv"], 2); ?>'>
							</div><br>
							<label class="control-label">Total Desconto Comercial</label>
							<div class="controls">
								<input disabled type="text" class="span1" value='<?php echo number_format($info["edescc"], 2); ?>'>
							</div><br>
							<label class="control-label">Total IVA</label>
							<div class="controls">
								<input disabled type="text" class="span1" value='<?php echo number_format($info["ettiva"], 2); ?>'>
							</div><br>
							<label class="control-label">Total Documento</label>
							<div class="controls">
								<input disabled type="text" class="span1" value='<?php echo number_format($info["etotal"], 2); ?>'>
							</div><br>
						</form>
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
			$('#DocLinhas').DataTable({
				"bDestroy": true,
				"bPaginate":   false,
				"bSort":   false,
				"bInfo":     false,
				"bFilter":     false
			});
			
			var dados = new Array();
		
			<?php
				$dados = get_doc_data_l($_GET['docstamp']);
				
				foreach($dados as $row) {
					echo "var dados_tmp = new Array();";
					echo "dados_tmp.push('" . $row["ref"] . "');";
					echo "dados_tmp.push('" . $row["design"] . "');";
					echo "dados_tmp.push('" . number_format($row["qtt"],2) . "');";
					echo "dados_tmp.push('" . number_format($row["epv"],2) . "');";
					echo "dados_tmp.push('" . number_format($row["desconto"],2) . "');";
					echo "dados_tmp.push('" . number_format($row["desc2"],2) . "');";
					echo "dados_tmp.push('" . number_format($row["iva"],2) . "');";
					echo "dados_tmp.push('" . number_format($row["etiliquido"],2) . "');";
					echo "dados.push(dados_tmp);";
				}
			?>
			
			$('#DocLinhas').dataTable().fnAddData(dados);
			
			jQuery("#DocLinhas thead tr th").css( "width", "auto");
		});
	</script>
	<!-- end: JavaScript-->
</body>
</html>
