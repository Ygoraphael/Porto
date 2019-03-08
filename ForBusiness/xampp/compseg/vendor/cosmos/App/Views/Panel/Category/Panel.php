<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Cosmos\System\Template;

$tpl = new Template(APP_PATH_TPL . 'panel/index.html');
$parameters_customers = [
    'deleted' => ['=', 0]
];
$tpl->COUNT_CUSTOMERS = count((new \App\Model\Company)->listingRegisters($parameters_customers));
$parameters_user = [
    'deleted' => ['<', 1]
];
$tpl->COUNT_USERS = count((new \App\Model\User)->listingRegisters($parameters_user));
$tpl->show();
