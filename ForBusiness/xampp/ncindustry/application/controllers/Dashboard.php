<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('user_model', 'user');
        $this->load->model('Dashboard_model', 'dashboard');
        $this->user->logged();
    }
    
    function index() {
        $data = array();
        
        $params = array('dataobra = GETDATE()');
        $data["enc_novas"] = $this->dashboard->getEncomendasNovas($params);
        
        $params = array('dataobra = GETDATE()');
        $data["enc_fechadas"] = $this->dashboard->getEncomendasFechadas($params);
        
        $data["enc_abertas"] = $this->dashboard->getEncomendasAbertas();
        
        $params = array('YEAR(dataobra) = YEAR(GETDATE())');
        $data["enc_abertas_fechadas_mes"] = $this->dashboard->ChartEncomendasAbertasFechadasMes($params);
        
        $data["stock_falta"] = array_slice($this->dashboard->StockArtigoEncomendado(), 0, 10);

        $this->template->content->view('dashboard_picking', $data);
	$this->template->publish();
    }
}
