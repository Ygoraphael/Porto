<?php
include 'AppMail.php';
include("backoffice/Bd.php");
$lang = defaultLang();
if(isset($_GET['lang'])){
    foreach (langs() as $key => $value) {
        if($key == $_GET['lang']){
            $lang = $_GET['lang'];
        }
    }   
}
function menu_active_current_page($page) {
        $pn = page_name();
        if ($page == $pn) {
            echo 'class="current"';
        }          
    }
?>
<!doctype html>
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
	<title>Guedes, Alves e Pacheco LDA</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="Impact Ideas, Impact-Ideas.pt">
	<!-- STYLESHEETS -->	
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" >
	<link rel="stylesheet" href="fonts/font-awesome-4.2.0/css/font-awesome.min.css">
	<!-- Add fancyBox -->
	<link rel="stylesheet" href="js/fancybox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
	<!-- FONTS -->
	<link href='http://fonts.googleapis.com/css?family=Dosis:400,700' rel='stylesheet' type='text/css'>
	<!-- PARSLEY -->
	<link href="js/Parsley.js-2.0.5/src/parsley.css" rel="stylesheet">
	<!-- outdatedbrowser -->
    <link rel="stylesheet" type="text/css" href="js/outdatedbrowser/outdatedBrowser.min.css">
	<!-- MyBasicRules -->
	<link href="css/base2.2.css" rel="stylesheet">
	<!-- MyStyles -->
	<link href="css/styles.css?v18" rel="stylesheet">
	<!-- favicon -->
	<link rel="shortcut icon" href="favicon.ico">
	<!-- Modernizrrrr -->
	<!--[if IE]>
	<script src="js/modernizr-2.7.1.min.js" type="text/javascript"></script>
	<script src="js/Respond-master/src/respond.js"></script>
	<![endif]-->
</head>
<body class="test-rows">
<!--[if gte IE 9]>
  <style type="text/css">
    .gradient {
       filter: none;
    }
  </style>
<![endif]-->
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/pt_PT/all.js#xfbml=1&appId=657332391023261&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>
	<!-- PAGE -->
	<div id="page">
		<!-- NAV-BAR -->
		<div id="nav-bar">
			<div class="container">
				<div class="row">
					<div id="mobile-menu" class="visible-xs-block">
						<button type="button" class="btn btn-default"><span class="fa fa-bars"></span></button>		
					</div>
					<div id="logo-container" class="col-sm-2 col-md-2 col-lg-2">
						<div id="logo">
							<h1>
								<a href="index.php">
									<img src="img/site/logo.png" alt="gap" title="gap">
								</a>
							</h1>
						</div>
					</div>
					<div id="menu-mobile" class="col-sm-10 col-md-10 col-lg-10">
						<nav id="fixed-top-navigation">
							<ul class="list-inline pull-right">
								<li <?=menu_active_current_page("index")?> >
									<div class="left_tube"></div>
									<div class="center_tube">
										<a href="index.php">home</a>
									</div>
									<div class="right_tube"></div>
								</li>
								<li <?=menu_active_current_page("about")?> >
									<div class="left_tube"></div>
									<div class="center_tube">	
										<a href="about.php">sobre</a>
									</div>
									<div class="right_tube"></div>
								</li>
								<li <?=menu_active_current_page("services")?> >
									<div class="left_tube"></div>
									<div class="center_tube">	
										<a href="services.php">serviços</a>
									</div>
									<div class="right_tube"></div>
								</li>
								<li <?=menu_active_current_page("partners")?> >
									<div class="left_tube"></div>
									<div class="center_tube">	
										<a href="partners.php">parceiros</a>
									</div>
									<div class="right_tube"></div>
								</li>
								<li <?=menu_active_current_page("contacts")?> >
									<div class="left_tube"></div>
									<div class="center_tube">	
										<a href="contacts.php">contactos</a>
									</div>
									<div class="right_tube"></div>
								</li>
							</ul>
						</nav>
					</div>
				</div>
			</div>
		</div>
		<!--/NAV-BAR -->