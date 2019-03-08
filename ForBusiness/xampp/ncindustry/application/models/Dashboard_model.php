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
        $this->load->model('Nci_model', 'nci');
    }

    public function getEncomendasNovas( $params = array() ) {
        $def = $this->nci->getU_ncidef();
        
        $query = "	
            select count(*) total
            from bo
            where
                ndos = " . $def[0]["ndospicking"] . " 
        ";
        
        if( count($params) ) {
            foreach($params as $param) {
                $query .= "AND " . $param . " ";
            }
        }

        $sql_status = $this->mssql->mssql__select($query);
        
        if (sizeof($sql_status)) {
            return $sql_status;
        }
        
        return false;
    }
    
    public function getEncomendasFechadas( $params = array() ) {
        $def = $this->nci->getU_ncidef();
        
        $query = "	
            select count(*) total
            from bo
            where
                ndos = " . $def[0]["ndospicking"] . " AND
                fechada = 1 
        ";
        
        if( count($params) ) {
            foreach($params as $param) {
                $query .= "AND " . $param . " ";
            }
        }

        $sql_status = $this->mssql->mssql__select($query);
        
        if (sizeof($sql_status)) {
            return $sql_status;
        }
        
        return false;
    }
    
    public function getEncomendasAbertas( $params = array() ) {
        $def = $this->nci->getU_ncidef();
        
        $query = "	
            select count(*) total
            from bo
            where
                ndos = " . $def[0]["ndospicking"] . " AND
                fechada = 0 
        ";
        
        if( count($params) ) {
            foreach($params as $param) {
                $query .= "AND " . $param . " ";
            }
        }

        $sql_status = $this->mssql->mssql__select($query);
        
        if (sizeof($sql_status)) {
            return $sql_status;
        }
        
        return false;
    }
    
    public function ChartEncomendasAbertasFechadasMes( $params = array() ) {
        $def = $this->nci->getU_ncidef();
        
        $query = "
            select isnull(total.aberto, 0) aberto, isnull(fechado.fechado, 0) fechado, limpo.mes
            from
            (
                select count(bostamp) aberto, MONTH(dataobra) mes
                from bo
                where 
                    ndos = " . $def[0]["ndospicking"] . " ";
        
        if( count($params) ) {
            foreach($params as $param) {
                $query .= "AND " . $param . " ";
            }
        }
        
        $query .= "
                group by MONTH(dataobra)
            ) total
            inner join 
            (
                select count(bostamp) fechado, MONTH(dataobra) mes
                from bo
                where 
                    ndos = " . $def[0]["ndospicking"] . " and 
                    fechada = 1 ";
        
        if( count($params) ) {
            foreach($params as $param) {
                $query .= "AND " . $param . " ";
            }
        }
        
        $query .= "
                group by MONTH(dataobra)
            ) fechado on total.mes = fechado.mes
            right join 
            (
                select 1 mes
                union all
                select 2
                union all
                select 3
                union all
                select 4
                union all
                select 5
                union all
                select 6
                union all
                select 7
                union all
                select 8
                union all
                select 9
                union all
                select 10
                union all
                select 11
                union all
                select 12
            ) limpo on total.mes = limpo.mes
        ";
        
        $sql_status = $this->mssql->mssql__select($query);
        
        if (sizeof($sql_status)) {
            return $sql_status;
        }
        
        return false;
    }
    
    public function StockArtigoEncomendado( $params = array() ) {
        $def = $this->nci->getU_ncidef();
        
        $query = "	
            select ref, MAX(design) design, SUM(qtt) qtt, SUM(stock) stock, abs(SUM(stock_final)) stock_final
            from
            (
                select bi.ref, st.design, bi.qtt, st.stock, stock - bi.qtt stock_final
                from bo
                inner join bi on bo.bostamp = bi.bostamp
                inner join st on bi.ref = st.ref
                where
                    bo.ndos = " . $def[0]["ndospicking"] . " and
                    bo.fechada = 0 and
                    bi.qtt > 0 and
                    stock - bi.qtt < 0 ";
        
            if( count($params) ) {
                foreach($params as $param) {
                    $query .= "AND " . $param . " ";
                }
            }
            
        $query .= "
            ) x
            group by
                ref
            order by
                stock_final desc
        ";

        $sql_status = $this->mssql->mssql__select($query);
        
        if (sizeof($sql_status)) {
            return $sql_status;
        }
        
        return false;
    }
}
