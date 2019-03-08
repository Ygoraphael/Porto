<?php
include 'db_config.php';
$curso = $_POST['curso'];

$query = $db->getQuery(true);
$query->select("*");
$query->from($db->quoteName('cursos'));
$query->where($db->quoteName('CC') . ' = ' . $db->quote($curso));
$db->setQuery($query);
$results = $db->loadAssocList();

foreach ($results as $row) {
    ?>
    <form id='form-edit-curso' novalidate>
        <div class="span12">
            <span>Código</span><br>
            <input type="text" disabled class="input-large" style="width: 100%;" value="<?= repStr($row["CC"]); ?>">
            <input type="hidden" name="CC" class="input-large" style="width: 100%;" value="<?= repStr($row["CC"]); ?>">
        </div>
        <div class="span12">
            <span>Valor</span><br>
            <textarea class="tinyedit" name="Preco" cols="70" rows="4" wrap="soft" required=""><?= repStr($row["Preco"]); ?></textarea>
        </div>
        <div class="span12">
            <span>Nome do Curso</span><br>
            <textarea class="tinyedit" name="NomeCurso" cols="70" rows="4" wrap="soft" required=""><?= repStr($row["NomeCurso"]); ?></textarea>
        </div>
        <div class="span12">
            <span>Public Alvo</span><br>
            <textarea class="tinyedit" class="tinyedit" name="PublicoTarget" cols="70" rows="4" wrap="soft" required=""><?= repStr($row["PublicoTarget"]); ?></textarea>
        </div>
        <div class="span12">
            <span>Conteudo</span><br>
            <textarea class="tinyedit" name="Conteudos" cols="70" rows="4" wrap="soft" required=""><?= repStr($row["Conteudos"]); ?></textarea>
        </div>
        <div class="span12">
            <span>Objetivo</span><br>
            <textarea class="tinyedit" name="Objectivos" cols="70" rows="4" wrap="soft" required=""><?= repStr($row["Objectivos"]); ?></textarea>
        </div>
        <div class="span12">
            <span>Contexto</span><br>
            <textarea class="tinyedit" name="Contexto" cols="70" rows="4" wrap="soft" required=""><?= repStr($row["Contexto"]); ?></textarea>
        </div>
        <div class="span12" >
            <span>Acreditações</span><br>
            <textarea class="tinyedit" name="acreditacoes" cols="70" rows="4" wrap="soft" required=""><?= repStr($row["acreditacoes"]); ?></textarea>
        </div>
        <div class="span12">
            <span>Info</span><br>
            <textarea class="tinyedit" name="Info" cols="70" rows="4" wrap="soft" required=""><?= repStr($row["Info"]); ?></textarea>
        </div>
        <div class="span12">
            <span>Requisitos</span><br>
            <textarea class="tinyedit" name="requisitos" cols="70" rows="4" wrap="soft" required=""><?= repStr($row["requisitos"]); ?></textarea>
        </div>
        <div class="span12">
            <span>Nova Aba</span><br>
            <input type="text" name="aba_nome" placeholder="Nome da Aba" style="width:30%" value="<?= repStr($row["aba_nome"]); ?>">
            <input id="e_visible" type="checkbox" name="aba_visivel" <?php if(repStr($row["aba_visivel"])=='1'){echo 'checked';}else{echo '';} ?> > Aba Visível<br><br>
            <textarea class="tinyedit" name="aba_descricao" cols="70" rows="4" wrap="soft" required=""><?= repStr($row["aba_descricao"]); ?></textarea>
        </div>
    </form>
    <div class="clearfix"></div><br>
    <div class="span12">
        <button type="button" class="btn-xs btn-danger btn-delete-curso" id="<?= repStr($row["CC"]) ?>"><i class="icon-trash"></i> Apagar</button>
    </div><br><br>
<?php } ?>
