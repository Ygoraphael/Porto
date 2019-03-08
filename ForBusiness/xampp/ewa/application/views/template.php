<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<?php $this->load->view('header'); ?>
<body>
    <!-- Fixed navbar -->


    <div class="mainmenu">

    </div>
    <?php $this->position->RenderPosition('menu-topo'); ?>
    <style>
        .mainmenu .navbar-brand {
            height: 80px;
        }

        .mainmenu .nav >li >a {
            padding-top: 30px;
            padding-bottom: 30px;
        }
        .mainmenu .navbar-toggle {
            padding: 10px;
            margin: 25px 15px 25px 0;
        }
    </style>



    <?php if ($frontpage == "true") { ?>
        <!-- *****************************************************************************************************************
                HEADERWRAP
                ***************************************************************************************************************** -->
        <div id="headerwrap">
            <div class="container homepage-cover page-cover entry-cover has-image">
                <iframe style="min-width: 100%; min-height: 120%;"  class="fillWidth fadeIn animated" id="video-background" src="https://www.youtube.com/embed/SFKi02CgrvA?rel=0&&autoplay=1&playlist=SFKi02CgrvA&controls=0&showinfo=0&loop=1" frameborder="0"  allowfullscreen></iframe>
                <div class="row search-row">
                    <div class="col-lg-8 col-lg-offset-2">

                        <h2 class="home-widget-title"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Search the best things to do'); ?></h2>
                        <h3 class="home-widget-description"><?php $t = "We help you find out what's happening in your destination";
    echo $this->googletranslate->translate($_SESSION["language_code"], $t); ?></h3>
                        <div class="custom-search-input col-md-8 col-md-offset-2">
                            <div class="input-group col-md-12">
                                <input data-provide="typeahead" type="text" class="form-control input-lg" id="main-search" placeholder="<?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Search for destinations or things to do'); ?>" />
                                <span class="input-group-btn">
                                    <button class="btn btn-lg" type="button" onclick="search_products();">
                                        <i class="glyphicon glyphicon-search"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /row -->
            </div>
            <!-- /container -->
        </div>
        <script type="text/javascript">
            jQuery('#main-search').bootcomplete({
                method: 'post',
                url: 'search/',
                minLength: 3
            });

            function search_products() {
                search_value = jQuery("#main-search").val().toString().trim();
                if (search_value.length > 0) {
                    window.location.href = 'listing?s=' + search_value;
                } else {
                    window.location.href = 'listing';
                }
            }
        </script>
        <!-- /headerwrap -->		
    <?php } ?>
    <!-- *****************************************************************************************************************
            MIDDLE CONTENT
            ***************************************************************************************************************** -->
    <div class="content clearfix">
        <div id="service">
            <?php //$this->position->RenderPosition('nc:content'); ?>
            <?php
            // This is the main content partial
            echo $this->template->content;
            $this->position->RenderPosition('position-1');
            ?>

        </div>
    </div>
    <div id="black_wrap">
        <div class="container">
            <div class="row centered">
                <h1 class="aso-title"><?php $t = "there is no better way to find what's happening around world";
            echo $this->googletranslate->translate($_SESSION["language_code"], $t); ?> </h1>
                <p>
                    <img src="http://europeanworld.eu/wp-content/uploads/2016/10/EWA_c_WORLDWIDE.png" scale="0">
                </p>
            </div>
        </div>
    </div>
    <div id="white_wrap">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-8 col-lg-9">
                    <h1 class="cta-title"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Become a supplier'); ?></h1>
                    <div class="cta-description">
                        <p><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Increase your sales by distributing your products to millions monthly travel planners on EUROPEANWORLD.EU, over thousand travel agents'); ?></p>
                    </div>
                </div>
                <div class="cta-button-wrapper col-sm-12 col-md-4 col-lg-3">
                    <button type="button" class="btn btn-danger cta-button"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Inform what you do'); ?></button>
                    <p><small class="cta-subtext"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'shortly we will help you to increase your success'); ?></small></p>
                </div>
            </div>
        </div>
    </div>
    <!-- *****************************************************************************************************************
            FOOTER
            ***************************************************************************************************************** -->
    <div id="footerwrap">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-sm-12 footerwrap-mod">
                    <p><img src="https://www.soft4booking.com/images2/soft4booking_logo_footer.png" alt="SOFT4BOOKING" style="width:231px;height:62px;" scale="0"></p>
                    <p style="color:white"> <?php echo $this->googletranslate->translate($_SESSION["language_code"], 'At SOFT4BOOKING our purpose is to help people find great locals like tours, restaurants, spas, etc... Go Explore!'); ?></p>
                </div>
                <div class="col-lg-3 col-sm-12 footerwrap-mod">
                    <p> <?php $this->position->RenderPosition('menu-baixo1'); ?></p>
                </div>
                <div class="col-lg-3 col-sm-12 footerwrap-mod">
                    <p>
                    <h4><a href="http://www.europeanworld.org">EWA\ European World Alliance</a></h4>
                    <h4><a href="#"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Your Tour is already with us?'); ?></a></h4>
                    <h4><a href="#"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'BEST PRICE GUARANTEED'); ?></a></h4>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <footer id="colophon" class="site-footer" role="contentinfo">
        <div class="container">
            <div class="site-info"><?php echo $this->googletranslate->translate($_SESSION["language_code"], 'Copyright SOFT4BOOKING © 2017. All rights reserved and registered trademark of Global Fragments, Lda'); ?></div>
            <div class="site-social">
                <div class="menu-social-widget-menu-container">
                    <a href="https://www.facebook.com/ewa.europeanworld/"><i class="fa fa-facebook"></i></a>
                    <a href="https://www.linkedin.com/company/10387269?trk=tyah&amp;trkInfo=clickedVertical%3Acompany%2CclickedEntityId%3A10387269%2Cidx%3A1-1-1%2CtarId%3A1457044052939%2Ctas%3Aeuropeanworld"><i class="fa fa-linkedin-square"></i></a>
                    <a href="http://https://plus.google.com/108060639646521876119/posts"><i class="fa fa-google-plus"></i></a>
                    <a href="https://twitter.com/EUROPEANWORLDEU"><i class="fa fa-twitter"></i></a>
                    <a href="https://www.youtube.com/channel/UCASBE_8158454-Sn_MKOHWA"><i class="fa fa-youtube-play"></i></a>
                    <a href="http://www.instagram.com/europeanworld.eu/"><i class="fa fa-instagram"></i></a>
                </div>
            </div>
        </div>
    </footer>
</body>
<!-- Modal -->
<?php $this->load->view('footer'); ?>
<script>
    function set_language(lang, lang_code) {
        jQuery.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>/ajax/set_language",
            data: {
                "lang": lang,
                "lang_code": lang_code
            },
            success: function (data)
            {
                window.location.reload();
                console.log(data);
            }
        });
    }
</script>
<style>
    .language_drop li{
        margin:0;
        display:inline;
    }

    .language_drop li a{
        padding: 3px 20px 3px 8px;
    }
</style>
<script>
    function set_currency(type_currency, i, ch) {
        jQuery.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>/ajax/set_currency",
            data: {
                "type_currency": type_currency,
                "i": i,
                "ch": ch
            },
            success: function (data)
            {
                window.location.reload();
            }
        });
    }
</script>
<style>
    .currency_drop li{
        margin:0;
        display:inline;
    }

    .currency_drop li a{
        padding: 2px 138px 2px 19px;
    }
    .currency_drop ul a{
        padding: 2px 160px 2px 10px;
    }
</style>