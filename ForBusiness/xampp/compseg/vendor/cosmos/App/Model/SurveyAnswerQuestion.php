<?php

namespace App\Model;

use Cosmos\System\Model;

class SurveyAnswerQuestion extends Model {

    private $survey_answer;
    private $survey_question;
    private $value;

    public function __construct() {
        parent::__construct($this);
    }

    function getSurvey_answer() {
        return $this->survey_answer;
    }
    
    function getSurvey_question() {
        return $this->survey_question;
    }

    function getValue() {
        return $this->value;
    }

    function setSurvey_answer($survey_answer) {
        $this->survey_answer = $survey_answer;
    }
    
    function setSurvey_question($survey_question) {
        $this->survey_question = $survey_question;
    }

    function setValue($value) {
        $this->value = $value;
    }

}
