<?php

namespace App\Dao;

use Cosmos\System\Dao;

class SafetyWalk extends Dao {

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
	
	public function RegisterFilter($filter){
		if($filter){
			$query_where = '';
			foreach($filter as $key => $value){
				$where = $key." ".$value[0]." '".$value[1]."' ".$value[2];
				$query_where = $query_where." ".$where;
			}
		}
		$this->safetywalk = $query_where;
		$this->QueryRegisterFilter();
        return $this->result;
	}
    
    public function startEventSWNotification() {
        $this->result = $this->querybuild("CALL ManageSafetyWalkNotifications(1);");
    }
	
	private function QueryRegisterFilter(){
		$this->result = $this->queryBuild("SELECT sw.* FROM SafetyWalk as sw WHERE {$this->safetywalk}");
	}
}
