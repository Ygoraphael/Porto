<?php

$start = $_GET['s'];
$start2 = $_GET['s'] . ' 00:00:00';
$end = $_GET['e'];
$end2 = $_GET['e'] . ' 23:59:59';
$idstatus = $_GET['t'];
$idprofile = $_GET['p'];
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Cosmos\System\Template;

$tpl = new Template(APP_PATH_TPL . 'panel/safetywalks/company.html');

$filter = [
    'deleted' => ['=', 0, 'AND']
];
//**STATUS
if ($idstatus != 100) {
    $filter['status'] = ['=', $idstatus, 'AND'];
}

//data inicio e fim 
if ($start != "" && $end != "") {
    $dataf = $start2 . "' AND '" . $end2;
    $filter['created_at'] = ['BETWEEN', $dataf, 'AND'];
}
else if ( $start == "" && $end != "" ) {
    $filter['created_at'] = ['<=', $start2, 'AND'];
}
else if ( $start != "" && $end == "" ) {
    $filter['created_at'] = ['>=', $end2, 'AND'];
}

if ($idprofile != 0) {
    $filter['profile'] = ['=', $idprofile, 'AND'];
}
$filter['idSafetyWalk'] = ['>', 0, ''];

$safetywalks = (new App\Model\SafetyWalk())->listingRegisters($filter);
if (!empty($safetywalks)) {
    foreach ($safetywalks as $safetywalk) {
        $status = Cosmos\System\Helper::getStatusSurvey($safetywalk->getStatus());
        $safetywalk->setStatus($status->status);
        $type = Cosmos\System\Helper::getMonthTypeSurvey($safetywalk->getType());
        $safetywalk->setType($type);
        $tpl->ID = $safetywalk->idSafetyWalk;
        $safetywalk->setCreated_at((new DateTime($safetywalk->getCreated_at()))->format('d/m/Y H:i:s'));
        $tpl->status_class = $status->alert;

        $profile = (new \App\Model\Profile())->fetch($safetywalk->getProfile());
        $safetywalk->setProfile($profile->getName());

        $tpl->SAFETYWALK = $safetywalk;
        $tpl->block('BLOCK_SAFETYWALKS');
    }
    $tpl->block('BLOCK_LISTING_SAFETYWALKS');
} else {
    $tpl->block('BLOCK_NO_SAFETYWALKS');
}
$st = array(100, 0, 1, 2);
foreach ($st as $s) {
    $status2 = \Cosmos\System\Helper::getStatusSurvey($s);
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

$parameters = [
    'deleted' => ['=', 0]
];
$profiles = (new App\Model\Profile)->listingRegisters($parameters);
if (!empty($profiles)) {
    foreach ($profiles as $profile) {
        $PROFILE = (new \App\Model\Translate())->translater($profile->getName());
        $profile->setName($PROFILE);
        if ($idprofile == $profile->getId()) {
            $tpl->SELECTED3 = 'selected';
        } elseif ($idprofile == 0) {
            $tpl->SELECTED2 = 'selected';
        } else {
            $tpl->SELECTED3 = '';
        }
        $tpl->SELECT_PROFILE = $profile;
        $tpl->block('BLOCK_SELECT_PROFILE');
    }
}
$tpl->start2 = $start;
$tpl->END3 = $end;
$tpl->show();
