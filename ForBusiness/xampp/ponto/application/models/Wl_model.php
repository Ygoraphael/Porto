<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model class.
 * 
 * @extends CI_Model
 */
class Wl_model extends CI_Model {

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
	
	public function get_ppickups_mssql_product( $no, $bostamp ) {
		$query = "
			select *
			from u_ppickup (nolock)
			inner join bo on u_ppickup.bostamp = bo.bostamp
			inner join u_pickup on u_ppickup.u_pickupstamp = u_pickup.u_pickupstamp
			where 
				bo.no = " . $no . " and
				bo.bostamp = '" . $bostamp . "'
			order by u_pickup.name
		";
		$query = $this->mssql->mssql__select( $query );
		return $query;
	}
	
	public function get_related_products_mssql( $bostamp ) {
		$query = "
			select Top 4 *,ISNULL((select top 1 img from u_pimg where u_pimg.bostamp = bo.bostamp order by NEWID()),'') img
			from u_relprod (nolock)
				inner join bo (nolock) on u_relprod.relprodbostamp = bo.bostamp
				inner join bo3 (nolock) on u_relprod.relprodbostamp = bo3.bo3stamp
			where 
				u_relprod.bostamp = '".$bostamp."'
			order by
				NEWID()
			";
		$query = $this->mssql->mssql__select( $query );
		return $query;
	}
	
	public function get_product_taxes_mssql( $bostamp ) {
		$query = "
			select * 
			from u_ptax
			inner join u_tax on u_ptax.u_taxstamp = u_tax.u_taxstamp
			where
				u_ptax.bostamp = '" . $bostamp . "'
			order by u_ptax.tax
		";

		$result = $this->mssql->mssql__select( $query );
		return $result;
	}
	
	public function get_product_taxes( $bostamp ) {
		$this->db->select('*');
		$this->db->from('u_ptax');
		$this->db->join('u_tax', 'u_ptax.u_taxstamp = u_tax.u_taxstamp');
		$this->db->where('u_ptax.bostamp', $bostamp);
		$query = $this->db->get();
		$query = $query->result_array();
		
		return $query;
	}
	
	public function get_iva_mssql() {
		$query = "
			select *
			from taxasiva
			where taxa <> 0
			order by codigo
		";

		$result = $this->mssql->mssql__select( $query );
		return $result;
	}
	
	public function get_iva() {
		$this->db->select('*');
		$this->db->from('taxasiva');
		$this->db->order_by('codigo');
		$query = $this->db->get();
		$query = $query->result_array();
		
		return $query;
	}
	
	public function set_wl_var( &$data, $op ) {
		$wl_data = $this->wl_model->get_wl_data( $op );
		
		if( sizeof($wl_data) > 0 ) {
			$op_data = $this->wl_model->get_operator_data( $wl_data['no'] );
			$slider_img = $this->wl_model->get_wl_img( $wl_data['id'] );
			
			//qual o template
			switch( $wl_data['template'] ) {
				case 'Template 1':
					$this->template->set_template('wl_layout1');
					break;
				case 'Template 2':
					$this->template->set_template('wl_layout2');
					break;
				default:
					$this->template->set_template('wl_layout1');
					break;
			}
			
			//qual o title
			$data["title"] = $op_data['nome'];
			//dados op
			$data["morada"] = $op_data['morada'];
			$data["codpost"] = $op_data['codpost'];
			$data["local"] = $op_data['local'];
			$data["pais"] = $op_data['pais'];
			$data["telefone"] = $op_data['telefone'];
			//menu
			$data["menu"] = $wl_data['menu'];
			//qual o bg color
			$data["headfoot_color"] = $wl_data['headfoot_color'];
			$data["bg_color"] = $wl_data['bg_color'];
			//menu font color
			$data["menu_font_color"] = $wl_data['menu_font_color'];
			//qual o bg color do conteudo
			$data["bg_content_color"] = $wl_data['content_color'];
			//qual a font a usar
			$data["fontfamily"] = $wl_data['fontfamily'];
			//qual o logo
			$data["logo"] = $wl_data['logo'];
			$data["slider"] = $slider_img;
			//qual os items do menu		
			$data["slidervideo"] = $wl_data['slidervideo'];
			$data["customcss"] = $wl_data['customcss'];
			$data["sliderproducts"] = $wl_data['sliderproducts'];
			$data["booknowproducts"] = $wl_data['booknowproducts'];
			$data["sliderproduct"] = $wl_data['sliderproduct'];
			$data["sliderimage"] = $wl_data['sliderimage'];
			$data["listgridbut"] = $wl_data['listgridbut'];
			$data["filtersactive"] = $wl_data['filtersactive'];
			$data["cur_page"] = $this->uri->segment(3);
			
			$data["op_existe"] = 1;
		}
		else {
			$data["op_existe"] = 0;
		}
	}
	
