<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Backoffice_login extends CI_Controller {

    public function __construct() {

        parent::__construct();
        $this->load->library(array('session'));
        $this->load->helper(array('url'));
        $this->load->model('user_model');
    }

    public function index() {
        $this->template->frontpage = "false";
        $this->load->model('user_model');

        $data = $this->session->flashdata('data');

        $data['postRed'] = empty($this->input->post('postRed')) ? '' : '+&postRed=' . $this->input->post('postRed');
        $data['postDt'] = empty($this->input->post('postDt')) ? '' : '+&postDt=' . $this->input->post('postDt');

        if (isset($_SESSION["backoffice_user_id"]) && $_SESSION["backoffice_user_id"] > 0) {
            //redirect
            $data['user'] = $this->user_model->get_backoffice_user($_SESSION["backoffice_user_id"], $_SESSION["backoffice_user_estab"]);

            if (isset($data['returnTo']) && $data['returnTo'] != '') {
                $this->template->content->view($data['returnTo'], $data);
            } else {
                redirect('/backoffice');
            }
            $this->template->publish();
        } else {
            //login or register
            $this->session->set_flashdata('data', $data);
            $this->template->content->view('backoffice_login', $data);
            $this->template->publish();
        }
    }

    public function login() {

        // create the data object
        $data = new stdClass();

        // load form helper and validation library
        $this->load->helper('form');
        $this->load->library('form_validation');

        // set validation rules
        $this->form_validation->set_rules('no', 'no', 'required');
        $this->form_validation->set_rules('estab', 'estab', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        //Validation Recaptcha
        $recaptcha = $_POST['g-recaptcha-response'];
        //log_message("ERROR",print_r($recaptcha,TRUE));

        if ($recaptcha) {
            $secret = "6LcU7iMUAAAAAHnVRYvEE5SZzzesOh6vl2felU9x";
            $ip = $_SERVER['REMOTE_ADDR'];
            //log_message("ERROR",print_r($ip,TRUE));
            $var = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $recaptcha . "&remopteip=" . $ip);
            $get_resGoogle = json_decode($var, TRUE);
            if ($get_resGoogle['success']) { //log_message("ERROR",print_r($get_resGoogle,TRUE));
            } else {
                $this->form_validation->set_rules('recaptcha', 'recaptcha', 'required');
            }
        } else {
            $this->form_validation->set_rules('recaptcha', 'recaptcha', 'required');
        }
        if ($this->form_validation->run() == false) {
            // validation not ok, send validation errors to the view
            $data->error = validation_errors();
            $data->redirect_page_error = '';
            $data->redirect_page_success = '';
            $data->success = 0;
        } else {
            // set variables from the form
            $no = $this->input->post('no');
            $estab = $this->input->post('estab');
            $password = $this->input->post('password');
            $recaptcha = $_POST['g-recaptcha-response'];

            if ($this->user_model->resolve_backoffice_user_login($no, $estab, $password)) {

                $user = $this->user_model->get_backoffice_user_mssql($no, $estab);

                // set session user datas
                $_SESSION['backoffice_user_id'] = (int) $user["no"];
                $_SESSION['backoffice_user_estab'] = (int) $user["estab"];
                $_SESSION['backoffice_logged_in'] = (bool) true;
                $_SESSION['lang_u'] = $user["lang"];

                // user login ok
                $data->error = '';
                $data->redirect_page_error = '';
                $data->redirect_page_success = '';
                $data->success = 1;
            } else {
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

        if (isset($_SESSION['backoffice_logged_in']) && $_SESSION['backoffice_logged_in'] === true) {

            // remove session datas
            foreach ($_SESSION as $key => $value) {
                if (strpos($key, 'backoffice_') !== false)
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
