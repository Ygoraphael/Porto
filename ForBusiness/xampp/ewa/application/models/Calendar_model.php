<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Calendar_model class.
 * 
 * @extends CI_Model
 */
class Calendar_model extends CI_Model {

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

    public function rentalinit($bostamp, $day, $month, $year) {
        $sessions = $this->get_sessions($bostamp, $day, $month, $year);
        
        $this->db->select('*');
        $this->db->from('bo3');
        $this->db->where('bo3.bo3stamp', $bostamp);
        $bo3 = $this->db->get();
        $bo3 = $bo3->result_array();
        
        $hours = array();
        
        $result = array();
        $res_h = array();
        $res_m = array();
        
        if( sizeof($sessions) && sizeof($bo3) ) {
            $bo3 = $bo3[0];
            $ihour = $sessions[0]["ihour"];
            $fhour = strlen(trim($sessions[0]["fhour"])) ? $sessions[0]["fhour"] : "23:59";
            
            if( $bo3["u_rentint"] ) {
                $interval = intval($bo3['u_minnotic']);
                switch( trim($bo3['u_minnott']) ) {
                    case 'Hours':
                        $interval = 'PT' . $interval . 'H';
                        break;
                    case 'Minutes':
                        $interval = 'PT' . $interval . 'M';
                        break;
                    case 'Days':
                        $interval = 'P' . $interval . 'D';
                        break;
                    default:
                        $interval = 'P' . $interval . 'D';
                        break;
                }

                $fdate = new DateTime($fhour);
                $date = new DateTime($ihour . ':00');

                $hours[] = $date->format('H:i');
                $date = $date->add(new DateInterval($interval));

                while( $date < $fdate ) {
                    $hours[] = $date->format('H:i');
                    $date = $date->add(new DateInterval($interval));
                }

                foreach( $hours as $hour ) {
                    $tmp = explode(':', $hour);

                    if( !in_array($tmp[0], $res_h) ) {
                        $res_h[] = $tmp[0];
                    }

                    if( !in_array($tmp[1], $res_m) ) {
                        $res_m[] = $tmp[1];
                    }
                }

                $result[] = $res_h;
                $result[] = $res_m;
                return $result;
            }
            else {                
                $tmp = explode(':', $ihour);
                $res_h[] = $tmp[0];
                $res_m[] = $tmp[1];
                $result[] = $res_h;
                $result[] = $res_m;
                
                return $result;
            }
        }
        else {
            return array();
        }
    }

    public function voucher_validation($bostamp, $voucher_code) {
        $this->db->select('*');
        $this->db->from('u_vouch');
        $this->db->where('u_vouch.code', $voucher_code);
        $voucher = $this->db->get();
        $voucher = $voucher->result_array();

        $this->db->select('*');
        $this->db->from('u_pvouch');
        $this->db->join('u_vouch', 'u_pvouch.u_vouchstamp = u_vouch.u_vouchstamp');
        $this->db->join('bo', 'u_pvouch.bostamp = bo.bostamp');
        $this->db->where('u_vouch.code', $voucher_code);
        $this->db->where('bo.bostamp', $bostamp);
        $voucher_produto = $this->db->get();
        $voucher_produto = $voucher_produto->result_array();

        $result = array();

        if (sizeof($voucher) > 0) {
            $voucher = $voucher[0];

            //este voucher existe
            if (sizeof($voucher_produto) > 0) {
                //este produto tem este voucher atribuido
                $now = strtotime('today');
                if ($now > strtotime($voucher["validity"])) {
                    //ja passou prazo de validade
                    $result["success"] = 0;
                    $result["message"] = "This voucher has expired";
                    $result["value"] = 0;
                    $result["formula"] = '';
                } else {
                    $this->db->select('*');
                    $this->db->from('bo');
                    $this->db->join('bo2', 'bo.bostamp = bo2.bo2stamp');
                    $this->db->join('bo3', 'bo.bostamp = bo3.bo3stamp');
                    $this->db->where('bo.ndos', 4);
                    $this->db->where('bo2.ngstatus', 'PROCESSED');
                    $this->db->where('bo3.u_vouch', $voucher_code);
                    $voucher_usage = $this->db->get();
                    $voucher_usage = $voucher_usage->result_array();
                    $voucher_usage = sizeof($voucher_usage);

                    if ($voucher_usage >= $voucher["useqtt"] && $voucher["useqtt"] != 0) {
                        //ja passou o numero de vezes em que pode ser usado
                        $result["success"] = 0;
                        $result["message"] = "This voucher can't be used anymore";
                        $result["value"] = 0;
                        $result["formula"] = '';
                        $result["code"] = '';
                    } else {
                        $result["success"] = 1;
                        $result["message"] = "Voucher applied successfully";
                        $result["value"] = $voucher["value"];
                        $result["formula"] = $voucher["type"];
                        $result["code"] = $voucher["code"];
                    }
                }
            } else {
                //este voucher não pode ser usado neste produto
                $result["success"] = 0;
                $result["message"] = "This voucher can't be used in this product";
                $result["value"] = 0;
                $result["formula"] = '';
                $result["code"] = '';
            }
        } else {
            //este voucher não existe
            $result["success"] = 0;
            $result["message"] = "This voucher don't exist";
            $result["value"] = 0;
            $result["formula"] = '';
            $result["code"] = '';
        }

        return $result;
    }

