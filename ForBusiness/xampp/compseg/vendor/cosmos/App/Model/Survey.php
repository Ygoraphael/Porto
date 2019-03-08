<?php

namespace App\Model;

use Cosmos\System\Model;

class Survey extends Model {

    private $status = 0;
    private $code;
    private $validate;
    private $qtt;
    private $type;
    private $started_at;
    private $last_notification;
    private $profile;

    public function __construct() {
        parent::__construct($this);
    }

    function getCode() {
        return $this->code;
    }

    function setCode($code) {
        $this->code = $code;
    }

    function getStatus() {
        return $this->status;
    }

    function getQtt() {
        return $this->qtt;
    }

    function getType() {
        return $this->type;
    }

    function getStarted_at() {
        return $this->started_at;
    }

    function getLast_notification() {
        return $this->last_notification;
    }

    function getProfile() {
        return $this->profile;
    }

    function setStarted_at($started_at) {
        $this->started_at = $started_at;
    }

    function setLast_notification($last_notification) {
        $this->last_notification = $last_notification;
    }

    function setQtt($qtt) {
        $this->qtt = $qtt;
    }

    function setType($type) {
        $this->type = $type;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function getValidate() {
        return $this->validate;
    }

    function setValidate($validate) {
        $this->validate = $validate;
    }

    function setProfile($profile) {
        $this->profile = $profile;
    }

    public static function getSurveysForUser() {
        return (new \App\Dao\Survey)->getSurveysForUser();
    }

    public static function verifySurveyAnswered(\App\Model\Survey $survey) {
        return (new \App\Dao\Survey)->verifySurveyAnswered($survey);
    }

    public static function getSurveyLastCompleted() {
        return (new \App\Dao\Survey)->getSurveyLastCompleted();
    }

    public static function getListingSurveyForCompany() {
        return (new \App\Dao\Survey)->getListingSurveyForCompany();
    }

    public static function getSurveyLastCompletedForCompany() {
        return (new \App\Dao\Survey)->getSurveyLastCompletedForCompany();
    }

    public static function startEventSurveyNotification() {
        return (new \App\Dao\Survey)->startEventSurveyNotification();
    }

    public function EditSurvey() {
        $this->qtt = filter_input(INPUT_POST, 'qtt', FILTER_SANITIZE_NUMBER_INT);
        $this->update();
    }
	
	public function RegisterFilter($filter){
		return (new \App\Dao\Survey)->RegisterFilter($filter);
	}
}
