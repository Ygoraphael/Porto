<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('user_model', 'user');
        $this->load->model('Dashboard_model', 'dashboard');
        $this->load->model('Ov_model', 'objectivos');
        $this->user->logged();
    }

    function index() {
        $this->breadcrumbs->push('Dashboard', '/dashboard');
        $data = array();
      
        $data['best_seller_st'] = $this->dashboard->get_best_seller_st(array("year" => date('Y')));
        $data['best_seller_stfami'] = $this->dashboard->get_best_seller_stfami(array("year" => date('Y')));
        if (date('m') == 1) {
            $last_month = 12;
            $last_year = date('Y') - 1;
        } else {
            $last_month = date('m') - 1;
            $last_year = date('Y');
        }
        $data['cur_month_sales'] = $this->dashboard->get_month_sales(array("year" => date('Y'), "month" => date('m')));
        $data['last_month_sales'] = $this->dashboard->get_month_sales(array("year" => $last_year, "month" => $last_month));
        $data['cur_month_purchases'] = $this->dashboard->get_month_purchases(array("year" => date('Y'), "month" => date('m')));
        $data['last_month_purchases'] = $this->dashboard->get_month_purchases(array("year" => $last_year, "month" => $last_month));
        $data['salesman_year_sales'] = $this->dashboard->get_year_sales_salesman(array("year" => date('Y'), "salesman" => $this->session->userdata('userdata')['vendedor']));
        $data['salesman_previous_year_sales'] = $this->dashboard->get_year_sales_salesman(array("year" => date('Y')-1, "salesman" => $this->session->userdata('userdata')['vendedor']));
        $data['salesman_previous_previous_year_sales'] = $this->dashboard->get_year_sales_salesman(array("year" => date('Y')-2, "salesman" => $this->session->userdata('userdata')['vendedor']));
        //
    
        $total_sales = 0;
        foreach( $data['salesman_previous_year_sales'] as $month ) {
            $total_sales += floatval($month["valor"]);
        }
        
        $data['salesman_previous_year_sales_total'] = number_format($total_sales, 2, '.', '');
        
        $total_sales = 0;
        foreach( $data['salesman_year_sales'] as $month ) {
            $total_sales += floatval($month["valor"]);
        }
        $data['salesman_year_sales_total'] = number_format($total_sales, 2, '.', '');
        
        //
        $data['salesman_data'] = $this->user->get_salesman_data(array("salesman" => $this->session->userdata('userdata')['vendedor']));
        $data['year_sales'] = $this->dashboard->get_year_sales(array("year" => date('Y')));
        $data['previous_year_sales'] = $this->dashboard->get_year_sales(array("year" => date('Y')-1));
        $data['rankdiv'] = $this->dashboard->get_ranking_clientes_divida();
        $data['rankdiv_salesman'] = $this->dashboard->get_ranking_clientes_divida_salesman(array("vendedor" => $this->session->userdata('userdata')['vendedor']));
       
        $total_sales = 0;
        foreach( $data['year_sales'] as $month ) {
            $total_sales += floatval($month["valor"]);
        }
        $data['year_sales_total'] = number_format($total_sales, 2, '.', '');
        $total_sales = 0;
        foreach( $data['previous_year_sales'] as $month ) {
            $total_sales += floatval($month["valor"]);
        }
        $data['previous_year_sales_total'] = number_format($total_sales, 2, '.', '');
        $data['top5_area_year_sales'] = $this->dashboard->get_top_area_year_sales(array("year" => date('Y')));
        $data['top5_area_salesman_year_sales'] = $this->dashboard->get_top_area_salesman_year_sales(array("vendedor" => $this->session->userdata('userdata')['vendedor'],"year" => date('Y')));
        
        $data['Objective_Current_Year'] = $this->objectivos->getObjectivoByVendedorAno(array("vendedor" => $this->session->userdata('userdata')['vendedor'] , "ano" => date('Y')));
        $data['Objective_Previous_Year'] = $this->objectivos->getObjectivoByVendedorAno(array("vendedor" => $this->session->userdata('userdata')['vendedor'] , "ano" => date('Y')-1));
        $data['Objective_Previous_Previous_Year'] = $this->objectivos->getObjectivoByVendedorAno(array("vendedor" => $this->session->userdata('userdata')['vendedor'] , "ano" => date('Y')-2));
        
        $data['Count_Sales_Salesman_Three_Years'] = array($this->dashboard->get_count_year_sales_salesman(array("vendedor" => $this->session->userdata('userdata')['vendedor'] , "ano" => date('Y'))),$this->dashboard->get_count_year_sales_salesman(array("vendedor" => $this->session->userdata('userdata')['vendedor'] , "ano" => date('Y')-1)),$this->dashboard->get_count_year_sales_salesman(array("vendedor" => $this->session->userdata('userdata')['vendedor'] , "ano" => date('Y')-2)));
        
        $data['Average_Sales_Salesman_Three_Years'] = array($this->dashboard->get_average_year_sales_salesman(array("vendedor" => $this->session->userdata('userdata')['vendedor'] , "ano" => date('Y'))),$this->dashboard->get_average_year_sales_salesman(array("vendedor" => $this->session->userdata('userdata')['vendedor'] , "ano" => date('Y')-1)),$this->dashboard->get_average_year_sales_salesman(array("vendedor" => $this->session->userdata('userdata')['vendedor'] , "ano" => date('Y')-2)));
        
        $data['Max_Sales_Salesman_Three_Years'] = array($this->dashboard->get_max_year_sales_salesman(array("vendedor" => $this->session->userdata('userdata')['vendedor'] , "ano" => date('Y'))),$this->dashboard->get_max_year_sales_salesman(array("vendedor" => $this->session->userdata('userdata')['vendedor'] , "ano" => date('Y')-1)),$this->dashboard->get_max_year_sales_salesman(array("vendedor" => $this->session->userdata('userdata')['vendedor'] , "ano" => date('Y')-2)));
      
        $this->template->content->view('dashboard/index', $data);
        $this->template->publish();
    }

}
