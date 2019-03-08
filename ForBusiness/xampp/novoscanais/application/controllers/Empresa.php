<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Empresa extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $data = array();
        $this->template->content->view('empresa/index', $data);
        $this->template->publish();
    }
}

?>
