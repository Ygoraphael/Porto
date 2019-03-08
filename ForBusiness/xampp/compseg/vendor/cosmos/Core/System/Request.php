<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Cosmos\System;

/**
 * Description of Request
 *
 * @author Jeferson Kaefer
 */
Class Request {

    private $_controller;
    private $_method;
    private $_args;

    public function __construct() {
        $parts = explode('/', $_SERVER['REQUEST_URI']);
        $parts = array_filter($parts);

        $this->_controller = ($c = array_shift($parts)) ? $c : 'Index';
        $this->_method = ($c = array_shift($parts)) ? $c : 'index';
        $this->_args = (isset($parts[0])) ? $parts : array();

        if ($this->_controller == 'facebook') {
            $method = explode('?', $this->_method);
            if (is_array($method)) {
                $this->_method = $method[0];
                $this->_args = $method;
            }
        }
        if ($this->_controller == 'pay') {
            $method = explode('?', $this->_method);
            if (is_array($method)) {
                $this->_method = $method[0];
                $this->_args = $method;
            }
        }
    }

    public function getController() {
        return $this->_controller;
    }

    public function getMethod() {
        return $this->_method;
    }

    public function getArgs() {
        return $this->_args;
    }

}
