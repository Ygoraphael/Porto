<?php

$notification_id = $_GET['id'];

use Cosmos\System\Template;

$tpl = new Template(APP_PATH_TPL . 'panel/securitydialog/answer.html');

$parameters = [
    'idNotification' => ['=', $notification_id, 'AND'],
    'table1' => ['=', "securitydialogweek", 'AND'],
    'deleted' => ['=', 0],
];
$notifications = (new \App\Model\Notification)->listingRegisters($parameters);

if (!empty($notifications)) {
    $notification = $notifications[0];
    $id = $notification->getValue1();
    $dialogweek = (new \App\Model\SecurityDialogWeek)->fetch($id);
    $dialog = (new \App\Model\SecurityDialog)->fetch($dialogweek->getSecurityDialog());
    $tpl->DIALOG = $dialog;

    $user = (new \App\Model\User())->fetch(\App\Model\User::getUserLoged()->getId());
    $tpl->USER = $user;
    $tpl->NOT_ID = $notification_id;
    $tpl->DATE_ANSWER = date('Y-m-d');


    $tpl->show();
}