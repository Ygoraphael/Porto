<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Position {
	
    protected $CI;
	
	public function __construct()
    {
		$this->CI =& get_instance();
		$this->CI->load->library('menu');
    }
	
	public function RenderPosition($position_name)
	{
		if( $position_name == 'nc:content' ) {
			//get controllers
			$this->CI->load->view( $this->CI->uri->segment(1) );
		}

		//get plugins
		$cur_url = uri_string();
		$plugins = $this->GetPluginInPosition($position_name);
		
		foreach ($plugins as $plugin){
			$pages = $this->GetPluginPages($plugin["id"]);
			$found = 0;
			foreach( $pages as $page ) {
				$pattern = '/' . str_replace("/", "\/", $page["url"]) . '/';

				if( preg_match($pattern, $cur_url) )
					$found = 1;
			}
			if( $found && file_exists($plugin["url"]))
				include($plugin["url"]);
		}

		$position_id = $this->PositionName2Id($position_name);
		
		//get menus
		$this->CI->menu->GetMenusInPosition($position_id);
		//get modules

	}
	
	public function PositionName2Id($position_name) 
	{
		$query = $this->CI->db->query('SELECT id FROM position where name = '.$this->CI->db->escape($position_name));
		$row = $query->row();
		if (isset($row))
		{
			return $row->id;
		}
	}
	
	public function GetPluginInPosition($position)
	{
		$array = array();
		$query = $this->CI->db->query('SELECT a.*, b.name as position_name from plugin a inner join position b on b.id = a.position where b.name = '.$this->CI->db->escape($position));
		$query = $query->result_array();
		
		return $query;
	}
	
	public function GetPluginPages($id)
	{
		$array = array();
		$query = $this->CI->db->query('SELECT * from plugin_page where plugin_id = ' . $id);
		$query = $query->result_array();
		
		return $query;
	}
}