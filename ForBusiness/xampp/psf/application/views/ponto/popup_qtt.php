<!DOCTYPE HTML>
<html>
    <?php $this->load->view("header.php"); ?> 
    <body>
        <div class="col-lg-10 main-page">
            <div class="stats-ponto4 ">
                <h5><?= lang('Add_number_of_tasks_done'); ?></h5>
                <br>
                <form action="<?= base_url(); ?>ponto/add_product" method="POST">
                    <div class="input-group">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-danger btn-number"  data-type="minus" data-field="qtt">
                                <span class="glyphicon glyphicon-minus"></span>
                            </button>
                        </span>
                        <input id="checker" type="text" name="qtt" class="form-control input-number" value="1" min="1" max="9999" pattern="[0-9]*" required style="padding-left:5px !important;width:120%">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-success btn-number" data-type="plus" data-field="qtt">
                                <span class="glyphicon glyphicon-plus"></span>
                            </button>
                        </span>
                    </div>
                    <div class="col-lg-12"  style="margin-top:25px;">
                        <button type=button onClick="parent.jQuery.fancybox.close();" class="btn_cart2  fancybox fancybox.iframe"><i class="fa fa-caret-square-o-left" aria-hidden="true" style="font-size:46px;color:white"></i></button>
                        <button type="submit" class="btn_cart fancybox fancybox.iframe" data-toggle="modal" data-target="#popup" onclick="parent.jQuery.fancybox.close()"><i class="fa fa-check-square-o" style="font-size:46px;color:white"></i></button>
                        
                        <button type="button" class="fancybox-keyboard fancybox fancybox.iframe" onclick="keyboard()"><i class="fa fa-keyboard-o" style="font-size:2em;" ></i></button>
               
                        <div id="keyboardInsert" style="padding-left:6.5%;padding-right:6.5%">
                        </div>
                        
                        <div class="clearfix"></div>	
                        <input type="hidden" name="ststamp"  value="<?= $ststamp; ?>" >
                    </div>
                </form>
            </div>
        </div>
        <script type="text/javascript">
            
            //Método para inserir números no input do cartão pelo teclado virtual
            function addNumberInput(value) {
                if ($("#checker").val() == 0) {
                    $("#checker").val(value);
                } else if($("#checker").val()<1000){
                    console.log(value);
                    $("#checker").val($("#checker").val() + value);
                }
            }
            
            //Método para remover números no input do cartão pelo teclado virtual
            function removeNumberInput() {
                $("#checker").val($("#checker").val().slice(0, -1));
            }
            
            
            var toggleKeyboard=false;
            
            function keyboard(){
                
                var addNumberInput='addNumberInput($(this).val())';
                var checkerVal="$('#checker').val('')";
                
                if(!toggleKeyboard){
                    
                 $("#keyboardInsert").append('<div class="col-xs-12"><div class="col-xs-4" style="margin-top:3%; padding-right:0px; padding-left:0px"><input type="button"  onclick="'+addNumberInput+'" class="stats-ponto keypad" value="1"><div class="clearfix"></div></div><div class="col-xs-4" style="margin-top:3%; padding-right:0px; padding-left:0px"><input type="button"  onclick="'+addNumberInput+'" class="stats-ponto keypad" value="2"><div class="clearfix"></div></div><div class="col-xs-4" style="margin-top:3%; padding-right:0px; padding-left:0px"><input type="button"  onclick="'+addNumberInput+'" class="stats-ponto keypad" value="3"><div class="clearfix"></div></div></div><div class="col-xs-12"><div class="col-xs-4" style="padding-right:0px; padding-left:0px"><input type="button"  onclick="'+addNumberInput+'" class="stats-ponto keypad" value="4"><div class="clearfix"></div></div><div class="col-xs-4" style="padding-right:0px; padding-left:0px"><input type="button"  onclick="'+addNumberInput+'" class="stats-ponto keypad" value="5"><div class="clearfix"></div></div><div class="col-xs-4" style="padding-right:0px; padding-left:0px"><input type="button"  onclick="'+addNumberInput+'" class="stats-ponto keypad" value="6"><div class="clearfix"></div></div></div><div class="col-xs-12"><div class="col-xs-4" style="padding-right:0px; padding-left:0px"><input type="button" onclick="'+addNumberInput+'" class="stats-ponto keypad" value="7"><div class="clearfix"></div></div><div class="col-xs-4" style="padding-right:0px; padding-left:0px"><input type="button"  onclick="'+addNumberInput+'" class="stats-ponto keypad" value="8"><div class="clearfix"></div></div><div class="col-xs-4" style="padding-right:0px; padding-left:0px"><input type="button"  onclick="'+addNumberInput+'" class="stats-ponto keypad" value="9"><div class="clearfix"></div></div></div><div class="col-xs-12"><div class="col-xs-4" style="padding-right:0px; padding-left:0px"><button type="button" style="height:58px !important" onclick="'+checkerVal+'" class="stats-ponto keypad"><i class="fa fa-trash" style="font-size:25px;color:white"></i></button><div class="clearfix"></div></div><div class="col-xs-4" style="padding-right:0px; padding-left:0px"><input type="button"  onclick="'+addNumberInput+'" class="stats-ponto keypad" value="0"><div class="clearfix"></div></div><div class="col-xs-4" style="padding-right:0px; padding-left:0px"><button type="button" style="height:58px !important" onclick="removeNumberInput()" class="stats-ponto keypad"><i class="fa fa-chevron-circle-left" style="font-size:25px;color:white"></i></button><div class="clearfix"></div></div></div>');
                 //$("#keyboardInsert").show();
                 
                 
                    
                   
                }else{
                   //$("#keyboardInsert").hide();
                   $("#keyboardInsert").html("");
                    
                }
                parent.jQuery.fancybox.update();
                toggleKeyboard=!toggleKeyboard;
        
            }
            
            
            //Função que previne a introdução de quantidades com valores incorrectos ao clicar no botão
            //Por exemplo: introduzir manualmente valores negativos ou colocar valores exageradamente altos
            $('.btn-number').click(function (e) {
                e.preventDefault();
                fieldName = $(this).attr('data-field');
                type = $(this).attr('data-type');
                var input = $("input[name='" + fieldName + "']");
                var currentVal = parseInt(input.val());
                
                //Se o valor introduzido for um número
                if (!isNaN(currentVal)) {
                    
                    //Verificações ao reduzir quantidades.
                    //Se a quantidade atual for igual ao minimo, bloqueia o botão de redução
                    //Caso contrário, subtrai à quantidade atual
                    if (type == 'minus') {
                        if (currentVal > input.attr('min')) {
                            input.val(currentVal - 1).change();
                        }
                        if (parseInt(input.val()) == input.attr('min')) {
                            $(this).attr('disabled', true);
                        }
                    } else if (type == 'plus') {
                        
                        //Verificações ao aumentar quantidades.
                        //Se a quantidade atual for igual ao máximo, bloqueia o botão de incrementação
                        //Caso contrário, adiciona à quantidade atual
                        if (currentVal < input.attr('max')) {
                            input.val(currentVal + 1).change();
                        }
                        if (parseInt(input.val()) == input.attr('max')) {
                            $(this).attr('disabled', true);
                        }
                    }
                } else {
                    input.val(0);
                }
            });
            
            $('.input-number').focusin(function () {
                $(this).data('oldValue', $(this).val());
            });
            
            
            //Função que previne a introdução de quantidades com valores incorrectos ao modificar o input 
            //Por exemplo: introduzir manualmente valores negativos ou colocar valores exageradamente altos
            $('.input-number').change(function () {
                minValue = parseInt($(this).attr('min'));
                maxValue = parseInt($(this).attr('max'));
                valueCurrent = parseInt($(this).val());

                name = $(this).attr('name');
                if (valueCurrent >= minValue) {
                    $(".btn-number[data-type='minus'][data-field='" + name + "']").removeAttr('disabled')
                } else {
                    alert('Sorry, the minimum value was reached');
                    $(this).val($(this).data('oldValue'));
                }
                if (valueCurrent <= maxValue) {
                    $(".btn-number[data-type='plus'][data-field='" + name + "']").removeAttr('disabled')
                } else {
                    alert('Sorry, the maximum value was reached');
                    $(this).val($(this).data('oldValue'));
                }
            });
            
            //Função que previne a introdução de characteres que não sejam numéricos
            $(".input-number").keydown(function (e) {
                // Allow: backspace, delete, tab, escape, enter and .
                if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
                // Allow: Ctrl+A
                (e.keyCode == 65 && e.ctrlKey === true) ||
                // Allow: home, end, left, right
                (e.keyCode >= 35 && e.keyCode <= 39)) {
                    return;
                }

                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                    e.preventDefault();
                }
            });
        </script>		
    </body>
</html>
<style>
    
    .keypad{
        margin:0px !important;
        height:20%;
        color: #fff;
        font-size: 1em;
        padding-left: 2% !important;
        padding-right: 2%  !important;
    }
    
    .fancybox-keyboard {
        position: absolute;
        top: -73px;
        right: 138px;
        width: 36px;
        height: 36px;
        cursor: pointer;
        z-index: 8040;
        background-color:white;
        border: 0px;
    }
    
    
    body{
        
         overflow-x:hidden !important;
    }
    
    .btn-number{
        color: #fff;
        width: 40px;
        height: 63px;
        line-height: 30px;
        font-size: 14px;
        font-weight: bold;
        text-align: center;
        cursor: pointer;

    }
    .input-group{
        width: 140px;
        margin: 10px auto;
    }

    .input-number{
        font-size: 25px;
        width: 40px;
        height: 63px;
    }
</style>
<?php $this->load->view('footerscript'); ?>