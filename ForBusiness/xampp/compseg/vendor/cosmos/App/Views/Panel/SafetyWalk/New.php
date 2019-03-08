<?php

use Cosmos\System\Template;

$tpl = new Template(APP_PATH_TPL . 'panel/safetywalks/form_safetywalk.html');
$parameters = [
    'deleted' => ['=', 0]
];
$companys = (new App\Model\Company)->listingRegisters($parameters);
if (App\Model\User::getUserLoged()->getUser_type() == 1) {
    if (!empty($companys)) {
        foreach ($companys as $company) {
            $tpl->NAME = $company->getConfig()->getName();
            $tpl->VALUE = $company->getId();
            $tpl->block('BLOCK_SELECT_COMPANY');
        }
    }
    $tpl->block('BLOCK_BTN_NEW_SAFETYWALK');
}
$parameters = [
    'deleted' => ['=', 0]
];
$profiles = (new App\Model\Profile)->listingRegisters($parameters);
if (!empty($profiles)) {
    foreach ($profiles as $profile) {
        $tpl->SELECT_PROFILE = $profile;
        $tpl->block('BLOCK_SELECT_PROFILE');
    }
}
foreach (\App\Controller\Survey::$types as $key => $type) {
    $tpl->TEXT = $type;
    $tpl->VALUE = $key;
    $tpl->block('BLOCK_SELECT_TYPE_DATE');
}
$tpl->TITLE = "%%New Safety Walk%%";
$date = (new DateTime());
$tpl->DATE_EXPIRED = $date->format('Y-m-d');

$tpl->show();
