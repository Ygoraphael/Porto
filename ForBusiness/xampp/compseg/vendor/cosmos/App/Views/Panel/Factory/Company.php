<?php

use Cosmos\System\Template;

$tpl = new Template(APP_PATH_TPL . 'panel/factorys/index.html');
$parameters = [
    'deleted' => ['<', 1]
];
$factorys = (new App\Model\Factory)->listingRegisters($parameters);

if (!empty($factorys)) {
    foreach ($factorys as $factory) {
        $status = \Cosmos\System\Helper::getStatus($factory->getStatus());
        $factory->setStatus($status->status);
        $factory->setCreated_at((new DateTime($factory->getCreated_at()))->format('d/m/Y H:i:s'));
        $tpl->status_class = $status->alert;
        $tpl->FACTORY = $factory;
        $tpl->block('BLOCK_FACTORY');
    }
    $tpl->block('BLOCK_FACTORYS');
} else {
    $tpl->block('BLOCK_NO_FACTORYS');
}
$tpl->show();
