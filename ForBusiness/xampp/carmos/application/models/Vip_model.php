<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * St_model class.
 * 
 * @extends CI_Model
 */
class Vip_model extends CI_Model {

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

    public function getData($stamp) {
        $update_values = array();
        $update_values[] = $stamp;
        
        $query = "	
            select *
            from cl (nolock)
            where 
               clstamp = ?
        ";
        $sql_status = $this->mssql->mssql__prepare_sel($query, $update_values);

        return $sql_status;
    }
}
