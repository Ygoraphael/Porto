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
						$pag = "node71";
						include("menu.php");
					?>
				</aside>
				<section class="main-section">
					<br>
					<div class="row">
						<div class="large-12 small-12 columns left">
							<i class="step fi-comment size-12 left"></i>
							<a style="margin-left:5px;" class='text001'>Clientes > </a><a class='text002'>Cunsultar</a>
							<br>
							<a class='text003'>Ver sus clientes</a>
						</div>
					</div>
					<hr />
					<div class="large-6 columns">
						<div class="row">
							<div class="large-12 columns">
								<form method="get" action="/" id="live-search-example">
									<div><input type="text" name="s" placeholder="Buscar cliente"></div>
								</form>
								<script>
									function PreencheCliente(dados) {
										var str = decodeURIComponent(dados);
										var arr = $.parseJSON('[' + str + ']');
										
										jQuery("#ncont").val( arr[0]["ncont"].trim() );
										jQuery("#no").val( arr[0]["no"].trim() );
										jQuery("#nome").val( arr[0]["nome"].trim() );
										jQuery("#morada").val( arr[0]["morada"].trim() );
										jQuery("#codpost").val( arr[0]["codpost"].trim() );
										jQuery("#local").val( arr[0]["local"].trim() );
										
										$('#live-search-example input[name=s]').val("");
										$('#live-search-s').html("");
									}
									
									$('#live-search-example input[name=s]').liveSearch({url: 'clientes.php?s='});
								</script>
							</div>
						</div>
						<div class="row">
							<div class="large-9 columns">
								<label>Número de Identificación Fiscal
									<input type="text" disabled id="ncont" placeholder="NIF del cliente" />
								</label>
							</div>
							<div class="large-3 columns">
								<label>Número de cliente
									<input type="text" disabled id="no" placeholder="Numero del cliente" />
								</label>
							</div>
						</div>
						<div class="row">
							<div class="large-12 columns">
								<label>Nombre
									<input type="text" disabled id="nome" placeholder="Nombre del cliente" />
								</label>
							</div>
						</div>
						<div class="row">
							<div class="large-12 columns">
								<label>Dirección
									<input type="text" disabled id="morada" placeholder="Dirección del cliente" />
								</label>
							</div>
						</div>
						<div class="row">
							<div class="large-12 columns">
								<label>Cod. Postal
									<input type="text" disabled id="codpost" placeholder="Cod. Postal del cliente" />
								</label>
							</div>
						</div>
						<div class="row">
							<div class="large-12 columns">
								<label>Localidad
									<input type="text" disabled id="local" placeholder="Localidad del cliente" />
								</label>
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