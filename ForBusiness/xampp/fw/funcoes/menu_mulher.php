<?php
$lang = JFactory::getLanguage();
$db = JFactory::getDbo();

$query = $db->getQuery(true);
$query->select("DISTINCT Modalidade");
$query->from($db->quoteName('#__fastseller_product_type_4', 'fs4'));
$query->where($db->quoteName('fs4.Genero') . " in ('FEMININO','MASCULINO;FEMININO')");
$query->order('Modalidade ASC');
$db->setQuery($query);
$modalidades = $db->loadAssocList();

if (count($modalidades)) {
    foreach ($modalidades as $modalidade) {

        $query = $db->getQuery(true);
        $query->select($db->quoteName(array(strtolower(str_replace("-", "_", $lang->getTag())))));
        $query->from($db->quoteName('#__filtros'));
        $query->where($db->quoteName('pt_pt') . ' = ' . $db->quote($modalidade["Modalidade"]) . ' AND ' . $db->quoteName('nome') . ' = ' . $db->quote('modalidade'));
        $db->setQuery($query);
        $mod_traducao = $db->loadRowList();

        if (count($mod_traducao)) {
            $lang_modalidade = $mod_traducao[0][0];
        } else {
            $lang_modalidade = $modalidade["Modalidade"];
        }

        $query = $db->getQuery(true);
        $query->select("DISTINCT Categoria");
        $query->from($db->quoteName('#__fastseller_product_type_4', 'fs4'));
        $query->where($db->quoteName('fs4.Genero') . " in ('MASCULINO','MASCULINO;FEMININO')");
        $query->where($db->quoteName('fs4.Modalidade') . " = " . $db->quote($modalidade["Modalidade"]));
        $query->order('Categoria ASC');

        $db->setQuery($query);
        $categorias = $db->loadAssocList();
        
        if ($lang->getTag() == "en-GB") {
            $ModUrl = "index.php/products/search?Modalidade=" . strtoupper($modalidade["Modalidade"]) . "&Genero=FEMININO";
        } elseif ($lang->getTag() == "es-ES") {
            $modUrl = "index.php/productos/search?Modalidade=" . strtoupper($modalidade["Modalidade"]) . "&Genero=FEMININO";
        } else {
            $ModUrl = "index.php/produtos/search?Modalidade=" . strtoupper($modalidade["Modalidade"]) . "&Genero=FEMININO";
        }
        ?>
        <div class="col-md-2 menuFontSize" style="margin:0 12px;">
            <div class="clearfix"><p><a href="<?= $ModUrl ?>" class="menuFontTitle menuFontTitleOrange"><b><?= $lang_modalidade ?></b></a></p></div>
            <?php
            if (count($categorias)) {
                foreach ($categorias as $categoria) {

                    $query = $db->getQuery(true);
                    $query->select($db->quoteName(array(strtolower(str_replace("-", "_", $lang->getTag())))));
                    $query->from($db->quoteName('#__filtros'));
                    $query->where($db->quoteName('pt_pt') . ' = ' . $db->quote($categoria["Categoria"]) . ' AND ' . $db->quoteName('nome') . ' = ' . $db->quote('categoria'));
                    $db->setQuery($query);
                    $cat_traducao = $db->loadRowList();

                    if (count($mod_traducao)) {
                        $lang_categoria = $cat_traducao[0][0];
                    } else {
                        $lang_categoria = $categoria["Categoria"];
                    }

                    if ($lang->getTag() == "en-GB") {
                        $url = "index.php/products/search?Modalidade=" . strtoupper($modalidade["Modalidade"]) . "&Genero=FEMININO&Categoria=" . strtoupper($categoria["Categoria"]);
                    } elseif ($lang->getTag() == "es-ES") {
                        $url = "index.php/productos/search?Modalidade=" . strtoupper($modalidade["Modalidade"]) . "&Genero=FEMININO&Categoria=" . strtoupper($categoria["Categoria"]);
                    } else {
                        $url = "index.php/produtos/search?Modalidade=" . strtoupper($modalidade["Modalidade"]) . "&Genero=FEMININO&Categoria=" . strtoupper($categoria["Categoria"]);
                    }
                    ?>
                    <div><p><a href="<?= $url ?>"><?= $lang_categoria ?></a></p></div><br>
                    <?php
                }
            }
            ?>
        </div>
        <?php
    }
}
?>
