<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model class.
 * 
 * @extends CI_Model
 */
class Dossier_model extends CI_Model {

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

	public function update_encomenda($params) {

        if (isset($params["volume"]) && isset($params["peso"]) && isset($params["bostamp"])) {
            $query = "
                update bo 
                set 
                    u_volume = {$params["volume"]},
                    u_pesotot = {$params["peso"]}
                where 
                    bostamp = rtrim(ltrim('{$params["bostamp"]}'))
            ";
            $sql_status = $this->mssql->mssql__execute($query);
            return $sql_status;
        } else {
            return array();
        }
    }
	
    public function getTs( $params ) {
        $update_values = array();

        $query = "	
            select *
            from ts
            order by nmdos
        ";

        $sql_status = $this->mssql->mssql__prepare_sel($query, $update_values);
        return $sql_status;
    }
    
    public function getDossierCab( $params ) {
        $where_array = array();

        $query = "
            select top 100 *
            from bo
            inner join bo2 on bo.bostamp = bo2.bo2stamp
            inner join bo3 on bo.bostamp = bo3.bo3stamp
        ";
        
        if (isset($params["ndos"])) {
            $where_array[] = " ndos = '" . $params["ndos"] . "' ";
        }
        if (isset($params["fechada"])) {
            $where_array[] = " fechada = '" . $params["fechada"] . "' ";
        }
        if (isset($params["tabela1"])) {
            $where_array[] = " tabela1 = '" . $params["tabela1"] . "' ";
        }
        if (isset($params["bostamp"])) {
            $where_array[] = " bostamp = '" . $params["bostamp"] . "' ";
        }
        if (isset($params["dataobra_i"])) {
            $where_array[] = " dataobra >= '" . $params["dataobra_i"] . "' ";
        }
        if (isset($params["dataobra_f"])) {
            $where_array[] = " dataobra <= '" . $params["dataobra_f"] . "' ";
        }

        if (sizeof($where_array)) {
            $where = implode("AND", $where_array);

            if (substr($where, -3) == "AND")
                $where = substr($where, 0, strlen($where) - 3);

            $query .= "where " . $where;
        }
        
        $query .= "
            order by bo.ndos, bo.obrano
        ";

        $sql_status = $this->mssql->mssql__select($query);
        return $sql_status;
    }
    
    public function getDossierLin( $params ) {
        $update_values = array();
        $where_array = array();

        $query = "
            select bi.*, st.ststamp
            from bi
            left join st on bi.ref = st.ref
        ";
        
        if (isset($params["bostamp"])) {
            $where_array[] = " bi.bostamp = '" . $params["bostamp"] . "' ";
        }
        
        if (isset($params["linhasvazias"])) {
            if( !$params["linhasvazias"] )
                $where_array[] = " ( rtrim(ltrim(bi.ref)) <> '' OR rtrim(ltrim(bi.design)) <> '' ) ";
        }

        if (sizeof($where_array)) {
            $where = implode("AND", $where_array);

            if (substr($where, -3) == "AND")
                $where = substr($where, 0, strlen($where) - 3);

            $query .= "where " . $where;
        }
        
        $query .= "
            order by bi.lordem
        ";
        $sql_status = $this->mssql->mssql__prepare_sel($query, $update_values);
        return $sql_status;
    }

}
