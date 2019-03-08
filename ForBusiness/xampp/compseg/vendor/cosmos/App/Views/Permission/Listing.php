<?php

$level = filter_input(INPUT_POST, 'data', FILTER_SANITIZE_NUMBER_INT);

use Cosmos\System\Template;

$tpl = new Template(APP_PATH_TPL . 'permission/listing.html');
$parameters = [
    'level_min' => ['<=', $level, 'AND'],
    'level_max' => ['>=', $level, 'AND'],
    'status' => ['=', 1]
];
$pages = (new App\Model\Page)->listingRegisters($parameters);
if (!empty($pages)) {
    foreach ($pages as $page) {
        $translate = (new \App\Model\Translate());
		$pageText= (new \App\Model\Translate())->translater($page->getTitle());
		$page->setTitle(ucfirst($pageText));
        if ($page->getPermission() == 1) {
            $tpl->permission_true = 'checked';
            $tpl->clear('permission_false');
        } else {
            $tpl->permission_false = 'checked';
            $tpl->clear('permission_true');
        }
        $tpl->PAGE_MAIN = $page;
        $tpl->block('BLOCK_MENU_PERMISSION');
    }
    $tpl->block('BLOCK_PEMISSIONS');
}
$tpl->show();
