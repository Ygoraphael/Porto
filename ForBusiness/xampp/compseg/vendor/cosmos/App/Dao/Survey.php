<?php

namespace App\Dao;

use Cosmos\System\Dao;

class Survey extends Dao {

    private $user;
    private $result;
    private $survey;
    private $company;

    function __construct() {
        $this->set_db = 'company';
        $this->name_db = \App\Model\Company::getCompany()->getData_base();

        $this->company = \App\Model\Company::getCompany();
        $this->user = \App\Model\User::getUserLoged();

        parent::__construct($this);
    }

    public function getSurveysForUser() {
        $this->querySurveysForUser();
        return $this->result;
    }

	public function RegisterFilter($filter){
		if($filter){
			$query_where = '';
			foreach($filter as $key => $value){
				$where = $key." ".$value[0]." '".$value[1]."' ".$value[2];
				$query_where = $query_where." ".$where;
			}
		}
		$this->survey = $query_where;
		$this->QueryRegisterFilter();
        return $this->result;
	}
	
    public function verifySurveyAnswered(\App\Model\Survey $survey) {
        $this->survey = $survey;
        $this->querySurveyAnswered();
        if (!empty($this->result)) {
            return false;
        }
        return true;
    }

    public function getSurveyLastCompleted() {
        $this->querySurveyLastCompleted();
        return $this->result;
    }

    public function getSurveyLastCompletedForCompany() {
        $this->querySurveyLastCompletedForCompany();
        return $this->result;
    }

	
	private function QueryRegisterFilter(){
		$this->result = $this->queryBuild("SELECT sv.* FROM Survey as sv WHERE {$this->survey}");
	}
    private function querySurveysForUser() {
        $this->result = $this->queryBuild("SELECT s.idSurvey as p_id, s.code,s.created_at, s.validate as p_validate, su.status FROM Survey as s
        INNER JOIN SurveyUser as su ON s.idSurvey=su.survey
        INNER JOIN User as u ON su.user=u.idUser
        WHERE u.idUser={$this->user->getId()}");
    }

    private function querySurveyAnswered() {
        $this->result = $this->queryBuild("SELECT s.idSurvey as id FROM Survey as s
        INNER JOIN SurveyUser as su ON s.idSurvey=su.survey
        INNER JOIN User as u ON su.user=u.idUser
        WHERE u.idUser={$this->user->getId()} AND s.idSurvey={$this->survey->getId()} AND su.status=1");
    }

    private function querySurveyLastCompleted() {
        $this->result = $this->querybuild("SELECT c.idCompany, u.name, u.idUser, su.status,s.code, s.idSurvey FROM Survey as s
        INNER JOIN SurveyUser as su ON s.idSurvey=su.survey
        INNER JOIN UserLicense as ul ON su.user=ul.user
        INNER JOIN Company as c ON ul.company=c.idCompany
        INNER JOIN User as u ON ul.user=u.idUser
        WHERE su.status=1");
    }

    private function querySurveyLastCompletedForCompany() {
        $this->result = $this->querybuild("SELECT c.idCompany, u.name, u.idUser, su.status,s.code, s.idSurvey FROM Survey as s
        INNER JOIN SurveyUser as su ON s.idSurvey=su.survey
        INNER JOIN UserLicense as ul ON su.user=ul.user
        INNER JOIN Company as c ON ul.company=c.idCompany
        INNER JOIN User as u ON ul.user=u.idUser
        WHERE c.idCompany={$this->company->getId()} AND su.status=1");
    }

    public function getListingSurveyForCompany() {
        $this->queryListingSurveyForCompany();
        return $this->result;
    }

    private function queryListingSurveyForCompany() {
        $this->result = $this->querybuild("SELECT s.idSurvey as id, s.code, s.created_at, s.validate, s.status, s.qtt, s.type
		FROM Survey as s");
    }

    public function startEventSurveyNotification() {
        $this->result = $this->querybuild("CALL ManageSurveyNotifications(1);");
    }

}
