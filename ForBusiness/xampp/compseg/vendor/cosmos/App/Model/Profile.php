<?php

namespace App\Model;

use Cosmos\System\Model;

class Profile extends Model {

    private $name;
    private $status = 1;

    function __construct() {
        parent::__construct($this);
    }

    function getName() {
        return $this->name;
    }

    function getStatus() {
        return $this->status;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    public function register() {
        $this->name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $this->insert();
    }

    public function saveUpdate() {
        $this->name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $this->update();
    }

    public function listing($company) {
        return (new \App\Dao\Profile($company))->listing();
    }
	


}
