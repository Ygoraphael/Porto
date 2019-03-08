
<!DOCTYPE HTML>
<html>
    <?php $this->load->view("header.php"); ?> 
    <!--Logo PSF-->	
    <body>
        <!--Dadod Trabalhador-->
        <?php
        $resp = $trabalhador;
        $nome = $resp[0]["username"];
        ?>
        <!-- Menu para Trabalhador -->
        <div class="main-content">
            <div style="margin:0px;">
				<div class="col-lg-12 " >
					<div class="stats-ponto2 ">
						<h4><?php echo $la = lang('Started_a_new_task'); ?></h4>
						<h1><?php echo $nome; ?></h1>
						<h4><?php echo $la = lang('Good_job'); ?></h4>
					</div>	
				</div>
            </div>
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