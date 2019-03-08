<?php

namespace App\Model;

use Cosmos\System\Model;

class ProfileMonitor extends Model {

    private $profile;
    private $monitor;
    private $status;

    public function __construct() {
        parent::__construct($this);
    }

    function getProfile() {
        return $this->profile;
    }

    function getMonitor() {
        return $this->monitor;
    }

    function getStatus() {
        return $this->status;
    }

    function setProfile($profile) {
        $this->profile = $profile;
    }

    function setMonitor($monitor) {
        $this->monitor = $monitor;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    public static function getDeleteProfileMonitors($profile) {
        return (new \App\Dao\ProfileMonitor)->getDeleteProfileMonitors($profile);
    }
}
