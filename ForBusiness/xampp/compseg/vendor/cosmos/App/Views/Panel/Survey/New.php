<?php

use Cosmos\System\Template;

$tpl = new Template(APP_PATH_TPL . 'panel/surveys/form_survey.html');
$translate = (new \App\Model\Translate());
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
foreach (\App\Controller\Survey::$types as $key => $type) {
    $tpl->TEXT = $type;
    $tpl->VALUE = $key;
    $tpl->block('BLOCK_SELECT_TYPE_DATE');
}
$tpl->TITLE = ('%%New Survey%%');
$date = (new DateTime());
$tpl->DATE_START = $date->format('Y-m-d');

$parameters = [
    'deleted' => ['=', 0]
];
$categories = (new App\Model\Category)->listingRegisters($parameters);
$tmp = array();
if (!empty($categories)) {
    foreach ($categories as $category) {
        $tmp[] = $category->getName();
    }
}
$tmp = rawurlencode(json_encode($tmp));
$tpl->SURVEY_CATS = $tmp;

$tpl->show();
