<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {

	public function index()
	{
		$this->template->frontpage = "false";
		$this->load->model('user_model');
		
		$data['user'] = $this->user_model->get_user($_SESSION["user_id"]);
		
        $this->template->content->view('account_menu', $data);
        $this->template->content->view('account', $data);
        $this->template->publish();
	}
	
	public function orders()
	{
		$this->template->frontpage = "false";
		$this->load->model('user_model');
		$this->load->model('checkout_model');
		
		$data['user'] = $this->user_model->get_user($_SESSION["user_id"]);
		$data['orders'] = $this->checkout_model->get_orders( $_SESSION["user_id"] );
		
        $this->template->content->view('account_menu', $data);
        $this->template->content->view('account_orders', $data);
        $this->template->publish();
	}
	
	public function order()
	{
		$this->template->frontpage = "false";
		$this->load->model('user_model');
		$this->load->model('checkout_model');
		
		$data['bostamp'] = $this->uri->segment(3);
		$data['user'] = $this->user_model->get_user($_SESSION["user_id"]);
		$data['order'] = $this->checkout_model->get_order( $data['bostamp'] );
		$data['order'] = $data['order'][0];
		$data['order_bi'] = $this->checkout_model->get_order_bi( $data['bostamp'] );
		
        $this->template->content->view('account_menu', $data);
        $this->template->content->view('account_order', $data);
        $this->template->publish();
	}
	
	public function updateaccount()
	{
		$this->load->model('user_model');
		$data = new stdClass();
		
		if ( $this->user_model->update_user($_SESSION["user_id"], $this->input->post()) ) {
			$data->success = 1;
		}
		else {
			$data->error = "Your request can't be completed right now. Please try again later.";
			$data->success = 0;
		}
		
		echo json_encode($data);
	}
}
