<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('checkout_model');
        $this->load->library('mssql');
        $this->load->library('pagination');
        $this->load->helper('cookie');
        $this->load->library('urlparameters');
    }

    public function set_language() {
        $_SESSION["language"] = $this->input->post('lang');
        $_SESSION["language_code"] = $this->input->post('lang_code');
    }

    public function set_currency() {
        $_SESSION["type_currency"] = $this->input->post('type_currency');
        $_SESSION["i"] = $this->input->post('i');
        $_SESSION["ch"] = $this->input->post('ch');
        //val currency vs EUR
        //log_message('ERROR', print_r($_SESSION["ch"],TRUE));
        if ($_SESSION["ch"] == EUR) {
            $_SESSION["c_currency"] = 1;
        } else {
            $_SESSION["c_currency"] = $this->currency->change($_SESSION["ch"]);
        }
    }

}
