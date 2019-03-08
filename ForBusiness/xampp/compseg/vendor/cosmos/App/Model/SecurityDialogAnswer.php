<?php

namespace App\Model;

use Cosmos\System\Model;

class SecurityDialogAnswer extends Model {

    private $user;
    private $securitydialogweek;
    private $attendance;

    public function __construct() {
        parent::__construct($this);
    }

    function getUser() {
        return $this->user;
    }

    function getSecurityDialogWeek() {
        return $this->securitydialogweek;
    }
    
    function getAttendance() {
        return $this->attendance;
    }

    function setUser($user) {
        $this->user = $user;
    }

    function setSecurityDialogWeek($securitydialogweek) {
        $this->securitydialogweek = $securitydialogweek;
    }
    
    function setAttendance($attendance) {
        $this->attendance = $attendance;
    }

}