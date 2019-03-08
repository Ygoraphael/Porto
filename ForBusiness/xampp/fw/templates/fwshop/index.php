<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <jdoc:include type="head" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="CSS/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="<?php echo $this->baseurl ?>/CSS/CSS.css" type="text/css" media="all">
    <link rel="stylesheet" href="<?php echo $this->baseurl ?>/CSS/CSS_SEC.css" type="text/css" media="all">
    <link rel="stylesheet" href="<?php echo $this->baseurl ?>/CSS/animations.css" type="text/css" media="all">
    <link rel="stylesheet" href="<?php echo $this->baseurl ?>/CSS/animate.css" type="text/css" media="all">
    <link rel="stylesheet" href="<?php echo $this->baseurl ?>/CSS/checkboxlist.css" type="text/css" media="all">
    <link rel="stylesheet" href="<?php echo $this->baseurl ?>/CSS/common.css" type="text/css" media="all">
    <link rel="stylesheet" href="<?php echo $this->baseurl ?>/CSS/vmpanels.css" type="text/css" media="all">
    <link rel="stylesheet" href="<?php echo $this->baseurl ?>/CSS/vtip.css" type="text/css" media="all">
    <link rel="stylesheet" href="<?php echo $this->baseurl ?>/CSS/jquery.fancybox-1.3.4.css" type="text/css" media="all">
    <link rel="stylesheet" href="<?php echo $this->baseurl ?>/CSS/validationEngine.jquery.css" type="text/css" media="all">
    <link rel="stylesheet" href="<?php echo $this->baseurl ?>/CSS/fontes.css" type="text/css" media="all">
    <link rel="stylesheet" href="<?php echo $this->baseurl ?>/CSS/modal.css" type="text/css" media="all">
    <link rel="stylesheet" href="<?php echo $this->baseurl ?>/CSS/menu_horizontal.css" type="text/css" media="all">
    <link rel="stylesheet" href="<?php echo $this->baseurl ?>/CSS/cptrackbar.css" type="text/css" media="all">
    <link rel="stylesheet" href="<?php echo $this->baseurl ?>/CSS/owl.carousel.css">
    <link rel="stylesheet" href="<?php echo $this->baseurl ?>/CSS/owl.theme.default.css">
    <script type="text/javascript" src="<?php echo $this->baseurl ?>/customJS/jquery-migrate.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->baseurl ?>/customJS/owl.carousel.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->baseurl ?>/customJS/lightbox.js"></script>
    <script type="text/javascript" src="<?php echo $this->baseurl ?>/customJS/jquery.themepunch.tools.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->baseurl ?>/customJS/jquery.themepunch.revolution.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->baseurl ?>/customJS/cs-head.min.js"></script>
    <script type="text/javascript" src="<?php echo $this->baseurl ?>/customJS/jquery.printarea.js"></script>
    <script type="text/javascript" src="<?php echo $this->baseurl ?>/customJS/jquery.fancybox-1.3.4.pack.js"></script>
    <script type="text/javascript" src="<?php echo $this->baseurl ?>/customJS/cptrackbar.js"></script>
