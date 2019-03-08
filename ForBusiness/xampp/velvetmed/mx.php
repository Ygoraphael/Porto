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
						$current_page = "Visita";
						include("breadcrumbs.php"); 
						$info = get_doc_data($_GET['mxstamp'], 'mx');
						$infocl = get_cliente_data($info["clno"]);
					?>
					
					<div class="row-fluid">
						<form class="form-horizontal">
							<button type="submit" class="btn btn-primary" onclick="window.history.go(-1); return false;" ><i class="white halflings-icon circle-arrow-left"></i> Voltar</button>
							<br><br>
							<h1>Visita</h1>
						</form>
						<div class="span5">
							<form class="form-horizontal">
								<label for="nome_cliente" class="control-label">Nome</label>
								<div class="controls">
									<input disabled type="text" id="nome_cliente" class="span12" value='<?php echo $info["clnome"]; ?>'>
								</div><br>
								<label for="num_cliente" class="control-label">Nº Cliente</label>
								<div class="controls">
									<input disabled type="text" id="num_cliente" class="span3" value='<?php echo $info["clno"]; ?>'>
								</div><br>
								<label class="control-label">Estabelecimento</label>
								<div class="controls">
									<input disabled type="text" class="span3" value='<?php echo $info["clestab"]; ?>'>
								</div><br>
								<label class="control-label">Data Visita</label>
								<div class="controls">
									<input disabled type="text" class="span5" value='<?php echo substr($info["data"], 0, 10); ?>'>
								</div><br>
								<label class="control-label" for="Hora">Hora</label>
							<div class="controls">
								<input disabled type="text" class="span2" value="<?php echo substr($info["hinicio"], 0,2); ?>" >
								<input disabled type="text" class="span2" value="<?php echo substr($info["hinicio"],3, 5); ?>" >
							</div>
							</form>
						</div>
						<div class="span5">
							<form class="form-horizontal">
								<label for="" class="control-label">Nº Cont.</label>
								<div class="controls">
									<input disabled type="text" id="" class="span12" value='<?php echo $infocl["ncont"]; ?>'>
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
					<div class="span10">
						<form class="form-horizontal">
							<label class="control-label">Relatório</label>
							<div class="controls">
								<textarea disabled id="relatorio" class="span12" style="height:200px; background:white;"><?php echo $info["texto"]; ?></textarea>								
							</div>
						</form>
					</div>
				</div>
			</div><!--/.fluid-container-->
		</div><!--/#content.span10-->
	
	<div class="clearfix"></div>
	
	<?php include("footer.php"); ?>
	
	<!-- start: JavaScript-->
	<?php include("footer_code.php"); ?>
	<!-- end: JavaScript-->
</body>
</html>
