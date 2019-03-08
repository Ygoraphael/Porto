<?php

/**
 * Product: Meteor
 * Created by Cosmos Digital.
 * Developer: Jeferson Kaefer
 * Date: 26/09/2016
 * Time: 21:18
 */

namespace App\Controller;

use Cosmos\System\Controller;
use Cosmos\System\Helper;

class Logout extends Controller {

    function __construct() {
        parent::__construct($this);
    }

    function index() {
        if (Authentication::isAuthenticated()) {
            $user = \App\Model\User::getUserLogged();
            $user->setOnline(0);
            $user->update();
        }
        $_SESSION = array();
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]
            );
        }
        session_start();
        session_destroy();
        
        return Helper::redirect('/');
    }

}