</head>
<body>
    <div id="wrapper">
        <div id="sidebar-wrapper" class="custom-scrollbar">
            <jdoc:include type="modules" name="position-4" />
        </div>
    </div>
    <nav class="navbar navbar-expand-md reset-navbar-color" style="padding:0px;">
        <jdoc:include type="modules" name="languageBar" />
    </nav>
    <nav class="navbar navbar-expand-md reset-navbar-color" style="padding:0;">
        <div class="container" style="padding:0px;">
            <div class="center-img">
                <a href="<?php echo JURI::ROOT(); ?>"><img class="img-change img-fluid" src="<?php echo JURI::ROOT(); ?>/templates/fwshop/images/logo_fw.png"></a>
            </div>
        </div>
    </nav>
    <nav id="header" class="navbar navbar-expand-md reset-navbar-color navBorder" style="padding:10px 0 0 0;">
        <div class="container" style="padding:0;">
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbar-collapsed" aria-controls="navbar-collapsed" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa fa-bars" aria-hidden="true" style="color:white;"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbar-collapsed" style=" max-height:200px !important;">
                <ul class="navbar-nav mr-auto reset-nav-bottom">
                    <li>
                        <div class="titleFont" style="padding-left:6%; padding-right:5%">
                            <a href="<?php echo JURI::ROOT(); ?>"><?php echo JText::_('NOVOSCANAIS_HOME'); ?></a>
                        </div>
                    </li>
                    <li class="sub-menu-parent">
                        <?php
                        $lang = JFactory::getLanguage();
                        if ($lang->getTag() == "en-GB") {
                            $PVmUrl = "products";
                        } elseif ($lang->getTag() == "es-ES") {
                            $PVmUrl = "productos";
                        } else {
                            $PVmUrl = "produtos";
                        }
                        ?>
                        <div class="titleFont" style="padding-left:5%; padding-right:5%">
                            <a href="index.php/<?= $PVmUrl ?>/search?Genero=MASCULINO"><?php echo JText::_('NOVOSCANAIS_MAN'); ?></a>
                        </div>
                        <!-- -->
                        <ul class="sub-menu">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="row">
                                            <jdoc:include type="modules" name="menu-homem" />
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="row">
                                            <div class="col-md-12" >
                                                <div class="row">
                                                    <div class="col-md-12 reset-img1">
                                                        <jdoc:include type="modules" name="menu-homem-1" />
                                                    </div>
                                                    <div class="col-md-12 reset-img2">
                                                        <jdoc:include type="modules" name="menu-homem-2" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end container man -->
                        </ul>
                    </li>
                    <li class="sub-menu-parent">
                        <div class="titleFont" style="padding-left:5%; padding-right:5%">
                            <a href="index.php/<?= $PVmUrl ?>/search?Genero=FEMININO"><?php echo JText::_('NOVOSCANAIS_WOMAN'); ?></a>
                        </div>
                        <!-- -->
                        <ul class="sub-menu">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="row">
                                            <jdoc:include type="modules" name="menu-mulher" />
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="row">
                                            <div class="col-md-12" >
                                                <div class="row">
                                                    <div class="col-md-12 reset-img1">
                                                        <jdoc:include type="modules" name="menu-mulher-1" />
                                                    </div>
                                                    <div class="col-md-12 reset-img2">
                                                        <jdoc:include type="modules" name="menu-mulher-2" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end container woman -->
                        </ul>
                        <!-- -->
                    </li>
                    <li class="sub-menu-parent">
                        <div class="titleFont" style="padding-left:5%; padding-right:5%">
                            <a href="#"><?php echo JText::_('NOVOSCANAIS_COLECTIONS'); ?></a>
                        </div>
                        <ul class="sub-menu">
                            <div class="container">
                                <div class="row">
                                    <jdoc:include type="modules" name="menu-colecoes" />
                                </div>
                            </div>
                        </ul>
                    </li>
                    <li>
                        <div class="titleFont" style="padding-left:5%; padding-right:5%">
                            <a href="http://fullwear.pt/fw2016/" target="_blank"><?php echo JText::_('NOVOSCANAIS_CUSTOM'); ?></a>
                        </div>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right subnavbar-mobile">
                    <div class="row" style="margin:0 auto;">
                        <li>
                            <a href="#langBar" class="globe linkColor" data-toggle="collapse" href="#langBar" aria-expanded="true" aria-controls="langBar">
                                <i id="globe" class="awesome-color fa fa-globe fa-2x" aria-hidden="true"></i>
                            </a>
                        </li>
                        <li id="search">
                            <a class="linkColor d-block awesome-color fa fa-search fa-2x" data-toggle="collapse" href="#searchStuff" aria-expanded="true" aria-controls="searchStuff"></a>
                        </li>
                        <li class="sub-menu-parent" style="cursor:pointer;">
                            <i class="linkColor awesome-color fa fa-user fa-2x" aria-hidden="true"></i>
                            <ul class="sub-menu logItem">
                                <jdoc:include type="modules" name="position-5" />
                            </ul>
                        </li>
                        <li>
                        <jdoc:include type="modules" name="position-1" />
                        </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
<div class="container">
    <div class="card">
        <div id="searchStuff" class="collapse" aria-labelledby="heading-collapsed">
            <div class="card-body">
                <jdoc:include type="modules" name="searchBar" />
            </div>
        </div>
    </div>
</div>
<main id="content" role="main" style="padding:0 15px 150px 15px;">
    <?php if ($this->countModules('slider') && $this->countModules('position-12')) : ?>
        <div class="container reset-container">
            <div class="row">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8" style="padding-right:0;">
                            <div class="col-md-12" style="padding-left:0; padding-right:0; ">
                                <div class="slider-widget drop-shadow">
                                    <jdoc:include type="modules" name="slider" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <jdoc:include type="modules" name="home-prod1" />
                                </div>
                                <div class="col-md-6">
                                    <jdoc:include type="modules" name="home-prod2" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <jdoc:include type="modules" name="position-12" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <div class="container reset-container">
		<br>
		<jdoc:include type="message" />
        <jdoc:include type="component" />
    </div>
    <jdoc:include type="modules" name="position-8" />
