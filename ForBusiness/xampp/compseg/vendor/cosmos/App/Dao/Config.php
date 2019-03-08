<?php

namespace App\Dao;

use Cosmos\System\Dao;

class Config extends Dao {

    function __construct(\App\Model\Company $company) {
        $this->set_db = 'company';
        $this->name_db = $company->getData_base();
        parent::__construct($this);
    }

    public function getConfig() {
        return $this->getConfigCompany();
    }

    private function getConfigCompany() {
        return parent::selectOne();
    }

}
