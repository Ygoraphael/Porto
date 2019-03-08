<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MainPage extends CI_Controller {

	public function index()
	{
		$this->load->library('position');
		$this->template->frontpage = "true";
		$this->load->model('Main_model');
		
		$data = array();
        $this->template->content->view('mainpage', $data);
		
		$this->template->publish();
	}
}
