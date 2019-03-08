<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Dashboard_model class.
 * 
 * @extends CI_Model
 */
class Bi_model extends CI_Model {

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

    public function getLinhas($stamp) {
        $this->db->select('*');
        $this->db->from("bi");
        $this->db->where('bostamp', $stamp);
        $this->db->order_by('lordem asc');

        $result = $this->db->get()->result_array();
        if (count($result))
            return $result;
        else
            return array();
    }

}