<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu {
	
	protected $CI;
	
	public function __construct()
    {
		$this->CI =& get_instance();
		$this->CI->load->library(array('session'));
    }
	
	public function GetMenusInPosition($position)
	{
		$query = $this->CI->db->query('SELECT * FROM menu where position = '.$this->CI->db->escape($position));
		foreach ($query->result_array() as $row)
		{
			$this->RenderMenu($row);
		}
	}
	
    public function RenderMenu($row)
	{
		if($row["toggle"] == 1) {
			echo '<div class="navbar-header">';
			
			if(trim($row["logo"]) <> '') {
				echo '<a href="'.base_url().trim($row["url"]).'" title="'.trim($row["title"]).'" rel="'.trim($row["title"]).'" class="custom-header navbar-brand clearfix"><img class="clearfix" src="'.base_url() . trim($row["logo"]).'" alt="" scale="0"></a>';
			}
			
			echo '	<button type="button" class="navbar-toggle clearfix" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>
			<div class="navbar-collapse collapse navbar-right navbar-top">
				<div class="navbar-top">
					<ul class="nav navbar-nav">
			';
			
			$query = $this->CI->db->query("SELECT * FROM menu_item where menu_id = ".$this->CI->db->escape($row["id"])." and parent = 0 order by lorder");
			foreach ($query->result_array() as $row2)
			{
				$query = $this->CI->db->query("SELECT * FROM menu_item where menu_id = ".$this->CI->db->escape($row["id"])." and parent = ".$row2["id"]." order by lorder");
				
				if(sizeof($query->result_array()) > 0) {
					echo $this->RenderMenuItemDropdown($row2, $query->result_array());
				}
				else {
					echo $this->RenderMenuItem($row2);
				}
			}
			echo '
					</ul>
				</div>
			</div>';
		}
		else {
		}
	}
	
	public function RenderMenuItem($row)
	{
		if( $row["logged_only"] == "0" || ( $row["logged_only"] == "1" && $this->CI->session->userdata('logged_in') ) ) {
			if( $row["type"] == "url" ) {
				return '<li><a href="'.base_url().$row["url"].'">'.$row["text"].'</a></li>';
			}
			else if( $row["type"] == "login_popup" && !$this->CI->session->userdata('logged_in') ) {
			return '<li><a data-toggle="modal" href="'.base_url().'login_popup" data-target="#myModal">'.$row["text"].'</a></li>';
			}
			else if( $row["type"] == "user_data" ) {
				return '<li><a href="'.base_url().$row["url"].'">'.$_SESSION[$row["text"]].'</a></li>';
			}
		}
	}
	
	public function RenderMenuItemDropdown($row2, $result)
	{
		if( $row2["logged_only"] == "0" || ( $row2["logged_only"] == "1" && $this->CI->session->userdata('logged_in') ) ) {
			echo '<li class="dropdown">';
			if( $row2["type"] == "user_data" ) {
				echo '<a href="'.base_url().$row2["url"].'" class="dropdown-toggle" data-toggle="dropdown">'.$_SESSION[$row2["text"]].' <b class="caret"></b></a>';
			}
			else {
				echo '<a href="'.base_url().$row2["url"].'" class="dropdown-toggle" data-toggle="dropdown">'.$row2["text"].' <b class="caret"></b></a>';
			}

			echo	'<ul class="dropdown-menu">';
					foreach($result as $row3)
					{
						echo $this->RenderMenuItem($row3);
					}
			echo	'</ul>
				</li>';
		}
	}
	
}