<?php

namespace App\Model;

use Cosmos\System\Model;

class FactoryUser extends Model {

    private $user;
    private $factory;

    function __construct() {
        parent::__construct($this);
    }

    function getUser() {
        return $this->user;
    }

    function getFactory() {
        return $this->factory;
    }

    function setUser($user) {
        $this->user = $user;
    }

    function setFactory($factory) {
        $this->factory = $factory;
    }

}
