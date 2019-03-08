<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$hash = $_GET['recover_hash'];

use Cosmos\System\Template;

$tpl = new Template(APP_PATH_TPL . 'login/resetpassword.html');

$parameters = [
    'hash' => ['=', $hash, 'AND'],
    'status' => ['=', 1]
];
$user = (new \App\Model\User())->listingRegisters($parameters);
if ($user) {
    $tpl->HASH = $hash;
    $tpl->block('BLOCK_HASH');

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

    $tpl->show();
}
