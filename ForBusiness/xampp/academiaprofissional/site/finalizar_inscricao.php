<?php

include_once 'Mail.php';
include_once 'db_config.php';

//definir tipo - empresa/individual
if (isset($_POST['type']) && !isset($_SESSION['type'])) {
    $_SESSION['type'] = $_POST['type'];
}

if (isset($_SESSION['curso_corrente']['id']) && isset($_SESSION['curso_corrente']['nome'])) {
    $curso_id = $_SESSION['curso_corrente']['id'];
    $curso_nome = $_SESSION['curso_corrente']['nome'];
    $exameclienteadp = $_SESSION['curso_corrente']['exameclienteadp'];

    unset($_SESSION['curso_corrente']['id']);
    unset($_SESSION['curso_corrente']['nome']);
    unset($_SESSION['curso_corrente']['exameclienteadp']);
}

if (isset($_SESSION['type']) && isset($curso_id)) {
    $query = $db->getQuery(true);
    $query->select(array('a.*', 'c.CC', 'c.NomeCurso'));
    $query->from($db->quoteName('acoes', 'a'));
    $query->join('INNER', $db->quoteName('cursos', 'c') . ' ON (' . $db->quoteName('a.RefCurso') . ' = ' . $db->quoteName('c.CC') . ')');
    $query->where($db->quoteName('a.ID') . ' = ' . $db->quote($curso_id));
    $db->setQuery($query);
    $acoes = $db->loadAssocList();

    if ($_SESSION['type'] == "empresa") {
        //guardar agora a compra
        foreach ($acoes as $row) {
            $_SESSION["caret"][$curso_id]['acao'] = $curso_id;
            $_SESSION["caret"][$curso_id]['nome'] = $curso_nome;

            //exame
            if ($row['exame']) {
                if ($exameclienteadp) {
                    $_SESSION["caret"][$curso_id]['preco'] = $row['preco'];
                    $_SESSION["caret"][$curso_id]['exameclienteadp'] = 1;
                } else {
                    $_SESSION["caret"][$curso_id]['preco'] = floatval($row['preco2']);
                    $_SESSION["caret"][$curso_id]['exameclienteadp'] = 0;
                }
            }
            //curso
            else {
                $cur_date = new DateTime(date('Y-m-d'));
                $data_inicio  = new DateTime(date('Y-m-d', strtotime($row['DataInicio'])));
                $dDiff = $cur_date->diff($data_inicio);
                $dDiff->format('%R');
                if ($dDiff->days >= intval($row['diaspreco2'])) {
                    $_SESSION["caret"][$curso_id]['preco'] = $row['preco2'];
                }
                else {
                    $_SESSION["caret"][$curso_id]['preco'] = $row['preco'];
                }
                $_SESSION["caret"][$curso_id]['exameclienteadp'] = 0;
            }
            
            $_SESSION["caret"][$curso_id]['cc'] = $row['CC'];
            $_SESSION["caret"][$curso_id]['descricao'] = $row['NomeCurso'];
            $_SESSION["caret"][$curso_id]['tipologia'] = ($row['exame'] ? "exame" : "curso");

            $nif_tmp = array();
            $formandos = json_decode($_POST["formandosData"], true);
            foreach ($formandos as $formando) {
                if (!in_array(trim($formando["NIF"]), $nif_tmp)) {
                    $nif_tmp[] = trim($formando["NIF"]);

                    $_SESSION["caret"][$curso_id]['formando'][count($nif_tmp) - 1]['NomeFormando'] = $formando["Nome"];
                    $_SESSION["caret"][$curso_id]['formando'][count($nif_tmp) - 1]['NIF'] = $formando["NIF"];
                    $_SESSION["caret"][$curso_id]['formando'][count($nif_tmp) - 1]['Email'] = $formando["E-mail"];
                    $_SESSION["caret"][$curso_id]['formando'][count($nif_tmp) - 1]['Telemovel'] = $formando["Telemóvel"];
                    $_SESSION["caret"][$curso_id]['formando'][count($nif_tmp) - 1]['DataNasc'] = $formando["Data nascimento"];
                    $_SESSION["caret"][$curso_id]['formando'][count($nif_tmp) - 1]['Morada'] = $formando["Morada"];
                    $_SESSION["caret"][$curso_id]['formando'][count($nif_tmp) - 1]['CodigoPostal'] = $formando["Cód. Postal"];
                    $_SESSION["caret"][$curso_id]['formando'][count($nif_tmp) - 1]['Localidade'] = $formando["Localidade"];
                    $_SESSION["caret"][$curso_id]['formando'][count($nif_tmp) - 1]['CartaoCidadao'] = $formando["Cartão cidadão"];
                    $_SESSION["caret"][$curso_id]['formando'][count($nif_tmp) - 1]['Validade'] = $formando["Validade cartão cidadão"];
                    $_SESSION["caret"][$curso_id]['formando'][count($nif_tmp) - 1]['nCartaConducao'] = $formando["Carta condução"];
                    $_SESSION["caret"][$curso_id]['formando'][count($nif_tmp) - 1]['DataEmissao'] = $formando["Data emissão carta condução"];
                    $_SESSION["caret"][$curso_id]['formando'][count($nif_tmp) - 1]['DataRenovADR'] = $formando["Data Renovação ADR"];
                    $_SESSION["caret"][$curso_id]['formando'][count($nif_tmp) - 1]['DataRenovCAM'] = "";
					$_SESSION["caret"][$curso_id]['formando'][count($nif_tmp) - 1]['escolaridade'] = $formando["Escolaridade"];
                }
            }
        }
    } else {
        //dados indiviual ainda nao estao guardados
        if (!isset($_SESSION['caret_user'])) {
            $_SESSION['caret_user']['NomeFormando'] = (isset($_POST['NomeFormando']) ? $_POST['NomeFormando'] : '');
            $_SESSION['caret_user']['NIF'] = (isset($_POST['NIF']) ? $_POST['NIF'] : '');
            $_SESSION['caret_user']['Email'] = (isset($_POST['Email']) ? $_POST['Email'] : '');
            $_SESSION['caret_user']['Telemovel'] = (isset($_POST['Telemovel']) ? $_POST['Telemovel'] : '');
            $_SESSION['caret_user']['DataNasc'] = (isset($_POST['DataNasc']) ? $_POST['DataNasc'] : '');
            $_SESSION['caret_user']['Morada'] = (isset($_POST['Morada']) ? $_POST['Morada'] : '');
            $_SESSION['caret_user']['CodigoPostal'] = (isset($_POST['CodigoPostal']) ? $_POST['CodigoPostal'] : '');
            $_SESSION['caret_user']['CartaoCidadao'] = (isset($_POST['CartaoCidadao']) ? $_POST['CartaoCidadao'] : '');
            $_SESSION['caret_user']['Validade'] = (isset($_POST['Validade']) ? $_POST['Validade'] : '');
            $_SESSION['caret_user']['nCartaConducao'] = (isset($_POST['nCartaConducao']) ? $_POST['nCartaConducao'] : '');
            $_SESSION['caret_user']['DataEmissao'] = (isset($_POST['DataEmissao']) ? $_POST['DataEmissao'] : '');
            $_SESSION['caret_user']['DataRenovADR'] = (isset($_POST['DataRenovADR']) ? $_POST['DataRenovADR'] : '');
            $_SESSION['caret_user']['DataRenovCAM'] = (isset($_POST['DataRenovCAM']) ? $_POST['DataRenovCAM'] : '');
			$_SESSION['caret_user']['escolaridade'] = (isset($_POST['escolaridade']) ? $_POST['escolaridade'] : '');
        }

        //guardar agora a compra
        foreach ($acoes as $row) {
            $_SESSION["caret"][$curso_id]['acao'] = $curso_id;
            $_SESSION["caret"][$curso_id]['nome'] = $curso_nome;
            $_SESSION["caret"][$curso_id]['cc'] = $row['CC'];
            $_SESSION["caret"][$curso_id]['descricao'] = $row['NomeCurso'];
            $_SESSION["caret"][$curso_id]['tipologia'] = ($row['exame'] ? "exame" : "curso");
            
            //exame
            if ($row['exame']) {
                if ($exameclienteadp) {
                    $_SESSION["caret"][$curso_id]['preco'] = $row['preco'];
                    $_SESSION["caret"][$curso_id]['exameclienteadp'] = 1;
                } else {
                    $_SESSION["caret"][$curso_id]['preco'] = floatval($row['preco2']);
                    $_SESSION["caret"][$curso_id]['exameclienteadp'] = 0;
                }
            }
            //curso
            else {
                $cur_date = new DateTime(date('Y-m-d'));
                $data_inicio  = new DateTime(date('Y-m-d', strtotime($row['DataInicio'])));
                $dDiff = $cur_date->diff($data_inicio);
                $dDiff->format('%R');
                if ($dDiff->days >= intval($row['diaspreco2'])) {
                    $_SESSION["caret"][$curso_id]['preco'] = $row['preco2'];
                }
                else {
                    $_SESSION["caret"][$curso_id]['preco'] = $row['preco'];
                }
                $_SESSION["caret"][$curso_id]['exameclienteadp'] = 0;
            }
        }
    }
}

header("Location: " . JURI::base() . "index.php/compras");
