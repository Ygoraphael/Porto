<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use Cosmos\System\Controller;

class Register extends Controller {

    function __construct() {
        parent::__construct($this);
    }

    public function index() {

        $this->load('Register');
    }

    public function finish() {
        $this->load('Register', 'Finish');
    }

    public function user() {

        if ($_POST) {
            $user = new \App\Controller\User();
            $user->register();
        }
    }

    public function confirm() {
        $hash = func_get_args()[0];
        $parameters = ['hash' => ['=', $hash, 'AND'], 'user_confirmed' => ['=', 0]];
        $user = (new \App\Model\User)->listingRegisters($parameters)[0];
        if (!empty($user)) {
            $user->setActive(1);
            $user->setUser_confirmed(1);
            $date = new \DateTime();
            $user->setConfirmed_at($date->format('Y-m-d H:i:s'));
            echo $user->update();
            $this->load('Register', 'Confirm');
        } else {
            $this->load('Register', 'Confirm_off');
        }
    }

}
