<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

	public function index()
	{
		$this->load->library('position');
		$this->template->frontpage = "false";
		
		$data = array();
        //$this->template->content->view('product', $data);
		
		$this->template->publish();
	}
	
	public function id() {
		$this->load->library('position');
		$this->template->frontpage = "false";
		$this->load->model('user_model');
		$this->load->model('product_model');
		$this->load->model('wl_model');
		
		$data = array();

		$data["product"] = $this->product_model->get_product_data($this->uri->segment(2), 1);
		$data["product_img"] = $this->product_model->get_product_img($this->uri->segment(2));
		$data["tickets"] = $this->product_model->get_product_tickets($this->uri->segment(2));
		$data["seats"] = $this->wl_model->get_product_seats($this->uri->segment(2));
		$data["extras"] = $this->wl_model->get_product_extras($this->uri->segment(2));
		$data["categories"] = $this->wl_model->get_product_categories($this->uri->segment(2));

		if( sizeof($data["product"]) )
			$data["row"] = $data["product"][0];
		
        $this->template->content->view('product', $data);
		
		$this->template->publish();
	}
}
