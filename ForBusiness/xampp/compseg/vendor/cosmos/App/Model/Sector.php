<?php

namespace App\Model;

use Cosmos\System\Model;

class Sector extends Model {

    private $name;
    private $status = 1;
    private $factory;

    public function __construct() {
        parent::__construct($this);
    }

    function getName() {
        return $this->name;
    }

    function getStatus() {
        return $this->status;
    }

    function getFactory() {
        return $this->factory;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setFactory($factory) {
        $this->factory = $factory;
    }

    public function register() {
        $this->name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $this->factory = filter_input(INPUT_POST, 'factory', FILTER_SANITIZE_NUMBER_INT);
        $this->insert();
    }

    public function saveUpdate() {
        $this->name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $this->factory = filter_input(INPUT_POST, 'factory', FILTER_SANITIZE_NUMBER_INT);
        $this->update();
    }

    public function listing($company) {
        return (new \App\Dao\Sector($company))->listing();
    }

}
