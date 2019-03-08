<!--Cronômetro, após três segundos faze um redirecionamento a http://localhost/dev/ncindustry/ponto-->
<!DOCTYPE HTML>
<html>
    <?php $this->load->view("header.php"); ?> 	
    <body>
        <div class="col-lg-offset-1 main-content" >
            <div >
                <a href="#">
                    <h1><?php echo $this->config->item("nc_name"); ?></h1>
                </a>
            </div>	
        </div>	
        <!--Dadod Trabalhador-->
        <?php
        $resp = $trabalhador;
        $nome = $resp[0]["username"];
        ?>

        <!-- Menu para Trabalhador -->
        <div class="main-content">
            <div id="page-wrapper">
                <div class="col-lg-offset-1 col-lg-10 main-page">
                    <?php echo form_open('', 'class="cod_trabalhador" id="form_entrar"'); ?>
                    <div class="col-lg-12 " style="margin-top:5%; ">
                        <div class="stats-ponto2 ">
                            <h4><?php echo $la = lang('Welcome'); ?></h4>
                            <h1><?php echo $nome; ?></h1>
                            <h4><?php echo $la = lang('Good_job'); ?></h4>
                        </div>
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
