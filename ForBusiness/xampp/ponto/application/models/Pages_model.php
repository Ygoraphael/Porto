<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model class.
 * 
 * @extends CI_Model
 */
class Pages_model extends CI_Model {

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
	
	
	public function get_page($alias) {
		$this->db->select("*");
		$this->db->from('pages');
		$this->db->where('alias', $alias);
		
		 return $this->db->get()->row();
	}
	
	
	
}