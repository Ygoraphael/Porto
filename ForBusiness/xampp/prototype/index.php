<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<meta name="description" content="">
		<meta name="author" content="">
		<title>Prototype</title>
		<!-- Bootstrap core CSS -->
		<link href="css/bootstrap.css" rel="stylesheet">
		<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
		<link href="css/ie10-viewport-bug-workaround.css" rel="stylesheet">
		<!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
		<!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
		<script src="js/ie-emulation-modes-warning.js"></script>
		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		<!-- Custom styles for this template -->
		<link href="carousel.css" rel="stylesheet">
		<link href="css/bootstrap-theme.css" rel="stylesheet">
		<!-- Carousel -->
		<link rel="stylesheet" href="css/reset.css">
		<link rel="stylesheet" href="css/carousel-style.css">
		<link rel="stylesheet" href="css/font-awesome.min.css">
		<link rel="stylesheet" href="css/main_style.css">
		<script src="js/modernizr.js"></script>
	</head>
	<?php
		$index = 0;
		$categories = 0;
		$product_details = 1;
	?>
	<body>
		<nav class="navbar navbar-default navbar-static-top" style="width:100%; min-height:120px; background:url('img/topo.png') no-repeat; background-size: 100% 100%; border:0px;">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="#">
						<img class="logo-brand" style="" src="img/logo.png" />
						<img class="logo-brand2" style="margin-top:10px" src="img/logo2.png" />
					</a>
				</div>
				<div id="navbar" class="navbar-collapse collapse">
					<ul class="nav navbar-nav navbarproto">
						<li class="active"><a href="#">INÍCIO</a></li>
						<li><a href="#about">MARCA</a></li>
						<li><a href="#about">PRODUTOS</a></li>
						<li><a href="#contact">ESPECIFICAÇÕES</a></li>
						<li><a href="#contact">SUPORTE</a></li>
						<li><a href="#contact">NOTÍCIAS</a></li>
						<li><a href="#contact">CONTACTOS</a></li>
					</ul>
				</div><!--/.nav-collapse -->
			</div>
			<div class="store-controls">
				<div class="main-controls">
					<div class='fwidth clearfix'>
						<span class='pull-right' style="display:block;">
							<a href='#' class="cwhite">PT</a> | <a href='#'>ENG</a>
						</span>
					</div>
					<div class='fwidth clearfix'>
						<span class='pull-right'>
							<a href="#">Área de Cliente</a>
						</span>
					</div>
					<div class='fwidth clearfix'>
						<span class='pull-right'>
							<a href="#"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Carrinho de Compras</a>
						</span>
					</div>
				</div>
				<div class="social-controls">
					<span class='pull-right'>
						<a href="#"><i class="fa fa-facebook-official" aria-hidden="true"></i></a>
						<a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
						<a href="#"><i class="fa fa-youtube-play" aria-hidden="true"></i></a>
					</span>
				</div>
			</div>
			<div class="menu-store-controls">
				<div class="menu-main-controls clearfix">
					<span class='pull-right'>
						<a href="#"><i class="fa fa-user" aria-hidden="true"></i></a>
					</span>
					<span class='pull-right'>
						<a href="#"><i class="fa fa-shopping-cart" aria-hidden="true"></i></a>
					</span>
					<span class='pull-right' style="display:block;">
						<a href='#' class="cwhite">PT</a> | <a href='#'>ENG</a>
					</span>				
				</div>
			</div>
		</nav>
		<?php if($product_details) {
		?>
		<div class="col-lg-12 nopadding small-banner">
		</div>
		<div class="col-lg-12">
			<div class="col-lg-12">
				<div class="breadrumb col-lg-12">
					<span class="ftype01">PRODUTOS</span>
					<span class="ftype02">/ RODAS / ESTRADA</span>
				</div>
				<div class="col-lg-3 col-xs-12 prod-details-img">
					<div class="col-lg-12 col-xs-12 col-sm-12 prod-item">
						<div class="col-lg-12 prod-img-item">
							<img src="img/products/wheel001.jpg" />
						</div>
					</div>
				</div>
				<div class="col-lg-9 col-xs-12  prod-details-grid">
					<div class="col-lg-12 catinfo-main-item prod-details-text">
						<div class="catinfo-item">
							<div class="maininfo-item">3SL PRO TOUR</div>
							<div class="maininfopplus-item"></div>
						</div>
					</div>
					<div class="col-lg-12 prod-details-desc">
						Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco 
						laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit 
						in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
					</div>
					<div class="clearfix"> </div>
					<div class="col-lg-2 prod-details-grid1 nopadding">
						<div class="list-group panel-default">
							<a href="#" class="list-group-item panel-heading">REFERÊNCIA</a>
							<a href="#" class="list-group-item">MODELO:</a>
							<a href="#" class="list-group-item panel-heading">PESO:</a>
							<a href="#" class="list-group-item">URL SUPORTE TÉCNICO:</a>
							<a href="#" class="list-group-item panel-heading">URL MONTAGEM:</a>
						</div>
					</div>
					<div class="col-lg-10 prod-details-grid1 nopadding">
						<div class="list-group panel-default">
							<a href="#" class="list-group-item panel-heading">P74.25.004</a>
							<a href="#" class="list-group-item">ZERO</a>
							<a href="#" class="list-group-item panel-heading">0.0 gr</a>
							<a href="#" class="list-group-item"></a>
							<a href="#" class="list-group-item panel-heading"></a>
						</div>
					</div>
					<div class="col-lg-3 col-xs-12 col-sm-4 catinfo-main-item-2 prod-details-cart pull-right nopadding">
						<div class="catinfo-item-2">
							<div class="maininfo-item-2">ADICIONAR AO CARRINHO DE COMPRAS</div>
							<div class="maininfopplus-item-2"><center><i class="fa fa-cart-plus" aria-hidden="true"></i></center></div>
						</div>
					</div>
				</div>
				<div class="breadrumb col-lg-12">
					<span class="ftype02"><b>PRODUTOS SUGERIDOS</b></span>
				</div>
				<div class="col-lg-12 sug-prod clearfix">
					<div class="col-lg-6 col-xs-12 sug-prod-item">
						<div class="col-lg-4 col-xs-12 col-sm-12 prod-item">
							<div class="col-lg-12 col-xs-12 prod-img-item" onmouseenter="$(this).addClass('hover')" onmouseleave="$(this).removeClass('hover')">
								<img src="img/products/wheel001.jpg" />
								<div class="prod-img-overlay">
									<a href="#" class="expand">+</a>
								</div>
							</div>
						</div>
						<div class="col-lg-8 col-xs-12 sug-prod-desc">
							<div class="col-lg-12 col-xs-12 catinfo-main-item">
								<a class="catinfo-item">
									<div class="maininfo-item">3SL PRO TOUR</div>
									<div class="maininfopplus-item"><center><i class="fa fa-cart-plus" aria-hidden="true"></i></center></div>
								</a>
							</div>
							<div class="col-lg-12 col-xs-12 prod-details-desc">
								Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco 
								laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit 
								in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
							</div>
							<div class="col-lg-12 col-xs-12">
								<a href="#">+ ver mais</a>
							</div>
						</div>
					</div>
					<div class="col-lg-6 col-xs-12 sug-prod-item">
						<div class="col-lg-4 col-xs-12 col-sm-12 prod-item">
							<div class="col-lg-12 col-xs-12 prod-img-item" onmouseenter="$(this).addClass('hover')" onmouseleave="$(this).removeClass('hover')">
								<img src="img/products/wheel001.jpg" />
								<div class="prod-img-overlay">
									<a href="#" class="expand">+</a>
								</div>
							</div>
						</div>
						<div class="col-lg-8 col-xs-12 sug-prod-desc">
							<div class="col-lg-12 col-xs-12 catinfo-main-item">
								<a class="catinfo-item">
									<div class="maininfo-item">3SL PRO TOUR</div>
									<div class="maininfopplus-item"><center><i class="fa fa-cart-plus" aria-hidden="true"></i></center></div>
								</a>
							</div>
							<div class="col-lg-12 col-xs-12 prod-details-desc">
								Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco 
								laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit 
								in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
							</div>
							<div class="col-lg-12 col-xs-12">
								<a href="#">+ ver mais</a>
							</div>
						</div>
					</div>
					<div class="col-lg-6 col-xs-12 sug-prod-item">
						<div class="col-lg-4 col-xs-12 col-sm-12 prod-item">
							<div class="col-lg-12 col-xs-12 prod-img-item" onmouseenter="$(this).addClass('hover')" onmouseleave="$(this).removeClass('hover')">
								<img src="img/products/wheel001.jpg" />
								<div class="prod-img-overlay">
									<a href="#" class="expand">+</a>
								</div>
							</div>
						</div>
						<div class="col-lg-8 col-xs-12 sug-prod-desc">
							<div class="col-lg-12 col-xs-12 catinfo-main-item">
								<a class="catinfo-item">
									<div class="maininfo-item">3SL PRO TOUR</div>
									<div class="maininfopplus-item"><center><i class="fa fa-cart-plus" aria-hidden="true"></i></center></div>
								</a>
							</div>
							<div class="col-lg-12 col-xs-12 prod-details-desc">
								Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco 
								laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit 
								in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
							</div>
							<div class="col-lg-12 col-xs-12">
								<a href="#">+ ver mais</a>
							</div>
						</div>
					</div>
					<div class="col-lg-6 col-xs-12 sug-prod-item">
						<div class="col-lg-4 col-xs-12 col-sm-12 prod-item">
							<div class="col-lg-12 col-xs-12 prod-img-item" onmouseenter="$(this).addClass('hover')" onmouseleave="$(this).removeClass('hover')">
								<img src="img/products/wheel001.jpg" />
								<div class="prod-img-overlay">
									<a href="#" class="expand">+</a>
								</div>
							</div>
						</div>
						<div class="col-lg-8 col-xs-12 sug-prod-desc">
							<div class="col-lg-12 col-xs-12 catinfo-main-item">
								<a class="catinfo-item">
									<div class="maininfo-item">3SL PRO TOUR</div>
									<div class="maininfopplus-item"><center><i class="fa fa-cart-plus" aria-hidden="true"></i></center></div>
								</a>
							</div>
							<div class="col-lg-12 col-xs-12 prod-details-desc">
								Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco 
								laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit 
								in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
							</div>
							<div class="col-lg-12 col-xs-12">
								<a href="#">+ ver mais</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php }
		?>
		<?php if($categories) {
		?>
		<div class="col-lg-12 nopadding small-banner">
		</div>
		<div class="col-lg-12">
			<div class="col-lg-9">
				<div class="breadrumb col-lg-12">
					<span class="ftype01">PRODUTOS</span>
					<span class="ftype02">/ RODAS / ESTRADA</span>
				</div>
				<div class="col-lg-3">
					<div class="col-lg-12 nopadding">
						<div class="panel nopadding list-group cat-menu">
							<a class="list-group-item" style='background:#fee202'><span class="ftype01">Categorias</span></a>
							<a href="#" class="list-group-item" data-toggle="collapse" data-target="#m1">Componentes <span class="glyphicon glyphicon-plus pull-right"></span></a>
							<div id="m1" class="sublinks collapse">
								<a class="list-group-item small"><span class="glyphicon glyphicon-chevron-right"></span> Cat001</a>
								<a class="list-group-item small"><span class="glyphicon glyphicon-chevron-right"></span> Cat002</a>
							</div>
							<a href="#" class="list-group-item" data-toggle="collapse" data-target="#m2">Cubos <span class="glyphicon glyphicon-plus pull-right"></span></a>
							<div id="m2" class="sublinks collapse">
								<a class="list-group-item small"><span class="glyphicon glyphicon-chevron-right"></span> Cat001</a>
								<a class="list-group-item small"><span class="glyphicon glyphicon-chevron-right"></span> Cat002</a>
							</div>
							<a href="#" class="list-group-item" data-toggle="collapse" data-target="#m3">Oficina <span class="glyphicon glyphicon-plus pull-right"></span></a>
							<div id="m3" class="sublinks collapse">
								<a class="list-group-item small"><span class="glyphicon glyphicon-chevron-right"></span> Cat001</a>
								<a class="list-group-item small"><span class="glyphicon glyphicon-chevron-right"></span> Cat002</a>
							</div>
							<a href="#" class="list-group-item" data-toggle="collapse" data-target="#m4">Rodas <span class="glyphicon glyphicon-plus pull-right"></span></a>
							<div id="m4" class="sublinks collapse">
								<a class="list-group-item small"><span class="glyphicon glyphicon-chevron-right"></span> Cat001</a>
								<a class="list-group-item small"><span class="glyphicon glyphicon-chevron-right"></span> Cat002</a>
							</div>
						</div>
					</div>
					<div class="col-lg-12 nopadding">
						<div class="nopadding">
							<a class="list-group-item" style='background:#fee202'><span class="ftype01">Tags</span></a>
						</div>
						<div class="tags">
							<ul class=''>
								<li><a href="#">btt</a></li>
								<li><a href="#">estrada</a></li>
								<li><a href="#">pedaleira</a></li>
								<li><a href="#">acessórios</a></li>
								<li><a href="#">aros</a></li>
								<li><a href="#">parafusos</a></li>
								<li><a href="#">cubos</a></li>
								<li><a href="#">rolamentos</a></li>
								<li><a href="#">anilha</a></li>
								<li><a href="#">cassete</a></li>
								<li><a href="#">pratos</a></li>
								<li><a href="#">roldanas</a></li>
								<div class="clearfix"> </div>
							</ul>
						</div>
					</div>
				</div>
				<div class="col-lg-9">
					<div class="col-lg-12">
						<div class="col-lg-12 col-xs-12 col-sm-12">
							<div class="col-lg-4 col-xs-12 col-sm-4 prod-item">
								<div class="col-lg-12 prod-img-item" onmouseenter="$(this).addClass('hover')" onmouseleave="$(this).removeClass('hover')">
									<img src="img/products/wheel001.jpg" />
									<div class="prod-img-overlay">
										<a href="#" class="expand">+</a>
									</div>
								</div>
								<div class="col-lg-12 catinfo-main-item">
									<a class="catinfo-item">
										<div class="maininfo-item">3SL PRO TOUR</div>
										<div class="maininfopplus-item"><center><i class="fa fa-plus" aria-hidden="true"></i></center></div>
									</a>
								</div>
							</div>
							<div class="col-lg-4 col-xs-12 col-sm-4 prod-item">
								<div class="col-lg-12 prod-img-item" onmouseenter="$(this).addClass('hover')" onmouseleave="$(this).removeClass('hover')">
									<img src="img/products/wheel001.jpg" />
									<div class="prod-img-overlay">
										<a href="#" class="expand">+</a>
									</div>
								</div>
								<div class="col-lg-12 catinfo-main-item">
									<a class="catinfo-item">
										<div class="maininfo-item">3SL PRO TOUR</div>
										<div class="maininfopplus-item"><center><i class="fa fa-plus" aria-hidden="true"></i></center></div>
									</a>
								</div>
							</div>
							<div class="col-lg-4 col-xs-12 col-sm-4 prod-item">
								<div class="col-lg-12 prod-img-item" onmouseenter="$(this).addClass('hover')" onmouseleave="$(this).removeClass('hover')">
									<img src="img/products/wheel001.jpg" />
									<div class="prod-img-overlay">
										<a href="#" class="expand">+</a>
									</div>
								</div>
								<div class="col-lg-12 catinfo-main-item">
									<a class="catinfo-item">
										<div class="maininfo-item">3SL PRO TOUR</div>
										<div class="maininfopplus-item"><center><i class="fa fa-plus" aria-hidden="true"></i></center></div>
									</a>
								</div>
							</div>
							<div class="col-lg-4 col-xs-12 col-sm-4 prod-item">
								<div class="col-lg-12 prod-img-item" onmouseenter="$(this).addClass('hover')" onmouseleave="$(this).removeClass('hover')">
									<img src="img/products/wheel001.jpg" />
									<div class="prod-img-overlay">
										<a href="#" class="expand">+</a>
									</div>
								</div>
								<div class="col-lg-12 catinfo-main-item">
									<a class="catinfo-item">
										<div class="maininfo-item">3SL PRO TOUR</div>
										<div class="maininfopplus-item"><center><i class="fa fa-plus" aria-hidden="true"></i></center></div>
									</a>
								</div>
							</div>
							<div class="col-lg-4 col-xs-12 col-sm-4 prod-item">
								<div class="col-lg-12 prod-img-item" onmouseenter="$(this).addClass('hover')" onmouseleave="$(this).removeClass('hover')">
									<img src="img/products/wheel001.jpg" />
									<div class="prod-img-overlay">
										<a href="#" class="expand">+</a>
									</div>
								</div>
								<div class="col-lg-12 catinfo-main-item">
									<a class="catinfo-item">
										<div class="maininfo-item">3SL PRO TOUR</div>
										<div class="maininfopplus-item"><center><i class="fa fa-plus" aria-hidden="true"></i></center></div>
									</a>
								</div>
							</div>
							<div class="col-lg-4 col-xs-12 col-sm-4 prod-item">
								<div class="col-lg-12 prod-img-item" onmouseenter="$(this).addClass('hover')" onmouseleave="$(this).removeClass('hover')">
									<img src="img/products/wheel001.jpg" />
									<div class="prod-img-overlay">
										<a href="#" class="expand">+</a>
									</div>
								</div>
								<div class="col-lg-12 catinfo-main-item">
									<a class="catinfo-item">
										<div class="maininfo-item">3SL PRO TOUR</div>
										<div class="maininfopplus-item"><center><i class="fa fa-plus" aria-hidden="true"></i></center></div>
									</a>
								</div>
							</div>
							<div class="col-lg-4 col-xs-12 col-sm-4 prod-item">
								<div class="col-lg-12 prod-img-item" onmouseenter="$(this).addClass('hover')" onmouseleave="$(this).removeClass('hover')">
									<img src="img/products/wheel001.jpg" />
									<div class="prod-img-overlay">
										<a href="#" class="expand">+</a>
									</div>
								</div>
								<div class="col-lg-12 catinfo-main-item">
									<a class="catinfo-item">
										<div class="maininfo-item">3SL PRO TOUR</div>
										<div class="maininfopplus-item"><center><i class="fa fa-plus" aria-hidden="true"></i></center></div>
									</a>
								</div>
							</div>
							<div class="col-lg-4 col-xs-12 col-sm-4 prod-item">
								<div class="col-lg-12 prod-img-item" onmouseenter="$(this).addClass('hover')" onmouseleave="$(this).removeClass('hover')">
									<img src="img/products/wheel001.jpg" />
									<div class="prod-img-overlay">
										<a href="#" class="expand">+</a>
									</div>
								</div>
								<div class="col-lg-12 catinfo-main-item">
									<a class="catinfo-item">
										<div class="maininfo-item">3SL PRO TOUR</div>
										<div class="maininfopplus-item"><center><i class="fa fa-plus" aria-hidden="true"></i></center></div>
									</a>
								</div>
							</div>
							<div class="col-lg-4 col-xs-12 col-sm-4 prod-item">
								<div class="col-lg-12 prod-img-item" onmouseenter="$(this).addClass('hover')" onmouseleave="$(this).removeClass('hover')">
									<img src="img/products/wheel001.jpg" />
									<div class="prod-img-overlay">
										<a href="#" class="expand">+</a>
									</div>
								</div>
								<div class="col-lg-12 catinfo-main-item">
									<a class="catinfo-item">
										<div class="maininfo-item">3SL PRO TOUR</div>
										<div class="maininfopplus-item"><center><i class="fa fa-plus" aria-hidden="true"></i></center></div>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-3">
				<div class="featured col-lg-12">
					<span class="ftype01">DESTAQUES</span>
					<span class="ftype03"><a href="">+ ver mais</a></span>
				</div>
				<div class="col-lg-12 feat-main">
					<div class="col-lg-12 feat-cont">
						<a href="#">
							<div class="col-lg-12 feat-cont-img">
								<img src="img/ads/ad001.jpg" />
								<div class="overlay"><i class="fa fa-search" aria-hidden="true"></i></div>
							</div>
						</a>
						<a href="#">
							<div class="col-lg-12 feat-cont-img">
								<img src="img/ads/ad002.jpg" />
								<div class="overlay"><i class="fa fa-search" aria-hidden="true"></i></div>
							</div>
						</a>
						<a href="#">
							<div class="col-lg-12 feat-cont-img">
								<img src="img/ads/ad003.jpg" />
								<div class="overlay"><i class="fa fa-search" aria-hidden="true"></i></div>
							</div>
						</a>
					</div>
				</div>
			</div>
		</div>
		<?php }
		?>
		<?php if($index) {
		?>
		<div class="col-lg-12 bancarou" style="margin:0; padding:0;">
			<section class="cd-hero">
				<ul class="cd-hero-slider autoplay">
					<li class="selected">
						<div class="cd-full-width">
						</div> <!-- .cd-full-width -->
					</li>
					<li>
						<div class="cd-full-width">
						</div> <!-- .cd-full-width -->
					</li>
				</ul>
				<div class="ws_controls">
					<a href="#" class="ws_next">
						<span><i></i><b></b></span>
					</a>
					<a href="#" class="ws_prev">
						<span><i></i><b></b></span>
					</a>
					<a href="#" class="ws_playpause ws_pause">
						<span><i></i><b></b></span>
					</a>
				</div>
				<!-- .cd-hero-slider -->
				<div class="cd-slider-nav">
					<nav>
						<ul>
							<li class="selected"><span></span></li>
							<li><span></span></li>
						</ul>
					</nav> 
				</div> <!-- .cd-slider-nav -->
			</section> <!-- .cd-hero -->
		</div>
		<div class="col-lg-12" style="background:white;">
			<div class="row col-lg-8 paddinglr30">
				<div class="col-lg-12">
					<h2 class="col-lg-2">PRODUTOS</h2>
					<h2 class="col-lg-2" style='font-size:10px; padding-top:1.6vh;'><a style='font-size:10px; color:#E6C716;'>+ VER TODOS</a></h2>
					<hr class="col-lg-11 paddinglr40 zeromargin" style='background:yellow'>
				</div>
				<style>					
					.small-box {
						overflow: hidden;
					}
				</style>
				<div class="col-lg-6 product_main">
					<div class="col-lg-12 product_sec small-box" style="padding:0;">
						<a class="catinfo">
							<div class="maininfo">GAMA PHYSIS</div>
							<div class="maininfopplus"><center><i class="fa fa-plus" aria-hidden="true"></i></center></div>
						</a>
						<img src="img/products/3.png" style="" class="img-responsive" />  
					</div>
				</div>
				<div class="col-lg-6 product_main">
					<div class="col-lg-12 product_sec small-box" style="padding:0;">
						<a class="catinfo">
							<div class="maininfo">ACESSÓRIOS</div>
							<div class="maininfopplus"><center><i class="fa fa-plus" aria-hidden="true"></i></center></div>
						</a>
						<img src="img/products/3.png" style="" class="img-responsive" />  
					</div>
				</div>
				<div class="col-lg-6 product_main">
					<div class="col-lg-12 product_sec small-box" style="padding:0;">
						<a class="catinfo">
							<div class="maininfo">RODAS MTB</div>
							<div class="maininfopplus"><center><i class="fa fa-plus" aria-hidden="true"></i></center></div>
						</a>
						<img src="img/products/3.png" style="" class="img-responsive" />  
					</div>
				</div>
				<div class="col-lg-6 product_main">
					<div class="col-lg-12 product_sec small-box" style="padding:0;">
						<a class="catinfo">
							<div class="maininfo">RODAS ESTRADA</div>
							<div class="maininfopplus"><center><i class="fa fa-plus" aria-hidden="true"></i></center></div>
						</a>
						<img src="img/products/3.png" style="" class="img-responsive" />  
					</div>
				</div>
			</div>
			<div class="row col-lg-4 paddinglr30" style="margin-bottom:20px;">
				<div class="col-lg-12">
					<h2 class="col-lg-4">NOTÍCIAS</h2>
					<hr class="col-lg-10 paddinglr40 zeromargin" style='background:yellow'>
				</div>
				<div class="col-lg-12 product_main">
					<div class="col-lg-3 col-sm-3 col-xs-12 product_sec nopadding">
						<img src="img/news/square.png" style="" class="img-responsiveH" />
					</div>
					<div class="col-lg-9 col-sm-9 col-xs-12 product_sec nopadding">
						<div class="col-lg-12 newscontent">
							Em finais de 2006, dois jovens juntaram-se e criaram aquela que foi a primeira loja de referência nacional, On-Line, com sede em Portugal e a 
							comercializar produtos de bicicletas a preços baixos - Racing Cycle.
						</div>
						<div class="col-lg-12">
							<a class='pull-right'>+ ver mais</a>
						</div>
					</div>
				</div>
				<div class="col-lg-12 product_main">
					<div class="col-lg-3 col-sm-3 col-xs-12 product_sec nopadding">
						<img src="img/news/square.png" style="" class="img-responsiveH" />
					</div>
					<div class="col-lg-9 col-sm-9 col-xs-12 product_sec nopadding">
						<div class="col-lg-12 newscontent">
							Em finais de 2006, dois jovens juntaram-se e criaram aquela que foi a primeira loja de referência nacional, On-Line, com sede em Portugal e a 
							comercializar produtos de bicicletas a preços baixos - Racing Cycle.
						</div>
						<div class="col-lg-12">
							<a class='pull-right'>+ ver mais</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php }
		?>
		<footer class="col-lg-12 paddinglr30" style="min-height:90px; background:url('img/rodape.png') no-repeat; background-size: 100% 100%;">
            <div class="col-lg-4" style="color:white; margin-top:0px;">
				<nav class="">
					<div class="container" style="top:0px; width:100%">
						<div id="navbar" class="">
							<ul class="nav navbar-nav">
								<li class="active"><a class="menubut" href="#">MARCA</a></li>
								<li class="menubord"><a href="#about" class="menubut">PRODUTOS</a></li>
								<li class="menubord"><a href="#contact" class="menubut">ESPECIFICAÇÕES</a></li>
								<li class="menubord"><a href="#contact" class="menubut">SUPORTE</a></li>
								<li class="menubord"><a href="#contact" class="menubut">NOTÍCIAS</a></li>
								<li class="menubord"><a href="#contact" class="menubut">CONTACTOS</a></li>
							</ul>
						</div>
					</div>
				</nav>
			</div>
			<div class="col-lg-8" style="margin-top:0px;">
				<a class="navbar-brand pull-right" style="padding:10 0 0 0;" href="#">
					<img class="" style="width:200px" src="img/logo.png" />
					<img class="" style="width:120px; margin-top:10px" src="img/logo2.png" />
				</a>
			</div>
         </footer>
		<!-- Bootstrap core JavaScript
			================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<script>window.jQuery || document.write('<script src="js/vendor/jquery.min.js"><\/script>')</script>
		<script src="js/carousel-main.js"></script>
		<script src="js/jquery.mobile.custom.js"></script>
		<!-- <script src="http://hammerjs.github.io/dist/hammer.min.js"></script> -->
		<script src="js/bootstrap.min.js"></script>
		<!-- Just to make our placeholder images work. Don't actually copy the next line! -->
		<script src="js/holder.min.js"></script>
		<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
		<script src="js/ie10-viewport-bug-workaround.js"></script>
		<script>
			var wwidth = jQuery( window ).width();
			jQuery(".cd-hero-slider").css("height", wwidth*680/1903);
			$( window ).resize(function() {
				var wwidth = jQuery( window ).width();
				jQuery(".cd-hero-slider").css("height", wwidth*680/1903);
			});
		 </script>
	</body>
</html>