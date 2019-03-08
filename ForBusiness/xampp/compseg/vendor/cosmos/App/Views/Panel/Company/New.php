<?php

use Cosmos\System\Template;

$tpl = new Template(APP_PATH_TPL . 'panel/companys/form_company.html');

$languages = (new \App\Model\Language)->listing();
if(!empty($languages)){
	foreach($languages as $language){
		$tpl->select = '';
		$tpl->VALUE = $language->getId();
        $tpl->TEXT = $language->getText();
		$tpl->block('BLOCK_LANGUAGE');	
	}$tpl->block('BLOCK_LANGUAGES');
}	
$tpl->TITLE = '%%New Company%%';
$tpl->action = 'btn_save';
$tpl->show();
