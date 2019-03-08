<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Dashboard_model class.
 * 
 * @extends CI_Model
 */
class Tp_model extends CI_Model {

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
    
    public function getTiposPagamento($fields) {
        $sql  = " SELECT " . implode(", ", $fields);
        $sql .= " FROM tp";
        $sql .= " WHERE formapag = 1 and";
        $sql .= " ousrdata > '20120501' and";
        $sql .= " tipo = 1";
        $sql .= " ORDER BY descricao ASC";

        return $this->db->query($sql)->result_array();
    }

}
