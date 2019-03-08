<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Config extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('user_model', 'user');
        $this->load->model('dossier_model', 'dossier');
        $this->load->model('nci_model', 'nci');
        $this->user->rootLogged();
    }
    
    function index() {
        $tsParams = array();
        $ts = $this->dossier->getTs( $tsParams );
        $u_ncidefParams = array();
        $u_ncidef = $this->nci->getU_ncidef( $u_ncidefParams );
        
        $data = array();
        $data["ts"] = $ts;
        $data["u_ncidef"] = $u_ncidef[0];
        $this->template->content->view('config/config', $data);
	$this->template->publish();
    }
    
    function email() {
        $u_ncidefParams = array();
        $u_ncidef = $this->nci->getU_ncidef( $u_ncidefParams );
        
        $data = array();
        $data["u_ncidef"] = $u_ncidef[0];
        $this->template->content->view('config/email', $data);
	$this->template->publish();
    }
    
    function basedados() {
        $u_ncidefParams = array();
        $u_ncidef = $this->nci->getU_ncidef( $u_ncidefParams );
        
        $data = array();
        $data["u_ncidef"] = $u_ncidef[0];
        $this->template->content->view('config/basedados', $data);
	$this->template->publish();
    }
    
    function utilizadores() {
        $u_nciusParams = array();
        $u_ncius = $this->nci->getU_ncius( $u_nciusParams );
        
        $data = array();
        $data["u_ncius"] = $u_ncius;
        $this->template->content->view('config/utilizadores', $data);
	$this->template->publish();
    }
    
    function utilizador() {
        $u_nciusParams = array( "usstamp" => $this->uri->segment(3) );
        $u_ncius = $this->nci->getU_ncius( $u_nciusParams );
        
        $data = array();
        $data["u_ncius"] = $u_ncius[0];
        $this->template->content->view('config/utilizador', $data);
	$this->template->publish();
    }
    
    public function update_utilizador()
    {      
        $post = $this->input->post("item");
        $post = json_decode($post, true);
        
        if ( !$post['u_ncius']['u_nciusstamp'] ) {
            show_404();
        }

        $data = $post;
        $params = array( "data" => $data );
        
        if ( $this->nci->update($params) ) {
            http_response_code(200);
            $response = array('message' => lang('update_success'));
        } else {
            http_response_code(400);
            $response = array('message' => lang('general_error'));
        }

        $this->output->set_output(json_encode($response));
    }
    
    public function update_dados()
    {      
        $post = $this->input->post("item");
        $post = json_decode($post, true);
        
        if ( !$post['u_ncidef']['u_ncidefstamp'] ) {
            show_404();
        }

        $data = $post;
        $params = array( "data" => $data );
        
        if ( $this->nci->update($params) ) {
            http_response_code(200);
            $response = array('message' => lang('update_success'));
        } else {
            http_response_code(400);
            $response = array('message' => lang('general_error'));
        }

        $this->output->set_output(json_encode($response));
    }
    
    public function get($table = NULL, $id = NULL)
    {
        if ($id === NULL || $table === NULL) {
            show_404();
        }

        $response = array(
            'item' => $this->nci->get($id)
        );

        http_response_code(200);
        $this->output->set_output(json_encode($response));
    }
    
    public function createNciUsers()
    {              
        if ( $this->nci->createNciUsers() ) {
            http_response_code(200);
            $response = array('message' => lang('table_create_success'));
        } else {
            http_response_code(400);
            $response = array('message' => lang('general_error'));
        }

        $this->output->set_output(json_encode($response));
    }
    
    public function updateNciUsers()
    {              
        if ( $this->nci->updateNciUsers() ) {
            http_response_code(200);
            $response = array('message' => lang('table_update_success'));
        } else {
            http_response_code(400);
            $response = array('message' => lang('general_error'));
        }

        $this->output->set_output(json_encode($response));
    }
    
    public function createNciDef()
    {              
        if ( $this->nci->createNciDef() ) {
            http_response_code(200);
            $response = array('message' => lang('table_create_success'));
        } else {
            http_response_code(400);
            $response = array('message' => lang('general_error'));
        }

        $this->output->set_output(json_encode($response));
    }
    
    public function createNciTabelaPonto()
    {      
        $post = $this->input->post("item");
        $post = json_decode($post, true);

        $data = $post;
        $params = $data;
        
        if ( $this->nci->createNciTabelaPonto($params) ) {
            http_response_code(200);
            $response = array('message' => lang('table_create_success'));
        } else {
            http_response_code(400);
            $response = array('message' => lang('general_error'));
        }

        $this->output->set_output(json_encode($response));
    }
    
    public function createNciTabelaTarefas()
    {      
        $post = $this->input->post("item");
        $post = json_decode($post, true);

        $data = $post;
        $params = $data;
        
        if ( $this->nci->createNciTabelaTarefas($params) ) {
            http_response_code(200);
            $response = array('message' => lang('table_create_success'));
        } else {
            http_response_code(400);
            $response = array('message' => lang('general_error'));
        }

        $this->output->set_output(json_encode($response));
    }
    
    public function createNciTabelaTarefasRegisto()
    {      
        $post = $this->input->post("item");
        $post = json_decode($post, true);

        $data = $post;
        $params = $data;
        
        if ( $this->nci->createNciTabelaTarefasRegisto($params) ) {
            http_response_code(200);
            $response = array('message' => lang('table_create_success'));
        } else {
            http_response_code(400);
            $response = array('message' => lang('general_error'));
        }

        $this->output->set_output(json_encode($response));
    }
    
    public function createNciTabelaTarefasRegistoLinhas()
    {      
        $post = $this->input->post("item");
        $post = json_decode($post, true);

        $data = $post;
        $params = $data;
        
        if ( $this->nci->createNciTabelaTarefasRegistoLinhas($params) ) {
            http_response_code(200);
            $response = array('message' => lang('table_create_success'));
        } else {
            http_response_code(400);
            $response = array('message' => lang('general_error'));
        }

        $this->output->set_output(json_encode($response));
    }
}
