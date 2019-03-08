<?php
$idstatus = $_GET['s'];
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Cosmos\System\Template;

$tpl = new Template(APP_PATH_TPL . 'panel/companys/index.html');
$parameters = [
    'deleted' => ['=', 0, 'AND']
];
if( $idstatus != 100 ){
	$parameters['status'] = ['=', $idstatus, 'AND'];
}
$parameters['idCompany'] = ['>', 0 , ''];
$companys = (new App\Model\Company)->listingRegisters($parameters);
if (!empty($companys)) {
    foreach ($companys as $company) {
        $tpl->COMPANY_NAME = $company->getConfig()->getName();
        $status = Cosmos\System\Helper::getStatus($company->getStatus());
        $company->setStatus($status->status);
        $tpl->status_class = $status->alert;
        $tpl->COMPANY = $company;
        $tpl->block('BLOCK_COMPANY');
    }
    $tpl->block('BLOCK_COMPANYS');
} else {
    $tpl->block('BLOCK_NO_COMPANYS');
}
$st = array(100, 0, 1, 2);
foreach ($st as $s) {
    $status2 = \Cosmos\System\Helper::getStatus($s);
    foreach ($status2 as $sta => $value) {
        if ($sta === 'status') {
            if ($idstatus == $s) {
                $tpl->SELECTED = 'selected';
            } else {
                $tpl->SELECTED = '';
            }
            $tpl->VALUEST = $s;
            $valst = (new \App\Model\Translate())->translater($value);
            $tpl->TEXTST = $valst;
            $tpl->block('BLOCK_STATUS');
        }
    }
}

$tpl->show();

