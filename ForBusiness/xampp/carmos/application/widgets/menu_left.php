<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_left extends Widget {
    
    public function display($args = array()) {
        $this->load->model('Td_model', 'td_model');
        $this->load->model('Ts_model', 'ts_model');
        
        $data = array();        
        $this->load->view('template/menu_left', $data);
    }

}