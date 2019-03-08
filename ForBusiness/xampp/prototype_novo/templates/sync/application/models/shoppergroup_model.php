<?php

class Shoppergroup_model extends CI_Model {
	
    var $fields = array();
	var $fields2 = array();
	var $exists = 0;

	function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function get ( $cliente ) 
	{
    	$query = $this->db->get_where( 'jos_virtuemart_shoppergroups', array( 'shopper_group_name' => $cliente ) );

    	if ( $query->num_rows() > 0 ) 
		{
    		foreach( $query->result_array() as $row ) 
			{
                $this->fields = $row; 
				$this->exists = 1;
                return $this;
            }
    	}
		
    	return $this;
    }

	function WriteLog($message)
	{
		$f = fopen("MyLog.txt", "a");
		fwrite($f, date("Y-m-d H:i:s") . " - " . print_r($message,true) . "\n");
		fclose($f);
	}
	
    function save( $insert = false ) 
	{
    	if ( $insert ) 
		{
			$query = $this->db->insert( 'jos_virtuemart_shoppergroups', $this->fields );
			if ( $query ) 
			{
				return $this->db->insert_id();
			}
			else
			{
				return 0;
			}
    	} 
		else 
		{
			$this->db->where( 'virtuemart_shoppergroup_id', $this->fields['virtuemart_shoppergroup_id'] );
			$query = $this->db->update( 'jos_virtuemart_shoppergroups', $this->fields );
			return $query;
        }
    }
	
	function attach_price( $artigo, $shopper_id, $desconto )
	{		
	
		$query = $this->db->get_where( 'jos_virtuemart_products', array('product_sku' => $artigo) );
		if( $query->num_rows() > 0 )
		{
			$row = $query->row_array();
			$prod_id = $row["virtuemart_product_id"];	
			$prod_price = 0;
			
			$query = $this->db->get_where( 'jos_virtuemart_product_prices', array('virtuemart_product_id' => $prod_id, 'virtuemart_shoppergroup_id' => 0) );
			if( $query->num_rows() > 0 ) 
			{
				$row = $query->row_array();
				$prod_price = $row["product_price"];
			}
	
			$query = $this->db->get_where( 'jos_virtuemart_product_prices', array('virtuemart_product_id' => $prod_id, 'virtuemart_shoppergroup_id' => $shopper_id) );
			
			if( $query->num_rows() > 0 ) //update
			{
				$this->fields2 = $query->row_array();
				$this->fields2["product_price"] = $prod_price * (1 - (intval($desconto)/100) );
				
				$this->db->trans_start();
				$this->db->where( 'virtuemart_product_price_id', $this->fields2["virtuemart_product_price_id"] );
				$query = $this->db->update( 'jos_virtuemart_product_prices', $this->fields2);
				
				if ( $query ) 
				{
					$this->db->trans_complete();
				}
				else
				{
					 $this->db->trans_rollback();
					 $this->WriteLog( "Falhou Gravar Update Preco jos_virtuemart_product_prices - " . $artigo );
					 return false;
				}
			}
			else //insert
			{
						
				$this->db->trans_start();
								
				$this->fields2["virtuemart_product_price_id"] = null;
				$this->fields2["product_price"] = $prod_price * (1 - (intval($desconto)/100) );
				$this->fields2["virtuemart_shoppergroup_id"] = $shopper_id;
				$this->fields2["virtuemart_product_id"] = $prod_id;
				
				$query = $this->db->insert( 'jos_virtuemart_product_prices', $this->fields2);
				if ( $query ) 
				{
					$id = $this->db->insert_id();
					$this->db->trans_complete();
				}
				else
				{
					 $this->db->trans_rollback();
					 $this->WriteLog( "Falhou Gravar Novo Preco jos_virtuemart_product_prices - " . $artigo );
					 return false;
				}
			}
		}
	}

	function attach_shopper_group( $shopper_id, $cliente )
	{		
		$query = $this->db->get_where( 'jos_users', array('phc_no' => $cliente) );
		if( $query->num_rows() > 0 )
		{
			$row = $query->row_array();
			$user_id = $row["id"];
	
			$query = $this->db->get_where( 'jos_virtuemart_vmuser_shoppergroups', array('virtuemart_user_id' => $user_id, 'virtuemart_shoppergroup_id' => $shopper_id) );				
			if( $query->num_rows() > 0 ) //update
			{
			}
			else //insert
			{
				$this->db->trans_start();

				$query = $this->db->insert( 'jos_virtuemart_vmuser_shoppergroups', array('virtuemart_user_id' => $user_id, 'virtuemart_shoppergroup_id' => $shopper_id));	
				if ( $query ) 
				{
					$this->db->trans_complete();
				}
				else
				{
					 $this->db->trans_rollback();
					 $this->WriteLog( "Falhou Gravar Novo Shoppergroup no user jos_virtuemart_vmuser_shoppergroups - " . $cliente );
					 return false;
				}
			}
		}
	}
}


?>