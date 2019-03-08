<?php

$idstatus = $_GET['status'];
$iduser = $_GET['user'];

$date_start = $_GET['dls'];
$datetime_start = $_GET['dls'] . " 00:00:00";
$date_end = $_GET['dle'];
$datetime_end = $_GET['dle'] . " 23:59:59";

use Cosmos\System\Template;

$tpl = new Template(APP_PATH_TPL . 'survey/surveys.html');
$translate = (new \App\Model\Translate());
$tpl->datestart = $date_start;
$tpl->dateend = $date_end;

$filter = [
    'idNotification' => ['>', 0, 'AND']
];

if ($iduser != 0) {
    $filter['user'] = ['=', $iduser, 'AND'];
}

//expirado
if ($idstatus == "Expired") {
    $filter['deleted'] = ['=', 1, 'AND'];
    $filter['value2'] = ['IS NULL', '', 'AND'];
    $filter['table2'] = ['IS NULL', '', 'AND'];
}
//concluido
else if ($idstatus == "Completed") {
    $filter['deleted'] = ['=', 1, 'AND'];
    $filter['value2'] = ['<>', '', 'AND'];
    $filter['table2'] = ['=', "surveyanswer", 'AND'];
}
//em aberto
else if ($idstatus == "Opened") {
    $filter['deleted'] = ['=', 0, 'AND'];
}

//data inicio e fim 
if ($date_start != "" && $date_end != "") {
    $dataf = $datetime_start . "' AND '" . $datetime_end;
    $filter['date_limit'] = ['BETWEEN', $dataf, 'AND'];
}
else if ( $date_start == "" && $date_end != "" ) {
    $filter['date_limit'] = ['<=', $datetime_end, 'AND'];
}
else if ( $date_start != "" && $date_end == "" ) {
    $filter['date_limit'] = ['>=', $datetime_start, 'AND'];
}

$filter['table1'] = ['=', "survey", ''];

$notifications = (new \App\Model\Notification())->listingRegisters($filter);

$num_oc = 0;
if (!empty($notifications)) {
    foreach ($notifications as $notification) {
        if (is_null($notification->getValue2())) {
            $answered_at = "";
            $url = "#";
        } else {
            $survey_answer = (new \App\Model\SurveyAnswer)->fetch($notification->getValue2());
            $answered_at = $survey_answer->getCreated_at();
            $url = (\Cosmos\System\Helper::getNotificationUrl($notification->getType(), array($notification->idNotification), 1));
        }
        $status = (\Cosmos\System\Helper::getStatusNotification($notification->getDeleted(), $notification->getValue2()));

        $survey = (new \App\Model\Survey)->fetch($notification->getValue1());
        $user = (new \App\Model\User)->fetch($notification->getUser());
        $notification->code = $survey->getCode();
        $notification->setUser($user->getName() . ' ' . $user->getLast_name());
        $notification->answered_at = $answered_at;
        $notification->url = $url;
        $statu = (new \App\Model\Translate())->translater($status->status);
        $notification->status = ($statu);
        $tpl->status_class = $status->alert;

        $num_oc++;
        $tpl->NOTIFICATION = $notification;
        $tpl->block('BLOCK_NOTIFICATION');
    }

    if (!$num_oc) {
        $tpl->block('BLOCK_NO_NOTIFICATION');
    }
} else {
    $tpl->block('BLOCK_NO_NOTIFICATION');
}

$users = \App\Model\User::getCompanyUsers(\App\Model\Company::getCompany());
if (!empty($users)) {
    foreach ($users as $user) {
        $user = (new App\Model\User)->fetch($user->user);
        $idUser = $user->getID();
        $Name = $user->getName();
        $Apelido = $user->getLast_name();
        if ($iduser == $idUser) {
            $tpl->SELECTED2 = 'selected';
        } else {
            $tpl->SELECTED2 = '';
        }
        $tpl->USERID = $idUser;
        $tpl->NAME_USER = $Name . ' ' . $Apelido;
        $tpl->block('BLOCK_USER2');
    }
}

$st = array();
$st['V1'] = [1];
$st['V2'] = [10, '', 2];
foreach ($st['V1'] as $s) {
    foreach ($st['V2'] as $l) {
        if ($l == 2) {
            $s = 0;
            $status2 = \Cosmos\System\Helper::getStatusNotification($s, $l);
        } else {
            $status2 = \Cosmos\System\Helper::getStatusNotification($s, $l);
        }

        foreach ($status2 as $sta => $value) {
            if ($sta === 'status') {
                $valst = (new \App\Model\Translate())->translater($value);
                $valst2 = $value;
                $tpl->TEXTST = $valst;
                if ($idstatus == $valst2) {
                    $tpl->SELECTED = 'selected';
                } else {
                    $tpl->SELECTED = '';
                }
                $tpl->TEXTST2 = $valst2;
                $tpl->block('BLOCK_STATUS');
            }
        }
    }
}

$tpl->show();
