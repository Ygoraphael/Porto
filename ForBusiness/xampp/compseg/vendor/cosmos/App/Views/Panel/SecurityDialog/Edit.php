<?php

$id = filter_input(INPUT_POST, 'data', FILTER_SANITIZE_NUMBER_INT);

use Cosmos\System\Template;

$securitydialog = (new \App\Model\SecurityDialog)->fetch($id);
$tpl = new Template(APP_PATH_TPL . 'panel/securitydialog/form_security_dialog_edit.html');


$parameters = [
    'deleted' => ['=', 0, 'ORDER BY name']
];

$profiles = (new App\Model\Profile)->listingRegisters($parameters);
if (!empty($profiles)) {
    foreach ($profiles as $profile) {
        if ($securitydialog->getProfile() == $profile->getId()) {
            $tpl->select = 'SELECTED';
        } else {
            $tpl->clear('select');
        }
        $tpl->VALUE = $profile->getId();
        $tpl->TEXT = $profile->getName();
        $tpl->block('BLOCK_SELECT_PROFILE');
    }
}
$tpl->TITLE = '%%Edit Dialogue%%';
$tpl->SECURITYDIALOG = $securitydialog;
$tpl->show();
