<?php

namespace App\Dao;

use Cosmos\System\Dao;

class Page extends Dao {

    function __construct() {
        parent::__construct($this);
    }

    public function getPagesAdministrator() {
        return $this->listingPagesAdministrator();
    }

    private function listingPagesAdministrator() {
        $parameters = [
            'level_min' => ['<=', 2, 'AND'],
            'level_max' => ['>=', 2]
        ];
        return parent::selectAll($parameters);
    }

}
