<?php defined( '_JEXEC' ) or die( 'Restricted access' );?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" >
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<meta name="description" content="">
		<meta name="author" content="">
		<title>Prototype</title>
		<!-- Bootstrap core CSS -->
		<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/system/css/system.css" type="text/css" />
		<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/system/css/general.css" type="text/css" />
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
		<jdoc:include type="head" />
		<script>var $jq = jQuery.noConflict();</script>
		<link href="carousel.css" rel="stylesheet">
		<link href="css/bootstrap-theme.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="css/widgets.css" media="all" />
		
		<link rel="stylesheet" type="text/css" href="js/modalbox.css" media="all" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="css/fancybox.css" media="all" />
		<link rel="stylesheet" type="text/css" href="css/print.css" media="print" />
		
		<script type="text/javascript" src="js/bundle.js"></script>
		<script type="text/javascript" src="js/all.js"></script>
		<script type="text/javascript" src="js/nav.js"></script>
		<script type="text/javascript" src="js/cart.js"></script>
		<script type="text/javascript" src="js/products-slider.js"></script>
		<script type="text/javascript" src="js/left-nav.js"></script>
		<script type="text/javascript" src="js/cat-slides.js"></script>
		<script type="text/javascript" src="js/mob-nav.js"></script>
		<script type="text/javascript" src="js/pro-img-slider.js"></script>
		<script type="text/javascript" src="js/toggle.js"></script>
		<script type="text/javascript" src="js/cloud-zoom.js"></script>
		<script type="text/javascript" src="js/jquery.fancybox-1.3.4.pack.js"></script>
		<script type="text/javascript" src="js/jquery.lettering.js"></script>
		<script type="text/javascript" src="js/easing.js"></script>
		<script type="text/javascript" src="js/eislideshow.js"></script>
		<script type="text/javascript" src="js/jquery.elevatezoom.js"></script>
		<!-- Carousel -->
		<link rel="stylesheet" href="css/reset.css">
		<link rel="stylesheet" href="css/carousel-style.css">
		<link rel="stylesheet" href="css/font-awesome.min.css">
		<link rel="stylesheet" href="css/main_style.css">
		<script src="js/modernizr.js"></script>
	</head>
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
					<a class="navbar-brand" href="">
						<img class="logo-brand" style="" src="img/logo.png" />
						<img class="logo-brand2" style="margin-top:10px; margin-right: 14px; float: right;" src="img/logo2.png" />
					</a>
				</div>
				<div id="navbar" class="navbar-collapse collapse">
					<jdoc:include type="modules" name="menu_top" />
				</div><!--/.nav-collapse -->
			</div>
			<div class="store-controls" style="margin-top: 13px;">
				<div class="main-controls">
					<div class="social-controls" style="position: absolute; right: 27px;">
						<span class='pull-right'>
							<a href="https://www.facebook.com/PrototypeRacingParts"><i class="fa fa-facebook-official" aria-hidden="true"></i></a>
							<a href="https://www.instagram.com/prototype_racingparts/"><i class="fa fa-instagram" aria-hidden="true"></i></a>
							<a href="https://www.youtube.com/channel/UCG2x3QzlUbvlFiOItYi9nFA"><i class="fa fa-youtube-play" aria-hidden="true"></i></a>
						</span>
					</div>
					<div class='fwidth clearfix' style="position: relative; width: 61%;">
						<span class='pull-left' style="display:block; margin-left: 48px;">
							<jdoc:include type="modules" name="language" />
						</span>
					</div>
					
					<div class='fwidth clearfix'>
						<span class='pull-right'>
							<?php
								$lang = JFactory::getLanguage();
								$lacliente = '';
								$acliente = '';
								$entrar = '';
								if( $lang->getTag() == 'pt-PT' )
								{
										$lacliente = 'Área de Cliente';
										$acliente = 'area-de-cliente';
										$entrar = 'entrar';
								}
								else if( $lang->getTag() == 'en-GB' )
								{
										$lacliente = 'Client Area';
										$acliente = 'client-area';
										$entrar = 'login';
								}
								if (JFactory::getUser()->id > 0) 
								{
									?>
									<a href="index.php/<?php echo $acliente; ?>" title="Área de Cliente"><?php echo $lacliente; ?></a>
									<?php
								}
								else
								{?>
									<a href="index.php/<?php echo $entrar; ?>" title="Área de Cliente"><?php echo $lacliente; ?></a>
									<?php
								}
							?>
						</span>
					</div>
					<div class='fwidth clearfix'>
						<span class='pull-right'>
							<jdoc:include type="modules" name="cart" />
						</span>
					</div>
				</div>
				
			</div>
			<div class="menu-store-controls">
				<div class="menu-main-controls clearfix">
					<span class='pull-right'>
						<a href="#"><i class="fa fa-user" aria-hidden="true"></i></a>
					</span>
					<span class='pull-right'>
						<a href="index.php/component/virtuemart/cart"><i class="fa fa-shopping-cart" aria-hidden="true"></i></a>
					</span>
					<span class='pull-right' style="display:block;">
						<a href='<?php echo JURI::root(); ?>index.php/pt' class="cwhite">PT</a> | <a href='<?php echo JURI::root(); ?>index.php/en/'>ENG</a>
					</span>				
				</div>
			</div>
		</nav>
		<?php
			$app = JFactory::getApplication();
			$menu = $app->getMenu();
			if ($app->getMenu()->getActive()->home) {
		?>
		
		<style>
			<?php
				$dir = "carousel";
				$dh  = opendir($dir);
				while (false !== ($filename = readdir($dh))) {
					$files[] = $filename;
				}
				$files_images = array();
				
				foreach($files as $file) {
					if( (strpos(strtolower($file), '.jpg') !== false) || (strpos(strtolower($file), '.png') !== false) || (strpos(strtolower($file), '.gif') !== false) || (strpos(strtolower($file), '.BMP') !== false) ) {
						$files_images[] = $file;
					}
				}
				
				$number_banners = sizeof($files_images);
				$string_img = "";
				$string_nav = "";
				for($i=0;$i<$number_banners;$i++) {
					if($i==0) {
						$string_img .= '<li class="selected"><div class="cd-full-width"></div></li>';
						$string_nav .= '<li class="selected"><span></span></li>';
					}
					else {
						$string_img .= '<li><div class="cd-full-width"></div></li>';
						$string_nav .= '<li><span></span></li>';
					}
					
			?>
				.cd-hero-slider li:nth-of-type(<?php echo $i+1; ?>) {
					background-color: #2c343b;
					background-image: url(<?php echo JURI::root(); ?>carousel/<?php echo $files_images[$i]; ?>);
				}
			<?php
				}
			?>
			</style>
			<div class="col-lg-12 bancarou" style="margin:0; padding:0;">
				<section class="cd-hero">
					<ul class="cd-hero-slider autoplay">
						<?php echo $string_img; ?>
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
								<?php echo $string_nav; ?>
							</ul>
						</nav> 
					</div> <!-- .cd-slider-nav -->
				</section> <!-- .cd-hero -->
			</div>
			<div class="col-lg-12" style="background:white;">
				<div class="row col-lg-8 paddinglr30">
					<div class="col-lg-12">
						<h2 class="col-lg-2"><?php echo JText::_('NC_PRODUCTS'); ?></h2>
						<?php
							$lang = JFactory::getLanguage();

							if( $lang->getTag() == 'pt-PT' )
							{
								$pag_produtos = 'index.php/pt/produtos';
							}
							else if( $lang->getTag() == 'en-GB' )
							{
								$pag_produtos = 'index.php/en/products';
							}
						?>
						<h2 class="col-lg-2" style='font-size:10px; padding-top:1.6vh;'><a href="<?php echo $pag_produtos; ?>" style='font-size:10px; color:#E6C716;'><?php echo JText::_('NC_SEE_ALL'); ?></a></h2>
						<hr class="col-lg-11 paddinglr40 zeromargin" style='background:yellow'>
					</div>
					<style>					
						.small-box {
							overflow: hidden;
						}
					</style>
					<?php
						$lang = JFactory::getLanguage();
						$db = JFactory::getDbo();
						$query = $db->getQuery(true);
						$query->select('*');
						$query->from($db->quoteName('#__content'));
						$query->where($db->quoteName('catid') . ' = 12');
						$query->where($db->quoteName('state') . ' = 1');
						$query->where($db->quoteName('language') . ' = ' . $db->quote($lang->getTag()));
						$query->order('id ASC');
						$db->setQuery($query,0,4);

						$results = $db->loadObjectList();

						foreach( $results as $categoria ) {
							$images_cat = split(',',$categoria->images);
							$images_cat = split(':',$images_cat[0]);
							$images_cat = str_replace('\/', '/', $images_cat[1]);
							$images_cat = str_replace('"', '', $images_cat);
							if(trim($images_cat) == '') {
								$images_cat = "img/news/square.png";
							}
							
							$url_cat = split(',',$categoria->urls);
							$url_cat = split(':',$url_cat[0]);
							$url_cat = str_replace('\/', '/', $url_cat[2]);
							$url_cat = str_replace('"', '', $url_cat);
							if(trim($url_cat) == '') {
								$url_cat = "img/news/square.png";
							}
							else {
								$url_cat = substr($url_cat, strpos($url_cat,"index.php"));
							}
							
						?>
						<div class="col-lg-6 product_main">
							<div class="col-lg-12 product_sec small-box" style="padding:0;">
								<a href="<?php echo $url_cat; ?>" class="catinfo">
									<div class="maininfo"><?php echo $categoria->introtext; ?></div>
									<div class="maininfopplus"><center><i class="fa fa-plus" aria-hidden="true"></i></center></div>
								</a>
								<img src="<?php echo $images_cat; ?>" style="" class="img-responsive" />  
							</div>
						</div>
						<?php
						}
					?>
				</div>
				<div class="row col-lg-4 paddinglr30" style="margin-bottom:20px;">
					<div class="col-lg-12">
						<h2 class="col-lg-4"><?php echo JText::_('NC_NEWS'); ?></h2>
						<hr class="col-lg-10 paddinglr40 zeromargin" style='background:yellow'>
					</div>
					<?php
						$lang = JFactory::getLanguage();
						$db = JFactory::getDbo();
						$query = $db->getQuery(true);
						$query->select('*');
						$query->from($db->quoteName('#__content'));
						$query->where($db->quoteName('catid') . ' = 9');
						$query->where($db->quoteName('state') . ' = 1');
						$query->where($db->quoteName('language') . ' = ' . $db->quote($lang->getTag()));
						$query->order('created DESC');
						$db->setQuery($query,0,2);

						$results = $db->loadObjectList();

						foreach( $results as $noticia ) {
							$images_news = split(',',$noticia->images);
							$images_news = split(':',$images_news[0]);
							$images_news = str_replace('\/', '/', $images_news[1]);
							$images_news = str_replace('"', '', $images_news);
							if(trim($images_news) == '') {
								$images_news = "img/news/square.png";
							}
						?>
						<div class="col-lg-12 product_main">
							<div class="col-lg-3 col-sm-3 col-xs-12 product_sec nopadding">
								<img src="<?php echo $images_news; ?>" style="" class="img-responsiveH" />
							</div>
							<div class="col-lg-9 col-sm-9 col-xs-12 product_sec nopadding">
								<div class="col-lg-12 newscontent">
									<?php echo $noticia->introtext; ?>
								</div>
								<div class="col-lg-12">
									<a class='pull-right' href='index.php?option=com_content&view=article&id=<?php echo $noticia->id; ?>'><?php echo JText::_('NC_SEE_MORE'); ?></a>
								</div>
							</div>
						</div>
						<?php
						}
					?>
				</div>
			</div>
		<?php
			}
			else {
		?>
			<div class="col-lg-12 col-xs-12 nopadding small-banner"></div>
			<div class="col-lg-12 col-xs-12 clearfix" style='margin-bottom:10px; min-height:800px;'>
				<div class="<?php if ($this->countModules( 'right' )) { echo 'col-lg-9 col-xs-12'; } else { echo 'col-lg-12 col-xs-12'; } ?> nopadding">
					<div class="breadrumb col-lg-12">
						<span class="ftype01"><jdoc:include type="modules" name="breadcrumb" /></span>
					</div>
					<?php if ($this->countModules( 'left' )) { ?>
					<div class="col-lg-3 col-xs-12">
						<jdoc:include type="modules" name="left" />
					</div>
					<?php } ?>
					<div class="<?php if ($this->countModules( 'left' )) { echo 'col-lg-9 col-xs-12'; } else { echo 'col-lg-12 col-xs-12'; } ?>">
						<div class="col-lg-12 col-xs-12 nopadding">
							<div class="col-lg-12 col-xs-12 col-sm-12 nopadding">
								<jdoc:include type="component" />
								<jdoc:include type="modules" name="center-top" />
							</div>
						</div>
					</div>
					<?php if ($this->countModules( 'prod_sug' )) { ?>
						<jdoc:include type="modules" name="prod_sug" />
					<?php } ?>
				</div>
				<?php if ($this->countModules( 'right' )) { ?>
				<div class="col-lg-3 col-xs-12">
					<jdoc:include type="modules" name="right" />
				</div>
				<?php } ?>
			</div>
		<?php
			}
		?>
		<footer class="col-lg-12 paddinglr30 clearfix" style="min-height:90px; background:url('img/rodape.png') no-repeat; background-size: 100% 100%;">
            <div class="col-lg-7 col-sm-9 col-md-8 col-xs-8" style="color:white; margin-top:0px;">
				<nav class="">
					<div class="container" style="top:0px; width:100%">
						<div id="navbar" class="">
							<jdoc:include type="modules" name="menu-bottom" />
						</div>
					</div>
				</nav>
			</div>
			<div class="col-lg-5 col-sm-3 col-md-4 col-xs-4" style="margin-top:0px;">
				<a class="navbar-brand pull-right" style="padding:10 0 0 0;" href="#">
					<img class="" style="width:200px" src="img/logo.png" />
					<img class="" style="width:120px; margin-top:10px; margin-right: 14px; float: right;" src="img/logo2.png" />
				</a>
			</div>
			<div class="col-lg-8 col-sm-8 col-md-8 col-xs-8" style="margin-top:15px; margin-bottom:25px;">
				<img src="img/POCentro_PT2020_FEDER_Bom.png" style="width:600px;" />
			</div>
			<?php
			if( $lang->getTag() == 'pt-PT' )
			{
					$privacidade = 'Privacidade';
					$termos = 'Termos e condições';
					$privacidadelink = 'privacidade';
					$termoslink = 'termos-e-condicoes';
			}
			else if( $lang->getTag() == 'en-GB' )
			{
					$privacidade = 'Privacy';
					$termos = 'Terms and Conditions';
					$privacidadelink = 'privacy';
					$termoslink = 'terms-and-conditions';
			}
			?>
			<div class="col-lg-4 col-sm-4 col-md-4 col-xs-4" style="margin-top:81px; margin-bottom:0px; text-align: -webkit-right;">
				<ul class="nav navbar-nav" style="float:right;">
					<li><a href="index.php/<?php echo $privacidadelink;?>" class="menubut" title="Privacidade"><?php echo $privacidade;?></a></li>
					<li><a href="index.php/<?php echo $termoslink;?>" class="menubut" title="Termos e condições"><?php echo $termos;?></a></li>
				</ul>
			</div>
         </footer>
		<!-- Bootstrap core JavaScript
			================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->
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
			jQuery( window ).resize(function() {
				var wwidth = jQuery( window ).width();
				jQuery(".cd-hero-slider").css("height", wwidth*680/1903);
			});
		 </script>
	</body>
</html>