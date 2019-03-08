<?php

$notification_id = $_GET['id'];
use Cosmos\System\Template;

$tpl = new Template(APP_PATH_TPL . 'panel/safetywalks/Viewanswer.html');

$parameters = [
    'idNotification' => ['=', $notification_id, 'AND'],
    'table1' => ['=', "safetywalk", 'AND'],
    'deleted' => ['=', 1],
];
$notifications = (new \App\Model\Notification)->listingRegisters($parameters);

if (!empty($notifications)) {
    $notification = $notifications[0];
    $sw_id = $notification->getValue1();
    $sw = (new \App\Model\SafetyWalk)->fetch($sw_id);

    $parameters = [
        'safetywalk' => ['=', $sw_id, 'AND'],
		'deleted' => ['=', 0,"ORDER BY ORD"]
    ];
    $swQuestions = (new \App\Model\SafetyWalkQuestion)->listingRegisters($parameters);
    $swAnswer = (new \App\Model\SafetyWalkAnswer)->fetch($notification->getValue2());

    $parameters = [
        'safetywalkanswer' => ['=', $swAnswer->getId()]
    ];
    $surveyAnswerQuestions = (new \App\Model\SafetyWalkAnswerQuestion)->listingRegisters($parameters);

    $user = (new \App\Model\User)->fetch($notification->getUser());
    $sector = (new \App\Model\Sector)->fetch($swAnswer->getSector());

    $parameters = [
        'safetywalk' => ['=', $sw_id, "ORDER BY ORD"]
    ];
    $safetywalk_rows = (new \App\Model\SafetyWalkQuestion)->listingRegisters($parameters);
    foreach ($safetywalk_rows as $question) {
        $question->hide1 = ( $question->getCheckbox() == "1" ? 'hidden' : '' );
        $question->hide2 = ( $question->getCheckbox() == "1" ? '' : 'hidden' );

        $parameters = [
            'safetywalkquestion' => ['=', $question->getId()]
        ];
        $sw_answer_question = (new \App\Model\SafetyWalkAnswerQuestion)->listingRegisters($parameters)[0];

        $question->checked = ( $sw_answer_question->getValue() == 1 ? "checked" : "" );

        $tpl->QUESTION = $question;
        $tpl->block('BLOCK_QUESTION');
    }

    $tpl->SECTOR = $sector->getName();
    $tpl->USER = $user->getName() . " " . $user->getLast_name();

    $date = new DateTime($swAnswer->getCreated_at());
    $tpl->DATE = date_format($date, 'Y-m-d');
    $tpl->HOUR = date_format($date, 'H:i');
    $tpl->USERFOLLOW = $swAnswer->getUserFollow();
    $tpl->COMMENT = $swAnswer->getComment();

    $tpl->show();
}