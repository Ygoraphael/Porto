<?php

namespace App\Dao;

use Cosmos\System\Dao;

class Language extends Dao {

    function __construct() {
        parent::__construct($this);
    }

    public function listing(){
        return $this->selectAll(['lang' => ['!=', '']]);
    }

}
