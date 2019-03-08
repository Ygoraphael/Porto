<?php

$notification_id = $_GET['id'];

use Cosmos\System\Template;

$tpl = new Template(APP_PATH_TPL . 'panel/securitydialog/viewanswer.html');

$parameters = [
    'idNotification' => ['=', $notification_id, 'AND'],
    'table1' => ['=', "securitydialogweek", 'AND'],
    'deleted' => ['=', 1],
];
$notifications = (new \App\Model\Notification)->listingRegisters($parameters);

if (!empty($notifications)) {
    $notification = $notifications[0];
    $securitydialogweek_id = $notification->getValue1();
    $securitydialogweek = (new \App\Model\SecurityDialogWeek)->fetch($securitydialogweek_id);

    $parameters = [
        'securitydialogweek' => ['=', $securitydialogweek_id, 'AND'],
        'user' => ['=', $notification->getUser()]
    ];

    $securitydialoganswer = (new \App\Model\SecurityDialogAnswer)->listingRegisters($parameters)[0];

    $dialog_id = $securitydialogweek->getSecurityDialog();
    $dialog = (new \App\Model\SecurityDialog)->fetch($dialog_id);

    $user = (new \App\Model\User)->fetch($securitydialoganswer->getUser());
    
    $dialog->attendance = $securitydialoganswer->getAttendance();
    $dialog->username = $user->getName() . ' ' . $user->getLast_name();
    $dialog->date_answer = substr($securitydialoganswer->getCreated_At(), 0, 10);

    $tpl->DIALOG = $dialog;

    $tpl->show();
}