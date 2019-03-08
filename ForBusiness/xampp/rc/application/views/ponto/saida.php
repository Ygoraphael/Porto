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
        <!-- Menu para Trabalhador -->
        <div class="main-content">
            <div id="page-wrapper">
                <div class="col-lg-offset-1 col-lg-10 main-page">
                    <div class="col-lg-3 " style="margin-top:5%; ">
                        <div class="stats-ponto ">
                            <h4><?php echo $la = lang('Code_Card'); ?></h4>
                        </div>
                        <div class="clearfix"></div>	
                    </div>
                    <div class="col-lg-9 " style="margin-top:5%">
                        <div class="stats-ponto ">
                            <?php echo form_open('', 'class="cod_trabalhador" id="form_entrar"'); ?>
                            <input type="text" class="text-muted" name="cod_trabalhador" placeholder="<?php echo $la = lang('Code_Worker'); ?>" required="" style="width:80%; height:100px;">
                       	</div>
                        <div class="clearfix"></div>	
                    </div>
                    <div class="col-lg-6 states-lg " style="margin-top:5% ">
                        <input type="button"  onclick="history.back()" class="stats-ponto" value="<?php echo $la = lang('Go_back'); ?>">
                        <div class="clearfix"></div>	
                    </div>
                    <div class="col-lg-6 states-lg " style="margin-top:5%">
                        <input type="submit" class="stats-ponto" value="<?php echo $la = lang('Exit'); ?>">	
                        <?php form_close(); ?> 
                        <div class="clearfix"></div>	
                    </div> 
                </div>
            </div>	
            <?php $this->load->view('ponto/footer'); ?>
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