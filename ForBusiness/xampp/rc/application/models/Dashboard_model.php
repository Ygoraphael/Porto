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
