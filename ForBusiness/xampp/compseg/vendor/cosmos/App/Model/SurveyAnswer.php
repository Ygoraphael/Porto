<?php

namespace App\Model;

use Cosmos\System\Model;

class SurveyAnswer extends Model {

    private $user;
    private $survey;
    private $sector;
    private $content;

    public function __construct() {
        parent::__construct($this);
    }

    function getUser() {
        return $this->user;
    }

    function getSurvey() {
        return $this->survey;
    }
    
    function getSector() {
        return $this->sector;
    }
    
    function getContent() {
        return $this->content;
    }

    function setUser($user) {
        $this->user = $user;
    }

    function setSurvey($survey) {
        $this->survey = $survey;
    }
    
    function setSector($sector) {
        $this->sector = $sector;
    }
    
    function setContent($content) {
        $this->content = $content;
    }

}