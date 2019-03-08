<?php
include_once 'db_config.php';
?>

<style>

    .pagcurgeraltit {
        margin-top:25px;
    }

    @-ms-viewport {
        width: device-width
    }

    .visible-lg,
    .visible-md,
    .visible-sm,
    .visible-xs {
        display: none!important
    }

    .visible-lg-block,
    .visible-lg-inline,
    .visible-lg-inline-block,
    .visible-md-block,
    .visible-md-inline,
    .visible-md-inline-block,
    .visible-sm-block,
    .visible-sm-inline,
    .visible-sm-inline-block,
    .visible-xs-block,
    .visible-xs-inline,
    .visible-xs-inline-block {
        display: none!important
    }

    @media (max-width:767px) {
        .visible-xs {
            display: block!important
        }
        table.visible-xs {
            display: table!important
        }
        tr.visible-xs {
            display: table-row!important
        }
        td.visible-xs,
        th.visible-xs {
            display: table-cell!important
        }
    }

    @media (max-width:767px) {
        .visible-xs-block {
            display: block!important
        }
    }

    @media (max-width:767px) {
        .visible-xs-inline {
            display: inline!important
        }
    }

    @media (max-width:767px) {
        .visible-xs-inline-block {
            display: inline-block!important
        }
    }

    @media (min-width:768px) and (max-width:991px) {
        .visible-sm {
            display: block!important
        }
        table.visible-sm {
            display: table!important
        }
        tr.visible-sm {
            display: table-row!important
        }
        td.visible-sm,
        th.visible-sm {
            display: table-cell!important
        }
    }

    @media (min-width:768px) and (max-width:991px) {
        .visible-sm-block {
            display: block!important
        }
    }

    @media (min-width:768px) and (max-width:991px) {
        .visible-sm-inline {
            display: inline!important
        }
    }

    @media (min-width:768px) and (max-width:991px) {
        .visible-sm-inline-block {
            display: inline-block!important
        }
    }

    @media (min-width:992px) and (max-width:1199px) {
        .visible-md {
            display: block!important
        }
        table.visible-md {
            display: table!important
        }
        tr.visible-md {
            display: table-row!important
        }
        td.visible-md,
        th.visible-md {
            display: table-cell!important
        }
    }

    @media (min-width:992px) and (max-width:1199px) {
        .visible-md-block {
            display: block!important
        }
    }

    @media (min-width:992px) and (max-width:1199px) {
        .visible-md-inline {
            display: inline!important
        }
    }

    @media (min-width:992px) and (max-width:1199px) {
        .visible-md-inline-block {
            display: inline-block!important
        }
    }

    @media (min-width:1200px) {
        .visible-lg {
            display: block!important
        }
        table.visible-lg {
            display: table!important
        }
        tr.visible-lg {
            display: table-row!important
        }
        td.visible-lg,
        th.visible-lg {
            display: table-cell!important
        }
    }

    @media (min-width:1200px) {
        .visible-lg-block {
            display: block!important
        }
    }

    @media (min-width:1200px) {
        .visible-lg-inline {
            display: inline!important
        }
    }

    @media (min-width:1200px) {
        .visible-lg-inline-block {
            display: inline-block!important
        }
    }

    @media (max-width:767px) {
        .hidden-xs {
            display: none!important
        }
    }

    @media (min-width:768px) and (max-width:991px) {
        .hidden-sm {
            display: none!important
        }
    }

    @media (min-width:992px) and (max-width:1199px) {
        .hidden-md {
            display: none!important
        }
    }

    @media (min-width:1200px) {
        .hidden-lg {
            display: none!important
        }
    }

    .visible-print {
        display: none!important
    }

    @media print {
        .visible-print {
            display: block!important
        }
        table.visible-print {
            display: table!important
        }
        tr.visible-print {
            display: table-row!important
        }
        td.visible-print,
        th.visible-print {
            display: table-cell!important
        }
    }

    .visible-print-block {
        display: none!important
    }

    @media print {
        .visible-print-block {
            display: block!important
        }
    }

    .visible-print-inline {
        display: none!important
    }

    @media print {
        .visible-print-inline {
            display: inline!important
        }
    }

    .visible-print-inline-block {
        display: none!important
    }

    @media print {
        .visible-print-inline-block {
            display: inline-block!important
        }
    }

    @media print {
        .hidden-print {
            display: none!important
        }
    }

    .horule {
        border: 0;
        height: 1px;
        background: #333;
        background: -webkit-gradient(linear, left top, right top, color-stop(0%,hsla(0,0%,0%,0)), color-stop(50%,hsla(0,0%,0%,.75)), color-stop(100%,hsla(0,0%,0%,0)));
        background: -webkit-linear-gradient(left, hsla(0,0%,0%,0) 0%, hsla(0,0%,0%,.75) 50%, hsla(0,0%,0%,0) 100%);
        background:    -moz-linear-gradient(left, hsla(0,0%,0%,0) 0%, hsla(0,0%,0%,.75) 50%, hsla(0,0%,0%,0) 100%);
        background:     -ms-linear-gradient(left, hsla(0,0%,0%,0) 0%, hsla(0,0%,0%,.75) 50%, hsla(0,0%,0%,0) 100%);
        background:      -o-linear-gradient(left, hsla(0,0%,0%,0) 0%, hsla(0,0%,0%,.75) 50%, hsla(0,0%,0%,0) 100%);
        background:         linear-gradient(left, hsla(0,0%,0%,0) 0%, hsla(0,0%,0%,.75) 50%, hsla(0,0%,0%,0) 100%);
    }