    public function get_calendar($datai, $dataf, $op, $bostamp, $u_psessstamp) {
        $query = "
			select
			      SUM(bi.qtt) ocup,
				  MAX(u_psess.lotation) lotation,
				--produto.obrano,
				--bo3.u_psessstp,
				convert(varchar(10), bo3.u_sessdate, 120) datasessao,
				MAX(u_psess.ihour) horasessao,
				MAX(produto.u_name) produto,
				MAX(case when pbo.u_color = '' then '#fff' else pbo.u_color end) cor
			from bo encomenda (nolock)
				inner join bo3 (nolock) on encomenda.bostamp = bo3.bo3stamp
				inner join u_psess (nolock) on bo3.u_psessstp = u_psess.u_psessstamp
				inner join bo produto (nolock) on encomenda.origem = produto.bostamp
				inner join bo3 pbo (nolock) on produto.bostamp = pbo.bo3stamp
				inner join bi on encomenda.bostamp = bi.bostamp
			where 
				encomenda.ndos = 4 and
				produto.no = " . $op . " and
				bo3.u_sessdate >= '" . date('Y-m-d', $datai) . "' and
				bo3.u_sessdate <= '" . date('Y-m-d', $dataf) . "' and
				LEFT(bi.ref,2) ='P.'				
		";
        if (trim($bostamp) != '') {
            $query .= "
				and produto.bostamp = '" . $bostamp . "' 
			";
        }
        if (trim($u_psessstamp) != '') {
            $query .= "
				and u_psess.u_psessstamp = '" . $u_psessstamp . "' 
			";
        }
        $query .= "
			group by
				convert(varchar(10), bo3.u_sessdate, 120),
				produto.obrano,
				bo3.u_psessstp,
				bi.ref
		";

        $result = $this->mssql->mssql__select($query);
        // log_message("ERROR", print_r($query, true));
        $out = array();
        $id = 1;
        foreach ($result as $row) {
            $out[] = array(
                'id' => $id,
                'title' => $row['produto'],
                'session' => $row['horasessao'],
                'url' => '',
                'color' => $row['cor'],
                'percent' => $e = number_format($row['ocup'], 0, '.', '') . ' of ' . $f = number_format($row['lotation'], 0, '.', ''),
                'start' => strtotime($row['datasessao'] . ' ' . str_replace("00:00", "00:01", $row['horasessao'])) . '000',
                'end' => strtotime($row['datasessao'] . ' ' . str_replace("00:00", "00:01", $row['horasessao'])) . '000'
            );
            $id++;
        }

        return $out;
    }

