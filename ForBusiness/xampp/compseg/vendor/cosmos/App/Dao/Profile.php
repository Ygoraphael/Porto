<?php

namespace App\Dao;

use Cosmos\System\Dao;

class Profile extends Dao {

    private $profile = null;

    function __construct($company = null) {
        $this->set_db = 'company';        
        $this->name_db = (is_null($company) ? \App\Model\Company::getCompany()->getData_base() : $company->getData_base());
        parent::__construct($this);
    }

    public function listing() {
        return $this->selectAll(['deleted' => ['=', 0]]);
    }

}
