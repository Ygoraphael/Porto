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
				$current_page = "Dashboard";
				include("breadcrumbs.php"); 
			?>
			
			<div class="row-fluid">
				<?php include("weather.php"); ?>
				<?php include("bot_intervencoes.php"); ?>
			</div>
			<div class="row-fluid">
				<?php include("intervencoes.php"); ?>
			</div>

			<?php include("dash_horas_trabalhadas.php"); ?>
						
			<div class="row-fluid">
				<?php include("dash_faturacao_anual.php"); ?>
				<div class="widget span3 red" onTablet="span6" onDesktop="span3">
					<h2><span class="glyphicons pie_chart"><i></i></span> Browsers</h2>
					<hr>
					<div class="content">
						<div class="browserStat big">
							<img src="img/browser-chrome-big.png" alt="Chrome">
							<span>34%</span>
						</div>
						<div class="browserStat big">
							<img src="img/browser-firefox-big.png" alt="Firefox">
							<span>34%</span>
						</div>
						<div class="browserStat">
							<img src="img/browser-ie.png" alt="Internet Explorer">
							<span>34%</span>
						</div>
						<div class="browserStat">
							<img src="img/browser-safari.png" alt="Safari">
							<span>34%</span>
						</div>
						<div class="browserStat">
							<img src="img/browser-opera.png" alt="Opera">
							<span>34%</span>
						</div>	
					</div>
				</div>
				<div class="widget yellow span4 noMargin" onTablet="span12" onDesktop="span4">
					<h2><span class="glyphicons fire"><i></i></span> Server Load</h2>
					<hr>
					<div class="content">
						 <div id="serverLoad2" style="height:224px;"></div>
					</div>
				</div>
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
