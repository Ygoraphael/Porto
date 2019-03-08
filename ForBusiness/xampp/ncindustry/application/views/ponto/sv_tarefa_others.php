
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
		<?php foreach ($name as $nam): ?>
        <!-- Menu para Trabalhador -->
        <div class="main-content">
			<div id="page-wrapper">
				<div class="col-lg-offset-1 col-lg-10 main-page" >
					<div class="stats-ponto2 ">
						<h1><?php echo $nam['username']; ?></h1>
						<br>
						<h4><?php echo $la = lang('Completed_tasks_have_been_added'); ?></h4>
					</div>	
				</div>
			</div>
			<?php $this->load->view('ponto/footer'); ?>
        </div>	
		<?php  endforeach; ?>
    </body>
</html>
<style>

    input {
        font-size: 2em;
        color: #fff;
        margin-top: 5px;
    }
</style>
