<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Vip extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Vip_model', 'vip_model');
    }

    function index() {
        if ($this->uri->segment(2) === FALSE) {
            show_404();
        } else {
			//se isto tiver post, processa post
			$something = $this->input->post();
			
			print_r($something);
			
            $stamp = $this->uri->segment(2);
            $data = array();
            $dados = $this->vip_model->getData($stamp);

            if(count($dados)) {
                $data['cliente'] = $dados[0];
                $this->template->content->view('vip/index', $data);
                $this->template->publish();
            }
            else {
                redirect('Error404');
            }            
        }
    }
    
    function update() {
        echo "aaaa";
    }
}
