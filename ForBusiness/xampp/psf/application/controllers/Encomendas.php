<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Encomendas extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('user_model', 'user');
        $this->load->model('dossier_model', 'dossier');
        $this->load->model('nci_model', 'nci');
        $this->load->model('st_model', 'st');
        $this->user->logged();
    }

    function index() {
        $data = array();
        $u_ncidefParams = array();
        $u_ncidef = $this->nci->getU_ncidef($u_ncidefParams)[0];

        $encParams = array("ndos" => $u_ncidef["ndospicking"]);
        $get_params = $this->input->get();

        if ($get_params) {
            if (isset($get_params["status"]) && $get_params["status"] == 1) {
                $encParams["tabela1"] = 'CONCLUÍDO';
                $data["status"] = $get_params["status"];
            } else if (isset($get_params["status"]) && $get_params["status"] == 0) {
                $encParams["tabela1"] = 'EM ABERTO';
                $data["status"] = $get_params["status"];
            } else if (isset($get_params["status"]) && $get_params["status"] == 2) {
                $encParams["tabela1"] = 'FATURADO';
                $data["status"] = $get_params["status"];
            } else if (isset($get_params["status"]) && $get_params["status"] == 3) {
                $data["status"] = $get_params["status"];
            } else if (!isset($get_params["status"])) {
                $data["status"] = 0;
                $encParams["tabela1"] = 'EM ABERTO';
            }

            if (!empty($get_params["dti"]) && isDate($get_params["dti"])) {
                $encParams["dataobra_i"] = str_replace("-", "", $get_params["dti"]);
                $data["dti"] = $get_params["dti"];
            } else {
                $data["dti"] = "";
            }

            if (!empty($get_params["dtf"]) && isDate($get_params["dti"])) {
                $encParams["dataobra_f"] = str_replace("-", "", $get_params["dtf"]);
                $data["dtf"] = $get_params["dtf"];
            } else {

                $data["dtf"] = "";
            }

            $enc = $this->dossier->getDossierCab($encParams);
            $data["enc"] = $enc;
            $this->template->content->view('encomendas/encomendas', $data);
            $this->template->publish();
        } else {
            $data["status"] = 0;
            $encParams["tabela1"] = 'EM ABERTO';
            $encParams["dataobra_i"] = date('Ym01');
            $data["dti"] = date('Y-m-01');
            $encParams["dataobra_f"] = date("Ymt");
            $data["dtf"] = date("Y-m-t");
            $enc = $this->dossier->getDossierCab($encParams);
            $data["enc"] = $enc;
            $this->template->content->view('encomendas/encomendas', $data);
            $this->template->publish();
        }
    }

    function encomenda() {
        $u_ncidefParams = array();
        $u_ncidef = $this->nci->getU_ncidef($u_ncidefParams)[0];

        $encParams = array("bostamp" => $this->uri->segment(3));
        $enc = $this->dossier->getDossierCab($encParams)[0];

        $encLinParams = array("linhasvazias" => "0", "bostamp" => $this->uri->segment(3));
        $enclin = $this->dossier->getDossierLin($encLinParams);

        $data = array();
        $data["enc"] = $enc;
        $data["enclin"] = $enclin;

        //$msg_content = hex2bin(substr($enc["obstab2"], 2, strlen($enc["obstab2"]) - 2));
        
        //file_put_contents("mensagem.msg", $msg_content);
        //$this->email_parser->setText(file_get_contents("mensagem.msg"));
        
        //$from = $this->email_parser->getHeader('from');
        //log_message("error", $from);
        
        $this->template->content->view('encomendas/encomenda', $data);
        $this->template->publish();
    }

    public function update_dados() {
        $post = $this->input->post("item");
        $post = json_decode($post, true);

        if (!$post['u_ncidef']['u_ncidefstamp']) {
            show_404();
        }

        $data = $post;
        $params = array("data" => $data);

        if ($this->nci->update($params)) {
            http_response_code(200);
            $response = array('message' => lang('update_success'));
        } else {
            http_response_code(400);
            $response = array('message' => lang('general_error'));
        }

        $this->output->set_output(json_encode($response));
    }

}
