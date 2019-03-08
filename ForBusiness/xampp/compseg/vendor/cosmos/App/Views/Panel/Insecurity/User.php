<?php

use Cosmos\System\Template;

$tpl = new Template(APP_PATH_TPL . 'panel/insecuritys/form_insecuritysUser.html');

$companys = (\App\Model\Company::getCompany());
$user = App\Model\User::getUserLoged();

$tpl->NAME2 = $companys->getConfig()->getName();
$VALUE2 = $companys->getId();
$tpl->VALUE2 = $VALUE2;

$tpl->block('BLOCK_COMPANY4');

$company = (new \App\Model\Company)->fetch($VALUE2);
$factorys = (new \App\Model\Factory())->listing($company);

if (!empty($factorys)) {
    foreach ($factorys as $factory) {
        $tpl->COMPANY = $VALUE2;
        $tpl->VALUE = $factory->getId();
        $tpl->TEXT = $factory->getName();
        $tpl->block('BLOCK_FACTORY');
    }
}

$companys = (\App\Model\Company::getCompany());
$user = App\Model\User::getUserLoged();

$tpl->NAME2 = $companys->getConfig()->getName();
$VALUE2 = $companys->getId();
$tpl->VALUE2 = $VALUE2;

$tpl->block('BLOCK_COMPANY5');

$company = (new \App\Model\Company)->fetch($VALUE2);
$factorys = (new \App\Model\Factory())->listing($company);

if (!empty($factorys)) {
    foreach ($factorys as $factory) {
        $tpl->COMPANY = $VALUE2;
        $tpl->VALUE = $factory->getId();
        $tpl->TEXT = $factory->getName();
        $tpl->block('BLOCK_FACTORY2');
    }
}


$date = (new DateTime());
$tpl->DATE_EXPIRED = $date->format('Y-m-d');

$tpl->show();
