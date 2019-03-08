<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Cosmos\System\Template;

$tpl = new Template(APP_PATH_TPL . 'panel/surveys/administrator.html');
$parameters = [
    'deleted' => ['<', 1, 'ORDER BY validate ASC']
];
$surveys = (new App\Model\Survey())->listingRegisters($parameters);
if (!empty($surveys)) {
    foreach ($surveys as $survey) {
        $status = Cosmos\System\Helper::getStatusSurvey($survey->getStatus());
        $survey->setStatus($status->status);
        $survey->setCreated_at((new DateTime($survey->getCreated_at()))->format('d/m/Y H:i:s'));
        $survey->setValidate((new DateTime())->format('d/m/Y H:i:s'));
        $tpl->status_class = $status->alert;
        $tpl->SURVEY = $survey;
        $tpl->block('BLOCK_SURVEYS');
    }
    $tpl->block('BLOCK_LISTING_SURVEYS');
} else {
    $tpl->block('BLOCK_NO_SURVEYS');
}
$tpl->show();
