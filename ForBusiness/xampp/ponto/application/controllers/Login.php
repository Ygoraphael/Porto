<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct() {
		
		parent::__construct();
		$this->load->library(array('session'));
		$this->load->helper(array('url'));
		$this->load->model('user_model');
		
		parse_str( $_SERVER['QUERY_STRING'], $_REQUEST );
        $this->config->load("facebook",TRUE);
        $config = $this->config->item('facebook');
        $this->load->library('Facebook', $config);
	}

	public function index()
	{
		$this->template->frontpage = "false";
		$this->load->model('user_model');
		
		$userId = $this->facebook->getUser();
		$data = $this->session->flashdata('data');
		
		$data['url_register_fb'] = "";
		
		$data['postRed'] = empty($this->input->post('postRed')) ? '': '+&postRed='.$this->input->post('postRed');
		$data['postDt'] = empty($this->input->post('postDt')) ? '': '+&postDt='.$this->input->post('postDt');
		
		if($userId == 0){
			$data['url_register_fb'] = $this->facebook->getLoginUrl(array('scope'=>'email'), base_url().'login/register_fb'); 
			$data['url_login_fb'] = $this->facebook->getLoginUrl(array('scope'=>'email'), base_url().'login/login_fb'); 
		}
		else {
			$data['url_register_fb'] = ''; 
			$data['url_login_fb'] = ''; 
		}
		
		if( isset($_SESSION["user_id"]) && $_SESSION["user_id"] > 0 ) {
			//redirect
			$data['user'] = $this->user_model->get_user($_SESSION["user_id"]);
			
			if( isset($data['returnTo']) && $data['returnTo'] != '' ) {
				$this->template->content->view($data['returnTo'], $data);
				$this->template->publish();
			}
			else {
				redirect('/');
			}
		}
		else {
			//login or register
			$this->session->set_flashdata('data', $data);
			$this->template->content->view('login', $data);
			$this->template->publish();
		}
	}
	
	public function register_fb() {
	
		$userId = $this->facebook->getUser();

		// If user is not yet authenticated, the id will be zero
		if($userId == 0){
			$data->error = '';
			$data->redirect_page_error = 'Unknown error';
			$data->redirect_page_success = '';
			$data->success = 0;
			
		} else {
			// Get user's data and print it
			$user = $this->facebook->api('/me?fields=id,first_name,last_name,email,gender,location,birthday');
			
			if( !$this->user_model->check_email_exist($user["email"]) ) {
				$this->user_model->create_user($user["email"], 'H`%`H)sz@Mh^Y?,jmX"t?>qJBCfeXE~f:Q\eu{-3=K(a<7fL}N.xZuL', 1, $user);
			}

			$user_id = $this->user_model->get_user_id_from_email($user["email"]);
			$user    = $this->user_model->get_user($user_id);
			
			// set session user datas
			$_SESSION['user_id']      = (int)$user["id"];
			$_SESSION['email']     	  = (string)$user["email"];
			$_SESSION['type']      	  = 'client';
			$_SESSION['logged_in']    = (bool)true;
			$_SESSION['is_confirmed'] = (bool)$user["is_confirmed"];
			$_SESSION['is_admin']     = (bool)$user["is_admin"];

			redirect('/');
		}
	}
	
	public function login_fb() {
	
		$userId = $this->facebook->getUser();

		// If user is not yet authenticated, the id will be zero
		if($userId == 0){
			$data->error = '';
			$data->redirect_page_error = 'Unknown error';
			$data->redirect_page_success = '';
			$data->success = 0;
			
		} else {
			// Get user's data and print it
			$user = $this->facebook->api('/me?fields=id,name,email');

			if( $this->user_model->resolve_user_login_facebook($user["email"]) ) {
				$user_id = $this->user_model->get_user_id_from_email($user["email"]);
				$user    = $this->user_model->get_user($user_id);
				
				// set session user datas
				$_SESSION['user_id']      = (int)$user["id"];
				$_SESSION['email']     	  = (string)$user["email"];
				$_SESSION['type']      	  = 'client';
				$_SESSION['logged_in']    = (bool)true;
				$_SESSION['is_confirmed'] = (bool)$user["is_confirmed"];
				$_SESSION['is_admin']     = (bool)$user["is_admin"];
			}

			$data = $this->session->flashdata('data');
			$this->session->set_flashdata('data',$data);
			
			if( $data['returnTo'] != '' ) {
				redirect($data['returnTo']);
			}
			else {
				redirect('/');
			}
		}
	}
	
	public function register() {
		
		// create the data object
		$data = new stdClass();
		
		// load form helper and validation library
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		// set validation rules
		$this->form_validation->set_rules('reg-email', 'Email', 'trim|required|valid_email|is_unique[users.email]', array('is_unique' => 'This email already exists. Please choose another one.'));
		$this->form_validation->set_rules('reg-password', 'Password', 'trim|required|min_length[6]');
		$this->form_validation->set_rules('reg-cpassword', 'Confirm Password', 'trim|required|min_length[6]|matches[reg-password]');
		
		if ($this->form_validation->run() === false) {
			// validation not ok, send validation errors to the view
			$data->error = validation_errors();
			$data->redirect_page_error = '';
			$data->redirect_page_success = '';
			$data->success = 0;
		} else {
			
			// set variables from the form
			$email    = $this->input->post('reg-email');
			$password = $this->input->post('reg-password');
			
			if ($this->user_model->create_user($email, $password, 0)) {
				// user creation ok
				$data->error = '';
				$data->redirect_page_error = '';
				$data->redirect_page_success = '';
				$data->success = 1;
				
			} else {
				// user creation failed, this should never happen
				$data->error = 'There was a problem creating your new account. Please try again.';
				$data->redirect_page_error = '';
				$data->redirect_page_success = '';
				$data->success = 0;
			}
		}
		echo json_encode($data);
	}

	
	public function log_in() {
		
		// create the data object
		$data = array();
		$data = $this->session->flashdata('data');
		
		// load form helper and validation library
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		// set validation rules
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'required');
		
		if ($this->form_validation->run() == false) {
			// validation not ok, send validation errors to the view
			$data["error"] = validation_errors();
			$data["redirect_page_error"] = '';
			$data["redirect_page_success"] = '';
			$data["success"] = 0;
		} else {
			// set variables from the form
			$email = $this->input->post('email');
			$password = $this->input->post('password');
			
			if ($this->user_model->resolve_user_login($email, $password)) {
				
				$user_id = $this->user_model->get_user_id_from_email($email);
				$user    = $this->user_model->get_user($user_id);
				
				// set session user datas
				$_SESSION['user_id']      = (int)$user["id"];
				$_SESSION['email']     = (string)$user["email"];
				$_SESSION['type']      	  = 'client';
				$_SESSION['logged_in']    = (bool)true;
				$_SESSION['is_confirmed'] = (bool)$user["is_confirmed"];
				$_SESSION['is_admin']     = (bool)$user["is_admin"];
				
				// user login ok
				$data['error'] = '';
				$data['redirect_page_error'] = '';
				
				if( isset($data['returnTo']) && $data['returnTo'] != '' ) {
					$data["redirect_page_success"] = $data['returnTo'];
				}
				else {
					$data["redirect_page_success"] = '';
				}
				
				$data["success"] = 1;
			}
			else {
				// login failed
				$data["error"] = 'Wrong username or password.';				
				$data["redirect_page_error"] = '';
				$data["redirect_page_success"] = '';
				$data["success"] = 0;
			}
		}
		
		echo json_encode($data);
	}
	
	public function logout() {
		
		// create the data object
		$data = new stdClass();
		
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			
			// remove session datas
			foreach ($_SESSION as $key => $value) {
				unset($_SESSION[$key]);
			}
			
			// user logout ok
			redirect('/');
			
		} else {
			
			// there user was not logged in, we cannot logged him out,
			// redirect him to site root
			redirect('/');
			
		}
		
	}
}
