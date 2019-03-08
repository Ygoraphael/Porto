<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Dashboard_model class.
 * 
 * @extends CI_Model
 */
class Bo3_model extends CI_Model {

    /**
     * __construct function.
     * 
     * @access public
     * @return void
     */
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

}
