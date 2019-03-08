<?php

namespace App\Model;

use Cosmos\System\Model;

class Config extends Model {

    private $name;

    function __construct() {
        parent::__construct($this);
    }

    function getName() {
        return $this->name;
    }

    function setName($name) {
        $this->name = $name;
    }

}
