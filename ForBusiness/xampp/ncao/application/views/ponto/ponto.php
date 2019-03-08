
<!DOCTYPE HTML>
<html>
    <?php $this->load->view("header.php"); ?> 
    <body>
        <div class="col-lg-offset-1 main-content" >
            <div >
                <a href="#">
                    <h1><?php echo $this->config->item("nc_name"); ?></h1>
                </a>
            </div>	
        </div>	
        <!-- Menu para Trabalhador -->
        <div class="main-content">
            <div id="page-wrapper">
                <div class="col-lg-offset-1 col-lg-10 main-page">
                    <div class="col-lg-6 " style="margin-top:5%; ">
                        <a href="<?php echo base_url() ?>ponto/entrada">
                            <div class="stats-ponto ">
                                <h4><?php echo $la = lang('ponto_in'); ?></h4>
                            </div>
                        </a>	
                        <div class="clearfix"></div>	
                    </div>
                    <div class="col-lg-6 states-lg" style="margin-top:5%">
                        <a href="<?php echo base_url() ?>ponto/saida">
                            <div class="stats-ponto">
                                <h4><?php echo $la = lang('ponto_out'); ?></h4>
                            </div>
                        </a>	
                        <div class="clearfix"></div>	
                    </div>
                    <div class="col-lg-6" style="margin-top:5% ">
						<a href="<?php echo base_url().$_SESSION['tarefa'] ?>">
							<div class="stats-ponto ">
								<h4><?php echo $la = lang('start_task'); ?></h4>
							</div>
						</a>							
                    </div>
                    <div class="col-lg-6 states-lg" style="margin-top:5%">
						<a href="<?php echo base_url() ?>ponto/familias">
							<div class="stats-ponto">
								<h4><?php echo $la = lang('close_task'); ?></h4>
							</div>
						</a>	
                    </div> 
                </div>
            </div>	
            <?php $this->load->view('ponto/footer'); ?>
        </div>	
    </body>
</html>