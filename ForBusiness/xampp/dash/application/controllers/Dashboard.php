<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('user_model', 'user');
        $this->load->model('Dashboard_model', 'dashboard');
    }

    function index() {
        $data = array();

        //$data['appstorun'] = array("dashboard/ongoing_inter", "dashboard/paused_inter", "dashboard/today_summary");
        $data['appstorun'] = array("dashboard/best_employee");

        $this->template->content->view('dashboard/index', $data);
        $this->template->publish();
    }
    
    function ongoing_inter() {
        $this->template->set_template('template_ajax');
        $data = array();

        $data['ongoing_inter'] = $this->dashboard->get_inters(1);

        $this->template->content->view('dashboard/ongoing_inter', $data);
        $this->template->publish();
    }
    
    function paused_inter() {
        $this->template->set_template('template_ajax');
        $data = array();

        $data['ongoing_inter'] = $this->dashboard->get_inters(0);

        $this->template->content->view('dashboard/paused_inter', $data);
        $this->template->publish();
    }
    
    function today_summary() {
        $this->template->set_template('template_ajax');
        $data = array();

        $data['tecs'] = $this->dashboard->get_tecs_summary();

        $this->template->content->view('dashboard/today_summary', $data);
        $this->template->publish();
    }
    
    function best_employee() {
        $this->template->set_template('template_ajax');
        $data = array();

        $data['tecs'] = $this->dashboard->get_best_employee(date('Y', strtotime('first day of last month')), date('m', strtotime('first day of last month')));

        $this->template->content->view('dashboard/best_employee', $data);
        $this->template->publish();
    }

}
