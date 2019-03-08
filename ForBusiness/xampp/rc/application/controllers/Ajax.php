<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('user_model', 'user');
        $this->load->model('dossier_model', 'dossier');
        $this->load->model('nci_model', 'nci');
        $this->load->model('st_model', 'st');
        $this->load->model('cl_model', 'cl');
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

//funcao para obter dados de um artigo diretamente atraves da referencia em ajax post
    function getartigo() {
        $params = array(array("ref", $this->input->post('ref')));
        $response = $this->st->getRegister($params);
        http_response_code(200);
        $this->output->set_output(json_encode($response));
    }

    function cliente() {
        $params = array(array("no", $this->input->post('no')), array("estab", 0));
        $response = $this->cl->getRegister($params);
        http_response_code(200);
        $this->output->set_output(json_encode($response));
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

    function filtrocl() {
        $keywords = $this->input->post('keywords');

        if ($keywords === NULL) {
            $response = array();
        } else {
            $response = $this->cl->filtro_cl(array('no', 'nome', 'ncont', 'pncont'), $keywords);
        }
        http_response_code(200);
        $this->output->set_output(json_encode($response));
    }

    function filtrost() {
        $keywords = $this->input->post('keywords');

        if ($keywords === NULL) {
            $response = array();
        } else {
            $response = $this->st->filtro_st(array('ref', 'design', 'epv1', 'stock'), $keywords);
        }
        http_response_code(200);
        $this->output->set_output(json_encode($response));
    }

    function ModalCl() {
        $cl = $this->cl->getAll(array('no', 'nome', 'ncont', 'pncont'), array('inactivo' => '0'), array('nome' => 'ASC'));

        $data = array();
        $data["cl"] = $cl;
        $this->template->content->view('ajax/modalcl', $data);
        $this->template->publish();
    }

    function ModalSt() {
        $st = $this->st->getAll(array('ref', 'design', 'epv1', 'stock'), array('inactivo' => '0'), array('design' => 'ASC'));

        $data = array();
        $data["st"] = $st;
        $this->template->content->view('ajax/modalst', $data);
        $this->template->publish();
    }

    function jsonDecode($json, $assoc = false) {
        $ret = json_decode($json, $assoc);
        if ($error = json_last_error()) {
            $errorReference = [
                JSON_ERROR_DEPTH => 'The maximum stack depth has been exceeded.',
                JSON_ERROR_STATE_MISMATCH => 'Invalid or malformed JSON.',
                JSON_ERROR_CTRL_CHAR => 'Control character error, possibly incorrectly encoded.',
                JSON_ERROR_SYNTAX => 'Syntax error.',
                JSON_ERROR_UTF8 => 'Malformed UTF-8 characters, possibly incorrectly encoded.',
                JSON_ERROR_RECURSION => 'One or more recursive references in the value to be encoded.',
                JSON_ERROR_INF_OR_NAN => 'One or more NAN or INF values in the value to be encoded.',
                JSON_ERROR_UNSUPPORTED_TYPE => 'A value of a type that cannot be encoded was given.',
            ];
            $errStr = isset($errorReference[$error]) ? $errorReference[$error] : "Unknown error ($error)";
            throw new \Exception("JSON decode error ($error): $errStr");
        }
        return $ret;
    }

    function saveOrder() {
        $data = $this->input->post('data');
        $data = json_decode(base64_decode($data), true);

        $this->load->library('DossierInterno');
        $di = new DossierInterno();

        $di->set("bo", "no", $data["no"]);
        $di->set("bo", "nome", $data["nome"]);
        $di->set("bo", "morada", $data["morada"]);
        $di->set("bo", "ncont", $data["ncont"]);
        $di->set("bo", "local", $data["local"]);
        $di->set("bo", "codpost", $data["codpost"]);
        $di->set("bo", "email", $data["email"]);
        $di->set("bo", "telefone", $data["telefone"]);
        $di->set("bo", "ndos", 48);
        $di->set("bo", "obs", $data["obs"]);
        $di->set("bo", "obstab2", $data["obstab2"]);
        $di->set("bo", "vendedor", $this->session->userdata('userdata')['vendedor']);
        $di->set("bo", "tpstamp", $data["tpdesc"]);

        foreach ($data["bi"] as $bi) {
            $di->newBi();
            $di->set("bi", "ref", html_entity_decode(base64_decode($bi["ref"])));
            $di->set("bi", "design", html_entity_decode(base64_decode($bi["design"])));
            $di->set("bi", "qtt", $bi["qtt"]);
            $di->set("bi", "edebito", $bi["epv"]);
            $di->set("bi", "desconto", $bi["desconto"]);
        }

        //$di->printData();
        $result = $di->save();
        $response = array("sucess" => $result, "message" => $result ? "Encomenda criada com sucesso" : "Erro ao criar encomenda" );
        
        $_SESSION['sucess'] = $response["sucess"];
        $_SESSION['message'] = $response["message"];
        $this->session->mark_as_flash(array('sucess', 'message'));
        
        http_response_code(200);
        $this->output->set_output(json_encode($response));
    }

}
