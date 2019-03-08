<?php

namespace App\Controller;

use Cosmos\System\Controller;

class Survey extends Controller {

    private $survey;
    private $response;
    private $users;
    private $start;
    private $finish;
    private $survey_repeater;
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
        $this->load('Survey');
    }

    public function answer() {
        $notification_id = (int) func_get_arg(0);
        $notification = (new \App\Model\Notification())->fetch($notification_id);

        $_GET['id'] = $notification_id;
        $this->load('Survey', 'Answer');
    }

    public function viewanswer() {
        if (func_num_args()) {
            $id = (int) func_get_arg(0);
            $_GET['id'] = $id;
            $this->load("{$this->directory}/Survey", 'ViewAnswer');
        } else {
            \Cosmos\System\Helper::redirect('/survey/surveys');
        }
    }

    public function new_survey() {
        $this->load("{$this->directory}/Survey", 'New');
    }

    public function edit() {
        $survey_id = (int) func_get_arg(0);
        if ((new \App\Model\Survey())->fetch($survey_id)) {
            $_GET['id'] = $survey_id;
            $parameters = [
                'survey' => ['=', $survey_id]
            ];
            $survey_answer = (new \App\Model\SurveyAnswer())->listingRegisters($parameters);
            if ($survey_answer) {
                $this->load("{$this->directory}/Survey", 'EditSurvey_Resp');
            } else {
                $this->load("{$this->directory}/Survey", 'EditSurvey');
            }
        } else {
            \Cosmos\System\Helper::redirect('/panel/surveys');
        }
    }

    public function view() {
        $survey_id = (int) func_get_arg(0);
        if ((new \App\Model\Survey())->fetch($survey_id)) {
            $_GET['id'] = $survey_id;
            $this->load("{$this->directory}/Survey", 'View');
        } else {
            \Cosmos\System\Helper::redirect('/panel/surveys');
        }
    }

    public function duplicate() {
        $survey_id = (int) func_get_arg(0);
        if ((new \App\Model\Survey())->fetch($survey_id)) {
            $_GET['id'] = $survey_id;
            $this->load("{$this->directory}/Survey", 'Duplicate');
        } else {
            \Cosmos\System\Helper::redirect('/panel/surveys');
        }
    }

    public function surveys() {
        if (func_num_args()) {           
            parse_str( str_replace("?", "", func_get_arg(0)), $t);
            
            $_GET['dls'] = $t["s2"];
            $_GET['dle'] = $t["e2"];

            $_GET['user'] = $t["t"];
            $_GET['status'] = $t["t2"];

            $this->load("Survey", 'Surveys');
        } else {
            $_GET['dls'] = $_SESSION['day_start'];
            $_GET['dle'] = $_SESSION['day_end'];

            $_GET['user'] = 0;
            $_GET['status'] = 100;
            
            $this->load("Survey", 'Surveys');
        }
    }

    public function surveystoanswer() {
        if (func_num_args()) {
            $t = explode("=", func_get_arg(0));
            $this->load("Survey", 'SurveysToAnswer');
        } else {
            $_GET['s'] = '';
            $_GET['e'] = '';
            $this->load("Survey", 'SurveysToAnswer');
        }
    }

    public function delete() {
        $this->survey = (new \App\Model\Survey());
        $this->status = $this->survey->delete();
        if ($this->status) {
            $this->response['type'] = 1;
            $this->response['message'] = '%%Survey deleted successfully%%!';
        }
        \Cosmos\System\Helper::my_session_start();
        $_SESSION['user_message']['msg'] = $this->response['message'];
        $_SESSION['user_message']['type'] = $this->response['type'];
        echo json_encode($this->response);
    }

    public function save() {
        $this->start = filter_input(INPUT_POST, 'start', FILTER_SANITIZE_STRING);
        $this->type = filter_input(INPUT_POST, 'validate', FILTER_SANITIZE_STRING);
        $this->helperSaveSurvey();

        \Cosmos\System\Helper::my_session_start();
        $_SESSION['user_message']['msg'] = $this->response['message'];
        $_SESSION['user_message']['type'] = $this->response['type'];
        echo json_encode($this->response);
    }

    public function UpdateSurvey() {
        $this->saveUpdate();

        \Cosmos\System\Helper::my_session_start();
        $_SESSION['user_message']['msg'] = $this->response['message'];
        $_SESSION['user_message']['type'] = $this->response['type'];
        echo json_encode($this->response);
    }

    private function saveUpdate() {
        $qtt = (filter_input(INPUT_POST, 'qtt', FILTER_SANITIZE_NUMBER_INT));
        $idsurvey = (filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT));
        $surveys = (new \App\Model\Survey())->fetch($idsurvey);
        if ($surveys) {
            $idsurvey2 = $surveys->getId();
            $this->survey = (new \App\Model\Survey())->fetch($idsurvey2);
            $this->survey->EditSurvey();
            if ($this->survey->getMessage()->getType() == 1) {
                $this->response['type'] = 1;
                $this->response['message'] = '%%Survey edit successfully%%!';
            } else {
                $this->response['message'] = '%%Unable to edit survey%%!';
                $this->response['type'] = 0;
            }
        }
    }

    public function editsurvey() {
        $this->saveEditsurvey();

        \Cosmos\System\Helper::my_session_start();
        $_SESSION['user_message']['msg'] = $this->response['message'];
        $_SESSION['user_message']['type'] = $this->response['type'];
        echo json_encode($this->response);
    }

    private function saveEditsurvey() {
        $idsurvey = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $qtt = filter_input(INPUT_POST, 'qtt', FILTER_SANITIZE_NUMBER_INT);
        $surveys = (new \App\Model\Survey())->fetch($idsurvey);
        if ($surveys) {
            $idsurvey2 = $surveys->getId();
            $parameters = [
                'survey' => ['=', $idsurvey2, 'AND'],
                'deleted' => ['=', 0]
            ];
            $questions = (new \App\Model\SurveyQuestion())->listingRegisters($parameters);
            if ($questions) {
                foreach ($questions as $question) {
                    $idQuestion = $question->getId();
                    $this->question = (new \App\Model\SurveyQuestion())->fetch($idQuestion);
                    $this->question->ShadowQuestion();
                }
            }
            $this->survey2 = (new \App\Model\Survey())->fetch($idsurvey2);
            $this->survey2->EditSurvey();
            $this->helperCreateQuestion2();
        }
    }

    public function saveedit() {
        $this->helperSaveAnswer();
        \Cosmos\System\Helper::my_session_start();
        $_SESSION['user_message']['msg'] = $this->response['message'];
        $_SESSION['user_message']['type'] = $this->response['type'];
        echo $this->response['type'];
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
            $this->response['message'] = '%%Survey responded successfully%%!';
            $this->response['type'] = 1;
        }
    }

    private function manageSurvey() {
        $date = (new \DateTime())->format('Y-m-d');
        $parameters = [
            'type' => ['>', 1, 'AND'],
            'start' => ['=', $date]
        ];
        //continue...
    }

    private function defineRepeatSurvey() {
        $this->survey_repeater = (new \App\Model\SurveyRepeater);
        $this->survey_repeater->setStart($this->start);
        $this->survey_repeater->setSurvey($this->survey);
        $this->survey_repeater->setType($this->type);
        $this->survey_repeater->insert();
    }

    private function helperSaveSurvey() {
        if (!empty($_POST['content'])) {
            $this->finish = self::HelperValidateSurvey($this->start, $this->type);
            $this->survey = (new \App\Model\Survey);
            $this->survey->setCode(\Cosmos\System\Helper::createCode());
            $this->survey->setValidate($this->finish);
            $this->survey->setStarted_at($this->start);
            $this->survey->setLast_notification($this->start);
            $this->survey->setQtt(filter_input(INPUT_POST, 'qtt', FILTER_SANITIZE_STRING));
            $this->survey->setType(filter_input(INPUT_POST, 'type', FILTER_SANITIZE_STRING));
            $this->survey->setProfile(filter_input(INPUT_POST, 'profile', FILTER_SANITIZE_STRING));
            $this->survey->insert();
            $this->survey = $this->survey->getMessage()->getId();
            $this->helperCreateQuestion();
        }
    }

    private function helperCreateQuestion() {
        $content = json_decode($_POST['content'], true);

        $ord = 0;
        foreach ($content as $data) {
            foreach ($data as $page) {
                $elements = $page["elements"];

                foreach ($elements as $element) {
                    if ($element["type"] == "matrix") {
                        $question_code = \Cosmos\System\Helper::createCode();

                        error_log( $question_code );
                        
                        if (!empty($element["Categoria"])) {
                            $category = (new \App\Model\Category)->getCategoryByName($element["Categoria"]);
                            if ($category) {
                                $category = $category->getId();
                            } else {
                                $category = 1;
                            }
                        } else {
                            $category = 1;
                        }

                        foreach ($element["rows"] as $matrix_row) {
                            if (is_array($matrix_row)) {
                                $tmp = array();
                                $tmp["text"] = $matrix_row["text"];
                            } else {
                                $tmp = array();
                                $tmp["text"] = $matrix_row;
                            }

                            $survey_question = (new \App\Model\SurveyQuestion());
                            $survey_question->setSurvey($this->survey);
                            $survey_question->setContext(json_encode($element));
                            $survey_question->setOrd($ord);
                            $survey_question->setType($element["type"]);
                            $survey_question->setCategory($category);
                            $survey_question->setCode($question_code);
                            $survey_question->setText($tmp["text"]);
                            $survey_question->insert();
                            if ($survey_question->getMessage()->getType() == 1) {
                                $this->response['type'] = 1;
                                $this->response['message'] = '%%Survey created successfully%%!';
                            }
                            $ord++;
                        }
                    } else {
                        $survey_question = (new \App\Model\SurveyQuestion());
                        $survey_question->setSurvey($this->survey);
                        $survey_question->setContext(json_encode($element));
                        $survey_question->setOrd($ord);
                        $survey_question->setType($element["type"]);
                        $survey_question->insert();
                        if ($survey_question->getMessage()->getType() == 1) {
                            $this->response['type'] = 1;
                            $this->response['message'] = '%%Survey created successfully%%!';
                        }
                        $ord++;
                    }
                }
            }
        }
        $this->helperSurveyEvent();
    }

    private function helperSurveyEvent() {
        $survey = (new \App\Model\Survey())->startEventSurveyNotification();
    }

    private function helperCreateQuestion2() {
        $content = json_decode($_POST['content'], true);
        $ord = 0;
        foreach ($content as $data) {
            foreach ($data as $page) {
                $elements = $page["elements"];
                foreach ($elements as $element) {
                    if ($element["type"] == "matrix") {
                        $question_code = \Cosmos\System\Helper::createCode();

                        if (!empty($element["Categoria"])) {
                            $category = (new \App\Model\Category)->getCategoryByName($element["Categoria"]);
                            if ($category) {
                                $category = $category->getId();
                            } else {
                                $category = 1;
                            }
                        } else {
                            $category = 1;
                        }

                        foreach ($element["rows"] as $matrix_row) {
                            if (is_array($matrix_row)) {
                                $tmp = array();
                                $tmp["text"] = $matrix_row["text"];
                            } else {
                                $tmp = array();
                                $tmp["text"] = $matrix_row;
                            }

                            $survey_question = (new \App\Model\SurveyQuestion());
                            $survey_question->setSurvey($this->survey2);
                            $survey_question->setContext(json_encode($element));
                            $survey_question->setOrd($ord);
                            $survey_question->setType($element["type"]);
                            $survey_question->setCategory($category);
                            $survey_question->setCode($question_code);
                            $survey_question->setText($tmp["text"]);
                            $survey_question->insert();
                            if ($survey_question->getMessage()->getType() == 1) {
                                $this->response['type'] = 1;
                                $this->response['message'] = '%%Survey edit successfully%%!';
                            }
                            $ord++;
                        }
                    } else {
                        $survey_question = (new \App\Model\SurveyQuestion());
                        $survey_question->setSurvey($this->survey2);
                        $survey_question->setContext(json_encode($element));
                        $survey_question->setOrd($ord);
                        $survey_question->setType($element["type"]);
                        $survey_question->insert();
                        if ($survey_question->getMessage()->getType() == 1) {
                            $this->response['type'] = 1;
                            $this->response['message'] = '%%Survey edit successfully%%!';
                        }
                        $ord++;
                    }
                }
            }
        }$this->helperSurveyEvent();
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

    private function helperSurveyUsers() {
        foreach ($this->users as $user) {
            $survey_user = (new \App\Model\SurveyUser);
            $survey_user->setUser($user->getId());
            $survey_user->setSurvey($this->survey);
            $survey_user->insert();
        }
    }

    public static function HelperValidateSurvey($date_start, $type) {

        switch ($type) {
            case 1:
                return self::SurveyWeekly($date_start);
            case 2:
                return self::SurveyMonthly($date_start);
            case 3:
                return self::SurveyBimonthly($date_start);
            case 4:
                return self::SurveyBimonthly($date_start);
            default:
                return $date_start;
        }
    }

    public static function SurveyWeekly(string $date_survey) {
        $date = (new \DateTime());
        if ($date_survey >= $date->format('Y-m-d')) {
            $date->modify('+1 weeks');
        }
        return $date->format('Y-m-d');
    }

    public static function SurveyMonthly(string $date_survey) {
        $date = (new \DateTime());
        if ($date_survey >= $date->format('Y-m-d')) {
            $date->modify('+1 months');
        }
        return $date->format('Y-m-d');
    }

    public static function SurveyBimonthly(string $date_survey) {
        $date = (new \DateTime());
        if ($date_survey >= $date->format('Y-m-d')) {
            $date->modify('+2 months');
        }
        return $date->format('Y-m-d');
    }

    public function group() {
        $this->load('SurveyGroup', 'Listing', false, false);
    }

}
