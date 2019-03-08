<?php

use Cosmos\System\Template;

$tpl = new Template(APP_PATH_TPL . 'panel/companys/listing.html');
$companys = (new \App\Model\Company)->listingRegisters();

if (!empty($companys) && App\Model\User::getUserLoged()->getUser_type() == 1) {
    foreach ($companys as $company) {
        $tpl->TEXT = $company->getConfig()->getName();
        $tpl->VALUE = $company->getId();
        $tpl->block('BLOCK_COMPANY');
    }
    $tpl->block('BLOCK_COMPANYS');
}

$tpl->show();
