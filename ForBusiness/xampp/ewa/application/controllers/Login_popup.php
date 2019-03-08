<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_popup extends CI_Controller {

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
		$data = new stdClass();
		$userId = $this->facebook->getUser();
		$data->url_register_fb = "";
		
		$data->postRed = empty($this->input->post('postRed')) ? '': '+&postRed='.$this->input->post('postRed');
		$data->postDt = empty($this->input->post('postDt')) ? '': '+&postDt='.$this->input->post('postDt');
		
		if($userId == 0){
			$data->url_register_fb = $this->facebook->getLoginUrl(array('scope'=>'email'), base_url().'login_popup/register_fb'); 
			$data->url_login_fb = $this->facebook->getLoginUrl(array('scope'=>'email'), base_url().'login_popup/login_fb'); 
		}
		else {
			$data->url_register_fb = ''; 
			$data->url_login_fb = ''; 
		}
		
		$this->load->view('header');
		$this->load->view('login_popup', $data);
		$this->load->view('footer');
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

			redirect(base_url());
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

			redirect(base_url());
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

	public function login() {
		
		// create the data object
		$data = new stdClass();
		
		// load form helper and validation library
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		// set validation rules
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'required');
		//Validation Recaptcha
		$recaptcha = $_POST['g-recaptcha-response'];
		//log_message("ERROR",print_r($recaptcha,TRUE));
			if($recaptcha){
				$secret ="6LcU7iMUAAAAAHnVRYvEE5SZzzesOh6vl2felU9x";
				$ip = $_SERVER['REMOTE_ADDR'];
				//log_message("ERROR",print_r($ip,TRUE));
				$var = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secret."&response=".$recaptcha."&remopteip=".$ip);
				$get_resGoogle = json_decode($var,TRUE);
				if($get_resGoogle['success']){ //log_message("ERROR",print_r($get_resGoogle,TRUE));
				} 
					else{
						$this->form_validation->set_rules('recaptcha', 'recaptcha', 'required');
					}
							
			}else{$this->form_validation->set_rules('recaptcha', 'recaptcha', 'required');}

			if ($this->form_validation->run() == false) {
			// validation not ok, send validation errors to the view
			$data->error = validation_errors();
			$data->redirect_page_error = '';
			$data->redirect_page_success = '';
			$data->success = 0;
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
				$data->error = '';
				$data->redirect_page_error = '';
				$data->redirect_page_success = '';
				$data->success = 1;
			}
			else {
				// login failed
				$data->error = 'Wrong username or password.';				
				$data->redirect_page_error = '';
				$data->redirect_page_success = '';
				$data->success = 0;
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
			redirect(base_url());
			
		} else {
			
			// there user was not logged in, we cannot logged him out,
			// redirect him to site root
			redirect(base_url());
			
		}
		
	}
	
}
