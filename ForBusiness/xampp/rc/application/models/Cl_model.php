<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Dashboard_model class.
 * 
 * @extends CI_Model
 */
class Cl_model extends CI_Model {

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

    public function filtro_cl($fields, $keywords) {
        $keywords = str_replace(" ", "%", $keywords);
        
        $sql  = " SELECT " . implode(", ", $fields);
        $sql .= " FROM cl";
        $sql .= " WHERE inactivo = 0 and (";
        $sql .= " no LIKE '%$keywords%' OR nome LIKE '%$keywords%' OR ncont LIKE '%$keywords%'";
        $sql .= " )";
        $sql .= " ORDER BY nome ASC";

        return $this->db->query($sql)->result_array();
    }

    public function funcao($params = array()) {
        
    }

    public function get_num_cliente($stamp) {
        $this->db->select('no');
        $this->db->from(get_instance()->router->class);
        $this->db->where(get_instance()->router->class . 'stamp', $stamp);
        $result = $this->db->get()->result_array();

        if (count($result))
            return $result[0]["no"];
        else
            return 0;
    }

    public function get_cliente_faturacao_atraso($stamp) {
        $sql = "
            SELECT 
               cc.datalc,
               cc.dataven,
               cc.edeb,
               cc.ecred,
               cc.cmdesc,
               cc.nrdoc,
               cc.ftstamp
            FROM cc
            INNER JOIN cl on cc.no = cl.no and cl.estab = 0
            LEFT JOIN RE ON cc.restamp = re.restamp
            WHERE 
                cc.no=" . $this->get_num_cliente($stamp) . " AND 
                (
                    CASE WHEN cc.moeda='EURO' OR cc.moeda=space(11) THEN abs((cc.edeb-cc.edebf)-(cc.ecred-cc.ecredf)) 
                    ELSE abs((cc.debm-cc.debfm)-(cc.credm-cc.credfm)) END) > (CASE WHEN cc.moeda='EURO' OR cc.moeda=space(11) THEN 0.010000 ELSE 0 END
                )
            ORDER BY 
                cc.datalc,
                cc.cm,
                cc.nrdoc
        ";

        return $this->db->query($sql)->result_array();
    }

    public function get_cc_pre($params) {
        $no = $this->get_num_cliente($params["stamp"]);
        $datai = $params["datai"];
        $dataf = $params["dataf"];

        $sql = "
            select ifnull(sum(edeb-ecred-erec), 0) saldo
            from
            ( 
                select	
                    cmdesc, 
                    edeb, 
                    ecred, 
                    ifnull((select sum(erec) from rl inner join re on rl.restamp = re.restamp where procdata < '$datai' and rl.ccstamp=cc.ccstamp and re.process=1),0) erec
                from cc 
                where 
                    cc.no = $no and cc.estab = 0 and cc.datalc < '$datai' and cmdesc!='N/Recibo'
            )x
	";
        return $this->db->query($sql)->result_array();
    }

    public function get_cc($params) {
        $no = $this->get_num_cliente($params["stamp"]);
        $datai = $params["datai"];
        $dataf = $params["dataf"];

        $sql = "
            select cc.obs,cc.ccstamp,cc.datalc as datalc,cc.dataven,cc.edeb,cc.ecred,cc.cmdesc,cc.nrdoc as nrdoc,cc.ultdoc,cc.ftstamp,cc.restamp
            FROM cc 
            LEFT JOIN RE ON cc.restamp = re.restamp 	
            WHERE cc.no=$no
                and date(cc.datalc)>='$datai' 
                and date(cc.datalc)<='$dataf' 
            ORDER BY datalc,cm,
            nrdoc
        ";
        return $this->db->query($sql)->result_array();
    }

}
