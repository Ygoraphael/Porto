<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller {

	public function __construct()
    {
		 parent::__construct();
		$this->load->library('position');
		$this->template->frontpage = "false";
  
    }
	
	public function index()
	{
		$data = array();
        //$this->template->content->view('product', $data);
		
		$this->template->publish();
	}
	
	public function id() {

		$this->load->model('pages_model');
		
		$data = array();
		$data["page"] = $this->pages_model->get_page($this->uri->segment(2));
        
		$this->template->content->view('admin/pages/page', $data);
		
		$this->template->publish();
	}
}
