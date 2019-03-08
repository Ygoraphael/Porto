<?php

namespace App\Dao;

use Cosmos\System\Dao;

class SurveyGroup extends Dao {

    function __construct() {
		$this->set_db = 'company';
        $this->name_db = \App\Model\Company::getCompany()->getData_base();
        parent::__construct($this);
    }

}