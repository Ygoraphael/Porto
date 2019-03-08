<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * St_model class.
 * 
 * @extends CI_Model
 */
class St_model extends CI_Model {

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

    public function getSt($params) {
        $update_values = array();
        $where_array = array();

        $query = "	
            select *
            from st
        ";

        if (isset($params["ststamp"])) {
            $where_array[] = " st.ststamp = '" . $params["ststamp"] . "' ";
        }

        if (isset($params["ref"])) {
            $where_array[] = " st.ref = '" . $params["ref"] . "' ";
        }

        if (sizeof($where_array)) {
            $where = implode("AND", $where_array);

            if (substr($where, -3) == "AND")
                $where = substr($where, 0, strlen($where) - 3);

            $query .= "where " . $where;
        }

        $query .= "
            order by st.ref
        ";

        $sql_status = $this->mssql->mssql__select($query);

        return $sql_status;
    }

    public function get_st_by_ref_barcode($params) {
        $update_values = array();
        $where_array = array();

        if (isset($params["search"]) && strlen(trim($params["search"]))) {
            $query = "	
                select *
                from st
                where ststamp in 
                (
                        select top 1 *
                        from 
                        (
                                select ststamp
                                from st
                                where (ref = '{$params["search"]}' OR codigo = '{$params["search"]}')
                                union all
                                select ststamp
                                from bc
                                where codigo = '{$params["search"]}'
                        ) x
                )
            ";

            $sql_status = $this->mssql->mssql__select($query);
            return $sql_status;
        } else {
            return array();
        }
    }

    public function get_artigo($params) {
        $update_values = array();
        $where_array = array();
        if (strlen(trim($params["ref"]))) {
            $query = "
                select 
                    *
                from	
                    st
                where 
                    ref = rtrim(ltrim('{$params["ref"]}'))
            ";
            $sql_status = $this->mssql->mssql__select($query);
            return $sql_status;
        } else {
            return array();
        }
    }

    public function save_update_linha_encomenda($params) {

        if (isset($params["qtt"]) && isset($params["qtt_satisf"]) && isset($params["bistamp"]) && isset($params["bostamp"])) {
            $query = "
                update bi 
                set 
                    u_nciqttc = '{$params["qtt_satisf"]}',
                    qtt = '{$params["qtt"]}'
                where 
                    bistamp = rtrim(ltrim('{$params["bistamp"]}')) and
                    bostamp = rtrim(ltrim('{$params["bostamp"]}'))
            ";
            $sql_status = $this->mssql->mssql__execute($query);
            return $sql_status;
        } else {
            return array();
        }
    }
    
    public function fechar_encomenda($params) {
        if (isset($params["bostamp"])) {
            $query = "
                update bo
                set 
                    fechada = 1
                where 
                    bostamp = rtrim(ltrim('{$params["bostamp"]}'))
            ";
            $sql_status = $this->mssql->mssql__execute($query);
            return $sql_status;
        } else {
            return array();
        }
    }
    
    public function abrir_encomenda($params) {
        if (isset($params["bostamp"])) {
            $query = "
                update bo
                set 
                    fechada = 0
                where 
                    bostamp = rtrim(ltrim('{$params["bostamp"]}'))
            ";
            $sql_status = $this->mssql->mssql__execute($query);
            return $sql_status;
        } else {
            return array();
        }
    }
    
    public function status_fechar_encomenda($params) {
        if (isset($params["bostamp"])) {
            $query = "
                update bo
                set 
                    tabela1 = 'CONCLUÍDO'
                where 
                    bostamp = rtrim(ltrim('{$params["bostamp"]}'))
            ";
            $sql_status = $this->mssql->mssql__execute($query);
            return $sql_status;
        } else {
            return array();
        }
    }
    
    public function status_abrir_encomenda($params) {
        if (isset($params["bostamp"])) {
            $query = "
                update bo
                set 
                    tabela1 = 'EM ABERTO'
                where 
                    bostamp = rtrim(ltrim('{$params["bostamp"]}'))
            ";
            $sql_status = $this->mssql->mssql__execute($query);
            return $sql_status;
        } else {
            return array();
        }
    }

