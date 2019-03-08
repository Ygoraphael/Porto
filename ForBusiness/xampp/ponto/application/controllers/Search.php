<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends CI_Controller {

	public function index()
	{
		$this->load->model('product_model');
		if(isset($_POST['op'])){
			echo json_encode($this->product_model->search_product_wl($this->input->post('query'), $_POST['op'])); 
		}else{
			echo json_encode($this->product_model->search_product($this->input->post('query')));
		}
		
	}
}

