<?php

use Cosmos\System\Template;

$tpl = new Template(APP_PATH_TPL . 'panel/users/Form_userAdmin.html');
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

$tpl->TITLE = '%%New User%%';
$tpl->action = 'btn_save';
$tpl->show();
