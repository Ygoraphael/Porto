<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calendar extends CI_Controller {

    public function index()
    {
        $this->load->model('calendar_model');
        $product = $this->input->get('event');
        $month = $this->input->get('mes');
        $year = $this->input->get('ano');

        echo json_encode( $this->calendar_model->get_days($product, $month, $year) );
    }

    public function session()
    {
        $this->load->model('calendar_model');
        $product = $this->input->get('event');
        $date = $this->input->get('date');
        $date = explode("/", $date);

        $day = $date[1];
        $month = $date[0];
        $year = $date[2];

        //month/day/year
        echo json_encode( $this->calendar_model->get_sessions($product, $day, $month, $year) );
    }

    public function prices()
    {
        $this->load->model('calendar_model');
        $product = $this->input->get('event');
        $session = $this->input->get('session');
        $date = $this->input->get('date');
        $date = explode("/", $date);

        $day = $date[1];
        $month = $date[0];
        $year = $date[2];

        echo json_encode( $this->calendar_model->get_prices($product, $day, $month, $year, $session) );
    }

    public function maxlotation()
    {
        $this->load->model('calendar_model');
        $product = $this->input->get('event');
        $session = $this->input->get('session');
        $op = $this->input->get('op');
        $date = $this->input->get('date');
        $date = explode("/", $date);

        $day = $date[1];
        $month = $date[0];
        $year = $date[2];

        echo json_encode( $this->calendar_model->get_maxlotation($product, $day, $month, $year, $session, $op) );
    }

    public function seat_prices()
    {
        $this->load->model('calendar_model');
        $product = $this->input->get('event');
        $session = $this->input->get('session');
        //cor
        $seat = $this->input->get('seat');
        //tam
        $type = $this->input->get('type');
        $date = $this->input->get('date');
        $date = explode("/", $date);

        $day = $date[1];
        $month = $date[0];
        $year = $date[2];

        echo json_encode( $this->calendar_model->get_seatprices($product, $day, $month, $year, $session, $seat, $type) );
    }

    public function seat_tickets()
    {
        $this->load->model('calendar_model');
        $product = $this->input->get('event');
        $session = $this->input->get('session');
        $seat = $this->input->get('seat');
        $date = $this->input->get('date');
        $date = explode("/", $date);

        $day = $date[1];
        $month = $date[0];
        $year = $date[2];

        echo json_encode( $this->calendar_model->get_seattickets($product, $day, $month, $year, $session, $seat) );
    }

    public function get_unavailableseats()
    {
        $this->load->model('calendar_model');
        $product = $this->input->get('event');
        $session = $this->input->get('session');
        $date = $this->input->get('date');
        $date = explode("/", $date);

        $day = $date[1];
        $month = $date[0];
        $year = $date[2];

        echo json_encode( $this->calendar_model->get_unavailableseats($product, $day, $month, $year, $session) );
    }

    public function check_voucher_wl() {
        $this->load->helper('cookie');
        $this->load->library('urlparameters');
        $this->load->model('calendar_model');
        $this->load->model('checkout_model');
        $bostamp = $this->input->post('bostamp');
        $voucher = $this->input->post('voucher');
        $op = $this->input->post('op');

        $result = $this->calendar_model->voucher_validation($bostamp, $voucher);

        if( $result["success"] == 1 ) {
            $anon_cookie = get_cookie('EWA_WL_'.$op);

            if( !is_null( $anon_cookie ) )
            {
                $tmp = $this->checkout_model->get_cart_cookie( $anon_cookie );
                $tmp['voucher'] = $result;
            }
            else {
                $tmp = array();
                $tmp['voucher'] = $result;
            }

            $id = $this->checkout_model->set_cart_cookie( $tmp, $anon_cookie );
            $cookie = array(
                'name'   => 'EWA_WL_'.$op,
                'value'  => $id,
                'expire' => '360',
                'path'   => '/'
            );
            set_cookie($cookie);
        }

        echo json_encode( $result );
    }

    public function check_voucher_ewa() {
        $this->load->model('calendar_model');
        $bostamp = $this->input->post('bostamp');
        $voucher = $this->input->post('voucher');

        $result = $this->calendar_model->voucher_validation($bostamp, $voucher);
        echo json_encode( $result );
    }

    public function rentalinit() {
        $this->load->model('calendar_model');
        $bostamp = $this->input->post('event');
        $date = $this->input->post('date');
        $date = explode("-", $date);

        $day = $date[2];
        $month = $date[1];
        $year = $date[0];

        $result = $this->calendar_model->rentalinit($bostamp, $day, $month, $year);
        echo json_encode( $result );
    }
}
