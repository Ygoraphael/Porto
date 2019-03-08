<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sync extends CI_Controller {

    public function index() {
        $this->load->model('sync_model');

        $dados = $this->input->post('data');
        $this->sync_model->processa_dados($dados);
    }

}
