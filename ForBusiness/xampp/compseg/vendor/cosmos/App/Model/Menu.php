<?php

namespace App\Model;

use Cosmos\System\Model;

class Menu extends Model {

    private $name;
    private $page;
    private $icon;
    private $parent;
    private $status;
    private $translate;
    private $order;
    private $level;

    function __construct() {
        parent::__construct($this);
    }

    function getName() {
        return $this->name;
    }

    function getPage() {
        return $this->page;
    }

    function getIcon() {
        return $this->icon;
    }

    function getParent() {
        return $this->parent;
    }

    function getStatus() {
        return $this->status;
    }

    function getTranslate() {
        return $this->translate;
    }

    function getOrder() {
        return $this->order;
    }

    function getLevel() {
        return $this->level;
    }

    function setLevel($level) {
        $this->level = $level;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setPage($page) {
        $this->page = $page;
    }

    function setIcon($icon) {
        $this->icon = $icon;
    }

    function setParent($parent) {
        $this->parent = $parent;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setTranslate($translate) {
        $this->translate = $translate;
    }

    function setOrder($order) {
        $this->order = $order;
    }

    public function getMenus() {
        return (new \App\Dao\Menu)->getMenus();
    }

}
