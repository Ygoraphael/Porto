<?php

namespace App\Model;

use Cosmos\System\Model;

class Event extends Model {

    function __construct() {
        parent::__construct($this);
    }

    function startEventSurveyNotification( \App\Model\Company $company ) {
        return (new \App\Dao\Event($company))->startEventSurveyNotification();
    }
    
    function startEventSWNotification( \App\Model\Company $company ) {
        return (new \App\Dao\Event($company))->startEventSWNotification();
    }
    
    function runDialogNotifications( \App\Model\Company $company ) {
        return (new \App\Dao\Event($company))->runDialogNotifications();
    }

}