</style>

<?php
if (isset($_SESSION['acao'])) {
    unset($_SESSION['acao']);
}
$request = $_SERVER['REQUEST_URI'];
$curso = explode('/', $request);

$curso = end($curso);
$curso = explode('?', $curso);

$_POST['name'] = $curso[0];
$cod_curso = $_POST['name'];

$query = $db->getQuery(true);
$query->select($db->quoteName(array('NomeCurso')));
$query->from($db->quoteName('cursos'));
$query->where($db->quoteName('CC') . ' = ' . $db->quote($cod_curso));

$db->setQuery($query);
$results = $db->loadAssocList();

foreach ($results as $row) {
    $title = nl2br($row['NomeCurso']);
}

$query = $db->getQuery(true);
$query->select('*');
$query->from($db->quoteName('cursos'));
$query->where($db->quoteName('CC') . ' = ' . $db->quote($cod_curso));

$db->setQuery($query);
$resultsAll = $db->loadAssocList();

foreach ($resultsAll as $linha) {
    $aba_nome = $linha['aba_nome'];
    $aba_visivel = $linha['aba_visivel'];
    $aba_descricao = $linha['aba_descricao'];
    $id_curso = $linha['ID'];
}

$query = $db->getQuery(true);
$query->select('*');
$query->from($db->quoteName('w2auh_juform_forms'));
$query->where($db->quoteName('curso') . ' = ' . $id_curso);
$query->where($db->quoteName('published') . ' = 1');
$db->setQuery($query);

$resultsForms = $db->loadAssocList();

$query = $db->getQuery(true);
$query->select('w2auh_juform_fields.caption, w2auh_juform_fields.form_id, w2auh_juform_fields.plugin_id, w2auh_juform_plugins.title as Plugin_Title,w2auh_juform_fields.field_name,w2auh_juform_fields.predefined_values, w2auh_juform_forms.title AS Form_Title, w2auh_juform_forms.afterprocess_action_value AS afterprocess, w2auh_juform_forms.afterprocess_action AS afterprocessaction');
$query->from('w2auh_juform_plugins,w2auh_juform_fields, w2auh_juform_forms');
$query->where('w2auh_juform_fields.plugin_id = w2auh_juform_plugins.id AND w2auh_juform_fields.form_id = w2auh_juform_forms.id AND w2auh_juform_forms.published=1 AND w2auh_juform_fields.published=1 ORDER BY w2auh_juform_fields.ordering');
$db->setQuery($query);

$resultsBAQ = $db->loadAssocList();
?>

