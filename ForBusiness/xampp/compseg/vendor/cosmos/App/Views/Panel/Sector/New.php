<?php

use Cosmos\System\Template;

$tpl = new Template(APP_PATH_TPL . 'panel/sectors/form_sector.html');
$tpl->TITLE = '%%New Sector%%';
$tpl->action = 'btn_save';
$parameters = [
    'deleted' => ['<', 1]
];
$factorys = (new \App\Model\Factory)->listingRegisters($parameters);
if (!empty($factorys)) {
    foreach ($factorys as $factory) {
        $tpl->VALUE = $factory->getId();
        $tpl->TEXT = $factory->getName();
        $tpl->block('BLOCK_FACTORY');
    }
}
$tpl->show();
