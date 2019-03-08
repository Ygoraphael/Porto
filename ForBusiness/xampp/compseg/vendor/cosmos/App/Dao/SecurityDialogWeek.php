<?php

namespace App\Dao;

use Cosmos\System\Dao;

class SecurityDialogWeek extends Dao {

    function __construct() {
        $this->set_db = 'company';
        $this->name_db = \App\Model\Company::getCompany()->getData_base();
        parent::__construct($this);
    }
    
    public function runDialogNotifications() {
        $this->result = $this->querybuild("CALL ManageSecurityDialogNotifications(1);");
    }

}
