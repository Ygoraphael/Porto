<?php

namespace App\Controller;

use Cosmos\System\Controller;

class Notification extends Controller {

    private $user;
    private $table1;
    private $value1;
    private $table2;
    private $value2;
    private $date_limit;
    private $title;
    private $description;
    private $type;

    function __construct() {
        parent::__construct($this);
    }
    
}
