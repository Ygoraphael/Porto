<?php

include 'db_config.php';

$query = $db->getQuery(true);
$conditions = array(
    $db->quoteName('ID') . ' = ' . $db->quote($_POST['acao'])
);
$query->delete($db->quoteName('acoes'));
$query->where($conditions);
$db->setQuery($query);
$result = $db->execute();

if ($result) {
    $_SESSION['msg']['type'] = 'alert-success';
    $_SESSION['msg']['msg'] = "Ação apagada com sucesso!";
} else {
    $_SESSION['msg']['type'] = 'alert-danger';
    $_SESSION['msg']['msg'] = "Não foi possivel apagar a ação";
}
?>