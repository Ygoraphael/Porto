<?php

namespace App\Model;

use Cosmos\System\Model;

class SectorUser extends Model {

    private $user;
    private $sector;

    public function __construct() {
        parent::__construct($this);
    }

    function getUser() {
        return $this->user;
    }

    function getSector() {
        return $this->sector;
    }

    function setUser($user) {
        $this->user = $user;
    }

    function setSector($sector) {
        $this->sector = $sector;
    }

}
