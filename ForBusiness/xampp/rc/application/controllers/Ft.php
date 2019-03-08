<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ft extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Ft_model', 'ft_model');
        $this->load->model('Ft2_model', 'ft2_model');
        $this->load->model('Ft3_model', 'ft3_model');
        $this->load->model('Fi_model', 'fi_model');
        $this->load->model('Td_model', 'td_model');
        $this->load->model('Dic_model', 'dic_model');
        $this->user_model->logged();
        $this->utils->set_back_url();
    }

    function index() {
        $this->breadcrumbs->push('Faturação', '/ft');
        $data = array();

        //parameters
        $data["post"] = $this->input->post();
        $doc = $this->input->post("doc");
        $numreg = $this->input->post("numreg");
        $fno = $this->input->post("fno");
        $tabFilterData = rawurldecode($this->input->post("tabFilterData"));

        if (strlen(trim($tabFilterData))) {
            $data['ft'] = $this->ft_model->getFilterWhere(trim($tabFilterData));
        } 
        else if ($doc && trim($fno)) {
            $data['ft'] = $this->ft_model->getAll(array(), array("ndoc" => $doc, "fno" => $fno), array());
        }
        else {
            if ($doc && $numreg)
                $data['ft'] = $this->ft_model->getAll(array(), array("ndoc" => $doc), array("usrdata" => "DESC", "usrhora" => "DESC"), $numreg);
            else if ($doc && 0)
                $data['ft'] = $this->ft_model->getAll(array(), array("ndoc" => $doc), array("usrdata" => "DESC", "usrhora" => "DESC"));
            else
                $data['ft'] = array();
        }

        $data['td'] = $this->td_model->getAll(array(), array(), array("nmdoc" => "ASC"));
        $data['dic'] = $this->dic_model->getAll(array(), array("tabela" => "ft"), array("titulo"=>"ASC"));
        $data['fno'] = $fno;

        $this->template->content->view('ft/index', $data);
        $this->template->publish();
    }

    function reg() {
        if ($this->uri->segment(3) === FALSE) {
            show_404();
        } else {
            $data = array();

            $stamp = $this->uri->segment(3);
            $data['ft'] = $this->ft_model->getRegister($stamp);
            $data['ft2'] = $this->ft2_model->getRegister($stamp);
            $data['ft3'] = $this->ft3_model->getRegister($stamp);
            $data['fi'] = $this->fi_model->getLinhas($stamp);
            $data['stamp'] = $stamp;

            if (count($data['ft'])) {
                $this->breadcrumbs->push('Doc. Faturação', '/ft');
                $this->breadcrumbs->push($data['ft']['nmdoc'] . ' nº ' . $data['ft']['fno'], '/ft/reg/' . $stamp);
                $this->template->content->view('ft/reg', $data);
                $this->template->publish();
            } else {
                show_404();
            }
        }
    }

}
