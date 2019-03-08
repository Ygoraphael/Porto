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
            <div id="page-wrapper" style="padding: 1.5em 0.5em 2.5em;">
					<div class="col-lg-10 text-left">
				<h1 style="padding: 0.5em 0.5em 1em;">Escolhe a tarefa para começar</h1>
				</div>
				<div class="col-lg-2 btn-red " style="padding: 0.5em 2em 0.2em;">
					<input type="button"  onclick="window.location.href = '<?php echo base_url(); ?>ponto'" class="btn_cart3" value="<?php echo $la = lang('Go_back'); ?>">
					<div class="clearfix"></div>	
				</div>
                <div class="col-lg-12">
                    <?php 
					foreach ($campos as $campo): ?>
                        <div class="col-lg-3 box_hover" style="margin-bottom:25px;">
                            <a href="<?php echo base_url(); ?>ponto/registo_tarefasDytable/<?php echo $campo["dytablestamp"]; ?>" class=" fancybox fancybox.iframe" data-toggle="modal" data-target="#popup" >
                                <div class="bopper">
                                        <p><?php echo $campo["campo"]; ?></p>
                                 </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
				<div class="clearfix"></div>
            </div>
	<?php $this->load->view('ponto/footer'); ?>
        </div>	
    </body>
	
	<script type="text/javascript">
		$(document).ready(function() {
			$('.fancybox').fancybox({
			    afterClose : function() {
					window.parent.location.reload();
					window.parent.$.fancybox.close();
				return;
				}	
			});
		});
	</script>
</html>

<?php $this->load->view('footerscript'); ?>
