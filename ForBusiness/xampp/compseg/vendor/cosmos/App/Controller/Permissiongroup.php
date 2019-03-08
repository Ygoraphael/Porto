<?php

namespace App\Controller;

use Cosmos\System\Controller;

class PermissionGroup extends Controller {

    private $permission;

    function __construct() {
        parent::__construct($this);
    }

    public function new_group() {
        $this->load('Permission', 'New', false, false);
    }

    public function listing() {
        $this->load('Permission', 'Listing', false, false);
    }

}
