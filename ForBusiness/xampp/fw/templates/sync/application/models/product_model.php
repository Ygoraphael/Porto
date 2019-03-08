<?php

class Product_model extends CI_Model {
	
	var $fields = array();		//products
	var $fields2 = array();		//products_pt_pt
	var $fields3 = array();		//categories
	var $fields4 = array();		//prices
	var $fields5 = array();		//medias
	var $fields6 = array();		//prod media
	var $fields7 = array();		//products_en_gb
	var $fields8 = array();		//product_customfields
	var $fields9 = array();		//modalidade,genero,linha,categoria
	var $fields10 = array();	//cor,tamanho
	var $fields11 = array();	//filtros modalidade
	var $fields12 = array();	//filtros categoria
	
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
		$value = $this->db->get('e506s_virtuemart_products')->row()->modified_on;
		
		if(!is_null($value))
			return $value;
		else
			return "1900-01-01 00:00:00";
	}

    function get_parent ( $ref ) 
	{
    	$query = $this->db->get_where( 'e506s_virtuemart_products', array( 'phc_ref' => $ref) );

    	if ( $query->num_rows() > 0 ) 
		{
    		foreach( $query->result_array() as $row ) 
			{
				$this->exists = 1;
                $this->fields = $row; 
                return $this;
            }
    	}
    	return $this;
    }
	
	function get ( $ref ) 
	{
    	$query = $this->db->get_where( 'e506s_virtuemart_products', array( 'product_sku' => $ref) );

    	if ( $query->num_rows() > 0 ) 
		{
    		foreach( $query->result_array() as $row ) 
			{
				$this->exists = 1;
                $this->fields = $row; 
                return $this;
            }
    	}
    	return $this;
    }

	function attach_price( $preco )
	{
		$this->fields4['virtuemart_product_id'] = $this->fields["virtuemart_product_id"];
		$this->fields4["virtuemart_shoppergroup_id"] = 0;
		$this->fields4["product_price"] = $preco;
		$this->fields4["override"] = 0;
		$this->fields4["product_override_price"] = 0;
		$this->fields4["product_tax_id"] = 0;
		$this->fields4["product_discount_id"] = 0;
		$this->fields4["product_currency"] = 47;
		$this->fields4['created_on'] = $this->fields["created_on"];
		$this->fields4['created_by'] = 0;
		$this->fields4['modified_on'] = $this->fields["modified_on"];
		$this->fields4['modified_by'] = 0;
		$this->fields4['locked_on'] = '0000-00-00 00:00:00';
		$this->fields4['locked_by'] = 0;
		
		$query = $this->db->get_where( 'e506s_virtuemart_product_prices', array('virtuemart_product_id' => $this->fields["virtuemart_product_id"]) );
		
		if( $query->num_rows() > 0 ) //update
		{
			$row = $query->row_array();
			$id = $row["virtuemart_product_price_id"];
			
			$this->db->trans_start();
			$this->db->where( 'virtuemart_product_price_id', $id );
			$query = $this->db->update( 'e506s_virtuemart_product_prices', $this->fields4);
			
			if ( $query ) 
			{
				$this->db->trans_complete();
			}
			else
			{
				 $this->db->trans_rollback();
				 $this->WriteLog( "Falhou Gravar Update Preco e506s_virtuemart_product_prices - " . $this->fields['virtuemart_product_id'] );
				 return false;
			}
		}
		else //insert
		{
			$this->db->trans_start();
			$query = $this->db->insert( 'e506s_virtuemart_product_prices', $this->fields4);	
			if ( $query ) 
			{
				$id = $this->db->insert_id();
				$this->db->trans_complete();
			}
			else
			{
				 $this->db->trans_rollback();
				 $this->WriteLog( "Falhou Gravar Novo Preco e506s_virtuemart_product_prices - " . $this->fields['virtuemart_product_id'] );
				 return false;
			}
		}
	}
	
	function save_ggl1()
	{	
		$query = $this->db->get_where( 'e506s_fastseller_product_type_4', array('product_id' => $this->fields["virtuemart_product_id"]) );
		
		if( $query->num_rows() > 0 ) //update
		{
			$row = $query->row_array();
			
			$this->db->trans_start();
			$this->db->where( 'product_id', $this->fields["virtuemart_product_id"] );
			$query = $this->db->update( 'e506s_fastseller_product_type_4', $this->fields9);
			
			if ( $query ) 
			{
				$this->db->trans_complete();
			}
			else
			{
				 $this->db->trans_rollback();
				 $this->WriteLog( "Falhou Gravar Update Modalidade Genero Linha Categoria e506s_fastseller_product_type_4 - " . $this->fields['virtuemart_product_id'] );
				 return false;
			}
		}
		else //insert
		{
			$this->db->trans_start();
			$query = $this->db->insert( 'e506s_fastseller_product_type_4', $this->fields9);	
			if ( $query ) 
			{
				$this->db->trans_complete();
			}
			else
			{
				 $this->db->trans_rollback();
				 $this->WriteLog( "Falhou Gravar Novo Modalidade Genero Linha Categoria e506s_fastseller_product_type_4 - " . $this->fields['virtuemart_product_id'] );
				 return false;
			}
		}
	}
	
	function save_modalidade()
	{
		$query = $this->db->get_where( 'e506s_filtros', array('nome' => 'modalidade', 'pt_pt' => $this->fields11["pt_pt"]) );
		if( $query->num_rows() > 0 ) //update
		{
			$this->db->trans_start();
			
			$this->db->where( 'nome', 'modalidade' );
			$this->db->where( 'pt_pt', $this->fields11["pt_pt"] );
			$query = $this->db->update( 'e506s_filtros', $this->fields11);
			
			if ( $query ) 
			{
				$this->db->trans_complete();
			}
			else
			{
				 $this->db->trans_rollback();
				 $this->WriteLog( "Falhou Gravar Update Modalidade Genero Linha Categoria e506s_filtros" );
				 return false;
			}
		}
		else //insert
		{
			$this->db->trans_start();
			
			$query = $this->db->insert( 'e506s_filtros', $this->fields11);	
			if ( $query ) 
			{
				$this->db->trans_complete();
			}
			else
			{
				 $this->db->trans_rollback();
				 $this->WriteLog( "Falhou Gravar Novo Modalidade Genero Linha Categoria e506s_filtros" );
				 return false;
			}
		}
	}
	
	function save_categoria()
	{
		$query = $this->db->get_where( 'e506s_filtros', array('nome' => 'categoria', 'pt_pt' => $this->fields12["pt_pt"]) );
		if( $query->num_rows() > 0 ) //update
		{
			$this->db->trans_start();
			
			$this->db->where( 'nome', 'categoria' );
			$this->db->where( 'pt_pt', $this->fields12["pt_pt"] );
			$query = $this->db->update( 'e506s_filtros', $this->fields12);
			
			if ( $query ) 
			{
				$this->db->trans_complete();
			}
			else
			{
				 $this->db->trans_rollback();
				 $this->WriteLog( "Falhou Gravar Update Modalidade Genero Linha Categoria e506s_filtros" );
				 return false;
			}
		}
		else //insert
		{
			$this->db->trans_start();
			
			$query = $this->db->insert( 'e506s_filtros', $this->fields12);	
			if ( $query ) 
			{
				$this->db->trans_complete();
			}
			else
			{
				 $this->db->trans_rollback();
				 $this->WriteLog( "Falhou Gravar Novo Modalidade Genero Linha Categoria e506s_filtros" );
				 return false;
			}
		}
	}
	
	function save_ggl2()
	{	
		$grelha = explode("|||", $this->fields10["Cor"]);
		$tam = $grelha[2];
		$cor = $grelha[3];
		
		$this->fields10["product_id"] = $this->fields["virtuemart_product_id"];
		$this->fields10["Cor"] = $cor;
		$this->fields10["Tamanho"] = $tam;
		$this->fields10["sinc"] = 1;
		
		$query = $this->db->get_where( 'e506s_fastseller_product_type_3', array('product_id' => $this->fields["virtuemart_product_id"], 'Cor' => $cor, 'Tamanho' => $tam) );
		
		if( $query->num_rows() > 0 ) //update
		{
			$row = $query->row_array();
			
			$this->db->trans_start();
			$this->db->where( 'product_id', $this->fields["virtuemart_product_id"] );
			$query = $this->db->update( 'e506s_fastseller_product_type_3', $this->fields10);
			
			if ( $query ) 
			{
				$this->db->trans_complete();
			}
			else
			{
				 $this->db->trans_rollback();
				 $this->WriteLog( "Falhou Gravar Update Cor Tamanho e506s_fastseller_product_type_3 - " . $this->fields['virtuemart_product_id'] );
				 return false;
			}
		}
		else //insert
		{
			$this->db->trans_start();
			$query = $this->db->insert( 'e506s_fastseller_product_type_3', $this->fields10);	
			if ( $query ) 
			{;
				$this->db->trans_complete();
			}
			else
			{
				 $this->db->trans_rollback();
				 $this->WriteLog( "Falhou Gravar Novo Cor Tamanho e506s_fastseller_product_type_3 - " . $this->fields['virtuemart_product_id'] );
				 return false;
			}
		}
	}
	
	function attach_media( $imagem, $ordering )
	{
		if(trim($imagem) != "")
		{
			$this->fields5["virtuemart_vendor_id"] = 1;
			$this->fields5["file_title"] = $imagem;
			$this->fields5["file_description"] = '';
			$this->fields5["file_meta"] = '';
			$this->fields5["file_type"] = 'product';
			$this->fields5["file_url"] = 'images/stories/virtuemart/product/'.$imagem;
			
			$tmp_array = explode(".", $imagem);
			$tipo = $tmp_array[sizeof($tmp_array) - 1];
			
			if($tipo == "jpg")
				$this->fields5["file_mimetype"] = 'image/jpeg';
			else if ($tipo == "png")
				$this->fields5["file_mimetype"] = 'image/png';
			else if ($tipo == "gif")
				$this->fields5["file_mimetype"] = 'image/gif';
			
			$this->fields5["file_url_thumb"] = '';
			$this->fields5["file_is_product_image"] = 0;
			$this->fields5["file_is_downloadable"] = 0;
			$this->fields5["file_is_forSale"] = 0;
			$this->fields5["file_params"] = '';
			$this->fields5["file_lang"] = '';
			$this->fields5["shared"] = 0;
			$this->fields5["published"] = 1;
			$this->fields5["created_on"] = '0000-00-00 00:00:00';
			$this->fields5["created_by"] = 0;
			$this->fields5["modified_on"] = '0000-00-00 00:00:00';
			$this->fields5["modified_by"] = 0;
			$this->fields5["locked_on"] = '0000-00-00 00:00:00';
			$this->fields5["locked_by"] = 0;
				
			$query = $this->db->get_where( 'e506s_virtuemart_medias', array('file_title' => $imagem, 'file_type' => 'product') );
			if( $query->num_rows() > 0 ) //update
			{
				$row = $query->row_array();
				$id = $row["virtuemart_media_id"];
				
				$this->db->trans_start();
				$this->db->where( 'virtuemart_media_id', $id );
				$query = $this->db->update( 'e506s_virtuemart_medias', $this->fields5);
				
				if ( $query ) 
				{
					$this->db->trans_complete();
				}
				else
				{
					 $this->db->trans_rollback();
					 $this->WriteLog( "Falhou Gravar Update Media e506s_virtuemart_medias - " . $this->fields['virtuemart_product_id'] );
					 return false;
				}
			}
			else //insert
			{
				$this->db->trans_start();
				$query = $this->db->insert( 'e506s_virtuemart_medias', $this->fields5);	
				if ( $query ) 
				{
					$id = $this->db->insert_id();
					$this->db->trans_complete();
				}
				else
				{
					 $this->db->trans_rollback();
					 $this->WriteLog( "Falhou Gravar Nova Media e506s_virtuemart_medias - " . $this->fields['virtuemart_product_id'] );
					 return false;
				}
			}
			
			$this->fields6["virtuemart_product_id"] = $this->fields['virtuemart_product_id'];
			$this->fields6["virtuemart_media_id"] = $id;
			$this->fields6["ordering"] = $ordering;
			
			$query = $this->db->get_where( 'e506s_virtuemart_product_medias', array('virtuemart_product_id' => $this->fields['virtuemart_product_id'], 'ordering' => $ordering) );
			if( $query->num_rows() > 0 ) //update
			{
				$this->db->trans_start();
				$this->db->where( array('virtuemart_product_id' => $this->fields['virtuemart_product_id'], 'ordering' => $ordering) );
				$query = $this->db->update( 'e506s_virtuemart_product_medias', $this->fields6);
				
				if ( $query ) 
				{
					$this->db->trans_complete();		
					return true;
				}
				else
				{
					 $this->db->trans_rollback();
					 $this->WriteLog( "Falhou Gravar Update Media e506s_virtuemart_product_medias - " . $this->fields['virtuemart_product_id'] );
					 return false;
				}
			}
			else //insert
			{
				$this->db->trans_start();
				$query = $this->db->insert( 'e506s_virtuemart_product_medias', $this->fields6);	
				if ( $query ) 
				{
					$this->db->trans_complete();		
					return true;
				}
				else
				{
					 $this->db->trans_rollback();
					 $this->WriteLog( "Falhou Gravar Nova Media e506s_virtuemart_product_medias - " . $this->fields['virtuemart_product_id'] );
					 return false;
				}
			}
		}
		else
		{
			$str_sql = "delete from `e506s_virtuemart_product_medias` where virtuemart_product_id = ".$this->fields['virtuemart_product_id']." and ordering = ".$ordering;
			$this->db->query($str_sql);
		}
	}
	
    function save( $insert = false ) 
	{
    	if ( $insert ) 
		{
			$this->db->trans_start();
    		$query = $this->db->insert( 'e506s_virtuemart_products', $this->fields );
			
    		if ( $query ) 
			{
				$id = $this->db->insert_id();
				
				//$f = fopen("tiago.txt", "a");
				//fwrite($f, print_r($id, true));
				//fclose($f);
				
				$this->fields['virtuemart_product_id'] = $id;
				$this->fields2['virtuemart_product_id'] = $id;
				$this->fields7['virtuemart_product_id'] = $id;
				$this->fields3['virtuemart_product_id'] = $id;
				
				$query = $this->db->insert( 'e506s_virtuemart_products_pt_pt', $this->fields2 );	
				
				if ( $query ) 
				{
					$query = $this->db->insert( 'e506s_virtuemart_products_en_gb', $this->fields7 );	
						
					if ( $query ) 
					{
						$query = $this->db->insert( 'e506s_virtuemart_product_categories', $this->fields3 );	
						
						if ( $query ) 
						{
							if (array_key_exists('custom_param', $this->fields8)) {
								$grelha = explode("|||", $this->fields8['custom_param']);
								
								$tam = 	$grelha[0];
								$cor = 	$grelha[1];
								
								$query = $this->db->query( 'select * from e506s_virtuemart_product_customfields where virtuemart_product_id = ' . $this->fields8['virtuemart_product_id'] );
								if( $query->num_rows() > 0 ) //update
								{
									$row = $query->row_array();
									$custom_param = $row["custom_param"];
									if ( strlen(trim($custom_param)) != 0 ) 
									{
										$custom_param = substr($custom_param, 0, strlen($custom_param) - 2);
										$custom_param = $custom_param . ', "'.$id.'":{"is_variant":"1", "selectoptions1":"'.$tam.'", "selectoptions2":"'.$cor.'", "custom_price":""}}}';
										$this->fields8['custom_param'] = $custom_param;
									}
									else
									{
										$custom_param = '{"child":{"'.$id.'":{"is_variant":"1", "selectoptions1":"'.$tam.'", "selectoptions2":"'.$cor.'", "custom_price":""}}}';
										$this->fields8['custom_param'] = $custom_param;
									}
									
									$this->db->where( 'virtuemart_product_id', $this->fields8['virtuemart_product_id'] );
									$query = $this->db->update( 'e506s_virtuemart_product_customfields', $this->fields8);
									if ( $query ) 
									{
										$this->db->trans_complete();
										return true;
									}
									else
									{
										 $this->db->trans_rollback();
										 $this->WriteLog( "Falhou Gravar Update Artigo e506s_virtuemart_product_customfields - " . $this->fields["product_sku"] );
										 return false;
									}
								}
								else {
									$this->fields8['custom_param'] = '{"child":{"'.$id.'":{"is_variant":"1", "selectoptions1":"'.$tam.'", "selectoptions2":"'.$cor.'", "custom_price":""}}}';
									
									$query = $this->db->insert( 'e506s_virtuemart_product_customfields', $this->fields8);	
									if ( $query ) 
									{
										$this->db->trans_complete();
										return true;
									}
									else
									{
										 $this->db->trans_rollback();
										 $this->WriteLog( "Falhou Gravar Update Artigo e506s_virtuemart_product_customfields - " . $this->fields["product_sku"] );
										 return false;
									}
								}
							}
							else 
							{
								$this->db->trans_complete();
										return true;
							}
						}
						else
						{
							 $this->db->trans_rollback();
							 $this->WriteLog( "Falhou Gravar Novo Artigo e506s_virtuemart_categories - " . $this->fields["product_sku"] );
							 return false;
						}
					}
					else
					{
						$this->db->trans_rollback();
						$this->WriteLog( "Falhou Gravar Novo Artigo e506s_virtuemart_products_en_gb - " . $this->fields["product_sku"] );
						return false;
					}
				}
				else
				{
					 $this->db->trans_rollback();
					 $this->WriteLog( "Falhou Gravar Novo Artigo e506s_virtuemart_products_pt_pt - " . $this->fields["product_sku"] );
					 return false;
				}
			}
			else
			{
				 $this->db->trans_rollback();
				 $this->WriteLog( "Falhou Gravar Novo Artigo e506s_virtuemart_products - " . $this->fields["product_sku"] );
				 return false;
			}
    	} 
		else 
		{
			$this->db->trans_start();
			
    		$this->db->where( 'virtuemart_product_id', $this->fields['virtuemart_product_id'] );
			$query = $this->db->update( 'e506s_virtuemart_products', $this->fields);
			
			if ( $query ) 
			{
				$this->db->where( 'virtuemart_product_id', $this->fields['virtuemart_product_id'] );
				$query = $this->db->update( 'e506s_virtuemart_products_pt_pt', $this->fields2);
				
				if ( $query ) 
				{
					$this->db->where( 'virtuemart_product_id', $this->fields['virtuemart_product_id'] );
					$query = $this->db->update( 'e506s_virtuemart_products_en_gb', $this->fields7);
					
					if ( $query ) 
					{
						$this->db->where( 'virtuemart_product_id', $this->fields['virtuemart_product_id'] );
						$query = $this->db->update( 'e506s_virtuemart_product_categories', $this->fields3);	
							
						if ( $query ) 
						{
							if (array_key_exists('custom_param', $this->fields8)) {
								$grelha = explode("|||", $this->fields8['custom_param']);
								
								$tam = 	$grelha[0];
								$cor = 	$grelha[1];
								
								$query = $this->db->query( 'select * from e506s_virtuemart_product_customfields where virtuemart_product_id = ' . $this->fields8['virtuemart_product_id'] );
								if( $query->num_rows() > 0 ) //update
								{
									$row = $query->row_array();
									$custom_param = $row["custom_param"];
									if ( strlen(trim($custom_param)) != 0 ) 
									{
										$custom_param = substr($custom_param, 0, strlen($custom_param) - 2);
										$custom_param = $custom_param . ', "'.$this->fields['virtuemart_product_id'].'":{"is_variant":"1", "selectoptions1":"'.$tam.'", "selectoptions2":"'.$cor.'", "custom_price":""}}}';
										$this->fields8['custom_param'] = $custom_param;
									}
									else
									{
										$custom_param = '{"child":{"'.$this->fields['virtuemart_product_id'].'":{"is_variant":"1", "selectoptions1":"'.$tam.'", "selectoptions2":"'.$cor.'", "custom_price":""}}}';
										$this->fields8['custom_param'] = $custom_param;
									}
									
									$this->db->where( 'virtuemart_product_id', $this->fields8['virtuemart_product_id'] );
									$query = $this->db->update( 'e506s_virtuemart_product_customfields', $this->fields8);
									if ( $query ) 
									{
										$this->db->trans_complete();
										return true;
									}
									else
									{
										 $this->db->trans_rollback();
										 $this->WriteLog( "Falhou Gravar Update Artigo e506s_virtuemart_product_customfields - " . $this->fields["product_sku"] );
										 return false;
									}
								}
								else {
									$this->fields8['custom_param'] = '{"child":{"'.$this->fields['virtuemart_product_id'].'":{"is_variant":"1", "selectoptions1":"'.$tam.'", "selectoptions2":"'.$cor.'", "custom_price":""}}}';
									
									$query = $this->db->insert( 'e506s_virtuemart_product_customfields', $this->fields8);	
									if ( $query ) 
									{
										$this->db->trans_complete();
										return true;
									}
									else
									{
										 $this->db->trans_rollback();
										 $this->WriteLog( "Falhou Gravar Update Artigo e506s_virtuemart_product_customfields - " . $this->fields["product_sku"] );
										 return false;
									}
								}
							}
							else 
							{
								$this->db->trans_complete();
										return true;
							}
						}
						else
						{
							 $this->db->trans_rollback();
							 $this->WriteLog( "Falhou Gravar Novo Artigo e506s_virtuemart_categories - " . $this->fields["product_sku"] );
							 return false;
						}
					}
					else
					{
						 $this->db->trans_rollback();
						 $this->WriteLog( "Falhou Gravar Update Artigo e506s_virtuemart_products_en_gb - " . $this->fields["product_sku"] );
						 return false;
					}				
				}
				else
				{
					 $this->db->trans_rollback();
					 $this->WriteLog( "Falhou Gravar Update Artigo e506s_virtuemart_products_pt_pt - " . $this->fields["product_sku"] );
					 return false;
				}
			}
			else
			{
				 $this->db->trans_rollback();
				 $this->WriteLog( "Falhou Gravar Update Artigo e506s_virtuemart_products - " . $this->fields["product_sku"] );
				 return false;
			}
    	}
    }
}


?>