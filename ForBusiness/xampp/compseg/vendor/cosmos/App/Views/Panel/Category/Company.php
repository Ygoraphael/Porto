<?php

use Cosmos\System\Template;

$tpl = new Template(APP_PATH_TPL . 'panel/categories/index.html');
$parameters = [
    'deleted' => ['<', 1]
];
$categories = (new App\Model\Category)->listingRegisters($parameters);

if (!empty($categories)) {
    foreach ($categories as $category) {
        $status = \Cosmos\System\Helper::getStatus($category->getStatus());
        $category->setStatus($status->status);
        $category->setCreated_at((new DateTime($category->getCreated_at()))->format('d/m/Y H:i:s'));
        $tpl->status_class = $status->alert;
        $tpl->CATEGORY = $category;
        $tpl->block('BLOCK_CATEGORY');
    }
    $tpl->block('BLOCK_CATEGORIES');
} else {
    $tpl->block('BLOCK_NO_CATEGORIES');
}
$tpl->show();
