<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model class.
 * 
 * @extends CI_Model
 */
class Sync_model extends CI_Model {

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

    public function processa_dados($dados) {
        $dados = json_decode($dados);
        $resultados = array();

        if (sizeof($dados) > 0) {
            foreach ($dados as $linha) {

                if ($linha->type == "INSERT") {
                    $data = array();

                    foreach ($linha->datarow as $coluna) {
                        $data[$coluna[1]] = $coluna[0];
                    }

                    $tmp = array();

                    if ($this->db->insert($linha->table, $data)) {
                        $tmp["u_ncsyncstamp"] = $linha->u_ncsyncstamp;
                        $tmp["success"] = 1;
                        $resultados[] = $tmp;
                    } else {
                        $tmp["u_ncsyncstamp"] = $linha->u_ncsyncstamp;
                        $tmp["success"] = 0;
                        $resultados[] = $tmp;
                    }
                } else if ($linha->type == "UPDATE") {
                    $data = array();

                    foreach ($linha->datarow as $coluna) {
                        if ($coluna[1] != $linha->table . "stamp") {
                            $data[$coluna[1]] = $coluna[0];
                        }
                    }

                    $tmp = array();

                    $this->db->where($linha->table . "stamp", $linha->stamp);
                    if ($this->db->update($linha->table, $data)) {
                        $tmp["u_ncsyncstamp"] = $linha->u_ncsyncstamp;
                        $tmp["success"] = 1;
                        $resultados[] = $tmp;
                    } else {
                        $tmp["u_ncsyncstamp"] = $linha->u_ncsyncstamp;
                        $tmp["success"] = 0;
                        $resultados[] = $tmp;
                    }
                } else if ($linha->type == "DELETE") {
                    $tmp = array();

                    $this->db->where($linha->table . "stamp", $linha->stamp);
                    if ($this->db->delete($linha->table)) {
                        $tmp["u_ncsyncstamp"] = $linha->u_ncsyncstamp;
                        $tmp["success"] = 1;
                        $resultados[] = $tmp;
                    } else {
                        $tmp["u_ncsyncstamp"] = $linha->u_ncsyncstamp;
                        $tmp["success"] = 0;
                        $resultados[] = $tmp;
                    }
                } else if ($linha->type == "MAKEITSUCCESS") {
                    $tmp = array();

                    $tmp["u_ncsyncstamp"] = $linha->u_ncsyncstamp;
                    $tmp["success"] = 1;
                    $resultados[] = $tmp;
                } else {
                    //unknown
                }
            }
        }

        echo json_encode($resultados);
    }

}
