<?php
include 'db_config.php';

$acao = $_POST['acao'];

$query = $db->getQuery(true);
$query->select("*");
$query->from($db->quoteName('acoes'));
$query->where($db->quoteName('ID') . ' = ' . $db->quote($acao));
$db->setQuery($query);
$results = $db->loadAssocList();

foreach ($results as $row) {
    ?>
    <form id='form-edit-acao'>
        <div class="span12">
            <span>Curso / Tipo Exame</span><br>
            <input type="text" name="NomeAcao" disabled="" class=" input-large" style="width: 100%;" value="<?= $row["NomeAcao"]; ?>">
            <input type="hidden" name="ID" class=" input-large" style="width: 100%;" value="<?= $row["ID"]; ?>">
        </div>
        <div class="span12">
            <span>Exame Online?</span><br>
            <select name="exame" class=" input-large" style="width: 100%;" >
                <option value="0" <?= (($row["exame"]) ? "" : "selected"); ?>>Não</option>
                <option value="1" <?= (($row["exame"]) ? "selected" : ""); ?>>Sim</option>
            </select>
        </div>
        <div class="span12">
            <span>Código Interno</span><br>
            <input type="text" name="CodigoInterno" class="input-large" style="width: 100%;" value="<?= $row["CodigoInterno"]; ?>">
        </div>
        <div class="span4">
            <span>Início</span><br>
            <input type="date" name="DataInicio" class="input-large" style="width: 100%;" value="<?= $row["DataInicio"]; ?>">
        </div>
        <div class="span4">
            <span>Fim</span><br>
            <input type="date" name="DataFim" class="input-large" style="width: 100%;" value="<?= $row["DataFim"]; ?>">
        </div>
        <div class="span4">
            <span>Sessões / Nº Testes</span><br>
            <input type="text" name="Sessoes" class="input-large" style="width: 100%;" value="<?= $row["Sessoes"]; ?>">
        </div>
        <div class="span6">
            <span>Preço</span><br>
            <input type="text" name="preco" class="input-large" style="width: 100%;" value="<?= $row["preco"]; ?>">
        </div>
        <div class="span6">
            <span>Preço 2</span><br>
            <input type="number" name="preco2" class="input-large" style="width: 100%;" value="<?= $row["preco2"]; ?>">
        </div>
        <div class="span6">
            <span>Nº Dias Preço 2</span><br>
            <input type="number" name="diaspreco2" class="input-large" style="width: 100%;" value="<?= $row["diaspreco2"]; ?>">
        </div>
        <div class="span12">
            <span>Formato / Nº Total Questões</span><br>
            <textarea class="tinyedit" name="Formato" cols="70" rows="4" wrap="soft" required=""><?= repStr($row["Formato"]); ?></textarea>
        </div>
        <div class="span12">
            <span>Cronograma</span><br>
            <textarea class="tinyedit" name="Horario" cols="70" rows="4" wrap="soft" required=""><?= repStr($row["Horario"]); ?></textarea>
        </div>
        <div class="span12">
            <span>Localidade</span><br>
            <input type="text" name="Localidade" class="input-large" style="width: 100%;" value="<?= $row["Localidade"]; ?>">
        </div>
        <div class="span12">
            <span>Morada</span><br>
            <textarea class="tinyedit" name="Morada" cols="70" rows="4" wrap="soft" required=""><?= repStr($row["Morada"]); ?></textarea>
        </div>
        <div class="span12">
            <span>Info / Vantagens</span><br>
            <textarea class="tinyedit" name="Info" cols="70" rows="4" wrap="soft" required=""><?= repStr($row["Info"]); ?></textarea>
        </div>
    </form>
    <div class="clearfix"></div><br>
    <div class="span12">
        <button type="button" class="btn-xs btn-danger btn-delete-acao" id="<?= $row["ID"] ?>"><i class="icon-trash"></i> Apagar</button>
    </div><br><br>
    <?php
}
?>