<!DOCTYPE HTML>
<html>
    <?php $this->load->view("header.php"); 
    ?> 
    <body>
        <div class="col-lg-offset-1 col-lg-10 main-page">
            <div class="col-lg-12 " >
                <div class="pop-up_error " style="height=auto; width:100%;" >
                    <i class="fa fa-exclamation-triangle" style="font-size:75px;color:#D0333D"></i>
                    <hr>
                    <h2><?= lang('You_have_not_added_any_tasks'); ?></h2>
                    <h2><?php echo lang('Add_a_task_to_continue'); ?></h2>
                    <button onclick="window.parent.location.href = '<?= base_url(); ?>ponto/tarefas'" class="btn_cart  parent.$.fancybox.close();" style="margin-top:25px;" >
                        <i class="fa fa-check-square-o" style="font-size:46px;color:white"></i>
                    </button>
                </div>
                <div class="clearfix"></div>	
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