<?php
include 'db_config.php';

$CC = $db->escape($_POST['CC']);
$Contexto = $db->escape($_POST['Contexto']);
$Info = $db->escape($_POST['Info']);
$NomeCurso = $db->escape($_POST['NomeCurso']);
$Objectivos = $db->escape($_POST['Objectivos']);
$Preco = $db->escape($_POST['Preco']);
$PublicoTarget = $db->escape($_POST['PublicoTarget']);
$Conteudos = $db->escape($_POST['Conteudos']);
$acreditacoes = $db->escape($_POST['acreditacoes']);
$requisitos = $db->escape($_POST['requisitos']);
$aba_nome = $db->escape($_POST['aba_nome']);
$aba_visivel=0;

if (isset($_POST['aba_visivel'])) {
    
    $aba_visivel = 1;

} else {
   $aba_visivel = 0;
}

$aba_descricao = $db->escape($_POST['aba_descricao']);

$db = JFactory::getDbo();
$query = $db->getQuery(true);
$columns = array('CC', 'Contexto', 'Info', 'NomeCurso', 'Objectivos', 'Preco', 'PublicoTarget', 'Conteudos', 'acreditacoes', 'requisitos', 'aba_nome', 'aba_visivel', 'aba_descricao');
$values = array($db->quote($CC), $db->quote($Contexto), $db->quote($Info), $db->quote($NomeCurso), $db->quote($Objectivos), $db->quote($Preco), $db->quote($PublicoTarget), $db->quote($Conteudos), $db->quote($acreditacoes), $db->quote($requisitos), $db->quote($aba_nome),$db->quote($aba_visivel), $db->quote($aba_descricao));
$query->insert($db->quoteName('cursos'))->columns($db->quoteName($columns))->values(implode(',', $values));
$db->setQuery($query);
$result = $db->execute();

if ($result) {

    echo "
    <div style='width:50%; margin: 0 auto; text-align:center;'>
    <span style='font-size:20px;'>Curso adicionado com sucesso</span><br><br>
      </div>
    ";
?>
<div style='width:50%; margin: 0 auto; text-align:center;'>
<span class='btn btn-default'>
<a href="<?= JURI::base(); ?>index.php/adminitracao-de-cursos" style='color:white; text-decoration:none'>Voltar</a>
</span>
</div>

<?php
}
?>