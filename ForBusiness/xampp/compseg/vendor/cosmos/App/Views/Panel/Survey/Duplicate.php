<?php

$id = $_GET['id'];

use Cosmos\System\Template;

$tpl = new Template(APP_PATH_TPL . 'panel/surveys/form_survey.html');
$parameters = [
    'deleted' => ['<', 1]
];
$companys = (new App\Model\Company)->listingRegisters($parameters);
if (App\Model\User::getUserLoged()->getUser_type() == 1) {
    if (!empty($companys)) {
        foreach ($companys as $company) {
            $tpl->NAME = $company->getConfig()->getName();
            $tpl->VALUE = $company->getId();
            $tpl->block('BLOCK_SELECT_COMPANY');
        }
    }
    $tpl->block('BLOCK_BTN_NEW_SURVEY');
}

foreach (\App\Controller\Survey::$types as $key => $type) {
    $tpl->TEXT = $type;
    $tpl->VALUE = $key;
    $tpl->block('BLOCK_SELECT_TYPE_DATE');
}
$tpl->block('BLOCK_BTN_EDIT_SURVEY');

$survey = (new \App\Model\Survey())->fetch($id);

$parameters = [
    'survey' => ['=', $id, 'AND'],
	'deleted' => ['=', 0]
];
$survey_rows = (new \App\Model\SurveyQuestion)->listingRegisters($parameters);

$codes_assigned = array();
$questions = "";
foreach ($survey_rows as $question) {
    if ($question->getType() == "matrix") {
        if (!in_array($question->getCode(), $codes_assigned)) {
            $codes_assigned[] = $question->getCode();
            $questions .= $question->getContext() . ",";
        }
    } else {
        $questions .= $question->getContext() . ",";
    }
}
if (!empty($questions)) {
    $questions = substr($questions, 0, strlen($questions) - 1);
}

$parameters = [
    'deleted' => ['=', 0]
];
$profiles = (new App\Model\Profile)->listingRegisters($parameters);
if (!empty($profiles)) {
    foreach ($profiles as $profile) {
		$PROFILE = (new \App\Model\Translate())->translater($profile->getName());
		$profile->setName($PROFILE);
        $tpl->SELECT_PROFILE = $profile;
        $tpl->block('BLOCK_SELECT_PROFILE');
    }
} 

$tpl->SURVEY_CONTENT = rawurlencode('{pages:[{elements:[' . $questions . '],name:"page1"}]}');
$tpl->SURVEY_QTT = "";
$tpl->SURVEY_TYPE = "";
$tpl->SURVEY_DATE_START = "";

$tpl->TITLE = ('%%New Survey%%');

$date = (new DateTime());
$tpl->DATE_START = $date->format('Y-m-d');
$tpl->show();
