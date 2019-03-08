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
						<h4><?php echo $la = lang('Can_not_start_a_task'); ?></h4>
						<h4><?php echo $nome; ?></h4>
						<h4><?php echo $la = lang('There_is_no_entrance'); ?></h4>
                    </div>
                </div>
            </div>	
        </div>	
    </body>
</html>

