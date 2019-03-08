<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Phc extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $data = array();
        $this->template->content->view('phc/index', $data);
        $this->template->publish();
    }

    function ouro() {
        $data = array();
        $this->template->content->view('phc/ouro', $data);
        $this->template->publish();
    }

    function oficinas() {
        $data = array();
        $this->template->content->view('phc/oficinas', $data);
        $this->template->publish();
    }

    function erp() {
        $data = array();
        $this->template->content->view('phc/erp', $data);
        $this->template->publish();
    }

    function financeira() {
        $data = array();
        $this->template->content->view('phc/financeira', $data);
        $this->template->publish();
    }

    function rh() {
        $data = array();
        $this->template->content->view('phc/rh', $data);
        $this->template->publish();
    }

    function suporte() {
        $data = array();
        $this->template->content->view('phc/suporte', $data);
        $this->template->publish();
    }

    function crm() {
        $data = array();
        $this->template->content->view('phc/crm', $data);
        $this->template->publish();
    }

    function frota() {
        $data = array();
        $this->template->content->view('phc/frota', $data);
        $this->template->publish();
    }

    function projetos() {
        $data = array();
        $this->template->content->view('phc/projetos', $data);
        $this->template->publish();
    }

    function industria() {
        $data = array();
        $this->template->content->view('phc/industria', $data);
        $this->template->publish();
    }

    function logistica() {
        $data = array();
        $this->template->content->view('phc/logistica', $data);
        $this->template->publish();
    }

    function restauracao() {
        $data = array();
        $this->template->content->view('phc/restauracao', $data);
        $this->template->publish();
    }

    function retalho() {
        $data = array();
        $this->template->content->view('phc/retalho', $data);
        $this->template->publish();
    }

    function construcao() {
        $data = array();
        $this->template->content->view('phc/construcao', $data);
        $this->template->publish();
    }

    function clinicas() {
        $data = array();
        $this->template->content->view('phc/clinicas', $data);
        $this->template->publish();
    }
    
}

?>