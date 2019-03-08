<?php

/**
 * Product: Meteor
 * Created by Cosmos Digital.
 * Developer: Jeferson Kaefer
 * Date: 12/09/2016
 * Time: 02:43
 */

namespace App\Controller;

use Cosmos\System\Controller;

class Es extends Controller {

    function __construct() {
        parent::__construct($this);
    }

    public function index() {
        \Cosmos\System\Helper::my_session_start();
        
        $_SESSION['cur_lang'] = 'es';
        \Cosmos\System\Helper::redirect('/');
    }

}
