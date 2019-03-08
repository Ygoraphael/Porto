<?php
/**ID de Insecurity**/

$id = filter_input(INPUT_POST, 'data', FILTER_SANITIZE_NUMBER_INT);

use Cosmos\System\Template;
	
    $tpl = new Template(APP_PATH_TPL . 'panel/insecuritys/seeInsecurity2.html');
	
	$inseguritys = (new \App\Model\Insecurity())->fetch($id);	
	if(!empty($inseguritys)){
			$tpl->ID = $id;
			$tpl->RESUMO = $inseguritys->getResumo();
			$tpl->IMG = $inseguritys->getImg();
			$tpl->DESCRIPTION = $inseguritys->getDescription();
			$tpl->COMMENT = $inseguritys->getComment();
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
