<style>
    .completa{
        width: 100%;
    }
</style>
<?php
include 'db_config.php';

if (isset($_GET["hs"])) {
    $query = $db->getQuery(true);
    $query->select('*');
    $query->from($db->quoteName('formandos'));
    $query->where($db->quoteName('ID') . ' = ' . $db->quote(adpcrypt($_GET["hs"], 'd')));

    $db->setQuery($query);
    $result = $db->loadAssocList();
}

if (!empty($result)) {
    foreach ($result as $row):
        ?>
        <h1 style="text-align:center; margin-top:50px;">Complete os dados em falta</h1>

        <form method="post" action="<?= JURI::base() ?>index.php/dados-em-falta-conclusao">
            <div class="flex-container">
                <div class="flex-item">
                    <input type="hidden" name="ID" value="<?php echo $row['ID']; ?>"/>
                    <span class="span12" >Nome do formando
                        <br>
                        <input class="completa" type="text" <?php echo ($row['NomeFormando'] == "" ? "name='NomeFormando'" : ""); ?> value="<?php echo $row['NomeFormando']; ?>" required><br><br>
                    </span>
                    <span class="span12">Data de Nascimento
                        <br>
                        <input class="completa" type="date" <?php echo (($row['DataNasc'] == "" || $row['DataNasc'] == "0000-00-00") ? "name='DataNasc'" : ""); ?> value="<?php echo $row['DataNasc']; ?>" required><br><br>
                    </span>
					<span class="span12">Escolaridade
                        <br>
						<select style="margin-bottom:15px" class="completa" <?php echo ($row['escolaridade'] == "" ? "name='escolaridade'" : ""); ?> required>
							<option <?= ($row['escolaridade'] == "") ? "selected" : "" ?> value=""></option>
							<option <?= ($row['escolaridade'] == "4º Ano") ? "selected" : "" ?> value="4º Ano">4º Ano</option>
							<option <?= ($row['escolaridade'] == "6º Ano") ? "selected" : "" ?> value="6º Ano">6º Ano</option>
							<option <?= ($row['escolaridade'] == "Secundário") ? "selected" : "" ?> value="Secundário">Secundário</option>
							<option <?= ($row['escolaridade'] == "Bacharelado") ? "selected" : "" ?> value="Bacharelado">Bacharelado</option>
							<option <?= ($row['escolaridade'] == "Licenciatura") ? "selected" : "" ?> value="Licenciatura">Licenciatura</option>
							<option <?= ($row['escolaridade'] == "Mestrado") ? "selected" : "" ?> value="Mestrado">Mestrado</option>
						</select>
                    </span>
                    <span class="span12">Morada
                        <br>
                        <input class="completa" type="text" <?php echo ($row['Morada'] == "" ? "name='Morada'" : ""); ?> value="<?php echo $row['Morada']; ?>" required><br><br>
                    </span>
                    <span class="span12">Código Postal
                        <br>
                        <input class="completa" type="text" <?php echo ($row['CodigoPostal'] == "" ? "name='CodigoPostal'" : ""); ?> value="<?php echo $row['CodigoPostal']; ?>" required><br><br>
                    </span>
                    <span class="span12">Localidade
                        <br>
                        <input class="completa" type="text" <?php echo ($row['Localidade'] == "" ? "name='Localidade'" : ""); ?> value="<?php echo $row['Localidade']; ?>" required><br><br>
                    </span>
                    <span class="span12">Email
                        <br>
                        <input class="completa" type="email" <?php echo ($row['Email'] == "" ? "name='Email'" : ""); ?> value="<?php echo $row['Email']; ?>" required><br><br>
                    </span>
                    <span class="span12">Telemóvel
                        <br>
                        <input class="completa" type="text" <?php echo ($row['Telemovel'] == "" ? "name='Telemovel'" : ""); ?> value="<?php echo $row['Telemovel']; ?>" required><br><br>
                    </span>
                    <span class="span12">Cartao do Cidadão
                        <br>
                        <input class="completa" type="text" <?php echo ($row['CartaoCidadao'] == "" ? "name='CartaoCidadao'" : ""); ?> value="<?php echo $row['CartaoCidadao']; ?>" required><br><br>
                    </span>
                    <span class="span12">Validade do Cartão do Cidadão
                        <br>
                        <input class="completa" type="date" <?php echo (($row['Validade'] == "" || $row['Validade'] == "0000-00-00") ? "name='Validade'" : ""); ?> value="<?php echo $row['Validade']; ?>" required><br><br>
                    </span>
                </div>
                <div class="flex-item">
                    <span class="span12">Carta de Condução
                        <br>
                        <input class="completa" type="text" <?php echo ($row['nCartaConducao'] == "" ? "name='nCartaConducao'" : ""); ?> value="<?php echo $row['nCartaConducao']; ?>" required><br><br>
                    </span>

                    <span class="span12">Local de Emissão
                        <br>
                        <input class="completa" type="text" <?php echo ($row['LocalEmissao'] == "" ? "name='LocalEmissao'" : ""); ?> value="<?php echo $row['LocalEmissao']; ?>" required><br><br>
                    </span>
                    <span class="span12">Data de Emissão
                        <br>
                        <input class="completa" type="date" <?php echo (($row['DataEmissao'] == "" || $row['DataEmissao'] == "0000-00-00") ? "name='DataEmissao'" : ""); ?> value="<?php echo $row['DataEmissao']; ?>" required><br><br>
                    </span>
                    <span class="span12">Data de Validade
                        <br>
                        <input class="completa" type="date" <?php echo (($row['DataValidade'] == "" || $row['DataValidade'] == "0000-00-00") ? "name='DataValidade'" : ""); ?> value="<?php echo $row['DataValidade']; ?>" required><br><br>
                    </span>
                    <span class="span12">Categoria da Carta de Condução
                        <br>
                        <input class="completa" type="text" <?php echo ($row['Categoria'] == "" ? "name='Categoria'" : ""); ?> value="<?php echo $row['Categoria']; ?>" required><br><br>
                    </span>
                    <span class="span12">NIF
                        <br>
                        <input class="completa" type="text" <?php echo ($row['NIF'] == "" ? "name='NIF'" : ""); ?> value="<?php echo $row['NIF']; ?>" required><br><br>
                    </span>
                    <span class="span12">Data de Renovação ADR
                        <br>
                        <input class="completa" type="date" <?php echo (($row['DataRenovADR'] == "" || $row['DataRenovADR'] == "0000-00-00") ? "name='DataRenovADR'" : ""); ?> value="<?php echo $row['DataRenovADR']; ?>" required><br><br>
                    </span>
                    <span class="span12">Data de Renovação CAM
                        <br>
                        <input class="completa" type="date" <?php echo (($row['DataRenovCAM'] == "" || $row['DataRenovCAM'] == "0000-00-00") ? "name='DataRenovCAM'" : ""); ?> value="<?php echo $row['DataRenovCAM']; ?>" required><br><br>
                    </span>
                    <input type="submit" class="btn btn-default" value="Gravar" id="<?php $row['ID']; ?>">
                </div>
            </div>
        </form>
        <?php
    endforeach;
}
?>

<script>
    jQuery(document).ready(function () {
        jQuery(".completa").each(function (i) {
            if (jQuery(this).val() !== '') {
                jQuery(this).prop('disabled', true);
            } else {
                jQuery(this).prop('disabled', false);
            }
        });
    });
</script>
