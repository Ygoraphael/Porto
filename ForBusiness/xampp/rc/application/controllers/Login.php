<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('user_model', 'user');
    }

    function index() {
        if ($this->user->islogged()) {
            redirect('/dashboard');
        } else if ($this->user->isRootLogged()) {
            redirect('/config');
        }

        $this->load->library('form_validation');
        $this->load->model('user_model', 'user');
        $this->load->helper('url');

        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_error_delimiters('<p class="error">', '</p>');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('login');
        } else {
            $params = array('username' => $this->input->post('username'), 'password' => $this->input->post('password'));
            $query = $this->user->validate($params);

            if ($query) {
                $query = $query[0];
                unset($query["aextpw"]);

                $data = array(
                    'userdata' => $query,
                    'logged' => true
                );
                $this->session->set_userdata($data);
                redirect('/dashboard');
            } else {
                redirect("/login");
            }
        }
    }

    function logout() {
        $data = array('username', 'logged', 'loggedroot');
        $this->session->unset_userdata($data);

        redirect('/login');
    }

}
