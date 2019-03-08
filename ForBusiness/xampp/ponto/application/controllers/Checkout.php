<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checkout extends CI_Controller {

	public function index()
	{		
		$this->load->model('checkout_model');
		$this->load->model('user_model');
		$this->template->frontpage = "false";

		if( $this->session->flashdata('data') ) {
			$data = $this->session->flashdata('data');
		}
		else {
			$data['reservation_type'] = $this->input->post('reservation_type');
			$data['reservation_data'] = $this->input->post('reservation_data');
			$data['reservation_date'] = $this->input->post('reservation_date');
			$data['reservation_session'] = $this->input->post('reservation_session');
			$data['reservation_bostamp'] = $this->input->post('reservation_bostamp');
			$data['PaymentMethods'] = $this->checkout_model->getPaymentMethods();
		}
		
		$data['checkout_cart'] = $this->checkout_model->get_cart($data['reservation_type'], $data['reservation_data'], $data['reservation_date'], $data['reservation_session'], $data['reservation_bostamp']);

		if( isset($_SESSION["user_id"]) && $_SESSION["user_id"] > 0 ) {
			//checkout
			$data['user'] = $this->user_model->get_user($_SESSION["user_id"]);
			
			$this->session->set_flashdata('data', $data);
			$this->template->content->view('checkout', $data);
			$this->template->publish();
		}
		else {
			//login or register
			$data['returnTo'] = 'checkout';
			
			$this->session->set_flashdata('data',$data);
			redirect('login');
		}
	}
	
	public function confirm()
	{		
		$this->load->model('checkout_model');
		$this->load->model('user_model');
		$this->load->model('phc_model');
		
		$this->template->frontpage = "false";
		
		if( $this->session->flashdata('data') ) {
			$data = $this->session->flashdata('data');
		}

		$PaymentMethod = $this->input->post("PaymentType");
		
		if( isset($_SESSION["user_id"]) && $_SESSION["user_id"] > 0 ) {
			//checkout
			$data['user'] = $this->user_model->get_user($_SESSION["user_id"]);
			$order_id = $this->checkout_model->save_tmp_order($data, $_SESSION["user_id"]);
			
			// log_message("ERROR", print_r($data, true));
			
			//SHA-OUT: Pson3200+-+-Ypal734489#+
			//SHA_IN: Ewa12345++!+
			
			$cart_total = 0;
			foreach( $data["checkout_cart"] as $linha ) {
				$cart_total += ( floatval($linha["qtt"]) * floatval($linha["unit_price"]) );
			}
			
			switch( $PaymentMethod ) {
				//Visa, Mastercard
				case 1:
				//Visa Electron
				case 3:
					$data["passData"] = array(
						"PSPID" => "EUROPEANWORLD",
						"ORDERID" => $order_id,
						"AMOUNT" => round($cart_total, 2)*100,
						"CURRENCY" => "EUR",
						'ACCEPTURL' => base_url() . 'checkout/accepted',
						'DECLINEURL' => base_url() . 'checkout/declined',
						'EXCEPTIONURL' => base_url() . 'checkout/exception',
						'CANCELURL' => base_url() . 'checkout/canceled',
					);
					
					$shasign = $this->checkout_model->get_sha256( $data["passData"], 'Pson3200+-+-Ypal734489#+' );
					$data["passData"]["SHASIGN"] = $shasign;
					$data["url"] = 'https://secure.ogone.com/ncol/test/orderstandard_utf8.asp';
					$this->load->view('checkout_creditcardpayment', $data);
					break;
			}
		}
		else {
			//login or register
			$data['returnTo'] = 'checkout';
			
			$this->session->set_flashdata('data',$data);
			redirect('login');
		}
	}
	
	public function accepted(){
		$this->load->model('checkout_model');
		$this->load->model('user_model');
		$this->load->model('phc_model');
		
		$this->template->frontpage = "false";
		
		$get = $this->input->get();
		$result = $this->checkout_model->get_sha256($get, 'Pson3200+-+-Ypal734489#+');
		
		// verificar se foi realmente enviado pela Ingenico
		if( $get["SHASIGN"] != $result ) {
			//contact Merchant
			$this->session->set_flashdata('data', $data);
			$this->template->content->view('checkout_incompleted', $data);
		}
		else {
			$data = $this->checkout_model->get_tmp_data( $get["orderID"] );
			$data["payment"] = $get;

			if( isset($_SESSION["user_id"]) && $_SESSION["user_id"] > 0 ) {
				//checkout
				$data['user'] = $this->user_model->get_user($_SESSION["user_id"]);
				//create encomenda PHC
				$data['origin'] = 'EWASITE';				
				$data["client_type"] = "client";
				
				$existe_order = $this->checkout_model->exist_tmp_data( $get["orderID"] );
					
				if( $existe_order )
				{
					$sql_status = $this->phc_model->create_order( $data );
					$this->checkout_model->delete_tmp_data( $data );
				}
				else
				{
					$sql_status = 1;
				}
				
				if( $sql_status ) {
					$this->session->set_flashdata('data', $data);
					$this->template->content->view('checkout_completed', $data);
				}
				else {
					$this->session->set_flashdata('data', $data);
					$this->template->content->view('checkout_incompleted', $data);
				}
			}
		}
		
		$this->template->publish();
    }
	
}
