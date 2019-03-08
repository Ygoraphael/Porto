<?php

namespace App\Controller;

use Cosmos\System\Controller;

class Event extends Controller {

    public function __construct() {
        parent::__construct($this);
    }

    public function runAllNotification() {
        $parameters = [
            'deleted' => ['=', 0]
        ];
        $companies = (new \App\Model\Company())->listingRegisters($parameters);
        if( !empty($companies) ) {
            foreach( $companies as $company ) {
                (new \App\Model\Event)->startEventSurveyNotification($company);
                (new \App\Model\Event)->startEventSWNotification($company);
                (new \App\Model\Event)->runDialogNotifications($company);
            }
        }
    }
}
