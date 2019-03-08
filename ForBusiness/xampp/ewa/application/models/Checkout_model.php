<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Checkout_model class.
 * 
 * @extends CI_Model
 */
class Checkout_model extends CI_Model {

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

    function setPlafondEmailSent($ag, $op, $status) {
        $query = "
			update u_agop set emailenviado = '" . $status . "'
			from fl (nolock)
				inner join u_agop (nolock) on fl.flstamp = u_agop.agstamp
				inner join fl op (nolock) on op.no = '" . $op . "' and op.estab = 0 and op.flstamp = u_agop.opstamp 
			where 
				fl.no = '" . $ag . "' and 
				fl.estab = 0 and 
				fl.inactivo = 0 and 
				fl.U_AGENTE  = 'Sim'
		";
        $emailenviado = $this->mssql->mssql__execute($query);

        return $emailenviado;
    }

    function getPlafondEmailSent($ag, $op) {
        $query = "
			select top 1 u_agop.emailenviado 
			from fl (nolock)
				inner join u_agop (nolock) on fl.flstamp = u_agop.agstamp
				inner join fl op (nolock) on op.no = '" . $op . "' and op.estab = 0 and op.flstamp = u_agop.opstamp 
			where 
				fl.no = '" . $ag . "' and 
				fl.estab = 0 and 
				fl.inactivo = 0 and 
				fl.U_AGENTE  = 'Sim'
		";
        $emailenviado = $this->mssql->mssql__select($query);

        if (sizeof($emailenviado) > 0) {
            $emailenviado = $emailenviado[0]["emailenviado"];
            return $emailenviado;
        } else {
            return 0;
        }
    }

    function getOperatorEmail($op) {
        $this->db->select('email');
        $this->db->from('fl');
        $this->db->where('no', $op);
        $this->db->where('estab', 0);
        $query = $this->db->get();
        $query = $query->result_array();

        if (sizeof($query) > 0) {
            return $query[0]["email"];
        } else {
            return "";
        }
    }

    function exist_tmp_data($uniq_id) {
        $this->db->select('data');
        $this->db->from('data_tmp');
        $this->db->where('uniq_id', $uniq_id);
        $query = $this->db->get();
        $query = $query->result_array();
        $empty = array();

        return sizeof($query);
    }

    function get_tmp_data($uniq_id) {
        $this->db->select('data');
        $this->db->from('data_tmp');
        $this->db->where('uniq_id', $uniq_id);
        $query = $this->db->get();
        $query = $query->result_array();
        $empty = array();

        if (sizeof($query))
            return json_decode($query[0]["data"], true);
        else
            return $empty;
    }

    function delete_tmp_data($data) {
        $this->db->where('uniq_id', $data["payment"]["orderID"]);
        $this->db->delete('data_tmp');
    }

    function delete_tmp_data2($id) {
        $this->db->where('uniq_id', $id);
        $this->db->delete('data_tmp');
    }

    function get_sha256($get, $key_sign) {
        $get = array_change_key_case($get, CASE_UPPER);
        ksort($get);
        $tmp = "";

        foreach ($get as $key => $val) {
            if ($key != "SHASIGN" && trim($val) != "")
                $tmp .= strtoupper($key) . '=' . $val . $key_sign;
        }

        $result = strtoupper(hash('sha256', $tmp));
        return $result;
    }

    function set_cart_cookie($data, $uniq_id = '') {
        if (trim($uniq_id) == '' or is_null($uniq_id))
            $uniq_id = $this->getToken(15);

        $this->db->select('*');
        $this->db->from('cart');
        $this->db->where('id', $uniq_id);

        $query = $this->db->get();
        $query = $query->result_array();

        if (sizeof($query) > 0) {
            $this->db->set('data', json_encode($data));
            $this->db->where('id', $uniq_id);
            $this->db->update('cart');
        } else {
            $cart = array(
                'data' => json_encode($data),
                'id' => $uniq_id
            );

            $this->db->insert('cart', $cart);
        }

        return $uniq_id;
    }

    function get_cart_cookie($id) {
        $this->db->select('data');
        $this->db->from('cart');
        $this->db->where('id', $id);

        $query = $this->db->get();
        $query = $query->result_array();

        if (sizeof($query) > 0) {
            return json_decode($query[0]["data"], true);
        } else {
            return array();
        }
    }