<div class="span12 nopadding side-collapse-container" style="word-wrap: break-word">
    <center><h4 class="page-header"><?= nl2br($row['NomeCurso']) ?></h4></center>

    <center><h2 class="pagcurgeraltit">Apresentação do Curso</h2></center>
    <hr class="horule" />
    <?php
    $query = $db->getQuery(true);
    $query->select("*");
    $query->from($db->quoteName('cursos'));
    $query->where($db->quoteName('CC') . ' = ' . $db->quote($cod_curso));
    $db->setQuery($query);
    $results = $db->loadAssocList();
    ?>
    <div class="" id="apresentacao-curso">
        <?php
        foreach ($results as $row) {
            echo nl2br(repStr(remNlRep($row['Contexto'])));
        }
        ?>
        <hr style="border-top: 1px solid #ccc; margin:15px;">
        <?php
        foreach ($results as $row) {
            echo "<b>Objectivos:</b><br><br> ";
            echo nl2br(repStr(remNlRep($row['Objectivos'])));
        }
        ?>
        <hr style="border-top: 1px solid #ccc; margin:15px;">
        <?php
        foreach ($results as $row) {
            echo "<b>Destinatários:</b> <br> <br> ";
            echo nl2br(repStr(remNlRep($row['PublicoTarget'])));
        }
        ?>
        <hr style="border-top: 1px solid #ccc; margin:15px;">
        <?php
        foreach ($results as $row) {
            echo "<b>Conteúdo:</b> <br> <br> ";
            echo nl2br(repStr(remNlRep($row['Conteudos'])));
        }
        foreach ($resultsForms as $linha) {
            //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            if ($linha['local'] == 2) {


                foreach ($resultsAll as $rr) {

                    if ($linha['curso'] == $rr['ID']) {

                        addforms($linha, $resultsBAQ, "Apresentação do Curso -> " . str_replace(array('<p>', '</p>'), '', $rr['NomeCurso']));
                    }
                }
            }
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////         
        }
        ?>
        <br>
    </div>

    <?php if ($aba_visivel == 0) : ?>
        <div class="tab-pane fade in" id="duvidas">
            <?php
            echo nl2br(repStr(remNlRep($aba_descricao)));

            $text = array();
            $value = array();
            $default = array();

            foreach ($resultsForms as $linha) {
                if ($linha['local'] == 1) {
                    foreach ($resultsAll as $rr) {
                        if ($linha['curso'] == $rr['ID']) {
                            addforms($linha, $resultsBAQ, "Nova Aba -> " . str_replace(array('<p>', '</p>'), '', $rr['NomeCurso']));
                        }
                    }
                }
            }
            ?>
        </div>
    <?php endif; ?>

    <center><h2 class="pagcurgeraltit">Preços e Condições de Inscrição</h2></center>
    <hr class="horule" />

    <div class="" id="precos-descontos">
        <?php
        foreach ($results as $row) {
            echo repStr(remNlRep($row['Preco']));
        }
        ?>

        <?php
        foreach ($results as $row) {
            echo nl2br(repStr(remNlRep($row['Info'])));
        }
        ?>
    </div>

    <center><h2 class="pagcurgeraltit">Cronograma e Inscrições</h2></center>
    <hr class="horule" />

    <div class="" id="cronograma">
        <div class="even_tab">
            <div class="span12 nopadding">
                <?php
                $local = $db->escape((isset($_REQUEST['input1']) ? $_REQUEST['input1'] : ""));
                $data = $db->escape((isset($_REQUEST['input2']) ? $_REQUEST['input2'] : ""));
                $acao = $db->escape((isset($_REQUEST['input3']) ? $_REQUEST['input3'] : ""));

//localidades
                $query = $db->getQuery(true);
                $query->select("DISTINCT Localidade");
                $query->from($db->quoteName('acoes'));
                $query->where($db->quoteName('exame') . ' = ' . $db->quote("0"));
                $query->where($db->quoteName('RefCurso') . ' = ' . $db->quote($cod_curso));
                $query->order('Localidade ASC');
                $db->setQuery($query);
                $localidades = $db->loadAssocList();

//ações
                $query = $db->getQuery(true);
                $query->select("DISTINCT NomeAcao");
                $query->from($db->quoteName('acoes'));
                $query->where($db->quoteName('exame') . ' = ' . $db->quote("0"));
                $query->where($db->quoteName('RefCurso') . ' = ' . $db->quote($cod_curso));
                $query->order('NomeAcao ASC');
                $db->setQuery($query);
                $list_cursos = $db->loadAssocList();

