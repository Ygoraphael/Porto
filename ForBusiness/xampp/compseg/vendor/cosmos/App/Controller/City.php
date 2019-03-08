<?php

namespace App\Controller;

use Cosmos\System\Controller;

class City extends Controller {

    public function __construct() {
        parent::__construct($this);
    }

    public function listing() {
        $this->load('City', 'Listing', false, false);
    }

}
