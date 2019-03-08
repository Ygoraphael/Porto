<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Vip_model', 'vip_model');
    }

    function index() {

    }
    
    function update() {
        echo "aaaa";
    }
}
