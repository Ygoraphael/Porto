<?php

namespace App\Dao;

use Cosmos\System\Dao;

class SectorUser extends Dao {

    function __construct() {
        $this->set_db = 'company';
        parent::__construct($this);
    }

}
