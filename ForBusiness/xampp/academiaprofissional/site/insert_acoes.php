<?php
include 'db_config.php';

$RefCurso = $db->escape($_POST['RefCurso']);
$exame = $db->escape($_POST['exame']);
$NomeAcao = $db->escape($_POST['NomeAcao']);
$DataInicio = $db->escape($_POST['DataInicio']);
$DataFim = $db->escape($_POST['DataFim']);
$Sessoes = $db->escape($_POST['Sessoes']);
$Horario = $db->escape($_POST['Horario']);
$Localidade = $db->escape($_POST['Localidade']);
$Morada = $db->escape($_POST['Morada']);
$Formato = $db->escape($_POST['Formato']);
$Info = $db->escape($_POST['Info']);
$Preco = $db->escape($_POST['preco']);
$CodigoInterno = $db->escape($_POST['CodigoInterno']);
$Preco2 = $db->escape($_POST['preco2']);
$DiasPreco2 = $db->escape($_POST['diaspreco2']);

$db = JFactory::getDbo();
$query = $db->getQuery(true);
$columns = array('RefCurso', 'NomeAcao', 'DataInicio', 'DataFim', 'Sessoes', 'Horario', 'Localidade', 'Morada', 'Formato', 'Info', 'preco', 'CodigoInterno', 'exame', 'preco2', 'diaspreco2');
$values = array(
    $db->quote($RefCurso), $db->quote($NomeAcao), $db->quote($DataInicio),
    $db->quote($DataFim), $db->quote($Sessoes), $db->quote($Horario),
    $db->quote($Localidade), $db->quote($Morada), $db->quote($Formato),
    $db->quote($Info), $db->quote($Preco), $db->quote($CodigoInterno),
    $db->quote($exame), $db->quote($Preco2), $db->quote($DiasPreco2)
);
$query->insert($db->quoteName('acoes'))->columns($db->quoteName($columns))->values(implode(',', $values));
$db->setQuery($query);
$result = $db->execute();

if ($result) {
    echo "
    <div style='width:50%; margin: 0 auto; text-align:center;'>
    <span style='font-size:20px;'>Ação adicionada com sucesso</span><br><br>
      </div>
    ";
?>
<div style='width:50%; margin: 0 auto; text-align:center;'>
<span class='btn btn-default'>
<a href="<?= JURI::base(); ?>index.php/listar-acoes" style='color:white; text-decoration:none'>Voltar</a>
</span>
</div>

<?php
}
?>