    public function get_seatprices($bostamp, $day, $month, $year, $session, $seat, $type) {
        $this->db->select('
		bo.obrano,
		bo3.u_quicksel
		');
        $this->db->from('bo');
        $this->db->join('bo3', 'bostamp = bo3stamp');
        $this->db->where('bo.bostamp', $bostamp);
        $query = $this->db->get();
        $product = $query->result_array();

        if (sizeof($product) > 0) {
            foreach ($product as $prod) {

                if (trim($prod["u_quicksel"]) == 0) {

                    $prices = $this->db->query("
					SELECT sx.epv1
					FROM sx
						JOIN st ON sx.ref = st.ref
						JOIN stobs ON st.ref = stobs.ref
						JOIN bo ON bo.bostamp = stobs.u_bostamp
						JOIN u_psess ON bo.bostamp = u_psess.bostamp
					WHERE bo.bostamp = '" . $bostamp . "'
					AND sx.cor = '" . $seat . "'
					AND sx.tam = '" . $type . "'
					AND u_psess.id = '" . $session . "'
					AND sx.ref = case when u_psess.price = 0 then CONCAT('P.', trim(bo.obrano),'.0') else CONCAT('P.', trim(bo.obrano),'." . $session . "') end");

                    return $prices->result_array();
                } else {

                    $prices = $this->db->query("
					SELECT sx.epv1
					FROM sx
						JOIN st ON sx.ref = st.ref
						JOIN stobs ON st.ref = stobs.ref
						JOIN bo ON bo.bostamp = stobs.u_bostamp
					WHERE bo.bostamp = '" . $bostamp . "'
					AND sx.cor = '" . $seat . "'
					AND sx.tam = '" . $type . "'
					AND sx.ref = CONCAT('P.', trim(bo.obrano),'.0')");

                    return $prices->result_array();
                }
            }
        }
    }

    public function get_seattickets($bostamp, $day, $month, $year, $session, $seat) {

        $seat = explode("_", $seat);
        $seat = trim($seat[1]);

        $this->db->select('
		u_ptick.*
		');
        $this->db->from('bo');
        $this->db->join('bo2', 'bo.bostamp = bo2.bo2stamp');
        $this->db->join('bo3', 'bo.bostamp = bo3.bo3stamp');
        $this->db->join('u_ptick', 'bo.bostamp = u_ptick.bostamp');
        $this->db->where('bo.bostamp', $bostamp);
        $this->db->where('bo.ndos = 1');
        $this->db->order_by('ticket', 'ASC');
        $tickets = $this->db->get();

        $exclusions = $this->db->query("SELECT DISTINCT tam
		FROM bi
		JOIN u_psess ON bi.bostamp = u_psess.bostamp
		WHERE bi.bostamp = '" . $bostamp . "'
		AND bi.cor = '" . $seat . "'
		AND u_psess.id = '" . $session . "'
		AND bi.ref = case when u_psess.price = 0 then CONCAT('P.', trim(bi.obrano),'.0') else CONCAT('P.', trim(bi.obrano),'." . $session . "') end");

        $tmp_tickets = array();

        if (sizeof($tickets->result_array()) > 0) {
            foreach ($tickets->result_array() as $ticket) {
                $found = 0;
                foreach ($exclusions->result_array() as $exclusion) {
                    if (trim($ticket["ticket"]) == trim($exclusion["tam"])) {
                        $found = 1;
                    }
                }
                if (!$found) {
                    $tmp = array();
                    $tmp["ticket"] = trim($ticket["ticket"]);
                    $tmp["name"] = trim($ticket["name"]);
                    $tmp_tickets[] = $tmp;
                }
            }
            return $tmp_tickets;
        } else {
            return $tickets->result_array();
        }
    }

    public function get_unavailableseats($bostamp, $day, $month, $year, $session) {
        $data_formatada = date("Y-m-d", strtotime("$year-$month-$day"));

        $this->db->select('
		bi.cor,
		bi.tam,
		bi.qtt
		');
        $this->db->from('bi');
        $this->db->join('st', 'bi.ref = st.ref');
        $this->db->join('stobs', 'st.ref = stobs.ref');
        $this->db->join('bo', 'bo.bostamp = stobs.u_bostamp');
        $this->db->join('u_psess', 'bo.bostamp = u_psess.bostamp');
        $this->db->join('bo A', 'A.bostamp = bi.bostamp');
        $this->db->join('bo3', 'A.bostamp = bo3.bo3stamp');
        $this->db->where('bo.bostamp', $bostamp);
        $this->db->where('u_psess.id', $session);
        $this->db->where('bo3.u_sessdate', $data_formatada);
        $this->db->where('bo3.u_psessstp = u_psess.u_psessstamp');
        $query = $this->db->get();
        $query = $query->result_array();

        return $query;
    }

    public function get_prices($bostamp, $day, $month, $year, $session) {

        $this->db->select('
		bo.obrano,
		bo3.u_quicksel
		');
        $this->db->from('bo');
        $this->db->join('bo3', 'bostamp = bo3stamp');
        $this->db->where('bo.bostamp', $bostamp);
        $query = $this->db->get();
        $product = $query->result_array();

        if (sizeof($product) > 0) {
            foreach ($product as $prod) {

                if (trim($prod["u_quicksel"]) == 0) {
                    $this->db->select('
					bo.obrano,
					u_psess.price
					');
                    $this->db->from('bo');
                    $this->db->join('u_psess', 'bo.bostamp = u_psess.bostamp');
                    $this->db->where('bo.bostamp', $bostamp);
                    $this->db->where('u_psess.id', $session);
                    $query = $this->db->get();
                    $query = $query->result_array();
                    $preco_id = "";

                    if (sizeof($query) > 0) {
                        foreach ($query as $sessao) {
                            if ($sessao["price"] == 0) {
                                $preco_id = "P." . trim($sessao["obrano"]) . ".0";
                            } else {
                                $preco_id = "P." . trim($sessao["obrano"]) . "." . trim($session);
                            }
                        }
                    }

                    $this->db->select('
					sx.ref,
					sx.cor,
					sx.tam,
					sx.epv1
					');
                    $this->db->from('sx');
                    $this->db->where('sx.ref', $preco_id);
                    $query = $this->db->get();
                    $query = $query->result_array();

                    return $query;
                } else {
                    $preco_id = "P." . trim($prod["obrano"]) . ".0";

                    $this->db->select('
					sx.ref,
					sx.cor,
					sx.tam,
					sx.epv1
					');
                    $this->db->from('sx');
                    $this->db->where('sx.ref', $preco_id);
                    $query = $this->db->get();
                    $query = $query->result_array();

                    return $query;
                }
            }
        }
    }

    public function rutime($ru, $rus, $index) {
        return ($ru["ru_$index.tv_sec"] * 1000 + intval($ru["ru_$index.tv_usec"] / 1000)) - ($rus["ru_$index.tv_sec"] * 1000 + intval($rus["ru_$index.tv_usec"] / 1000));
    }

    public function array_values_recursive($ary) {
        $lst = array();
        foreach (array_keys($ary) as $k) {
            $v = $ary[$k];
            if (is_scalar($v)) {
                $lst[] = $v;
            } elseif (is_array($v)) {
                $lst = array_merge($lst, $this->array_values_recursive($v)
                );
            }
        }
        return $lst;
    }

    public function mysql_date_add($now = null, $adjustment) {
        $adjustment = strtolower($adjustment);
        $adjustment = str_replace('interval', '', $adjustment);
        $adjustment = '+' . trim($adjustment);
        if (is_null($now) || strtolower(trim($now)) == 'now()') {
            $now = time();
        } else {
            preg_match('/([0-9]{4})-([0-9]{2})-([0-9]{2}) ([0-9]{2}):([0-9]{2}):([0-9]{2})/', $now, $parts);
            $now = mktime($parts[4], $parts[5], $parts[6], $parts[2], $parts[3], $parts[1]);
        }
        $timestamp = (integer) strtotime($adjustment, $now);
        return date('Y-m-d H:i:s', $timestamp);
    }

    public function get_maxlotation($bostamp, $day, $month, $year, $session, $op) {

        $this->db->select('
		bo.obrano,
		bo3.u_quicksel
		');
        $this->db->from('bo');
        $this->db->join('bo3', 'bostamp = bo3stamp');
        $this->db->where('bo.bostamp', $bostamp);
        $query = $this->db->get();
        $product = $query->result_array();

        if (sizeof($product) > 0) {
            foreach ($product as $prod) {

                if ($prod["u_quicksel"] == 0) {

                    // $time_start = microtime(true);
                    //lotacao por espaco fisico
                    $this->db->select('lotation');
                    $this->db->from('u_psess');
                    $this->db->where('bostamp', $bostamp);
                    $this->db->where('u_psess.id', $session);

                    $query = $this->db->get();
                    $query = $query->result_array();

                    if (sizeof($query) > 0)
                        $lotation = $query[0]["lotation"];
                    else
                        $lotation = 0;

                    $this->db->select('
						SUM(bi.qtt) qtt
					');
                    $this->db->from('bo enc');
                    $this->db->join('bo prod', 'enc.origem = prod.bostamp');
                    $this->db->join('bo2 enc2', 'enc.bostamp = enc2.bo2stamp');
                    $this->db->join('bo3 enc3', 'enc.bostamp = enc3.bo3stamp');
                    $this->db->join('bi', 'enc.bostamp = bi.bostamp');
                    $this->db->join('u_psess', 'u_psess.u_psessstamp = enc3.u_psessstp');
                    $this->db->where('enc.ndos', 4);
                    $this->db->where('prod.bostamp', $bostamp);
                    $this->db->where('u_psess.id', $session);
                    $this->db->where('enc2.ngstatus', 'PROCESSED');
                    $this->db->where('enc3.u_sessdate', $year . '-' . sprintf('%02d', $month) . '-' . sprintf('%02d', $day));
                    $this->db->group_by('bi.nmdos');

                    $query = $this->db->get();
                    $query = $query->result_array();

                    if (sizeof($query) > 0)
                        $current_lotation = $query[0]["qtt"];
                    else
                        $current_lotation = 0;

                    //verificar se tem recursos
                    $this->db->select('ref');
                    $this->db->from('u_prec');
                    $this->db->where('u_prec.bostamp', $bostamp);
                    $query = $this->db->get();
                    $query = $query->result_array();

                    if (sizeof($query) > 0) {
                        // lotacao por recursos
                        $str_sql1 = "
							CREATE TEMPORARY TABLE tempprod
							select prod.*, u_psess.u_psessstamp, u_psess.ihour
							from 
							(
								select prod.*, bi.qtt recqtt 
								from 
								(
									select distinct bo.no op, bo.bostamp prodstamp, bo3.u_estimdur, bo3.u_estidurt, u_prec.ref precref, u_prec.varbilh precvarbilh, u_prec.qtt precqtt , u_psess.ihour curihour
									from 
										bo 
										inner join bo2 on bo.bostamp = bo2.bo2stamp 
										inner join bo3 on bo.bostamp = bo3.bo3stamp 
										inner join u_prec on bo.bostamp = u_prec.bostamp 
										join u_psess on u_psess.id = " . $session . " and u_psess.bostamp = '" . $bostamp . "' 
									where bo.ndos = 1 and bo.no = " . $op . " and fechada = 0 
								) prod inner join bi on bi.ref = prod.precref and bi.no = prod.op and bi.ndos = 3
							) prod inner join u_psess on prod.prodstamp = u_psess.bostamp;
						";

                        $str_sql2 = "
							select 
								prec_ref,
								case
									when MAX(rec_available) - SUM(rec_used) < 0 then 0
									else MAX(rec_available) - SUM(rec_used)
								end available
							from 
							(
								select 
								case 
									-- quando igual
									when STR_TO_DATE(CONCAT(SUBSTRING(encprod.u_sessdate FROM 1 FOR 10), ' ', encprod.ihour), '%Y-%m-%d %H:%i:%s') = STR_TO_DATE(CONCAT('" . $year . '-' . sprintf('%02d', $month) . '-' . sprintf('%02d', $day) . "', ' ', encprod.curihour), '%Y-%m-%d %H:%i:%s') and 
									case
										when encprod.u_estidurt = 'Hours' then date_add(STR_TO_DATE(CONCAT(SUBSTRING(encprod.u_sessdate FROM 1 FOR 10), ' ', encprod.ihour), '%Y-%m-%d %H:%i:%s'), INTERVAL encprod.u_estimdur HOUR)
										when encprod.u_estidurt = 'Minutes' then date_add(STR_TO_DATE(CONCAT(SUBSTRING(encprod.u_sessdate FROM 1 FOR 10), ' ', encprod.ihour), '%Y-%m-%d %H:%i:%s'), INTERVAL encprod.u_estimdur MINUTE)
										when encprod.u_estidurt = 'Days' then date_add(STR_TO_DATE(CONCAT(SUBSTRING(encprod.u_sessdate FROM 1 FOR 10), ' ', encprod.ihour), '%Y-%m-%d %H:%i:%s'), INTERVAL encprod.u_estimdur DAY)
										else STR_TO_DATE(CONCAT(SUBSTRING(encprod.u_sessdate FROM 1 FOR 10), ' ', encprod.ihour), '%Y-%m-%d %H:%i:%s')
									end = case
										when encprod.u_estidurt = 'Hours' then date_add(STR_TO_DATE(CONCAT('" . $year . '-' . sprintf('%02d', $month) . '-' . sprintf('%02d', $day) . "', ' ', encprod.curihour), '%Y-%m-%d %H:%i:%s'), INTERVAL encprod.u_estimdur HOUR)
										when encprod.u_estidurt = 'Minutes' then date_add(STR_TO_DATE(CONCAT('" . $year . '-' . sprintf('%02d', $month) . '-' . sprintf('%02d', $day) . "', ' ', encprod.curihour), '%Y-%m-%d %H:%i:%s'), INTERVAL encprod.u_estimdur MINUTE)
										when encprod.u_estidurt = 'Days' then date_add(STR_TO_DATE(CONCAT('" . $year . '-' . sprintf('%02d', $month) . '-' . sprintf('%02d', $day) . "', ' ', encprod.curihour), '%Y-%m-%d %H:%i:%s'), INTERVAL encprod.u_estimdur DAY)
										else STR_TO_DATE(CONCAT('" . $year . '-' . sprintf('%02d', $month) . '-' . sprintf('%02d', $day) . "', ' ', encprod.curihour), '%Y-%m-%d %H:%i:%s')
									end then 1
									-- quando inicia antes e termina depois da hora inicio
									when STR_TO_DATE(CONCAT(SUBSTRING(encprod.u_sessdate FROM 1 FOR 10), ' ', encprod.ihour), '%Y-%m-%d %H:%i:%s') < STR_TO_DATE(CONCAT('" . $year . '-' . sprintf('%02d', $month) . '-' . sprintf('%02d', $day) . "', ' ', encprod.curihour), '%Y-%m-%d %H:%i:%s') and 
									case
										when encprod.u_estidurt = 'Hours' then date_add(STR_TO_DATE(CONCAT(SUBSTRING(encprod.u_sessdate FROM 1 FOR 10), ' ', encprod.ihour), '%Y-%m-%d %H:%i:%s'), INTERVAL encprod.u_estimdur HOUR)
										when encprod.u_estidurt = 'Minutes' then date_add(STR_TO_DATE(CONCAT(SUBSTRING(encprod.u_sessdate FROM 1 FOR 10), ' ', encprod.ihour), '%Y-%m-%d %H:%i:%s'), INTERVAL encprod.u_estimdur MINUTE)
										when encprod.u_estidurt = 'Days' then date_add(STR_TO_DATE(CONCAT(SUBSTRING(encprod.u_sessdate FROM 1 FOR 10), ' ', encprod.ihour), '%Y-%m-%d %H:%i:%s'), INTERVAL encprod.u_estimdur DAY)
										else STR_TO_DATE(CONCAT(SUBSTRING(encprod.u_sessdate FROM 1 FOR 10), ' ', encprod.ihour), '%Y-%m-%d %H:%i:%s')
									end > STR_TO_DATE(CONCAT('" . $year . '-' . sprintf('%02d', $month) . '-' . sprintf('%02d', $day) . "', ' ', encprod.curihour), '%Y-%m-%d %H:%i:%s') then 1
									-- quando inicia antes do fim e termina depois do fim
									when 
									case
										when encprod.u_estidurt = 'Hours' then date_add(STR_TO_DATE(CONCAT(SUBSTRING(encprod.u_sessdate FROM 1 FOR 10), ' ', encprod.ihour), '%Y-%m-%d %H:%i:%s'), INTERVAL encprod.u_estimdur HOUR)
										when encprod.u_estidurt = 'Minutes' then date_add(STR_TO_DATE(CONCAT(SUBSTRING(encprod.u_sessdate FROM 1 FOR 10), ' ', encprod.ihour), '%Y-%m-%d %H:%i:%s'), INTERVAL encprod.u_estimdur MINUTE)
										when encprod.u_estidurt = 'Days' then date_add(STR_TO_DATE(CONCAT(SUBSTRING(encprod.u_sessdate FROM 1 FOR 10), ' ', encprod.ihour), '%Y-%m-%d %H:%i:%s'), INTERVAL encprod.u_estimdur DAY)
										else STR_TO_DATE(CONCAT(SUBSTRING(encprod.u_sessdate FROM 1 FOR 10), ' ', encprod.ihour), '%Y-%m-%d %H:%i:%s')
									end < case
										when encprod.u_estidurt = 'Hours' then date_add(STR_TO_DATE(CONCAT('" . $year . '-' . sprintf('%02d', $month) . '-' . sprintf('%02d', $day) . "', ' ', encprod.curihour), '%Y-%m-%d %H:%i:%s'), INTERVAL encprod.u_estimdur HOUR)
										when encprod.u_estidurt = 'Minutes' then date_add(STR_TO_DATE(CONCAT('" . $year . '-' . sprintf('%02d', $month) . '-' . sprintf('%02d', $day) . "', ' ', encprod.curihour), '%Y-%m-%d %H:%i:%s'), INTERVAL encprod.u_estimdur MINUTE)
										when encprod.u_estidurt = 'Days' then date_add(STR_TO_DATE(CONCAT('" . $year . '-' . sprintf('%02d', $month) . '-' . sprintf('%02d', $day) . "', ' ', encprod.curihour), '%Y-%m-%d %H:%i:%s'), INTERVAL encprod.u_estimdur DAY)
										else STR_TO_DATE(CONCAT('" . $year . '-' . sprintf('%02d', $month) . '-' . sprintf('%02d', $day) . "', ' ', encprod.curihour), '%Y-%m-%d %H:%i:%s')
									end and 
									case
										when encprod.u_estidurt = 'Hours' then date_add(STR_TO_DATE(CONCAT(SUBSTRING(encprod.u_sessdate FROM 1 FOR 10), ' ', encprod.ihour), '%Y-%m-%d %H:%i:%s'), INTERVAL encprod.u_estimdur HOUR)
										when encprod.u_estidurt = 'Minutes' then date_add(STR_TO_DATE(CONCAT(SUBSTRING(encprod.u_sessdate FROM 1 FOR 10), ' ', encprod.ihour), '%Y-%m-%d %H:%i:%s'), INTERVAL encprod.u_estimdur MINUTE)
										when encprod.u_estidurt = 'Days' then date_add(STR_TO_DATE(CONCAT(SUBSTRING(encprod.u_sessdate FROM 1 FOR 10), ' ', encprod.ihour), '%Y-%m-%d %H:%i:%s'), INTERVAL encprod.u_estimdur DAY)
										else STR_TO_DATE(CONCAT(SUBSTRING(encprod.u_sessdate FROM 1 FOR 10), ' ', encprod.ihour), '%Y-%m-%d %H:%i:%s')
									end > case
										when encprod.u_estidurt = 'Hours' then date_add(STR_TO_DATE(CONCAT('" . $year . '-' . sprintf('%02d', $month) . '-' . sprintf('%02d', $day) . "', ' ', encprod.curihour), '%Y-%m-%d %H:%i:%s'), INTERVAL encprod.u_estimdur HOUR)
										when encprod.u_estidurt = 'Minutes' then date_add(STR_TO_DATE(CONCAT('" . $year . '-' . sprintf('%02d', $month) . '-' . sprintf('%02d', $day) . "', ' ', encprod.curihour), '%Y-%m-%d %H:%i:%s'), INTERVAL encprod.u_estimdur MINUTE)
										when encprod.u_estidurt = 'Days' then date_add(STR_TO_DATE(CONCAT('" . $year . '-' . sprintf('%02d', $month) . '-' . sprintf('%02d', $day) . "', ' ', encprod.curihour), '%Y-%m-%d %H:%i:%s'), INTERVAL encprod.u_estimdur DAY)
										else STR_TO_DATE(CONCAT('" . $year . '-' . sprintf('%02d', $month) . '-' . sprintf('%02d', $day) . "', ' ', encprod.curihour), '%Y-%m-%d %H:%i:%s')
									end then 1 
									else 0
									end enc_colision,
									encprod.precref prec_ref,
									encprod.recqtt rec_available,
									case 
												when encprod.precvarbilh = 1 then encbi.qtt*encprod.precqtt
												else encprod.precqtt
									end rec_used
								from bi encbi
								inner join 
								(
									select bostamp encstamp, bo3.u_sessdate, prod.*
									from 
									   bo 
										   inner join bo2 on bo.bostamp = bo2.bo2stamp 
										   inner join bo3 on bo.bostamp = bo3.bo3stamp 
										   inner join 
									   (
										   select * from tempprod
									   )prod on bo.origem = prod.prodstamp and bo3.u_psessstp = prod.u_psessstamp
									where bo.ndos = 4 and bo2.ngstatus = 'PROCESSED' and bo2.nocts = prod.op 
								)encprod on encbi.bostamp=encprod.encstamp) x 
							where x.enc_colision = 1
							group by prec_ref
							order by prec_ref;
						";

                        $str_sql3 = "
							DROP TEMPORARY TABLE tempprod;
						";

                        $this->db->trans_start();
                        $this->db->query($str_sql1);
                        $query = $this->db->query($str_sql2);
                        $this->db->query($str_sql3);
                        $this->db->trans_complete();

                        $query = $query->result_array();

                        // $time_end = microtime(true);
                        // log_message("ERROR", ($time_end - $time_start));

                        $minimum = -1;
                        if (sizeof($query) > 0) {
                            foreach ($query as $row) {
                                if ($minimum < 0)
                                    $minimum = $row["available"];
                                else {
                                    if ($row["available"] < $minimum)
                                        $minimum = $row["available"];
                                }
                            }

                            if ($minimum < 0)
                                $minimum = 0;

                            if ($minimum < $lotation - $current_lotation) {
                                $lotation = $minimum;
                                $current_lotation = 0;
                            }
                        }
                    }

                    return array("lotation" => $lotation, "current_lotation" => $current_lotation);
                } else {
                    return array("lotation" => 99999999, "current_lotation" => 0);
                }
            }
        }
    }

    public function get_sessions($bostamp, $day, $month, $year) {
        //se nao estiver nas exclusoes
        $this->db->select("
            u_pexcl.*
            ");
        $this->db->from('bo');
        $this->db->join('bo2', 'bo.bostamp = bo2.bo2stamp');
        $this->db->join('bo3', 'bo.bostamp = bo3.bo3stamp');
        $this->db->join('u_pexcl', 'bo.bostamp = u_pexcl.bostamp');
        $this->db->where("bo.bostamp =", $bostamp);
        $query = $this->db->get()->result_array();

        $exclusoes = array();
        if (sizeof($query) > 0) {
            foreach ($query as $exclusao) {
                $tmp = array();
                $tmp[] = $year . '-' . $exclusao["imonth"] . '-' . $exclusao["iday"];
                $tmp[] = $year . '-' . $exclusao["fmonth"] . '-' . $exclusao["fday"];
                $exclusoes[] = $tmp;
            }
        }

        $data_excluida = 0;

        foreach ($exclusoes as $exclusao) {
            $idate = strtotime($exclusao[0]);
            $fdate = strtotime($exclusao[1]);
            $choosed_date = strtotime($year . '-' . $month . '-' . $day);

            if ($idate <= $choosed_date && $fdate >= $choosed_date) {
                $data_excluida = 1;
            }
        }

        $sessions = array();

        if (!$data_excluida) {
            //sessoes - sessoes dia em branco
            $dia_da_semana = date("l", strtotime("$year-$month-$day"));
            $dia_da_semana = substr($dia_da_semana, 0, 3);
            $dia_da_semana = strtolower($dia_da_semana);

            $this->db->select("
                u_psess.*
                ");
            $this->db->from('bo');
            $this->db->join('bo2', 'bo.bostamp = bo2.bo2stamp');
            $this->db->join('bo3', 'bo.bostamp = bo3.bo3stamp');
            $this->db->join('u_psess', 'bo.bostamp = u_psess.bostamp');
            $this->db->where("u_psess.fixday = '1900-01-01' and u_psess.fixday_end = '1900-01-01'");
            $this->db->where("u_psess.$dia_da_semana = 1");
            $this->db->where("bo.bostamp =", $bostamp);
            $query = $this->db->get()->result_array();

            if (sizeof($query) > 0) {
                foreach ($query as $session) {
                    if (!in_array($session["id"], $sessions)) {
                        $sessions[] = $session["id"];
                    }
                }
            }
        }

        //sessoes - sessoes dia preenchido
        $this->db->select("
            u_psess.*
            ");
        $this->db->from('bo');
        $this->db->join('bo2', 'bo.bostamp = bo2.bo2stamp');
        $this->db->join('bo3', 'bo.bostamp = bo3.bo3stamp');
        $this->db->join('u_psess', 'bo.bostamp = u_psess.bostamp');
        $this->db->where("STR_TO_DATE('$year-$month-$day', '%Y-%m-%d %H:%i:%s') between STR_TO_DATE(u_psess.fixday, '%Y-%m-%d %H:%i:%s') AND STR_TO_DATE(u_psess.fixday_end, '%Y-%m-%d %H:%i:%s')");
        $this->db->where("((not DAYOFWEEK(STR_TO_DATE('$year-$month-$day', '%Y-%m-%d %H:%i:%s')) = 1) or (u_psess.sun = 1))");
        $this->db->where("((not DAYOFWEEK(STR_TO_DATE('$year-$month-$day', '%Y-%m-%d %H:%i:%s')) = 2) or (u_psess.mon = 1))");
        $this->db->where("((not DAYOFWEEK(STR_TO_DATE('$year-$month-$day', '%Y-%m-%d %H:%i:%s')) = 3) or (u_psess.tue = 1))");
        $this->db->where("((not DAYOFWEEK(STR_TO_DATE('$year-$month-$day', '%Y-%m-%d %H:%i:%s')) = 4) or (u_psess.wed = 1))");
        $this->db->where("((not DAYOFWEEK(STR_TO_DATE('$year-$month-$day', '%Y-%m-%d %H:%i:%s')) = 5) or (u_psess.thu = 1))");
        $this->db->where("((not DAYOFWEEK(STR_TO_DATE('$year-$month-$day', '%Y-%m-%d %H:%i:%s')) = 6) or (u_psess.fri = 1))");
        $this->db->where("((not DAYOFWEEK(STR_TO_DATE('$year-$month-$day', '%Y-%m-%d %H:%i:%s')) = 7) or (u_psess.sat = 1))");

        $this->db->where("bo.bostamp =", $bostamp);
        $query = $this->db->get()->result_array();

        if (sizeof($query) > 0) {
            foreach ($query as $session) {
                if (!in_array($session["id"], $sessions)) {
                    $sessions[] = $session["id"];
                }
            }
        }

        //get a todas as sessoes
        $sessions_final = array();

        if( sizeof($sessions) ) {
            $this->db->select("
                u_psess.*
                ");
            $this->db->from('bo');
            $this->db->join('bo2', 'bo.bostamp = bo2.bo2stamp');
            $this->db->join('bo3', 'bo.bostamp = bo3.bo3stamp');
            $this->db->join('u_psess', 'bo.bostamp = u_psess.bostamp');
            $this->db->where("bo.bostamp =", $bostamp);
            $this->db->where_in('u_psess.id', $sessions);
            $this->db->order_by('u_psess.ihour', 'ASC');
            $query = $this->db->get()->result_array();

            if (sizeof($query) > 0) {
                foreach ($query as $session) {
                    $sessions_final[] = $session;
                }
            }
            
            return $sessions_final;
        }
        else {
            return array();
        }
       
    }
    
    public function get_sales_limit(){
       
    }

    public function get_days($bostamp, $month, $year) {
        //Day_Sales_limit
        $query ="
            select 
                 u_dtlim 
            from
                bo3 
            where 
                bo3stamp = '".$bostamp."' 
                    
        ";
            $day_sale_limit = $this->mssql->mssql__select($query);
			$day_sl = substr($day_sale_limit[0]["u_dtlim"], 0, 10);
				
        date_default_timezone_set('UTC');

        //primeiro e ultimo dia do mes
        $a_date = $year . "-" . $month . "-" . "01";
        $first_day_month = new DateTime(date("Y-m-01", strtotime($a_date)));
        $last_day_month = new DateTime(date("Y-m-t", strtotime($a_date)));

        $days_with_session = array();

        // fase 1 - verificar sessoes com range data
        $this->db->select("
		u_psess.*
		");
        $this->db->from('bo');
        $this->db->join('bo2', 'bo.bostamp = bo2.bo2stamp');
        $this->db->join('bo3', 'bo.bostamp = bo3.bo3stamp');
        $this->db->join('u_psess', 'bo.bostamp = u_psess.bostamp');
        $this->db->where("(u_psess.fixday <> '1900-01-01' or u_psess.fixday_end <> '1900-01-01')");
        $this->db->where("bo.bostamp", $bostamp);
        $query = $this->db->get();
        $dias_com_range = $query->result_array();

        if (sizeof($dias_com_range) > 0) {
            foreach ($dias_com_range as $session_day) {
                $tmp_date_start = strtotime($session_day["fixday"]);
                $tmp_date_end = strtotime($session_day["fixday_end"]);

                // se estao corretamente preenchidas, entao verificar se estao no mes pedido
                if ($tmp_date_start <= $tmp_date_end && $tmp_date_start != "" && $tmp_date_end != "") {
                    for ($i = $tmp_date_start; $i <= $tmp_date_end; $i = $i + 86400) {
                        $tmp_dt = new DateTime("@$i");
                        if ($tmp_dt >= $first_day_month && $tmp_dt <= $last_day_month) {
                            //está no intervalo de datas mas é preciso verificar se está nos dias permitidos
                            $week_day = date("D", $i);
                            if ($session_day[strtolower($week_day)] == 1) {
                                $days_with_session[] = $i;
                            }
                        }
                    }
                } else {
                    $tmp_dt = new DateTime($tmp_date_start);
                    if ($tmp_dt >= $first_day_month && $tmp_dt <= $last_day_month) {
                        $days_with_session[] = $tmp_date_start;
                    }
                    $tmp_dt = new DateTime($tmp_date_end);
                    if ($tmp_dt >= $first_day_month && $tmp_dt <= $last_day_month) {
                        $days_with_session[] = $tmp_date_end;
                    }
                }
            }
        }

        // fase 2 - verificar sessoes sem data definida
        $this->db->select("
		u_psess.*
		");
        $this->db->from('bo');
        $this->db->join('bo2', 'bo.bostamp = bo2.bo2stamp');
        $this->db->join('bo3', 'bo.bostamp = bo3.bo3stamp');
        $this->db->join('u_psess', 'bo.bostamp = u_psess.bostamp');
        $this->db->where("u_psess.fixday = '1900-01-01' and u_psess.fixday_end = '1900-01-01'");
        $this->db->where("bo.bostamp =", $bostamp);
        $query = $this->db->get();
        $dias_sem_range = $query->result_array();

        $last_day_month->modify('+1 day');

        if (sizeof($dias_sem_range) > 0) {
            foreach ($dias_sem_range as $session_day) {
                $interval = DateInterval::createFromDateString('1 day');
                $period = new DatePeriod($first_day_month, $interval, $last_day_month);

                foreach ($period as $dt) {
                    if ($session_day[substr(strtolower($dt->format("l")), 0, 3)] == 1) {
                        $days_with_session[] = strtotime($dt->format("Y-m-d"));
                    }
                }
            }
        }

        // fase 3 - excluir datas de exclusão
        $this->db->select("
		u_pexcl.*
		");
        $this->db->from('bo');
        $this->db->join('bo2', 'bo.bostamp = bo2.bo2stamp');
        $this->db->join('bo3', 'bo.bostamp = bo3.bo3stamp');
        $this->db->join('u_pexcl', 'bo.bostamp = u_pexcl.bostamp');
        $this->db->where("bo.bostamp =", $bostamp);
        $query = $this->db->get();
        $datas_exclusao = $query->result_array();

        if (sizeof($datas_exclusao) > 0) {
            foreach ($datas_exclusao as $exclusion) {

                $exclusion_i_date = strtotime($year . "-" . $exclusion["imonth"] . "-" . $exclusion["iday"]);
                $exclusion_f_date = strtotime($year . "-" . $exclusion["fmonth"] . "-" . $exclusion["fday"]);

                foreach ($days_with_session as $day_with_session) {
                    if ($day_with_session >= $exclusion_i_date && $day_with_session <= $exclusion_f_date) {
                        if (($key = array_search($day_with_session, $days_with_session)) !== false) {
                            unset($days_with_session[$key]);
                        }
                    }
                }
            }
        }

        $days_with_session_tmp = $days_with_session;
        $days_with_session = array();

        foreach ($days_with_session_tmp as $day) {
            if (!in_array($day, $days_with_session))
                $days_with_session[] = $day;
        }

        $days_result = array();
		$today=date("Y-m-d");
		if($day_sl >= $today){
			$day_salelimit = $day_sl;
		}
			else{
				$day_salelimit = array();
			}
        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($first_day_month, $interval, $last_day_month);
        $now = strtotime('today');
	
        foreach ($period as $dt) {
			
            $tmp_array = array();
            $tmp_array["date"] = $dt->format("j/n/Y");
			$dl_array["tdate"] = $dt->format("Y-m-d");
			$d = strtotime($dt->format("Y/m/d"));
		
            //dias para tras e dias permitidos
            if (strtotime($dt->format("Y/m/d")) < $now) {
                $tmp_array["color"] = "#cc7d7d";
            } else if (!in_array(strtotime($dt->format("Y-m-d")), $days_with_session)) {
                $tmp_array["color"] = "#cc7d7d";
            }
			else if ($dl_array["tdate"] > $day_salelimit ) {
                $tmp_array["color"] = "#cc7d7d";
                
            } else {
                $tmp_array["color"] = "#83cc7d";
            }

            $days_result[] = $tmp_array;
        }

        return $days_result;
    }

}
