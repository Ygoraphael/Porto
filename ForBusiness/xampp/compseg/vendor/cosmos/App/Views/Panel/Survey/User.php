<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Cosmos\System\Template;

$tpl = new Template(APP_PATH_TPL . 'survey/surveystoanswer.html');
$parameters = [
    'user' => ['=', \App\Model\User::getUserLoged()->getId(), 'AND'],
    'table1' => ['=', "survey", 'AND'],
    'deleted' => ['=', 0]
];
$notifications = (new \App\Model\Notification)->listingRegisters($parameters);

if (!empty($notifications)) {
    foreach ($notifications as $notification) {
        $survey = (new \App\Model\Survey)->fetch($notification->getValue1());
        $notification->code = $survey->getCode();
        $notification->url = (\Cosmos\System\Helper::getNotificationUrl($notification->getType(), array($notification->getId())));
        $tpl->NOTIFICATION = $notification;
        $tpl->block('BLOCK_NOTIFICATION');
    }
} else {
    $tpl->BLOCK_NO_SURVEYSTOANSWER;
}

$tpl->show();
