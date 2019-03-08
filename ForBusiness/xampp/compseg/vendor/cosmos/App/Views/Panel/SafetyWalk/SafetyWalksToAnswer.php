<?php

$start = $_GET['s'];
$start2 = $_GET['s'] . ' 23:59:59';
$end = $_GET['e'];
$end2 = $_GET['e'] . ' 23:59:59';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Cosmos\System\Template;

$tpl = new Template(APP_PATH_TPL . 'panel/safetywalks/swstoanswer.html');
$parameters = [
    'user' => ['=', \App\Model\User::getUserLoged()->getId(), 'AND'],
    'table1' => ['=', "safetywalk", 'AND'],
    'deleted' => ['=', 0]
];
$notifications = (new \App\Model\Notification)->listingRegisters($parameters);
$num_oc = 0;
if (!empty($notifications)) {
    foreach ($notifications as $notification) {
        $sw = (new \App\Model\SafetyWalk)->fetch($notification->getValue1());
        $notification->code = $sw->getCode();
        $notification->url = (\Cosmos\System\Helper::getNotificationUrl($notification->getType(), array($notification->getId())));
        $tpl->NOTIFICATION = $notification;
        $mostra_registo = 1;
        if ($start != "") {
            if ($notification->getDate_limit() < $start2) {
                $mostra_registo = 0;
            }
        }
        if ($end != "") {
            if ($notification->getDate_limit() > $end2) {
                $mostra_registo = 0;
            }
        }

        if ($mostra_registo) {
            $num_oc++;
            $tpl->NOTIFICATION = $notification;
            $tpl->block('BLOCK_NOTIFICATION');
        }
    }if (!$num_oc) {
        $tpl->block('BLOCK_NO_SWTOANSWER');
    }
} else {
    $tpl->block('BLOCK_NO_SWTOANSWER');
}
$tpl->start = $start;
$tpl->END2 = $end;
$tpl->show();
