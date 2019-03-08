<?php

namespace App\Dao;

use Cosmos\System\Dao;

class ProfileMonitor extends Dao {

    function __construct($company = null) {
        $this->set_db = 'company';
        $this->name_db = \App\Model\Company::getCompany()->getData_base();
        parent::__construct($this);
    }

    public function listing() {
        return $this->selectAll(['deleted' => ['=', 0]]);
    }
    
    public function getDeleteProfileMonitors(\App\Model\Profile $profile) {
        $this->profile = $profile;
        $this->queryDeleteProfileMonitors();
        return $this->result;
    }

    private function queryDeleteProfileMonitors() {
        $this->result = $this->querybuild("DELETE FROM ProfileMonitor WHERE profile={$this->profile->getId()}");
    }

}
