<!DOCTYPE HTML>
<html>
    <?php $this->load->view("header.php"); ?> 
    <!--Logo PSF-->	
    <body>
	    <div class="col-lg-offset-1 main-content" >
            <div >
                <a href="#">
                    <h1><?php echo $this->config->item("nc_name"); ?></h1>
                </a>
            </div>	
        </div>	
        <!--Dadod Trabalhador-->
        <?php
        $resp = $trabalhador;
        $nome = $resp[0]["username"];
        ?>
        <!-- Menu para Trabalhador -->
        <div class="main-content">
            <div id="page-wrapper">
				<div class="col-lg-12 " >
					<div class="stats-ponto2 ">
						<h3><?php echo $la = lang('Can_not_close_a_task'); ?></h3>
						<h3><?php echo $nome; ?></h3>
						<h3><?php echo $la = lang('There_is_no_entrance'); ?></h3>
                    </div>
                </div>
            </div>
        </div>	
            <?php $this->load->view('ponto/footer'); ?>
    </body>
</html>