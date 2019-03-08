<!DOCTYPE html>
<html lang="pt">
    <head>
        <?php include("header.php"); ?>
    </head>

    <body>
        <!-- start: Header -->
        <?php include("nav_bar.php"); ?>
        <!-- start: Header -->

        <div class="container-fluid-full">
            <div class="row-fluid">
                <!-- start: Main Menu -->
                <?php include("menu.php"); ?>
                <!-- end: Main Menu -->

                <noscript>
                <div class="alert alert-block span10">
                    <h4 class="alert-heading">Warning!</h4>
                    <p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
                </div>
                </noscript>

                <!-- start: Content -->
                <div id="content" class="span10">
                    <?php
                    $current_page = "Terminar Intervenção";
                    include("breadcrumbs.php");
                    if (isset($_GET["id"])) {
                        $dados = get_dados_tarefa($_GET["id"]);
                    }
                    else {
                        return;
                    }
                    ?>
                    <div class="row-fluid">
                        <div class="span12">
                            <button type="submit" class="btn btn-primary" onclick="window.location.replace('index.php'); return false;" ><i class="white halflings-icon circle-arrow-left"></i> Voltar</button>
                            <form id="ter_inter" role="form" data-toggle="validator" class="form-horizontal">
                                <br><br>
                                <div class="control-group">
                                    <label class="control-label">Relatório</label>
                                    <div class="controls">
                                        <textarea class="form-control span8" id="relatorio" style="height:30vh; background:white;" required></textarea>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Assinatura Cliente</label>
                                    <div class="controls">
                                        <div id="signature-pad" class="m-signature-pad">
                                            <canvas width=400 height=200></canvas><br>
                                            <button type="submit" class="btn btn-primary" id="clear_sign" onclick="return false;">LIMPAR</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <div class="controls">
                                        <a onclick="$('#ter_inter').submit();" class="quick-button blue span8">
                                            <p style="color:white; font-size:2vh;">FINALIZAR</p>
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div><!--/.fluid-container-->
            <!-- end: Content -->
        </div><!--/#content.span10-->	
        <div class="clearfix"></div>
        <script>
            var canvas = document.querySelector("canvas");
            signaturePad = new SignaturePad(canvas);
            signaturePad.minWidth = 0.8;
            signaturePad.maxWidth = 0.8;
            signaturePad.penColor = "rgb(0, 0, 0)";
            var cancelButton = document.getElementById('clear_sign');
            cancelButton.addEventListener('click', function (event) {
                signaturePad.clear();
            });
            
            function ifnull(val) {
                if (val == null)
                    return "";
                else
                    return val;
            }

            $('#ter_inter').validator().on('submit', function (e) {
                if (e.isDefaultPrevented()) {
                    return false;
                } else {
                    ActivateLoading();

                    if( signaturePad.isEmpty() ) {
                        bootbox.alert("Não é possivel finalizar a intervenção! É necessária a assinatura do cliente.");
                        DeactivateLoading();
                        return false;
                    }
                    else {
                        var data_assinatura = signaturePad.toDataURL();
                        var assinatura = data_assinatura.split(",")[1];
                    }

                    jQuery.ajax({
                        type: "POST",
                        url: "funcoes_gerais.php",
                        data: {"action": "termina_intervencao('<?php echo $_GET["id"]; ?>', '" + jQuery("#relatorio").val().toString().replace(/[']+/g, '') + "', '" + assinatura + "', '<?php echo $dados[0]["id_projecto"] ?>');"},
                        success: function (data)
                        {
                            window.location.replace("index.php");
                        }
                    });
                    return false;
                }
            })
        </script>
        <style>
            #signature-pad canvas {
                border: 1px solid #cccccc;
            }
        </style>
<?php include("footer.php"); ?>

        <!-- start: JavaScript-->
<?php include("footer_code.php"); ?>
        <!-- end: JavaScript-->
    </body>
</html>
