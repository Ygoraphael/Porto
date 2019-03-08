<?php
/**ID de Insecurity**/

$id = filter_input(INPUT_POST, 'data', FILTER_SANITIZE_NUMBER_INT);

use Cosmos\System\Template;
	
    $tpl = new Template(APP_PATH_TPL . 'panel/insecuritys/See_pc_insecurity.html');
	
	$insecuritys = (new \App\Model\Insecurity())->fetch($id);	
	if(!empty($insecuritys)){
			$tpl->ID = $id;
			$tpl->RESUMO = $insecuritys->getResumo();
			$tpl->IMG = $insecuritys->getImg();			
			$COMMENT = $insecuritys->getComment();
			$tpl->COMMENT = "<li><p>".str_replace("+","</li><li><p>",$COMMENT)."<p></li>";
			/**DATA**/
			$date = (new DateTime());
			$tpl->DATE_RESOLVED = $date->format('Y-m-d');
			/**COMPANY**/
			$companys = (\App\Model\Company::getCompany());
			$tpl->COMPANY = $companys->getConfig()->getName();
			/**FACTORY**/
			$factorys = (new \App\Model\Factory())->fetch($insecuritys->getFactory());
			$tpl->FACTORY = $factorys->getName();
			/**SECTOR**/
			$sectors = (new \App\Model\Sector())->fetch($insecuritys->getSector());
			$tpl->SECTOR = $sectors->getName();
		}
		
	$tpl->block('BLOCK_INSECURITY');
    
	
    $tpl->show();
