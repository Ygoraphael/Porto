<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model class.
 * 
 * @extends CI_Model
 */
class User_model extends CI_Model {

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

    public function validate( $params ) {
        $update_values = array();
        $update_values[] = $params["username"];
        $update_values[] = $params["password"];

        $query = "	
            select *
            from us
            inner join u_ncius on us.usercode = u_ncius.usercode
            where
                us.inactivo = 0 and
                u_ncius.ativo = 1 and
                us.usercode = ? and
                u_ncius.u_pass = ?
        ";

        $sql_status = $this->mssql->mssql__prepare_sel($query, $update_values);
        
        if (sizeof($sql_status)) {
            return $sql_status;
        }
        
        return false;
    }
    
    public function logged() {
        $logged = $this->session->userdata('logged');

        if (!isset($logged) || $logged != true) {
            die();
        }
    }
    
    public function rootLogged() {
        $logged = $this->session->userdata('loggedroot');

        if (!isset($logged) || $logged != true) {
            die();
        }
    }
    
    public function islogged() {
        $logged = $this->session->userdata('logged');

        return $logged;
    }
    
    public function isRootLogged() {
        $logged = $this->session->userdata('loggedroot');

        return $logged;
    }
}
