<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model class.
 * 
 * @extends CI_Model
 */
class Utils_model extends CI_Model {

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

    public function stamp() {
        $query = "select CONVERT(VARCHAR(25), (select UPPER(suser_sname())+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5))) stamp";
        $query = $this->mssql->mssql__select($query);
        return $query[0]["stamp"];
    }

}
