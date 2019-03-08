<?php

namespace App\Controller;

use Cosmos\System\Controller;

class SafetyWalk extends Controller {

    private $safetywalk;
    private $response;
    private $users;
    private $start;
    private $type;
    private $profile;
    public static $types = [
        1 => 'Semana',
        2 => 'Mês',
        3 => 'Meses Pares',
        4 => 'Meses Ímpares'
    ];

    function __construct() {
        $month = date('m');
        $year = date('Y');
        $day = date("d", mktime(0, 0, 0, $month + 1, 0, $year));
        $daystart = date('Y-m-d', mktime(0, 0, 0, $month - 1, $day, $year));
        $dayend = date('Y-m-d', mktime(0, 0, 0, $month, $day, $year));

        $_SESSION['day_start'] = $daystart;
        $_SESSION['day_end'] = $dayend;
        $this->requiresAuthentication();
        $this->users = \App\Model\User::getAllUsers();
        parent::__construct($this);
    }

    public function index() {
        $this->load('SafetyWalk');
    }

    public function answer() {
        if (func_num_args()) {
            $notification_id = (int) func_get_arg(0);
            $_GET['id'] = $notification_id;
            $this->load("{$this->directory}/SafetyWalk", 'Answer');
        } else {
            \Cosmos\System\Helper::redirect('/panel/safetywalks');
        }
    }

    public function viewanswer() {
        if (func_num_args()) {
            $id = (int) func_get_arg(0);
            $_GET['id'] = $id;
            $this->load("{$this->directory}/SafetyWalk", 'ViewAnswer');
        } else {
            \Cosmos\System\Helper::redirect('/safetywalk/safetywalks');
        }
    }

    //**New Safety walk to PC**//
    public function newswp() {
        $this->load("{$this->directory}/SafetyWalk", 'New_pc');
    }

    //**New Safety walk to Phone**//
    public function newswph() {
        $this->load("{$this->directory}/SafetyWalk", 'New_phone');
    }

    public function view() {
        $safetywalk_id = (int) func_get_arg(0);
        if ((new \App\Model\SafetyWalk())->fetch($safetywalk_id)) {
            $_GET['id'] = $safetywalk_id;
            $this->load("{$this->directory}/SafetyWalk", 'View');
        } else {
            \Cosmos\System\Helper::redirect('/panel/safetywalks');
        }
    }

    //**Duplicate Safety walk to PC**//
    public function duplicateSwP() {
        $safetywalk_id = (int) func_get_arg(0);
        if ((new \App\Model\SafetyWalk())->fetch($safetywalk_id)) {
            $_GET['id'] = $safetywalk_id;
            $this->load("{$this->directory}/SafetyWalk", 'DuplicateSwP');
        } else {
            \Cosmos\System\Helper::redirect('/panel/safetywalks');
        }
    }

    //**Duplicate Safety walk to Phone**//
    public function duplicateSwPh() {
        $safetywalk_id = (int) func_get_arg(0);
        if ((new \App\Model\SafetyWalk())->fetch($safetywalk_id)) {
            $_GET['id'] = $safetywalk_id;
            $this->load("{$this->directory}/SafetyWalk", 'duplicateSwPh');
        } else {
            \Cosmos\System\Helper::redirect('/panel/safetywalks');
        }
    }

    //**Edit Safety walk to PC**//
    public function editswp() {
        $sw_id = (int) func_get_arg(0);
        $safetywalk = (new \App\Model\SafetyWalk())->fetch($sw_id);
        if ($safetywalk) {
            $parameters = [
                'safetywalk' => ['=', $safetywalk->getId()]
            ];
            $Answersw = (new \App\Model\SafetyWalkAnswer())->listingRegisters($parameters);
            if ($Answersw) {
                //**ONLY EDIT QTT **//
                $_GET['id'] = $safetywalk->getId();
                $this->load("{$this->directory}/SafetyWalk", 'Edit_pc_swResp');
            } else {
                //**EDIT ALL**//
                $_GET['id'] = $safetywalk->getId();
                $this->load("{$this->directory}/SafetyWalk", 'Edit_pc_sw');
            }
        } else {
            \Cosmos\System\Helper::redirect('/panel/safetywalks');
        }
    }

    //**Edit Safety walk to Phone**//
    public function editswph() {
        $sw_id = (int) func_get_arg(0);
        $safetywalk = (new \App\Model\SafetyWalk())->fetch($sw_id);
        if ($safetywalk) {
            $parameters = [
                'safetywalk' => ['=', $safetywalk->getId()]
            ];
            $Answersw = (new \App\Model\SafetyWalkAnswer())->listingRegisters($parameters);
            if ($Answersw) {
                //**ONLY EDIT QTT **//
                $_GET['id'] = $safetywalk->getId();
                $this->load("{$this->directory}/SafetyWalk", 'Edit_phone_swResp');
            } else {
                //**EDIT ALL**//
                $_GET['id'] = $safetywalk->getId();
                $this->load("{$this->directory}/SafetyWalk", 'Edit_phone_sw');
            }
        } else {
            \Cosmos\System\Helper::redirect('/panel/safetywalks');
        }
    }

