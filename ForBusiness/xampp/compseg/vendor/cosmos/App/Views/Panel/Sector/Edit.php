<?php

$id = filter_input(INPUT_POST, 'data', FILTER_SANITIZE_NUMBER_INT);

use Cosmos\System\Template;

$sector = (new \App\Model\Sector)->fetch($id);
$tpl = new Template(APP_PATH_TPL . 'panel/sectors/form_sector.html');
$tpl->TITLE = '%%Edit Sector%%';
$factorys = (new \App\Model\Factory)->listingRegisters();
if (!empty($factorys)) {
    foreach ($factorys as $factory) {
        if ($sector->getFactory() == $factory->getId()) {
            $tpl->select = 'SELECTED';
        } else {
            $tpl->clear('select');
        }
        $tpl->VALUE = $factory->getId();
        $tpl->TEXT = $factory->getName();
        $tpl->block('BLOCK_FACTORY');
    }
}
$tpl->SECTOR = $sector;
$tpl->action = 'btn_save_edit';
$tpl->show();
