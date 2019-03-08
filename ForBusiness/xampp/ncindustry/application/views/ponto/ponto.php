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
                <div class="col-lg-offset-1 col-lg-10 main-page">
                    <div class="col-lg-6 " style="margin-top:5%; ">
                        <a href="<?= base_url() ?>ponto/entrada">
                            <div class="stats-ponto ">
                                <h4><?= lang('ponto_in'); ?></h4>
                            </div>
                        </a>	
                        <div class="clearfix"></div>	
                    </div>
                    <div class="col-lg-6 states-lg" style="margin-top:5%">
                        <a href="<?= base_url() ?>ponto/saida">
                            <div class="stats-ponto">
                                <h4><?= lang('ponto_out'); ?></h4>
                            </div>
                        </a>	
                        <div class="clearfix"></div>	
                    </div>
                    <div class="col-lg-6" style="margin-top:5% ">
                        <a href="<?= base_url() . $inittarefa ?>">
                            <div class="stats-ponto ">
                                <h4><?= lang('start_task'); ?></h4>
                            </div>
                        </a>							
                    </div>
                    <div class="col-lg-6 states-lg" style="margin-top:5%">
                        <a href="<?= base_url() . $endtarefa ?>">
                            <div class="stats-ponto">
                                <h4><?= lang('close_task'); ?></h4>
                            </div>
                        </a>	
                    </div> 
                </div>
            </div>	
            <?php $this->load->view('ponto/footer'); ?>
        </div>	
    </body>
</html>
<?php $this->load->view('footerscript'); ?>