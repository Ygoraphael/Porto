<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Dashboard_model class.
 * 
 * @extends CI_Model
 */
class Dashboard_model extends CI_Model {

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
    
    public function get_inters($activo) {
        $sql = "
            select *
            from tmp_mov
            where activo = " . $activo . "
            order by activo desc, username, data_i, cliente
        ";
        $inter = $this->db->query($sql)->result_array();

        if (count($inter)) {
            for ($i = 0; $i < count($inter); $i++) {
                $query = "	
                    select 
                        isnull((select top 1 cl.nome from cl (nolock) where no = " . $inter[$i]["cliente"] . "), '') nome, 
                        isnull((select top 1 campo from dytable (nolock) where entityname = 'a_mhtipo' and dytablestamp = '" . $inter[$i]["tarefa"] . "'), '') tarefa,
                        isnull((select top 1 nmfref from fref (nolock) where fref = '" . $inter[$i]["id_projecto"] . "'), '') projeto,
                        isnull((select top 1 sum(esaldo) esaldo from cl (nolock) where no = " . $inter[$i]["cliente"] . "), 0) esaldo,
                        isnull((select sum((edeb-edebf)-(ecred-ecredf)) as vencido from cl (nolock) JOIN cc (nolock) ON cl.no=cc.no where cl.no= " . $inter[$i]["cliente"] . " AND GETDATE() between cc.dataven and dateadd(day, cl.alimite, cc.datalc)), 0) vencido,
                        isnull((select sum((edeb-edebf)-(ecred-ecredf)) as super_vencido from cl (nolock) JOIN cc (nolock) ON cl.no=cc.no where cl.no= " . $inter[$i]["cliente"] . " AND dateadd(day, cl.alimite, cc.datalc) < GETDATE()), 0) super_vencido,
                        isnull((select top 1 u_horasres FROM csup (nolock) WHERE no = " . $inter[$i]["cliente"] . "), 0) hrestantes_csup,
                        isnull((select top 1 1 FROM csup (nolock) WHERE no = " . $inter[$i]["cliente"] . " and datap >= GETDATE()), 0) contrato
                ";

                $tmp = $this->mssql->mssql__select($query);
                
                if(count($tmp)) {
                    $inter[$i]["nome_cliente"] = $tmp[0]["nome"];
                    $inter[$i]["nome_tarefa"] = $tmp[0]["tarefa"];
                    $inter[$i]["nome_projeto"] = $tmp[0]["projeto"];
                    $inter[$i]["vencido"] = $tmp[0]["vencido"];
                    $inter[$i]["super_vencido"] = $tmp[0]["super_vencido"];
                    $inter[$i]["hrestantes_csup"] = $tmp[0]["hrestantes_csup"];
                    $inter[$i]["contrato"] = $tmp[0]["contrato"];
                }
                else {
                    $inter[$i]["nome_cliente"] = "";
                    $inter[$i]["nome_tarefa"] = "";
                    $inter[$i]["nome_projeto"] = "";
                    $inter[$i]["vencido"] = 0;
                    $inter[$i]["super_vencido"] = 0;
                    $inter[$i]["hrestantes_csup"] = 0;
                    $inter[$i]["contrato"] = 0;
                }
            }
            return $inter;
        } else {
            return array();
        }
    }
    
    public function get_best_employee( $year, $month ) {
        $values = array();
        
        $query = "exec GetDashData @year = " . $year . ", @month = " . $month;
        
        $summary = $this->mssql->mssql__select($query);
        
        if (count($summary)) {
            return $summary;
        }
        else {
            return array();
        }
    }
    
    public function get_tecs_summary() {
        $query = "
            select cm4.cm, MAX(cm4.nome) nome, SUM(ISNULL(mh.u_moh,0)) hora
            from cm4 (nolock)
            left join mh (nolock) on cm4.cm = mh.tecnico and CONVERT(VARCHAR(10), mh.data, 120) = CONVERT(VARCHAR(10), getdate(), 120)
            where
                    cm4.inactivo = 0 and cm4.cm <> 2
            group by cm4.cm
            order by nome
        ";
        
        $tec_summary = $this->mssql->mssql__select($query);
        
        if (count($tec_summary)) {
            return $tec_summary;
        }
        else {
            return array();
        }
    }
    
    public function get_today_inter() {
        $query = "
            select data, nome, tecnico, tecnnm, relatorio, hora, horaf, no, fref, mhtipo, datapat, horapat, moh, deh, facturar, okft, u_cat, u_movid, u_moh
            from mh
            where
                    CONVERT(VARCHAR(10), data, 120) = CONVERT(VARCHAR(10), getdate(), 120)
            order by data desc
        ";
        
        $tec_summary = $this->mssql->mssql__select($query);
        
        if (count($tec_summary)) {
            return $tec_summary;
        }
        else {
            return array();
        }
    }

