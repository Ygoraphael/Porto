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

    public function validate($params) {

        $this->db->select('*');
        $this->db->from('us');
        $this->db->where('inactivo', 0);
        $this->db->where('usercode', $params["username"]);
        $this->db->where('aextpw', $params["password"]);
        $query = $this->db->get();

        if ($query->num_rows()) {
            return $query->result_array();
        }

        return array();
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

    public function get_salesman_data($params) {
        $this->db->select('*');
        $this->db->from('cm3');
        $this->db->where('cm', $params["salesman"]);
        $query = $this->db->get();

        if ($query->num_rows()) {
            return $query->result_array();
        }

        return array();
    }

}
