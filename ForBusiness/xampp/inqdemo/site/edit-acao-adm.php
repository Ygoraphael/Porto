<?php
include 'db_config.php';
$id = $_POST['acao'];
$sql = "SELECT * FROM acoes WHERE ID=$id";
$retval = $conn->query($sql);
if ($retval->num_rows > 0) {
    while ($row_acao = $retval->fetch_row()) {
        $acao = $row_acao;
        // $sql = "SELECT * FROM cursos WHERE CC = '$row_curso[9]'";
        //  $curso = $conn->query($sql);
        //while ($row_c = $curso->fetch_row()) {
        // }
    }
}
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<form id='form-edit-acao'>
    <div class="span12">
        <span>Nome Acão</span><br>
        <input type="text" name="NomeAcao"  disabled="" class=" input-large" style="width: 100%;" value="<?= $acao[1]; ?>">
         <input type="hidden" name="ID"  class=" input-large" style="width: 100%;" value="<?= $acao[0]; ?>">
    </div>
    <div class="span4">
        <span>Início</span><br>
        <input type="date"  name="DataInicio"   class="input-large" style="width: 100%;" value="<?= $acao[2]; ?>">
    </div>
    <div class="span4">
        <span>Fim</span><br>
        <input type="date"  name="DataFim"   class="input-large" style="width: 100%;" value="<?= $acao[3]; ?>">
    </div>
    <div class="span4">
        <span>Sessões</span><br>
        <input type="text"  name="Sessoes"   class="input-large" style="width: 100%;" value="<?= $acao[4]; ?>">
    </div>
    <div class="span12">
        <span>Horario</span><br>
        <input type="text"   name="Horario"  class="input-large" style="width: 100%;"  value="<?= $acao[6]; ?>">
    </div>
    <div class="span12">
        <span>Localidade</span><br>
        <input type="text" name="Localidade"  class="input-large" style="width: 100%;"  value="<?= $acao[7]; ?>">
    </div>
    <div class="span12">
        <span>Morada</span><br>
        <input type="text" name="Morada"  class="input-large" style="width: 100%;"  value="<?= $acao[8]; ?>">
    </div>
    <div class="span12">
        <span>Info</span><br>
        <textarea rows="4" name="Info"  style='width: 100%;'><?= $acao[5]; ?></textarea>
    </div>
</form>
<div class="clearfix"></div>
<br><br>
<div class="span12">
    <button type="button" class="btn-xs btn-danger btn-delete-acao" id="<?= $acao[0] ?>"><i class="icon-trash"></i> deletar</button>
</div>