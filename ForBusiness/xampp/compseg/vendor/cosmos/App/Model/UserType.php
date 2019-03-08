<?php

namespace App\Model;

use Cosmos\System\Model;

class UserType extends Model {

    private $level;
    private $name;

    function __construct() {
        parent::__construct($this);
    }

    function getLevel() {
        return $this->level;
    }

    function setLevel($level) {
        $this->level = $level;
    }

    function getName() {
        return $this->name;
    }

    private function getType() {
        $this->level = $this->fetch(User::getUserLoged()->getUser_type())->getId();
        switch ($this->level) {
            case 1:
                return (new PanelAdministrator());
            case 2:
                return (new PanelCompany());
            default:
                return (new PanelUser());
        }
    }

    public function getPanel() {
        return $this->getType();
    }

    function setName($name) {
        $this->name = $name;
    }

}
