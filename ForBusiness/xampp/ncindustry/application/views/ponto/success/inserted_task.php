<!DOCTYPE HTML>
<html>
    <?php $this->load->view("header.php"); ?>
    <body>
        <div class="col-lg-offset-1 col-lg-10 main-page">
            <div class="col-lg-12 " >
                <?php foreach ($trabalhador as $nam): ?>
                    <div class="stats-ponto4 ">
                        <h4><?=$nam['username']; ?></h4>
                        <hr>
                        <h4><?= lang('Completed_tasks_have_been_added'); ?></h4>
                        <button onclick="window.parent.location.href = '<?= base_url(); ?>ponto'" class="btn_cart parent.$.fancybox.close();" style="margin-top:25px;" ><i class="fa fa-check-square-o" style="font-size:46px;color:white;"></i></button>
                        <div class="clearfix"></div>
                    </div>
                <?php endforeach; ?>
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
