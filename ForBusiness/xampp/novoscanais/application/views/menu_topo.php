<header id="header">
    <?php if ($this->uri->uri_string() == ''): ?>
        <nav class="navbar navbar-inverse" id='menu' role="banner">
            <div class="container sub_Menu_Mobile">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand hdg" style="vertical-align: baseline;" href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>images/logo/Logotipo_NovosCanais.png" width="250" height="76" alt="logo"></a>
                    <a class="navbar-brand hdg2" style="vertical-align: baseline;" href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>images/logo/Logotipo_NovosCanais_Parcial.png" width="100" height="50" alt="logo"></a>
                    <a class="navbar-brand hdg3" style="vertical-align: baseline;" href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>images/logo/Logotipo_NovosCanais_Parcial.png" width="100" height="50" alt="logo"></a>
                </div>
                <div class="collapse navbar-collapse navbar-right">
                    <ul class="nav navbar-nav brackets-effect">
                        <li><a href="<?php echo base_url(); ?>" id="home">Home</a></li>
                      <!--  <li><a href="<?php echo base_url(); ?>empresa" >Empresa</a></li> -->
                        <li class="dropdown">
                            <a id="bserviço" class="dropdown-toggle" data-toggle="dropdown">Soluções <i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?= base_url(); ?>phc">PHC CS</a></li>
                                <li><a href="<?= base_url(); ?>phc/oficinas">PHC OFICINAS</a></li>
                                <li><a href="<?= base_url(); ?>phc/ouro">PHC OURO</a></li>
                                <li><a href="<?= base_url(); ?>drivefx">DRIVE FX</a></li>
                                <li><a href="<?= base_url(); ?>office365">OFFICE 365</a></li>
                                <li><a href="<?= base_url(); ?>web">WEB APP</a></li>
                            </ul>
                        </li>
                        <li><a href="<?php echo base_url(); ?>contactos">Contactos</a></li>
                        <li><a href="tel:+351 220 136 600"><i class="fa fa-phone-square"></i> +351 220 136 600</a></li>
                        <li><a href="<?php echo base_url(); ?>contactos"><i class="fa fa-phone-square"></i> ACESSO REMOTO</a></li>
                    </ul>
                </div>
            </div><!--/.container-->
        </nav><!--/nav-->
    <?php endif; ?>
    <?php if ($this->uri->uri_string() != ''): ?>
        <nav class="navbar navbar-inverse fussion" role="banner">
            <div class="container sub_Menu_Mobile">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand hdg" style="vertical-align: baseline;" href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>images/logo/Logotipo_NovosCanais.png" width="250" height="76" alt="logo"></a>
                    <a class="navbar-brand hdg2" style="vertical-align: baseline;" href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>images/logo/Logotipo_NovosCanais_Parcial.png" width="100" height="50" alt="logo"></a>
                    <a class="navbar-brand hdg3" style="vertical-align: baseline;" href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>images/logo/Logotipo_NovosCanais_Parcial.png" width="100" height="50" alt="logo"></a>
                </div>
                <div class="collapse navbar-collapse navbar-right">
                    <ul class="nav navbar-nav brackets-effect">
                        <li><a href="<?php echo base_url(); ?>">Home</a></li>
                        <!-- <li><a href="<?= base_url(); ?>empresa">Empresa</a></li> -->
                        <li class="dropdown">
                            <a id="bserviço" class="dropdown-toggle" data-toggle="dropdown">Soluções <i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?= base_url(); ?>phc">PHC CS</a></li>
                                <li><a href="<?= base_url(); ?>phc/oficinas">PHC OFICINAS</a></li>
                                <li><a href="<?= base_url(); ?>phc/ouro">PHC OURO</a></li>
                                <li><a href="<?= base_url(); ?>drivefx">DRIVE FX</a></li>
                                <li><a href="<?= base_url(); ?>office365">OFFICE 365</a></li>
                                <li><a href="<?= base_url(); ?>web">WEB APP</a></li>
                            </ul>
                        </li>
                        <li><a href="<?php echo base_url(); ?>contactos">Contactos</a></li>
                        <li><a href="tel:+351 220 136 600"><i class="fa fa-phone-square"></i> +351 220 136 600</a></li>
                        <li><a href="<?php echo base_url(); ?>contactos"><i class="fa fa-phone-square"></i> ACESSO REMOTO</a></li>
                    </ul>
                </div>
            </div><!--/.container-->
        </nav><!--/nav-->
    <?php endif; ?>
</header><!--/header-->
