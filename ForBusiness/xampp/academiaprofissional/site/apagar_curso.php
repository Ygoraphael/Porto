<?php

include 'db_config.php';

$query = $db->getQuery(true);
$conditions = array(
    $db->quoteName('CC') . ' = ' . $db->quote($_POST['CC'])
);
$query->delete($db->quoteName('cursos'));
$query->where($conditions);
$db->setQuery($query);
$result = $db->execute();

if ($result) {
    $query = $db->getQuery(true);
    $conditions = array(
        $db->quoteName('RefCurso') . ' = ' . $db->quote($_POST['CC'])
    );
    $query->delete($db->quoteName('acoes'));
    $query->where($conditions);
    $db->setQuery($query);
    $result = $db->execute();

    if ($result) {
        $_SESSION['msg']['type'] = 'alert-success';
        $_SESSION['msg']['msg'] = "Curso apagado com sucesso!";
    } else {
        $_SESSION['msg']['type'] = 'alert-danger';
        $_SESSION['msg']['msg'] = "Não foi possivel apagar o curso";
    }
}