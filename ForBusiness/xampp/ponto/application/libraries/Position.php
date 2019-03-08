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
		if( substr( $position_name, 0, 8 ) == 'position' ) {
			//get controllers
			$url = $this->GetPluginInPosition($position_name);
			foreach ($url as $value){
				include($value);
			}
		}
		else {
			$position_id = $this->PositionName2Id($position_name);
			
			//get menus
			$this->CI->menu->GetMenusInPosition($position_id);
			//get modules
		}
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
		$row = $query->row();
		if (isset($row))
		{	
			foreach ($query->result() as $row)
			{
				array_push($array, $row->url);
			}
		}
		
		return $array;
	}
}