<?php

$CompanyFactory = filter_input(INPUT_POST, 'CompanyFactory', FILTER_SANITIZE_NUMBER_INT);
$valor  = explode("+", $CompanyFactory);
$factory = $valor[0];
$company = $valor[1];

use Cosmos\System\Template;

$tpl = new Template(APP_PATH_TPL . 'panel/sectors/listing2.html');
	
$company = (new \App\Model\Company)->fetch($company);
$factorys = (new \App\Model\Factory())->listing($company);
$sectors  = (new \App\Model\Sector())->listing($company);
		
if (!empty($sectors)) {
    foreach ($sectors as $sector) {
		$IDFACTORY = $sector->getfactory();
		
		if($IDFACTORY == $factory){
			$tpl->idcompany = $company;
			$tpl->VALUE = $sector->getId();
			$tpl->TEXT = $sector->getName();
			$tpl->block('BLOCK_SECTOR');
		}	
    }
}

$tpl->show();