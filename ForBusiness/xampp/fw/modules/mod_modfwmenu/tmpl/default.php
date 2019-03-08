<?php // No direct access defined('_JEXEC') or die;        ?>
<?php
$image = $params->get('image');
$url = $params->get('url');
$prodalias = $params->get('prodalias');

$language = & JFactory::getLanguage();
$language->load('mod_virtuemart_product');
$url_lang = substr($language->getTag(), 0, 2);
$url_vm = "";
switch ($url_lang) {
    case 'pt':
        $url_vm = 'produtos';
        break;
    case 'es':
        $url_vm = 'productos';
        break;
    case 'en':
        $url_vm = 'products';
        break;
}
?>




<?php if (strlen(trim($prodalias)) || strlen(trim($url))) : ?>
    <?php if (strlen(trim($prodalias))) : ?>
        <a href="<?= juri::base() . "index.php/" . $url_lang . "/" . $url_vm . "/" . $prodalias ?>">
        <?php elseif (strlen(trim($url))) : ?>
            <a href="<?= $url ?>">
            <?php endif; ?>
        <?php endif; ?>
        <img class="img-fluid" src="<?= $image ?>">
        <?php if (strlen(trim($prodalias)) || strlen(trim($url))) : ?>
        </a>
    <?php endif; ?>