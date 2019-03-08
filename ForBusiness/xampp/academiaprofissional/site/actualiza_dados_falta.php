<?php
include_once 'db_config.php';

$db = JFactory::getDbo();
$query = $db->getQuery(true);
$fields = array();

$fields_formandos = array('ID', 'empresa', 'NomeFormando', 'DataNasc', 'Morada', 'CodigoPostal', 'Localidade', 'Email', 'Telemovel', 'CartaoCidadao', 'Validade', 'nCartaConducao', 'LocalEmissao', 'DataEmissao', 'DataValidade', 'Categoria', 'NIF', 'DataRenovADR', 'DataRenovCAM', 'AcaoF', 'escolaridade');

foreach ($_POST as $key => $value) {
    if (in_array($key, $fields_formandos)) {
        $fields[] = $db->quoteName($key) . ' = ' . $db->quote($db->escape($value));
    }
}
$conditions = array(
    $db->quoteName('ID') . ' = ' . $db->quote($_POST['ID'])
);
$query->update($db->quoteName('formandos'))->set($fields)->where($conditions);
$db->setQuery($query);
$result = $db->execute();

if ($result) {
    EnviarEmailDadosFaltaAcademia($_POST['ID']);
    EnviarEmailDadosFaltaFormando($_POST['ID']);
    ?>
    <div class="row" style="min-height:150px;height:150px">
        <h1 style="text-align: center;"><br><br>Parabéns, os dados foram submetidos com sucesso</h1>
    </div>
    <?php
} else {
    ?>
    <h1 style="text-align: center;"><br><br>Lamentamos, mas não foi possível atualizar os dados</h1>
    <?php
}
