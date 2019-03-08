<?php

$idCompany = filter_input(INPUT_POST, 'idCompany', FILTER_SANITIZE_NUMBER_INT);
$factory_id = filter_input(INPUT_POST, 'idFactory', FILTER_SANITIZE_NUMBER_INT);

use Cosmos\System\Template;
	
$company = (new \App\Model\Company)->fetch($idCompany);
$factorys = (new \App\Model\Factory())->listing($company);
$sectors  = (new \App\Model\Sector())->listing($company);
$tpl = new Template(APP_PATH_TPL . 'panel/sectors/listing.html');
		
if (!empty($sectors)) {
    foreach ($sectors as $sector) {
		$IDFACTORY = $sector->getfactory();
		
		if($IDFACTORY == $factory_id){
			$tpl->idcompany = $company;
			$tpl->VALUE = $sector->getId();
			$tpl->TEXT = $sector->getName();
			$tpl->block('BLOCK_SECTOR');
		}	
    }
}

$tpl->show();




