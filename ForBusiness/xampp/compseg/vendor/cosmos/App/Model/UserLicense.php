<?php

namespace App\Model;

use Cosmos\System\Model;

class UserLicense extends Model {

    private $user;
    private $status = 1;
    private $company;

    public function __construct() {
        parent::__construct($this);
    }

    function getUser() {
        return $this->user;
    }

    function getStatus() {
        return $this->status;
    }

    function getCompany() {
        return $this->company;
    }

    function setUser($user) {
        $this->user = $user;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setCompany($company) {
        $this->company = $company;
    }

    public static function getLisence($user) {
        return (new \App\Dao\UserLicense)->getLisence($user);
    }
	
	public static function getDeleteUserLicenseUser($user) {
        return (new \App\Dao\UserLicense)->getDeleteUserLicenseUser($user);
    }

}
