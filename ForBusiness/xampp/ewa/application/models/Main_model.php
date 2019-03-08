<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model class.
 * 
 * @extends CI_Model
 */
class Main_model extends CI_Model {

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
	
	
	public function get_products($agent) {
		$this->db->select('
		bo.*,
		bo2.*,
		bo3.*,
		u_pimg.*
		');
		$this->db->from('bo');
		$this->db->join('bo2', 'bo.bostamp = bo2.bo2stamp');
		$this->db->join('bo3', 'bo.bostamp = bo3.bo3stamp');
		$this->db->join('u_pimg', 'bo.bostamp = u_pimg.bostamp');
		if($agent != ""){
			$this->db->join('u_pagent', 'bo.bostamp = u_pagent.bostamp', 'left');
			$this->db->where('u_pagent.no', $agent);
		}  
		$this->db->where('bo.ndos = 1');
		$this->db->where('bo.estab = 0');
		$this->db->where('bo.logi8 = 0');
		$this->db->group_by('bo.bostamp'); 
		$this->db->limit(12, 0);
		$query = $this->db->get();
		$query = $query->result_array();
		return $query;
	}
	
	public function get_category( $agent) {
		$this->db->select('
		*,(SELECT img FROM u_pimg where u_pimg.bostamp = bo.bostamp ORDER BY RAND() LIMIT 1) as img
		');
		$this->db->join('bo', 'u_pcateg.bostamp = bo.bostamp');
		if($agent != ""){
			$this->db->join('u_pagent', 'bo.bostamp = u_pagent.bostamp', 'left');
			$this->db->where('u_pagent.no', $agent);
		}
		$this->db->from('u_pcateg');
		$this->db->where('bo.ndos = 1');
		$this->db->where('bo.logi8 = 0');
		$this->db->group_by('category');
		$this->db->limit(12, 0);
		$query = $this->db->get();
		$query = $query->result_array();
		return $query;
	}
	
	public function get_topdest( $agent) {
		$this->db->select('u_city,(SELECT img FROM u_pimg where u_pimg.bostamp = bo.bostamp ORDER BY RAND() LIMIT 1) as img');
		$this->db->from('bo');
		$this->db->join('bo3', 'bo.bostamp = bo3.bo3stamp');
		if($agent != ""){
			$this->db->join('u_pagent', 'bo.bostamp = u_pagent.bostamp', 'left');
			$this->db->where('u_pagent.no', $agent);
		}
		$this->db->where('bo.ndos = 1');
		$this->db->where('bo.logi8 = 0');
		$this->db->where("bo3.u_city <>  ''");
		$this->db->group_by('u_city');
		$this->db->limit(12, 0);
		$query = $this->db->get();
		$query = $query->result_array();
		return $query;
	}
	
	
	
}