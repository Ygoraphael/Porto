<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Cosmos\System\Template;

$tpl = new Template(APP_PATH_TPL . 'panel/users/index.html');
if (isset($_SESSION['user_message']) && !is_null($_SESSION['user_message'])) {
    $tpl->MESSAGE = $_SESSION['user_message']['msg'];
    if ($_SESSION['user_message']['type'] == 1) {
        $tpl->TYPE_CLASS = 'success';
        $tpl->TYPE = 'Sucesso!';
    } else {
        $tpl->TYPE_CLASS = 'warning';
        $tpl->TYPE = 'Erro!';
    }
    Cosmos\System\Helper::my_session_start();
    $tpl->block("BLOCK_MESSAGE");
    $_SESSION['user_message'] = null;
}
$users = (new App\Model\User)->listingRegisters();
if (!empty($users)) {
    foreach ($users as $user) {
        $tpl->USER = $user;
        $tpl->block('BLOCK_USER');
    }
    $tpl->block('BLOCK_USERS');
}
$tpl->show();
