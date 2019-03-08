<?php

namespace App\Model;

use Cosmos\System\Model;

class SecurityDialogWeek extends Model {

    private $securitydialog;
    private $year;
    private $week;
    private $last_notification;

    function __construct() {
        parent::__construct($this);
    }

    function getSecurityDialog() {
        return $this->securitydialog;
    }
    
    function getYear() {
        return $this->year;
    }
    
    function getWeek() {
        return $this->week;
    }
    
    function getLast_notification() {
        return $this->last_notification;
    }

    function setSecurityDialog($securitydialog) {
        $this->securitydialog = $securitydialog;
    }
    
    function setYear($year) {
        $this->year = $year;
    }
    
    function setWeek($week) {
        $this->week = $week;
    }
    
    function setLast_notification($last_notification) {
        $this->last_notification = $last_notification;
    }
    
    public function register() {
        $this->insert();
    }

    public function saveUpdate() {
        $this->update();
    }
    
    public function runDialogNotifications() {
        return (new \App\Dao\SecurityDialogWeek)->runDialogNotifications();
    }

}