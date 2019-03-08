<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Re extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Re_model', 're_model');
        $this->load->model('Rl_model', 'rl_model');
        $this->load->model('Tsre_model', 'tsre_model');
        $this->load->model('Dic_model', 'dic_model');
        $this->user_model->logged();
        $this->utils->set_back_url();
    }

    function index() {
        $this->breadcrumbs->push('Recibos', '/ft');
        $data = array();

        //parameters
        $data["post"] = $this->input->post();
        $doc = $this->input->post("doc");
        $numreg = $this->input->post("numreg");
        $rno = $this->input->post("rno");
        $tabFilterData = rawurldecode($this->input->post("tabFilterData"));

        if (strlen(trim($tabFilterData))) {
            $data['re'] = $this->re_model->getFilterWhere(trim($tabFilterData));
        } 
        else if ($doc && trim($rno)) {
            $data['re'] = $this->re_model->getAll(array(), array("ndoc" => $doc, "rno" => $rno), array());
        }
        else {
            if ($doc && $numreg)
                $data['re'] = $this->re_model->getAll(array(), array("ndoc" => $doc), array("usrdata" => "DESC", "usrhora" => "DESC"), $numreg);
            else if ($doc && 0)
                $data['re'] = $this->re_model->getAll(array(), array("ndoc" => $doc), array("usrdata" => "DESC", "usrhora" => "DESC"));
            else
                $data['re'] = array();
        }

        $data['tsre'] = $this->tsre_model->getAll(array(), array(), array("nmdoc" => "ASC"));
        $data['dic'] = $this->dic_model->getAll(array(), array("tabela" => "re"), array("titulo"=>"ASC"));
        $data['rno'] = $rno;

        $this->template->content->view('re/index', $data);
        $this->template->publish();
    }

    function reg() {
        if ($this->uri->segment(3) === FALSE) {
            show_404();
        } else {
            $data = array();

            $stamp = $this->uri->segment(3);
            $data['re'] = $this->re_model->getRegister($stamp);
            $data['rl'] = $this->rl_model->getLinhas($stamp);
            $data['stamp'] = $stamp;

            if (count($data['re'])) {
                $this->breadcrumbs->push('Recibos', '/re');
                $this->breadcrumbs->push($data['re']['nmdoc'] . ' nº ' . $data['re']['rno'], '/re/reg/' . $stamp);
                $this->template->content->view('re/reg', $data);
                $this->template->publish();
            } else {
                show_404();
            }
        }
    }
}
