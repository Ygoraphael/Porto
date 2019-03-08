<?php

namespace App\Dao;

use Cosmos\System\Dao;

class Category extends Dao {

    private $company = null;

    function __construct($company = null) {
        $this->set_db = 'company';
        $this->name_db = \App\Model\Company::getCompany()->getData_base();
        parent::__construct($this);
    }

    public function listing() {
        return $this->selectAll(['deleted' => ['=', 0]]);
    }

    public function getCategoryByName($value) {
        $parameters = [
            'name' => ['=', $value]
        ];
        $object = parent::selectOne($parameters);
        return $object ?? false;
    }

}
