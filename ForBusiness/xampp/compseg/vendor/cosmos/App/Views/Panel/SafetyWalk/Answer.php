<?php

$notification_id = $_GET['id'];
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Cosmos\System\Template;

$tpl = new Template(APP_PATH_TPL . 'panel/safetywalks/index.html');

$parameters = [
    'idNotification' => ['=', $notification_id, 'AND'],
    'table1' => ['=', "safetywalk", 'AND'],
    'deleted' => ['=', 0],
];
$notifications = (new \App\Model\Notification)->listingRegisters($parameters);

if (!empty($notifications)) {
    $notification = $notifications[0];

    $id = $notification->getValue1();
    $safetywalk = (new \App\Model\SafetyWalk())->fetch($id);

    $parameters = [
        'safetywalk' => ['=', $id, 'AND'],
		'deleted' => ['=', 0,"ORDER BY ORD"]
    ];
    $sw_rows = (new \App\Model\SafetyWalkQuestion)->listingRegisters($parameters);

    foreach ($sw_rows as $question) {
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

    $tpl->NOT_ID = $notification_id;
    $tpl->USER = App\Model\User::getUserLoged()->getName() . " " . App\Model\User::getUserLoged()->getLast_name();
    $tpl->DATE = date("Y-m-d");
    $tpl->HOUR = date("H:i");
    $tpl->TITLE = "Safety Walk";

    $tpl->show();
}