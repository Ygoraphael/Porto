<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model class.
 * 
 * @extends CI_Model
 */
class Admin_model extends CI_Model {

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
	
	public function delete_pages($data) {
		
		foreach ($data['id'] as $value){
			$this->db->where('id', $value);
		$result = $this->db->delete('pages');
		}
		
		
		return $result;
	}
	
	public function get_menus($parentroot) {
		$this->db->select("*");
		$this->db->from('menu_item');
		if($parentroot == 1){
		$this->db->where('parent', '0');
		}
		$query = $this->db->get();
		
		return $query;
	}
	public function get_menus_child($id) {
		$this->db->select("*");
		$this->db->from('menu_item');
		$this->db->where('parent', $id);
			
		$query = $this->db->get();
		
		return $query;
	}
	
	public function get_menus_byid($id) {
		$this->db->select("a.*, b.id as id_category");
		$this->db->from('menu_item a');
		$this->db->join('menu b', 'b.id = a.menu_id');
		$this->db->where('a.id', $id);
			
		return $this->db->get()->row();
	}
	
	public function get_menus_bycategory($id) {
		$this->db->select("*");
		$this->db->from('menu');
		$this->db->where('id', $id);	
		return $this->db->get()->row();
	}
	
	public function get_menus_category() {
		$this->db->select("*");
		$this->db->from('menu');	
		$query = $this->db->get();
		return $query;
	}
	
	public function get_positions() {
		$this->db->select("*");
		$this->db->from('position');	
		$query = $this->db->get();
		return $query;
	}
	
	public function get_orderitem($id) {
		$this->db->select("*");
		$this->db->from('menu_item');
		$this->db->where('parent', $id);
		$this->db->order_by("lorder", "asc");	
		$query = $this->db->get();
		return $query;
	}
	
	public function create_menu_item($text,$url,$parent,$category_id,$logged_only,$type,$lorder) {
		$logged_only2 = $logged_only === '0'? 0: 1;
		$data = array(
			'text' => $text,
			'url' => $url,
			'parent' => $parent,
			'menu_id' => $category_id,
			'logged_only' => $logged_only2,
			'type' => $type,
			'lorder' => $lorder
		);

		$this->db->insert('menu_item', $data);
		$insert_id = $this->db->insert_id();

		return  $insert_id;
	}	
	
	public function create_menu_category($title,$url,$name,$logo,$position,$toggle) {
		$toggle2 = $toggle === '0'? 0: 1;
		$data = array(
			'title' => $title,
			'url' => $url,
			'name' => $name,
			'logo' => $logo,
			'position' => $position,
			'toggle' => $toggle2
		);

		$this->db->insert('menu', $data);
		$insert_id = $this->db->insert_id();

		return  $insert_id;
	}
	
	public function update_menu_item($id,$text,$url,$parent,$category_id,$logged_only,$type,$lorder) {
		$logged_only2 = $logged_only === '0'? 0: 1;
		
		$data = array(
			'text' => $text,
			'url' => $url,
			'parent' => $parent,
			'menu_id' => $category_id,
			'logged_only' => $logged_only2,
			'type' => $type,
			'lorder' => $lorder
		);
		$this->db->where('id', $id);
		$sql = $this->db->update('menu_item', $data);
		

		return  $id;
	}	
	
	public function update_menu_category($id,$title,$url,$name,$logo,$position,$toggle){
		$toggle2 = $toggle === '0'? 0: 1;
		$data = array(
			'title' => $title,
			'url' => $url,
			'name' => $name,
			'logo' => $logo,
			'position' => $position,
			'toggle' => $toggle2
		);
		
		$this->db->where('id', $id);
		$sql = $this->db->update('menu', $data);
		

		return  $id;
	}
	
	
	public function get_alias($alias) {
		$this->db->select("*");
		$this->db->from('pages');
		$this->db->where('alias', $alias);
		return $this->db->get()->row();
	}
	
	
	public function create_page($alias,$title,$content) {
		$data = array(
			'title' => $title,
			'content' => $content,
			'alias' => $alias
		);

		$this->db->insert('pages', $data);
		$insert_id = $this->db->insert_id();

		return  $insert_id;
	}
	
	public function create_plugin($url,$title,$position) {
		$data = array(
			'title' => $title,
			'position' => $position,
			'url' => $url
		);

		$this->db->insert('plugin', $data);
		$insert_id = $this->db->insert_id();

		return  $insert_id;
	}
	
	public function update_plugin($id,$url,$title,$position) {
		$data = array(
			'title' => $title,
			'position' => $position,
			'url' => $url
		);

		$this->db->where('id', $id);
		$sql = $this->db->update('plugin', $data);
		return  $id;
	}
	
	public function create_users($sql) {
		
		$this->db->insert('users', $sql);
		
		$insert_id = $this->db->insert_id();
		
		
		return  $insert_id;	
		
	}
	
	public function update_item_pages($id,$title,$content) {
		$data = array(
			'title' => $title,
			'content' => $content,
		);

		$this->db->where('id', $id);
		$sql = $this->db->update('pages', $data);
		

		return  $id;
	}
	
	public function get_page() {
		$this->db->select("*");
		$this->db->from('pages');		
		$query = $this->db->get();
	
		return $query;
	}
	
	public function get_page_byid($id) {
		$this->db->select("*");
		$this->db->from('pages');
		$this->db->where('id', $id);
		return $this->db->get()->row();
	}
	public function get_users_byid($id) {
		$this->db->select("*");
		$this->db->from('users');
		$this->db->where('id', $id);
		return $this->db->get()->row();
	}
	
	public function get_users() {
		$this->db->select("*");
		$this->db->from('users');		
		$query = $this->db->get();
	
		return $query;
	}
	
	public function update_users($id,$sql) {
		$this->db->where('id', $id);
		
		$sql = $this->db->update('users', $sql);

		return  $id;

	}
	

	public function get_plugin() {
		$this->db->select("a.*, b.name as position_name");
		$this->db->from('plugin a');	
		$this->db->join('position b', 'b.id = a.position');		
		$query = $this->db->get();
	
		return $query;
	}
	public function get_fields() {
		$this->db->select("*");
		$this->db->from('fields');	
			$this->db->order_by("lorder", "asc");	
		$query = $this->db->get();
	
		return $query;
	}
	
	public function get_plugin_byid($id) {
		$this->db->select("*");
		$this->db->from('plugin');
		
		$this->db->where('id', $id);
		
		
		return $this->db->get()->row();
	}
	
}