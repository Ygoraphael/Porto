<?php

class Order_model extends CI_Model {
	
	var $encomendas = array();
	var $fields = array();
	
	var $exists = 0;

	function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }

	function WriteLog($message)
	{
		$f = fopen("MyLog.txt", "a");
		fwrite($f, date("Y-m-d H:i:s") . " - " . print_r($message,true) . "\n");
		fclose($f);
	}

	function get_max_mdate()
	{
		$this->db->select_max('modified_on');
		$value = $this->db->get('d2e0b_virtuemart_orders')->row()->modified_on;
		
		if(!is_null($value))
			return $value;
		else
			return "1900-01-01 00:00:00";
	}
	
	function get_order ( $obrano ) 
	{
    	$query = $this->db->get_where( 'd2e0b_virtuemart_orders', array( 'virtuemart_order_id' => $obrano) );

    	if ( $query->num_rows() > 0 ) 
		{
    		foreach( $query->result_array() as $row ) 
			{
                $this->fields = $row; 
                return $this;
            }
    	}
    	return $this;
    }
	
	function getorderstatus ( $estado ) 
	{
    	$query = $this->db->get_where( 'd2e0b_virtuemart_orderstates', array( 'order_status_name' => $estado) );

    	if ( $query->num_rows() > 0 ) 
		{
    		foreach( $query->result_array() as $row ) 
			{
                return $row["order_status_code"]; 
            }
    	}
    	return "";
    }
	
    function get ( $last_order ) 
	{
		$str_sql = 
		"
		select 
			virtuemart_order_id obrano,
			(select phc_no from d2e0b_users where id = virtuemart_user_id) no,
			order_number,
			order_pass,
			order_total etotalciva,
			order_billTaxAmount ebo22_iva,
			order_shipment,
			(order_total - order_billTaxAmount) etotaldeb,
			(order_total - order_billTaxAmount) etotal,
			(order_subtotal + order_shipment) - (order_total - order_billTaxAmount) edescc,
			customer_note obs,
			created_on dataobra, 
			IFNULL((select first_name from d2e0b_virtuemart_order_userinfos where d2e0b_virtuemart_orders.virtuemart_order_id = virtuemart_order_id and address_type = 'BT' limit 1), '') nome,
			IFNULL((select address_1 from d2e0b_virtuemart_order_userinfos where d2e0b_virtuemart_orders.virtuemart_order_id = virtuemart_order_id and address_type = 'BT' limit 1), '') morada,
			IFNULL((select city from d2e0b_virtuemart_order_userinfos where d2e0b_virtuemart_orders.virtuemart_order_id = virtuemart_order_id and address_type = 'BT' limit 1), '') local,
			IFNULL((select email from d2e0b_virtuemart_order_userinfos where d2e0b_virtuemart_orders.virtuemart_order_id = virtuemart_order_id and address_type = 'BT' limit 1), '') email,
			IFNULL((select phone_1 from d2e0b_virtuemart_order_userinfos where d2e0b_virtuemart_orders.virtuemart_order_id = virtuemart_order_id and address_type = 'BT' limit 1), '') telefone,
			IFNULL((select country_name from d2e0b_virtuemart_countries where virtuemart_country_id = IFNULL((select virtuemart_country_id from d2e0b_virtuemart_order_userinfos where d2e0b_virtuemart_orders.virtuemart_order_id = virtuemart_order_id and address_type = 'BT' limit 1), '')), '') pais_origem,
			IFNULL((select zip from d2e0b_virtuemart_order_userinfos where d2e0b_virtuemart_orders.virtuemart_order_id = virtuemart_order_id and address_type = 'BT' limit 1), '') codpost,
			IFNULL((select first_name from d2e0b_virtuemart_order_userinfos where d2e0b_virtuemart_orders.virtuemart_order_id = virtuemart_order_id and address_type = 'ST' limit 1), '') nome_entrega,
			IFNULL((select address_1 from d2e0b_virtuemart_order_userinfos where d2e0b_virtuemart_orders.virtuemart_order_id = virtuemart_order_id and address_type = 'ST' limit 1), '') morada_entrega,
			IFNULL((select city from d2e0b_virtuemart_order_userinfos where d2e0b_virtuemart_orders.virtuemart_order_id = virtuemart_order_id and address_type = 'ST' limit 1), '') local_entrega,
			IFNULL((select phone_1 from d2e0b_virtuemart_order_userinfos where d2e0b_virtuemart_orders.virtuemart_order_id = virtuemart_order_id and address_type = 'ST' limit 1), '') telefone_entrega,
			IFNULL((select country_name from d2e0b_virtuemart_countries where virtuemart_country_id = IFNULL((select virtuemart_country_id from d2e0b_virtuemart_order_userinfos where d2e0b_virtuemart_orders.virtuemart_order_id = virtuemart_order_id and address_type = 'ST' limit 1), '')), '') pais_origem_entrega,
			IFNULL((select zip from d2e0b_virtuemart_order_userinfos where d2e0b_virtuemart_orders.virtuemart_order_id = virtuemart_order_id and address_type = 'ST' limit 1), '') codpost_entrega,
			IFNULL((select payment_name from d2e0b_virtuemart_paymentmethods_pt_pt where virtuemart_paymentmethod_id = virtuemart_paymentmethod_id limit 1), '') pagamento,
            IFNULL((select shipment_name from d2e0b_virtuemart_shipmentmethods_pt_pt where virtuemart_shipmentmethod_id = virtuemart_shipmentmethod_id limit 1), '') envio
		FROM 
			d2e0b_virtuemart_orders 
		WHERE 
			virtuemart_order_id > $last_order
		";
		
		$query = $this->db->query($str_sql);
		$indice = 10000;
		
		$encomendas = array();
		
		foreach ($query->result_array() as $row ) 
		{
			$str_sql2 = 
				"
				select 
					A.virtuemart_product_id obrano,
					A.order_item_sku ref,
					convert(A.order_item_name, char(60)) design,
					A.product_quantity qtt,
					A.product_item_price edebito,
					A.product_subtotal_discount desconto 
				FROM 
					d2e0b_virtuemart_order_items A 
				WHERE 
					A.virtuemart_order_id = " . $row["obrano"] . "
				";
			
			$query2 = $this->db->query( $str_sql2 );
			
			$itens = array();
			
			foreach ($query2->result_array() as $row2 ) 
			{
				$row2["lordem"] = $indice;
				$itens[] = $row2;
				$indice += 10000;
			}
			
			$itens[] = array
				(
				"obrano"=>$row["obrano"], 
				"ref"=>"PRO2431", 
				"design"=>"Portes", 
				"qtt"=>"1.0", 
				"edebito"=>$row["order_shipment"], 
				"desconto"=>"0.0",
				"lordem"=>$indice
				);
			
			$row["Itens"] = $itens;
			$encomendas[] = $row;
		}
		
    	return $encomendas;
    }
	
	function save() 
	{
		$this->db->where( 'virtuemart_order_id', $this->fields['virtuemart_order_id'] );
		$query = $this->db->update( 'd2e0b_virtuemart_orders', $this->fields);
		
		if ( $query ) 
		{
			return true;
		}
		else
		{
			 $this->WriteLog( "Falhou Gravar Estado Encomenda d2e0b_virtuemart_orders - " . $this->fields["virtuemart_order_id"] );
			 return false;
		}
    }
}


?>