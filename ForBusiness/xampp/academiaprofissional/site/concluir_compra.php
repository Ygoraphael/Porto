<?php
include_once 'db_config.php';

if (isset($_SESSION["caret"]) && sizeof($_SESSION["caret"])) {
    if (isset($_SESSION['empresa'])) {

        $query = $db->getQuery(true);
        $columns = array(
            'NomeEmpresa', 'Morada', 'CodigoPostal', 'Localidade', 'NIF', 'PessoaContacto', 'Email', 'Telemovel'
        );

        $values = array(
            $_SESSION['empresa']['NomeEmpresa'],
            $_SESSION['empresa']['Morada'],
            $_SESSION['empresa']['CodigoPostal'],
            $_SESSION['empresa']['Localidade'],
            $_SESSION['empresa']['NIF'],
            $_SESSION['empresa']['PessoaContacto'],
            $_SESSION['empresa']['Email'],
            $_SESSION['empresa']['Telemovel'],
        );
        $query->insert($db->quoteName('empresa'))->columns($db->quoteName($columns))->values(implode(',', $db->quote($values)));
        $db->setQuery($query);
        $db->execute();
        $empresa_id = $db->insertid();

        $empresa = $empresa_id;
    } else {
        $empresa = 0;
    }

    $total = 0;
    $total_qtd = 0;
    $desconto = 0;
    $total_qtd_curso = 0;
    $formandos_qtt = array();

    foreach ($_SESSION['caret'] as $id => $curso) {
        if (isset($_SESSION['empresa'])) {
            $qtd = count($curso['formando']);
            $valor = count($curso['formando']) * $curso['preco'];

            foreach ($curso['formando'] as $qfor) {
                if (array_key_exists($qfor['NIF'], $formandos_qtt)) {
                    if ($curso['tipologia'] == "curso")
                        $formandos_qtt[$qfor['NIF']] = $formandos_qtt[$qfor['NIF']] + 1;
                }
                else {
                    if ($curso['tipologia'] == "curso")
                        $formandos_qtt[$qfor['NIF']] = 1;
                }
            }
        } else {
            $valor = $curso['preco'];
            $qtd = 1;

            if (array_key_exists($_SESSION['caret_user']['NIF'], $formandos_qtt)) {
                if ($curso['tipologia'] == "curso")
                    $formandos_qtt[$_SESSION['caret_user']['NIF']] = $formandos_qtt[$_SESSION['caret_user']['NIF']] + 1;
            }
            else {
                if ($curso['tipologia'] == "curso")
                    $formandos_qtt[$_SESSION['caret_user']['NIF']] = 1;
            }
        }
        $total_qtd += $qtd;
        $total += $valor;
        if ($curso['tipologia'] == "curso")
            $total_qtd_curso += $qtd;
    }

    $formultiplecourse = 0;
    foreach ($formandos_qtt as $fq) {
        if ($fq > 1)
            $formultiplecourse = 1;
    }

    //if ($total_qtd_curso <= 1) {
    //    $desconto = 0;
    //} elseif ($formultiplecourse) {
    //    $desconto = $total - ($total * 0.80);
    //} elseif ($total_qtd_curso == 2) {
    //    $desconto = $total - ($total * 0.90);
    //} elseif ($total_qtd_curso >= 3) {
    //    $desconto = $total - ($total * 0.80);
    //}
    $desconto = 0;

    //cabecalho
    $query = $db->getQuery(true);
    $columns = array('data', 'baseincidencia', 'desconto', 'total', 'empresa');
    $values = array(
        $db->quote(date("Y-m-d H:i:s")),
        number_format($total, 2, ".", ""),
        number_format($desconto, 2, ".", ""),
        number_format(($total - $desconto) * 1.23, 2, ".", ""),
        $empresa
    );
    $query->insert($db->quoteName('inscricao'))->columns($db->quoteName($columns))->values(implode(',', $values));
    $db->setQuery($query);
    $db->execute();
    $inscricao_id = $db->insertid();

    //formandos
    //empresa
    if (isset($_SESSION['empresa'])) {
        $nif_tmp = array();
        foreach ($_SESSION['caret'] as $id => $inscricao) {
            foreach ($inscricao['formando'] as $formando) {
                if (!in_array(trim($formando["NIF"]), $nif_tmp)) {
                    $nif_tmp[] = trim($formando["NIF"]);

                    $query = $db->getQuery(true);
                    $columns = array(
                        'inscricao', 'NomeFormando', 'NIF', 'Email', 'Telemovel', 'DataNasc', 'Morada', 'CodigoPostal', 'Localidade', 'CartaoCidadao',
                        'Validade', 'nCartaConducao', 'LocalEmissao', 'DataEmissao', 'DataValidade', 'Categoria', 'DataRenovADR', 'DataRenovCAM', 'AcaoF', 'escolaridade'
                    );

                    $values = array(
                        $inscricao_id,
                        $formando['NomeFormando'],
                        $formando['NIF'],
                        $formando['Email'],
                        $formando['Telemovel'],
                        $formando['DataNasc'],
                        $formando['Morada'],
                        $formando['CodigoPostal'],
                        $formando['Localidade'],
                        $formando['CartaoCidadao'],
                        $formando['Validade'],
                        $formando['nCartaConducao'],
                        '',
                        $formando['DataEmissao'],
                        '',
                        '',
                        $formando['DataRenovADR'],
                        $formando['DataRenovCAM'],
                        '',
						$formando['escolaridade']
                    );
                    $query->insert($db->quoteName('formandos'))->columns($db->quoteName($columns))->values(implode(',', $db->quote($values)));
                    $db->setQuery($query);
                    $db->execute();
                    $formando_id = $db->insertid();
                }
            }
        }
    }
    //individual
    else {
        $query = $db->getQuery(true);
        $columns = array(
            'inscricao', 'NomeFormando', 'NIF', 'Email', 'Telemovel', 'DataNasc', 'Morada', 'CodigoPostal', 'Localidade', 'CartaoCidadao',
            'Validade', 'nCartaConducao', 'LocalEmissao', 'DataEmissao', 'DataValidade', 'Categoria', 'DataRenovADR', 'DataRenovCAM', 'AcaoF', 'escolaridade'
        );

        $values = array(
            $inscricao_id,
            $_SESSION['caret_user']['NomeFormando'],
            $_SESSION['caret_user']['NIF'],
            $_SESSION['caret_user']['Email'],
            $_SESSION['caret_user']['Telemovel'],
            $_SESSION['caret_user']['DataNasc'],
            $_SESSION['caret_user']['Morada'],
            $_SESSION['caret_user']['CodigoPostal'],
            '',
            $_SESSION['caret_user']['CartaoCidadao'],
            $_SESSION['caret_user']['Validade'],
            $_SESSION['caret_user']['nCartaConducao'],
            '',
            $_SESSION['caret_user']['DataEmissao'],
            '',
            '',
            $_SESSION['caret_user']['DataRenovADR'],
            $_SESSION['caret_user']['DataRenovCAM'],
            '',
			$_SESSION['caret_user']['escolaridade']
        );
        $query->insert($db->quoteName('formandos'))->columns($db->quoteName($columns))->values(implode(',', $db->quote($values)));
        $db->setQuery($query);
        $db->execute();
        $formando_id = $db->insertid();
    }

    //linhas
    if (isset($_SESSION['empresa'])) {
        foreach ($_SESSION['caret'] as $id => $inscricao) {
            foreach ($inscricao['formando'] as $formando) {
                //get formando
                $query = $db->getQuery(true);
                $query->select("*");
                $query->from($db->quoteName('formandos'));
                $query->where($db->quoteName('NIF') . ' = ' . $db->quote($formando["NIF"]));
                $query->where($db->quoteName('inscricao') . ' = ' . $db->quote($inscricao_id));
                $db->setQuery($query);
                $results = $db->loadAssocList();

                if (count($results)) {
                    foreach ($results as $row) {
                        $formando_id = $row["ID"];
                    }
                }

                $valor = $inscricao['preco'];
                $acao = $inscricao['acao'];
                $curso = $inscricao['cc'];
                $formando = $formando_id;
                $formacaoadp = $inscricao['exameclienteadp'];

                $query = $db->getQuery(true);
                $columns = array(
                    'inscricao', 'formando', 'curso', 'acao', 'preco', 'formacaoadp'
                );

                $values = array(
                    $inscricao_id,
                    $formando,
                    $curso,
                    $acao,
                    $valor,
                    $formacaoadp
                );
                $query->insert($db->quoteName('inscricao_linha'))->columns($db->quoteName($columns))->values(implode(',', $db->quote($values)));
                $db->setQuery($query);
                $db->execute();
            }
        }
    } else {
        foreach ($_SESSION['caret'] as $id => $inscricao) {
            $valor = $inscricao['preco'];
            $acao = $inscricao['acao'];
            $curso = $inscricao['cc'];
            $formando = $formando_id;
            $formacaoadp = $inscricao['exameclienteadp'];

            $query = $db->getQuery(true);
            $columns = array(
                'inscricao', 'formando', 'curso', 'acao', 'preco', 'formacaoadp'
            );

            $values = array(
                $inscricao_id,
                $formando,
                $curso,
                $acao,
                $valor,
                $formacaoadp
            );
            $query->insert($db->quoteName('inscricao_linha'))->columns($db->quoteName($columns))->values(implode(',', $db->quote($values)));
            $db->setQuery($query);
            $db->execute();
        }
    }

    //emails
    if (isset($_SESSION['empresa'])) {
        //email empresa
        EnviarEmailInscricaoEmpresa($inscricao_id);
        //email adp
        EnviarEmailInscricaoAcademia($inscricao_id, 'empresa');
        //email formandos
        $nif_tmp = array();
        foreach ($inscricao['formando'] as $formando) {
            if (!in_array(trim($formando["NIF"]), $nif_tmp)) {
                $nif_tmp[] = trim($formando["NIF"]);

                $query = $db->getQuery(true);
                $query->select("ID");
                $query->from($db->quoteName('formandos'));
                $query->where($db->quoteName('NIF') . ' = ' . $db->quote($formando["NIF"]));
                $query->where($db->quoteName('inscricao') . ' = ' . $db->quote($inscricao_id));
                $db->setQuery($query);
                $results = $db->loadAssocList();

                if (count($results)) {
                    foreach ($results as $row) {
                        $formando_id = $row["ID"];
                        EnviarEmailInscricaoFormando($inscricao_id, $formando_id);
                    }
                }
            }
        }
    } else {
        //email empresa/formando
        EnviarEmailInscricaoEmpresaFormando($inscricao_id);
        //email adp
        EnviarEmailInscricaoAcademia($inscricao_id, 'individual');
    }

    //limpar dados da sessao
    limpar_sessao();
?>

<div class="container">
    <div class="span12"></div>
    <div class="span6 offset3">
        <h3><i class="icon-shopping-cart"></i> Concluído</h3>
        <div class="span12 alert alert-block alert-success"
             style="border-radius: 3px; border:1px dotted #ccc; padding: 30px;">
            <div class="page-section text-center">
                <div class="panel"></div>
                <h4>Inscrição finalizada com sucesso!</h4><br>
                <p>Você receberá um email com detalhes de sua inscrição!</p>
                <p>Obrigado!</p>
                <p>
                    <br>
                    <a href="<?= JURI::base() ?>" class="btn btn-warning">Voltar</a>
                    <br>
                </p>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
</div>
<div class="clearfix"></div>
<div class="span12">
</div>
<?php
}
else {
?>
<div class="container">
    <div class="span12"></div>
    <div class="span6 offset3">
        <div class="span12 alert alert-block alert-danger" style="border-radius: 3px; border:1px dotted #ccc; padding: 30px;">
            <div class="page-section text-center">
                <div class="panel"></div>
                <h4>A sua sessão expirou!</h4><br>
                <p>Inicie a compra novamente por favor.</p>
                <p>Obrigado!</p>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
</div>
<div class="clearfix"></div>
<div class="span12">
</div>
<?php
}
?>