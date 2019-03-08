<?php

use Cosmos\System\Template;

$user2 = (App\Model\User::getUserLoged()->getUser_type() );

if ($user2 == 1) {
    $tpl = new Template(APP_PATH_TPL . 'panel/insecuritys/form_insecuritys3.html');

    $date = (new DateTime());
    $tpl->DATE_EXPIRED = $date->format('Y-m-d');

    $companys = (new \App\Model\Company)->listingRegisters();

    if (!empty($companys)) {
        foreach ($companys as $company) {
            $tpl->TEXT = $company->getConfig()->getName();
            $tpl->VALUE = $company->getId();
            $tpl->block('BLOCK_COMPANY');
        }
        $tpl->block('BLOCK_COMPANYS');
    }
    $tpl->action = 'btn_save';
    $tpl->show();
} elseif ($user2 == 2 || $user2 == 3) {

    $tpl = new Template(APP_PATH_TPL . 'panel/insecuritys/form_insecuritys3.html');

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

    $date = (new DateTime());
    $tpl->DATE_EXPIRED = $date->format('Y-m-d');
    $tpl->show();
}