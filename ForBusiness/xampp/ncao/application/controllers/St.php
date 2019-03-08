<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class St extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('St_model', 'st_model');
        $this->load->model('Sa_model', 'sa_model');
        $this->load->model('Sz_model', 'sz_model');
        $this->user_model->logged();
        $this->utils->set_back_url();
    }

    function index() {
        $this->breadcrumbs->push('Artigos', '/st');

        $data = array();
        $data['st'] = $this->st_model->getAll(array("ref", "design", "unidade", "peso", "ststamp", "epv1", "stock"), array("inactivo" => 0));

        $this->template->content->view('st/index', $data);
        $this->template->publish();
    }

    function reg() {
        if ($this->uri->segment(3) === FALSE) {
            show_404();
        } else {
            $data = array();

            $stamp = $this->uri->segment(3);
            $data['st'] = $this->st_model->getRegister($stamp);
            $data['stamp'] = $stamp;

            if (count($data['st'])) {
                $data['sz'] = $this->sz_model->getAll();
                $data['sa'] = $this->sa_model->getAll(array(), array("ref" => $data['st']["ref"]));
                $this->breadcrumbs->push('Artigos', '/st/');
                $this->breadcrumbs->push($data['st']['ref']." - ".$data['st']['design'], '/st/reg/' . $stamp);
                $this->template->content->view('st/reg', $data);
                $this->template->publish();
            } else {
                show_404();
            }
        }
    }
}

