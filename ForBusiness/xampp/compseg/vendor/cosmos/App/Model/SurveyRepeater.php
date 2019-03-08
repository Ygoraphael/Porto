<?php

namespace App\Model;

use Cosmos\System\Model;

class SurveyRepeater extends Model {

    private $start;
    private $type;
    private $survey;

    public function __construct() {
        parent::__construct($this);
    }

    function getStart() {
        return $this->start;
    }

    function getType() {
        return $this->type;
    }

    function getSurvey() {
        return $this->survey;
    }

    function setSurvey($survey) {
        $this->survey = $survey;
    }

    function setStart($start) {
        $this->start = $start;
    }

    function setType($type) {
        $this->type = $type;
    }

}
