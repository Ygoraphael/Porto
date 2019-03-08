<?php

$company_id = filter_input(INPUT_POST, 'data', FILTER_SANITIZE_NUMBER_INT);

use Cosmos\System\Template;

$tpl = new Template(APP_PATH_TPL . 'panel/companys/form_company.html');
$tpl->TITLE = '%%Edit Company%%';
$company = (new App\Model\Company)->fetch($company_id);
$tpl->NAME = $company->getConfig()->getName();
$tpl->LICENSE = (new \App\Model\License)->fetch($company->getLicense());
$tpl->USER = (new App\Model\User)->selectAdminCompany($company);
$tpl->COMPANY = $company;
$lang = (new \App\Model\Language)->fetch($company->getLanguage());
$languages = (new \App\Model\Language)->listing();
if(!empty($languages)){
	foreach($languages as $language){
		if ($language->getId() == $lang->getId()) {
            $tpl->select = 'SELECTED';
        } else {
            $tpl->clear('select');
        }
		$tpl->VALUE = $language->getId();
        $tpl->TEXT = $language->getText();
		$tpl->block('BLOCK_LANGUAGE');	
	}$tpl->block('BLOCK_LANGUAGES');
}	
$tpl->action = 'btn_save_edit';
$tpl->disabled = 'disabled';
$tpl->show();
