<?php

namespace App\Model;

use Cosmos\System\Model;

class UserCompany extends Model {

    private $code;

    function __construct() {
        parent::__construct($this);
    }

    function getCode() {
        return $this->code;
    }

    function setCode($code) {
        $this->code = $code;
    }

}
