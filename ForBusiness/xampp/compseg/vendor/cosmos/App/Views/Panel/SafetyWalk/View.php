<?php

$id = $_GET['id'];

use Cosmos\System\Template;

$tpl = new Template(APP_PATH_TPL . 'panel/safetywalks/view.html');
$safetywalk = (new \App\Model\SafetyWalk())->fetch($id);

$parameters = [
    'safetywalk' => ['=', $id, "AND"],
	'deleted' => ['=', 0,"ORDER BY ORD"]
];
$safetywalk_rows = (new \App\Model\SafetyWalkQuestion)->listingRegisters($parameters);
foreach ($safetywalk_rows as $question) {
    $question->hide1 = ( $question->getCheckbox() == "1" ? 'hidden' : '' );
    $question->hide2 = ( $question->getCheckbox() == "1" ? '' : 'hidden' );
            
    $tpl->QUESTION = $question;
    $tpl->block('BLOCK_QUESTION');
}

$parameters = [
    'deleted' => ['=', 0, 'ORDER BY name']
];
$sectors = (new \App\Model\Sector)->listingRegisters($parameters);
foreach ($sectors as $sector) {
    $tpl->SECTOR = $sector;
    $tpl->block('BLOCK_SECTOR');
}

$tpl->USER = App\Model\User::getUserLoged()->getName() . " " . App\Model\User::getUserLoged()->getLast_name();
$tpl->DATE = date("Y-m-d");
$tpl->HOUR = date("H:i");
$tpl->TITLE = "%%Safety Walk%%";

$tpl->show();
