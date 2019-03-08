<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Bo extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Bo_model', 'bo_model');
        $this->load->model('Bo2_model', 'bo2_model');
        $this->load->model('Bo3_model', 'bo3_model');
        $this->load->model('Bi_model', 'bi_model');
        $this->load->model('Ts_model', 'ts_model');
        $this->load->model('Dic_model', 'dic_model');
        $this->load->model('Tp_model', 'tp_model');
        $this->user_model->logged();
        $this->utils->set_back_url();
    }

    function index() {
        $this->breadcrumbs->push('Dossiers Internos', '/bo');
        $data = array();

        //parameters
        $data["post"] = $this->input->post();
        $doc = $this->input->post("doc");
        $numreg = $this->input->post("numreg");
        $obrano = $this->input->post("obrano");
        $tabFilterData = rawurldecode($this->input->post("tabFilterData"));

        if (strlen(trim($tabFilterData))) {
            $data['bo'] = $this->bo_model->getFilterWhere(trim($tabFilterData));
        } else if ($doc && trim($obrano)) {
            $data['bo'] = $this->bo_model->getAll(array(), array("ndos" => $doc, "obrano" => $obrano), array());
        } else {
            if ($doc && $numreg)
                $data['bo'] = $this->bo_model->getAll(array(), array("ndos" => $doc), array("usrdata" => "DESC", "usrhora" => "DESC"), $numreg);
            else if ($doc && 0)
                $data['bo'] = $this->bo_model->getAll(array(), array("ndos" => $doc), array("usrdata" => "DESC", "usrhora" => "DESC"));
            else
                $data['bo'] = array();
        }

        $data['ts'] = $this->ts_model->getAll(array(), array(), array("nmdos" => "ASC"));
        $data['dic'] = $this->dic_model->getAll(array(), array("tabela" => "bo", "CHAR_LENGTH(trim(titulo)) >" => "0", "titulo <>" => "?"), array("titulo" => "ASC"));
        $data['obrano'] = $obrano;

        $this->template->content->view('bo/index', $data);
        $this->template->publish();
    }

    function reg() {
        if ($this->uri->segment(3) === FALSE) {
            show_404();
        } else {
            $data = array();

            $stamp = $this->uri->segment(3);
            $data['bo'] = $this->bo_model->getRegister($stamp);
            $data['bo2'] = $this->bo2_model->getRegister($stamp);
            $data['bo3'] = $this->bo3_model->getRegister($stamp);
            $data['bi'] = $this->bi_model->getLinhas($stamp);
            $data['stamp'] = $stamp;

            if (count($data['bo'])) {
                $this->breadcrumbs->push('Dossier Interno', '/bo');
                $this->breadcrumbs->push($data['bo']['nmdos'] . ' nº ' . $data['bo']['obrano'], '/bo/reg/' . $stamp);
                $this->template->content->view('bo/reg', $data);
                $this->template->publish();
            } else {
                show_404();
            }
        }
    }

    function add() {
        $this->breadcrumbs->push('Introdução Dossier Interno', '/bo/add');
        $data = array();

        //parameters
        $data["post"] = $this->input->post();
        $tmpreg = $this->input->post("tmpreg");

        $data['bo'] = array();
        $data['ts'] = $this->ts_model->getAll(array(), array(), array("nmdos" => "ASC"));
        $data['tpdesc'] = $this->tp_model->getTiposPagamento(array("descricao", "tpstamp"));

        $this->template->content->view('bo/add', $data);
        $this->template->publish();
    }

}
