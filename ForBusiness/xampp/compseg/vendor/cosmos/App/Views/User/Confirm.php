<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Cosmos\System\Template;

$tpl = new Template(APP_PATH_TPL . 'user/confirm.html');
if (isset($_SESSION['user_password'])) {
    $user = unserialize($_SESSION['user_password']['user']);
    $tpl->welcome = "%%Hello%%, {$user->getName()} {$user->getLast_name()}";
} else {
    Cosmos\System\Helper::redirect('/login');
}
if (isset($_SESSION['message_password']) && !is_null($_SESSION['message_password'])) {
    $tpl->MESSAGE = $_SESSION['message_password']['msg'];
    if ($_SESSION['message_password']['type'] == 1) {
        $tpl->TYPE_CLASS = 'success';
        $tpl->TYPE = 'Sucesso!';
    } else {
        $tpl->TYPE_CLASS = 'warning';
        $tpl->TYPE = 'Erro!';
    }
    Cosmos\System\Helper::my_session_start();
    $tpl->block("BLOCK_MESSAGE");
    $_SESSION['message_password'] = null;
}
$tpl->show();