    public function save_new_linha_encomenda($params) {
        $update_values = array();
        $where_array = array();

        $bistamp = $this->utils_model->stamp();
        
        if (strlen(trim($params["ref"]))) {
            $query = "
                select 
                    *
                from 
                    st
                where 
                    ref = '{$params["ref"]}'
            ";

            $sql_st = $this->mssql->mssql__select($query);

            if ($sql_st) {
                foreach ($sql_st as $st) {

                    $query = "
                        select 
                            top(1) *
                        from 
                            bi
                        where 
                            bostamp = '{$params["bostamp"]}'
                    ";
                    $sql_bi = $this->mssql->mssql__select($query);

                    if ($sql_bi) {
                        foreach ($sql_bi as $bi) {
                            $nmdos = $bi['nmdos'];
                            $obrano = $bi['obrano'];
                            $stipo = $bi['stipo'];
                            $no = $bi['no'];
                            $ndos = $bi['ndos'];
                            $zona = $bi['zona'];
                            $local = $bi['local'];
                            $morada = $bi['morada'];
                            $codpost = $bi['codpost'];
                            $nome = $bi['nome'];
                        }

                        $query = "
                            insert into bi 
                            (
                                bistamp,
                                nmdos,
                                obrano,
                                ref,
                                design,
                                qtt,
                                tabiva,
                                armazem, 
                                pu,
                                prorc,
                                stipo,
                                no,
                                ndos,
                                zona,
                                adjudicada,
                                lordem,
                                local,
                                morada,
                                codpost,
                                nome,
                                vendedor,
                                edebito,
                                eprorc,
                                epcusto,
                                usr1,
                                usr2,
                                usr3,
                                usr4,
                                usr5,
                                usr6,
                                familia,
                                ecustoind,
                                debitoori,
                                edebitoori,
                                bostamp,
                                ousrinis,
                                ousrdata, 
                                ousrhora, 
                                usrinis,
                                usrdata,
                                usrhora,
                                u_nciqttc
                            )	
                            values
                            (
                                '{$bistamp}',
                                '{$nmdos}',
                                '{$obrano}',
                                '{$params["ref"]}',
                                isnull((select top 1 design from st where ref = '{$params["ref"]}'), ''),
                                '{$params["qtt"]}',
                                '1',
                                '1',
                                isnull((select top 1 pv1 from st where ref = '{$params["ref"]}'), ''),
                                isnull((select top 1 pv1 from st where ref = '{$params["ref"]}'), ''),
                                '{$stipo}',
                                '{$no}',
                                '{$ndos}',
                                '{$zona}',
                                '1',
                                 isnull((select max(lordem) + 10000 from bi where bostamp = '{$params["bostamp"]}'), 10000),
                                '{$local}',
                                '{$morada}',
                                '{$codpost}',
                                '{$nome}',
                                '1',
                                isnull((select top 1 epv1 from st where ref = '{$params["ref"]}'), ''),
                                isnull((select top 1 epv1 from st where ref = '{$params["ref"]}'), ''),
                                isnull((select top 1 epcpond from st where ref = '{$params["ref"]}'), ''),
                                isnull((select top 1 usr1 from st where ref = '{$params["ref"]}'), ''),
                                isnull((select top 1 usr2 from st where ref = '{$params["ref"]}'), ''),
                                isnull((select top 1 usr3 from st where ref = '{$params["ref"]}'), ''),
                                isnull((select top 1 usr4 from st where ref = '{$params["ref"]}'), ''),
                                isnull((select top 1 usr5 from st where ref = '{$params["ref"]}'), ''),
                                isnull((select top 1 usr6 from st where ref = '{$params["ref"]}'), ''),
                                isnull((select top 1 familia from st where ref = '{$params["ref"]}'), ''),
                                isnull((select top 1 epcpond from st where ref = '{$params["ref"]}'), ''),
                                isnull((select top 1 pv1 from st where ref = '{$params["ref"]}'), ''),
                                isnull((select top 1 epv1 from st where ref = '{$params["ref"]}'), ''),
                                '{$params["bostamp"]}',
                                UPPER(suser_sname()),
                                CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
                                CONVERT(VARCHAR(5), GETDATE(), 8), 
                                UPPER(suser_sname()),
                                CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
                                CONVERT(VARCHAR(5), GETDATE(), 8),
                                '{$params["qtt_satisf"]}'
                            )			
                        ";

                        $sql_status = $this->mssql->mssql__execute($query);
                        return $bistamp;
                    } else {
                        return array();
                    }
                }
            } else {
                return array();
            }
        } else {
            return array();
        }
    }

}
