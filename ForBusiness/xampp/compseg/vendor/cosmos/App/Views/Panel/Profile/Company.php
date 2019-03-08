<?php

use Cosmos\System\Template;

$tpl = new Template(APP_PATH_TPL . 'panel/profiles/index.html');
$parameters = [
    'deleted' => ['=', 0, 'ORDER BY NAME']
];
$profiles = (new App\Model\Profile)->listingRegisters($parameters);

if (!empty($profiles)) {
    foreach ($profiles as $profile) {
        $status = \Cosmos\System\Helper::getStatus($profile->getStatus());
        $profile->setStatus($status->status);
        $profile->setCreated_at((new DateTime($profile->getCreated_at()))->format('d/m/Y H:i:s'));
        $tpl->status_class = $status->alert;
        $tpl->PROFILE = $profile;
        $tpl->block('BLOCK_PROFILE');
    }
    $tpl->block('BLOCK_PROFILES');
} else {
    $tpl->block('BLOCK_NO_PROFILES');
}
$tpl->show();