</main>
<footer id="customFOO">
    <div style="border-bottom:1px solid rgba(119,119,119,0.25); width:100%; height:30px;"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 custom-border" style="text-align:start">
                <h5 style="margin-left:15%"><?php echo JText::_('NOVOSCANAIS_STORE'); ?></h5>
                <ul>
                    <li>
                        <a href="index.php/<?= $PVmUrl ?>/search?Genero=MASCULINO">
                            <i class="fa fa-male" aria-hidden="true"></i>
                            <?php echo JText::_('NOVOSCANAIS_MAN'); ?>
                        </a>
                    </li>
                    <li>
                        <a href="index.php/<?= $PVmUrl ?>/search?Genero=FEMININO">
                            <i class="fa fa-female" aria-hidden="true">
                            </i>
                            <?php echo JText::_('NOVOSCANAIS_WOMAN'); ?>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fa fa-users" aria-hidden="true">
                            </i>
                            <?php echo JText::_('NOVOSCANAIS_COLECTIONS'); ?>
                        </a>
                    </li>
                    <li>
                        <a href="http://fullwear.pt/fw2016/" target="_blank">
                            <i class="fa fa-scissors" aria-hidden="true">
                            </i>
                            <?php echo JText::_('NOVOSCANAIS_CUSTOM'); ?>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-md-4 custom-border" style="text-align:start">
                <h5 style="margin-left:15%">  <?php echo JText::_('NOVOSCANAIS_ABOUT'); ?></h5>
                <ul>
                    <li>
                        <a href="#">
                            <i class="fa fa-file" aria-hidden="true"></i>
                            <?php echo JText::_('NOVOCANAIS_TOS'); ?>
                        </a>
                    </li>
                    <li>
                        <a href="http://fullwear.pt/fw2016/portfolio/maquetas/" target="">
                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                            <?php echo JText::_('NOVOSCANAIS_MODELS'); ?>
                        </a>
                    </li>
                    <li>
                        <a href="http://fullwear.pt/fw2016/comunidade/" target="_blank">
                            <i class="fa fa-comments" aria-hidden="true"></i>
                            <?php echo JText::_('NOVOSCANAIS_COMUNITY'); ?>
                        </a>
                    </li>
                    <li>
                        <a href="http://fullwear.pt/fw2016/portfolio/testemunhos/" target="_blank">
                            <i class="fa fa-exchange" aria-hidden="true"></i>
                            <?php echo JText::_('NOVOSCANAIS_TESTIMONIALS'); ?>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-sm-4" style="text-align:start">
                <h5 style="margin-left:15%">
                    <?php echo JText::_('NOVOSCANAIS_CONTACT'); ?>
                </h5>
                <ul>
                    <li>
                        <a href="https://www.facebook.com/FULLWEAR/" target="_blank">
                            <i class="fa fa-facebook" aria-hidden="true"></i>
                            facebook.com/fullwear
                        </a>
                    </li>
                    <li>
                        <a href="https://www.youtube.com/channel/UCo7KiFPFlGmRWVkxm2PcGkA" target="_blank">
                            <i class="fa fa-youtube" aria-hidden="true"></i>
                            youtube.com/fullwear
                        </a>
                    </li>
                    <li>
                        <a href="mailto:geral@fullwear.pt" target="_top">
                            <i class="fa fa-envelope-o" aria-hidden="true"></i>
                            geral@fullwear.pt</a>
                    </li>
                    <li>
                        <a href="tel:+351256305309">
                            <i class="fa fa-phone" aria-hidden="true"></i>
                            +351 256 305 309
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Google Embed MAPS API -->
        <iframe id="map-container" frameborder="0" style="border:0"
                src="https://www.google.com/maps/embed?pb=!1m22!1m11!1m3!1d906.305544829084!2d-8.56218811893967!3d40.96108673750441!2m2!1f0!2f0!3m2!1i1024!2i768!4f13.1!4m8!3e6!4m0!4m5!1s0xd2380a86c8c1f0d%3A0x4d4d60f6c3e28a15!2sfullwear!3m2!1d40.961341999999995!2d-8.562078999999999!5e1!3m2!1spt-PT!2spt!4v1510762236309" >
        </iframe>
    </div>
    <div class="social-networks">
    </div>
    <div class="footer-copyright" style="border-top:1px solid rgba(119,119,119,0.25);">
        <p>© 2017 Copyright FULLWEAR.PT </p>
    </div>
</footer>
<script type="text/javascript" src="<?php echo $this->baseurl; ?>/customJS/customJS.js"></script>
<script>
    //accordion animation --> filters menu
    var acc = document.getElementsByClassName("accordion");
    var i;
    for (i = 0; i < acc.length; i++) {
        acc[i].onclick = function () {
            this.classList.toggle("active");
            var panel = this.nextElementSibling;
            if (panel.style.maxHeight) {
                panel.style.maxHeight = null;
            } else {
                panel.style.maxHeight = panel.scrollHeight + "px";
            }
        }
    }
    //change image according to screen size
    jQuery(function () {
        if (jQuery(window).width() < 768) {
            jQuery('.img-change').attr('src', '<?php echo JURI::ROOT(); ?>/templates/fwshop/images/logo_fw_small.png');
        }
        if (jQuery(window).width() > 768) {
            jQuery('.img-change').attr('src', '<?php echo JURI::ROOT(); ?>/templates/fwshop/images/logo_fw.png');
        }
    });
</script>
<a href="javascript:" id="return-to-top"><i class="fa fa-arrow-up" aria-hidden="true"></i></a>
</body>
</html>
