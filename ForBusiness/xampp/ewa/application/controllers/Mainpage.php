<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MainPage extends CI_Controller {

	public function index()
	{
		$this->load->library('position');
		$this->template->frontpage = "true";
		$this->load->model('Main_model');
		$this->load->model('user_model');
		
		$data = array();
		$agent = "";
		if( isset($_SESSION["user_id"])){
			if($_SESSION['type'] == "agent"){
				$agent= $_SESSION["user_id"]; 
			}
		}  

		$data['products'] = $this->Main_model->get_products($agent);
		$data['pcateg'] = $this->Main_model->get_category($agent);
		$data['topdest'] = $this->Main_model->get_topdest($agent);
        $this->template->content->view('mainpage', $data);
		
		$this->template->publish();
	}
}
