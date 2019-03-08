<?php
/**ID de Insecurity**/
$id2 = $_GET['id'];
$id = $_GET['value1'];
$description = $_GET['description'];

use Cosmos\System\Template;
	
    $tpl = new Template(APP_PATH_TPL . 'panel/insecuritys/Answer_phone_Insecurity.html');
	$inseguritys = (new \App\Model\Insecurity())->fetch($id);	
	if(!empty($inseguritys)){
			$tpl->ID = $id;
			$tpl->ID2 = $id2;
			$tpl->RESUMO = $inseguritys->getResumo();
			$tpl->IMG = $inseguritys->getImg();
			$tpl->COMMENT = $inseguritys->getComment();
			$tpl->DESCRIPTION = $description;
			/**DATA**/
			$date = (new DateTime());
			$tpl->DATE_RESOLVED = $date->format('Y-m-d');
			/**COMPANY**/
			$companys = (\App\Model\Company::getCompany());
			$tpl->COMPANY = $companys->getConfig()->getName();
			/**FACTORY**/
			$factorys = (new \App\Model\Factory())->fetch($inseguritys->getFactory());
			$tpl->FACTORY = $factorys->getName();
			/**SECTOR**/
			$sectors = (new \App\Model\Sector())->fetch($inseguritys->getSector());
			$tpl->SECTOR = $sectors->getName();
		}
	$tpl->block('BLOCK_INSECURITY');
    
    $tpl->show();
