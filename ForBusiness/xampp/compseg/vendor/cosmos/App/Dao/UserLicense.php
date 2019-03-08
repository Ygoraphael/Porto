<?php

namespace App\Dao;

use Cosmos\System\Dao;

class UserLicense extends Dao {

    private $user;

    function __construct() {
        parent::__construct($this);
    }

    public function getLisence(\App\Model\User $user) {
        $this->user = $user;
        return $this->getUserLicense();
    }

    private function getUserLicense() {
        $parameters = [
            'user' => ['=', $this->user->getId()]
        ];
        $object = parent::selectOne($parameters);
        if (is_object($object)) {
            return $object;
        }
        return false;
    }
	
	public function getDeleteUserLicenseUser(\App\Model\User $user) {
        $this->user = $user;
        $this->queryDeleteUserLicenseUser();
        return $this->result;
    }

    private function queryDeleteUserLicenseUser() {
        $this->result = $this->querybuild("DELETE FROM UserLicense WHERE user={$this->user->getId()}");
    }

}
