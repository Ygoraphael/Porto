<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_left extends Widget {
    
    public function display($args = array()) {       
        $data = array();        
        $this->load->view('template/menu_left', $data);
    }

}