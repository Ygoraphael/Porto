<?php
$db = JFactory::getDbo();
$lang = JFactory::getLanguage();

$query = $db->getQuery(true);
$query->select("*");

$query->from($db->quoteName('#__virtuemart_categories', 'vc'));
$query->join('INNER', $db->quoteName('#__virtuemart_categories_pt_pt', 'vcl') . ' ON (' . $db->quoteName('vc.virtuemart_category_id') . ' = ' . $db->quoteName('vcl.virtuemart_category_id') . ')');
$query->join('LEFT', $db->quoteName('#__virtuemart_category_medias', 'vcm') . ' ON (' . $db->quoteName('vc.virtuemart_category_id') . ' = ' . $db->quoteName('vcm.virtuemart_category_id') . ')');
$query->join('LEFT', $db->quoteName('#__virtuemart_medias', 'vm') . ' ON (' . $db->quoteName('vcm.virtuemart_media_id') . ' = ' . $db->quoteName('vm.virtuemart_media_id') . ')');

$query->where($db->quoteName('vc.published') . ' = 1');
$db->setQuery($query);
$colecoes = $db->loadAssocList();

if ($lang->getTag() == "en-GB") {
    $url = "index.php/products/";
} elseif ($lang->getTag() == "es-ES") {
    $url = "index.php/productos/";
} else {
    $url = "index.php/produtos/";
}

if (count($colecoes)) {
    foreach ($colecoes as $colecao) {
        ?>
        <div class="col-sm-2">
            <a href="<?= $url ?>/<?= trim($colecao["slug"]) ?>">
                <div class="center colection-title menuFontTitle" style="color:white; font-size:13px;"><?= $colecao["category_name"] ?></div>
                <div><img class="img-fluid hvr-grow colection-img" src="<?= (trim($colecao["file_url"]) == "" ? "https://cdn.shopify.com/s/files/1/1441/5702/products/Product-FRE1S60W_large.jpg" : trim($colecao["file_url"])) ?>"></div>
            </a>
        </div>
        <?php
    }
}
