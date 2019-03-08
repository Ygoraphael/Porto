<!DOCTYPE HTML>
<html>
    <?php $this->load->view("header.php"); ?> 
    <!--Logo PSF-->	
    <body>
		<div class="col-lg-offset-1 col-lg-10 main-page">
			<div class="col-lg-12 " >
					<?php echo form_open('', 'class="cod_trabalhador" id="form_entrar"'); ?>
					<div class="stats-ponto4 ">
					<h4><?php echo $la = lang('Code_Card'); ?></h4>
						<div class="col-lg-9 " style="margin-top:5%">
							<input type="text" class="text-muted" name="cod_trabalhador" placeholder="<?php echo $la = lang('Code_Worker'); ?>" required="" style="width:100%; height:auto;">	
							<button type="submit" class="btn_cart" style="margin-top:5%" ><i class="fa fa-check-square-o" style="font-size:46px;color:white;"></i></button>	
						</div>
						<?php form_close(); ?> 
					</div>
				<?php  form_close();?>
			</div>
		</div>
	</body>	
</html>
<style>

    input {
        font-size: 1.5em;
    }
</style>
<script>
    $(function () {
        $("[name='cod_trabalhador']").focus();
        $(window).keypress(function (e) {
            var key = e.which;

            if (key == 13) {
                jQuery("#form_entrar").submit();
            } else {
                tmp = jQuery("[name='cod_trabalhador']").val();
                jQuery("[name='cod_trabalhador']").val(tmp + String.fromCharCode(key));
            }
        });
    });
</script>