<?php
include 'db_config.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$acao = $_POST['acao'];

$query = $db->getQuery(true);
$query->select("*");
$query->from($db->quoteName('acoes'));
$query->where($db->quoteName('ID') . ' = ' . $db->quote($acao));
$db->setQuery($query);
$results = $db->loadAssocList();

if (count($results)) {
    foreach ($results as $row) {
        $_SESSION['curso_corrente']['id'] = $row["ID"];
        $_SESSION['curso_corrente']['nome'] = $row["NomeAcao"];

        if(isset($_POST['exameclienteadp'])) {
            $_SESSION['curso_corrente']['exameclienteadp'] = $_POST['exameclienteadp'];
        }
        else {
            $_SESSION['curso_corrente']['exameclienteadp'] = 0;
        }
    }
}

if (!isset($_SESSION['type'])) {
    ?>
    <h4>Está a inscrever-se no curso de <?php echo $_SESSION['curso_corrente']['nome'] ?></h4>
    <div class="container text-center">
        <h3 class="headingTop">Selecione a opção:</h3>
        <form action='<?= JURI::base(); ?>index.php/inscricao-individual' method="post">
            <input type="hidden" name="type" value="individual">
            <input type="submit" name="submit"  class="btn btn-success" value="Inscrição Individual" style="min-width:250px">
        </form>
        <form action='<?= JURI::base(); ?>index.php/inscricao-empresa' method="post">
            <input type="hidden" name="type" value="empresa">
            <input type="submit" name="submit" class="btn btn-warning" value="Inscrição Empresa" style="min-width:250px">
        </form>
        <a href="javascript:window.history.go(-1)" class="btn btn-success pull-left btn-fyi">Voltar</a>
        <span class="glyphicon glyphicon-chevron-left"></span>
    </div>
    <?php
} elseif ($_SESSION['type'] == 'empresa') {
    header("Location: " . JURI::base() . "index.php/inserir-formando");
} else {
    unset($_SESSION['empresa']);
    header("Location: " . JURI::base() . "index.php/finalizar-inscricao");
}