    //**Save Edit Safety walk when has amswer **//
    public function saveEdit_sw_resp() {
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $qtt = filter_input(INPUT_POST, 'qtt', FILTER_SANITIZE_NUMBER_INT);

        $this->safetywalk = (new \App\Model\SafetyWalk())->fetch($id);
        $this->safetywalk->saveEdit_sw_resp();

        if ($this->safetywalk->getMessage()->getType() == true) {
            $this->response['type'] = 1;
            $this->response['message'] = '%%Safety Walk edit successfully%%!';
        } else {
            $this->response['message'] = '%%Unable to edit Safety Walk%%!';
            $this->response['type'] = 0;
        }

        \Cosmos\System\Helper::my_session_start();
        $_SESSION['user_message']['msg'] = $this->response['message'];
        $_SESSION['user_message']['type'] = $this->response['type'];
        echo json_encode($this->response);
    }

    //**Save Edit Safety walk when dont has amswer **//
    public function saveEdit_sw() {
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $parameters = [
            'safetywalk' => ['=', $id]
        ];
        $Questions = (new \App\Model\SafetyWalkQuestion())->listingRegisters($parameters);
        if ($Questions) {
            foreach ($Questions as $Question) {
                $idQuestion = $Question->getId();
                $this->question = (new \App\Model\SafetyWalkQuestion())->fetch($idQuestion);
                $this->question->ShadowQuestion();
            }
        }
        $qtt = filter_input(INPUT_POST, 'qtt', FILTER_SANITIZE_NUMBER_INT);
        $this->safetywalk = (new \App\Model\SafetyWalk())->fetch($id);
        $this->safetywalk->saveEdit_sw_resp();
        $this->helperCreateQuestion_EDIT();

        \Cosmos\System\Helper::my_session_start();
        $_SESSION['user_message']['msg'] = $this->response['message'];
        $_SESSION['user_message']['type'] = $this->response['type'];
        echo json_encode($this->response);
    }

    private function helperCreateQuestion_EDIT() {
        $content = json_decode(rawurldecode(filter_input(INPUT_POST, 'content', FILTER_SANITIZE_STRING)), true);

        $ord = 0;
        foreach ($content as $row) {
            $safetywalk_question = (new \App\Model\SafetyWalkQuestion());
            $safetywalk_question->setSafetyWalk($this->safetywalk);
            $safetywalk_question->setText($row["text"]);
            $safetywalk_question->setOrd($ord);
            $safetywalk_question->setCheckbox(($row["checkbox"] == 1 ? 1 : 0));
            $safetywalk_question->insert();
            if ($safetywalk_question->getMessage()->getType() == TRUE) {
                $this->response['type'] = 1;
                $this->response['message'] = '%%Safety Walk Edit successfully%%!';
            }
            $ord++;
        }
    }

    public function safetywalks() {
        if (func_num_args()) {
            parse_str( str_replace("?", "", func_get_arg(0)), $t);
            
            $_GET['dls'] = $t["s2"];
            $_GET['dle'] = $t["e2"];

            $_GET['user'] = $t["t"];
            $_GET['status'] = $t["t2"];
            
            $this->load("{$this->directory}/SafetyWalk", 'SafetyWalks');
        } else {
            $_GET['dls'] = $_SESSION['day_start'];
            $_GET['dle'] = $_SESSION['day_end'];

            $_GET['user'] = 0;
            $_GET['status'] = 100;
            
            $this->load("{$this->directory}/SafetyWalk", 'SafetyWalks');
        }
    }

    public function swtoanswer() {
        if (func_num_args()) {
            $t = explode("=", func_get_arg(0));
            $this->load("{$this->directory}/SafetyWalk", 'SafetyWalksToAnswer');
        } else {
            $_GET['s'] = '';
            $_GET['e'] = '';
            $this->load("{$this->directory}/SafetyWalk", 'SafetyWalksToAnswer');
        }
    }

    public function delete() {
        $this->safetywalk = (new \App\Model\SafetyWalk());
        $this->status = $this->safetywalk->delete();
        if ($this->status) {
            $this->response['type'] = 1;
            $this->response['message'] = '%%Safety Walk deleted successfully%%!';
        }
        \Cosmos\System\Helper::my_session_start();
        $_SESSION['user_message']['msg'] = $this->response['message'];
        $_SESSION['user_message']['type'] = $this->response['type'];
        echo json_encode($this->response);
    }

    public function save() {
        $this->start = filter_input(INPUT_POST, 'start', FILTER_SANITIZE_STRING);
        $this->type = filter_input(INPUT_POST, 'validate', FILTER_SANITIZE_STRING);
        $this->helperSaveSafetyWalk();
        \Cosmos\System\Helper::my_session_start();
        $_SESSION['user_message']['msg'] = $this->response['message'];
        $_SESSION['user_message']['type'] = $this->response['type'];
        echo json_encode($this->response);
    }

