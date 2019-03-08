<!--Cronômetro, após três segundos faze um redirecionamento a http://localhost/dev/ncindustry/ponto-->
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
		<div class="col-lg-offset-1 col-lg-10 main-page">
			<?php echo form_open('', 'class="cod_trabalhador" id="form_entrar"'); ?>
			<div class="col-lg-12 " style="margin-top:5%; ">
				<div class="stats-ponto4 ">
					<h4><?php echo $la = lang('You_must_start_a_task'); ?></h4>
					<h1><?php echo $nome; ?></h1>
					<h4><?php echo $la = lang('Add_a_task_to_continue'); ?></h4>
					<button onclick="window.parent.location.href = '<?php echo base_url(); ?>ponto/tarefa'" class="btn_cart  parent.$.fancybox.close();" style="margin-top:25px;" ><p style="font-size:1.5em; color:white;"><?php echo $la = lang('start_task'); ?></p></button>
				</div>
				<div class="clearfix"></div>	
			</div>
		</div>
    </body>
</html>

