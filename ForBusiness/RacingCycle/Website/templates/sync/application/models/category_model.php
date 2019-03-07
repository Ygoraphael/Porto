<?php

class Category_model extends CI_Model {

	var $exists = 0;
	var $fields = array();
	var $fields2 = array();
	var $fields3 = array();
	var $fields4 = array();
	var $fields5 = array();
	var $fields6 = array();
	
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

	function get_max_mdate()
	{
		$this->db->select_max('modified_on');
		$value = $this->db->get('d2e0b_virtuemart_categories')->row()->modified_on;
		
		if(!is_null($value))
			return $value;
		else
			return "1900-01-01 00:00:00";
	}
	
    function get( $ref ) 
	{
    	$query = $this->db->get_where( 'd2e0b_virtuemart_categories', array('phc_ref' => $ref) );
    	
    	if( $query->num_rows() > 0 ) 
		{
    		foreach( $query->result_array() as $row ) 
			{
				$this->exists = 1;
                $this->fields = $row;
				
				$query = $this->db->get_where( 'd2e0b_virtuemart_categories_pt_pt', array('virtuemart_category_id' => $row["virtuemart_category_id"]) );
				if( $query->num_rows() > 0 ) 
				{
					foreach( $query->result_array() as $row2 ) 
					{
						$this->fields2 = $row2;
						break;
					}
				}
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
	
	function attach_media( $imagem )
	{
		if(trim($imagem) != "")
		{
			$this->fields5["virtuemart_vendor_id"] = 1;
			$this->fields5["file_title"] = $imagem;
			$this->fields5["file_description"] = '';
			$this->fields5["file_meta"] = '';
			$this->fields5["file_type"] = 'category';
			$this->fields5["file_url"] = 'images/stories/virtuemart/category/'.$imagem;
			
			$tmp_array = explode(".", $imagem);
			$tipo = $tmp_array[sizeof($tmp_array) - 1];
			
			if($tipo == "JPG")
				$this->fields5["file_mimetype"] = 'image/jpeg';
			else if ($tipo == "PNG")
				$this->fields5["file_mimetype"] = 'image/png';
			else if ($tipo == "GIF")
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
				
			$query = $this->db->get_where( 'd2e0b_virtuemart_medias', array('file_title' => $imagem) );
			if( $query->num_rows() > 0 ) //update
			{
				$row = $query->row_array();
				$id = $row["virtuemart_media_id"];
				
				$this->db->trans_start();
				$this->db->where( 'virtuemart_media_id', $id );
				$query = $this->db->update( 'd2e0b_virtuemart_medias', $this->fields5);
				
				if ( $query ) 
				{
					$this->db->trans_complete();
				}
				else
				{
					 $this->db->trans_rollback();
					 $this->WriteLog( "Falhou Gravar Update Media d2e0b_virtuemart_medias - " . $this->fields['virtuemart_category_id'] );
					 return false;
				}
			}
			else //insert
			{
				$this->db->trans_start();
				$query = $this->db->insert( 'd2e0b_virtuemart_medias', $this->fields5);	
				if ( $query ) 
				{
					$id = $this->db->insert_id();
					$this->db->trans_complete();
				}
				else
				{
					 $this->db->trans_rollback();
					 $this->WriteLog( "Falhou Gravar Nova Media d2e0b_virtuemart_medias - " . $this->fields['virtuemart_category_id'] );
					 return false;
				}
			}
			
			$this->fields4["virtuemart_category_id"] = $this->fields['virtuemart_category_id'];
			$this->fields4["virtuemart_media_id"] = $id;
			$this->fields4["ordering"] = 0;
			
			$query = $this->db->get_where( 'd2e0b_virtuemart_category_medias', array('virtuemart_category_id' => $this->fields['virtuemart_category_id']) );
			if( $query->num_rows() > 0 ) //update
			{
				$this->db->trans_start();
				$this->db->where( 'virtuemart_category_id', $this->fields['virtuemart_category_id'] );
				$query = $this->db->update( 'd2e0b_virtuemart_category_medias', $this->fields4);
				
				if ( $query ) 
				{
					$this->db->trans_complete();		
					return true;
				}
				else
				{
					 $this->db->trans_rollback();
					 $this->WriteLog( "Falhou Gravar Update Media d2e0b_virtuemart_category_medias - " . $this->fields['virtuemart_category_id'] );
					 return false;
				}
			}
			else //insert
			{
				$this->db->trans_start();
				$query = $this->db->insert( 'd2e0b_virtuemart_category_medias', $this->fields4);	
				if ( $query ) 
				{
					$this->db->trans_complete();		
					return true;
				}
				else
				{
					 $this->db->trans_rollback();
					 $this->WriteLog( "Falhou Gravar Nova Media d2e0b_virtuemart_category_medias - " . $this->fields['virtuemart_category_id'] );
					 return false;
				}
			}
		}
	}

    function save( $insert = false ) 
	{
    	if ( $insert ) 
		{
			$this->db->trans_start();
    		$query = $this->db->insert( 'd2e0b_virtuemart_categories', $this->fields );
			
    		if ( $query ) 
			{
				$id = $this->db->insert_id();
				$this->fields['virtuemart_category_id'] = $id;
				$this->fields2['virtuemart_category_id'] = $id;
				$this->fields6['virtuemart_category_id'] = $id;
				error_log("Insert Familia ptpt");
				$query = $this->db->insert( 'd2e0b_virtuemart_categories_pt_pt', $this->fields2);	
				
				if ( $query ) 
				{
				    error_log("Entra Familia eng1");
				    
					$query = $this->db->insert( 'd2e0b_virtuemart_categories_en_gb', $this->fields6);	
				
					if ( $query ) 
					{error_log("Entra Familia eng2");
						$this->db->trans_complete();
						return true;
					}
					else
					{
					    error_log("Entra Familia eng3");
						 $this->db->trans_rollback();
						 $this->WriteLog( "Falhou Gravar Nova Familia d2e0b_virtuemart_categories_en_gb - " . $this->fields["phc_ref"] );
						 return false;
					}
				}
				else
				{error_log("Entra Familia eng4");
					 $this->db->trans_rollback();
					 $this->WriteLog( "Falhou Gravar Nova Familia d2e0b_virtuemart_categories_pt_pt - " . $this->fields["phc_ref"] );
					 return false;
				}
			}
			else
			{
			    error_log("Entra Familia eng5");
				 $this->db->trans_rollback();
				 $this->WriteLog( "Falhou Gravar Nova Familia d2e0b_virtuemart_categories - " . $this->fields["phc_ref"] );
				 return false;
			}
    	} 
		else 
		{
			$this->db->trans_start();
			
    		$this->db->where( 'virtuemart_category_id', $this->fields['virtuemart_category_id'] );
    		
			$query = $this->db->update( 'd2e0b_virtuemart_categories', $this->fields);
			
			if ( $query ) 
			{
				$this->db->where( 'virtuemart_category_id', $this->fields['virtuemart_category_id'] );
				$query = $this->db->update( 'd2e0b_virtuemart_categories_pt_pt', $this->fields2);
				
				if ( $query ) 
				{
					$this->db->where( 'virtuemart_category_id', $this->fields['virtuemart_category_id'] );
					$query = $this->db->update( 'd2e0b_virtuemart_categories_en_gb', $this->fields6);
					
					if ( $query ) 
					{
						$this->db->trans_complete();
						return true;
					}
					else
					{
						 $this->db->trans_rollback();
						 $this->WriteLog( "Falhou Gravar Update Familia d2e0b_virtuemart_categories_en_gb - " . $this->fields["phc_ref"] );
						 return false;
					}
				}
				else
				{
					 $this->db->trans_rollback();
					 $this->WriteLog( "Falhou Gravar Update Familia d2e0b_virtuemart_categories_pt_pt - " . $this->fields["phc_ref"] );
					 return false;
				}
			}
			else
			{
				 $this->db->trans_rollback();
				 $this->WriteLog( "Falhou Gravar Update Familia d2e0b_virtuemart_categories - " . $this->fields["phc_ref"] );
				 return false;
			}
    	}
    }
	
	function save_relations( )
	{
		$query = $this->db->get_where( 'd2e0b_virtuemart_category_categories', array('category_child_id' => $this->fields3['category_child_id']) );
		if( $query->num_rows() > 0 ) //update
		{
			$this->db->trans_start();
			$this->db->where( 'category_child_id', $this->fields3['category_child_id'] );
			$query = $this->db->update( 'd2e0b_virtuemart_category_categories', $this->fields3);
			
			if ( $query ) 
			{
				$this->db->trans_complete();
				return true;
			}
			else
			{
				 $this->db->trans_rollback();
				 $this->WriteLog( "Falhou Gravar Update Relacao Familia d2e0b_virtuemart_category_categories - " . $this->fields3['category_child_id'] );
				 return false;
			}
    	}
		else //insert
		{
			$this->db->trans_start();
			$query = $this->db->insert( 'd2e0b_virtuemart_category_categories', $this->fields3 );
			
			if ( $query ) 
			{
				$this->db->trans_complete();
				return true;
			}
			else
			{
				 $this->db->trans_rollback();
				 $this->WriteLog( "Falhou Gravar Nova Relacao Familia d2e0b_virtuemart_category_categories - " . $this->fields3['category_child_id'] );
				 return false;
			}
		}
	}
	
	function get_id_by_ref($ref, $refcat = "")
	{
		
		$query = $this->db->get_where( 'd2e0b_virtuemart_categories', array('phc_ref' => $ref) );
    	
    	if( $query->num_rows() > 0 ) 
		{
    		foreach( $query->result_array() as $row ) 
			{
                return $row["virtuemart_category_id"];
            }
    	}
		
    	return 0;
	}

}

?>