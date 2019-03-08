<?php

namespace App\Dao;

use Cosmos\System\Dao;

class Factory extends Dao {

    private $company = null;

    function __construct($company = null) {
        $this->company = $company;
        $this->set_db = 'company';
        $this->setData_base();
        parent::__construct($this);
    }

    private function setData_base() {
        if (is_null($this->company)) {
            $this->name_db = \App\Model\Company::getCompany()->getData_base();
        } else {
            $this->name_db = $this->company->getData_base();
        }
    }

    public function listing() {
        return $this->selectAll(['deleted' => ['<', 1]]);
    }

}
