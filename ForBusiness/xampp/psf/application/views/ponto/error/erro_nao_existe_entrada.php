<!DOCTYPE HTML>
<html>
    <?php $this->load->view("header.php"); ?> 	
    <body>
        <div class="col-lg-offset-1 main-content" >
            <div>
                <a href="<?= base_url() ?>ponto">
                    <h1><?= $this->config->item("nc_name"); ?></h1>
                </a>
            </div>
        </div>	
        <!-- Menu para Trabalhador -->
        <div class="main-content">
            <div id="page-wrapper" style="min-height:87vh">
                <div class="col-lg-10 col-lg-offset-1 main-page">
                    <div class="col-lg-12 " style="margin-top:5%; ">
                        <div class="stats-ponto2 ">
                            <h4><?= lang('There_is_no_entrance'); ?></h4>
                            <h1><?= $trabalhador[0]["username"]; ?></h1>
                        </div>
                        <div class="clearfix"></div>	
                    </div>
                </div>
            </div>	
            <?php $this->load->view('ponto/footer'); ?>
        </div>	
    </body>
</html>
<style>
    input {
        font-size: 2em;
        color: #fff;
        margin-top: 5px;
    }
</style>
<?php $this->load->view('footerscript'); ?>