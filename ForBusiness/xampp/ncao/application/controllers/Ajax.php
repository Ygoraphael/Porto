<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('user_model', 'user');
        $this->load->model('dossier_model', 'dossier');
        $this->load->model('nci_model', 'nci');
        $this->load->model('st_model', 'st');
        $this->user->logged();
        $this->template->set_template('template_ajax');
    }

    function artigo() {
        $stParams = array("ststamp" => $this->uri->segment(3));
        $st = $this->st->getSt($stParams);

        $data = array();
        if (count($st)) {
            $data["st"] = $st[0];
            $this->template->content->view('ajax/artigo', $data);
            $this->template->publish();
        }
    }

    function get_st_by_ref_barcode($search = NULL) {
        if ($search === NULL) {
            show_404();
        }

        $stParams = array("search" => $search);
        $response = $this->st->get_st_by_ref_barcode($stParams);

        http_response_code(200);
        $this->output->set_output(json_encode($response));
    }

    function save_qtt($qtt = NULL, $ref = NULL) {
        $qtt = $_POST['qtt'];
        $ref = $_POST['ref'];
        if ($qtt === NULL) {
            show_404();
        }
        $ArtigoParams = array();
        $ArtigoParams["qtt"] = $qtt;
        $ArtigoParams["ref"] = $ref;
        $response = $this->st->save_qtt($ArtigoParams);

        http_response_code(200);
        $this->output->set_output(json_encode($response));
    }

    function save_new_linha_encomenda() {
        $qtt = $_POST['qtt'];
        $qtt_satisf = $_POST['qtt_satisf'];
        $ref = $_POST['ref'];
        $bostamp = $_POST['bostamp'];
        if ($qtt === NULL) {
            show_404();
        }
        $ArtigoParams = array();
        $ArtigoParams["qtt"] = $qtt;
        $ArtigoParams["qtt_satisf"] = $qtt_satisf;
        $ArtigoParams["ref"] = $ref;
        $ArtigoParams["bostamp"] = $bostamp;
        $response = $this->st->save_new_linha_encomenda($ArtigoParams);

        http_response_code(200);
        $this->output->set_output(json_encode($response));
    }
    
    function save_update_linha_encomenda() {
        $qtt = $_POST['qtt'];
        $qtt_satisf = $_POST['qtt_satisf'];
        $bistamp = $_POST['stamp'];
        $bostamp = $_POST['bostamp'];
        
        if ($qtt === NULL) {
            show_404();
        }
        
        $ArtigoParams = array();
        $ArtigoParams["qtt"] = $qtt;
        $ArtigoParams["qtt_satisf"] = $qtt_satisf;
        $ArtigoParams["bistamp"] = $bistamp;
        $ArtigoParams["bostamp"] = $bostamp;
        $response = $this->st->save_update_linha_encomenda($ArtigoParams);

        http_response_code(200);
        $this->output->set_output(json_encode($response));
    }
    
    function fechar_encomenda() {
        $bostamp = $_POST['bostamp'];
        
        if ($bostamp === NULL) {
            show_404();
        }
        
        $Params = array();
        $Params["bostamp"] = $bostamp;
        $response = $this->st->fechar_encomenda($Params);

        http_response_code(200);
        $this->output->set_output(json_encode($response));
    }
    
    function abrir_encomenda() {
        $bostamp = $_POST['bostamp'];
        
        if ($bostamp === NULL) {
            show_404();
        }
        
        $Params = array();
        $Params["bostamp"] = $bostamp;
        $response = $this->st->abrir_encomenda($Params);

        http_response_code(200);
        $this->output->set_output(json_encode($response));
    }
    
    function status_fechar_encomenda() {
        $bostamp = $_POST['bostamp'];
        
        if ($bostamp === NULL) {
            show_404();
        }
        
        $Params = array();
        $Params["bostamp"] = $bostamp;
        $response = $this->st->status_fechar_encomenda($Params);

        http_response_code(200);
        $this->output->set_output(json_encode($response));
    }
    
    function status_abrir_encomenda() {
        $bostamp = $_POST['bostamp'];
        
        if ($bostamp === NULL) {
            show_404();
        }
        
        $Params = array();
        $Params["bostamp"] = $bostamp;
        $response = $this->st->status_abrir_encomenda($Params);

        http_response_code(200);
        $this->output->set_output(json_encode($response));
    }

    function get_artigo($ref = NULL) {
        $ref = $_POST['ref'];
        if ($ref === NULL) {
            show_404();
        }

        $ArtigoParams = array();
        $ArtigoParams["ref"] = $ref;
        $response = $this->st->get_artigo($ArtigoParams);

        http_response_code(200);
        $this->output->set_output(json_encode($response));
    }

}
