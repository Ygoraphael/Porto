<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Office365 extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $data = array();
        $this->template->content->view('office365/index', $data);
        $this->template->publish();
    }

}

?>