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
					$current_page = "Dashboard";
					include("breadcrumbs.php"); 
				?>
				
				<div class="row-fluid">
					<?php include("weather.php"); ?>
					<?php include("bot_intervencoes.php"); ?>
				</div>
				<div class="row-fluid">
					<?php include("cur_intervencoes.php"); ?>
				</div>

				<?php include("dash_horas_trabalhadas.php"); ?>
							
				<div class="row-fluid">
					<?php include("dash_faturacao_anual.php"); ?>
				</div>
			</div><!--/.fluid-container-->
	
			<!-- end: Content -->
		</div><!--/#content.span10-->
	</div><!--/fluid-row-->
	
	<div class="clearfix"></div>
	<?php include("footer.php"); ?>
	
	<!-- start: JavaScript-->
	<?php include("footer_code.php"); ?>
	<!-- end: JavaScript-->
</body>
</html>
