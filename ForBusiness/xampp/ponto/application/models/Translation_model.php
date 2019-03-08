<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model class.
 * 
 * @extends CI_Model
 */
class Translation_model extends CI_Model {

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
		
	public function get_translations_by_key($key) {
		$this->db->select("*");
		$this->db->from('u_translate');
		$this->db->where('keyvalue', $key);
		return $this->db->get()->row();

	}
	
	public function get_translations() {
		$this->db->select("*");
		$this->db->from('u_translate');
		$query = $this->db->get();
		
		return $query;
	}
	
	public function get_languages() {
		$this->db->select("*");
		$this->db->from('u_plang');
		$query = $this->db->get();
		
		return $query;
	}
	
	public function get_translations_by_id($id) {
		$this->db->select("*");
		$this->db->from('u_translate');
		$this->db->where('keyvalue', $id);
		return $this->db->get()->row();
	}
	

	
	public function get_languages_by_code($code) {
		$this->db->select("*");
		$this->db->from('u_plang');
		$this->db->where('u_plangstamp', $code);
		return $this->db->get()->row();

	}
	
	public function create_country($country,$stamp){
		$data = array(
			'language' => $country
		);

		$this->db->insert('u_plang', $data);
		$insert_id = $this->db->insert_id();

		return  $insert_id;
	
	}
	public function create_translation($key,$value,$language){
		$data = array(
			'keyvalue' => $key,
			'textvalue' => $value,
			'lang' => $language
		);

		$this->db->insert('u_translate', $data);
		

		return  $key;
	
	}
	
	public function update_country($country,$flag,$code){
		
		$data = array(
			'country' => $country,
			'flag' => $flag,
			'code' => $code
		);
		$this->db->where('code', $code);
		$sql = $this->db->update('u_plang', $data);
		

		return  $code;
	
	}
	
	public function update_translation($id,$key,$value,$language){
		
		$data = array(
			'keyvalue' => $key,
			'textvalue' => $value,
			'lang' => $language
		);

		$this->db->where('keyvalue', $id);
		$sql = $this->db->update('u_translate', $data);
		

		return  $id;
	
	}
	
		
	
	
}