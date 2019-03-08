<?php

$idstatus = $_GET['t'];
$iduser = $_GET['u'];
$start = $_GET['s'];
$start2 = $_GET['s'] . ' 00:00:00';
$end = $_GET['e'];
$end2 = $_GET['e'] . ' 23:59:59';

use Cosmos\System\Template;

$tpl = new Template(APP_PATH_TPL . 'panel/insecuritys/company.html');
$translate = (new \App\Model\Translate());
$filter = [
    'deleted' => ['=', 0, 'AND']
];

//data inicio e fim 
if ($start != "" && $end != "") {
    $dataf = $start2 . "' AND '" . $end2;
    $filter['created_at'] = ['BETWEEN', $dataf, 'AND'];
}
else if ( $start == "" && $end != "" ) {
    $filter['created_at'] = ['<=', $end2, 'AND'];
}
else if ( $start != "" && $end == "" ) {
    $filter['created_at'] = ['>=', $start2, 'AND'];
}

// Status
if ($idstatus != 100) {
    $filter['status'] = ['=', $idstatus, 'AND'];
}
//user
if ($iduser != '') {
    $filter['user'] = ['=', $iduser, 'AND'];
}
if ($iduser == 'No_One') {
    $filter['user'] = ['=', '', 'AND'];
}
if ($iduser == '100') {
    $filter['user'] = ['!=', '', 'AND'];
}
$filter['idInsecurity'] = ['>', 0, ''];

$inseguritys = (new App\Model\Insecurity())->listingRegisters($filter);
if (!empty($inseguritys)) {
    foreach ($inseguritys as $insegurity) {
        $tpl->status = $insegurity->getStatus();
        if ($tpl->status == 0) {
            $status = \Cosmos\System\Helper::getStatus($insegurity->getStatus());
            $insegurity->setStatus($status->status);
            $tpl->urlimg = '/assets/images/upload/';
            $tpl->status = $insegurity->getStatus();
            $tpl->status_class = $status->alert;
            $tpl->CODE = $insegurity->idInsecurity;
            $tpl->IMG = $insegurity->getImg();
            $tpl->created_at = $insegurity->getCreated_at();
            $tpl->RESUMO = $insegurity->getResumo();
            $tpl->block('BLOCK_INSECURITY');
        } elseif ($tpl->status == 3 || $tpl->status == 4 || $tpl->status == 5) {
            $status = \Cosmos\System\Helper::getStatus($insegurity->getStatus());
            $insegurity->setStatus($status->status);
            $ID = $insegurity->idInsecurity;
            $ID2 = (int) ($ID);
            $parameters = [
                'value1' => ['=', $ID2]
            ];
            $notifications = (new \App\Model\Notification())->listingRegisters($parameters);
            foreach ($notifications as $notification) {
                $users = $notification->getUser();
                $user = (New App\Model\User())->fetch($users);
                $tpl->USER3 = $user->getName();
                $tpl->USER4 = $user->getlast_name();
            }
            $tpl->urlimg = '/assets/images/upload/';
            $tpl->status = $insegurity->getStatus();
            $tpl->status_class = $status->alert;
            $tpl->CODE = $insegurity->idInsecurity;
            $tpl->IMG = $insegurity->getImg();
            $tpl->created_at = $insegurity->getCreated_at();
            $tpl->RESUMO = $insegurity->getResumo();
            $tpl->block('BLOCK_INSECURITY2');
        }
    }
    $tpl->block('BLOCK_INSECURITYS');
} else {
    $tpl->block('BLOCK_NO_INSECURITYS');
}
$st = array(100, 0, 4, 3);
foreach ($st as $s) {
    $status2 = \Cosmos\System\Helper::getStatus($s);
    foreach ($status2 as $sta => $value) {
        if ($sta === 'status') {
            if ($idstatus == $s) {
                $tpl->SELECTED2 = 'selected';
            } else {
                $tpl->SELECTED2 = '';
            }
            $tpl->VALUEST = $s;
            $valst = $value;
            $tpl->TEXTST = $valst;
            $tpl->block('BLOCK_STATUS');
        }
    }
}
$users = \App\Model\User::getCompanyUsers(\App\Model\Company::getCompany());
if (!empty($users)) {
    foreach ($users as $user) {
        $user = (new App\Model\User)->fetch($user->user);
        $idUser = $user->getID();
        $Name = $user->getName();
        $Apelido = $user->getLast_name();
        if ($iduser == $idUser) {
            $tpl->SELECTED = 'selected';
        } elseif ($iduser == 'No_One') {
            $tpl->SELECTED3 = 'selected';
        } elseif ($iduser == '') {
            $tpl->SELECTED2 = 'selected';
        } else {
            $tpl->SELECTED = '';
        }
        $tpl->USERID = $idUser;
        $tpl->NAME_USER = $Name . ' ' . $Apelido;
        $tpl->block('BLOCK_USER2');
    }
}
if ($iduser == 'No_One') {
    $tpl->SELECTED3 = 'selected';
}
if ($iduser == '') {
    $tpl->SELECTED2 = 'selected';
}
$tpl->start = $start;
$tpl->END2 = $end;
$tpl->show();
