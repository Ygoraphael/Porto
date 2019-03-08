<?php

namespace App\Model;

use Cosmos\System\Model;

class Permission extends Model {

    private $page;
    private $user;
    private $permission_group;
    private $status = 1;
    private $action = 1;

    function __construct() {
        parent::__construct($this);
    }

    function getPage() {
        return $this->page;
    }

    function getUser() {
        return $this->user;
    }

    function getPermission_group() {
        return $this->permission_group;
    }

    function getStatus() {
        return $this->status;
    }

    function getAction() {
        return $this->action;
    }

    function setPage($page) {
        $this->page = $page;
    }

    function setUser($user) {
        $this->user = $user;
    }

    function setPermission_group($permission_group) {
        $this->permission_group = $permission_group;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setAction($action) {
        $this->action = $action;
    }

    public static function getPermissionsUser($user) {
        return (new \App\Dao\Permission)->getPermissionsUser($user);
    }

    public static function getDeletePermissionsUser($user) {
        return (new \App\Dao\Permission)->getDeletePermissionsUser($user);
    }

}
