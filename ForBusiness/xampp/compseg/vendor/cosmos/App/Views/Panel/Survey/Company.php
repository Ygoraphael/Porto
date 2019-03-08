<?php

$idstatus = $_GET['t'];
$start = $_GET['s'];
$start2 = $_GET['s'] . ' 23:59:59';
$end = $_GET['e'];
$end2 = $_GET['e'] . ' 23:59:59';
$idprofile = $_GET['p'];

use Cosmos\System\Template;

$tpl = new Template(APP_PATH_TPL . 'panel/surveys/company.html');
$translate = (new \App\Model\Translate());
$filter = [
    'deleted' => ['=', 0, 'AND']
];

//data inicio e fim 
if ($start != "" && $end != "") {
    $dataf = $start2 . "' AND '" . $end2;
    $filter['created_at'] = ['BETWEEN', $dataf, 'AND'];
} else if ($start == "" && $date_end != "") {
    $filter['created_at'] = ['<=', $end2, 'AND'];
} else if ($start != "" && $date_end == "") {
    $filter['created_at'] = ['>=', $start2, 'AND'];
}

// Status
if ($idstatus != 100) {
    $filter['status'] = ['=', $idstatus, 'AND'];
}

if ($idprofile != 0) {
    $filter['profile'] = ['=', $idprofile, 'AND'];
}

$filter['idSurvey'] = ['>', 0, ''];

$surveys = (new \App\Model\Survey())->listingRegisters($filter);
if (!empty($surveys)) {
    foreach ($surveys as $survey) {
        $status = Cosmos\System\Helper::getStatusSurvey($survey->getStatus());
        $survey->setStatus($status->status);
        $type = Cosmos\System\Helper::getMonthTypeSurvey($survey->getType());
        $survey->setType($type);
        $survey->setCreated_at((new DateTime($survey->getCreated_at()))->format('d/m/Y H:i:s'));
        $tpl->status_class = $status->alert;

        error_log($survey->idSurvey);
        $profile = (new \App\Model\Profile())->fetch($survey->getProfile());
        $survey->setProfile($profile->getName());

        $tpl->ID = $survey->idSurvey;
        $tpl->SURVEY = $survey;
        $tpl->block('BLOCK_SURVEYS');
    }
    $tpl->block('BLOCK_LISTING_SURVEYS');
} else {
    $tpl->block('BLOCK_NO_SURVEYS');
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
            $tpl->TEXTST = $value;
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
$tpl->start = $start;
$tpl->END2 = $end;
$tpl->show();
