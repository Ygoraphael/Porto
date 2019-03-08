<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cosmos\System;

/**
 * Description of ErrorController
 *
 * @author Jeferson Kaefer
 */
Class ErrorController {

    public function index() {
        return 'erro, 404';
    }

    public function error($message = 'No information about the error') {
        echo '<pre>' . print_r($message, 1) . '</pre>';
    }

}
