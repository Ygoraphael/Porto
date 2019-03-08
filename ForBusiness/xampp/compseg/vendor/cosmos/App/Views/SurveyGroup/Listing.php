<?php

$country = filter_input(INPUT_POST, 'data', FILTER_SANITIZE_NUMBER_INT);

use Cosmos\System\Template;

$tpl = new Template(APP_PATH_TPL . 'surveygroup/listing.html');

$parameters = [
    'deleted' => ['<', 1]
];
$groups = (new \App\Model\SurveyGroup)->listingRegisters($parameters);
foreach ($groups as $group) {
    $tpl->TEXT = $group->getDescription();
    $tpl->VALUE = $group->getId();
    $tpl->block('BLOCK_SURVEY_GROUP');
}
$tpl->show();
