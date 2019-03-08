<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Backoffice extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('user_model');
		
		if( isset($_SESSION["backoffice_user_id"]) ) {
			$data['user'] = $this->user_model->get_backoffice_user( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"] );
			$cur_url = $this->uri->segment(2);
			if($cur_url == "")
				$cur_url = "dashboard";
			
			$acesso = $this->user_model->get_user_access( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"], $cur_url, '' );
			
			if( !$acesso ) {
				redirect('/backoffice/denied');
			}
		}
	}
	
	public function locations() {
		$this->template->frontpage = "false";
		$this->load->model('user_model');
		$this->load->model('product_model');
		$this->load->model('phc_model');
		$this->template->set_template('template_bo');
		
		if( isset($_SESSION["backoffice_user_id"]) && $_SESSION["backoffice_user_id"] > 0 ) {
			$data['title'] = 'Locations';
			$data['user'] = $this->user_model->get_backoffice_user( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"] );
			$data['locations'] = $this->product_model->get_locations_mssql( $_SESSION["backoffice_user_id"] );
			$this->template->content->view('backoffice-locations', $data);
			$this->template->publish();
		}
		else {
			//login or register
			$data['returnTo'] = 'backoffice';
			$this->session->set_flashdata('data',$data);
			redirect('backoffice_login');
		}
	}
	
	public function location() {
		$this->template->frontpage = "false";
		$this->load->model('user_model');
		$this->load->model('product_model');
		$this->load->model('phc_model');
		$this->template->set_template('template_bo');
		
		if( isset($_SESSION["backoffice_user_id"]) && $_SESSION["backoffice_user_id"] > 0 ) {
			$locationstamp = $this->uri->segment(3);
			$data['title'] = 'Location';
			$data['user'] = $this->user_model->get_backoffice_user( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"] );
			$data['location'] = $this->product_model->get_location_mssql( $locationstamp, $_SESSION["backoffice_user_id"] );
			$data['countries'] = $this->product_model->get_countries();
			$this->template->content->view('backoffice-location', $data);
			$this->template->publish();
		}
		else {
			//login or register
			$data['returnTo'] = 'backoffice';
			$this->session->set_flashdata('data',$data);
			redirect('backoffice_login');
		}
	}
	
	public function lastminute() {
		$this->template->frontpage = "false";
		$this->load->model('user_model');
		$this->load->model('product_model');
		$this->load->model('phc_model');
		$this->template->set_template('template_bo');
		
		if( isset($_SESSION["backoffice_user_id"]) && $_SESSION["backoffice_user_id"] > 0 ) {
			$data['title'] = 'Product Order / Last Minute';
			$data['user'] = $this->user_model->get_backoffice_user( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"] );
			$data['lastminute'] = $this->product_model->get_lastminute_mssql( $_SESSION["backoffice_user_id"] );
			$data['products'] = $this->product_model->operator_get_products_mssql( $_SESSION["backoffice_user_id"] );
			$data['taxes'] = $this->user_model->get_taxes_mssql( $_SESSION["backoffice_user_id"] );
			$this->template->content->view('backoffice-lastminute', $data);
		}
		else {
			//login or register
			$data['returnTo'] = 'backoffice';
			$this->session->set_flashdata('data',$data);
			redirect('backoffice_login');
		}
		$this->template->publish();
	}
	
	public function settings_users() {
		$this->template->frontpage = "false";
		$this->load->model('user_model');
		$this->load->model('product_model');
		$this->load->model('phc_model');
		$this->template->set_template('template_bo');
		
		if( isset($_SESSION["backoffice_user_id"]) && $_SESSION["backoffice_user_id"] > 0 ) {
			$acesso = $this->user_model->get_user_access( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"], '', 'SA8F7CC056595A399CD789' );
			
			if( !$acesso ) {
				redirect('/backoffice/denied');
			}else
			{
				$data['title'] = 'Users';
				$data['view_user'] = $this->user_model->get_user_access( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"], '', 'SA9D40AEF8FCD951C03B88' );
				$data['create_user'] = $this->user_model->get_user_access( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"], '', 'SAC1ECBFE53E3075E44804' );
				$data['user'] = $this->user_model->get_backoffice_user( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"] );
				$data['users'] = $this->user_model->get_operator_users_mssql( $_SESSION["backoffice_user_id"] );
				$this->template->content->view('backoffice-settings-users', $data);
			}
		}
		else {
			//login or register
			$data['returnTo'] = 'backoffice';
			$this->session->set_flashdata('data',$data);
			redirect('backoffice_login');
		}
		$this->template->publish();
	}
	
	public function settings_taxes() {
		$this->template->frontpage = "false";
		$this->load->model('user_model');
		$this->load->model('product_model');
		$this->load->model('phc_model');
		$this->template->set_template('template_bo');
		
		if( isset($_SESSION["backoffice_user_id"]) && $_SESSION["backoffice_user_id"] > 0 ) {
			$data['title'] = 'Taxes & Fees';
			$data['user'] = $this->user_model->get_backoffice_user( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"] );
			$data['taxes'] = $this->user_model->get_taxes_mssql( $_SESSION["backoffice_user_id"] );
			$this->template->content->view('backoffice-settings-taxes', $data);
		}
		else {
			//login or register
			$data['returnTo'] = 'backoffice';
			$this->session->set_flashdata('data',$data);
			redirect('backoffice_login');
		}
		$this->template->publish();
	}
	
	public function tax() {
		$this->template->frontpage = "false";
		$this->load->model('user_model');
		$this->load->model('product_model');
		$this->load->model('phc_model');
		$this->template->set_template('template_bo');
		
		if( isset($_SESSION["backoffice_user_id"]) && $_SESSION["backoffice_user_id"] > 0 ) {
			$u_taxstamp = $this->uri->segment(3);
			$data['title'] = 'Tax/Fee';
			$data['user'] = $this->user_model->get_backoffice_user( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"] );
			$data['tax'] = $this->product_model->get_tax_mssql( $u_taxstamp, $_SESSION["backoffice_user_id"] );
			$this->template->content->view('backoffice-tax', $data);
			$this->template->publish();
		}
		else {
			//login or register
			$data['returnTo'] = 'backoffice';
			$this->session->set_flashdata('data',$data);
			redirect('backoffice_login');
		}
	}
	
	public function user() {
		$this->template->frontpage = "false";
		$this->load->model('user_model');
		$this->load->model('product_model');
		$this->load->model('phc_model');
		$this->template->set_template('template_bo');
		
		if( isset($_SESSION["backoffice_user_id"]) && $_SESSION["backoffice_user_id"] > 0 ) {
			$acesso = $this->user_model->get_user_access( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"], '', 'SA9D40AEF8FCD951C03B88' );
			
			if( !$acesso ) {
				redirect('/backoffice/denied');
			}else
			{
				$data['title'] = 'User';
				
				$no = $this->uri->segment(3);
				$estab = $this->uri->segment(4);

				if( $no != $_SESSION["backoffice_user_id"] or trim($estab) == ""  ) {
					redirect('/backoffice/denied');
				}
				else {
					$data['user'] = $this->user_model->get_backoffice_user( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"] );
					$data['user_data'] = $this->user_model->get_backoffice_user_mssql( $no, $estab );
					$data['access_list'] = $this->user_model->get_user_access_mssql( $no, $estab );
					
					$this->template->content->view('backoffice-user', $data);
				}
			}
		}
		else {
			//login or register
			$data['returnTo'] = 'backoffice';
			$this->session->set_flashdata('data',$data);
			redirect('backoffice_login');
		}
		$this->template->publish();
	}
	
	public function get_saft() {
		$this->template->frontpage = "false";
		$this->load->model('user_model');
		$this->load->model('product_model');
		$this->load->model('phc_model');
		$this->load->library('drivefx');
		
		if( isset($_SESSION["backoffice_user_id"]) && $_SESSION["backoffice_user_id"] > 0 ) {
			$data['title'] = 'SAF-T PT';
			$data['user'] = $this->user_model->get_backoffice_user( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"] );
			
			$dfx_data = $this->phc_model->get_drivefx_credential( $_SESSION["backoffice_user_id"] );
			$year = $this->uri->segment(3);
			$month = $this->uri->segment(4);
			
			$query_date = $year.'-'.$month.'-01';
			$first_day = date('Y-m-01', strtotime($query_date));
			$last_day = date('Y-m-t', strtotime($query_date));
			
			if( strtotime($last_day) > strtotime("now") ) {
				$last_day = date('Y-m-d', strtotime("now"));
			}
			
			if( sizeof($dfx_data) > 0 && $dfx_data[0]["U_FTAUTO"] ) {
				$this->drivefx->set_credentials( $dfx_data[0]["U_DFXURL"], $dfx_data[0]["U_DFXUSER"], $dfx_data[0]["U_DFXPASS"], $dfx_data[0]["U_DFXTYPE"], $dfx_data[0]["U_DFXCOMP"] );
				$this->drivefx->login();
				$this->drivefx->get_saft( $year, $first_day, $last_day, $dfx_data[0]["cae"] );
				$this->drivefx->logout();
				
				if( $this->drivefx->error != '' ) {
					print_r($this->drivefx->error);
				}
			}
		}
	}
	
	public function orders()
	{
		$this->template->frontpage = "false";
		$this->load->model('user_model');
		$this->load->model('product_model');
		$this->template->set_template('template_bo');

		if( isset($_SESSION["backoffice_user_id"]) && $_SESSION["backoffice_user_id"] > 0 ) {
			
			$data['title'] = 'Orders';
			$data['user'] = $this->user_model->get_backoffice_user( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"] );
			
			if( !$this->input->post('id') ){
				$acesso = $this->user_model->get_user_access( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"], '', 'SABCF743DD9696D97311C9' );
			
				if( !$acesso ) {
					redirect('/backoffice/denied');
				}else{

					if( $data['user']["u_operador"] == 'Sim' ) {
						$order_view = $this->user_model->get_user_access( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"], '', 'SA6BB4EC227D94FAA9955B' );
						$data['order_view'] = $order_view;
						$data['payments'] = $this->product_model->operator_get_payment_mssql("nocts",$_SESSION["backoffice_user_id"]);
						$data['agents'] = $this->product_model->operator_get_agents_mssql( $_SESSION["backoffice_user_id"] );
						$data['products'] = $this->product_model->operator_get_products_mssql( $_SESSION["backoffice_user_id"] );

					}else{
						$order_view = $this->user_model->get_user_access( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"], '', 'SA6BB4EC227D94FAA9955B' );
						$data['order_view'] = $order_view;
						$data['payments'] = $this->product_model->operator_get_payment_mssql("TKHDID",$_SESSION["backoffice_user_id"]);
						$data['agents'] = $this->product_model->agent_get_operators_mssql( $_SESSION["backoffice_user_id"] );
						$data['products'] = $this->product_model->agent_get_products_mssql( $_SESSION["backoffice_user_id"] );

					}

					$data['locals'] = $this->product_model->operator_get_local_mssql($_SESSION["backoffice_user_id"]);
					$this->template->content->view('backoffice-orders', $data);
				}
			}

			if($this->input->post('id') ){
				$acesso = $this->user_model->get_user_access( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"], '', 'SA6BB4EC227D94FAA9955B' );
			
				if( !$acesso ) {
					redirect('/backoffice/denied');
				}else{
					if( $data['user']["u_agente"] == 'Sim' )
						$data['order'] = $this->product_model->get_order_bystamp( $this->input->post('id'), "tkhdid" );
					if( $data['user']["u_operador"] == 'Sim' )
						$data['order'] = $this->product_model->get_order_bystamp( $this->input->post('id'), "nocts" );
					
					$data['title'] = 'Order nº ' . $data['order'][0]["obrano"];
					$data['order'] = $data['order'][0];
					$data['order_bi'] = $this->product_model->get_order_bi_bystamp( $this->input->post('id') );
					$data['user'] = $this->user_model->get_backoffice_user( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"] );
					$this->template->content->view('backoffice-order', $data);
				}
			}
		}
		else {
			//login or register
			$data['returnTo'] = 'backoffice';
			$this->session->set_flashdata('data',$data);
			redirect('backoffice_login');
		}
		$this->template->publish();
	}

	
	public function saft() {
		$this->template->frontpage = "false";
		$this->load->model('user_model');
		$this->load->model('product_model');
		$this->load->model('phc_model');
		$this->load->library('drivefx');
		$this->template->set_template('template_bo');
		
		if( isset($_SESSION["backoffice_user_id"]) && $_SESSION["backoffice_user_id"] > 0 ) {
			$acesso = $this->user_model->get_user_access( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"], '', 'SAF7759C566505A59BF2FE' );
			if( !$acesso ) {
				redirect('/backoffice/denied');
			}else{
				$data['title'] = 'SAF-T PT';
				$data['user'] = $this->user_model->get_backoffice_user( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"] );
				$this->template->content->view('backoffice-saft', $data);
			}
		}
		else {
			//login or register
			$data['returnTo'] = 'backoffice';
			$this->session->set_flashdata('data',$data);
			redirect('backoffice_login');
		}
		
        $this->template->publish();
	}
	
	public function pickups()
	{
		$this->template->frontpage = "false";
		$this->load->model('user_model');
		$this->load->model('product_model');
		$this->load->model('phc_model');
		$this->template->set_template('template_bo');
		
		if( isset($_SESSION["backoffice_user_id"]) && $_SESSION["backoffice_user_id"] > 0 ) {
			$data['title'] = 'Pickups';
			$data['user'] = $this->user_model->get_backoffice_user( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"] );
			$data['pickups'] = $this->product_model->get_pickups_mssql( $_SESSION["backoffice_user_id"] );
			$this->template->content->view('backoffice-pickups', $data);
		}
		else {
			//login or register
			$data['returnTo'] = 'backoffice';
			$this->session->set_flashdata('data',$data);
			redirect('backoffice_login');
		}
		
        $this->template->publish();
	}
	
	public function pickup()
	{
		$this->template->frontpage = "false";
		$this->load->model('user_model');
		$this->load->model('product_model');
		$this->load->model('phc_model');
		$this->template->set_template('template_bo');
		
		if( isset($_SESSION["backoffice_user_id"]) && $_SESSION["backoffice_user_id"] > 0 ) {
			$u_pickupstamp = $this->uri->segment(3);
			$data['title'] = 'Pickup';
			$data['user'] = $this->user_model->get_backoffice_user( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"] );
			$data['countries'] = $this->product_model->get_countries();
			$data['u_pickup'] = $this->product_model->get_pickup_mssql( $u_pickupstamp, $_SESSION["backoffice_user_id"] );
			$this->template->content->view('backoffice-pickup', $data);
		}
		else {
			//login or register
			$data['returnTo'] = 'backoffice';
			$this->session->set_flashdata('data',$data);
			redirect('backoffice_login');
		}
		
        $this->template->publish();
	}
	
	public function extras()
	{
		$this->template->frontpage = "false";
		$this->load->model('user_model');
		$this->load->model('product_model');
		$this->load->model('phc_model');
		$this->template->set_template('template_bo');
		
		if( isset($_SESSION["backoffice_user_id"]) && $_SESSION["backoffice_user_id"] > 0 ) {
			
			$acesso = $this->user_model->get_user_access( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"], '', 'SA360D20B1354FB0DB9428' );
			$acesso_resources_usase = $this->user_model->get_user_access( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"], '', 'SA6F92F41EA303ACBBF936' );
			
			if( !$acesso ) {
				redirect('/backoffice/denied');
			}else{
				$data['title'] = 'Extras';
				$data['acesso_resources_usase'] = $acesso_resources_usase;
				$data['user'] = $this->user_model->get_backoffice_user( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"] );
				$data['extras'] = $this->phc_model->get_extras_mssql( $_SESSION["backoffice_user_id"] );
				$this->template->content->view('backoffice-extras', $data);
			}
		}
		else {
			//login or register
			$data['returnTo'] = 'backoffice';
			$this->session->set_flashdata('data',$data);
			redirect('backoffice_login');
		}
		
        $this->template->publish();
	}
	
	public function extras_usage()
	{
		$this->template->frontpage = "false";
		$this->load->model('user_model');
		$this->load->model('product_model');
		$this->load->model('phc_model');
		$this->template->set_template('template_bo');
		
		if( isset($_SESSION["backoffice_user_id"]) && $_SESSION["backoffice_user_id"] > 0 ) {
			$acesso = $this->user_model->get_user_access( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"], '', 'SA6F92F41EA303ACBBF936' );
			if( !$acesso ) {
				redirect('/backoffice/denied');
			}else{
				$data['title'] = 'Resources Usage';
				$data['user'] = $this->user_model->get_backoffice_user( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"] );
				$data['products'] = $this->product_model->operator_get_products_mssql( $_SESSION["backoffice_user_id"] );
				$data['extras'] = $this->phc_model->get_extras_mssql( $_SESSION["backoffice_user_id"] );
				$this->template->content->view('backoffice-extras-usage', $data);
			}
		}
		else {
			//login or register
			$data['returnTo'] = 'backoffice';
			$this->session->set_flashdata('data',$data);
			redirect('backoffice_login');
		}
		
        $this->template->publish();
	}
	
	
	public function settings_profile()
	{
		$this->template->frontpage = "false";
		$this->load->model('user_model');
		$this->load->model('product_model');
		$this->load->model('phc_model');
		$this->template->set_template('template_bo');
		
		if( isset($_SESSION["backoffice_user_id"]) && $_SESSION["backoffice_user_id"] > 0 ) {
			$data['title'] = 'Profile';
			$data['user'] = $this->user_model->get_backoffice_user( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"] );
			$data['profile'] = $this->phc_model->get_profile( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"] );
			$data['profile']=$data['profile'][0];
			$this->template->content->view('backoffice-profile', $data);
		}
		else {
			//login or register
			$data['returnTo'] = 'backoffice';
			$this->session->set_flashdata('data',$data);
			redirect('backoffice_login');
		}
		
        $this->template->publish();
	}
	
	public function settings_regional()
	{
		$this->template->frontpage = "false";
		$this->load->model('user_model');
		$this->load->model('product_model');
		$this->load->model('phc_model');
		$this->template->set_template('template_bo');
		
		if( isset($_SESSION["backoffice_user_id"]) && $_SESSION["backoffice_user_id"] > 0 ) {
			$data['title'] = 'Regional Settings';
			$data['user'] = $this->user_model->get_backoffice_user( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"] );
			$data['profile'] = $this->phc_model->get_profile( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"] );
			$data['languages'] = $this->phc_model->get_languages();
			$data['profile']=$data['profile'][0];
			$this->template->content->view('backoffice-profile-settings-regional', $data);
		}
		else {
			//login or register
			$data['returnTo'] = 'backoffice';
			$this->session->set_flashdata('data',$data);
			redirect('backoffice_login');
		}
		
        $this->template->publish();
	}
	
	public function rep_treasury()
	{
		$this->template->frontpage = "false";
		$this->load->model('user_model');
		$this->load->model('product_model');
		$this->template->set_template('template_bo');
		
		if( isset($_SESSION["backoffice_user_id"]) && $_SESSION["backoffice_user_id"] > 0 ) {
			$acesso = $this->user_model->get_user_access( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"], '', 'SA6DA85C460B130DAA5400' );
			
			if( !$acesso ) {
				redirect('/backoffice/denied');
			}else
			{	
				$data['title'] = 'Treasury';
				$data['user'] = $this->user_model->get_backoffice_user( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"] );
				$data['products'] = $this->product_model->operator_get_products_mssql( $_SESSION["backoffice_user_id"] );
				$data['agents'] = $this->product_model->operator_get_agents_mssql( $_SESSION["backoffice_user_id"] );
				$data['u_tick'] = $this->product_model->get_tickets_mssql();
				$data['locations'] = $this->product_model->get_locations_mssql( $_SESSION["backoffice_user_id"] );
				$this->template->content->view('backoffice-treasury', $data);
			}
		}
		else {
			//login or register
			$data['returnTo'] = 'backoffice';
			$this->session->set_flashdata('data',$data);
			redirect('backoffice_login');
		}
		
        $this->template->publish();
	}
	
	public function rep_agent_treasury()
	{
		$this->template->frontpage = "false";
		$this->load->model('user_model');
		$this->load->model('product_model');
		$this->template->set_template('template_bo');
		
		if( isset($_SESSION["backoffice_user_id"]) && $_SESSION["backoffice_user_id"] > 0 ) {
			$acesso = $this->user_model->get_user_access( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"], '', 'SA6DA85C460B130DAA5400' );
			
			if( !$acesso ) {
				redirect('/backoffice/denied');
			}else
			{	
				$data['title'] = 'Treasury';
				$data['user'] = $this->user_model->get_backoffice_user( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"] );
				$data['operators'] = $this->product_model->agent_get_operators_mssql( $_SESSION["backoffice_user_id"] );
				$this->template->content->view('backoffice-agent-treasury', $data);
			}
		}
		else {
			//login or register
			$data['returnTo'] = 'backoffice';
			$this->session->set_flashdata('data',$data);
			redirect('backoffice_login');
		}
		
        $this->template->publish();
	}
	
	public function rep_reimbursement()
	{
		$this->template->frontpage = "false";
		$this->load->model('user_model');
		$this->load->model('product_model');
		$this->load->model('phc_model');
		$this->template->set_template('template_bo');
		
		if( isset($_SESSION["backoffice_user_id"]) && $_SESSION["backoffice_user_id"] > 0 ) {
			$acesso = $this->user_model->get_user_access( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"], '', 'SA6DA85C460B130DAA5400' );
			
			if( !$acesso ) {
				redirect('/backoffice/denied');
			}
			else
			{	
				$data['title'] = 'Reimbursements';
				$data['user'] = $this->user_model->get_backoffice_user( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"] );
				$data['agents'] = $this->product_model->operator_get_agents_mssql( $_SESSION["backoffice_user_id"] );
				$this->template->content->view('backoffice-reimbursement', $data);
			}
		}
		else {
			//login or register
			$data['returnTo'] = 'backoffice';
			$this->session->set_flashdata('data',$data);
			redirect('backoffice_login');
		}
		
        $this->template->publish();
	}
	
	public function rep_fees()
	{
		$this->template->frontpage = "false";
		$this->load->model('user_model');
		$this->load->model('product_model');
		$this->template->set_template('template_bo');
		
		if( isset($_SESSION["backoffice_user_id"]) && $_SESSION["backoffice_user_id"] > 0 ) {
			$acesso = $this->user_model->get_user_access( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"], '', 'SA6DA85C460B130DAA5400' );
			
			if( !$acesso ) {
				redirect('/backoffice/denied');
			}else
			{	
				$data['title'] = 'My Fees';
				$data['user'] = $this->user_model->get_backoffice_user( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"] );
				$data['products'] = $this->product_model->operator_get_products_mssql( $_SESSION["backoffice_user_id"] );
				$data['agents'] = $this->product_model->operator_get_agents_mssql( $_SESSION["backoffice_user_id"] );
				$data['u_tick'] = $this->product_model->get_tickets_mssql();
				$data['locations'] = $this->product_model->get_locations_mssql( $_SESSION["backoffice_user_id"] );
				$this->template->content->view('backoffice-sales-fees', $data);
			}
		}
		else {
			//login or register
			$data['returnTo'] = 'backoffice';
			$this->session->set_flashdata('data',$data);
			redirect('backoffice_login');
		}
		
        $this->template->publish();
	}
	
	public function calendar()
	{
		$this->template->frontpage = "false";
		$this->load->model('user_model');
		$this->load->model('product_model');
		$this->template->set_template('template_bo');
		
		if( isset($_SESSION["backoffice_user_id"]) && $_SESSION["backoffice_user_id"] > 0 ) {
			$acesso = $this->user_model->get_user_access( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"], '', 'SA8A06BB3A68C080CA9854' );
			
			if( !$acesso ) {
				redirect('/backoffice/denied');
			}else
			{	
				$data['title'] = 'Calendar';
				$data['user'] = $this->user_model->get_backoffice_user( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"] );
				$data['products'] = $this->product_model->operator_get_products_mssql( $_SESSION["backoffice_user_id"] );
				$this->template->content->view('backoffice-calendar', $data);
			}
		}
		else {
			//login or register
			$data['returnTo'] = 'backoffice';
			$this->session->set_flashdata('data',$data);
			redirect('backoffice_login');
		}
		
        $this->template->publish();
	}
	
	public function rep_orders()
	{
		$this->template->frontpage = "false";
		$this->load->model('user_model');
		$this->load->model('product_model');
		$this->template->set_template('template_bo');
		
		if( isset($_SESSION["backoffice_user_id"]) && $_SESSION["backoffice_user_id"] > 0 ) {
			$acesso = $this->user_model->get_user_access( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"], '', 'SA7A14DEF7DEBCF27DAF3F' );
			
			if( !$acesso ) {
				redirect('/backoffice/denied');
			}else
			{	
				$data['title'] = 'Sales orders';
				$data['user'] = $this->user_model->get_backoffice_user( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"] );
				$data['products'] = $this->product_model->operator_get_products_mssql( $_SESSION["backoffice_user_id"] );
				$data['agents'] = $this->product_model->operator_get_agents_mssql( $_SESSION["backoffice_user_id"] );
				$data['locations'] = $this->product_model->get_locations_mssql( $_SESSION["backoffice_user_id"] );
				$this->template->content->view('backoffice-sales-orders', $data);
			}
		}
		else {
			//login or register
			$data['returnTo'] = 'backoffice';
			$this->session->set_flashdata('data',$data);
			redirect('backoffice_login');
		}
		
        $this->template->publish();
	}
	
	public function denied()
	{
		if( isset($_SESSION["backoffice_user_id"]) ) {
			$data['user'] = $this->user_model->get_backoffice_user( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"] );
		}
		$data['title'] = 'Access Denied';
		$this->template->frontpage = "false";
		$this->template->set_template('template_bo');
		$this->template->content->view('backoffice-denied', $data);
		$this->template->publish();
	}
	
	public function index()
	{
		$this->template->frontpage = "false";
		$this->load->model('user_model');
		$this->template->set_template('template_bo');
		
		$cur_url = $this->uri->segment(1).'/'.$this->uri->segment(2);
		
		if( isset($_SESSION["backoffice_user_id"]) && $_SESSION["backoffice_user_id"] > 0 ) {
			$acesso = $this->user_model->get_user_access( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"], '', 'SAF89DDD5879F910F2B961' );
			
			if( !$acesso ) {
				$data['title'] = 'Home';
				$data['user'] = $this->user_model->get_backoffice_user( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"] );
				$this->template->content->view('backoffice-home-denied', $data);
			}else
			{				
				$data['title'] = 'Dashboard';
				$data['user'] = $this->user_model->get_backoffice_user( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"] );
				$this->template->content->view('backoffice-dashboard', $data);
			}
		}
		else {
			//login or register
			$data['returnTo'] = 'backoffice';
			
			$this->session->set_flashdata('data',$data);
			redirect('backoffice_login');
		}
		
        $this->template->publish();
	}
	
	public function agent_new()
	{
		$this->template->frontpage = "false";
		$this->load->model('user_model');
		$this->load->model('product_model');
		$this->template->set_template('template_bo');
		
		if( isset($_SESSION["backoffice_user_id"]) && $_SESSION["backoffice_user_id"] > 0 ) {
			$data['title'] = 'New Agent';
			$data['user'] = $this->user_model->get_backoffice_user( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"] );
			$data['ag_vat'] = $this->input->get("v");
			
			$this->template->content->view('backoffice-new-agent', $data);
		}
		else {
			//login or register
			$data['returnTo'] = 'backoffice';
			$this->session->set_flashdata('data',$data);
			redirect('backoffice_login');
		}
		
        $this->template->publish();
	}
	
	public function agents()
	{
		$this->template->frontpage = "false";
		$this->load->model('user_model');
		$this->load->model('product_model');
		$this->template->set_template('template_bo');
		
		if( isset($_SESSION["backoffice_user_id"]) && $_SESSION["backoffice_user_id"] > 0 ) {
			$acesso = $this->user_model->get_user_access( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"], '', 'SA67019ECEF7C192FAA31C' );
			$acesso_view = $this->user_model->get_user_access( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"], '', 'SAC8FCB47326EB61266AB5' );
			$acesso_create = $this->user_model->get_user_access( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"], '', 'SA3E16944885C6694D1212' );
			
			if( !$acesso ) {
				redirect('/backoffice/denied');
			}else
			{	
				$data['title'] = 'Agents';
				$data['acesso_view'] = $acesso_view;
				$data['acesso_create'] = $acesso_create;
				$data['user'] = $this->user_model->get_backoffice_user( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"] );
				$data['agents'] = $this->product_model->operator_get_agents_mssql( $_SESSION["backoffice_user_id"] );
				$this->template->content->view('backoffice-agents', $data);
			}
		}
		else {
			//login or register
			$data['returnTo'] = 'backoffice';
			$this->session->set_flashdata('data',$data);
			redirect('backoffice_login');
		}
		
        $this->template->publish();
	}
	
	public function vouchers()
	{
		$this->template->frontpage = "false";
		$this->load->model('user_model');
		$this->load->model('phc_model');
		$this->template->set_template('template_bo');
		
		if( isset($_SESSION["backoffice_user_id"]) && $_SESSION["backoffice_user_id"] > 0 ) {
			$acesso = $this->user_model->get_user_access( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"], '', 'SAA2DF21D14BF47B9B81EB' );
			$access_cvoucher = $this->user_model->get_user_access( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"], '', 'SA4E0C5BA3DB729BF07ECD' );
			$access_view = $this->user_model->get_user_access( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"], '', 'SAB9CB4C86AA0B0F5DD874' );
			
			if( !$acesso ) {
				redirect('/backoffice/denied');
			}else
			{	
				$data['title'] = 'Vouchers';
				$data['access_view'] = $access_view;
				$data['access_cvoucher'] = $access_cvoucher;
				$data['user'] = $this->user_model->get_backoffice_user( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"] );
				$data['vouchers'] = $this->phc_model->get_vouchers( $_SESSION["backoffice_user_id"] );
				$this->template->content->view('backoffice-vouchers', $data);
			}
		}
		else {
			//login or register
			$data['returnTo'] = 'backoffice';
			$this->session->set_flashdata('data',$data);
			redirect('backoffice_login');
		}
		
        $this->template->publish();
	}
	
	
	public function voucher()
	{
		$this->template->frontpage = "false";
		$this->load->model('user_model');
		$this->load->model('phc_model');
		$this->load->model('product_model');
		$this->template->set_template('template_bo');
		
		if( isset($_SESSION["backoffice_user_id"]) && $_SESSION["backoffice_user_id"] > 0 ) {
			$access_view = $this->user_model->get_user_access( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"], '', 'SAB9CB4C86AA0B0F5DD874' );
			
			if( !$access_view ) {
				redirect('/backoffice/denied');
			}else
			{	
				$u_vouchstamp = $_POST['id'];
				if( $u_vouchstamp =="") {
					redirect('/backoffice/vouchers');
				}
				$data['voucher'] = $this->phc_model->get_vouchers_stamp( $_SESSION["backoffice_user_id"], $u_vouchstamp);
				$data['voucher'] = $data['voucher'][0];
				$data['title'] = 'Voucher - '.$data['voucher']['code'];
				$data['pvoucher'] = $this->phc_model->get_pvouchers_stamp( $_SESSION["backoffice_user_id"], $data['voucher']['u_vouchstamp']);
				$data['user'] = $this->user_model->get_backoffice_user( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"] );
				$data['products'] = $this->product_model->operator_get_products_mssql( $_SESSION["backoffice_user_id"] );
				$this->template->content->view('backoffice-edit-vouch', $data);
			}
		}
		else {
			//login or register
			$data['returnTo'] = 'backoffice';
			$this->session->set_flashdata('data',$data);
			redirect('backoffice_login');
		}
		
        $this->template->publish();
	}
	
	
	public function voucher_new()
	{
		$this->template->frontpage = "false";
		$this->load->model('user_model');
		$this->load->model('product_model');
		$this->template->set_template('template_bo');
		
		if( isset($_SESSION["backoffice_user_id"]) && $_SESSION["backoffice_user_id"] > 0 ) {
			$acesso = $this->user_model->get_user_access( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"], '', 'SA4E0C5BA3DB729BF07ECD' );
			
			if( !$acesso ) {
				redirect('/backoffice/denied');
			}else
			{	
				$data['title'] = 'Voucher';
				$data['user'] = $this->user_model->get_backoffice_user( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"] );
				$data['products'] = $this->product_model->operator_get_products_mssql( $_SESSION["backoffice_user_id"] );
				$this->template->content->view('backoffice-new-vouch', $data);
			}
		}
		else {
			//login or register
			$data['returnTo'] = 'backoffice';
			$this->session->set_flashdata('data',$data);
			redirect('backoffice_login');
		}
		
        $this->template->publish();
	}
	
	public function products()
	{
		$this->template->frontpage = "false";
		$this->load->model('user_model');
		$this->load->model('product_model');
		$this->template->set_template('template_bo');
		
		if( isset($_SESSION["backoffice_user_id"]) && $_SESSION["backoffice_user_id"] > 0 ) {
			
			$acesso = $this->user_model->get_user_access( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"], '', 'SAC900184B5F312E402FFF' );
			$acesso_create = $this->user_model->get_user_access( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"], '', 'SAC15A5D42B3E0E0F2E0F1' );
			$acesso_view = $this->user_model->get_user_access( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"], '', 'SA8D7C96FC0EE90EC56B77' );
			
			if( !$acesso ) {
				redirect('/backoffice/denied');
			}
			else {
				$data['title'] = 'Products';
				$data['acesso_view'] =   $acesso_view;
				$data['acesso_create'] =  $acesso_create;
				$data['user'] = $this->user_model->get_backoffice_user( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"] );
				$data['products'] = $this->product_model->operator_get_products( $_SESSION["backoffice_user_id"] );
				$this->template->content->view('backoffice-products', $data);
			}
		}
		else {
			//login or register
			$data['returnTo'] = 'backoffice';
			$this->session->set_flashdata('data',$data);
			redirect('backoffice_login');
		}
		
        $this->template->publish();
	}
	
	public function white_label()
	{
		$this->template->frontpage = "false";
		$this->load->model('user_model');
		$this->load->model('product_model');
		$this->load->model('phc_model');
		$this->template->set_template('template_bo');
		
		// templates (temporario)
		$templates = array();
		$tmp = array();
		$tmp['name'] = 'Template 1';
		$templates[] = $tmp;
		$tmp = array();
		$tmp['name'] = 'Template 2';
		$templates[] = $tmp;
		$data["templates"] = $templates;
		
		// fonts (temporario)
		$fonts = array();
		$tmp = array();
		$tmp['name'] = '"Arial Black", Gadget, sans-serif';
		$fonts[] = $tmp;
		$tmp = array();
		$tmp['name'] = 'Arial, Helvetica, sans-serif';
		$fonts[] = $tmp;
		$tmp = array();
		$tmp['name'] = '"Comic Sans MS", cursive, sans-serif';
		$fonts[] = $tmp;
		$tmp = array();
		$tmp['name'] = 'Georgia, serif';
		$fonts[] = $tmp;
		$tmp = array();
		$tmp['name'] = 'Impact, Charcoal, sans-serif';
		$fonts[] = $tmp;
		$tmp = array();
		$tmp['name'] = '"Lucida Sans Unicode", "Lucida Grande", sans-serif';
		$fonts[] = $tmp;
		$tmp = array();
		$tmp['name'] = '"Open Sans", sans-serif';
		$fonts[] = $tmp;
		$tmp = array();
		$tmp['name'] = '"Palatino Linotype", "Book Antiqua", Palatino, serif';
		$fonts[] = $tmp;
		$tmp = array();
		$tmp['name'] = 'Tahoma, Geneva, sans-serif';
		$fonts[] = $tmp;
		$tmp = array();
		$tmp['name'] = '"Times New Roman", Times, serif';
		$fonts[] = $tmp;
		$tmp = array();
		$tmp['name'] = '"Trebuchet MS", Helvetica, sans-serif';
		$fonts[] = $tmp;
		$tmp = array();
		$tmp['name'] = 'Verdana, Geneva, sans-serif';
		$fonts[] = $tmp;
		$data["fonts"] = $fonts;

		if( isset($_SESSION["backoffice_user_id"]) && $_SESSION["backoffice_user_id"] > 0 ) {
			$acesso = $this->user_model->get_user_access( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"], '', 'SA3E630F18DA9650FE1C90' );
			
			if( !$acesso ) {
				redirect('/backoffice/denied');
			}else
			{
				$data['title'] = 'White Label';
				$data['user'] = $this->user_model->get_backoffice_user( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"] );
				$data['whitelabel'] = $this->phc_model->get_white_label($_SESSION["backoffice_user_id"])[0];
				$data['sl_img'] = $this->phc_model->get_white_label_slider_img( $data['whitelabel']["id"] );
			
			}
			$this->template->content->view('backoffice-white-label', $data);
		}
		else {
			//login or register
			$data['returnTo'] = 'backoffice';
			$this->session->set_flashdata('data',$data);
			redirect('backoffice_login');
		}
		
        $this->template->publish();
	}
	
	public function product()
	{
		$this->template->frontpage = "false";
		$this->load->model('user_model');
		$this->load->model('product_model');
		$this->load->model('phc_model');
		$this->template->set_template('template_bo');
		
		$sefurl = $this->uri->segment(3);
		$page = $this->uri->segment(4);
		
		if( isset($_SESSION["backoffice_user_id"]) && $_SESSION["backoffice_user_id"] > 0 ) {
			$acesso = $this->user_model->get_user_access( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"], '', 'SA8D7C96FC0EE90EC56B77' );
			
			if( !$acesso ) {
				redirect('/backoffice/denied');
			}else
			{ 
				$data['product'] = $this->product_model->operator_get_product_mssql( $_SESSION["backoffice_user_id"], $sefurl );
				$data['u_psess'] = $this->product_model->operator_get_session_mssql( $_SESSION["backoffice_user_id"], $sefurl );
				$data['u_pexcl'] = $this->product_model->operator_get_exclusi_mssql( $_SESSION["backoffice_user_id"], $sefurl );
				$data['u_plang'] = $this->product_model->operator_get_languag_mssql( $_SESSION["backoffice_user_id"], $sefurl );
				$data['u_lang'] = $this->product_model->operator_get_lang_mssql();
				
				if( sizeof($data['product']) > 0 ) {
					$data['title'] = 'Product - ' . $data['product'][0]["u_name"];
					$data['product'] = $data['product'][0];
					$data['user'] = $this->user_model->get_backoffice_user( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"] );
					$data['countries'] = $this->product_model->get_countries();
					$data['u_pseat'] = $this->product_model->get_product_seats_mssql( $sefurl );
					$data['u_ptick'] = $this->product_model->get_product_tickets_mssql( $sefurl );
					$data['u_tick'] = $this->product_model->get_tickets_mssql();
					$data['u_pntick'] = $this->product_model->get_product_tickets_numbers_mssql( $sefurl );
					$data['images'] = $this->phc_model->get_images( $data['product']['bostamp'] );
					$data['categ'] = $this->phc_model->get_categ_mssql();
					$data['u_pcateg'] = $this->phc_model->get_pcateg_mssql( $data['product']['bostamp'] );
					$image_voucher = $this->phc_model->get_image_voucher( $data['product']['bostamp'] );
					$data['u_prec'] = $this->product_model->get_extras_mssql($_SESSION["backoffice_user_id"]);
					$data['u_pextra'] = $this->product_model->get_product_extras_mssql( $sefurl );
					$data['products'] = $this->product_model->operator_get_products_mssql( $_SESSION["backoffice_user_id"] );
					$data['related_products'] = $this->product_model->get_related_products_mssql( $data['product']["bostamp"] );
					$data['ptaxes'] = $this->product_model->get_product_taxes_mssql( $data['product']["bostamp"] );
					$data['taxes'] = $this->user_model->get_taxes_mssql( $_SESSION["backoffice_user_id"] );
					$data['pickups'] = $this->product_model->get_pickups_mssql( $_SESSION["backoffice_user_id"] );
					$data['ppickups'] = $this->product_model->get_ppickups_mssql( $_SESSION["backoffice_user_id"] );
					$data['legal_taxes'] = $this->product_model->get_iva_mssql();
					
					if($image_voucher[0]['u_imgvouch'] == ""){
						$data['image_voucher'] = "";
					}else{
						$data['image_voucher'] = $image_voucher;
					}
					
					switch(trim($page)) {
						case "details":
							$data["page"] = "details";
							$data["next"] = "tickets";
							$data["back"] = "type";
							$this->template->content->view('backoffice-product-details', $data);
							break;
						case "tickets":
							$data["page"] = "tickets";
							$data["next"] = "tickets-number";
							$data["back"] = "details";
							$this->template->content->view('backoffice-product-tickets', $data);
							break;
						case "tickets-number":
							$data["page"] = "tickets-number";
							$data["next"] = "seats";
							$data["back"] = "tickets";
							$this->template->content->view('backoffice-product-tickets-number', $data);
							break;
						case "seats":
							$data["page"] = "seats";
							$data["next"] = "seats-disposition";
							$data["back"] = "tickets-number";
							$this->template->content->view('backoffice-product-seats', $data);
							break;
						case "seats-disposition":
							$data["page"] = "seats-disposition";
							$data["next"] = "scheduling";
							$data["back"] = "seats";
							$this->template->content->view('backoffice-product-seats-disposition', $data);
							break;
						case "scheduling":
							$data["page"] = "scheduling";
							$data["next"] = "location";
							$data["back"] = "seats-disposition";
							$this->template->content->view('backoffice-product-scheduling', $data);
							break;
						case "location":
							$data["page"] = "location";
							$data["next"] = "extras-resources";
							$data["back"] = "scheduling";
							$this->template->content->view('backoffice-product-location', $data);
							break;
						case "extras-resources":
							$data["page"] = "extras-resources";
							$data["next"] = "taxes-fees";
							$data["back"] = "location";
							$this->template->content->view('backoffice-product-extras-resources', $data);
							break;
						case "taxes-fees":
							$data["page"] = "taxes-fees";
							$data["next"] = "pickups";
							$data["back"] = "extras-resources";
							$this->template->content->view('backoffice-product-taxes-fees', $data);
							break;
						case "pickups":
							$data["page"] = "pickups";
							$data["next"] = "languages";
							$data["back"] = "taxes-fees";
							$this->template->content->view('backoffice-product-pickups', $data);
							break;
						case "languages":
							$data["page"] = "languages";
							$data["next"] = "related-products";
							$data["back"] = "pickups";
							$this->template->content->view('backoffice-product-languages', $data);
							break;
						case "related-products":
							$data["page"] = "related-products";
							$data["back"] = "pickups";
							$this->template->content->view('backoffice-product-related-products', $data);
							break;
						default:
							$data["page"] = "type";
							$data["next"] = "details";
							$this->template->content->view('backoffice-product', $data);
							break;
					}
					
					// $this->template->content->view('backoffice-product', $data);
				}
				else {
					$data['title'] = 'Product Error';
					$this->template->content->view('backoffice-product-denied', $data);
				}
			}
		}
		else {
			//login or register
			$data['returnTo'] = 'backoffice';
			$this->session->set_flashdata('data',$data);
			redirect('backoffice_login');
		}
		
        $this->template->publish();
	}
	
	public function product_price()
	{
		$this->template->frontpage = "false";
		$this->load->model('user_model');
		$this->load->model('product_model');
		$this->template->set_template('template_bo');
		
		$sefurl = $this->uri->segment(3);
		$price_id = $this->uri->segment(4);
		
		if( isset($_SESSION["backoffice_user_id"]) && $_SESSION["backoffice_user_id"] > 0 ) {
			$data['product'] = $this->product_model->operator_get_product( $_SESSION["backoffice_user_id"], $sefurl );
			
			if( sizeof($data['product']) > 0 ) {
				$data['title'] = 'Product - ' . $data['product'][0]["u_name"];
				$data['product'] = $data['product'][0];
				$data['user'] = $this->user_model->get_backoffice_user( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"] );
				$data['u_psess'] = $this->product_model->operator_get_session( $_SESSION["backoffice_user_id"], $sefurl );			
				$data['u_pseat'] = $this->product_model->get_product_seats( $sefurl );
				$data['u_ptick'] = $this->product_model->get_product_tickets( $sefurl );
				
				$data['prices'] = $this->product_model->get_product_prices_by_ref( "P." . $data['product']["obrano"] . "." . $price_id );
				$data['price_id'] = $price_id;
				$this->template->content->view('backoffice-product-price', $data);
			}
			else {
				$data['title'] = 'Product Error';
				$this->template->content->view('backoffice-product-denied', $data);
			}
		}
		else {
			//login or register
			$data['returnTo'] = 'backoffice';
			$this->session->set_flashdata('data',$data);
			redirect('backoffice_login');
		}
		
        $this->template->publish();
	}
	
	public function logout()
	{
		$data = new stdClass();
		if (isset($_SESSION['backoffice_logged_in']) && $_SESSION['backoffice_logged_in'] === true) {
			foreach ($_SESSION as $key => $value) {
				if( strpos($key, 'backoffice_') !== false )
					unset($_SESSION[$key]);
			}
			redirect('/backoffice');
		} else {
			redirect('/backoffice');
			
		}
	}
	
	public function upload() {
		
		$this->load->model('phc_model');
        if (!empty($_FILES)) {
			$tempFile = $_FILES['file']['tmp_name'];
			$fileName = $_FILES['file']['type'];
			$currentSection = explode("/",$fileName);
			$currentSection = $currentSection[1];
			$bostamp = $_POST['bostamp'];
			$targetPath = base_url() . 'image_product/';
			$targetPath_local = getcwd() . '/image_product/';
			$random = $this->generateRandomString();
			$date_str = date('m-d-Y_his');
			$targetFile = $random.$date_str.'.'.$currentSection ;
			$targetFile_local = $targetPath_local.$random.$date_str.'.'.$currentSection ;
			move_uploaded_file($tempFile, $targetFile_local);
			
			$result=$this->phc_model->insert_image($bostamp,$targetFile);
        }
		echo $result;
    }
	
	public function upload_image_voucher() {
		
		$this->load->model('phc_model');
        if (!empty($_FILES)) {
			$tempFile = $_FILES['file']['tmp_name'];
			$fileName = $_FILES['file']['type'];
			$currentSection = explode("/",$fileName);
			$currentSection = $currentSection[1];
			$bostamp = $_POST['bostamp'];
			$targetPath = base_url() . 'image_product/';
			$targetPath_local = getcwd() . '/image_product/';
			$random = $this->generateRandomString();
			$date_str = date('m-d-Y_his');
			$targetFile = $random.$date_str.'.'.$currentSection ;
			$targetFile_local = $targetPath_local.$random.$date_str.'.'.$currentSection ;
			move_uploaded_file($tempFile, $targetFile_local);
			
			$result=$this->phc_model->update_image_voucher($bostamp, $targetFile);
        }
		echo $result;
    }
	
	public function deletefile() {
		$this->load->model('phc_model');
		$filename = $this->input->post('search');
		$bostamp = $this->input->post('bostamp');
		$targetFile = base_url() . 'image_product/'.$filename;
		$targetFile_local = getcwd() . '/image_product/'.$filename;

		if( file_exists($targetFile_local) ){
			unlink($targetFile_local);
		}
		
		$result=$this->phc_model->remove_image($bostamp, $filename);
		echo $result ;
    }
	
	
	public function deletefile_voucher() {
		$this->load->model('phc_model');
      $filename = $this->input->post('search');
	  $bostamp = $this->input->post('bostamp');
	  $targetFile = getcwd() . '/image_product/'.$filename;
	
	  unlink($targetFile);
	  $result=$this->phc_model->update_image_voucher($bostamp,"");
	  echo $targetFile ;
    }
	
	function generateRandomString($length = 5) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
	
	public function agent()
	{
		$this->template->frontpage = "false";
		$this->load->model('user_model');
		$this->load->model('phc_model');
		$this->load->model('product_model');
		$this->template->set_template('template_bo');
		if( isset($_SESSION["backoffice_user_id"]) && $_SESSION["backoffice_user_id"] > 0 ) {
			if( $this->uri->segment(3) != "" && !$this->input->post('id') ){
				$acesso = $this->user_model->get_user_access( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"], '', 'SAC8FCB47326EB61266AB5' );
				$acesso_manage_fees = $this->user_model->get_user_access( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"], '', 'SAF6F8B7E594AB9EB2A17B' );
				$acesso_assign_products = $this->user_model->get_user_access( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"], '', 'SAF34B5F703CDDF051F09F' );
				$dissociate_op_agent = $this->user_model->get_user_access( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"], '', 'SAE5F7470AA7189E335176' );
				if( !$acesso ) {
					redirect('/backoffice/denied');
				}else
				{
					$data['title'] = 'Agent';
					$data['acesso_assign_products'] = $acesso_assign_products;
					$data['acesso_manage_fees'] = $acesso_manage_fees;
					$data['dissociate_op_agent'] = $dissociate_op_agent;
					$data['user'] = $this->user_model->get_backoffice_user( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"] );
					$data['agent'] = $this->phc_model->get_agent($this->uri->segment(3));
					$data['locations'] = $this->product_model->get_locations_mssql( $_SESSION["backoffice_user_id"] );
					$this->template->content->view('backoffice-agent', $data);
				}
			}
			if($this->input->post('id') && $this->uri->segment(3) != ""){
				
				if($this->input->post('id') == 1){
						$data['title'] = 'Manage Fees';
						$data['user'] = $this->user_model->get_backoffice_user( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"] );
						$data['productfee'] = $this->phc_model->get_productfee_agent( $this->uri->segment(3), $_SESSION["backoffice_user_id"]);
						$this->template->content->view('backoffice-agent-product-fee', $data);
				}
				if($this->input->post('id') == 2){
						$data['title'] = 'Assign Products';
						$data['user'] = $this->user_model->get_backoffice_user( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"] );
						$data['productfee'] = $this->phc_model->get_productfee( $this->uri->segment(3), $_SESSION["backoffice_user_id"]);
						$this->template->content->view('backoffice-agent-assign-fee', $data);
				}
			}
		}
		else {
			//login or register
			$data['returnTo'] = 'backoffice';
			$this->session->set_flashdata('data',$data);
			redirect('backoffice_login');
		}
		
        $this->template->publish();
	}
	
	public function customers() {
		$this->template->frontpage = "false";
		$this->load->model('user_model');
		$this->load->model('product_model');
		$this->template->set_template('template_bo');

		if( isset($_SESSION["backoffice_user_id"]) && $_SESSION["backoffice_user_id"] > 0 ) {
			$acesso = $this->user_model->get_user_access( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"], '', 'SAF3A4C53F9B3584AC0284' );
			
			if( !$acesso ) {
				redirect('/backoffice/denied');
			}else{
				$data['title'] = 'Customers';
				$data['acesso_view'] = $this->user_model->get_user_access( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"], '', 'SA3E630F18DA9650FE1C90' );
				$data['user'] = $this->user_model->get_backoffice_user( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"] );
				$data['customers'] = $this->product_model->get_customers( $_SESSION["backoffice_user_id"] );
				$this->template->content->view('backoffice-customers', $data);
			}
		}
		else {
			//login or register
			$data['returnTo'] = 'backoffice';
			$this->session->set_flashdata('data',$data);
			redirect('backoffice_login');
		}
		$this->template->publish();
	}

	public function customer() {
	   $this->template->frontpage = "false";
	   $this->load->model('user_model');
	   $this->load->model('product_model');
	   $this->template->set_template('template_bo');

	   $customer_id = $this->uri->segment(3);
	   
	   if( isset($_SESSION["backoffice_user_id"]) && $_SESSION["backoffice_user_id"] > 0 ) {
		   $acesso = $this->user_model->get_user_access( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"], '', 'SA3E630F18DA9650FE1C90' );
			
			if( !$acesso ) {
				redirect('/backoffice/denied');
			}else{
			   $data['customer'] = $this->product_model->get_customers_by_id( $_SESSION["backoffice_user_id"], $customer_id );
			   if( sizeof($data['customer']) != "" ) {
				   $data['title'] = 'Customer - ' . $data['customer']["first_name"].' '.$data['customer']["last_name"];
				   $data['user'] = $this->user_model->get_backoffice_user( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"] );
				   $this->template->content->view('backoffice-customer', $data);
			   }
			   else {
			   redirect('backoffice/customers');
			   }
			}
	   }
	   else {
		   //login or register
		   $data['returnTo'] = 'backoffice';
		   $this->session->set_flashdata('data',$data);
		   redirect('backoffice_login');
	   }
		$this->template->publish();
	}
	
	public function agent_reimbursement()
	{
		$this->template->frontpage = "false";
		$this->load->model('user_model');
		$this->load->model('product_model');
		$this->load->model('phc_model');
		$this->template->set_template('template_bo');
		
		if( isset($_SESSION["backoffice_user_id"]) && $_SESSION["backoffice_user_id"] > 0 ) {
			$data['title'] = 'Cash Sales Reimbursement';
			$data['user'] = $this->user_model->get_backoffice_user( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"] );
			$data['reimbursements'] = $this->phc_model->get__last10_agent_reibursements( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"] );
			
			$this->template->content->view('backoffice-agent-reimbursement', $data);
		}
		else {
			//login or register
			$data['returnTo'] = 'backoffice';
			$this->session->set_flashdata('data',$data);
			redirect('backoffice_login');
		}
				
		$this->template->publish();
	}
	
	public function agent_mb_reimbursement()
	{
		$this->template->frontpage = "false";
		$this->load->model('user_model');
		$this->load->model('product_model');
		$this->template->set_template('template_bo');
		
		if( isset($_SESSION["backoffice_user_id"]) && $_SESSION["backoffice_user_id"] > 0 ) {
			$data['title'] = 'Cash Sales Reimbursement - Multibanco';
			$data['user'] = $this->user_model->get_backoffice_user( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"] );
			
			$this->template->content->view('backoffice-agent-mb-reimbursement', $data);
		}
		else {
			//login or register
			$data['returnTo'] = 'backoffice';
			$this->session->set_flashdata('data',$data);
			redirect('backoffice_login');
		}
				
		$this->template->publish();
	}

	public function agent_manual_reimbursement()
	{
		$this->template->frontpage = "false";
		$this->load->model('user_model');
		$this->load->model('product_model');
		$this->load->model('phc_model');
		$this->template->set_template('template_bo');
		
		if( isset($_SESSION["backoffice_user_id"]) && $_SESSION["backoffice_user_id"] > 0 ) {
			$data['title'] = 'Cash Sales Reimbursement - Manual';
			$data['user'] = $this->user_model->get_backoffice_user( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"] );
			$data['operators'] = $this->phc_model->get_agent_operators( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"] );
			
			$this->template->content->view('backoffice-agent-manual-reimbursement', $data);
		}
		else {
			//login or register
			$data['returnTo'] = 'backoffice';
			$this->session->set_flashdata('data',$data);
			redirect('backoffice_login');
		}
				
		$this->template->publish();
	}
	
	public function rep_agent_orders()
	{
		$this->template->frontpage = "false";
		$this->load->model('user_model');
		$this->load->model('product_model');
		$this->template->set_template('template_bo');
		
		if( isset($_SESSION["backoffice_user_id"]) && $_SESSION["backoffice_user_id"] > 0 ) {
			$data['title'] = 'Sales orders';
			$data['user'] = $this->user_model->get_backoffice_user( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"] );
			$data['products'] = $this->product_model->agent_get_products_mssql( $_SESSION["backoffice_user_id"] );
			$data['agents'] = $this->product_model->agent_get_operators_mssql( $_SESSION["backoffice_user_id"] );
			$this->template->content->view('backoffice-agent-sales-orders', $data);	
		}	
		else {
			//login or register
			$data['returnTo'] = 'backoffice';
			$this->session->set_flashdata('data',$data);
			redirect('backoffice_login');
		}
		
        $this->template->publish();
	}

	public function rep_agent_fees()
	{
		$this->template->frontpage = "false";
		$this->load->model('user_model');
		$this->load->model('product_model');
		$this->template->set_template('template_bo');
		
		if( isset($_SESSION["backoffice_user_id"]) && $_SESSION["backoffice_user_id"] > 0 ) {
			$data['title'] = 'My Fees';
			$data['user'] = $this->user_model->get_backoffice_user( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"] );
			$data['products'] = $this->product_model->agent_get_products_mssql( $_SESSION["backoffice_user_id"] );
			$data['agents'] = $this->product_model->agent_get_operators_mssql( $_SESSION["backoffice_user_id"] );
			$data['u_tick'] = $this->product_model->get_tickets_mssql();
			
			$this->template->content->view('backoffice-agent-sales-fees', $data);
		}
		else {
			//login or register
			$data['returnTo'] = 'backoffice';
			$this->session->set_flashdata('data',$data);
			redirect('backoffice_login');
		}
		
        $this->template->publish();
	}
	
	public function fee_receipts()
	{
		$this->template->frontpage = "false";
		$this->load->model('user_model');
		$this->load->model('phc_model');
		$this->template->set_template('template_bo');
		if( isset($_SESSION["backoffice_user_id"]) && $_SESSION["backoffice_user_id"] > 0 ) {
			$data['title'] = 'Manage Fee Receipts';
			$data['user'] = $this->user_model->get_backoffice_user( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"] );
			$data['fees'] = $this->phc_model->get_agent_fee( $_SESSION["backoffice_user_id"] );
			$this->template->content->view('backoffice-agent-fee-receipts', $data);
		}
		else {
			//login or register
			$data['returnTo'] = 'backoffice';
			$this->session->set_flashdata('data',$data);
			redirect('backoffice_login');
		}

		$this->template->publish();
	}

	public function add_fee_receipts()
	{
	   $this->template->frontpage = "false";
	   $this->load->model('user_model');
	   $this->load->model('phc_model');
	   $this->template->set_template('template_bo');
	   if( isset($_SESSION["backoffice_user_id"]) && $_SESSION["backoffice_user_id"] > 0 ) {
		   $data['title'] = 'Add Fee Receipts';
		   $data['user'] = $this->user_model->get_backoffice_user( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"] );
		   //$data['productfee'] = $this->phc_model->get_productfee( $this->uri->segment(3), $_SESSION["backoffice_user_id"]);
		   $this->template->content->view('backoffice-agent-add-fee-receipts', $data);
	   }
	   else {
		   //login or register
		   $data['returnTo'] = 'backoffice';
		   $this->session->set_flashdata('data',$data);
		   redirect('backoffice_login');
	   }
	   
		$this->template->publish();
	}
	
	public function ajax() {
		$this->load->model('user_model');
		$this->load->model('calendar_model');
		$this->load->model('product_model');
		$this->load->model('phc_model');
		$this->load->library('mssql');
		
		$sefurl = $this->uri->segment(3);
		if( isset($_SESSION["backoffice_user_id"]) ) {
			$data['user'] = $this->user_model->get_backoffice_user( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"] );
			
			switch( $sefurl ) {
				case 'update_product':
					$data['input'] = $this->input->post('input');
					$data['textarea'] = $this->input->post('textarea');
					$data['checkbox'] = $this->input->post('checkbox');
					$data['bostamp'] = $this->input->post('bostamp');
					$data['scheduling_table'] = $this->input->post('scheduling_table');
					$data['exclusion_table'] = $this->input->post('exclusion_table');
					$data['language_table'] = $this->input->post('language_table');
					$data['tickets_table'] = $this->input->post('tickets_table');
					$data['ticket_num_table'] = $this->input->post('ticket_num_table');
					$data['seats_table'] = $this->input->post('seats_table');
					$data['extras_table'] = $this->input->post('extras_table');
					$data['relprod_table'] = $this->input->post('relprod_table');
					$data['pickups_table'] = $this->input->post('pickups_table');
					$data['tax_table'] = $this->input->post('tax_table');
					$this->mssql->utf8_encode_deep( $data );
					$this->product_model->update_product( $data );
					break;
				case 'create_vouch':
					$data['input'] = $this->input->post('input');
					$data['vouch_table'] = $this->input->post('vouch_table');
					$data['user'] = $this->user_model->get_backoffice_user( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"] );
					$this->mssql->utf8_encode_deep( $data );
					$this->phc_model->create_vouch( $data );
					break;
				case 'update_vouch':
					$data['input'] = $this->input->post('input');
					$data['u_vouchstamp'] = $this->input->post('stamp');
					$data['vouch_table'] = $this->input->post('vouch_table');
					$data['user'] = $this->user_model->get_backoffice_user( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"] );
					$this->mssql->utf8_encode_deep( $data );
					$this->phc_model->update_vouch( $data );
					break;
				case 'delete_vouch':
					$data['u_vouchstamp'] = $this->input->post('stamp');
					$data['vouch_table'] = $this->input->post('vouch_table');
					$data['user'] = $this->user_model->get_backoffice_user( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"] );
					$this->mssql->utf8_encode_deep( $data );
					$this->phc_model->delete_vouch( $data );
					break;
				case 'update_profile':
					$data['id'] = $_SESSION["backoffice_user_id"];
					$data['estab'] = $_SESSION["backoffice_user_estab"];
					$data['lang'] = $this->input->post('lang');
					$this->mssql->utf8_encode_deep( $data );
					$this->phc_model->update_profile( $data );
					break;
				case 'update_profile_data':
					$data['id'] = $_SESSION["backoffice_user_id"];
					$data['estab'] = $_SESSION["backoffice_user_estab"];
					$data['checkbox'] = $this->input->post('checkbox');
					
					$this->mssql->utf8_encode_deep( $data );
					echo $this->phc_model->update_profile_data( $data );
					break;
				case 'update_whitelabel':
					$data['input'] = $this->input->post('input');
					$data['id'] = $this->input->post('id');
					$data['checkbox'] = $this->input->post('checkbox');
					
					echo json_encode($this->phc_model->update_whitelabel( $data ));
					break;
				case 'delete_product_session':
					$data['session'] = $this->input->post('stamp');
					$this->product_model->delete_product_session( $data );
					break;
				case 'delete_product_exclusion':
					$data['exclusion'] = $this->input->post('stamp');
					$this->product_model->delete_product_exclusion( $data );
					break;
				case 'delete_product_seat':
					$data['seat'] = $this->input->post('stamp');
					$this->product_model->delete_product_seat( $data );
					break;
				case 'delete_product_ticket_number':
					$data['u_pntickstamp'] = $this->input->post('stamp');
					$this->product_model->delete_product_ticket_number( $data );
					break;
				case 'update_product_price':
					$data['ref'] = $this->input->post('ref');
					$data['prices'] = json_decode( $this->input->post('prices') );
					$this->product_model->update_product_price( $data );
					break;
				case 'create_product':
					$data['product_name'] = $this->input->post('name');
					$this->product_model->create_product_mssql( $data );
					break;
				case 'create_user':
					$data['name'] = $this->input->post('name');
					$data['op'] = $_SESSION["backoffice_user_id"];
					
					$this->mssql->utf8_decode_deep( $data );
					
					return json_encode( $this->user_model->create_op_user( $data ) );
					break;
				case 'wl_upload_logo':
					$data['id'] = $this->input->post('id');
					$data['name'] = $this->input->post('name');
					$this->phc_model->wl_upload_logo( $data );
					break;
				case 'wl_delete_logo':
					$data['id'] = $this->input->post('id');
					$data['name'] = $this->input->post('name');
					$this->phc_model->wl_delete_logo( $data );
					break;
				case 'check_agent_vat':
					echo json_encode( $this->phc_model->check_agent_vat( $this->input->post('vat') ) );
					break;
				case 'associate_op_agent':
					echo json_encode( $this->phc_model->associate_op_agent( $this->input->post('vat'), $_SESSION["backoffice_user_id"] ) );
					break;
				case 'dissociate_op_agent':
					echo json_encode( $this->phc_model->dissociate_op_agent( $this->input->post('vat'), $_SESSION["backoffice_user_id"] ) );
					break;
				case 'create_agent':
					echo json_encode( $this->phc_model->create_agent( $this->input->post('input'), $_SESSION["backoffice_user_id"] ) );
					break;
				case 'update_chart':
					$data['chart1'] = $this->phc_model->dashboard_chart(1, $this->input->post('op'), $this->input->post('ag'), $_SESSION["backoffice_user_id"]);
					$data['chart2'] = $this->phc_model->dashboard_chart(2, $this->input->post('op'), $this->input->post('ag'), $_SESSION["backoffice_user_id"]);
					$data['chart3'] = $this->phc_model->dashboard_chart(3, $this->input->post('op'), $this->input->post('ag'), $_SESSION["backoffice_user_id"]);
					$data['chart4'] = $this->phc_model->dashboard_chart(4, $this->input->post('op'), $this->input->post('ag'), $_SESSION["backoffice_user_id"]);
					echo json_encode($data);
					break;
				case 'get_sales':
					$data = array();
					$data[] = $this->input->post('date_i');
					$data[] = $this->input->post('date_f');
					$data[] = $this->input->post('agen');
					$data[] = $this->input->post('prod');
					$data[] = $_SESSION["backoffice_user_id"];
					$data[] = $this->input->post('local');
					echo json_encode( $this->phc_model->get_sales( $data ) );
					break;
				case 'get_fees':
					$data = array();
					$data[] = $this->input->post('date_i');
					$data[] = $this->input->post('date_f');
					$data[] = $this->input->post('agen');
					$data[] = $this->input->post('prod');
					$data[] = $_SESSION["backoffice_user_id"];
					$data[] = $this->input->post('tick');
					$data[] = $this->input->post('local');
					echo json_encode( $this->phc_model->get_fees( $data ) );
					break;
				case 'get_treasury':
					$data = array();
					$data["dataini"] = $this->input->post('date_i');
					$data["datafim"] = $this->input->post('date_f');
					$data["agno"] = $this->input->post('agen');
					$data["no"] = $_SESSION["backoffice_user_id"];
					$data["local"] = $this->input->post('local');
					echo json_encode( $this->phc_model->get_treasury( $data ) );
					break;
				case 'get_agent_treasury':
					$data = array();
					$data["dataini"] = $this->input->post('date_i');
					$data["datafim"] = $this->input->post('date_f');
					$data["opno"] = $this->input->post('opno');
					$data["no"] = $_SESSION["backoffice_user_id"];
					echo json_encode( $this->phc_model->get_agent_treasury( $data ) );
					break;
				case 'set_reimbursements_processed':
					$data = array();
					$data["fostamps"] = json_decode($this->input->post('fostamps'));
					$data["no"] = $_SESSION["backoffice_user_id"];

					echo $this->phc_model->set_reimbursements_processed( $data );
					break;
				case 'get_reimbursements':
					$data = array();
					$data["dataini"] = $this->input->post('date_i');
					$data["datafim"] = $this->input->post('date_f');
					$data["ag"] = $this->input->post('ag');
					$data["status"] = $this->input->post('status');
					$data["no"] = $_SESSION["backoffice_user_id"];
					
					echo json_encode( $this->phc_model->get_reimbursements_mssql( $data ) );
					break;
				case 'agent_product_fee':
					$data['user'] = $this->user_model->get_backoffice_user( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"] );
					$agent_product_fee_tmp = array();
					$agent_product_fee_tmp = json_decode($this->input->post('agent_product_fee'), true);
					$agent_product_fee = array();
					$agent = $this->input->post('agent');
					$ins = 0;
					foreach ( $agent_product_fee_tmp as $row ) {
						if( $row[3] == 0 ) {
							$this->phc_model->delete_agent_product_fee( $row[0],  $agent, $row[3] );
							$ins = 0;
						}
						else if( $row[3] == 1 && $row[1] == 0 ) {
							$this->phc_model->insert_agent_product_fee( $row[0], $agent, $row[3] );
							$ins = 1;
						}
						else {
							$ins = 1;
						}
						
						$tmp = array();
						$tmp[] = $row[0];
						$tmp[] = $ins;
						$tmp[] = $row[2];
						$tmp[] = $row[3];
						$agent_product_fee[] = $tmp;
					}
					$data['agent_product_fee'] = $agent_product_fee;
					echo json_encode($data);
					break;
				case 'agent_product_manage_fee':
					$data['user'] = $this->user_model->get_backoffice_user( $_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"] );
					$agent_product_fee_tmp = array();
					$agent_product_fee_tmp = json_decode($this->input->post('agent_product_fee'));
					$agent_product_fee = array();
					$agent = $this->input->post('agent');
					$ins = 0;
					foreach ($agent_product_fee_tmp as $row){
						
						$this->phc_model->update_agent_product_fee($row[0],  $agent, $row[3]);
						
						$tmp = array();
						$tmp[] = $row[0];
						$tmp[] = $ins;
						$tmp[] = $row[2];
						$tmp[] = $row[3];
						$agent_product_fee[] = $tmp;
					}
					$data['agent_product_fee'] = $agent_product_fee;
					echo json_encode($data);
					break;
				case 'get_calendar':
					$out = array();
					//data inicial
					if( isset($_REQUEST['from']) )
						$datai = $_REQUEST['from'] / 1000;
					else
						$datai = date('now');
					//data final
					if( isset($_REQUEST['to']) )
						$dataf = $_REQUEST['to'] / 1000;
					else
						$dataf = date('now');
					//operador
					$op = $_SESSION["backoffice_user_id"];
					$bostamp = $_REQUEST['bostamp'];
					$u_psessstamp = $_REQUEST['u_psessstamp'];
					$out = $this->calendar_model->get_calendar( $datai, $dataf, $op, $bostamp, $u_psessstamp );

					echo json_encode(array('success' => 1, 'result' => $out));
					break;
				case 'get_product_session':
					$bostamp = $this->input->post('bostamp');
					$op = $_SESSION["backoffice_user_id"];

					echo json_encode( $this->phc_model->get_product_session_mssql( $bostamp, $op ) );
					break;
				case 'update_extras':
					$data['extras'] = $this->input->post('extras');
					echo json_encode( $this->phc_model->update_extras( $data, $_SESSION["backoffice_user_id"] ) );
					break;
				case 'delete_extra':
					$id = $this->input->post('id');
					echo $this->phc_model->delete_extra( $id, $_SESSION["backoffice_user_id"] );
					break;
				case 'get_orders':
					$data = array();
					$data[] = $this->input->post('date_i');
					$data[] = $this->input->post('date_f');
					$data[] = $this->input->post('agen');
					$data[] = $this->input->post('prod');
					$data[] = $_SESSION["backoffice_user_id"];
					$data[] = $this->input->post('payment');
					$data[] = $this->input->post('local');
					$data[] = $this->input->post('user_type');

					echo json_encode( $this->phc_model->get_orders( $data ) );
					break;
				case 'wl_upload_slimg':
					$this->load->model('phc_model');
					if (!empty($_FILES)) {
						$tempFile = $_FILES['file']['tmp_name'];
						$fileName = $_FILES['file']['type'];
						$currentSection = explode("/",$fileName);
						$currentSection = $currentSection[1];
						$wlid = $_POST['id'];
						$targetPath = base_url() . 'image_product/';
						$targetPath_local = getcwd() . '/image_product/';
						$random = $this->generateRandomString();
						$date_str = date('m-d-Y_his');
						$targetFile = $random.$date_str.'.'.$currentSection ;
						$targetFile_local = $targetPath_local.$random.$date_str.'.'.$currentSection ;
						move_uploaded_file($tempFile, $targetFile_local);
						
						$result = $this->phc_model->insert_wl_sl_img($wlid, $targetFile, $_SESSION["backoffice_user_id"]);
					}
					echo $result;
					break;
				case 'wl_delete_slimg':
					$data['id'] = $this->input->post('id');
					$data['name'] = $this->input->post('name');
					$this->phc_model->wl_delete_slimg( $data );
					break;
				case 'get_resources_usage':
					$data = array();
					$data[] = $this->input->post('date_i');
					$data[] = $this->input->post('date_f');
					$data[] = $this->input->post('res');
					$data[] = $this->input->post('prod');
					$data[] = $_SESSION["backoffice_user_id"];
					echo json_encode( $this->phc_model->get_resources_usage( $data ) );
					break;
				case 'get_agent_sales':
					$data = array();
					$data[] = $this->input->post('date_i');
					$data[] = $this->input->post('date_f');
					$data[] = $this->input->post('agen');
					$data[] = $this->input->post('prod');
					$data[] = $_SESSION["backoffice_user_id"];
					echo json_encode( $this->phc_model->get_agent_sales( $data ) );
					break;
				case 'get_agent_fees':
					$data = array();
					$data[] = $this->input->post('date_i');
					$data[] = $this->input->post('date_f');
					$data[] = $this->input->post('agen');
					$data[] = $this->input->post('prod');
					$data[] = $_SESSION["backoffice_user_id"];
					$data[] = $this->input->post('tick');
					echo json_encode( $this->phc_model->get_agent_fees( $data ) );
					break;
				case 'add_fee_receipts': 
					$data['adoc'] = $this->input->post('no');
					$data['no'] = $_SESSION["backoffice_user_id"];
					$data['value'] = $this->input->post('value');
					$data['date'] = $this->input->post('date');
					$data['description'] = $this->input->post('description');
					$data['file'] = $this->input->post('file');
					$this->mssql->utf8_encode_deep( $data );
					
					echo $this->phc_model->add_fee_receipts( $data );
				break;
				case 'update_user': 
					$data['access'] = $this->input->post('access');
					$data['input'] = $this->input->post('input');
					$data['no'] = $_SESSION["backoffice_user_id"];
					$data['estab'] = $this->input->post('estab');
					
					echo $this->user_model->update_backoffice_user( $data );
				break;
				case 'update_pickup': 
					$data['input'] = json_decode($this->input->post('input'));
					$data['no'] = $_SESSION["backoffice_user_id"];
					$data['u_pickupstamp'] = $this->input->post('u_pickupstamp');
					
					echo $this->product_model->update_pickup( $data );
				break;
				case 'update_tax': 
					$data['input'] = json_decode($this->input->post('input'));
					$data['no'] = $_SESSION["backoffice_user_id"];
					$data['u_taxstamp'] = $this->input->post('u_taxstamp');
					
					echo $this->product_model->update_tax( $data );
				break;
				case 'delete_tax': 
					$data['no'] = $_SESSION["backoffice_user_id"];
					$data['stamp'] = $this->input->post('stamp');
					
					echo $this->product_model->delete_tax( $data );
				break;
				case 'delete_pickup': 
					$data['no'] = $_SESSION["backoffice_user_id"];
					$data['stamp'] = $this->input->post('stamp');
					
					echo $this->product_model->delete_pickup( $data );
				break;
				case 'update_location': 
					$data['input'] = json_decode($this->input->post('input'));
					$data['no'] = $_SESSION["backoffice_user_id"];
					$data['u_locationstamp'] = $this->input->post('u_locationstamp');
					
					echo $this->product_model->update_location( $data );
				break;
				case 'delete_location': 
					$data['no'] = $_SESSION["backoffice_user_id"];
					$data['stamp'] = $this->input->post('stamp');
					
					echo $this->product_model->delete_location( $data );
				break;
				case 'update_agent': 
					$data['no'] = $_SESSION["backoffice_user_id"];
					$data['agent'] = $this->input->post('agent');
					$data['u_locationstamp'] = $this->input->post('u_locationstamp');
					
					echo $this->product_model->update_agent( $data );
				break;
				case 'access_maintenance': 
					echo $this->user_model->access_maintenance( $_SESSION["backoffice_user_id"] );
				break;
				case 'upload_file_fee':
					$num_uploaded = 0;
					$files_uploaded = array();
					
					foreach($_FILES as $file) {
						$currentSection = explode(".",$file['name']);
						$currentSection = $currentSection[1];
						
						$targetPath_local = getcwd() . '/pdf_fees/';
						$random = $this->phc_model->generateRandomString();
						$date_str = date('m-d-Y_his');
						$targetFile = $random . $date_str . '.' . $currentSection ;
						$targetFile_local = $targetPath_local . $random . $date_str . '.' . $currentSection;
						move_uploaded_file($file['tmp_name'], $targetFile_local);
						$num_uploaded++;
						$files_uploaded[] = $targetFile;
					}
					
					$result = array( $num_uploaded, $files_uploaded );
					echo json_encode($result);
					break;
				case 'get_adoc': 
					$adoc = $this->input->post('adoc');
					$no = $_SESSION["backoffice_user_id"];
					$data = $this->input->post('date');
					
					$exist_doc = $this->phc_model->get_adoc( $adoc, $data,$no );
					echo sizeof($exist_doc);
					
					break;
				case 'create_location': 
					$data['name'] = $this->input->post('name');
					$data['no'] = $_SESSION["backoffice_user_id"];
					
					echo json_encode($this->product_model->create_location( $data ));
					break;
				case 'create_tax': 
					$data['name'] = $this->input->post('name');
					$data['no'] = $_SESSION["backoffice_user_id"];
					
					echo json_encode($this->product_model->create_tax( $data ));
					break;
				case 'create_pickup': 
					$data['name'] = $this->input->post('name');
					$data['no'] = $_SESSION["backoffice_user_id"];
					
					echo json_encode($this->product_model->create_pickup( $data ));
					break;
				case 'create_lastminute': 
					$data['lastmin'] = json_decode($this->input->post('lastmin'), true);
					$data['no'] = $_SESSION["backoffice_user_id"];
					
					echo json_encode($this->product_model->create_lastminute( $data ));
					break;
				case 'agent_insert_reimbursement': 
					$data['amount'] = $this->input->post('amount');
					$data['opno'] = $this->input->post('operator');
					$data['formapag'] = $this->input->post('formapag');
					$data['no'] = $_SESSION["backoffice_user_id"];
					
					echo $this->phc_model->agent_insert_reimbursement( $data );
					break;
				default:
					echo 'Nothing to do';
					break;
			}
		}
	}

}