//ações datas
                $query = $db->getQuery(true);
                $query->select("DISTINCT DataInicio");
                $query->from($db->quoteName('acoes'));
                $query->where($db->quoteName('exame') . ' = ' . $db->quote("0"));
                $query->where($db->quoteName('RefCurso') . ' = ' . $db->quote($cod_curso));
                $query->order('DataInicio ASC');
                $db->setQuery($query);
                $list_datas = $db->loadAssocList();

                $str_query = "SELECT * FROM acoes WHERE " . $db->quoteName('RefCurso') . '=' . $db->quote($cod_curso) . ' AND ' . $db->quoteName('exame') . ' = ' . $db->quote("0") . ' ';

                $str_query_where = "";
                if (strlen(trim($local)))
                    $str_query_where .= 'AND ' . $db->quoteName('Localidade') . ' = ' . $db->quote($local);
                if (strlen(trim($data)))
                    $str_query_where .= 'AND ' . $db->quoteName('DataInicio') . ' = ' . $db->quote($data);
                if (strlen(trim($acao)))
                    $str_query_where .= 'AND ' . $db->quoteName('NomeAcao') . ' = ' . $db->quote($acao);

                $db->setQuery($str_query . $str_query_where);
                $acoes_curso = $db->loadAssocList();

                if (count($acoes_curso))
                    
                ?>
                <form action="" method="POST" class="form-inline">
                    <div class="form-group" style="display: inline-block;">
                        <label for="input3">Curso</label>
                        <select class="form-control" id="input3" name="input3">
                            <option value=""></option>
                            <?php
                            $tmp_nomeacao = array();
                            foreach ($list_cursos as $row) {
                                if (!in_array(trim($row["NomeAcao"]), $tmp_nomeacao)) {
                                    $selected = "";
                                    if ($acao == trim($row['NomeAcao']) && $acao != "")
                                        $selected = "selected";
                                    if (strlen(trim($row['NomeAcao'])) > 0)
                                        echo "<option " . $selected . " value='" . $row['NomeAcao'] . "'>" . $row['NomeAcao'] . "</option>";
                                    $tmp_nomeacao[] = trim($row["NomeAcao"]);
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group" style="display: inline-block;">
                        <label for="input1">Localidade</label>
                        <select class="form-control" id="input1" name="input1">
                            <option value=""></option>
                            <?php
                            $tmp_local = array();

                            foreach ($localidades as $row) {
                                if (!in_array(trim($row["Localidade"]), $tmp_local)) {
                                    $selected = "";
                                    if ($local == trim($row['Localidade']) && $local != "")
                                        $selected = "selected";
                                    if (strlen(trim($row['Localidade'])) > 0)
                                        echo "<option " . $selected . " value='" . $row['Localidade'] . "'>" . $row['Localidade'] . "</option>";
                                    $tmp_local[] = trim($row["Localidade"]);
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group" style="display: inline-block;">
                        <label for="input2">Data de Início</label>
                        <select class="form-control" id="input2" name="input2">
                            <option value=""></option>
                            <?php
                            $tmp_data = array();
                            foreach ($list_datas as $row) {
                                if (!in_array(trim($row["DataInicio"]), $tmp_data)) {
                                    $selected = "";
                                    if ($data == trim($row['DataInicio']) && $data != "")
                                        $selected = "selected";
                                    if (strlen(trim($row['DataInicio'])) > 0)
                                        echo "<option " . $selected . " value='" . $row['DataInicio'] . "'>" . $row['DataInicio'] . "</option>";
                                    $tmp_data[] = trim($row["DataInicio"]);
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-default">Procurar</button>
                </form>
                <table class="no-more-tables dt3" style="width: 100%">
                    <thead>
                        <tr>
                            <th class="" style="text-align: left;">Curso</th>
                            <th class="" style="text-align: center;">Localidade</th>
                            <th class="" style="text-align: center;">Data de Início</th>
                            <th class="" style="text-align: center;">Nº Sessões</th>
                            <th class="" style=" text-align: center"></th>
                            <th class="" style=" text-align: center"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($acoes_curso as $acao) { ?>
                            <tr style="vertical-align: baseline;" class="text-center">
                                <td data-title="Curso" class="contact-address" style="text-align: left;"><?php echo nl2br($acao['NomeAcao']); ?></td>
                                <td data-title="Localidade" class="contact-address"><?php echo nl2br($acao['Localidade']); ?></td>
                                <td data-title="Data de Início" class="contact-email"><?php echo nl2br((new \DateTime($acao['DataInicio']))->format('Y-m-d')); ?></td>
                                <td data-title="Nº Sessões" class="hidden-phone contact-address"><?php echo nl2br($acao['Sessoes']); ?></td>
                                <td data-title="" class="">
                                    <a href="#ex<?= $acao['ID']; ?>" role="button" class="btn btn-primary" data-toggle="modal">detalhes</a>
                                </td>
                                <td data-title="" class="inscricao ">
                                    <form action='<?= JURI::base(); ?>index.php/inscrever' method="post">
                                        <input type="hidden" name="codint" value="<?php echo nl2br($acao['CodigoInterno']); ?>">
                                        <input type="hidden" name="title" value="<?php echo $title; ?>">
                                        <input type="hidden" name="acao" value="<?php echo $acao['ID']; ?>">
                                        <input type="submit" name="submit" class="btn btn-success" value="Inscrever">
                                    </form>
                                </td>
                            </tr>
                            <!-- Modal -->
                        <div id="ex<?= $acao['ID']; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="z-index: 9999;">
                            <div class="modal-header" style="background-color:#cc262b; color:white; border-top-left-radius:6px; border-top-right-radius:6px;">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h3 id="myModalLabel">Informações</h3>
                            </div>
                            <!-- pop up body -->
                            <div class="modal-body">
                                <div class="row" style="margin:0;">

                                    <div style="width:100%">
                                        <div style="padding-left:15px;">
                                            <br>
                                            <p><b style="color:#37393A;">Data de Início:   </b>
                                                <?php echo nl2br((new \DateTime($acao['DataInicio']))->format('d/m/Y')); ?>
                                                <b style="color:#37393A;">Data de Término: </b>
                                                <?php echo nl2br((new \DateTime($acao['DataFim']))->format('d/m/Y')); ?></p>
                                            <p><b>Sessões:   </b><?php echo nl2br(repStr(remNlRep($acao['Sessoes']))); ?></p>
                                            <p><b>Formato: </b><?php echo removeP(nl2br(repStr(remNlRep($acao['Formato'])))); ?></p><br>
                                            <p><b>Localidade: </b>  <?php echo removeP(nl2br(repStr(remNlRep($acao['Localidade'])))); ?></p>
                                            <p><b>Endereço: </b><div style="padding-left:3%;"><?php echo nl2br(repStr(remNlRep($acao['Morada']))); ?></div></p><br>
                                            <p><b>Cronograma: </b><div style="padding-left:3%;"><?php echo nl2br(repStr(remNlRep($acao['Horario']))); ?></div></p><br>
                                            <p><b>Preço e Promoções: </b>
                                                <?php
                                                $cur_date = new DateTime(date('Y-m-d'));
                                                $data_inicio = new DateTime(date('Y-m-d', strtotime($acao['DataInicio'])));
                                                $dDiff = $cur_date->diff($data_inicio);
                                                $dDiff->format('%R');

                                                if (intval($acao['diaspreco2']) != 0 && $dDiff->days >= intval($acao['diaspreco2'])) {
                                                    echo "Inscreva-se HOJE e aproveite a PROMOÇÃO que só dura até " . intval($acao['diaspreco2']) . " dias antes do início do curso " . number_format($acao['preco2'], 2, ",", ".") . " (valor sem iva) " . number_format($acao['preco2'] * 1.23, 2, ",", ".") . " (valor com iva)";
                                                } else {
                                                    echo "Inscrição " . number_format($acao['preco'], 2, ",", ".") . " (valor sem iva) " . number_format($acao['preco'] * 1.23, 2, ",", ".") . " (valor com iva)";
                                                }
                                                ?>
                                            </p><br>
                                            <p><b>Detalhes: </b><div style="padding-left:3%;"><?php echo nl2br(repStr(remNlRep($acao['Info']))); ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end of pop up -->
                            <div class="modal-footer">
                                <form action='<?= JURI::base(); ?>index.php/inscrever' method="post">
                                    <input type="hidden" name="codint" value="<?php echo nl2br($acao['CodigoInterno']); ?>">
                                    <input type="hidden" name="title" value="<?php echo $title; ?>">
                                    <input type="hidden" name="acao" value="<?php echo $acao['ID']; ?>">
                                    <input type="submit" name="submit" class="btn btn-success" value="Inscrever">
                                </form>
                            </div>
                        </div>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <center><h2 class="pagcurgeraltit">Exames Online</h2></center>
    <hr class="horule" />

    <div class="" id="exames-online">
        <?php
        $query = $db->getQuery(true);
        $query->select("*");
        $query->from($db->quoteName('acoes'));
        $query->where($db->quoteName('RefCurso') . ' = ' . $db->quote($cod_curso));
        $query->where($db->quoteName('exame') . ' = ' . $db->quote("1"));
        $db->setQuery($query);
        $exames_curso = $db->loadAssocList();

        if (count($exames_curso)) {
            ?>
            <table class="no-more-tables" style="width: 100%">
                <thead>
                    <tr>
                        <th class="" style="vertical-align: baseline; text-align: left;">Tipo de Exame</th>
                        <th class="" style="vertical-align: baseline; text-align: center;">Nº Testes</th>
                        <th class="" style="vertical-align: baseline; text-align: center;">Nº Total Questões</th>
                        <th class="" style=" text-align: center"></th>
                        <th class="" style=" text-align: center"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($exames_curso as $acao) { ?>
                        <tr style="vertical-align: baseline;" class="text-center">
                            <td data-title="Tipo de Exame" class="contact-address" style="text-align: left;"><?php echo nl2br(repStr(remNlRep($acao['NomeAcao']))); ?></td>
                            <td data-title="Nº Testes" class="contact-address"><?php echo nl2br(repStr(remNlRep($acao['Sessoes']))); ?></td>
                            <td data-title="Nº Questões" class="contact-address"><?php echo nl2br(repStr(remNlRep($acao['Formato']))); ?></td>
                            <td class="">
                                <a href="#ex<?= $acao['ID']; ?>" role="button" class="btn btn-primary" data-toggle="modal">detalhes</a>
                            </td>
                            <td class="inscricao ">
                                <form style="margin:0px;" id="exinp<?= $acao['ID']; ?>" action='<?= JURI::base(); ?>index.php/inscrever' method="post">
                                    <input type="hidden" name="codint" value="<?php echo nl2br($acao['CodigoInterno']); ?>">
                                    <input type="hidden" name="title" value="<?php echo $title; ?>">
                                    <input type="hidden" name="exameclienteadp" value="">
                                    <input type="hidden" name="acao" value="<?php echo $acao['ID']; ?>">
                                </form>
                                <button type="button" class="btn btn-success" data-title="Fez a formação com a Academia do Profissional?" data-btn-ok-label="Sim" data-btn-cancel-label="Não" data-toggle="confirmation" data-id="exinp<?= $acao['ID']; ?>">Inscrever</button>
                            </td>
                        </tr>
                        <!-- Modal -->
                    <div id="ex<?= $acao['ID']; ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="z-index: 9999;">
                        <div class="modal-header" style="background-color:#cc262b; color:white; border-top-left-radius:6px; border-top-right-radius:6px;">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            <h3 id="myModalLabel">Informações</h3>
                        </div>
                        <!-- pop up body -->
                        <div class="modal-body">
                            <div class="row" style="margin:0;">
                                <div style="width:100%;">
                                    <div style="padding-left:35px;"><br>
                                        <p>
                                            <b style="color:#37393A;">Nº exames: </b>
                                            <?php echo $acao['Sessoes']; ?>
                                        </p>
                                        <p>
                                            <b style="color:#37393A;">Nº total de questões: </b>
                                            <?php echo repStr(remNlRep(removeP($acao['Formato']))); ?>
                                        </p><br>
                                        <p>
                                            <b style="color:#37393A;">Vantagens: </b>
                                            <?php echo repStr(remNlRep($acao['Info'])); ?>
                                        </p><br>
                                        <p>
                                            <b style="color:#37393A;">Preço cliente Academia do Profissional: </b>
                                            <?php echo number_format(floatval($acao['preco']), 2, '.', ''); ?> €
                                        </p>
                                        <p>
                                            <b style="color:#37393A;">Preço não cliente Academia do Profissional: </b>
                                            <?php echo number_format(floatval($acao['preco2']), 2, '.', ''); ?> €
                                        </p><br>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end of pop up -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" data-title="Fez a formação com a Academia do Profissional?" data-btn-ok-label="Sim" data-btn-cancel-label="Não" data-toggle="confirmation" data-id="exinp<?= $acao['ID']; ?>">Inscrever</button>
                        </div>
                    </div>
                <?php } ?>
                </tbody>
            </table>
            <?php
        }
        ?>
    </div>
</div>
<script>
    jQuery(window).load(function () {
        // Javascript to enable link to tab
        var url = document.location.toString();
        if (url.match('#')) {
            var curenv = findBootstrapEnvironment();
            if( curenv == 'xs' || curenv == 'sm' ) {
                curenv = 1;
            }
            else {
                curenv = 0;
            }
            scrollToDiv("#" + url.split('#')[1], curenv);
        }
    })
</script>
<style>
    .tab-pane hr {
        margin:20px;
    }
    .dataTables_length{float: right};
</style>