    function save_tmp_order($data, $user) {
        $uniq_id = $this->getToken(8);

        $order_data = array(
            'data' => json_encode($data),
            'user_id' => $user,
            'uniq_id' => $uniq_id
        );

        $this->db->insert('data_tmp', $order_data);

        return $uniq_id;
    }

    function crypto_rand_secure($min, $max) {
        $range = $max - $min;
        if ($range < 1)
            return $min; // not so random...
        $log = ceil(log($range, 2));
        $bytes = (int) ($log / 8) + 1; // length in bytes
        $bits = (int) $log + 1; // length in bits
        $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter; // discard irrelevant bits
        } while ($rnd > $range);
        return $min + $rnd;
    }

    function getToken($length) {
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet .= "0123456789";
        $max = strlen($codeAlphabet); // edited

        for ($i = 0; $i < $length; $i++) {
            $token .= $codeAlphabet[$this->crypto_rand_secure(0, $max - 1)];
        }

        return $token;
    }

    public function getPaymentMethods() {
        $this->db->select('
			*
		');
        $this->db->from('payment_methods');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_orders($user_id) {
        $this->db->select('*');
        $this->db->from('bo');
        $this->db->join('bo2', 'bo.bostamp = bo2.bo2stamp');
        $this->db->join('bo3', 'bo.bostamp = bo3.bo3stamp');
        $this->db->join('u_psess', 'bo3.u_psessstp = u_psess.u_psessstamp');
        $this->db->join('order_status', 'bo2.ngstatus = order_status.name', 'left');
        $this->db->where('bo.ndos', '4');
        $this->db->where('bo.nopat', $user_id);
        $this->db->where('bo.site', 'EWASITE');
        $this->db->order_by('bo.obrano', 'ASC');
        $query = $this->db->get();
        $query = $query->result_array();
        return $query;
    }

    public function getAgentMaxPlafond($ag, $op) {

        $query = "
			select top 1 u_agop.cashplafond 
			from fl (nolock)
				inner join u_agop (nolock) on fl.flstamp = u_agop.agstamp
				inner join fl op (nolock) on op.no = '" . $op . "' and op.estab = 0 and op.flstamp = u_agop.opstamp 
			where 
				fl.no = '" . $ag . "' and 
				fl.estab = 0 and 
				fl.inactivo = 0 and 
				fl.U_AGENTE  = 'Sim'
		";
        $plafond = $this->mssql->mssql__select($query);

        if (sizeof($plafond) > 0) {
            $plafond = $plafond[0]["cashplafond"];
            return $plafond;
        } else {
            return 0;
        }
    }

    public function get_ifonepage($id, $op) {
        $query = "
			select top 1 u_agop.onepage_checkout 
			from fl (nolock)
                                                        inner join u_agop (nolock) on fl.flstamp = u_agop.agstamp
                                                        inner join fl op (nolock) on op.no = '" . $op . "' and op.estab = 0 and op.flstamp = u_agop.opstamp 
		
			where 
				fl.no = " . $id . " and 
				fl.estab = 0 and 
				fl.inactivo = 0 and 
				fl.U_AGENTE  = 'Sim' 
		";

        $sql_status = $this->mssql->mssql__select($query);
        return $sql_status;
    }

    public function getAgentSellLimit($ag, $op) {

        $query = "
			select top 1 u_agop.limitevenda 
			from fl (nolock)
				inner join u_agop (nolock) on fl.flstamp = u_agop.agstamp
				inner join fl op (nolock) on op.no = '" . $op . "' and op.estab = 0 and op.flstamp = u_agop.opstamp 
			where 
				fl.no = '" . $ag . "' and 
				fl.estab = 0 and 
				fl.inactivo = 0 and 
				fl.U_AGENTE  = 'Sim'
		";
        $limite = $this->mssql->mssql__select($query);

        if (sizeof($limite) > 0) {
            $limite = $limite[0]["limitevenda"];
            return $limite;
        } else {
            return 0;
        }
    }

    public function getAgentPlafond($ag, $op) {

        $query = "
			select top 1 u_agop.cashplafond 
			from fl (nolock)
				inner join u_agop (nolock) on fl.flstamp = u_agop.agstamp
				inner join fl op (nolock) on op.no = '" . $op . "' and op.estab = 0 and op.flstamp = u_agop.opstamp 
			where 
				fl.no = '" . $ag . "' and 
				fl.estab = 0 and 
				fl.inactivo = 0 and 
				fl.U_AGENTE  = 'Sim'
		";
        $plafond = $this->mssql->mssql__select($query);

        if (sizeof($plafond) > 0) {
            $plafond = $plafond[0]["cashplafond"];

            $query = "
				select 
					top 1 fo2.u_esaldpla, fo.adoc, fo.nome, fo.no, fo2.ousrdata, fo2.ousrhora, fo.doccode, fo.etotal, fo2.u_opno
				from fo
					inner join fo2 on fo.fostamp = fo2.fo2stamp
				where 
					fo.doccode = 104 and
					fo.no = '" . $ag . "' and
					u_opno = '" . $op . "' and
					aprovado = 1
				order by
					fo2.ousrdata desc, fo2.ousrhora desc
			";
            $ult_dev = $this->mssql->mssql__select($query);

            if (sizeof($ult_dev) > 0) {
                $ult_dev = $ult_dev[0];

                $query = "
					select SUM(valor) valor
					from u_ccom
					inner join bo2 on bo2.bo2stamp = u_ccom.ecstamp
					where 
						agno = '" . $ag . "' and opno = '" . $op . "' and
						CONVERT(datetime, u_ccom.ousrdata + ' ' + u_ccom.ousrhora , 120) >= CONVERT(datetime, '" . substr($ult_dev["ousrdata"], 0, 19) . "', 120) and
						bo2.identificacao2 = 'CASH'
				";

                $total_vendido = $this->mssql->mssql__select($query);

                if (sizeof($total_vendido) > 0) {
                    $total_vendido = $total_vendido[0];
                    return floatval($plafond) - floatval($ult_dev["u_esaldpla"]) - floatval($total_vendido["valor"]);
                } else {
                    return floatval($plafond) - floatval($ult_dev["u_esaldpla"]);
                }
            } else {
                $query = "
					select SUM(valor) valor
					from u_ccom
					inner join bo2 on bo2.bo2stamp = u_ccom.ecstamp
					where 
						agno = '" . $ag . "' and opno = '" . $op . "' and
						bo2.identificacao2 = 'CASH'
				";

                $total_vendido = $this->mssql->mssql__select($query);

                if (sizeof($total_vendido) > 0) {
                    $total_vendido = $total_vendido[0];

                    return floatval($plafond) - floatval($total_vendido["valor"]);
                } else {
                    return floatval($plafond);
                }
            }
        } else {
            return 0;
        }
    }

    public function get_order($bostamp) {
        $this->db->select("*,(select nome from fl where no = bo2.TKHDID and estab = 0) agent,bo3.U_SESSDATE,bo2.IDENTIFICACAO2,bo2.NOMECTS,bo2.TKHDID,IFNULL((select u_name from bo a where bostamp=bo.origem), '') product,(select ihour from u_psess where u_psessstamp = bo3.u_psessstp) ihour,
		(bo.ebo12_iva+bo.ebo22_iva+bo.ebo32_iva+bo.ebo42_iva+bo.ebo52_iva+bo.ebo62_iva+bo2.ebo72_iva+bo2.ebo82_iva+bo2.ebo92_iva + bo.etotaldeb) etotal");
        $this->db->from('bo');
        $this->db->join('bo2', 'bo.bostamp = bo2.bo2stamp');
        $this->db->join('bo3', 'bo.bostamp = bo3.bo3stamp');
        $this->db->join('order_status', 'bo2.ngstatus = order_status.name', 'left');
        $this->db->where('bo.bostamp', $bostamp);
        $this->db->where('bo.ndos', 4);
        $this->db->where('bo.estab', 0);
        $query = $this->db->get();
        $query = $query->result_array();
        return $query;
    }

    public function get_order_bi($bostamp) {
        $this->db->select('*');
        $this->db->from('bi');
        $this->db->where('bi.bostamp', $bostamp);
        $this->db->order_by('bi.lordem');
        $query = $this->db->get();
        $query = $query->result_array();
        return $query;
    }

    public function wl_get_orders($user_id, $op) {
        $this->db->select('
		bo.*, bo3.*, u_psess.*, bo2.ngstatus, order_status.*
		');
        $this->db->from('bo');
        $this->db->join('bo2', 'bo.bostamp = bo2.bo2stamp');
        $this->db->join('bo3', 'bo.bostamp = bo3.bo3stamp');
        $this->db->join('u_psess', 'bo3.u_psessstp = u_psess.u_psessstamp');
        $this->db->join('order_status', 'bo2.ngstatus = order_status.name', 'left');
        $this->db->where('bo.ndos', '4');
        $this->db->where('bo.nopat', $user_id);
        $this->db->where('bo2.nocts', $op);
        $this->db->order_by('bo.obrano', 'ASC');
        $query = $this->db->get();
        $query = $query->result_array();
        return $query;
    }

    public function wl_get_order($bostamp) {

        $this->db->select("*,(select nome from fl where no = bo2.TKHDID and estab = 0) agent,bo3.U_SESSDATE,bo2.IDENTIFICACAO2,bo2.NOMECTS,bo2.TKHDID,IFNULL((select u_name from bo a where bostamp=bo.origem), '') product,(select ihour from u_psess where u_psessstamp = bo3.u_psessstp) ihour,(bo.ebo12_iva+bo.ebo22_iva+bo.ebo32_iva+bo.ebo42_iva+bo.ebo52_iva+bo.ebo62_iva+bo2.ebo72_iva+bo2.ebo82_iva+bo2.ebo92_iva + bo.etotaldeb) etotal");
        $this->db->from('bo');
        $this->db->join('bo2', 'bo.bostamp = bo2.bo2stamp');
        $this->db->join('bo3', 'bo.bostamp = bo3.bo3stamp');
        $this->db->join('order_status', 'bo2.ngstatus = order_status.name', 'left');
        $this->db->where('bo.bostamp', $bostamp);
        $this->db->where('bo.ndos', 4);
        $this->db->where('bo.estab', 0);
        $query = $this->db->get();
        $query = $query->result_array();
        return $query;
    }

    public function wl_get_order_bi($bostamp) {

        $this->db->select('
		*
		');
        $this->db->from('bi');
        $this->db->where('bi.bostamp', $bostamp);
        $this->db->order_by('bi.lordem');
        $query = $this->db->get();
        $query = $query->result_array();
        return $query;
    }

    public function get_cart($type, $cart_data, $date, $session, $bostamp) {

        $cart = array();
        $cart_data = json_decode($cart_data);

        //verificar se quicksel
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

                    if ($type == "seats") {
                        $date = explode("/", $date);

                        $day = $date[1];
                        $month = $date[0];
                        $year = $date[2];
                        $data_formatada = date("Y-m-d", strtotime("$year-$month-$day"));

                        foreach ($cart_data as $row) {

                            $cart_product = array();

                            //lugar
                            $cor = $row[0];
                            //tipo bilhete
                            $tam = $row[1];
                            //qtt
                            $qtt = floatval(str_replace(",", "", $row[2]));
                            //extra
                            $extra = $row[3];

                            //se bilhete
                            if (!$extra) {
                                $cart_product["cor"] = $cor;
                                $cart_product["tam"] = $tam;

                                //check if seat is occupied
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
                                $this->db->where('bi.cor', $cor);
                                $query = $this->db->get();
                                $query = $query->result_array();

                                //já está ocupado
                                if (sizeof($query) > 0) {
                                    $cart_product["occupied"] = 1;
                                } else {
                                    $cart_product["occupied"] = 0;

                                    //check seat's price
                                    $this->db->select('
									bo.obrano,
									u_psess.price,
									u_psess.ihour,
									u_psess.u_psessstamp
									');
                                    $this->db->from('bo');
                                    $this->db->join('u_psess', 'bo.bostamp = u_psess.bostamp');
                                    $this->db->where('bo.bostamp', $bostamp);
                                    $this->db->where('u_psess.id', $session);
                                    $query = $this->db->get();
                                    $query = $query->result_array();
                                    $preco_id = "";

                                    $cart_product["date"] = $data_formatada;

                                    if (sizeof($query) > 0) {
                                        foreach ($query as $sessao) {
                                            if ($sessao["price"] == 0) {
                                                $preco_id = "P." . trim($sessao["obrano"]) . ".0";
                                            } else {
                                                $preco_id = "P." . trim($sessao["obrano"]) . "." . trim($session);
                                            }

                                            $cart_product["session_hour"] = trim($sessao["ihour"]);
                                            $cart_product["session_stamp"] = trim($sessao["u_psessstamp"]);
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
                                    $this->db->where('sx.cor', $cor);
                                    $this->db->where('sx.tam', $tam);
                                    $query = $this->db->get();
                                    $query = $query->result_array();

                                    if (sizeof($query) > 0) {
                                        foreach ($query as $preco) {
                                            $preco_bilhete = number_format($preco["epv1"], 2, '.', ',');
                                        }
                                    }

                                    $cart_product["ref"] = $preco_id;
                                    $cart_product["unit_price"] = floatval(str_replace(",", "", $preco_bilhete));
                                    $cart_product["qtt"] = 1;

                                    $this->db->select('
									bo.u_name
									');
                                    $this->db->from('bo');
                                    $this->db->where('bo.bostamp', $bostamp);
                                    $query = $this->db->get();
                                    $query = $query->result_array();

                                    if (sizeof($query) > 0) {
                                        foreach ($query as $bo) {
                                            $cart_product["desc"] = $bo["u_name"];
                                        }
                                    }
                                }
                            } else {
                                $cart_product["cor"] = "";
                                $cart_product["tam"] = "";

                                $cart_product["occupied"] = 0;
                                $cart_product["date"] = $data_formatada;
                                $cart_product["session_hour"] = "";
                                $cart_product["session_stamp"] = "";
                                $cart_product["ref"] = $tam;
                                $cart_product["unit_price"] = floatval(str_replace(",", "", $cor));
                                $cart_product["qtt"] = floatval(str_replace(",", "", $qtt));

                                $this->db->select('
									design
								');
                                $this->db->from('u_prec');
                                $this->db->where('ref', $tam);
                                $this->db->where('bostamp', $bostamp);
                                $query = $this->db->get();
                                $query = $query->result_array();

                                if (sizeof($query) > 0) {
                                    foreach ($query as $ex) {
                                        $cart_product["desc"] = $ex["design"];
                                    }
                                }
                            }
                            //save it to cart array

                            $cart[] = $cart_product;
                        }
                    } else if ($type == "tickets") {
                        $date = explode("/", $date);

                        $day = $date[1];
                        $month = $date[0];
                        $year = $date[2];

                        $data_formatada = date("Y-m-d", strtotime("$year-$month-$day"));

                        foreach ($cart_data as $row) {

                            $cart_product = array();

                            //lugar
                            $cor = $row[0];
                            //tipo bilhete
                            $tam = $row[1];
                            //qtd bilhete
                            $qtt = $row[2];
                            //extra
                            $extra = $row[3];

                            //se bilhete
                            if (!$extra) {
                                $cart_product["cor"] = $cor;
                                $cart_product["tam"] = $tam;

                                //check if max min tickets
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
                                $this->db->where('bi.cor', $cor);
                                $query = $this->db->get();
                                $query = $query->result_array();

                                $cart_product["occupied"] = 0;

                                //check seat's price
                                $this->db->select('
								bo.obrano,
								u_psess.price,
								u_psess.ihour,
								u_psess.u_psessstamp
								');
                                $this->db->from('bo');
                                $this->db->join('u_psess', 'bo.bostamp = u_psess.bostamp');
                                $this->db->where('bo.bostamp', $bostamp);
                                $this->db->where('u_psess.id', $session);
                                $query = $this->db->get();
                                $query = $query->result_array();
                                $preco_id = "";

                                $cart_product["date"] = $data_formatada;

                                if (sizeof($query) > 0) {
                                    foreach ($query as $sessao) {
                                        if ($sessao["price"] == 0) {
                                            $preco_id = "P." . trim($sessao["obrano"]) . ".0";
                                        } else {
                                            $preco_id = "P." . trim($sessao["obrano"]) . "." . trim($session);
                                        }

                                        $cart_product["session_hour"] = trim($sessao["ihour"]);
                                        $cart_product["session_stamp"] = trim($sessao["u_psessstamp"]);
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
                                $this->db->where('sx.cor', $cor);
                                $this->db->where('sx.tam', $tam);
                                $query = $this->db->get();
                                $query = $query->result_array();

                                // $f = fopen("tiago.txt", "a");
                                // fwrite($f, print_r($this->db->last_query(), true) );
                                // fclose($f);

                                if (sizeof($query) > 0) {
                                    foreach ($query as $preco) {
                                        $preco_bilhete = number_format($preco["epv1"], 2, '.', ',');
                                    }
                                }

                                $cart_product["ref"] = $preco_id;
                                $cart_product["unit_price"] = floatval(str_replace(",", "", $preco_bilhete));
                                $cart_product["qtt"] = floatval(str_replace(",", "", $qtt));

                                $this->db->select('
								bo.u_name
								');
                                $this->db->from('bo');
                                $this->db->where('bo.bostamp', $bostamp);
                                $query = $this->db->get();
                                $query = $query->result_array();

                                if (sizeof($query) > 0) {
                                    foreach ($query as $bo) {
                                        $cart_product["desc"] = $bo["u_name"];
                                    }
                                }
                            } else {
                                $cart_product["cor"] = "";
                                $cart_product["tam"] = "";

                                $cart_product["occupied"] = 0;
                                $cart_product["date"] = $data_formatada;
                                $cart_product["session_hour"] = "";
                                $cart_product["session_stamp"] = "";
                                $cart_product["ref"] = $tam;
                                $cart_product["unit_price"] = floatval(str_replace(",", "", $cor));
                                $cart_product["qtt"] = floatval(str_replace(",", "", $qtt));

                                $this->db->select('
									design
								');
                                $this->db->from('u_prec');
                                $this->db->where('ref', $tam);
                                $this->db->where('bostamp', $bostamp);
                                $query = $this->db->get();
                                $query = $query->result_array();

                                if (sizeof($query) > 0) {
                                    foreach ($query as $ex) {
                                        $cart_product["desc"] = $ex["design"];
                                    }
                                }
                            }

                            //save it to cart array

                            $cart[] = $cart_product;
                        }
                    }
                } else {
                    if ($type == "seats") {
                        $date = explode("/", $date);

                        $day = $date[1];
                        $month = $date[0];
                        $year = $date[2];
                        $data_formatada = date("Y-m-d", strtotime("$year-$month-$day"));

                        foreach ($cart_data as $row) {

                            $cart_product = array();

                            //lugar
                            $cor = $row[0];
                            //tipo bilhete
                            $tam = $row[1];
                            //qtt
                            $qtt = $row[2];
                            //extra
                            $extra = $row[3];

                            //se bilhete
                            if (!$extra) {
                                $cart_product["cor"] = $cor;
                                $cart_product["tam"] = $tam;

                                $cart_product["occupied"] = 0;

                                //check seat's price
                                $this->db->select('
								bo.obrano
								');
                                $this->db->from('bo');
                                $this->db->where('bo.bostamp', $bostamp);
                                $query = $this->db->get();
                                $query = $query->result_array();
                                $preco_id = "";

                                $cart_product["date"] = $data_formatada;

                                if (sizeof($query) > 0) {
                                    foreach ($query as $sessao) {
                                        $preco_id = "P." . trim($sessao["obrano"]) . ".0";
                                    }
                                }

                                $cart_product["session_hour"] = '00:00';
                                $cart_product["session_stamp"] = "";

                                $this->db->select('
								sx.ref,
								sx.cor,
								sx.tam,
								sx.epv1
								');
                                $this->db->from('sx');
                                $this->db->where('sx.ref', $preco_id);
                                $this->db->where('sx.cor', $cor);
                                $this->db->where('sx.tam', $tam);
                                $query = $this->db->get();
                                $query = $query->result_array();

                                if (sizeof($query) > 0) {
                                    foreach ($query as $preco) {
                                        $preco_bilhete = number_format($preco["epv1"], 2, '.', ',');
                                    }
                                }

                                $cart_product["ref"] = $preco_id;
                                $cart_product["unit_price"] = floatval(str_replace(",", "", $preco_bilhete));
                                $cart_product["qtt"] = 1;

                                $this->db->select('
								bo.u_name
								');
                                $this->db->from('bo');
                                $this->db->where('bo.bostamp', $bostamp);
                                $query = $this->db->get();
                                $query = $query->result_array();

                                if (sizeof($query) > 0) {
                                    foreach ($query as $bo) {
                                        $cart_product["desc"] = $bo["u_name"];
                                    }
                                }
                            } else {
                                $cart_product["cor"] = "";
                                $cart_product["tam"] = "";

                                $cart_product["occupied"] = 0;
                                $cart_product["date"] = $data_formatada;
                                $cart_product["session_hour"] = "";
                                $cart_product["session_stamp"] = "";
                                $cart_product["ref"] = $tam;
                                $cart_product["unit_price"] = floatval(str_replace(",", "", $cor));
                                $cart_product["qtt"] = floatval(str_replace(",", "", $qtt));

                                $this->db->select('
									design
								');
                                $this->db->from('u_prec');
                                $this->db->where('ref', $tam);
                                $this->db->where('bostamp', $bostamp);
                                $query = $this->db->get();
                                $query = $query->result_array();

                                if (sizeof($query) > 0) {
                                    foreach ($query as $ex) {
                                        $cart_product["desc"] = $ex["design"];
                                    }
                                }
                            }
                            //save it to cart array

                            $cart[] = $cart_product;
                        }
                    } else if ($type == "tickets") {
                        $date = explode("/", $date);

                        $day = $date[1];
                        $month = $date[0];
                        $year = $date[2];

                        $data_formatada = date("Y-m-d", strtotime("$year-$month-$day"));

                        foreach ($cart_data as $row) {

                            $cart_product = array();

                            //lugar
                            $cor = $row[0];
                            //tipo bilhete
                            $tam = $row[1];
                            //qtd bilhete
                            $qtt = $row[2];
                            //extra
                            $extra = $row[3];

                            //se bilhete
                            if (!$extra) {
                                $cart_product["cor"] = $cor;
                                $cart_product["tam"] = $tam;
                                $cart_product["occupied"] = 0;

                                //check seat's price
                                $this->db->select('
								bo.obrano
								');
                                $this->db->from('bo');
                                $this->db->where('bo.bostamp', $bostamp);
                                $query = $this->db->get();
                                $query = $query->result_array();
                                $preco_id = "";

                                $cart_product["date"] = $data_formatada;

                                if (sizeof($query) > 0) {
                                    foreach ($query as $sessao) {
                                        $preco_id = "P." . trim($sessao["obrano"]) . ".0";
                                    }
                                }
                                $cart_product["session_hour"] = '00:00';
                                $cart_product["session_stamp"] = "";

                                $this->db->select('
								sx.ref,
								sx.cor,
								sx.tam,
								sx.epv1
								');
                                $this->db->from('sx');
                                $this->db->where('sx.ref', $preco_id);
                                $this->db->where('sx.cor', $cor);
                                $this->db->where('sx.tam', $tam);
                                $query = $this->db->get();
                                $query = $query->result_array();

                                if (sizeof($query) > 0) {
                                    foreach ($query as $preco) {
                                        $preco_bilhete = number_format($preco["epv1"], 2, '.', ',');
                                    }
                                }

                                $cart_product["ref"] = $preco_id;
                                $cart_product["unit_price"] = floatval(str_replace(",", "", $preco_bilhete));
                                $cart_product["qtt"] = floatval(str_replace(",", "", $qtt));

                                $this->db->select('
								bo.u_name
								');
                                $this->db->from('bo');
                                $this->db->where('bo.bostamp', $bostamp);
                                $query = $this->db->get();
                                $query = $query->result_array();

                                if (sizeof($query) > 0) {
                                    foreach ($query as $bo) {
                                        $cart_product["desc"] = $bo["u_name"];
                                    }
                                }
                            } else {
                                $cart_product["cor"] = "";
                                $cart_product["tam"] = "";

                                $cart_product["occupied"] = 0;
                                $cart_product["date"] = $data_formatada;
                                $cart_product["session_hour"] = "";
                                $cart_product["session_stamp"] = "";
                                $cart_product["ref"] = $tam;
                                $cart_product["unit_price"] = floatval(str_replace(",", "", $cor));
                                $cart_product["qtt"] = floatval(str_replace(",", "", $qtt));

                                $this->db->select('
									design
								');
                                $this->db->from('u_prec');
                                $this->db->where('ref', $tam);
                                $this->db->where('bostamp', $bostamp);
                                $query = $this->db->get();
                                $query = $query->result_array();

                                if (sizeof($query) > 0) {
                                    foreach ($query as $ex) {
                                        $cart_product["desc"] = $ex["design"];
                                    }
                                }
                            }

                            //save it to cart array

                            $cart[] = $cart_product;
                        }
                    }
                }
            }
        }
        return $cart;
    }

}
