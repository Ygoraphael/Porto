<?php defined( '_JEXEC' ) or die( 'Restricted access' );?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<html xmlns="http://www.w3.org/1999/xhtml" class="no-js" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Porto Antigo</title>
		<!-- Bootstrap -->
		<script src="js/jquery.min.js"></script>
		<script src="js/modernizr.custom.js"></script>
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/jquery.fancybox.css" rel="stylesheet">
		<link href="css/flickity.css" rel="stylesheet" >
		<link href="css/animate.css" rel="stylesheet">
		<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
		<link href='http://fonts.googleapis.com/css?family=Nunito:400,300,700' rel='stylesheet' type='text/css'>
		<link href="css/styles.css" rel="stylesheet">
		<link href="css/queries.css" rel="stylesheet">
		<link href="css/queries.css" rel="stylesheet">
		<!-- Facebook and Twitter integration -->
		<meta property="og:title" content=""/>
		<meta property="og:image" content=""/>
		<meta property="og:url" content=""/>
		<meta property="og:site_name" content=""/>
		<meta property="og:description" content=""/>
		<meta name="twitter:title" content="" />
		<meta name="twitter:image" content="" />
		<meta name="twitter:url" content="" />
		<meta name="twitter:card" content="" />
		<jdoc:include type="head" />
		<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/system/css/system.css" type="text/css" />
		<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/system/css/general.css" type="text/css" />
		<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/template.css" type="text/css" />
		<style>
			.foot_contac p{
				color:white !important;
				font-size:18px !important;
			}
			.modal {
				display:    none;
				position:   fixed;
				z-index:    1000;
				top:        0;
				left:       0;
				height:     100%;
				width:      100%;
				background: rgba( 255, 255, 255, .8 ) 
							url('http://i.stack.imgur.com/FhHRx.gif') 
							50% 50% 
							no-repeat;
			}

			body.loading {
				overflow: hidden;   
			}

			body.loading .modal {
				display: block;
			}
		</style>
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
		<!--[if lt IE 7]>
		<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
		<![endif]-->
		<!-- open/close -->
		<header>
			<section class="hero">
				<div class="texture-overlay"></div>
				<div class="container">
					<div class="row hero-content">
						<div class="col-md-12">
							<center>
							<img src="images/_cartaz_PortoAntigo_2015.jpg" style="width:60%;" />
							</center>
						</div>
					</div>
				</div>
			</section>
		</header>
		<section class="screenshots-intro">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<h1>Informações</h1>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed a lorem quis neque interdum consequat ut sed sem. Duis quis tempor nunc. Interdum et malesuada fames ac ante ipsum primis in faucibus.</p>
						<br>
						<div class="row">
							<div class="col-md-3"></div>
							<div class="col-md-6"><center><h2>Formulário de Inscrição</h2></center></div>
							<div class="col-md-3"></div>
						</div>
						<br>
						<div class="row">
							<div class="col-md-3"></div>
							<div class="col-md-6"><jdoc:include type="modules" name="position-1" /></div>
							<div class="col-md-3"></div>
						</div>
						<div class="row">
							<div class="col-md-3"></div>
							<div class="col-md-6"><jdoc:include type="modules" name="position-3" /></div>
							<div class="col-md-3"></div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<section class="showcase">
			<div class="showcase-wrap">
				<div class="texture-overlay"></div>
				<div class="container">
					<div class="row">
						<div class="col-md-6">
							<h1>Local de Partida</h1>
							<p>Quinta da Bonjóia</p>
							<p>R. de Bonjóia, 185</p>
							<p>4300 Porto</p>
						</div>
						<div class="col-md-6">
							<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1502.0807083877469!2d-8.576639!3d41.152829!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd2464834375c50d%3A0xac3806c6db58c2fb!2sFunda%C3%A7%C3%A3o+Porto+Social!5e0!3m2!1spt-PT!2spt!4v1437999354996" width="500" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>
						</div>
					</div>
				</div>
			</div>
		</section>
		<?php if ($this->countModules( 'position-7' )) : ?>
		<section class="features-list" id="features">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<jdoc:include type="modules" name="position-7" />
					</div>
				</div>
			</div>
		</section>
		<?php endif; ?>
		<footer>
			<div class="container">
				<div class="row">
					<div class="col-md-5">
						<p>© <a href="http://patocycles.com">Patocycles</a> 2015</p>
					</div>
					<div class="col-md-7 foot_contac">
						<p>Rua Monte dos Burgos, nº 964</p>
						<p>4250-313 Porto</p>
						<p><b>Tel.</b> +351 228 323 885</p>
						<p><b>Telm.</b> +351 934 405 868</p>
						<p><b>Email.</b> web@patocycles.com</p>
					</div>
				</div>
			</div>
		</footer>
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="js/min/toucheffects-min.js"></script>
		<script src="js/flickity.pkgd.min.js"></script>
		<script src="js/jquery.fancybox.pack.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="js/retina.js"></script>
		<script src="js/waypoints.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/min/scripts-min.js"></script>
		<!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
		<script>
		(function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
		function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
		e=o.createElement(i);r=o.getElementsByTagName(i)[0];
		e.src='//www.google-analytics.com/analytics.js';
		r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
		ga('create','UA-XXXXX-X');ga('send','pageview');
		</script>
		<jdoc:include type="modules" name="position-2" />
		<div class="modal"><center style="margin-top:15%; font-size:3rem; font-weight:bold;">A fazer inscrição.<br>Aguarde por favor!</center></div>
	</body>
</html>
