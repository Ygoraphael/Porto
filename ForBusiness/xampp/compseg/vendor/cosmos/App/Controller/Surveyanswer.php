<?php

namespace App\Controller;

use Cosmos\System\Controller;

class SurveyAnswer extends Controller {

    private $survey_answer;
    private $response;
    private $user;
    private $survey;

    function __construct() {
        $this->requiresAuthentication();
        $this->users = \App\Model\User::getAllUsers();
        parent::__construct($this);
    }

    public function index() {
        $this->load('SurveyQuestion');
    }

    public function save() {
        $this->helperSaveAnswer();
        \Cosmos\System\Helper::my_session_start();
        $_SESSION['user_message']['msg'] = $this->response['message'];
        $_SESSION['user_message']['type'] = $this->response['type'];
        echo $this->response['type'];
    }

    private function helperSaveAnswer() {
        if (!empty($_POST['content']) && !empty($_POST['notification_id'])) {
            $content = json_decode(rawurldecode($_POST['content']));
            $notification_id = $_POST['notification_id'];
            $sector_id = $_POST['sector_id'];

            $notification = (new \App\Model\Notification())->fetch($notification_id);

            if ($notification->getUser() == \App\Model\User::getUserLoged()->getId()) {
                $this->survey_answer = new \App\Model\SurveyAnswer;
                $this->survey_answer->setUser(\App\Model\User::getUserLoged()->getId());
                $this->survey_answer->setSurvey($notification->getValue1());
                $this->survey_answer->setSector($sector_id);
                $this->survey_answer->setContent($_POST['content']);
                $this->survey_answer->insert();

                $this->survey_answer = $this->survey_answer->getMessage()->getId();
                $this->helperCreateAnswerQuestion();
            } else {
                //sem permissao
            }
        }
    }

    private function helperCreateAnswerQuestion() {
        if (!empty($_POST['content'])) {
            $answers = json_decode(rawurldecode($_POST['content']));

            if (!empty((array)$answers)) {
                foreach ($answers as $key => $value) {
                    //matrix
                    if ($key == "matrix") {
                        foreach ($value as $key => $value) {
                            $survey_answer_question = new \App\Model\SurveyAnswerQuestion;
                            $survey_answer_question->setSurvey_answer($this->survey_answer);
                            $survey_answer_question->setSurvey_question($key);
                            $survey_answer_question->setValue($value);
                            $survey_answer_question->insert();
                            if ($survey_answer_question->getMessage()->getType() == 1) {
                                $this->response['type'] = 1;
                                $this->response['message'] = '%%Survey responded successfully%%!';
                            }
                        }
                    } else {
                        $survey_answer_question = new \App\Model\SurveyAnswerQuestion;
                        $survey_answer_question->setSurvey_answer($this->survey_answer);
                        $survey_answer_question->setSurvey_question($key);
                        if (is_array($value)) {
                            $survey_answer_question->setValue(json_encode($value));
                        } else {
                            $survey_answer_question->setValue($value);
                        }
                        $survey_answer_question->insert();
                        if ($survey_answer_question->getMessage()->getType() == 1) {
                            $this->response['type'] = 1;
                            $this->response['message'] = '%%Survey responded successfully%%!';
                        }
                    }
                }
            } else {
                $this->response['type'] = 1;
                $this->response['message'] = 'Observação respondida com sucesso!';
            }

            $notification_id = $_POST['notification_id'];
            $notification = (new \App\Model\Notification())->fetch($notification_id);
            $notification->setDeleted(1);
            $notification->setTable2("surveyanswer");
            $notification->setValue2($this->survey_answer);
            $notification->update();
        }
    }

}
