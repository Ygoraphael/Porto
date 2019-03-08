<?php

use Cosmos\System\Template;

$tpl = new Template(APP_PATH_TPL . 'panel/sectors/index.html');
$parameters = [
    'deleted' => ['<', 1]
];
$sectors = (new App\Model\Sector)->listingRegisters($parameters);

if (!empty($sectors)) {
    foreach ($sectors as $sector) {
        $status = \Cosmos\System\Helper::getStatus($sector->getStatus());
        $sector->setStatus($status->status);
        $sector->setCreated_at((new DateTime($sector->getCreated_at()))->format('d/m/Y H:i:s'));
        $factory = (new \App\Model\Factory)->fetch($sector->getFactory());
        $tpl->FACTORY = $factory;
        $tpl->status_class = $status->alert;
        $tpl->SECTOR = $sector;
        $tpl->block('BLOCK_SECTOR');
    }
    $tpl->block('BLOCK_SECTORS');
} else {
    $tpl->block('BLOCK_NO_SECTORS');
}
$tpl->show();
