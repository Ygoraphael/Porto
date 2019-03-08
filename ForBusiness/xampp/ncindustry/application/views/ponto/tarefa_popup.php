<!DOCTYPE HTML>
<html>
    <?php
    $this->load->view("header.php");
    $keypad = $u_ncidef['keypad'];
    ?> 
    <body>
        <div class="col-lg-offset-1 col-lg-10 main-page">
            <div class="col-lg-12 " >
                <?php echo form_open('', 'class="cod_trabalhador" id="form_entrar"'); ?>
                <div class="stats-ponto4">
                    <h4><?= lang('Code_Card'); ?></h4>
                    <hr>
                    <div class="col-xs-12>" style="margin-top:5%">
                        <input id="checker" type="text" class="text-muted" name="cod_trabalhador" placeholder="<?= lang('Code_Worker'); ?>" style="display:inline-block" <?php
                        if ($keypad == 1) {
                            echo "readonly";
                        }
                        ?> required="" style="width:100%; height:auto;">
                    </div>
                    <?php if ($keypad == 1) : ?>
                        <div class="col-xs-12">
                            <div class="col-xs-4" style="margin-top:3%; padding-right:0px; padding-left:0px">
                                <input type="button"  onclick="addNumberInput($(this).val())" class="stats-ponto keypad" value="1">
                                <div class="clearfix"></div>	
                            </div>
                            <div class="col-xs-4" style="margin-top:3%; padding-right:0px; padding-left:0px">
                                <input type="button"  onclick="addNumberInput($(this).val())" class="stats-ponto keypad" value="2">
                                <div class="clearfix"></div>	
                            </div>
                            <div class="col-xs-4" style="margin-top:3%; padding-right:0px; padding-left:0px">
                                <input type="button"  onclick="addNumberInput($(this).val())" class="stats-ponto keypad" value="3">
                                <div class="clearfix"></div>	
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div class="col-xs-4" style="padding-right:0px; padding-left:0px">
                                <input type="button"  onclick="addNumberInput($(this).val())" class="stats-ponto keypad" value="4">
                                <div class="clearfix"></div>	
                            </div>
                            <div class="col-xs-4" style="padding-right:0px; padding-left:0px">
                                <input type="button"  onclick="addNumberInput($(this).val())" class="stats-ponto keypad" value="5">
                                <div class="clearfix"></div>	
                            </div>
                            <div class="col-xs-4" style="padding-right:0px; padding-left:0px">
                                <input type="button"  onclick="addNumberInput($(this).val())" class="stats-ponto keypad" value="6">
                                <div class="clearfix"></div>	
                            </div>
                        </div>

                        <div class="col-xs-12">
                            <div class="col-xs-4" style="padding-right:0px; padding-left:0px">
                                <input type="button" onclick="addNumberInput($(this).val())" class="stats-ponto keypad" value="7">
                                <div class="clearfix"></div>	
                            </div>
                            <div class="col-xs-4" style="padding-right:0px; padding-left:0px">
                                <input type="button"  onclick="addNumberInput($(this).val())" class="stats-ponto keypad" value="8">
                                <div class="clearfix"></div>	
                            </div>
                            <div class="col-xs-4" style="padding-right:0px; padding-left:0px">
                                <input type="button"  onclick="addNumberInput($(this).val())" class="stats-ponto keypad" value="9">
                                <div class="clearfix"></div>	
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <div class="col-xs-4" style="padding-right:0px; padding-left:0px">
                                <button type="button" onclick="$('#checker').val('')" class="stats-ponto keypad"><i class="fa fa-trash" style="font-size:35px;color:white"></i></button>
                                <div class="clearfix"></div>	
                            </div>
                            <div class="col-xs-4" style="padding-right:0px; padding-left:0px">
                                <input type="button"  onclick="addNumberInput($(this).val())" class="stats-ponto keypad" value="0">
                                <div class="clearfix"></div>	
                            </div>
                            <div class="col-xs-4" style="padding-right:0px; padding-left:0px">
                                <button type="button" onclick="removeNumberInput()" class="stats-ponto keypad"><i class="fa fa-chevron-circle-left" style="font-size:35px;color:white"></i></button>
                                <div class="clearfix"></div>	
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="col-xs-12" style="margin-top:5%;" >
                        <button id="conf_btn_cod_cart" type="submit" class="btn_cart" style="margin-top:3%;margin-bottom:5%" ><i class="fa fa-check-square-o" style="font-size:46px;color:white;"></i></button> 
                    </div>
                    <div class="clearfix"></div>
                    <?php form_close(); ?>
                </div>
                <?php form_close(); ?>
            </div>
        </div>
    </body>	
</html>
<style>

    input, button {
        height: 50%;
        font-size: 2em;
        color: #fff;
        margin-top: 5px;
        margin-bottom: 15px
    }

    .keypad{
        margin:0px !important;
        height:20%;
        padding-left: 0px !important;
        padding-right: 0px !important;
        padding-top: 10% !important;
        padding-bottom: 10% !important;
    }

</style>
<script>

    //Método para evitar que o input do cartão receba valores do teclado
    $('#checker').keypress(function (event) {
        if (<?= $keypad ?> == 1) {
            event.preventDefault();
            return false;
        }
    });

    //Método para inserir números no input do cartão pelo teclado virtual
    function addNumberInput(value) {
        if ($("#checker").val() == 0) {
            $("#checker").val(value);
        } else {
            $("#checker").val($("#checker").val() + value);
        }
    }
    //Método para remover números no input do cartão pelo teclado virtual
    function removeNumberInput() {
        $("#checker").val($("#checker").val().slice(0, -1));
    }

    ///////Inserir na div um overlay para bloquear o toque
    //Os parâmetros da função insertBlocker funcionam da seguinte maneira:
    //O primeiro refere-se à String da div a selecionar
    //Os seguintes definem o tamanho e posicionamento do loader no ecrã
    //Sendo eles, respectivamente: width,height,left,top

    $("#conf_btn_cod_cart").click(function () {
        if ($("#checker").val() != '') {
            insertBlocker(".stats-ponto4", 30, 30, 34, 36);// Parâmetros: String da div a selecionar,width
        }
    });

    //A função seguinte faz com que o campo relativo ao código da obra
    //seja selecionado automaticamente e que possa ser executado através
    //da tecla enter, correspondente ao código 13

    $(function () {
        if (<?= $keypad ?> == 0) {
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