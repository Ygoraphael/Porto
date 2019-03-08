<?php

namespace App\Controller;

use Cosmos\System\Controller;

class SafetyWalkAnswer extends Controller {

    private $safetywalk_answer;
    private $response;
    private $user;
    private $safetywalk;

    function __construct() {
        $this->requiresAuthentication();
        $this->users = \App\Model\User::getAllUsers();
        parent::__construct($this);
    }

    public function index() {
        $this->load('SafetyWalkQuestion');
    }

    public function save() {
        $this->helperSaveAnswer();
        \Cosmos\System\Helper::my_session_start();
        $_SESSION['user_message']['msg'] = $this->response['message'];
        $_SESSION['user_message']['type'] = $this->response['type'];
        echo $this->response['type'];
    }

    private function helperSaveAnswer() {
        if (!empty($_POST['questions']) && !empty($_POST['notification_id'])) {
            $notification_id = filter_input(INPUT_POST, 'notification_id', FILTER_SANITIZE_NUMBER_INT);
            $sector_id = filter_input(INPUT_POST, 'sector_id', FILTER_SANITIZE_NUMBER_INT);

            $notification = (new \App\Model\Notification())->fetch($notification_id);

            if ($notification->getUser() == \App\Model\User::getUserLoged()->getId()) {
                $this->safetywalk_answer = new \App\Model\SafetyWalkAnswer;
                $this->safetywalk_answer->setUser(\App\Model\User::getUserLoged()->getId());
                $this->safetywalk_answer->setSafetyWalk($notification->getValue1());
                $this->safetywalk_answer->setSector($sector_id);
                $this->safetywalk_answer->setComment(filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_STRING));
                $this->safetywalk_answer->setUserFollow(filter_input(INPUT_POST, 'userfollow', FILTER_SANITIZE_STRING));
                $this->safetywalk_answer->insert();

                $this->safetywalk_answer = $this->safetywalk_answer->getMessage()->getId();
                $this->helperCreateAnswerQuestion();
            } else {
                //sem permissao
            }
        }
    }

    private function helperCreateAnswerQuestion() {
        if (!empty($_POST['questions'])) {
            $answers = json_decode(rawurldecode(filter_input(INPUT_POST, 'questions', FILTER_SANITIZE_STRING)), true);

            if (!empty($answers)) {
                foreach ($answers as $answer) {
                    $safetywalk_answer_question = new \App\Model\SafetyWalkAnswerQuestion;
                    $safetywalk_answer_question->setSafetyWalkAnswer($this->safetywalk_answer);
                    $safetywalk_answer_question->setSafetyWalkQuestion($answer["id"]);
                    $safetywalk_answer_question->setValue($answer["checked"]);
                    $safetywalk_answer_question->insert();
                    if ($safetywalk_answer_question->getMessage()->getType() == 1) {
                        $this->response['type'] = 1;
                        $this->response['message'] = '%%Safety Walk answered successfully%%!';
                    }
                }
            } else {
                $this->response['type'] = 1;
                $this->response['message'] = '%%Safety Walk answered successfully%%!';
            }

            $notification_id = $_POST['notification_id'];
            $notification = (new \App\Model\Notification())->fetch($notification_id);
            $notification->setDeleted(1);
            $notification->setTable2("safetywalkanswer");
            $notification->setValue2($this->safetywalk_answer);
            $notification->update();
        }
    }

}
