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
						$pag = "index";
						include("menu.php"); 
					?>
				</aside>
				<section class="main-section">
					<br>
					<div class="row">
						<div class="large-12 small-12 columns left">
							<i class="step fi-graph-pie size-12 left"></i>
							<a style="margin-left:5px;" class='text001'>Dashboard</a>
							<br>
							<a class='text003'>Tablero de bordo</a>
						</div>
					</div>
					<hr />
					<div class="row">
						<div class="large-4 columns text-center">
							<div class="row">
								<div class="large-12 small-12 columns">
									<h4>Proyectos por vendedor</h4>
								</div>
							</div>
							<div class="row">
								<div id="canvas-holder" class="large-12 small-12 columns">
									<canvas id="chart-area" style="height:100%; width:100%;"/>
								</div>
							</div>
							<script>
								var pieData = [
									{
										value:  2487.00,
										color:"#F7464A",
										highlight: "#FF5A5E",
										label: "Fullwear"
									},
									{
										value:  366.00,
										color: "#46BFBD",
										highlight: "#5AD3D1",
										label: "Miguel Martinez"
									}
								];

								var ctx = document.getElementById("chart-area").getContext("2d");
								window.myPie = new Chart(ctx).Pie(pieData);
							</script>
						</div>
						<div class="large-4 columns text-center">
							<div class="row">
								<div class="large-12 small-12 columns">
									<h4>Creación de Proyectos por Mes en 2015</h4>
								</div>
							</div>
							<div class="row">
								<div id="canvas-holder1" class="large-12 small-12 columns">
									<canvas id="canvas" style="height:100%; width:90%;"></canvas>
								</div>
							</div>
							<script>
								var randomScalingFactor = function(){ return Math.round(Math.random()*100)};
								var barChartData = {
									labels : ["enero","febrero","marzo","abril","mayo"],
									datasets : [
										{
											fillColor : "rgba(220,220,220,0.5)",
											strokeColor : "rgba(220,220,220,0.8)",
											highlightFill: "rgba(220,220,220,0.75)",
											highlightStroke: "rgba(220,220,220,1)",
											data : [randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor()]
										}
									]
								}
								var ctx2 = document.getElementById("canvas").getContext("2d");
								window.myBar = new Chart(ctx2).Bar(barChartData, {

								});
							</script>
						</div>
						<div class="large-4 columns text-center"></div>
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