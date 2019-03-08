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
					
						if( !isset($_GET["ref"]) || trim($_GET["ref"]) == '' ) {
							return;
						}
						$ref = trim($_GET["ref"]);
						$current_page = "Produto " . $ref;
						include("breadcrumbs.php");
						
						$produto = get_produto($ref);
						
					?>
					<div class="row-fluid" style="margin-bottom:10px">
						<button type="submit" class="btn btn-primary" onclick="window.history.go(-1); return false;"><i class="white halflings-icon circle-arrow-left"></i> Voltar</button><br><br>
					</div>
					
					<div class="row-fluid">
						<div class="span6">
							<b>REFERÊNCIA</b><br>
							<span style="color: #3390e0"><?php echo $produto["ref"]; ?></span><br><br>
							<b>NOME</b><br>
							<span style="color: #3390e0"><?php echo $produto["design"]; ?></span><br><br>
							<b>GAMA</b><br>
							<span style="color: #3390e0">VELVET <?php echo strtoupper($produto["u_famsite"]); ?></span><br><br>
							<b>APRESENTAÇÃO</b><br>
							<span style="color: #3390e0"><?php echo $produto["desc1"]; ?></span><br><br>
							<b>MODO DE APLICAÇÃO</b><br>
							<span style="color: #3390e0"><?php echo $produto["desc2"]; ?></span><br><br>
							<b>DESCRIÇÃO</b><br>
							<span style="color: #3390e0"><?php echo $produto["stobs"]; ?></span><br><br>
						</div>
						<div class="span6">
							<div class="span2"></div>
							<img class="span8" src="<?php echo $produto["imagem"]; ?>" />
							<div class="span2"></div>
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
	</script>
	<!-- end: JavaScript-->
</body>
</html>
