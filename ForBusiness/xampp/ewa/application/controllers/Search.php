<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends CI_Controller {

	public function index()
	{
		$this->load->model('product_model');
		if(isset($_POST['op'])){
			if( isset($_SESSION["user_id"])){
				if($_SESSION['type'] == "agent"){
				echo json_encode($this->product_model->search_product_wl($this->input->post('query'), $_POST['op'],1,$_SESSION["user_id"])); 	

				}else{
					echo json_encode($this->product_model->search_product_wl($this->input->post('query'), $_POST['op'],1)); 
				}
			}else{
				echo json_encode($this->product_model->search_product_wl($this->input->post('query'), $_POST['op'],1)); 
			}
		}else{
			echo json_encode($this->product_model->search_product($this->input->post('query'),1));
		}
		
	}
}

