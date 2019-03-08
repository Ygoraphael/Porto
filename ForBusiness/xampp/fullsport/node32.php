<!doctype html>
<html class="no-js" lang="en">
	<head>
		<?php include("header.php"); ?>
		<script src="js/raphael.js"></script>
		<script src="js/tshirts.js"></script>
		<script type="text/javascript" src="js/jscolor/jscolor.js"></script>
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
						$pag = "node32";
						include("menu.php");
					?>
				</aside>
				<section class="main-section">
					<br>
					<div class="row">
						<div class="large-12 small-12 columns left">
							<i class="step fi-comment size-12 left"></i>
							<a style="margin-left:5px;" class='text001'>Diseño > </a><a class='text002'>Maqueta</a>
							<br>
							<a class='text003'>Crea su maqueta</a>
						</div>
					</div>
					<hr />
					<div class="row">
						<div class="large-12 columns">
							<div class="row">
								<div class="large-3 columns">
									<a class="button" onclick="t2_f.hide(); t1_f.show(); seleccionado=1;">Tshirt1</a>
									<a class="button" onclick="t1_f.hide(); t2_f.show(); seleccionado=2;">Tshirt2</a>
								</div>
								<div class="large-3 columns">
									<table>
										<tr>
											<td>Cor: </td>
											<td>
												<input class="color" id="color">
											</td>
										</tr>
										<tr>
											<td></td>
											<td>
												<a onclick="limpa_cor();">Limpar Cor</a>
											</td>
										</tr>
									</table>
								</div>
								<div class="large-3 columns"></div>
								<div class="large-3 columns"></div>
							</div>
							<div class="row">
								<div class="large-12 columns">
									<div style="float:left; width:50%; height:50%;" id="imagem">
										<div id="shirts"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
				<a class="exit-off-canvas"></a>
			</div>
		</div>
		<script>
			var t1_f
			var t2_f;
			var r;
			var seleccionado = 1;
			
			Raphael("shirts", 500, 500, function () {
				r = this;
				var over = function () {
					this.c = this.attr("fill");
					this.stop().animate({fill: "#bacabd"}, 500);
				},
					out = function () {
						this.stop().animate({fill: this.c}, 500);
					};
					
				r.setStart();
				for (var object in tshirt1_frente.shapes) {
					p1 = r.path(tshirt1_frente.shapes[object]).attr({stroke: "#ccc6ae", fill: "#f0efeb", "stroke-opacity": 1.5});
					p1.click(function () {
						var color = jQuery("#color").val();
						this.attr({fill: "#"+color});
					});
				}
				t1_f = r.setFinish();
				
				r.setStart();
				for (var object in tshirt2_frente.shapes) {
					p1 = r.path(tshirt2_frente.shapes[object]).attr({stroke: "#ccc6ae", fill: "#f0efeb", "stroke-opacity": 1.5});
					p1.click(function () {
						var color = jQuery("#color").val();
						var color = jQuery("#color").val();
						this.attr({fill: "#"+color});
					});
				}
				t2_f = r.setFinish();
				t2_f.hide();
				
				r.setViewBox(50, 200, 650, 600, true);
			});
			
			function limpa_cor() {
				if (seleccionado == 1)
					t1_f.attr({stroke: '#ccc6ae', fill: '#f0efeb', 'stroke-opacity': 1.5});
				if (seleccionado == 2)
					t2_f.attr({stroke: '#ccc6ae', fill: '#f0efeb', 'stroke-opacity': 1.5});
			}
		</script>
		<script src="js/foundation.min.js"></script>
		<?php include("mainjs.php"); ?>
		<script>
			$(document).foundation();
		</script>
	</body>
</html>