    public function saveedit() {
        $this->helperSaveAnswer();
        \Cosmos\System\Helper::my_session_start();
        $_SESSION['user_message']['msg'] = $this->response['message'];
        $_SESSION['user_message']['type'] = $this->response['type'];
        echo json_encode($this->response);
    }

    private function helperSaveAnswer() {

        foreach ($_POST as $key => $post) {
            if (!is_array($post) && ($key != 'survey') && ($key)) {
                $survey_answer = new \App\Model\SurveyAnswer;
                $survey_answer->setSurvey_question($_POST['id'][$key]);
                $survey_answer->setUser(\App\Model\User::getUserLoged()->getId());
                $survey_answer->setValue($post);
                $survey_answer->insert();
            }
        }
        if ($survey_answer->getMessage()->getType() == 1) {
            
        }
    }

    private function setStatusSurveyForUser() {
        $survey = filter_input(INPUT_POST, 'survey', FILTER_SANITIZE_NUMBER_INT);
        $parameters = [
            'survey' => ['=', $survey, 'AND'],
            'user' => ['=', \App\Model\User::getUserLoged()->getId()]
        ];
        $surveyUser = (new \App\Model\SurveyUser)->listingRegisters($parameters)[0];
        $surveyUser->setStatus(1);
        $surveyUser->update();
        if ($surveyUser->getMessage()->getType() == 1) {
            $this->response['message'] = '%%Safety Walk answered successfully%%!';
            $this->response['type'] = 1;
        }
    }

    private function helperSaveSafetyWalk() {
        if (!empty($_POST['content'])) {

            $this->safetywalk = (new \App\Model\SafetyWalk);
            $this->safetywalk->setCode(\Cosmos\System\Helper::createCode());
            $this->safetywalk->setStarted_at($this->start);
            $this->safetywalk->setLast_notification($this->start);
            $this->safetywalk->setQtt(filter_input(INPUT_POST, 'qtt', FILTER_SANITIZE_STRING));
            $this->safetywalk->setType(filter_input(INPUT_POST, 'type', FILTER_SANITIZE_STRING));
            $this->safetywalk->setProfile(filter_input(INPUT_POST, 'profile', FILTER_SANITIZE_STRING));
            $this->safetywalk->insert();
            $this->safetywalk = $this->safetywalk->getMessage()->getId();

            $this->helperCreateQuestion();
        }
    }

    private function helperCreateQuestion() {
        $content = json_decode(rawurldecode(filter_input(INPUT_POST, 'content', FILTER_SANITIZE_STRING)), true);

        $ord = 0;
        foreach ($content as $row) {
            $safetywalk_question = (new \App\Model\SafetyWalkQuestion());
            $safetywalk_question->setSafetyWalk($this->safetywalk);
            $safetywalk_question->setText($row["text"]);
            $safetywalk_question->setOrd($ord);
            $safetywalk_question->setCheckbox(($row["checkbox"] == 1 ? 1 : 0));
            $safetywalk_question->insert();
            if ($safetywalk_question->getMessage()->getType() == 1) {
                $this->response['type'] = 1;
                $this->response['message'] = '%%Safety Walk created successfully%%!';
            }
            $ord++;
        }
        $this->helperSWEvent();
    }

    private function helperSWEvent() {
        $survey = (new \App\Model\SafetyWalk())->startEventSWNotification();
    }

    private function helperSurveyForUser() {
        if (isset($_POST['company'])) {
            if (!in_array(0, $_POST['company'])) {
                foreach ($_POST['company'] as $company_id) {
                    $users = \App\Model\User::getCompanyUsers((new \App\Model\Company)->fetch($company_id));
                    foreach ($users as $user) {
                        $survey_user = (new \App\Model\SurveyUser);
                        $survey_user->setUser($user->user);
                        $survey_user->setSurvey($this->survey);
                        $survey_user->insert();
                    }
                }
            } elseif ($_POST['company'][0] == 0) {
                $this->helperSurveyUsers();
            } else {
                $this->users = \App\Model\User::getCompanyUsers((new \App\Model\Company)->fetch($_POST['company'][0]));
                $this->helperSurveyUsers();
            }
        } else {
            $type = (new \App\Model\UserType)->fetch(\App\Model\User::getUserLoged()->getUser_type());
            if (($type->getLevel() == 2)) {
                $user_license = \App\Model\UserLicense::getLisence(\App\Model\User::getUserLoged());
                $users = \App\Model\User::getCompanyUsers((new \App\Model\Company)->fetch($user_license->getCompany()));
                foreach ($users as $user) {
                    $survey_user = (new \App\Model\SurveyUser);
                    $survey_user->setUser($user->user);
                    $survey_user->setSurvey($this->survey);
                    $survey_user->insert();
                }
            }
        }
    }

}