    public function get_ranking_clientes_divida() {
        $sql = "
            select
                cc.moeda, 
                cc.nome, cc.no, 
                sum(cc.edeb) as edeb, sum(cc.ecred) as ecred,
                sum(cc.edebf) as edebf, sum(cc.ecredf) as ecredf,
                sum((cc.edeb-cc.edebf-(cc.ecred-cc.ecredf))) esaldo
            from cc 
            where (cc.edeb-cc.edebf-(cc.ecred-cc.ecredf))<>0 
            group by cc.nome,cc.moeda,cc.no
            order by esaldo desc
            limit 50
        ";
        return $this->db->query($sql)->result_array();
    }

    public function get_ranking_clientes_divida_salesman($params) {
        $sql = "
            select
                cc.moeda, 
                cc.nome, 
                cc.no, 
                cl.clstamp,
                sum(cc.edeb) as edeb, sum(cc.ecred) as ecred,
                sum(cc.edebf) as edebf, sum(cc.ecredf) as ecredf,
                sum((cc.edeb-cc.edebf-(cc.ecred-cc.ecredf))) esaldo
            from cc
            inner join cl on cl.no = cc.no and cl.estab = cc.estab
            where 
                (cc.edeb-cc.edebf-(cc.ecred-cc.ecredf))<>0 AND
                cl.vendedor = $params[vendedor]
            group by cc.nome,cc.moeda,cc.no
            order by esaldo desc
            limit 50
        ";
        return $this->db->query($sql)->result_array();
    }

    public function get_best_seller_st($params) {
        $sql = "
            select SUM(qtt) qtt, ref
            from pn
            where ref <> '' 
        ";

        $sql .= " AND fdata BETWEEN '$params[year]0101' AND '$params[year]1231'";

        $sql .= "
            group by ref
            order by qtt desc
            limit 1
        ";
        return $this->db->query($sql)->result_array();
    }

    public function get_best_seller_stfami($params) {
        $sql = "
            select SUM(pn.qtt) qtt, stfami.ref
            from pn
            inner join st on pn.ref = st.ref
            inner join stfami on st.familia = stfami.ref
            where pn.ref <> '' 
        ";

        $sql .= " AND pn.fdata BETWEEN '$params[year]0101' AND '$params[year]1231'";

        $sql .= "
            group by stfami.ref
            order by pn.qtt desc
            limit 1
        ";
        return $this->db->query($sql)->result_array();
    }

    public function get_month_sales($params) {
        $sql = "
            SELECT
                month(ft.fdata) AS mes, 
                sum(ft.eivain1 + ft.eivain2 + ft.eivain3 + ft.eivain4 + ft.eivain5 + ft.eivain6 + ft.eivain7 + ft.eivain8 + ft.eivain9) AS valor
            FROM ft
            INNER JOIN td ON ft.ndoc = td.ndoc AND td.regrd = 0
            WHERE
                ft.anulado = 0 AND 
                ft.fno >= 0 AND 
                ft.tipodoc not in (4, 5) AND 
                year(ft.fdata) = $params[year] AND month(ft.fdata) = $params[month]
            GROUP BY
                month(ft.fdata)
            ORDER BY
                month(ft.fdata)
        ";
        return $this->db->query($sql)->result_array();
    }

    public function get_month_purchases($params) {
        $sql = "
            select
                month(fo.data) as mes,
                sum(case when cm1.debito=0 then fo.eivain else -fo.eivain end) AS valor 
            from fo
            inner join fo2 on fo2.fo2stamp = fo.fostamp and fo2.anulado=0 
            inner join cm1 on cm1.cm = fo.doccode
            where 
                year(fo.data)= $params[year] AND
                month(fo.data)= $params[month]
            group by 
                month(fo.data)
            order by 
                month(fo.data)
        ";
        return $this->db->query($sql)->result_array();
    }

    public function get_year_sales_salesman($params) {
        $sql = "
            SELECT
                month(ft.fdata) AS mes, 
                sum(ft.eivain1 + ft.eivain2 + ft.eivain3 + ft.eivain4 + ft.eivain5 + ft.eivain6 + ft.eivain7 + ft.eivain8 + ft.eivain9) AS valor
            FROM ft
            INNER JOIN td ON ft.ndoc = td.ndoc AND td.regrd = 0
            WHERE
                ft.anulado = 0 AND 
                ft.fno >= 0 AND 
                ft.tipodoc not in (4, 5) AND 
                ft.vendedor = $params[salesman] AND
                year(ft.fdata) = $params[year]
            GROUP BY
                month(ft.fdata)
            ORDER BY
                month(ft.fdata)
        ";
        return $this->db->query($sql)->result_array();
    }

