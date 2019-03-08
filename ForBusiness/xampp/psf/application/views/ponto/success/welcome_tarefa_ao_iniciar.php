<!DOCTYPE HTML>
<html>
    <?php $this->load->view("header.php"); 
        $nome = $trabalhador[0]["username"];
    ?> 
    <body>
        <!-- Menu para Trabalhador -->
        <div class="col-lg-offset-1 col-lg-10 main-page">
            <?php echo form_open('', 'class="cod_trabalhador" id="form_entrar"'); ?>
            <div class="col-lg-12 " style="margin-top:5%; ">
                <div class="stats-ponto4 ">  
                    <h4><?php echo $nome; ?></h4>
                    <hr>
                    <h1><?php echo $la = lang('Started_a_new_task'); ?></h1>
                    <h4><?php echo $la = lang('Good_job'); ?></h4>
                    <button onclick="window.parent.location.href = '<?= base_url(); ?>ponto'" class="btn_cart  parent.$.fancybox.close();" style="margin-top:25px;" >
                       <i class="fa fa-check-square-o" style="font-size:46px;color:white"></i>
                    </button>
                </div>
                <div class="clearfix"></div>	
            </div>
        </div>
    </body>
</html>
<?php $this->load->view('footerscript'); ?>