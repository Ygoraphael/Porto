<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

	public function index()
	{
		$this->load->library('position');
		$this->template->frontpage = "false";
		$this->template->publish();
	}
	
	public function id() {
		$this->load->library('position');
		$this->template->frontpage = "false";
		$this->load->model('user_model');
		$this->load->model('product_model');
		$this->load->model('wl_model');
		$this->load->model('phc_model');
		
		$data = array();

		$data["product"] = $this->product_model->get_product_data($this->uri->segment(2), 1);
		$data["product_img"] = $this->product_model->get_product_img($this->uri->segment(2));
		$data["tickets"] = $this->product_model->get_product_tickets($this->uri->segment(2));
		$data["seats"] = $this->wl_model->get_product_seats($this->uri->segment(2));
		$data["extras"] = $this->wl_model->get_product_extras($this->uri->segment(2));
		$data["categories"] = $this->wl_model->get_product_categories($this->uri->segment(2));
		$data["languages"] = $this->phc_model->get_languages();

		if( sizeof($data["product"]) ) {
			$data["row"] = $data["product"][0];
		
			$data['related_products'] = $this->wl_model->get_related_products_mssql( $data['row']["bostamp"] );
			$data['pickups'] = $this->wl_model->get_ppickups_mssql_product($data['row']["bostamp"]);
			$data['planguages'] = $this->wl_model->get_product_languages($data['row']["bostamp"]);
			
			foreach($data["related_products"] as $key => $csm){
				$lastminute = $this->wl_model->get_lastminute_product( $data["related_products"][$key]["bostamp"]);
				if(sizeof($lastminute)>0){
					if(substr($lastminute[0]['formula'], 1, 8) == "%"){
						$formula= substr($lastminute[0]['formula'], 0, 1).number_format($lastminute[0]['value'],2).substr($lastminute[0]['formula'], 1, 8);
					}else{
						$formula= substr($lastminute[0]['formula'], 0, 1).number_format($lastminute[0]['value'],2)."€";
					}
					
					$data["related_products"][$key]["lastminute"]="1";				
					$data["related_products"][$key]["lastminute_formula"]=$formula;
				}else{
					$data["related_products"][$key]["lastminute"]="0";													
				}
			}
			
			$this->template->content->view('product', $data);
			$this->template->publish();
		}
	}
}
