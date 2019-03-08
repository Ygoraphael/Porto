<?php

namespace App\Controller;

use Cosmos\System\Controller;

class Permission extends Controller {

    function __construct() {
        parent::__construct($this);
    }

    public function new_group() {
        (new PermissionGroup)->new_group();
    }

    public function listing() {
        $this->load('Permission', 'Listing', false, false);
    }

    public function group() {
        $this->load('PermissionGroup', 'Listing', false, false);
    }

    public static function permission_user(\App\Model\User $user) {
        $status = false;
        foreach ($_POST['permission'] as $key => $permission) {
            if ($permission == 1) {
                $permission = (new \App\Model\Permission);
                $permission->setUser($user->getId());
                $permission->setPage($key);
                $permission->insert();
                if ($permission->getMessage()->getType() == 1) {
                    $status = true;
                }
            }
        }
        return $status;
    }

}
