<?php

use Cosmos\System\Template;

$tpl = new Template(APP_PATH_TPL . 'panel/users/form_user2.html');
$translate = (new \App\Model\Translate());

$tpl->code = Cosmos\System\Helper::createCode();
$level = (new App\Model\UserType)->fetch(App\Model\User::getUserLoged()->getUser_type())->getLevel();
$parameters = [
    'level' => ['>=', $level, 'ORDER BY level DESC']
];
$level_types = (new App\Model\UserType())->listingRegisters($parameters);
if (!empty($level_types)) {
    foreach ($level_types as $level) {
        $tpl->TEXT = $level->getName();
        $tpl->VALUE = $level->getId();
        $tpl->block('BLOCK_SELECT_LEVEL');
    }
}

$companys = (\App\Model\Company::getCompany());
$profiles = (new \App\Model\Profile())->listing($companys);
if (!empty($profiles)) {
    foreach ($profiles as $profile) {
        $tpl->VALUE = $profile->getId();
        $tpl->TEXT = $profile->getName();
        $tpl->block('BLOCK_PROFILE');
    }
}

$tpl->TITLE = '%%New User%%';
$tpl->action = 'btn_save';
$tpl->show();