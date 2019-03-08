<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Cosmos\System\Template;

$tpl = new Template(APP_PATH_TPL . 'panel/securitydialog/administrator.html');
$dialogs = (new \App\Model\SecurityDialog)->listingRegisters();
if (!empty($dialogs)) {
    foreach ($dialogs as $dialog) {
        $tpl->SECURITYDIALOG = $dialog;
        $tpl->block('BLOCK_SECURITYDIALOG');
    }
    $tpl->block('BLOCK_SECURITYDIALOGS');
}
else {
    $tpl->block('BLOCK_NO_USERS');
}
$tpl->show();
