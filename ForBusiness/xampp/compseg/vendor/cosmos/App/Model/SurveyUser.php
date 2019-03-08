<?php

namespace App\Model;

use Cosmos\System\Model;

class SurveyUser extends Model {

    private $status = 0;
    private $user;
    private $survey;

    public function __construct() {
        parent::__construct($this);
    }

    function getStatus() {
        return $this->status;
    }

    function getUser() {
        return $this->user;
    }

    function getSurvey() {
        return $this->survey;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setUser($user) {
        $this->user = $user;
    }

    function setSurvey($survey) {
        $this->survey = $survey;
    }

}
