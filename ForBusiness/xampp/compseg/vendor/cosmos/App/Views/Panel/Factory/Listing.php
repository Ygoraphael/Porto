<?php

$company_id = filter_input(INPUT_POST, 'data', FILTER_SANITIZE_NUMBER_INT);

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Cosmos\System\Template;

$tpl = new Template(APP_PATH_TPL . 'panel/factorys/listing.html');
$company = (new \App\Model\Company)->fetch($company_id);
$factorys = (new \App\Model\Factory())->listing($company);
if (!empty($factorys)) {
    foreach ($factorys as $factory) {
        $tpl->VALUE = $factory->getId();
        $tpl->TEXT = $factory->getName();
        $tpl->block('BLOCK_FACTORY');
    }
}
$tpl->show();
