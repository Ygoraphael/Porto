<?php

namespace App\Model;

use Cosmos\System\Model;

class SafetyWalkAnswerQuestion extends Model {

    private $safetywalkanswer;
    private $safetywalkquestion;
    private $value;

    public function __construct() {
        parent::__construct($this);
    }

    function getSafetyWalkAnswer() {
        return $this->safetywalkanswer;
    }
    
    function getSafetyWalkQuestion() {
        return $this->safetywalkquestion;
    }

    function getValue() {
        return $this->value;
    }

    function setSafetyWalkAnswer($safetywalkanswer) {
        $this->safetywalkanswer = $safetywalkanswer;
    }
    
    function setSafetyWalkQuestion($safetywalkquestion) {
        $this->safetywalkquestion = $safetywalkquestion;
    }

    function setValue($value) {
        $this->value = $value;
    }

}
