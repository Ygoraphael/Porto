<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Web extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $data = array();
        $this->template->content->view('web/index', $data);
        $this->template->publish();
    }
    
}

?>