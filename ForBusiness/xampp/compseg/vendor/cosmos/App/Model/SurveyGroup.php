<?php

namespace App\Model;

use Cosmos\System\Model;

class SurveyGroup extends Model {

    private $description;

    public function __construct() {
        parent::__construct($this);
    }

    function getDescription() {
        return $this->description;
    }

    function setDescription($description) {
        $this->description = $description;
    }

}
