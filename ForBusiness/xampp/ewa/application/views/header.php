<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <?php
                //Meta Tags
                $url_metatags = $this->uri->segment(3);
                if ($url_metatags == "product") {
                    foreach ($this->template->getMetatags2($product[0]["bostamp"]) as $metatag):
                        echo $this->template->trigger_meta2("keywords", $metatag['u_metatags']);
                    endforeach;
                }
            ?>	
        <?php
        foreach ($this->template->getMetatags() as $metatag):
            echo $this->template->trigger_meta($metatag['name'], $metatag['content']);
        endforeach;
        ?>
        <link rel="shortcut icon" href="<?php echo base_url(); ?>favicon.ico">
        <link rel="icon" type="image/png" sizes="32x32" href="<?php echo base_url(); ?>favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url(); ?>favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url(); ?>favicon-16x16.png">
        <title><?php echo $this->template->title->default("EuropeanWorld – Your Travel Advisor"); ?></title>
        <!-- Bootstrap core CSS -->
        <link href="<?php echo base_url(); ?>css/bootstrap.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>css/font-awesome.min.css" rel="stylesheet">
        <!-- Custom styles for this template -->
        <link href="<?php echo base_url(); ?>css/bootstrap-formhelpers.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>css/bootstrap-datepicker3.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>css/bootstrap-datepicker3.standalone.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.css"/>
        <link href="<?php echo base_url(); ?>css/slick-theme.css" rel="stylesheet">
        <link type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/4.0.1/ekko-lightbox.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>css/bootcomplete.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>css/bic_calendar.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>css/style.css" rel="stylesheet">
        <!--[if lt IE 9]><script src="../../js/ie8-responsive-file-warning.js"></script><![endif]-->
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <?php echo $this->template->stylesheet; ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>js/bootstrap-datepicker.min.js"></script>
        <script type="text/javascript" src="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/4.0.1/ekko-lightbox.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.bootcomplete.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/bic_calendar.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-scrollTo/2.1.0/jquery.scrollTo.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>
    </head>