    public function get_average_year_sales_salesman($params) {
        $sql = "
            SELECT
                avg(ft.eivain1 + ft.eivain2 + ft.eivain3 + ft.eivain4 + ft.eivain5 + ft.eivain6 + ft.eivain7 + ft.eivain8 + ft.eivain9) AS media
            FROM ft
            INNER JOIN td ON ft.ndoc = td.ndoc AND td.regrd = 0
            WHERE
                ft.anulado = 0 AND 
                ft.fno >= 0 AND 
                ft.tipodoc not in (4, 5) AND 
                ft.vendedor = $params[vendedor] AND
                year(ft.fdata) = $params[ano]
        ";
        return $this->db->query($sql)->result_array();
    }

    public function get_max_year_sales_salesman($params) {
        $sql = "
            SELECT
                MAX(ft.eivain1 + ft.eivain2 + ft.eivain3 + ft.eivain4 + ft.eivain5 + ft.eivain6 + ft.eivain7 + ft.eivain8 + ft.eivain9) AS max
            FROM ft
            INNER JOIN td ON ft.ndoc = td.ndoc AND td.regrd = 0
            WHERE
                ft.anulado = 0 AND 
                ft.fno >= 0 AND 
                ft.tipodoc not in (4, 5) AND 
                ft.vendedor = $params[vendedor] AND
                year(ft.fdata) = $params[ano]
        ";
        return $this->db->query($sql)->result_array();
    }

    public function get_count_year_sales_salesman($params) {
        $sql = "
            SELECT 
                count(ft.ftstamp) AS nr
            FROM ft
            INNER JOIN td ON ft.ndoc = td.ndoc AND td.regrd = 0
            WHERE
                ft.anulado = 0 AND 
                ft.fno >= 0 AND 
                ft.tipodoc not in (4, 5) AND 
                ft.vendedor = $params[vendedor] AND
                year(ft.fdata) = $params[ano]
         
        ";
        return $this->db->query($sql)->result_array();
    }

    public function get_year_sales($params) {
        $sql = "
            SELECT
                month(ft.fdata) AS mes, 
                sum(ft.eivain1 + ft.eivain2 + ft.eivain3 + ft.eivain4 + ft.eivain5 + ft.eivain6 + ft.eivain7 + ft.eivain8 + ft.eivain9) AS valor
            FROM ft
            INNER JOIN td ON ft.ndoc = td.ndoc AND td.regrd = 0
            WHERE
                ft.anulado = 0 AND 
                ft.fno >= 0 AND 
                ft.tipodoc not in (4, 5) AND 
                year(ft.fdata) = $params[year]
            GROUP BY
                month(ft.fdata)
            ORDER BY
                month(ft.fdata)
        ";
        return $this->db->query($sql)->result_array();
    }

    public function get_top_area_year_sales($params) {
        $sql = "
            SELECT
                ft.zona,
                sum(ft.eivain1 + ft.eivain2 + ft.eivain3 + ft.eivain4 + ft.eivain5 + ft.eivain6 + ft.eivain7 + ft.eivain8 + ft.eivain9) AS valor
            FROM ft
            INNER JOIN td ON ft.ndoc = td.ndoc AND td.regrd = 0
            WHERE
                ft.anulado = 0 AND 
                ft.fno >= 0 AND 
                ft.tipodoc not in (4, 5) AND 
                year(ft.fdata) = $params[year]
            GROUP BY
                zona
            ORDER BY
                valor DESC
            LIMIT 5
        ";
        return $this->db->query($sql)->result_array();
    }

    public function get_top_area_salesman_year_sales($params) {
        $sql = "
            SELECT
                ft.zona,
                sum(ft.eivain1 + ft.eivain2 + ft.eivain3 + ft.eivain4 + ft.eivain5 + ft.eivain6 + ft.eivain7 + ft.eivain8 + ft.eivain9) AS valor
            FROM ft
            INNER JOIN td ON ft.ndoc = td.ndoc AND td.regrd = 0
            WHERE
                ft.anulado = 0 AND 
                ft.fno >= 0 AND 
                ft.tipodoc not in (4, 5) AND 
                ft.vendedor = $params[vendedor] AND
                year(ft.fdata) = $params[year]
            GROUP BY
                zona
            ORDER BY
                valor DESC
            LIMIT 5
        ";
        return $this->db->query($sql)->result_array();
    }

}