	public function get_wl_img( $id ) {
		$this->db->select('*');
		$this->db->from('u_wlimg');
		$this->db->where('wl_id', $id);
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function get_operator_data( $no ) {
		$this->db->select('*');
		$this->db->from('fl');
		$this->db->where('no', $no);
		$this->db->where('estab', 0);
		$query = $this->db->get()->row_array();
		return $query;
	}
	
	public function get_wl_data( $id ) {
		$this->db->select('*');
		$this->db->from('u_whitelabel');
		$this->db->where('no', $id);
		$query = $this->db->get()->row_array();
		return $query; 
	}
	
	public function get_filters( $operator, $parametros) {
		$dates = array();
		$categories = array();
		$destinations = array();
		$cities = array();
		$languages = array();
		$duration = array();
		$search_str = array();

		if( sizeof($parametros) > 0 ) {
			foreach($parametros as $key=>$value) {
				switch ($key) {
					case 'da':
						$dates = explode('|', trim($value));
						break;
					case 'c':
						$categories = explode('|', trim($value));
						break;
					case 'd':
						$destinations = explode('|', trim($value));
						break;
					case 'dc':
						$cities = explode('|', trim($value));
						break;
					case 'l':
						$languages = explode('|', trim($value));
						break;
					case 'du':
						$duration = explode('|', trim($value));
						break;
					case 's':
						$search_str = trim($value);
						$search_str = explode(' ', $search_str);
						break;
				}
			}
		}

		$filters = array();
		
		//destinations
		$this->db->select('bo3.u_country');
		$this->db->distinct();
		$this->db->from('bo');
		$this->db->join('bo2', 'bo.bostamp = bo2.bo2stamp');
		$this->db->join('bo3', 'bo.bostamp = bo3.bo3stamp');
		$this->db->where('u_country !=', '');
		$this->db->where('bo.ndos = 1');
		$this->db->where('bo.no', $operator);
		$this->db->order_by('u_country', 'ASC');
		$query = $this->db->get();
		$tmp = array();
		foreach( $query->result_array() as $row ) {
			$tmp[] = $row["u_country"];
		}
		$filters["destinations"] = $tmp;
		$filters["destinations_filtered"] = $destinations;
		
		//cities
		$this->db->select('bo3.u_city');
		$this->db->distinct();
		$this->db->from('bo');
		$this->db->join('bo2', 'bo.bostamp = bo2.bo2stamp');
		$this->db->join('bo3', 'bo.bostamp = bo3.bo3stamp');
		$this->db->where('u_city !=', '');
		$this->db->where('bo.ndos = 1');
		$this->db->where('bo.no', $operator);
		$this->db->order_by('u_city', 'ASC');
		$query = $this->db->get();
		$tmp = array();
		foreach( $query->result_array() as $row ) {
			$tmp[] = $row["u_city"];
		}
		$filters["cities"] = $tmp;
		$filters["cities_filtered"] = $cities;
		
		//categories
		$this->db->select('u_pcateg.category');
		$this->db->distinct();
		$this->db->from('u_pcateg');
		$this->db->join('bo', 'bo.bostamp = u_pcateg.bostamp');
		$this->db->where('bo.no', $operator);
		$this->db->order_by('category', 'ASC');
		$query = $this->db->get();
		$tmp = array();
		foreach( $query->result_array() as $row ) {
			$tmp[] = $row["category"];
		}
		$filters["categories"] = $tmp;
		$filters["categories_filtered"] = $categories;
		
		//languages
		$this->db->select('u_plang.language');
		$this->db->distinct();
		$this->db->from('u_plang');
		$this->db->join('bo', 'bo.bostamp = u_plang.bostamp');
		$this->db->where('bo.no', $operator);
		$this->db->order_by('language', 'ASC');
		$query = $this->db->get();
		$tmp = array();
		foreach( $query->result_array() as $row ) {
			$tmp[] = $row["language"];
		}
		$filters["languages"] = $tmp;
		$filters["languages_filtered"] = $languages;
		
		//duration
		$tmp = array('1', '2', '3', '4', '5');
		$filters["duration"] = $tmp;
		$filters["duration_filtered"] = $duration;
		
		//search_string
		$filters["search_str"] = $search_str;
		
		return $filters;
	}
	
	public function get_products( $operator, $filters ,$limit = "", $start = "") {
 		$this->db->limit($limit, $start);
		
		$this->db->select("
		bo.*,
		bo2.*,
		bo3.*,
		IFNULL((select img from u_pimg where u_pimg.bostamp = bo.bostamp LIMIT 1),'') img
		");
		$this->db->distinct();
		$this->db->from('bo');
		$this->db->join('bo2', 'bo.bostamp = bo2.bo2stamp');
		$this->db->join('bo3', 'bo.bostamp = bo3.bo3stamp');
		$this->db->join('u_pcateg', 'bo.bostamp = u_pcateg.bostamp', 'left');
		$this->db->join('u_plang', 'bo.bostamp = u_plang.bostamp', 'left');
		$this->db->where('bo.ndos = 1');
		$this->db->where('bo.no', $operator);
		
		//destinations
		if( sizeof($filters["destinations_filtered"])>0 ) {
			$tmp_string = "(";
			foreach( $filters["destinations_filtered"] as $destination ) {
				$tmp_string .= 'bo3.u_country =' . $this->db->escape($destination) . ' OR ';
			}
			$tmp_string = substr($tmp_string, 0, strlen($tmp_string)-3) . ')';
			$this->db->where($tmp_string);
		}
		
		//cities
		if( sizeof($filters["cities_filtered"])>0 ) {
			$tmp_string = "(";
			foreach( $filters["cities_filtered"] as $cities ) {
				$tmp_string .= 'bo3.u_city =' . $this->db->escape($cities) . ' OR ';
			}
			$tmp_string = substr($tmp_string, 0, strlen($tmp_string)-3) . ')';
			$this->db->where($tmp_string);
		}
		//categories
		if( sizeof($filters["categories_filtered"])>0 ) {
			$tmp_string = "(";
			foreach( $filters["categories_filtered"] as $category ) {
				$tmp_string .= 'u_pcateg.category =' . $this->db->escape($category) . ' OR ';
			}
			$tmp_string = substr($tmp_string, 0, strlen($tmp_string)-3) . ')';
			$this->db->where($tmp_string);
		}
		
		//languages
		if( sizeof($filters["languages_filtered"])>0 ) {
			$tmp_string = "(";
			foreach( $filters["languages_filtered"] as $language ) {
				$tmp_string .= 'u_plang.language =' . $this->db->escape($language) . ' OR ';
			}
			$tmp_string = substr($tmp_string, 0, strlen($tmp_string)-3) . ')';
			$this->db->where($tmp_string);
		}
		
		//duration
		if( sizeof($filters["duration_filtered"])>0 ) {
			$tmp_string = "(";
			foreach( $filters["duration_filtered"] as $duration ) {
				switch($duration) {
					case '1':
						$tmp_string .= 'case bo3.u_estidurt when \'Days\' then bo3.u_estimdur*24 when \'Minutes\' then bo3.u_estimdur/60 else bo3.u_estimdur end >= 0 AND case bo3.u_estidurt when \'Days\' then bo3.u_estimdur*24 when \'Minutes\' then bo3.u_estimdur/60 else bo3.u_estimdur end <= 3 OR ';
						break;
					case '2':
						$tmp_string .= 'case bo3.u_estidurt when \'Days\' then bo3.u_estimdur*24 when \'Minutes\' then bo3.u_estimdur/60 else bo3.u_estimdur end >= 3 AND case bo3.u_estidurt when \'Days\' then bo3.u_estimdur*24 when \'Minutes\' then bo3.u_estimdur/60 else bo3.u_estimdur end <= 5 OR ';
						break;
					case '3':
						$tmp_string .= 'case bo3.u_estidurt when \'Days\' then bo3.u_estimdur*24 when \'Minutes\' then bo3.u_estimdur/60 else bo3.u_estimdur end >= 5 AND case bo3.u_estidurt when \'Days\' then bo3.u_estimdur*24 when \'Minutes\' then bo3.u_estimdur/60 else bo3.u_estimdur end <= 7 OR ';
						break;
					case '4':
						$tmp_string .= 'case bo3.u_estidurt when \'Days\' then bo3.u_estimdur*24 when \'Minutes\' then bo3.u_estimdur/60 else bo3.u_estimdur end >= 7 AND case bo3.u_estidurt when \'Days\' then bo3.u_estimdur*24 when \'Minutes\' then bo3.u_estimdur/60 else bo3.u_estimdur end <= 24 OR ';
						break;
					case '5':
						$tmp_string .= 'case bo3.u_estidurt when \'Days\' then bo3.u_estimdur*24 when \'Minutes\' then bo3.u_estimdur/60 else bo3.u_estimdur end >= 24 OR';
						break;
				}
			}
			$tmp_string = substr($tmp_string, 0, strlen($tmp_string)-3) . ')';
			$this->db->where($tmp_string);
		}
		
		//search_string
		foreach( $filters["search_str"] as $search_val ) {
			$this->db->where( " (bo3.u_country like '%" . $search_val . "%' or bo3.u_city like '%" . $search_val . "%' or bo.u_name like '%" . $search_val . "%' or u_pcateg.category like '%" . $search_val . "%' ) " );
		}
		
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function get_lastminute_taxes( $bostamp ) {
		$this->db->select("
		u_tax.*
		");
		$this->db->from('u_lastminute');
		$this->db->join('u_tax', 'u_lastminute.u_taxstamp = u_tax.u_taxstamp');
		$this->db->where('u_lastminute.bostamp', $bostamp);
		
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function get_lastminute_products( $operator, $filters ) {
		$this->db->select("
		bo.*,
		bo2.*,
		bo3.*,
		IFNULL((select img from u_pimg where u_pimg.bostamp = bo.bostamp LIMIT 1),'') img
		");
		$this->db->distinct();
		$this->db->from('bo');
		$this->db->join('bo2', 'bo.bostamp = bo2.bo2stamp');
		$this->db->join('bo3', 'bo.bostamp = bo3.bo3stamp');
		$this->db->join('u_lastminute', 'bo.bostamp = u_lastminute.bostamp');
		$this->db->join('u_pcateg', 'bo.bostamp = u_pcateg.bostamp', 'left');
		$this->db->join('u_plang', 'bo.bostamp = u_plang.bostamp', 'left');
		$this->db->where('bo.ndos = 1');
		$this->db->where('bo.no', $operator);
		
		//destinations
		if( sizeof($filters["destinations_filtered"])>0 ) {
			$tmp_string = "(";
			foreach( $filters["destinations_filtered"] as $destination ) {
				$tmp_string .= 'bo3.u_country =' . $this->db->escape($destination) . ' OR ';
			}
			$tmp_string = substr($tmp_string, 0, strlen($tmp_string)-3) . ')';
			$this->db->where($tmp_string);
		}
		
		//cities
		if( sizeof($filters["cities_filtered"])>0 ) {
			$tmp_string = "(";
			foreach( $filters["cities_filtered"] as $city ) {
				$tmp_string .= 'bo3.u_city =' . $this->db->escape($city) . ' OR ';
			}
			$tmp_string = substr($tmp_string, 0, strlen($tmp_string)-3) . ')';
			$this->db->where($tmp_string);
		}
		
		//categories
		if( sizeof($filters["categories_filtered"])>0 ) {
			$tmp_string = "(";
			foreach( $filters["categories_filtered"] as $category ) {
				$tmp_string .= 'u_pcateg.category =' . $this->db->escape($category) . ' OR ';
			}
			$tmp_string = substr($tmp_string, 0, strlen($tmp_string)-3) . ')';
			$this->db->where($tmp_string);
		}
		
		//languages
		if( sizeof($filters["languages_filtered"])>0 ) {
			$tmp_string = "(";
			foreach( $filters["languages_filtered"] as $language ) {
				$tmp_string .= 'u_plang.language =' . $this->db->escape($language) . ' OR ';
			}
			$tmp_string = substr($tmp_string, 0, strlen($tmp_string)-3) . ')';
			$this->db->where($tmp_string);
		}
		
		//duration
		if( sizeof($filters["duration_filtered"])>0 ) {
			$tmp_string = "(";
			foreach( $filters["duration_filtered"] as $duration ) {
				switch($duration) {
					case '1':
						$tmp_string .= 'case bo3.u_estidurt when \'Days\' then bo3.u_estimdur*24 when \'Minutes\' then bo3.u_estimdur/60 else bo3.u_estimdur end >= 0 AND case bo3.u_estidurt when \'Days\' then bo3.u_estimdur*24 when \'Minutes\' then bo3.u_estimdur/60 else bo3.u_estimdur end <= 3 OR ';
						break;
					case '2':
						$tmp_string .= 'case bo3.u_estidurt when \'Days\' then bo3.u_estimdur*24 when \'Minutes\' then bo3.u_estimdur/60 else bo3.u_estimdur end >= 3 AND case bo3.u_estidurt when \'Days\' then bo3.u_estimdur*24 when \'Minutes\' then bo3.u_estimdur/60 else bo3.u_estimdur end <= 5 OR ';
						break;
					case '3':
						$tmp_string .= 'case bo3.u_estidurt when \'Days\' then bo3.u_estimdur*24 when \'Minutes\' then bo3.u_estimdur/60 else bo3.u_estimdur end >= 5 AND case bo3.u_estidurt when \'Days\' then bo3.u_estimdur*24 when \'Minutes\' then bo3.u_estimdur/60 else bo3.u_estimdur end <= 7 OR ';
						break;
					case '4':
						$tmp_string .= 'case bo3.u_estidurt when \'Days\' then bo3.u_estimdur*24 when \'Minutes\' then bo3.u_estimdur/60 else bo3.u_estimdur end >= 7 AND case bo3.u_estidurt when \'Days\' then bo3.u_estimdur*24 when \'Minutes\' then bo3.u_estimdur/60 else bo3.u_estimdur end <= 24 OR ';
						break;
					case '5':
						$tmp_string .= 'case bo3.u_estidurt when \'Days\' then bo3.u_estimdur*24 when \'Minutes\' then bo3.u_estimdur/60 else bo3.u_estimdur end >= 24 OR';
						break;
				}
			}
			$tmp_string = substr($tmp_string, 0, strlen($tmp_string)-3) . ')';
			$this->db->where($tmp_string);
		}
		
		//search_string
		foreach( $filters["search_str"] as $search_val ) {
			$this->db->where( " (bo3.u_country like '%" . $search_val . "%' or bo3.u_city like '%" . $search_val . "%' or bo.u_name like '%" . $search_val . "%' or u_pcateg.category like '%" . $search_val . "%' ) " );
		}
		
		$this->db->order_by('u_lastminute.lorder', 'ASC');
		
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function operator_get_products( $operator ) {
		$this->db->select("
		bo.*,
		bo2.*,
		bo3.*
		");
		$this->db->distinct();
		$this->db->from('bo');
		$this->db->join('bo2', 'bo.bostamp = bo2.bo2stamp');
		$this->db->join('bo3', 'bo.bostamp = bo3.bo3stamp');
		$this->db->where('bo.ndos = 1');
		$this->db->where('bo.no', $operator);
		
		$query = $this->db->get();
		$query = $query->result_array();
		return $query;
	}
	
	public function get_products_top( $operator ) {
		$this->db->select("
		bo.*,
		bo2.*,
		bo3.*,
		u_pimg.*
		");
		$this->db->distinct();
		$this->db->from('bo');
		$this->db->join('bo2', 'bo.bostamp = bo2.bo2stamp');
		$this->db->join('bo3', 'bo.bostamp = bo3.bo3stamp');
		$this->db->join('u_pimg', 'bo.bostamp = u_pimg.bostamp');
		$this->db->where('bo.ndos = 1');
		$this->db->where('bo.no', $operator);
		$this->db->where('bo3.u_listtop = 1');
		$this->db->group_by('bo.bostamp'); 
		
		$query = $this->db->get();
		$query = $query->result_array();
		return $query;
	}	
	
	public function get_lastminute_product( $bostamp ) {
		$this->db->select("
		*  
		");
		$this->db->from('u_lastminute ');
		$this->db->join('u_tax ', 'u_lastminute.u_taxstamp = u_tax.u_taxstamp ');
		$this->db->where('u_lastminute.bostamp', $bostamp);
		$query = $this->db->get();
		$query = $query->result_array();
		return $query;
	}
	
	public function get_category($operator) {
		$this->db->select('
		*,(SELECT img FROM u_pimg where u_pimg.bostamp = bo.bostamp ORDER BY RAND() LIMIT 1) as img
		');
		$this->db->from('u_pcateg');
		$this->db->join('bo', 'u_pcateg.bostamp = bo.bostamp');
		$this->db->group_by('category');
		$this->db->where('bo.ndos = 1');
		$this->db->where('bo.no', $operator);
		$this->db->limit(12, 0);
		$query = $this->db->get();
		$query = $query->result_array();
		return $query;
	}
	
	public function get_topdest($operator) {
		$this->db->select('u_city,(SELECT img FROM u_pimg where u_pimg.bostamp = bo.bostamp ORDER BY RAND() LIMIT 1) as img');
		$this->db->from('bo');
		$this->db->join('bo3', 'bo.bostamp = bo3.bo3stamp');
		$this->db->where('bo.ndos = 1');
		$this->db->where("bo3.u_city <>  ''");
		$this->db->where('bo.no', $operator);
		$this->db->group_by('u_city');
		$this->db->limit(12, 0);
		$query = $this->db->get();
		$query = $query->result_array();
		return $query;
	}
	
	public function operator_get_product_mssql( $operator, $sefurl ) {
		$query = "
			select bo.*, bo2.*, bo3.*
			from bo 
				inner join bo2 on bo.bostamp = bo2.bo2stamp
				inner join bo3 on bo.bostamp = bo3.bo3stamp
			where 
				bo3.u_sefurl = '".$sefurl."' and 
				bo.ndos = 1 and
				bo.no = ".$operator."
			";
		$query = $this->mssql->mssql__select( $query );
		return $query;
	}
	
	public function operator_get_session_mssql( $operator, $sefurl ) {
		$query = "
			select u_psess.*
			from u_psess 
				inner join bo on u_psess.bostamp = bo.bostamp
				inner join bo3 on bo.bostamp = bo3.bo3stamp
			where 
				bo3.u_sefurl = '".$sefurl."' and 
				bo.ndos = 1 and
				bo.no = ".$operator."
			";
		$query = $this->mssql->mssql__select( $query );
		return $query;
	}
	
	public function operator_get_product( $operator, $sefurl ) {
		$this->db->select("
		bo.*,
		bo2.*,
		bo3.*
		");
		$this->db->distinct();
		$this->db->from('bo');
		$this->db->join('bo2', 'bo.bostamp = bo2.bo2stamp');
		$this->db->join('bo3', 'bo.bostamp = bo3.bo3stamp');
		$this->db->where('bo.ndos = 1');
		$this->db->where('bo.no', $operator);
		$this->db->where('bo3.u_sefurl', $sefurl);
		
		$query = $this->db->get();
		$query = $query->result_array();
		return $query;
	}
	
	public function operator_get_session( $operator, $sefurl ) {
		$this->db->select("
		u_psess.*
		");
		$this->db->distinct();
		$this->db->from('u_psess');
		$this->db->join('bo', 'u_psess.bostamp = bo.bostamp');
		$this->db->join('bo3', 'bo.bostamp = bo3.bo3stamp');
		$this->db->where('bo.ndos = 1');
		$this->db->where('bo.no', $operator);
		$this->db->where('bo3.u_sefurl', $sefurl);
		
		$query = $this->db->get();
		$query = $query->result_array();
		return $query;
	}
	
	public function get_product_data( $operator, $sefurl ) {
		$this->db->select('
		bo.*,
		bo2.*,
		bo3.*
		');
		$this->db->from('bo');
		$this->db->join('bo2', 'bo.bostamp = bo2.bo2stamp');
		$this->db->join('bo3', 'bo.bostamp = bo3.bo3stamp');
		$this->db->where('bo3.u_sefurl', $sefurl);
		$this->db->where('bo.ndos = 1');
		$this->db->where('bo.no', $operator);
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function get_product_data_stamp( $bostamp ) {
		$this->db->select('
		bo.*,
		bo2.*,
		bo3.*
		');
		$this->db->from('bo');
		$this->db->join('bo2', 'bo.bostamp = bo2.bo2stamp');
		$this->db->join('bo3', 'bo.bostamp = bo3.bo3stamp');
		$this->db->where('bo.bostamp', $bostamp);
		$this->db->where('bo.ndos = 1');
		$query = $this->db->get();
		$query = $query->result_array();
		
		if( sizeof($query) > 0 )
			return $query[0];
		else
			return $query[0];
	}
	
	public function get_tickets() {
		$this->db->select('
		u_tick.*
		');
		$this->db->from('u_tick');
		$this->db->order_by('ticket', 'ASC');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function get_product_tickets( $sefurl ) {
		$this->db->select('
		u_ptick.*
		');
		$this->db->from('bo');
		$this->db->join('bo2', 'bo.bostamp = bo2.bo2stamp');
		$this->db->join('bo3', 'bo.bostamp = bo3.bo3stamp');
		$this->db->join('u_ptick', 'bo.bostamp = u_ptick.bostamp');
		$this->db->where('bo3.u_sefurl', $sefurl);
		$this->db->where('bo.ndos = 1');
		$this->db->order_by('ticket', 'ASC');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function get_product_tickets_mssql( $sefurl ) {
		$query = "
			select u_ptick.* 
			from bo 
				inner join bo2 on bo.bostamp = bo2.bo2stamp
				inner join bo3 on bo.bostamp = bo3.bo3stamp
				inner join u_ptick on bo.bostamp = u_ptick.bostamp
			where 
				bo3.u_sefurl = '".$sefurl."' and 
				bo.ndos = 1
			order by
				ticket ASC
			";
		$query = $this->mssql->mssql__select( $query );
		return $query;
	}
	
	public function get_product_tickets_numbers( $sefurl ) {
		$this->db->select('
		u_pntick.*
		');
		$this->db->from('bo');
		$this->db->join('bo2', 'bo.bostamp = bo2.bo2stamp');
		$this->db->join('bo3', 'bo.bostamp = bo3.bo3stamp');
		$this->db->join('u_pntick', 'bo.bostamp = u_pntick.bostamp');
		$this->db->where('bo3.u_sefurl', $sefurl);
		$this->db->where('bo.ndos = 1');
		$this->db->order_by('no', 'ASC');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function get_product_seats( $sefurl ) {
		$this->db->select('
		u_pseat.*
		');
		$this->db->from('bo');
		$this->db->join('bo2', 'bo.bostamp = bo2.bo2stamp');
		$this->db->join('bo3', 'bo.bostamp = bo3.bo3stamp');
		$this->db->join('u_pseat', 'bo.bostamp = u_pseat.bostamp');
		$this->db->where('bo3.u_sefurl', $sefurl);
		$this->db->where('bo.ndos = 1');
		$this->db->order_by('seat', 'ASC');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function get_product_extras( $sefurl ) {
		$this->db->select('
		u_prec.*
		');
		$this->db->from('bo');
		$this->db->join('bo2', 'bo.bostamp = bo2.bo2stamp');
		$this->db->join('bo3', 'bo.bostamp = bo3.bo3stamp');
		$this->db->join('u_prec', 'bo.bostamp = u_prec.bostamp');
		$this->db->where('bo3.u_sefurl', $sefurl);
		$this->db->where('bo.ndos = 1');
		$this->db->where('u_prec.extra = 1');
		$this->db->order_by('design', 'ASC');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function get_product_categories( $sefurl ) {
		$this->db->select('
		u_pcateg.*
		');
		$this->db->from('bo');
		$this->db->join('bo2', 'bo.bostamp = bo2.bo2stamp');
		$this->db->join('bo3', 'bo.bostamp = bo3.bo3stamp');
		$this->db->join('u_pcateg', 'bo.bostamp = u_pcateg.bostamp');
		$this->db->where('bo3.u_sefurl', $sefurl);
		$this->db->where('bo.ndos = 1');
		$this->db->order_by('category', 'ASC');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function get_product_seats_mssql( $sefurl ) {
		$query = "
			select u_pseat.* 
			from bo 
				inner join bo2 on bo.bostamp = bo2.bo2stamp
				inner join bo3 on bo.bostamp = bo3.bo3stamp
				inner join u_pseat on bo.bostamp = u_pseat.bostamp
			where 
				bo3.u_sefurl = '".$sefurl."' and 
				bo.ndos = 1
			order by
				CONVERT(VARCHAR(254), seat) ASC
			";
		$query = $this->mssql->mssql__select( $query );
		return $query;
	}
	
	public function get_product_prices_by_ref( $ref ) {
		$this->db->select('
		sx.*
		');
		$this->db->from('sx');
		$this->db->where('sx.ref', $ref);
		$this->db->order_by('cor', 'ASC');
		$this->db->order_by('tam', 'ASC');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function update_product_price( $data ) {
		foreach( $data["prices"] as $price ) {
			$update_values = array();
			$update_values[] = $price[2];
			$update_values[] = $price[2] * 200.482;
			$update_values[] = $price[0];
			$update_values[] = $price[1];
			
			$update_values[] = $data["ref"];
			
			$query = "update sx set epv1 = ?, pv1 = ? where cor = ? and tam = ? and ref = ?";
			$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
		}
		
		$result = array();
		$result["success"] = 1;
		$result["message"] = "Product's prices updated successfully";
		
		echo json_encode( $result );
	}
	
	public function get_product_img( $sefurl ) {
		$this->db->select('
		u_pimg.*
		');
		$this->db->from('bo');
		$this->db->join('bo2', 'bo.bostamp = bo2.bo2stamp');
		$this->db->join('bo3', 'bo.bostamp = bo3.bo3stamp');
		$this->db->join('u_pimg', 'bo.bostamp = u_pimg.bostamp');
		$this->db->where('bo3.u_sefurl', $sefurl);
		$this->db->where("u_pimg.img <> ''");
		$this->db->where('bo.ndos = 1');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function get_countries(  ) {
		$this->db->select('*');
		$this->db->from('u_countries');
		$this->db->order_by('printable_name', 'ASC');
		$query = $this->db->get();
		return $query->result_array();
	}
	
	public function search_product( $query_search ) {
		
		$query_search = trim($query_search);
		$query_search = explode(' ', $query_search);
		
		$result_array = array();
		
		// paises
		$this->db->select('bo3.u_country label, bo3.u_country id');
		$this->db->distinct();
		$this->db->from('bo');
		$this->db->join('bo2', 'bo.bostamp = bo2.bo2stamp');
		$this->db->join('bo3', 'bo.bostamp = bo3.bo3stamp');
		$this->db->where('bo.ndos = 1');
		foreach( $query_search as $search_val ) {
			$this->db->where( " (bo3.u_country like '%" . $search_val . "%') " );
		}

		$query = $this->db->get();
		$result_array = $query->result_array();
		
		// cidades
		$this->db->select('bo3.u_city label, bo3.u_city id');
		$this->db->distinct();
		$this->db->from('bo');
		$this->db->join('bo2', 'bo.bostamp = bo2.bo2stamp');
		$this->db->join('bo3', 'bo.bostamp = bo3.bo3stamp');
		$this->db->where('bo.ndos = 1');
		foreach( $query_search as $search_val ) {
			$this->db->where( " (bo3.u_city like '%" . $search_val . "%') " );
		}

		$query = $this->db->get();
		$result_array = array_merge($result_array, $query->result_array());
		
		// categorias
		$this->db->select('u_pcateg.category label, u_pcateg.category id');
		$this->db->distinct();
		$this->db->from('bo');
		$this->db->join('bo2', 'bo.bostamp = bo2.bo2stamp');
		$this->db->join('bo3', 'bo.bostamp = bo3.bo3stamp');
		$this->db->join('u_pcateg', 'bo.bostamp = u_pcateg.bostamp');
		$this->db->where('bo.ndos = 1');
		foreach( $query_search as $search_val ) {
			$this->db->where( " (u_pcateg.category like '%" . $search_val . "%') " );
		}

		$query = $this->db->get();
		$result_array = array_merge($result_array, $query->result_array());
		
		// artigos
		$this->db->select('bo.u_name label, bo.bostamp id');
		$this->db->from('bo');
		$this->db->join('bo2', 'bo.bostamp = bo2.bo2stamp');
		$this->db->join('bo3', 'bo.bostamp = bo3.bo3stamp');
		$this->db->where('bo.ndos = 1');
		foreach( $query_search as $search_val ) {
			$this->db->where( " (bo3.u_country like '%" . $search_val . "%' or bo3.u_city like '%" . $search_val . "%' or bo.u_name like '%" . $search_val . "%') " );
		}

		$query = $this->db->get();
		$result_array = array_merge($result_array, $query->result_array());
		return $result_array;
	}
	
	public function cria_grelha_mssql( $cor, $tam, $ref, $u_pseatstamp, $u_ptickstamp, $preço = -1 ) {
		//verificar se grelha ja existe
		$query = "select * from sx where ref = '".$ref."' and cor = '".$cor."' and tam = '".$tam."'";
		$query = $this->mssql->mssql__select( $query );
		
		//se nao existir, cria
		if( sizeof($query) == 0 ) {
			$update_values = array();
			$update_values[] = $ref;
			$update_values[] = $cor;
			$update_values[] = $tam;
			if( $preço > -1 ) {
				$update_values[] = $preço;
				$update_values[] = $preço * 200.482;
			}
			else {
				$update_values[] = 0;
				$update_values[] = 0;
			}
			$update_values[] = $ref;
			
			$query = "insert into sx (
				sxstamp,
				stock,
				ref,
				armazem,
				cor,
				tam,
				epv1,
				pv1,
				ststamp,
				ousrdata,
				ousrhora,
				ousrinis,
				usrdata,
				usrhora,
				usrinis
			) values (
				CONVERT(VARCHAR(25), (select UPPER(suser_sname())+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5))),
				0,
				?,
				1,
				?,
				?,
				?,
				?,
				isnull((select ststamp from st where ref = ?), ''),
				CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
				CONVERT(VARCHAR(5), GETDATE(), 8), 
				UPPER(suser_sname()), 
				CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
				CONVERT(VARCHAR(5), GETDATE(), 8),
				UPPER(suser_sname())
			) 
			";
			
			$sql_status2 = $this->mssql->mssql__prepare_exec( $query, $update_values );
		}
		
		//verificar se cor ja existe no sgc
		$query = "select * from sgc where ref = '".$ref."' and cor = '".$cor."'";
		$query = $this->mssql->mssql__select( $query );
		
		//se nao existir, cria
		if( sizeof($query) == 0 ) {
			$update_values = array();
			$update_values[] = $ref;
			$update_values[] = $cor;
			$update_values[] = $ref;
			$update_values[] = $u_pseatstamp;
			
			$query = "insert into sgc (
				sgcstamp,
				ref,
				cor,
				ststamp,
				u_pseat,
				ousrdata,
				ousrhora,
				ousrinis,
				usrdata,
				usrhora,
				usrinis
			) values (
				CONVERT(VARCHAR(25), (select UPPER(suser_sname())+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5))),
				?,
				?,
				isnull((select ststamp from st where ref = ?), ''),
				?,
				CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
				CONVERT(VARCHAR(5), GETDATE(), 8), 
				UPPER(suser_sname()), 
				CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
				CONVERT(VARCHAR(5), GETDATE(), 8),
				UPPER(suser_sname())
			) 
			";
			
			$sql_status2 = $this->mssql->mssql__prepare_exec( $query, $update_values );
		}
		
		//verificar se tam ja existe no sgc
		$query = "select * from sgt where ref = '".$ref."' and tam = '".$tam."'";
		$query = $this->mssql->mssql__select( $query ); 
		
		//se nao existir, cria
		if( sizeof($query) == 0 ) {
			$update_values = array();
			$update_values[] = $ref;
			$update_values[] = $tam;
			$update_values[] = $ref;
			$update_values[] = $u_ptickstamp;
			
			$query = "insert into sgt (
				sgtstamp,
				ref,
				tam,
				ststamp,
				u_ptick,
				ousrdata,
				ousrhora,
				ousrinis,
				usrdata,
				usrhora,
				usrinis
			) values (
				CONVERT(VARCHAR(25), (select UPPER(suser_sname())+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5))),
				?,
				?,
				isnull((select ststamp from st where ref = ?), ''),
				?,
				CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
				CONVERT(VARCHAR(5), GETDATE(), 8), 
				UPPER(suser_sname()), 
				CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
				CONVERT(VARCHAR(5), GETDATE(), 8),
				UPPER(suser_sname())
			) 
			";
			
			$sql_status2 = $this->mssql->mssql__prepare_exec( $query, $update_values );
		}
	}
	
	public function apaga_tam( $u_tickstamp, $bostamp ) {
		$query = "select bo.obrano, u_sefurl from bo inner join bo3 on bo.bostamp = bo3.bo3stamp where bostamp = '".$bostamp."'";
		$query = $this->mssql->mssql__select( $query );
		$obrano = $query[0]["obrano"];
		
		$query = "select ticket, u_tickstamp from u_tick where u_tickstamp = '".$u_tickstamp."'";
		$query = $this->mssql->mssql__select( $query );
		$tam = $query[0]["ticket"];
		$u_tickstamp = $query[0]["u_tickstamp"];
		
		$query = "select ref from st where ref like 'P.".$obrano.".%'";
		$refs = $this->mssql->mssql__select( $query );
		
		//apagar de u_ptick
		$update_values = array();
		$update_values[] = $u_tickstamp;
		$update_values[] = $bostamp;
		
		$query = "delete from u_ptick where u_tickstamp = ? and bostamp = ?";
		$sql_status2 = $this->mssql->mssql__prepare_exec( $query, $update_values );
		
		foreach( $refs as $ref ) {
			//apagar de sgt
			$update_values = array();
			$update_values[] = $ref['ref'];	
			$update_values[] = $tam;	

			$query = "delete from sgt where ref = ? and tam = ?";
			$sql_status2 = $this->mssql->mssql__prepare_exec( $query, $update_values );
			
			//apagar de sx
			$update_values = array();
			$update_values[] = $ref['ref'];	
			$update_values[] = $tam;	
			$query = "delete from sx where ref = ? and tam = ?";
			$sql_status2 = $this->mssql->mssql__prepare_exec( $query, $update_values );
		}
	}
	
	public function cria_tam( $u_tickstamp, $custom_name, $bostamp ) {
		$query = "select bo.obrano, u_sefurl from bo inner join bo3 on bo.bostamp = bo3.bo3stamp where bostamp = '".$bostamp."'";
		$query = $this->mssql->mssql__select( $query );
		$obrano = $query[0]["obrano"];
		$u_sefurl = $query[0]["u_sefurl"];
		
		$query = "select id, ticket, u_tickstamp from u_tick where u_tickstamp = '".$u_tickstamp."'";
		$query = $this->mssql->mssql__select( $query );
		$tam = $query[0]["ticket"];
		$u_tickstamp = $query[0]["u_tickstamp"];
		$id = $query[0]["id"];
		
		$query = "select ref from st where ref like 'P.".$obrano.".%'";
		$refs = $this->mssql->mssql__select( $query );
		
		$cores = $this->get_product_seats( $u_sefurl );
		
		// u_ptick
		$query = "select * from u_ptick where u_tickstamp = '".$u_tickstamp."' and bostamp = '".$bostamp."'";
		$query = $this->mssql->mssql__select( $query );
		
		//se nao existir, cria
		if( sizeof($query) == 0 ) {
			$update_values = array();
			$update_values[] = $u_tickstamp;
			$update_values[] = $bostamp;
			$update_values[] = $id;
			$update_values[] = $tam;
			$update_values[] = $custom_name;
			
			$query = "insert into u_ptick (
				u_ptickstamp,
				u_tickstamp,
				bostamp,
				id,
				ticket,
				name,
				ousrdata,
				ousrhora,
				ousrinis,
				usrdata,
				usrhora,
				usrinis
			) values (
				CONVERT(VARCHAR(25), (select UPPER(suser_sname())+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5))),
				?,
				?,
				?,
				?,
				?,
				CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
				CONVERT(VARCHAR(5), GETDATE(), 8), 
				UPPER(suser_sname()), 
				CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
				CONVERT(VARCHAR(5), GETDATE(), 8),
				UPPER(suser_sname())
			) 
			";
			
			$sql_status2 = $this->mssql->mssql__prepare_exec( $query, $update_values );
		}
		else {
			$update_values = array();
			$update_values[] = $custom_name;
			$update_values[] = $u_tickstamp;
			$update_values[] = $bostamp;
			
			$query = "update u_ptick set name = ? where u_tickstamp = ? and bostamp = ?";
			$sql_status2 = $this->mssql->mssql__prepare_exec( $query, $update_values );
		}
		
		foreach( $refs as $ref ) {
			foreach( $cores as $cor ) {
				$query = "select * from sx where ref = '".$ref['ref']."' and cor = '".$cor->seat."' and tam = '".$tam."'";
				$query = $this->mssql->mssql__select( $query );
		
				//se nao existir, cria
				if( sizeof($query) == 0 ) {
					$update_values = array();
					$update_values[] = $ref['ref'];
					$update_values[] = $cor->seat;
					$update_values[] = $tam;
					$update_values[] = 0;
					$update_values[] = 0;
					$update_values[] = $ref['ref'];
					
					$query = "insert into sx (
						sxstamp,
						stock,
						ref,
						armazem,
						cor,
						tam,
						epv1,
						pv1,
						ststamp,
						ousrdata,
						ousrhora,
						ousrinis,
						usrdata,
						usrhora,
						usrinis
					) values (
						CONVERT(VARCHAR(25), (select UPPER(suser_sname())+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5))),
						0,
						?,
						1,
						?,
						?,
						?,
						?,
						isnull((select ststamp from st where ref = ?), ''),
						CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
						CONVERT(VARCHAR(5), GETDATE(), 8), 
						UPPER(suser_sname()), 
						CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
						CONVERT(VARCHAR(5), GETDATE(), 8),
						UPPER(suser_sname())
					) 
					";
					
					$sql_status2 = $this->mssql->mssql__prepare_exec( $query, $update_values );
				}
		
				//verificar se tam ja existe no sgt
				$query = "select * from sgt where ref = '".$ref['ref']."' and tam = '".$tam."'";
				$query = $this->mssql->mssql__select( $query );
		
				//se nao existir, cria
				if( sizeof($query) == 0 ) {
					$update_values = array();
					$update_values[] = $ref['ref'];
					$update_values[] = $tam;
					$update_values[] = $ref['ref'];
					$update_values[] = $u_tickstamp;
					
					$query = "insert into sgt (
						sgtstamp,
						ref,
						tam,
						ststamp,
						u_ptick,
						ousrdata,
						ousrhora,
						ousrinis,
						usrdata,
						usrhora,
						usrinis
					) values (
						CONVERT(VARCHAR(25), (select UPPER(suser_sname())+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5))),
						?,
						?,
						isnull((select ststamp from st where ref = ?), ''),
						?,
						CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
						CONVERT(VARCHAR(5), GETDATE(), 8), 
						UPPER(suser_sname()), 
						CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
						CONVERT(VARCHAR(5), GETDATE(), 8),
						UPPER(suser_sname())
					) 
					";
					
					$sql_status2 = $this->mssql->mssql__prepare_exec( $query, $update_values );
				}
			}
		}
	}
	
	public function create_product_mssql( $data ) {
		
		$this->mssql->utf8_decode_deep( $data );
		$operator = $data["user"];
		
		$update_values = array();
		//bo bo2 bo3
		$update_values[] = 'Produto';
		$update_values[] = $operator->nome;
		$update_values[] = $operator->no;
		$update_values[] = 1;
		$update_values[] = $operator->morada;
		$update_values[] = $operator->local;
		$update_values[] = $operator->codpost;
		$update_values[] = $operator->ncont;
		$update_values[] = $data['product_name'];
		$update_values[] = $this->generate_seo_link( $data['product_name'] );
		//st
		$update_values[] = substr($data['product_name'], 0, 60);
		$update_values[] = 'PRODUTOS';
		$update_values[] = 'Produtos';
		$update_values[] = 1;
		$update_values[] = 1;
		$update_values[] = 1;
		//stobs
		$update_values[] = 'O';
		
		$query = "
		BEGIN TRANSACTION [Tran1];
		BEGIN TRY 

		DECLARE @stamp VARCHAR(25);
		DECLARE @numero INT;

		SET @stamp = CONVERT(VARCHAR(25), (select UPPER(suser_sname())+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5)));
		SET @numero = isnull((select max(obrano) + 1 from bo where ndos = 1), 1);
		
		insert into bo (
			bostamp,
			nmdos,
			obrano,
			dataobra,
			nome,
			no,
			obranome,
			boano,
			dataopen,
			ndos,
			moeda,
			morada,
			local,
			codpost,
			ncont,
			memissao,
			origem,
			u_name,
			ousrdata,
			ousrhora,
			ousrinis,
			usrdata,
			usrhora,
			usrinis
		) values (
			@stamp,
			?,
			@numero,
			CONVERT(VARCHAR(10), GETDATE(), 20),
			?,
			?,
			'P.' + rtrim(ltrim(CONVERT(VARCHAR(15), @numero))) + '.0',
			year(getdate()),
			CONVERT(VARCHAR(10), GETDATE(), 20),
			?,
			'EURO',
			?,
			?,
			?,
			?,
			'EURO',
			'BO',
			?,
			CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
			CONVERT(VARCHAR(5), GETDATE(), 8), 
			UPPER(suser_sname()), 
			CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
			CONVERT(VARCHAR(5), GETDATE(), 8),
			UPPER(suser_sname())
		)
		
		INSERT INTO bo2 (bo2stamp, idserie, tiposaft) values 
		(
			@stamp, 
			'BO', 
			(select top 1 tiposaft from ts where ndos = 1)
		)
		
		INSERT INTO bo3 (bo3stamp, u_sefurl) values 
		(
			@stamp,
			?
		)
		
		insert into st (
			ststamp,
			ref,
			design,
			familia,
			faminome,
			stns,
			iva1incl,
			texteis,
			ousrdata,
			ousrhora,
			ousrinis,
			usrdata,
			usrhora,
			usrinis
		) values (
			CONVERT(VARCHAR(25), (select UPPER(suser_sname())+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5))),
			'P.' + rtrim(ltrim(CONVERT(VARCHAR(15), @numero))) + '.0',
			?,
			?,
			?,
			?,
			?,
			?,
			CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
			CONVERT(VARCHAR(5), GETDATE(), 8), 
			UPPER(suser_sname()), 
			CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
			CONVERT(VARCHAR(5), GETDATE(), 8),
			UPPER(suser_sname())
		)
		
		insert into stobs (
			stobsstamp,
			ref,
			tipoprod,
			u_bostamp,
			ousrdata,
			ousrhora,
			ousrinis,
			usrdata,
			usrhora,
			usrinis
		) values (
			CONVERT(VARCHAR(25), (select UPPER(suser_sname())+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5))),
			'P.' + rtrim(ltrim(CONVERT(VARCHAR(15), @numero))) + '.0',
			?,
			@stamp,
			CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
			CONVERT(VARCHAR(5), GETDATE(), 8), 
			UPPER(suser_sname()), 
			CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
			CONVERT(VARCHAR(5), GETDATE(), 8),
			UPPER(suser_sname())
		) 
		
		COMMIT TRANSACTION [Tran1] 
		END TRY 
		BEGIN CATCH 
		ROLLBACK TRANSACTION [Tran1] 
		PRINT ERROR_MESSAGE() 
		END CATCH
		
		";
		
		$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
		$res_update["stobs_ins"] = $sql_status;
		
		$result = array();
		$result["success"] = 1;
		$result["sefurl"] = $this->generate_seo_link( $data['product_name'] );
		
		echo json_encode( $result );
	}
	
	public function generate_seo_link($input, $replace = '-', $remove_words = true, $words_array = array()) {
		//make it lowercase, remove punctuation, remove multiple/leading/ending spaces
		$return = trim(preg_replace('/ +/', ' ', preg_replace('/[^a-zA-Z0-9\s]/', '', strtolower($input))));

		//remove words, if not helpful to seo
		//i like my defaults list in remove_words(), so I wont pass that array
		if($remove_words) { $return = $this->remove_words($return, $replace, $words_array); }

		//convert the spaces to whatever the user wants
		//usually a dash or underscore..
		//...then return the value.
		return str_replace(' ', $replace, $return);
	}

	public function remove_words($input,$replace,$words_array = array(),$unique_words = true)
	{
		//separate all words based on spaces
		$input_array = explode(' ',$input);

		//create the return array
		$return = array();

		//loops through words, remove bad words, keep good ones
		foreach($input_array as $word)
		{
			//if it's a word we should add...
			if(!in_array($word,$words_array) && ($unique_words ? !in_array($word,$return) : true))
			{
				$return[] = $word;
			}
		}

		//return good words separated by dashes
		return implode($replace,$return);
	}
	
	public function apaga_grelha_mssql( $ref ) {
		$update_values = array();
		$update_values[] = $ref;
		
		$query = "delete from sx where ref = ?";
		$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
		
		$query = "delete from sgc where ref = ?";
		$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
		
		$query = "delete from sgt where ref = ?";
		$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
	}
	
	public function apaga_artigo_mssql( $ref ) {
		$update_values = array();
		$update_values[] = $ref;
		
		$query = "delete from st where ref = ?";
		$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
		
		$query = "delete from stobs where ref = ?";
		$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
	}
	
	public function stamp() {
		$query = "select CONVERT(VARCHAR(25), (select UPPER(suser_sname())+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5))) stamp";
		$query = $this->mssql->mssql__select( $query );
		return $query[0]["stamp"];
	}
	
	public function update_product( $data ) {
		$res_update = array();
		
		$data['input'] = json_decode($data['input']);
		$data['textarea'] = json_decode($data['textarea']);
		$data['checkbox'] = json_decode($data['checkbox']);
		$data['scheduling_table'] = json_decode($data['scheduling_table']);
		$data['tickets_table'] = json_decode($data['tickets_table']);
		$data['ticket_num_table'] = json_decode($data['ticket_num_table']);
		$product_data = $this->product_model->get_product_data_stamp( $data['bostamp'] );
		
		$product_obrano = $product_data["obrano"];
		$product_name = $product_data["u_name"];
		$product_sef = $product_data["u_sefurl"];
		
		$this->mssql->utf8_decode_deep( $data['input'] );
		$this->mssql->utf8_decode_deep( $data['textarea'] );
		$this->mssql->utf8_decode_deep( $data['checkbox'] );
		
		//bo update
		$update_query = "";
		$update_values = array();
		$update_where = "";
		
		//input
		foreach( $data['input']->bo as $key=>$value ) {
			$txtafound = 0;
			$chbfound = 0;
			foreach( $data['textarea'] as $textarea ) {
				if( $textarea[0] == "bo." . $key ) {
					$txtafound = 1;
				}
			}
			foreach( $data['checkbox'] as $checkbox ) {
				if( $checkbox[0] == "bo." . $key ) {
					$chbfound = 1;
				}
			}
			
			if( !$txtafound && !$chbfound ) {
				$update_query .= $key . " = ?, ";
				$update_values[] = $value;
			}
		}
		//textarea mce
		foreach( $data['textarea'] as $textarea ) {
			if (strpos($textarea[0], 'bo.') !== false) {
				$update_query .= $textarea[0] . " = ?, ";
				$update_values[] = str_replace("'", "''", base64_decode($textarea[1]));
			}
		}
		//checkbox
		foreach( $data['checkbox'] as $checkbox ) {
			if (strpos($checkbox[0], 'bo.') !== false) {
				$update_query .= $checkbox[0] . " = ?, ";
				$update_values[] = $checkbox[1];
			}
		}

		$update_query = substr($update_query, 0, strlen($update_query) - 2);
		$update_where .= "bostamp = '" . $data['bostamp'] . "'";
		
		$query = "update bo set " . $update_query . " where " . $update_where;
		$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
		
		$res_update["update_bo"] = $sql_status;
		
		//update bo3
		$update_query = "";
		$update_values = array();
		$update_where = "";
		
		//input
		foreach( $data['input']->bo3 as $key=>$value ) {
			$txtafound = 0;
			$chbfound = 0;
			foreach( $data['textarea'] as $textarea ) {
				if( $textarea[0] == "bo3." . $key ) {
					$txtafound = 1;
				}
			}
			foreach( $data['checkbox'] as $checkbox ) {
				if( $checkbox[0] == "bo3." . $key ) {
					$chbfound = 1;
				}
			}
			
			if( !$txtafound && !$chbfound ) {
				$update_query .= $key . " = ?, ";
				$update_values[] = $value;
			}
		}
		//textarea mce
		foreach( $data['textarea'] as $textarea ) {
			if (strpos($textarea[0], 'bo3.') !== false) {
				$update_query .= $textarea[0] . " = ?, ";
				$update_values[] = str_replace("'", "''", base64_decode($textarea[1]));
			}
		}
		//checkbox
		foreach( $data['checkbox'] as $checkbox ) {
			if (strpos($checkbox[0], 'bo3.') !== false) {
				$update_query .= $checkbox[0] . " = ?, ";
				$update_values[] = $checkbox[1];
			}
		}

		$update_query = substr($update_query, 0, strlen($update_query) - 2);
		$update_where .= "bo3stamp = '" . $data['bostamp'] . "'";
		
		$query = "update bo3 set " . $update_query . " where " . $update_where;
		$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
		
		$res_update["update_bo3"] = $sql_status;
		
		//tickets
		foreach( $data['tickets_table'] as $table_row ) {
			if( $table_row[2] == 1 ) {
				//ticket (tam) existe para este artigo?
				$this->cria_tam( $table_row[0], $table_row[1], $data['bostamp'] );
			}
			else {
				$this->apaga_tam( $table_row[0], $data['bostamp'] );
			}
		}
		
		//tickets num
		$updated_ticket_num_table = array();
		foreach( $data['ticket_num_table'] as $table_row ) {
			$updated_ticket_num_table_tmp = array();
			//update
			if( $table_row[0] != '' ) {			
				$update_values = array();
				$update_values[] = $table_row[1];
				$update_values[] = $table_row[0];
				
				$query = "update u_pntick set no = ? where u_pntickstamp = ?";
				
				$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
				$res_update["update_tick_num_tab_upd"] = $sql_status;
				
				$updated_ticket_num_table_tmp["no"] = $table_row[1];
				$updated_ticket_num_table_tmp["id"] = $table_row[2];
				$updated_ticket_num_table_tmp["u_pntickstamp"] = $table_row[0];
				$updated_ticket_num_table[] = $updated_ticket_num_table_tmp;
			}
			// insert
			else {
				$update_values = array();
				$u_pntickstamp = $this->product_model->stamp();
				$update_values[] = $u_pntickstamp;
				$update_values[] = $data['bostamp'];
				$update_values[] = $table_row[1];
				
				$query = "insert into u_pntick (
					u_pntickstamp,
					bostamp,
					no,
					issued,
					used,
					ousrdata,
					ousrhora,
					ousrinis,
					usrdata,
					usrhora,
					usrinis
				) values (
					?,
					?,
					?,
					0,
					0,
					CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
					CONVERT(VARCHAR(5), GETDATE(), 8), 
					UPPER(suser_sname()), 
					CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
					CONVERT(VARCHAR(5), GETDATE(), 8),
					UPPER(suser_sname())
				) 
				";
				
				$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
				$res_update["update_tick_num_tab_ins"] = $sql_status;
				
				$updated_ticket_num_table_tmp["no"] = $table_row[1];
				$updated_ticket_num_table_tmp["id"] = $table_row[2];
				$updated_ticket_num_table_tmp["u_pntickstamp"] = $u_pntickstamp;
				$updated_ticket_num_table[] = $updated_ticket_num_table_tmp;
			}
		}
		$res_update["updated_ticket_num_table"] = $updated_ticket_num_table;
		
		//scheduling_table
		$updated_scheduling_table = array();
		$updated_scheduling_pricing = array();
		
		foreach( $data['scheduling_table'] as $table_row ) {
			$updated_scheduling_table_tmp = array();
			
			//update
			if( $table_row[0] != '' ) {
				$update_query = "price = ?, ";
				$update_query .= "ihour = ?, ";
				$update_query .= "fixday = ?,";
				$update_query .= "mon = ?,";
				$update_query .= "tue = ?,";
				$update_query .= "wed = ?,";
				$update_query .= "thu = ?,";
				$update_query .= "fri = ?,";
				$update_query .= "sat = ?,";
				$update_query .= "sun = ? ";
				
				$update_values = array();
				$update_values[] = ($table_row[2] == "true" ? 1 : 0);
				$update_values[] = $table_row[3];
				$update_values[] = $table_row[4];
				$update_values[] = ($table_row[5] == "true" ? 1 : 0);
				$update_values[] = ($table_row[6] == "true" ? 1 : 0);
				$update_values[] = ($table_row[7] == "true" ? 1 : 0);
				$update_values[] = ($table_row[8] == "true" ? 1 : 0);
				$update_values[] = ($table_row[9] == "true" ? 1 : 0);
				$update_values[] = ($table_row[10] == "true" ? 1 : 0);
				$update_values[] = ($table_row[11] == "true" ? 1 : 0);
				
				$query = "update u_psess set " . $update_query . " where u_psessstamp = '" . $table_row[0] . "'";
				
				$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
				$res_update["update_sess_tab_upd"] = $sql_status;
				
				$updated_scheduling_table_tmp["id"] = $table_row[1];
				$updated_scheduling_table_tmp["u_psessstamp"] = $table_row[0];
				$updated_scheduling_table[] = $updated_scheduling_table_tmp;
			}
			// insert
			else {
				$update_values = array();
				$u_psessstamp = $this->product_model->stamp();
				$update_values[] = $u_psessstamp;
				$update_values[] = $data['bostamp'];
				$update_values[] = $table_row[1];
				$update_values[] = ($table_row[2] == "true" ? 1 : 0);
				$update_values[] = $table_row[3];
				$update_values[] = $table_row[4];
				$update_values[] = ($table_row[5] == "true" ? 1 : 0);
				$update_values[] = ($table_row[6] == "true" ? 1 : 0);
				$update_values[] = ($table_row[7] == "true" ? 1 : 0);
				$update_values[] = ($table_row[8] == "true" ? 1 : 0);
				$update_values[] = ($table_row[9] == "true" ? 1 : 0);
				$update_values[] = ($table_row[10] == "true" ? 1 : 0);
				$update_values[] = ($table_row[11] == "true" ? 1 : 0);
				
				$query = "insert into u_psess (
					u_psessstamp,
					bostamp,
					id,
					price,
					ihour,
					fixday,
					mon,
					tue,
					wed,
					thu,
					fri,
					sat,
					sun,
					ousrdata,
					ousrhora,
					ousrinis,
					usrdata,
					usrhora,
					usrinis
				) values (
					?,
					?,
					?,
					?,
					?,
					?,
					?,
					?,
					?,
					?,
					?,
					?,
					?,
					CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
					CONVERT(VARCHAR(5), GETDATE(), 8), 
					UPPER(suser_sname()), 
					CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
					CONVERT(VARCHAR(5), GETDATE(), 8),
					UPPER(suser_sname())
				) 
				";
				
				$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
				$res_update["update_sess_tab_ins"] = $sql_status;
				
				$updated_scheduling_table_tmp["id"] = $table_row[1];
				$updated_scheduling_table_tmp["u_psessstamp"] = $u_psessstamp;
				$updated_scheduling_table[] = $updated_scheduling_table_tmp;
			}
			
			//criar artigo
			//verificar se artigo ja existe
			$query = "select * from st where ref = '"."P." . $product_obrano . "." . $table_row[1]."'";
			$query = $this->mssql->mssql__select( $query ); 
			
			//produto com preco alternativo
			if( $table_row[2] == "true" ) {
				$updated_scheduling_pricing_tmp = array();
				$updated_scheduling_pricing_tmp["id"] = $table_row[1];
				$updated_scheduling_pricing_tmp["alt_price"] = 1;
				
				$updated_scheduling_pricing[] = $updated_scheduling_pricing_tmp;
			}	
			else {
				$updated_scheduling_pricing_tmp = array();
				$updated_scheduling_pricing_tmp["id"] = $table_row[1];
				$updated_scheduling_pricing_tmp["alt_price"] = 0;
				
				$updated_scheduling_pricing[] = $updated_scheduling_pricing_tmp;
			}				
			
			//se nao existir, cria
			if( $table_row[2] == "true" && sizeof($query) == 0) {
				//st
				$update_values = array();
				$update_values[] = "P." . $product_obrano . "." . $table_row[1];
				$update_values[] = substr($product_name, 0, 60);
				$update_values[] = 'PRODUTOS';
				$update_values[] = 'Produtos';
				$update_values[] = 1;
				$update_values[] = 1;
				$update_values[] = 1;
				
				$query = "insert into st (
					ststamp,
					ref,
					design,
					familia,
					faminome,
					stns,
					iva1incl,
					texteis,
					ousrdata,
					ousrhora,
					ousrinis,
					usrdata,
					usrhora,
					usrinis
				) values (
					CONVERT(VARCHAR(25), (select UPPER(suser_sname())+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5))),
					?,
					?,
					?,
					?,
					?,
					?,
					?,
					CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
					CONVERT(VARCHAR(5), GETDATE(), 8), 
					UPPER(suser_sname()), 
					CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
					CONVERT(VARCHAR(5), GETDATE(), 8),
					UPPER(suser_sname())
				) 
				";
				
				$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
				$res_update["st_ins"] = $sql_status;
				
				//stobs
				$update_values = array();
				$update_values[] = "P." . $product_obrano . "." . $table_row[1];
				$update_values[] = 'O';
				$update_values[] = $data['bostamp'];
				
				$query = "insert into stobs (
					stobsstamp,
					ref,
					tipoprod,
					u_bostamp,
					ousrdata,
					ousrhora,
					ousrinis,
					usrdata,
					usrhora,
					usrinis
				) values (
					CONVERT(VARCHAR(25), (select UPPER(suser_sname())+left(newid(),5)+right(newid(),5)+ left(newid(),5)+right(newid(),5))),
					?,
					?,
					?,
					CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
					CONVERT(VARCHAR(5), GETDATE(), 8), 
					UPPER(suser_sname()), 
					CONVERT(VARCHAR(10), GETDATE(), 20) + ' 00:00:00.000', 
					CONVERT(VARCHAR(5), GETDATE(), 8),
					UPPER(suser_sname())
				) 
				";
				
				$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
				$res_update["stobs_ins"] = $sql_status;
			}
			
			// log_message('error', print_r($data['input']->tickets_table, true));
			
			//grelhas
			$lugares = $this->get_product_seats_mssql( $product_sef );
			$bilhetes = $this->get_product_tickets_mssql( $product_sef );
			
			//se existirem lugares
			if( sizeof($lugares) > 0 && $table_row[2] == "true" ) {
				foreach( $lugares as $lugar ) {
					foreach( $bilhetes as $bilhete ) {
						$this->cria_grelha_mssql( $lugar["seat"], $bilhete["ticket"], "P." . $product_obrano . "." . $table_row[1], $lugar["u_pseatstamp"], $bilhete["u_ptickstamp"] );
					}
				}
			}
			else if( $table_row[2] == "true" ) {
				foreach( $bilhetes as $bilhete ) {
					$this->cria_grelha_mssql( "ND", $bilhete["ticket"], "P." . $product_obrano . "." . $table_row[1], '', $bilhete["u_ptickstamp"] );
				}
			}
			else {
				foreach( $bilhetes as $bilhete ) {
					$this->apaga_grelha_mssql( "P." . $product_obrano . "." . $table_row[1] );
					$this->apaga_artigo_mssql( "P." . $product_obrano . "." . $table_row[1] );
				}
			}
		}
		$res_update["updated_scheduling_table"] = $updated_scheduling_table;
		$res_update["updated_scheduling_pricing"] = $updated_scheduling_pricing;
		
		//grelhas ref. base
		$lugares = $this->get_product_seats_mssql( $product_sef );
		$bilhetes = $this->get_product_tickets_mssql( $product_sef );
		//se existirem lugares
		if( sizeof($lugares) > 0 ) {
			foreach( $lugares as $lugar ) {
				foreach( $bilhetes as $bilhete ) {
					$this->cria_grelha_mssql( $lugar["seat"], $bilhete["ticket"], "P." . $product_obrano . ".0", $lugar["u_pseatstamp"], $bilhete["u_ptickstamp"] );
				}
			}
		}
		else {
			foreach( $bilhetes as $bilhete ) {
				$this->cria_grelha_mssql( "ND", $bilhete["ticket"], "P." . $product_obrano . ".0", '', $bilhete["u_ptickstamp"] );
			}
		}
			
		echo json_encode( $res_update );
	}
	
	function delete_product_session( $data ) {
		$session = $data['session'];
		
		//obter ref para sessao
		$query = "
			select bo.obrano , u_psess.id
			from bo 
				inner join u_psess on bo.bostamp = u_psess.bostamp
			where 
				u_psess.u_psessstamp = '".$session."'
		";

		$query = $this->mssql->mssql__select( $query );
		
		if( sizeof($query) > 0 ) {
			$ref = "P." . $query[0]["obrano"] . "." . $query[0]["id"];
			
			// log_message('error', print_r($ref, true));
			
			//apagar st
			$update_values = array();
			$update_values[] = $ref;
			$query = "delete from st where ref = ?";
			$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
			
			//apagar stobs
			$update_values = array();
			$update_values[] = $ref;
			$query = "delete from stobs where ref = ?";
			$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
			
			//apagar sgc
			$update_values = array();
			$update_values[] = $ref;
			$query = "delete from sgc where ref = ?";
			$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
			
			//apagar sgt
			$update_values = array();
			$update_values[] = $ref;
			$query = "delete from sgt where ref = ?";
			$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
			
			//apagar sx
			$update_values = array();
			$update_values[] = $ref;
			$query = "delete from sx where ref = ?";
			$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
		}
		
		//apagar sessao
		$update_values = array();
		$update_values[] = $session;
		
		$query = "delete from u_psess where u_psessstamp = ?";

		$sql_status = $this->mssql->mssql__prepare_exec( $query, $update_values );
		echo $sql_status;
	}
	
}