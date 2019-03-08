<?php

$id = $_GET['id'];

use Cosmos\System\Template;

$tpl = new Template(APP_PATH_TPL . 'panel/surveys/form_survey3.html');
$survey = (new \App\Model\Survey())->fetch($id);
$tpl->DISALBLE = "disabled";
$parameters = [
    'deleted' => ['<', 1]
];
$companys = (new App\Model\Company)->listingRegisters($parameters);
if (App\Model\User::getUserLoged()->getUser_type() == 1) {
    if (!empty($companys)) {
        foreach ($companys as $company) {
            $tpl->NAME = $company->getConfig()->getName();
            $tpl->VALUE = $company->getId();
            $tpl->block('BLOCK_SELECT_COMPANY');
        }
    }
    $tpl->block('BLOCK_BTN_NEW_SURVEY');
}

foreach (\App\Controller\Survey::$types as $key => $type) {
	if( $survey->getType() == $key){
		$tpl->Selected2 = "selected";
	}else{
		$tpl->Selected2 = "";
	}
    $tpl->TEXT = $type;
    $tpl->VALUE = $key;
    $tpl->block('BLOCK_SELECT_TYPE_DATE');
}
$tpl->block('BLOCK_BTN_EDIT_SURVEY');

$parameters = [
    'survey' => ['=', $id, 'AND'],
	'deleted' => ['=', 0]
];
$survey_rows = (new \App\Model\SurveyQuestion)->listingRegisters($parameters);

    $last_type = "";
    $last_code = "";
    $last_questions = array();

    $questions = "";
if(!empty($survey_rows)) {
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
}

    if (!empty($questions)) {
        $questions = substr($questions, 0, strlen($questions) - 1);
    }
$parameters = [
    'deleted' => ['=', 0]
];
$profiles = (new App\Model\Profile)->listingRegisters($parameters);
if (!empty($profiles)) {
    foreach ($profiles as $profile) {
		$PROFILE = (new \App\Model\Translate())->translater($profile->getName());
		$profile->setName($PROFILE);
		$idprofile= $profile->getId();
		if($idprofile == $survey->getProfile() ){
			$tpl->Selected = "selected";
		}else{
			$tpl->Selected = "";
		}
        $tpl->SELECT_PROFILE = $profile;
        $tpl->block('BLOCK_SELECT_PROFILE');
    }
}
$tpl->NOT_ID = $id;
$tpl->SURVEY_CONTENT = rawurlencode('{"pages":[{"elements":[' . $questions . '],"name":"page1"}]}');
$tpl->SURVEY_QTT = $survey->getQtt();
$tpl->SURVEY_TYPE = $survey->getType();
$tpl->SURVEY_DATE_START = "";
$tpl->block('BLOCK_SURVEY');
$tpl->TITLE = "%%Edit Survey%%";
$time = explode(" ", $survey->getCreated_at());
$DS = $time[0];
$date = (new DateTime());
$tpl->DATE_START = $DS;
$parameters = [
    'deleted' => ['=', 0]
];
$categories = (new App\Model\Category)->listingRegisters($parameters);
$tmp = array();
if (!empty($categories)) {
    foreach ($categories as $category) {
        $tmp[] = $category->getName();
    }
}
$tmp = rawurlencode(json_encode($tmp));
$tpl->SURVEY_CATS = $tmp;
$tpl->show();
