<?php

include_once 'db_config.php';

$db = JFactory::getDbo();
$query = $db->getQuery(true);
$fields = array();

$fields_cursos = array('DataInicio', 'DataFim', 'Sessoes', 'Horario', 'Localidade', 'Morada', 'Info', 'preco', 'Formato', 'CodigoInterno', 'exame', 'preco2', 'diaspreco2');

foreach ($_POST as $key => $value) {
    if (in_array($key, $fields_cursos)) {
        $fields[] = $db->quoteName($key) . ' = ' . $db->quote($db->escape($value));
    }
}
$conditions = array(
    $db->quoteName('ID') . ' = ' . $db->quote($_POST['ID'])
);
$query->update($db->quoteName('acoes'))->set($fields)->where($conditions);
$db->setQuery($query);

$result = $db->execute();

if ($result) {
    $_SESSION['msg']['type'] = 'alert-success';
    $_SESSION['msg']['msg'] = "Ação atualizada com sucesso!";
} else {
    $_SESSION['msg']['type'] = 'alert-danger';
    $_SESSION['msg']['msg'] = "Não foi possivel atualizar a ação";
}