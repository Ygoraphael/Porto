<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Cosmos\System\Template;

$tpl = new Template(APP_PATH_TPL . 'panel/users/index.html');
$parameters = [
    'deleted' => ['<', 1]
];
$users = (new App\Model\User)->listingRegisters($parameters);
if (!empty($users)) {
    foreach ($users as $user) {
        $status = \Cosmos\System\Helper::getStatus($user->getStatus());
        $user->setStatus($status->status);
        $tpl->status_class = $status->alert;
        $tpl->USER = $user;
        $tpl->block('BLOCK_USER');
    }
    $tpl->block('BLOCK_USERS');
} else {
    $tpl->block('BLOCK_NO_USERS');
}
$tpl->show();
