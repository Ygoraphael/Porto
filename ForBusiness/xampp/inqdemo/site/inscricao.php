<?php
include 'db_config.php';
session_start();
$teste2 = $_POST['name'];
$edesta = $_POST['edesta'];
$_SESSION['acao'] = $_POST['acao'];

$acao = $_SESSION['acao'];
$sql = "SELECT * FROM acoes WHERE id = $acao";
$retval = $conn->query($sql);
if ($retval->num_rows > 0) {
    while ($row = $retval->fetch_row()) {
        $sql = "SELECT * FROM acoes WHERE NomeAcao = '$edesta'";
        $curso = $conn->query($sql);
        while ($row_c = $curso->fetch_row()) {
            $_SESSION['curso_corrente']['acao'] = $_POST['acao'];
            $_SESSION['curso_corrente']['id'] = $row_c[0];
            $_SESSION['curso_corrente']['nome'] = $row_c[1];
            $_SESSION['caret'][$row_c[0]]['nome'] = $row_c[1];
            $_SESSION['caret'][$row_c[0]]['acao'] = $acao;
            $_SESSION['caret'][$row_c[0]]['preco'] = $row_c[11];
        }
    }
}
if (!isset($_SESSION['type'])) {
    ?>
    <h4>Está a inscrever-se no curso de <?php echo $_SESSION['curso_corrente']['nome'] ?></h4>
    <div class="container text-center">
        <h3 class="headingTop">Selecione a opção:</h3>
        <form action='index.php?option=com_jumi&view=application&fileid=6' method="post">
            <input type="hidden" name="name" value="<?php echo $_SESSION['curso_corrente']['nome']; ?>">
            <input type="hidden" name="curso" value="<?php echo $_SESSION['curso_corrente']['id']; ?>">
            <input type="hidden" name="type" value="individual">
            <input type="submit" name="submit"  class="btn btn-success" value="Inscrição Individual">
        </form>
        <form action='index.php?option=com_jumi&view=application&fileid=7' method="post">
            <input type="hidden" name="name" value="<?php echo$_SESSION['curso_corrente']['nome']; ?>">
            <input type="hidden" name="curso" value="<?php echo $_SESSION['curso_corrente']['id']; ?>">
            <input type="hidden" name="type" value="empresa">
            <input type="submit" name="submit" class="btn btn-warning" value="Inscrição Empresa">
        </form>
        <a href="javascript:window.history.go(-1)" class="btn btn-success pull-left btn-fyi">Voltar</a>
        <span class="glyphicon glyphicon-chevron-left"></span>
    </div>
    <?php
} elseif ($_SESSION['type'] == 'empresa') {
    header("Location: http://{$_SERVER['HTTP_HOST']}/inqdemo/index.php/inserir-formando");
} else {
    unset($_SESSION['empresa']);
    header("Location: http://{$_SERVER['HTTP_HOST']}/inqdemo/index.php/compras");
}