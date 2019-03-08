<!DOCTYPE HTML>
<html>
    <?php $this->load->view("header.php"); ?> 
    
    <?php 
    
        $keypad=$u_ncidef['keypad'];
    
    ?>
    
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
            <div id="page-wrapper" <?php if($keypad==0){echo 'style="padding-top:15%; min-height:87vh"';}else{echo 'style="padding-top:3%;min-height:87vh !important"';}?> >
                <div class="col-lg-offset-1 col-lg-10 main-page">
                    <div class="col-xs-3">
                        <div class="cabecalhos_ecra_cod">
                            <h4><?= lang('Code_Card'); ?></h4>
                        </div>
                        <div class="clearfix"></div>	
                    </div>
                    <div class="col-xs-9">
                        <div class="cabecalhos_ecra_cod">
                            <?php echo form_open('', 'class="cod_trabalhador" id="form_entrar"'); ?>
                            <input id="checker" type="text" class="text-muted" name="cod_trabalhador" placeholder="<?= lang('Code_Worker'); ?>" required="" <?php if($keypad==1){echo "readonly";} ?> style="width:80%; height:9vh !important;">
                       	</div>
                        <div class="clearfix"></div>	
                    </div>
                    
                    <?php if($keypad==1){?>
                    
                    <div class="col-xs-12">
                        <div class="col-xs-4" style="margin-top:3%; padding-right:0px; padding-left:0px">
                            <input type="button"  onclick="addNumberInput($(this).val())" class="keypad-teclas keypad" value="1">
                            <div class="clearfix"></div>	
                        </div>
                        <div class="col-xs-4" style="margin-top:3%; padding-right:0px; padding-left:0px">
                            <input type="button"  onclick="addNumberInput($(this).val())" class="keypad-teclas keypad" value="2">
                            <div class="clearfix"></div>	
                        </div>
                        <div class="col-xs-4" style="margin-top:3%; padding-right:0px; padding-left:0px">
                            <input type="button"  onclick="addNumberInput($(this).val())" class="keypad-teclas keypad" value="3">
                            <div class="clearfix"></div>	
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="col-xs-4" style="padding-right:0px; padding-left:0px">
                            <input type="button"  onclick="addNumberInput($(this).val())" class="keypad-teclas keypad" value="4">
                            <div class="clearfix"></div>	
                        </div>
                        <div class="col-xs-4" style="padding-right:0px; padding-left:0px">
                            <input type="button"  onclick="addNumberInput($(this).val())" class="keypad-teclas keypad" value="5">
                            <div class="clearfix"></div>	
                        </div>
                        <div class="col-xs-4" style="padding-right:0px; padding-left:0px">
                            <input type="button"  onclick="addNumberInput($(this).val())" class="keypad-teclas keypad" value="6">
                            <div class="clearfix"></div>	
                        </div>
                    </div>
                    
                    <div class="col-xs-12">
                        <div class="col-xs-4" style="padding-right:0px; padding-left:0px">
                            <input type="button" onclick="addNumberInput($(this).val())" class="keypad-teclas keypad" value="7">
                            <div class="clearfix"></div>	
                        </div>
                        <div class="col-xs-4" style="padding-right:0px; padding-left:0px">
                            <input type="button"  onclick="addNumberInput($(this).val())" class="keypad-teclas keypad" value="8">
                            <div class="clearfix"></div>	
                        </div>
                        <div class="col-xs-4" style="padding-right:0px; padding-left:0px">
                            <input type="button"  onclick="addNumberInput($(this).val())" class="keypad-teclas keypad" value="9">
                            <div class="clearfix"></div>	
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="col-xs-4" style="padding-right:0px; padding-left:0px">
                            <button type="button" onclick="$('#checker').val('')" class="keypad-teclas keypad"><i class="fa fa-trash" style="font-size:35px;color:white"></i></button>
                        </div>
                        <div class="col-xs-4" style="padding-right:0px; padding-left:0px">
                            <input type="button"  onclick="addNumberInput($(this).val())" class="keypad-teclas keypad" value="0">
                            <div class="clearfix"></div>	
                        </div>
                        <div class="col-xs-4" style="padding-right:0px; padding-left:0px">
                              <button type="button" onclick="removeNumberInput()" class="keypad-teclas keypad"><i class="fa fa-chevron-circle-left" style="font-size:35px;color:white"></i></button>
                            <div class="clearfix"></div>	
                        </div>
                    </div>
                   
                    <?php }?>
                    
                    <div class="col-xs-6 states-lg <?php if($keypad==1){echo "btnVoltarKeyPad"; }else{echo "btnVoltarCard";}?>">
                        <input type="button" style="background-color: #d9534f;" onclick="history.back()" class="botoes_ecra_cod" value="<?= lang('Go_back'); ?>">
                        <div class="clearfix"></div>	
                    </div>
                    <div class="col-xs-6 <?php if($keypad==1){echo "btnEntrarKeyPad";}else{echo "btnVoltarCard";}?>">
                        <input id="entrar" type="submit" class="botoes_ecra_cod" value="<?= lang('Go_In'); ?>">	
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

    input,button {
        height: 50%;
        font-size: 2em;
        color: #fff;
        margin-top: 5px;
    }
    
    .keypad{
        margin:0px !important;
        height:20%;
        padding-left: 0px !important;
        padding-right: 0px !important;
    }
    
    .btnVoltarKeyPad{
        
        padding-right: 0px !important;
        margin-top: 2%;
 
    }
    
    .btnEntrarKeyPad{
        
        padding-left: 0px !important;
        margin-top: 2%;
        
    }
    
    .btnVoltarCard{

        margin-top: 3%;
        
    }
    
    .btnEntrarCard{
        
        margin-top: 3%;
        
    }
  
</style>
<script>
    
    //Método para evitar que o input do cartão receba valores do teclado
      $('#checker').keypress(function(event) {
        if(<?= $keypad?>==1){
            event.preventDefault();
            return false; 
        }
    });
    
    //Método para inserir números no input do cartão pelo teclado virtual
    function addNumberInput(value){
        if($("#checker").val()==0){ 
            $("#checker").val(value);  
        }else{
            $("#checker").val($("#checker").val()+value);
        }  
    }
    
    //Método para remover números no input do cartão pelo teclado virtual
    function removeNumberInput(){
        $("#checker").val($("#checker").val().slice(0,-1));  
    }
    
    ///////Inserir na div um overlay para bloquear o toque
    //Os parâmetros da função insertBlocker funcionam da seguinte maneira:
    //O primeiro refere-se à String da div a selecionar
    //Os seguintes definem o tamanho e posicionamento do loader no ecrã
    //Sendo eles, respectivamente: width,height,left,top
    
    $("#entrar").click(function(){
        if($("#checker").val() != ''){// Apenas invoca o blocker se o campo do código estiver preenchido
            insertBlocker("body",15,15,42.5,40); 
        }
    });
    
    //A função seguinte faz com que o campo relativo ao código da obra
    //seja selecionado automaticamente e que possa ser executado através
    //da tecla enter, correspondente ao código 13
    
    $(function () {
        if(<?= $keypad ?>==0){
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
        } 
    });
    
</script>
<?php $this->load->view('footerscript'); ?>