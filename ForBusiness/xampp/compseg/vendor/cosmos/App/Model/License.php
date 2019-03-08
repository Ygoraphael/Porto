<?php

namespace App\Model;

use Cosmos\System\Model;

class License extends Model {

    private $code;
    private $status = 1;
    private $users_license;

    function __construct() {
        parent::__construct($this);
    }

    function getCode() {
        return $this->code;
    }

    function getStatus() {
        return $this->status;
    }

    function getUsers_license() {
        return $this->users_license;
    }

    function setCode($code) {
        $this->code = $code;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setUsers_license($users_license) {
        $this->users_license = $users_license;
    }

    public function register() {
        $this->code = filter_input(INPUT_POST, 'license', FILTER_SANITIZE_STRING);
        $this->users_license = filter_input(INPUT_POST, 'users_license', FILTER_SANITIZE_NUMBER_INT);
        $this->insert();
    }

    public function updateRegisters() {
        $this->code = filter_input(INPUT_POST, 'license', FILTER_SANITIZE_STRING);
        $this->users_license = filter_input(INPUT_POST, 'users_license', FILTER_SANITIZE_NUMBER_INT);
        $this->update();
    }

}
