<?php

namespace App\Dao;

use Cosmos\System\Dao;

class Insecurity extends Dao {

    private $company = null;

    function __construct($company = null) {
        $this->set_db = 'company';
        $this->name_db = \App\Model\Company::getCompany()->getData_base();
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
		$this->insecurity = $query_where;
		$this->QueryRegisterFilter();
        return $this->result;
	}
    public function listing() {
        return $this->selectAll(['deleted' => ['=', 0]]);
    }

	private function QueryRegisterFilter(){
		$this->result = $this->queryBuild("SELECT it.*  FROM Insecurity as it WHERE {$this->insecurity}");
	}
	
}
