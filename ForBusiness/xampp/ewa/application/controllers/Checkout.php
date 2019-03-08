<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checkout extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('checkout_model');
		$this->load->model('wl_model');
		$this->load->library('mssql');
		$this->load->library('pagination');
		$this->load->helper('cookie');
		$this->load->library('urlparameters');
	}

	public function index()
	{
		$this->load->model('checkout_model');
		$this->load->model('user_model');
		$this->template->frontpage = "false";

		$anon_cookie = get_cookie('EWA');
		
		if( isset($_SESSION["user_id"]) && $_SESSION["user_id"] > 0 ) 
		{
			// temos login efetuado portanto temos que continuar a compra
			// verificar se temos cookie ativa. se tivermos cookie, então viemos de um login anónimo
			// temos de carregar a cookie para a cart
			if( !is_null( $anon_cookie ) )
			{
				$tmp = $this->checkout_model->get_cart_cookie( $anon_cookie );
			}
			
			if( null !== $this->input->post('reservation_session') )
			{
				$tmp['reservation_type'] = $this->input->post('reservation_type');
				$tmp['reservation_data'] = $this->input->post('reservation_data');
				$tmp['reservation_date'] = $this->input->post('reservation_date');
				$tmp['reservation_session'] = $this->input->post('reservation_session');
				$tmp['reservation_bostamp'] = $this->input->post('reservation_bostamp');
				$tmp['reservation_room'] = $this->input->post('reservation_room');
				$tmp['reservation_pickup'] = $this->input->post('reservation_pickup');
				$tmp['reservation_language'] = $this->input->post('reservation_language');
				$tmp['PaymentMethods'] = $this->checkout_model->getPaymentMethods();
				$tmp['checkout_cart'] = $this->checkout_model->get_cart($tmp['reservation_type'], $tmp['reservation_data'], $tmp['reservation_date'], $tmp['reservation_session'], $tmp['reservation_bostamp']);
				$tmp['returnTo'] = base_url() . 'checkout/';
				$tmp['voucher'] = array();
				$tmp['lastminute_taxes'] = array();
			}
			
			if( !isset($tmp['reservation_bostamp']) ) {
				$tmp['reservation_type'] = "";
				$tmp['reservation_data'] = "";
				$tmp['reservation_date'] = "";
				$tmp['reservation_session'] = "";
				$tmp['reservation_bostamp'] = "";
				$tmp['reservation_room'] = "";
				$tmp['reservation_pickup'] = "";
				$tmp['reservation_language'] = "";
				$tmp['PaymentMethods'] = $this->checkout_model->getPaymentMethods();
				$tmp['checkout_cart'] = array();
				$tmp['returnTo'] = base_url();
				$tmp['product'] = array();
				$tmp['taxasiva'] = array();
				$tmp['taxes'] = array();
				$tmp['voucher'] = array();
				$tmp['lastminute_taxes'] = array();
			}
			else {
				$tmp['product'] = $this->wl_model->get_product_data_stamp( $tmp['reservation_bostamp'], 1);
				$tmp['taxasiva'] = $this->wl_model->get_iva();
				$tmp['taxes'] = $this->wl_model->get_product_taxes( $tmp['reservation_bostamp'] );
				$tmp['lastminute_taxes'] = array();
			}
			
			$data['user'] = $this->user_model->get_user($_SESSION["user_id"]);
			$tmp['user'] = $this->user_model->get_user($_SESSION["user_id"]);
			
			$tmp['voucher'] = array();
			
			$id = $this->checkout_model->set_cart_cookie( $tmp, $anon_cookie );
			$cookie = array(
				'name'   => 'EWA',
				'value'  => $id,
				'expire' => '360',
				'path'   => '/'
			);
			set_cookie($cookie);
			
			$data = array_merge($data, $tmp);
			$this->template->content->view('checkout', $data);
			$this->template->publish();
		}
		else 
		{
			// nao temos login efetuado portanto temos de ir para pagina de login
			// temos no entanto que guardar a compra numa cookie para posterior carregamento
			// post existe portanto é uma nova compra
			if( null !== $this->input->post('reservation_session') )
			{
				$tmp['reservation_type'] = $this->input->post('reservation_type');
				$tmp['reservation_data'] = $this->input->post('reservation_data');
				$tmp['reservation_date'] = $this->input->post('reservation_date');
				$tmp['reservation_session'] = $this->input->post('reservation_session');
				$tmp['reservation_bostamp'] = $this->input->post('reservation_bostamp');
				$tmp['reservation_room'] = $this->input->post('reservation_room');
				$tmp['reservation_pickup'] = $this->input->post('reservation_pickup');
				$tmp['reservation_language'] = $this->input->post('reservation_language');
				$tmp['PaymentMethods'] = $this->checkout_model->getPaymentMethods();
				$tmp['checkout_cart'] = $this->checkout_model->get_cart($tmp['reservation_type'], $tmp['reservation_data'], $tmp['reservation_date'], $tmp['reservation_session'], $tmp['reservation_bostamp']);
				$tmp['returnTo'] = base_url() . 'checkout/';
				$tmp['product'] = $this->wl_model->get_product_data_stamp( $tmp['reservation_bostamp'], 1);
				$tmp['taxasiva'] = $this->wl_model->get_iva();
				$tmp['taxes'] = $this->wl_model->get_product_taxes( $tmp['reservation_bostamp'] );
				
				$id = $this->checkout_model->set_cart_cookie( $tmp, $anon_cookie );
				
				$cookie = array(
					'name'   => 'EWA',
					'value'  => $id,
					'expire' => '360',
					'path'   => '/'
				);
				set_cookie($cookie);
			}

			//login or register
			redirect('login');
		}
	}
	
	public function confirm()
	{
		$this->load->model('wl_model');
		$this->load->model('checkout_model');
		$this->load->model('user_model');
		$this->load->model('phc_model');
		
		$anon_cookie = get_cookie('EWA');
		$PaymentMethod = $this->input->post("PaymentType");
		
		if( isset($_SESSION["user_id"]) && $_SESSION["user_id"] > 0 ) {
			
			if( !is_null( $anon_cookie ) )
			{
				$tmp = $this->checkout_model->get_cart_cookie( $anon_cookie );
			}
			
			//checkout
			$data['user'] = $this->user_model->get_user($_SESSION["user_id"]);
			$tmp['user'] = $this->user_model->get_user($_SESSION["user_id"]);
			$data = array_merge($data, $tmp);
			$this->mssql->utf8_encode_deep( $data );
			
			$order_id = $this->checkout_model->save_tmp_order($data, $_SESSION["user_id"]);
			
			//SHA-OUT IN: Pson3200+-+-Ypal734489#+
			
			//calculo total ini------------------------
			//calculo total - variaveis
			$checkout_cart = $data["checkout_cart"];
			$lastminute_taxes = $data["lastminute_taxes"];
			$taxes = $data["taxes"];
			$voucher = $data["voucher"];
			$other_taxes = 0;
			$cart_total = 0;
			$subtotal = 0;
			$voucher_value = 0;
			
			//calculo total - subtotal
			foreach( $checkout_cart as $linha ) {
				$subtotal += ( floatval($linha["qtt"]) * floatval($linha["unit_price"]) );
			}

			//calculo total - taxas
			foreach( $taxes as $tax ) {			
				$cur_tax_value = 0;
				switch( $tax["formula"] ) {
					case '+%':
						$cur_tax_value += ($subtotal + $voucher_value) * floatval( $tax["value"] ) / 100;
						break;
					case '+v':
						$cur_tax_value +=  floatval( $tax["value"] );
						break;
				}
				$other_taxes += $cur_tax_value;
			}
			
			//calculo total
			$cart_total = $subtotal + $other_taxes + $voucher_value;
			
			//calculo total end------------------------
			
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
						'ACCEPTURL' => base_url() . 'checkout/accepted/',
						'DECLINEURL' => base_url() . 'checkout/declined/',
						'EXCEPTIONURL' => base_url() . 'checkout/exception/',
						'CANCELURL' => base_url() . 'checkout/canceled/'
					);
					
					$shasign = $this->checkout_model->get_sha256( $data["passData"], 'ojTOb*HMg5v9kmx.E}8' );
					$data["passData"]["SHASIGN"] = $shasign;
					$data["url"] = 'https://secure.ogone.com/ncol/test/orderstandard_utf8.asp';
					$this->load->view('checkout_creditcardpayment', $data);
					break;
			}
		}
		else {
			//login or register
			$tmp['returnTo'] = base_url() . 'checkout';
			$id = $this->checkout_model->set_cart_cookie( $tmp, $anon_cookie );
			
			$cookie = array(
				'name'   => 'EWA',
				'value'  => $id,
				'expire' => '360',
				'path'   => '/'
			);
			set_cookie($cookie);
			
			redirect( base_url() . 'login');
		}
	}
	
	public function accepted() {
		
		$this->load->model('wl_model');
		$this->load->model('checkout_model');
		$this->load->model('user_model');
		$this->load->model('phc_model');
		
		$this->template->frontpage = "false";
		
		$anon_cookie = get_cookie('EWA');
			
		if( !is_null( $anon_cookie ) )
		{
			$data = $this->checkout_model->get_cart_cookie( $anon_cookie );
		}
		
		$get = $this->input->get();
		$result = $this->checkout_model->get_sha256($get, 'cK=Rc6WvEVNCq8\9w(O');
		
		$data['origin'] = 'EWA';
		$data["client_type"] = $_SESSION["type"];
		$data['user'] = $this->user_model->get_user($_SESSION["user_id"]);
		
		$id = $this->checkout_model->set_cart_cookie( $data, $anon_cookie );
		$cookie = array(
			'name'   => 'EWA',
			'value'  => $id,
			'expire' => '360',
			'path'   => '/'
		);

		// verificar se foi realmente enviado pela Ingenico
		if( $get["SHASIGN"] != $result ) {
			//contact Merchant
			$this->template->content->view('checkout_incompleted', $data);
		}
		else {
			$data = array_merge($data, $this->checkout_model->get_tmp_data( $get["orderID"] ));
			$data["payment"] = $get;

			if( isset($_SESSION["user_id"]) && $_SESSION["user_id"] > 0 ) {
				//checkout
				$data['user'] = $this->user_model->get_user($_SESSION["user_id"]);
				//create encomenda PHC	
				$data['origin'] = 'EWA';
				$data["client_type"] = $_SESSION["type"];
				
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
				if( $sql_status[0] ) {
					$data['bostamp2'] = $sql_status[1];
					$this->template->content->view('checkout_completed', $data);
				}
				else {
					$this->template->content->view('checkout_incompleted', $data);
				}
				$this->template->publish();
			}
		}
    }
	
}
