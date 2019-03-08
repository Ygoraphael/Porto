<?php

namespace App\Dao;

use Cosmos\System\Dao;

class Notification extends Dao {

    function __construct() {
        $this->user = \App\Model\User::getUserLoged();

        if ($this->user->getUser_type() != 1) {
            $this->set_db = 'company';
            $this->name_db = \App\Model\Company::getCompany()->getData_base();
        }

        parent::__construct($this);
    }

    public function listingNotificationsUser(\App\Model\User $user) {
        $this->result = $this->querybuild("select idNotification id,user,table1,value1,table2,value2,date_limit,title,description,created_at,deleted_at,deleted,type 
        from Notification where user = " . $user->getId() . " and deleted = 0 ORDER BY date_limit ASC");
        return $this->result;
    }

}
