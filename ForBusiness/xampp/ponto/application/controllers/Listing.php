<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Listing extends CI_Controller {

	public function index()
	{
		$this->load->library('position');
		$this->load->library('urlparameters');
		$this->load->library('pagination');
		$this->template->frontpage = "false";
		
		$this->load->model('product_model');
		
		$config = array();
		$data = array();
		$parame = $this->urlparameters->ArrayUrlToString($this->input->get(NULL, TRUE));
		$total_rows= $this->product_model->get_products($this->product_model->get_filters($this->input->get(NULL, TRUE)));
        $config["base_url"] = base_url()."listing";
        $config["suffix"] = $parame;
        $config["total_rows"] = $total_rows->num_rows();
        if( isset($_GET['per_page'])) 
		{
			$config["per_page"] = $_GET['per_page'];
		}else{
			$config["per_page"] = 5;
		}
		$data["per_page"]=$config["per_page"];
        $config["uri_segment"] = 2; 
		$config["filters"] = $this->input->get(NULL, TRUE);
		$config['full_tag_open'] = '<div ><ul class="pagination">';
		$config['full_tag_close'] = '</ul></div><!--pagination-->';

		$config['first_link'] = '&laquo; First';
		$config['first_tag_open'] = '<li class="prev page">';
		$config['first_tag_close'] = '</li>';

		$config['last_link'] = 'Last &raquo;';
		$config['last_tag_open'] = '<li class="next page">';
		$config['last_tag_close'] = '</li>';

		$config['next_link'] = 'Next &rarr;';
		$config['next_tag_open'] = '<li class="next page">';
		$config['next_tag_close'] = '</li>';

		$config['prev_link'] = '&larr; Previous';
		$config['prev_tag_open'] = '<li class="prev page">';
		$config['prev_tag_close'] = '</li>';

		$config['cur_tag_open'] = '<li class="active"><a href="">';
		$config['cur_tag_close'] = '</a></li>';

		$config['num_tag_open'] = '<li class="page">';
		$config['num_tag_close'] = '</li>';
		
		$this->pagination->initialize($config);

        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
		
        $data["links"] = $this->pagination->create_links();
		$data["filters"] = $this->product_model->get_filters($this->input->get(NULL, TRUE));
		$data["products"] = $this->product_model->get_products($data["filters"],$config["per_page"], $page, 1);
        $this->template->content->view('listing', $data);
		
		//no-image-slide.png
		$this->template->publish();
	}
}
