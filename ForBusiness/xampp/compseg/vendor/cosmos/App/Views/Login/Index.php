<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Cosmos\System\Template;

$tpl = new Template(APP_PATH_TPL . 'login/index.html');
if (isset($_SESSION['user_message'])) {
    $tpl->MESSAGE = $_SESSION['user_message']['info'];
    if ($_SESSION['user_message']['type'] == 1) {
        $tpl->TYPE_CLASS = 'success';
        $tpl->TYPE = '%%Success%%!';
    } else {
        $tpl->TYPE_CLASS = 'warning';
        $tpl->TYPE = '%%Error%%!';
    }
    Cosmos\System\Helper::my_session_start();
    $tpl->block('BLOCK_MESSAGE');
    $_SESSION['user_message'] = null;
}
if (isset($_SESSION['message_password']) && !is_null($_SESSION['message_password'])) {
    $tpl->PW_MESSAGE = $_SESSION['message_password']['msg'];
    if ($_SESSION['message_password']['type'] == 1) {
        $tpl->PW_TYPE_CLASS = 'success';
        $tpl->PW_TYPE = '%%Success%%!';
    } else {
        $tpl->PW_TYPE_CLASS = 'warning';
        $tpl->PW_TYPE = '%%Error%%!';
    }
    Cosmos\System\Helper::my_session_start();
    $tpl->block("BLOCK_MESSAGE_PASSWORD");
    $_SESSION['message_password'] = null;
}

$tpl->show();
