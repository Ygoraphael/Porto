<!doctype html>
<html class="no-js" lang="en">
	<head>
		<?php include("header.php"); ?>
	</head>
	<body style="background:#eaedf2;">
		<div class="off-canvas-wrap" data-offcanvas>
			<div class="inner-wrap">
				<nav class="tab-bar clearfix" style="height:3.8125rem;">
					<span class="left" style="height:100%;">
						<a class="left-off-canvas-toggle menu-icon" style="color:black; background:#333333; height:100%; width:40px;" href="#"><span></span></a>
					</span>
					<span class="small-4 large-4 tab-bar-section left valign-middle" style="height:100%;">
						<i class="step fi-magnifying-glass size-12 left magnifying-glass"></i>
						<span class="magnifying-glass" style="margin-left:5px;">Bucador Proyectos</span>
						<input class='header-search-box' type='text' id='search-string' style="display:none; width: 0px;" name='search-string'>
					</span>
				</nav>
				<aside class="left-off-canvas-menu">
					<?php 
						$pag = "node10";
						include("menu.php");
					?>
				</aside>
				<section class="main-section">
					<br>
					<div class="row">
						<div class="large-12 small-12 columns left">
							<i class="step fi-comment size-12 left"></i>
							<a style="margin-left:5px;" class='text001'>Tareas > </a><a class='text002'>Importante</a>
							<br>
							<a class='text003'>Tablero para gestionar tus proyectos</a>
						</div>
					</div>
					<hr />
					<div class="row">
						<div class="large-4 columns">
							<div class="panel paneldash" style="background:#D0D0D0;">
								<div class="row">
									<div class="large-12 small-12 columns">
										<h5>Diseño</h5>
									</div>
								</div>
								<div class="row">
									<div class="large-8 small-8 columns text003" style="height:50px; margin-bottom:3px; background:#F8F8F8;">
										<div class="row nopadding" style="height:50%;">
											<div class="large-12 small-12 columns text003" style="background:#F8F8F8;">
												100.150 Planeta Vivo 2015
											</div>
										</div>
										<div class="row nopadding" style="height:50%;">
											<div class="large-12 small-12 columns text004" style="background:#F8F8F8;">
												18:45 15/05/2015
											</div>
										</div>
									</div>
									<div class="large-4 small-4 columns text003" style="height:50px; margin-bottom:3px; padding-top:5px; padding-bottom:5px; background:#F8F8F8;">
										<a href="#" class="button alert right nomargin button_padding001" style="margin-top:0.6rem;">Idea / logos</a>
									</div>
								</div>
								<div class="row">
									<div class="large-8 small-8 columns text003" style="height:50px; margin-bottom:3px; background:#F8F8F8;">
										<div class="row nopadding" style="height:50%;">
											<div class="large-12 small-12 columns text003" style="background:#F8F8F8;">
												100.150 Cascanueces 2015
											</div>
										</div>
										<div class="row nopadding" style="height:50%;">
											<div class="large-12 small-12 columns text004" style="background:#F8F8F8;">
												18:45 15/05/2015
											</div>
										</div>
									</div>
									<div class="large-4 small-4 columns text003" style="height:50px; margin-bottom:3px; padding-top:5px; padding-bottom:5px; background:#F8F8F8;">
										<a href="#" class="button alert right nomargin button_padding001" style="margin-top:0.6rem">Maqueta</a>
									</div>
								</div>
							</div>
						</div>
						<?php include("index_presupuestos.php"); ?>
						<div class="large-4 columns">
							<div class="panel paneldash" style="background:#D0D0D0;">
								<div class="row">
									<div class="large-12 small-12 columns">
										<h5>Producción</h5>
									</div>
								</div>
								<div class="row">
									<div class="large-8 small-8 columns text003" style="height:50px; margin-bottom:3px; background:#F8F8F8;">
										<div class="row nopadding" style="height:50%;">
											<div class="large-12 small-12 columns text003" style="background:#F8F8F8;">
												100.150 Planeta Vivo 2015
											</div>
										</div>
										<div class="row nopadding" style="height:50%;">
											<div class="large-12 small-12 columns text004" style="background:#F8F8F8;">
												18:45 15/05/2015
											</div>
										</div>
									</div>
									<div class="large-4 small-4 columns text003" style="height:50px; margin-bottom:3px; padding-top:5px; padding-bottom:5px; background:#F8F8F8;">
										<a href="#" class="button alert right nomargin button_padding001" style="margin-top:0.6rem;">Idea / logos</a>
									</div>
								</div>
								<div class="row">
									<div class="large-8 small-8 columns text003" style="height:50px; margin-bottom:3px; background:#F8F8F8;">
										<div class="row nopadding" style="height:50%;">
											<div class="large-12 small-12 columns text003" style="background:#F8F8F8;">
												100.150 Cascanueces 2015
											</div>
										</div>
										<div class="row nopadding" style="height:50%;">
											<div class="large-12 small-12 columns text004" style="background:#F8F8F8;">
												18:45 15/05/2015
											</div>
										</div>
									</div>
									<div class="large-4 small-4 columns text003" style="height:50px; margin-bottom:3px; padding-top:5px; padding-bottom:5px; background:#F8F8F8;">
										<a href="#" class="button alert right nomargin button_padding001" style="margin-top:0.6rem">Maqueta</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<?php include("index_plazosentregaorden.php") ;?>
						<div class="large-4 columns">
							<div class="panel paneldash" style="background:#D0D0D0;">
								<div class="row">
									<div class="large-12 small-12 columns">
										<h5>Muestras en tejido</h5>
									</div>
								</div>
								<div class="row">
									<div class="large-8 small-8 columns text003" style="height:50px; margin-bottom:3px; background:#F8F8F8;">
										<div class="row nopadding" style="height:50%;">
											<div class="large-12 small-12 columns text003" style="background:#F8F8F8;">
												100.150 Planeta Vivo 2015
											</div>
										</div>
										<div class="row nopadding" style="height:50%;">
											<div class="large-12 small-12 columns text004" style="background:#F8F8F8;">
												18:45 15/05/2015
											</div>
										</div>
									</div>
									<div class="large-4 small-4 columns text003" style="height:50px; margin-bottom:3px; padding-top:5px; padding-bottom:5px; background:#F8F8F8;">
										<a href="#" class="button success right nomargin button_padding001" style="margin-top:0.6rem;">Idea / logos</a>
									</div>
								</div>
								<div class="row">
									<div class="large-8 small-8 columns text003" style="height:50px; margin-bottom:3px; background:#F8F8F8;">
										<div class="row nopadding" style="height:50%;">
											<div class="large-12 small-12 columns text003" style="background:#F8F8F8;">
												100.150 Cascanueces 2015
											</div>
										</div>
										<div class="row nopadding" style="height:50%;">
											<div class="large-12 small-12 columns text004" style="background:#F8F8F8;">
												18:45 15/05/2015
											</div>
										</div>
									</div>
									<div class="large-4 small-4 columns text003" style="height:50px; margin-bottom:3px; padding-top:5px; padding-bottom:5px; background:#F8F8F8;">
										<a href="#" class="button orange right nomargin button_padding001" style="margin-top:0.6rem">Maqueta</a>
									</div>
								</div>
							</div>
						</div>
						<div class="large-4 columns">
							<div class="panel paneldash" style="background:#D0D0D0;">
								<div class="row">
									<div class="large-12 small-12 columns">
										<h5>Justificantes</h5>
									</div>
								</div>
								<div class="row">
									<div class="large-8 small-8 columns text003" style="height:50px; margin-bottom:3px; background:#F8F8F8;">
										<div class="row nopadding" style="height:50%;">
											<div class="large-12 small-12 columns text003" style="background:#F8F8F8;">
												100.150 Planeta Vivo 2015
											</div>
										</div>
										<div class="row nopadding" style="height:50%;">
											<div class="large-12 small-12 columns text004" style="background:#F8F8F8;">
												18:45 15/05/2015
											</div>
										</div>
									</div>
									<div class="large-4 small-4 columns text003" style="height:50px; margin-bottom:3px; padding-top:5px; padding-bottom:5px; background:#F8F8F8;">
										<a href="#" class="button alert right nomargin button_padding001" style="margin-top:0.6rem;">Idea / logos</a>
									</div>
								</div>
								<div class="row">
									<div class="large-8 small-8 columns text003" style="height:50px; margin-bottom:3px; background:#F8F8F8;">
										<div class="row nopadding" style="height:50%;">
											<div class="large-12 small-12 columns text003" style="background:#F8F8F8;">
												100.150 Cascanueces 2015
											</div>
										</div>
										<div class="row nopadding" style="height:50%;">
											<div class="large-12 small-12 columns text004" style="background:#F8F8F8;">
												18:45 15/05/2015
											</div>
										</div>
									</div>
									<div class="large-4 small-4 columns text003" style="height:50px; margin-bottom:3px; padding-top:5px; padding-bottom:5px; background:#F8F8F8;">
										<a href="#" class="button alert right nomargin button_padding001" style="margin-top:0.6rem">Maqueta</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
				<a class="exit-off-canvas"></a>
			</div>
		</div>
		<script src="js/foundation.min.js"></script>
		<?php include("mainjs.php"); ?>
		<script>
			$(document).foundation();
		</script>
	</body>
</html>