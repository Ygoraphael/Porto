<?php

namespace App\Model;

use Cosmos\System\Model;

class PermissionGroup extends Model {

    private $name;
    private $level;
    private $status;
    private $type;

    function __construct() {
        parent::__construct($this);
    }

    function getName() {
        return $this->name;
    }

    function getLevel() {
        return $this->level;
    }

    function getStatus() {
        return $this->status;
    }

    function getType() {
        return $this->type;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setLevel($level) {
        $this->level = $level;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setType($type) {
        $this->type = $type;
    }

}
