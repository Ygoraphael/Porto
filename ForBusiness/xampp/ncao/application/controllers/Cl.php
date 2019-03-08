<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cl extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Cl_model', 'cl_model');
        $this->user_model->logged();
        $this->utils->set_back_url();
    }

    function index() {
        $this->breadcrumbs->push('Clientes', '/cl');

        $data = array();
        $data['cl'] = $this->cl_model->getAll(array(), array("vendedor"=>$this->session->userdata('userdata')['vendedor']));
       // $params=array(), $where=array(), $orderby=array(), $limit=0

        $this->template->content->view('cl/index', $data);
        $this->template->publish();
    }

    function reg() {
        if ($this->uri->segment(3) === FALSE) {
            show_404();
        } else {
            $data = array();

            $stamp = $this->uri->segment(3);
            $data['cl'] = $this->cl_model->getRegister($stamp);
            $data['cc'] = $this->cl_model->get_cliente_faturacao_atraso($stamp);
            $data['stamp'] = $stamp;
            $data['referred_from'] = $this->session->userdata('previous_url');

            if (count($data['cl'])) {
                $this->breadcrumbs->push('Clientes', '/cl');
                $this->breadcrumbs->push($data['cl']['nome'], '/cl/reg/' . $stamp);
                $this->template->content->view('cl/reg', $data);
                $this->template->publish();
            } else {
                show_404();
            }
        }
    }

    function cc() {
        if ($this->uri->segment(3) === FALSE) {
            show_404();
        } else {
            $data = array();

            $stamp = $this->uri->segment(3);
            $data['cl'] = $this->cl_model->getRegister($stamp);

            $params = array();
            $params["stamp"] = $stamp;

            if (!empty($this->input->get('di')) && $this->utils->validateDate($this->input->get('di'))) {
                $params["datai"] = $this->input->get('di');
            } else {
                $params["datai"] = date('Y') . "-01-01";
            }

            if (!empty($this->input->get('df')) && $this->utils->validateDate($this->input->get('df'))) {
                $params["dataf"] = $this->input->get('df');
            } else {
                $params["dataf"] = date('Y') . "-12-31";
            }

            $data["datai"] = $params["datai"];
            $data["dataf"] = $params["dataf"];
            $data['ccpre'] = $this->cl_model->get_cc_pre($params);
            $data['cc'] = $this->cl_model->get_cc($params);
            $data['stamp'] = $stamp;
            $data['referred_from'] = $this->session->userdata('previous_url');

            if (count($data['cl'])) {
                $this->breadcrumbs->push('Clientes', '/cl');
                $this->breadcrumbs->push('Conta Corrente de ' . $data['cl']['nome'], '/cl/cc/' . $stamp);
                $this->template->content->view('cl/cc', $data);
                $this->template->publish();
            } else {
                show_404();
            }
        }
    }

}
