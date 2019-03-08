<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Dashboard_model class.
 * 
 * @extends CI_Model
 */
class Bo_model extends CI_Model {

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

    public function getFilterWhere($where) {
        try {
            $query = $this->db->query("select * from bo where " . $where);
        } catch (Exception $e) {
            return array();
        }

        if( $query )
            $result = $query->result_array();
        else
            $result = array();
        return $result;
    }

}
