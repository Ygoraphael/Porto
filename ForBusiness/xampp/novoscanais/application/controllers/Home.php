<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $data = array();
        $this->template->content->view('home/index', $data);
        $this->template->publish();
    }
}

?>