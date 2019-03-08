<?php

namespace App\Dao;

use Cosmos\System\Dao;

class Event extends Dao {

    function __construct(\App\Model\Company $company) {
        $this->set_db = 'company';
        $this->name_db = $company->getData_base();
        parent::__construct($this);
    }

    public function startEventSurveyNotification() {
        $this->result = $this->querybuild("CALL ManageSurveyNotifications(1);");
    }
    
    public function startEventSWNotification() {
        $this->result = $this->querybuild("CALL ManageSafetyWalkNotifications(1);");
    }
    
    public function runDialogNotifications() {
        $this->result = $this->querybuild("CALL ManageSecurityDialogNotifications(1);");
    }

}
