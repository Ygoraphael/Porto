<?php

//require_once '.../.../.../site/db_config.php';
$query = '';
foreach ($_POST as $key => $value) {
    $vir = ', ';
    if (end($_POST) == $value) {
        $vir = '';
    }
    $query .= $key . '=' . "'" . $value . "'" . $vir;
}
$sql = 'UPDATE cursos SET ' . $query . ' WHERE CC=' . "'" . $_POST['CC'] . "'";

if ($conn->query($sql) === TRUE) {
    $_SESSION['msg']['type'] = 'alert-success';
    $_SESSION['msg']['msg'] = "Curso atualizado com sucesso!";
} else {
    $_SESSION['msg']['type'] = 'alert-danger';
    $_SESSION['msg']['msg'] = "Não foi possivel atualizar esse curso";
}
$conn->close();
