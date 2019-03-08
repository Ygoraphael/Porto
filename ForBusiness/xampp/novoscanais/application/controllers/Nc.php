<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Nc extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('url');
    }

    function contacto() {
        $data = array();
        $data['error'] = '';
        $data['nome'] = '';
        $data['email'] = '';
        $data['telemovel'] = '';
        $data['parceiro'] = '';
        $data['subject'] = '';
        $data['message'] = '';
        $this->load->view('novoscanais/contacto', $data);
    }

    function enviar_mail2() {
        $this->load->library('email');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->helper('url');


        $this->form_validation->set_rules('name', 'Nome', 'trim|required|min_length[6]');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');


        if ($this->form_validation->run() == FALSE) {
            $data = array();
            $data['error'] = validation_errors();
            $data['nome'] = $this->input->post('name');
            $data['email'] = $this->input->post('email');
            $data['telemovel'] = $this->input->post('telemovel');
            $data['parceiro'] = $this->input->post('parceiro');
            $data['subject'] = $this->input->post('subject');
            $data['message'] = $this->input->post('message');

            $this->load->view('novoscanais/contacto', $data);
        } else {

            $name = $this->input->post('name');
            $email_from = $this->input->post('email');
            $email_to = 'ivan.alonzo@novoscanais.com';
            $email_to2 = 'geral@novoscanais.com';
            $email_to3 = 'exsorio@gmail.com';
            $telemovel = $this->input->post('telemovel');
            $parceiro = $this->input->post('parceiro');
            $subject = $this->input->post('subject');
            $message = $this->input->post('message');


            /** Para Imagems pero ainda não sei fazer* */
            $base = base_url();
            $url = $base . "images/logo/logo_preto.jpg";
            $f = $base . "images/mail/phc_cs_advanced.png";
            $f2 = $base . "images/mail/drivefx.png";
            $f3 = $base . "images/mail/barra_assinaturas.jpg";

            $htmlmessage = '<h1> NOVOSCANAIS </h1><hr><br>';
            $htmlmessage .= '<h2> O Cliente: ' . $parceiro . ' solicitou uma demostração grátis de PHC</h3><br>';
            $htmlmessage .= '<h4> Representante: ' . $name . '</h4>';
            $htmlmessage .= '<h4> Telemovél: ' . $telemovel . '</h4>';
            $htmlmessage .= '<h4> Correio eletrônico: ' . $email_from . '</h4>';
            $htmlmessage .= '<h3> Message: ' . $message . '</h3><br>';

            $this->email->from('noreply@novoscanais.com');
            $this->email->to($email_to3);
            $this->email->cc($email_to);
            $this->email->subject($subject);
            $this->email->message($htmlmessage);
            $this->email->send();

            if ($this->email->send(FALSE)) {

                $data = array();
                $data['error'] = $this->email->print_debugger();
                $data['nome'] = $this->input->post('name');
                $data['email'] = $this->input->post('email');
                $data['telemovel'] = $this->input->post('telemovel');
                $data['parceiro'] = $this->input->post('parceiro');
                $data['subject'] = $this->input->post('subject');
                $data['message'] = $this->input->post('message');

                $this->load->view('novoscanais/contacto', $data);
            } else {
                $this->cronometro(base_url(), 35);
                $this->load->view('novoscanais/msj_success');
            }
        }
    }

    function equipa() {
        $this->load->view('novoscanais/equipa');
    }

    function portafolio() {
        $this->load->view('novoscanais/portafolio');
    }

    function demonstration() {
        $data = array();
        $data['error'] = '';
        $data['nome'] = '';
        $data['email'] = '';
        $data['telemovel'] = '';
        $data['parceiro'] = '';
        $data['subject'] = '';
        $data['message'] = '';
        $this->load->view('novoscanais/demonstration', $data);
    }

    function enviar_mail() {
        $this->load->library('email');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->helper('url');


        $this->form_validation->set_rules('name', 'Nome', 'trim|required|min_length[6]');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');


        if ($this->form_validation->run() == FALSE) {
            $data = array();
            $data['error'] = validation_errors();
            $data['nome'] = $this->input->post('name');
            $data['email'] = $this->input->post('email');
            $data['telemovel'] = $this->input->post('telemovel');
            $data['parceiro'] = $this->input->post('parceiro');
            $data['subject'] = $this->input->post('subject');
            $data['message'] = $this->input->post('message');

            $this->load->view('novoscanais/demonstration', $data);
        } else {

            $name = $this->input->post('name');
            $email_from = $this->input->post('email');
            $email_to = 'ivan.alonzo@novoscanais.com';
            $email_to2 = 'geral@novoscanais.com';
            $email_to3 = 'exsorio@gmail.com';
            $telemovel = $this->input->post('telemovel');
            $parceiro = $this->input->post('parceiro');
            $subject = $this->input->post('subject');
            $message = $this->input->post('message');


            /** Para Imagems pero ainda não sei fazer* */
            $base = base_url();
            $url = $base . "images/logo/logo_preto.jpg";
            $f = $base . "images/mail/phc_cs_advanced.png";
            $f2 = $base . "images/mail/drivefx.png";
            $f3 = $base . "images/mail/barra_assinaturas.jpg";

            $htmlmessage = '<h1> NOVOSCANAIS </h1><hr><br>';
            $htmlmessage .= '<h2> O Cliente: ' . $parceiro . ' solicitou uma demostração grátis de PHC</h3><br>';
            $htmlmessage .= '<h4> Representante: ' . $name . '</h4>';
            $htmlmessage .= '<h4> Telemovél: ' . $telemovel . '</h4>';
            $htmlmessage .= '<h4> Correio eletrônico: ' . $email_from . '</h4>';
            $htmlmessage .= '<h3> Message: ' . $message . '</h3><br>';

            $this->email->from('noreply@novoscanais.com');
            $this->email->to($email_to3);
            $this->email->cc($email_to);
            $this->email->subject($subject);
            $this->email->message($htmlmessage);
            $this->email->send();

            if ($this->email->send(FALSE)) {

                $data = array();
                $data['error'] = $this->email->print_debugger();
                $data['nome'] = $this->input->post('name');
                $data['email'] = $this->input->post('email');
                $data['telemovel'] = $this->input->post('telemovel');
                $data['parceiro'] = $this->input->post('parceiro');
                $data['subject'] = $this->input->post('subject');
                $data['message'] = $this->input->post('message');

                $this->load->view('novoscanais/demonstration', $data);
            } else {
                $this->cronometro(base_url(), 35);
                $this->load->view('novoscanais/msj_success');
            }
        }
    }

    public function cronometro($url, $segundos) {

        if (!$segundos) {
            $segundos = 0;
        }
        echo '<meta http-equiv="refresh" content="' . $segundos . '; url=' . $url . '" />';
    }
}

?>