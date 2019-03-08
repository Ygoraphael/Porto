<?php

namespace App\Controller;

use Cosmos\System\Controller;

class ProfileMonitor extends Controller {

    function __construct() {
        parent::__construct($this);
    }

    public static function profile_monitor(\App\Model\Profile $profile) {
        $status = false;
        foreach ($_POST['profilemonitor'] as $key => $profilemonitor) {
            if ($profilemonitor == 1) {
                $profilemonitor = (new \App\Model\ProfileMonitor);
                $profilemonitor->setProfile($profile->getId());
                $profilemonitor->setMonitor($key);
                $profilemonitor->setStatus(1);
                $profilemonitor->insert();
                if ($profilemonitor->getMessage()->getType() == 1) {
                    $status = true;
                }
            }
        }
        return $status;
    }

}
