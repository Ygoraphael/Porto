<?php

$notification_id = $_GET['id'];
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Cosmos\System\Template;

$tpl = new Template(APP_PATH_TPL . 'survey/index.html');

$parameters = [
    'idNotification' => ['=', $notification_id, 'AND'],
    'table1' => ['=', "survey", 'AND'],
    'deleted' => ['=', 0],
];
$notifications = (new \App\Model\Notification)->listingRegisters($parameters);
if (!empty($notifications)) {
    $notification = $notifications[0];

    $id = $notification->getValue1();
    $survey = (new \App\Model\Survey())->fetch($id);

    $parameters = [
        'survey' => ['=', $id, 'AND'],
		'deleted' => ['=', 0]
    ];
    $survey_rows = (new \App\Model\SurveyQuestion)->listingRegisters($parameters);

    $last_type = "";
    $last_code = "";
    $last_questions = array();

    $questions = "";

    foreach ($survey_rows as $question) {
        if ($last_code != $question->getCode()) {
            if ($last_type == "matrix") {
                if ($question->getType() == "matrix") {
                    //inserir matrix
                    $tmp_data = json_decode($last_question->getContext(), true);
                    if (empty($tmp_data["title"])) {
                        $tmp_data["title"] = $tmp_data["name"];
                    }
                    unset($tmp_data["rows"]);
                    unset($tmp_data["name"]);
                    $tmp_data["name"] = "matrix";
                    $tmp_data["rows"] = $last_questions;
                    $last_questions = array();
                    $questions .= json_encode($tmp_data) . ",";
                } else {
                    //inserir matrix
                    $tmp_questions = array();
                    $tmp_questions["value"] = $question->getId();
                    $tmp_questions["text"] = $question->getText();
                    $last_questions[] = $tmp_questions;

                    $tmp_data = json_decode($last_question->getContext(), true);
                    if (empty($tmp_data["title"])) {
                        $tmp_data["title"] = $tmp_data["name"];
                    }
                    unset($tmp_data["rows"]);
                    unset($tmp_data["name"]);
                    $tmp_data["name"] = "matrix";
                    $tmp_data["rows"] = $last_questions;
                    $last_questions = array();
                    $questions .= json_encode($tmp_data) . ",";
                }
            } else {
                if ($question->getType() == "matrix") {
                    $tmp_questions = array();
                    $tmp_questions["value"] = $question->getId();
                    $tmp_questions["text"] = $question->getText();
                    $last_questions[] = $tmp_questions;
                } else {
                    //inserir normal
                    $tmp_data = json_decode($question->getContext(), true);
                    unset($tmp_data["name"]);
                    $tmp_data["name"] = $question->getId();
                    $questions .= json_encode($tmp_data) . ",";
                }
            }
        } else {
            if ($question->getType() == "matrix") {
                $tmp_questions = array();
                $tmp_questions["value"] = $question->getId();
                $tmp_questions["text"] = $question->getText();

                $last_questions[] = $tmp_questions;
            } else {
                //inserir normal
                $tmp_data = json_decode($question->getContext(), true);
                unset($tmp_data["name"]);
                $tmp_data["name"] = $question->getId();
                $questions .= json_encode($tmp_data) . ",";
            }
        }

        $last_code = $question->getCode();
        $last_type = $question->getType();
        $last_question = $question;
    }

    if ($last_type == "matrix") {
        //inserir matrix
        $tmp_data = json_decode($last_question->getContext(), true);
        if (empty($tmp_data["title"])) {
            $tmp_data["title"] = $tmp_data["name"];
        }
        unset($tmp_data["rows"]);
        unset($tmp_data["name"]);
        $tmp_data["name"] = "matrix";
        $tmp_data["rows"] = $last_questions;
        $last_questions = array();
        $questions .= json_encode($tmp_data) . ",";
    }

    if (!empty($questions)) {
        $questions = substr($questions, 0, strlen($questions) - 1);
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
    $tpl->SURVEY_CONTENT = rawurlencode('{"pages":[{"elements":[' . $questions . '],"name":"page1"}]}');
    $tpl->block('BLOCK_SURVEY');

    $tpl->show();
}


