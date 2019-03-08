<!DOCTYPE HTML>
<html>
    <?php $this->load->view("header.php"); ?> 
    <body>
        <!-- Menu para Trabalhador -->
        <div class="col-lg-offset-1 col-lg-10 main-page">
            <?php echo form_open('', 'class="cod_trabalhador" id="form_entrar"'); ?>
            <div class="col-lg-12 " style="margin-top:5%; ">
                <div class="stats-ponto4 ">
                    <h4><?= $trabalhador[0]["username"] ?></h4>
                    <hr>
                    <h2><?= lang('Has_an_open_task') ?></h2>
                    <h1><?= lang('Close_task_to_add_new') ?></h1>
                    <button onclick="window.parent.location.href = '<?= base_url(); ?>ponto/tarefas'" class="btn_cart  parent.$.fancybox.close();" style="margin-top:25px;" >
                       <i class="fa fa-check-square-o" style="font-size:46px;color:white"></i>
                    </button>
                </div>
                <div class="clearfix"></div>	
            </div>
        </div>
    </body>
</html>
<?php $this->load->view('footerscript'); ?>
