<?php

namespace App\Model;

use Cosmos\System\Model;

class SurveyQuestion extends Model {

    private $survey;
    private $type;
    private $category;
    private $context;
    private $ord;
    private $code;
    private $text;

    public function __construct() {
        parent::__construct($this);
    }

    function getSurvey() {
        return $this->survey;
    }

    function getType() {
        return $this->type;
    }

    function getCategory() {
        return $this->category;
    }

    function getContext() {
        return $this->context;
    }

    function getOrd() {
        return $this->ord;
    }

    function getCode() {
        return $this->code;
    }

    function getText() {
        return $this->text;
    }

    function setText($text) {
        $this->text = $text;
    }

    function setCode($code) {
        $this->code = $code;
    }

    function setSurvey($survey) {
        $this->survey = $survey;
    }

    function setCategory($category) {
        $this->category = $category;
    }

    function setType($type) {
        $this->type = $type;
    }

    function setContext($context) {
        $this->context = $context;
    }

    function setOrd($ord) {
        $this->ord = $ord;
    }

	
	public function ShadowQuestion(){
		$this->deleted = "1";
		$this->deleted_at = date('Y-m-d H:i:s');
		$this->update();
	}
	
}
