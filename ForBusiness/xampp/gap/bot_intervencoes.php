<div class="row widget" style="margin-bottom:0px;">
    <div class="span12" ontablet="span12" ondesktop="span12">
        <a onclick="entrar(); return false;" class="quick-button green span6" >
            <p style="color:white; font-size:2vh;">ENTRAR AO SERVIÇO</p>
        </a>
        <a onclick="verifica_tarefas_aberto(); return false;" class="quick-button red span6" >
            <p style="color:white; font-size:2vh;">SAIR DO SERVIÇO</p>
        </a>
    </div>
</div>
<div class="row widget">
    <div class="span12" ontablet="span12" ondesktop="span12">
        <a onclick="verifica_ponto_tarefa('ENTRADA'); return false; " class="quick-button blue span12" >
            <p style="color:white; font-size:2vh;">NOVA INTERVENÇÃO</p>
        </a>
    </div>
</div>

<script>
    
    function verifica_ponto_tarefa( tipo ) {
        $(".loading-overlay").show();

        jQuery.ajax({
            type: "POST",
            url: "funcoes_gerais.php",
            data: {"action": "estado_ponto();"},
            success: function (data)
            {
                var data = JSON.parse(data);
                
                if( tipo == 'ENTRADA' ) {
                    if( data['val'] == 'ENTRADA' ) {
                        window.location.href = "intervencoes_nova.php";
                    }
                    else {
                        bootbox.alert('NECESSÁRIO DAR ENTRADA AO SERVIÇO ANTES DE INICIAR UMA TAREFA');
                        $(".loading-overlay").hide();
                        return false;
                    }
                }
                else if( tipo == 'SAIDA' ) {
                    if( data['val'] == 'SAIDA' ) {
                        sair();
                        $(".loading-overlay").hide();
                    }
                    else {
                        bootbox.alert('NECESSÁRIO DAR ENTRADA AO SERVIÇO ANTES DE INICIAR UMA TAREFA');
                        $(".loading-overlay").hide();
                        return false;
                    }
                }
                else {
                    $(".loading-overlay").hide();
                    return false;
                }
                
            },
            error: function ()
            {
                $(".loading-overlay").hide();
                return false;
            }
        });
    }
    
    function verifica_tarefas_aberto() {
        $(".loading-overlay").show();

        jQuery.ajax({
            type: "POST",
            url: "funcoes_gerais.php",
            data: {"action": "tarefas_aberto();"},
            success: function (data)
            {
                var data = JSON.parse(data);
                
                if( data['val'] == 0 ) {
                    $(".loading-overlay").hide();
                    sair();
                }
                else {
                    bootbox.alert('NECESSÁRIO FECHAR TODAS AS TAREFAS ANTES DE SAIR DO SERVIÇO');
                    $(".loading-overlay").hide();
                    return false;
                }
                
            },
            error: function ()
            {
                $(".loading-overlay").hide();
                return false;
            }
        });
    }
    
    function entrar() {
        $(".loading-overlay").show();

        jQuery.ajax({
            type: "POST",
            url: "funcoes_gerais.php",
            data: {"action": "entrar_ponto();"},
            success: function (data)
            {
                var data = JSON.parse(data);
                bootbox.alert(data['msg']);
                $(".loading-overlay").hide();
            },
            error: function ()
            {
                $(".loading-overlay").hide();
            }
        });
    }

    function sair() {
        $(".loading-overlay").show();

        jQuery.ajax({
            type: "POST",
            url: "funcoes_gerais.php",
            data: {"action": "sair_ponto();"},
            success: function (data)
            {
                var data = JSON.parse(data);
                bootbox.alert(data['msg']);
                $(".loading-overlay").hide();
            },
            error: function ()
            {
                $(".loading-overlay").hide();
            }
        });
    }
</script>