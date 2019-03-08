<?php

namespace App\Model;

use Cosmos\System\Model;

class Page extends Model {

    private $link;
    private $status = 1;
    private $parent;
    private $title;
    private $permission;
    private $level_min;
    private $level_max;

    public function __construct() {
        parent::__construct($this);
    }

    function getLink() {
        return $this->link;
    }

    function getStatus() {
        return $this->status;
    }

    function getParent() {
        return $this->parent;
    }

    function getTitle() {
        return $this->title;
    }

    function getPermission() {
        return $this->permission;
    }

    function getLevel_min() {
        return $this->level_min;
    }

    function getLevel_max() {
        return $this->level_max;
    }

    function setLevel_min($level_min) {
        $this->level_min = $level_min;
    }

    function setLevel_max($level_max) {
        $this->level_max = $level_max;
    }

    function setPermission($permission) {
        $this->permission = $permission;
    }

    function setParent($parent) {
        $this->parent = $parent;
    }

    function setTitle($title) {
        $this->title = $title;
    }

    function setLink($link) {
        $this->link = $link;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    public function getAuthorized() {
        if ((new \App\Dao\Permission())->getRestrictedUser($this)) {
            return (new \App\Dao\Permission())->getAthorizedUser($this);
        } else {
            return true;
        }
    }

    public static function getPagesAdministrator() {
        return (new \App\Dao\Page())->getPagesAdministrator();
    }

}
