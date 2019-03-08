<!DOCTYPE html>
<html lang="en">
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
                    $current_page = "Inicio";
                    include("breadcrumbs.php");
                    $difanos = getanosvendasobjetivos();

                    //dados filtro
                    $objvndt1 = date("Y") . "-01-01";
                    if (isset($_POST["objvndt"])) {
                        $objvndt1 = $_POST["objvndt"];
                    }

                    $periodo = 1;
                    if (isset($_POST["periodo"])) {
                        $periodo = $_POST["periodo"];
                    }
                    
                    $curano = date('Y');
                    if (isset($_POST["ano"])) {
                        $curano = $_POST["ano"];
                    }

                    //calculos
                    $objet1 = getobjperiodo(str_replace("-", "", $objvndt1), $periodo, $_SESSION["user"]["id"]);
                    $objet1 = round((count($objet1)) ? $objet1[0]["evalor"] : 0, 2);

                    $vendas1 = getvndperiodo(str_replace("-", "", $objvndt1), $periodo, $_SESSION["user"]["id"]);
                    $vendas1 = round((count($vendas1)) ? $vendas1[0]["evalor"] : 0, 2);

                    $perct1 = ($objet1>0) ? round($vendas1 / $objet1 * 100, 2) : 100;

                    $objet2 = getobjperiodo($curano . "0101", 12, $_SESSION["user"]["id"]);
                    $objet2 = round((count($objet2)) ? $objet2[0]["evalor"] : 0, 2);
                    
                    $vendas2 = getvendasano($curano, $_SESSION["user"]["id"]);
                    $vendas2 = round((count($vendas2)) ? $vendas2[0]["evalor"] : 0, 2);

                    $perct2 = ($objet2>0) ? round($vendas2 / $objet2 * 100, 2) : 100;
                    ?>
                    <form method="POST" class="form-horizontal">
                        <div class="span5">
                            <h3>Comparação Objetivos/Vendas por Período</h3><br>
                            Data / Período
                            <div class="control-group">
                                <div class="controls span12">
                                    <input type="date" name="objvndt" class="span3" value='<?= $objvndt1 ?>'>
                                    <select name="periodo" class="span3">
                                        <option <?= ($periodo == 1 ? "selected" : "") ?> value="1">Mensal</option>
                                        <option <?= ($periodo == 3 ? "selected" : "") ?> value="3">Trimestre</option>
                                        <option <?= ($periodo == 6 ? "selected" : "") ?> value="6">Semestre</option>
                                    </select>
                                    <button type="submit" class="btn btn-primary"><i class="white halflings-icon refresh"></i></button>
                                </div>
                            </div>
                            Objetivos / Vendas
                            <div class="control-group">
                                <div class="controls span12">
                                    <input type="text" disabled class="span3" value='<?= $objet1 ?> €'>
                                    <input type="text" disabled class="span3" value='<?= $vendas1 ?> €'>
                                </div>
                            </div>
                            <div id="chartobj1" class="plot" style="width:300px;height:180px;"></div>
                            <div class="control-group">
                                <div class="controls span12">
                                    <input type="text" disabled class="span6" style="text-align:center;" value='<?= $perct1 ?> %'>
                                </div>
                            </div>
                        </div>
                        <div class="span5">
                            <h3>Comparação Objetivos/Vendas por Ano</h3><br>
                            <div class="clearfix">
                                Ano
                                <div class="control-group">
                                    <div class="controls span12">
                                        <select name="ano" class="span3">
                                            <?php foreach ($difanos as $ano) : ?>
                                                <option <?= ($ano["ano"] == $curano) ? 'selected' : '' ?> value="<?= $ano["ano"] ?>"><?= $ano["ano"] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <button type="submit" class="btn btn-primary"><i class="white halflings-icon refresh"></i></button>
                                    </div>
                                </div>
                                Objetivos / Vendas
                                <div class="control-group">
                                    <div class="controls span12">
                                        <input type="text" disabled class="span3" value='<?= $objet2 ?> €'>
                                        <input type="text" disabled class="span3" value='<?= $vendas2 ?> €'>
                                    </div>
                                </div>
                            </div>
                            <div id="chartobj2" class="plot" style="width:300px;height:180px;"></div>
                            <div class="control-group">
                                <div class="controls span12">
                                    <input type="text" disabled class="span6" style="text-align:center;" value='<?= $perct2 ?> %'>
                                </div>
                            </div>
                        </div>
                    </form>
                    <script>
                        $(document).ready(function () {
                            var char1per = [<?= $perct1 ?>];
                            var char2per = [<?= $perct2 ?>];

                            $.jqplot('chartobj1', [char1per], {
                                seriesDefaults: {
                                    renderer: $.jqplot.MeterGaugeRenderer,
                                    rendererOptions: {
                                        min: 0,
                                        max: 100,
                                        intervals: [25, 50, 75, 100],
                                        intervalColors: ['#cc6666', '#d18b3c', '#E7E658', '#93b75f']
                                    }
                                }
                            });

                            $.jqplot('chartobj2', [char2per], {
                                seriesDefaults: {
                                    renderer: $.jqplot.MeterGaugeRenderer,
                                    rendererOptions: {
                                        min: 0,
                                        max: 100,
                                        intervals: [25, 50, 75, 100],
                                        intervalColors: ['#cc6666', '#d18b3c', '#E7E658', '#93b75f']
                                    }
                                }
                            });
                        });
                    </script>
                </div><!--/.fluid-container-->
                <!-- end: Content -->
            </div><!--/#content.span10-->
        </div><!--/fluid-row-->

        <div class="clearfix"></div>
        <?php include("footer.php"); ?>

        <!-- start: JavaScript-->
        <?php include("footer_code.php"); ?>
        <!-- end: JavaScript-->
    </body>
</html>
