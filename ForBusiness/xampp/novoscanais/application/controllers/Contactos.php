<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Contactos extends CI_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $data = array();
        $this->template->content->view('contactos/index', $data);
        $this->template->publish();
    }
/*    function form_contacto() {
        $data = array();
        $data['error'] = '';
        $data['name'] = $this->input->post('name');
        $data['email'] = $this->input->post('email');
        $data['phone'] = $this->input->post('phone');
        $data['subject'] = $this->input->post('subject');
        $data['message'] = $this->input->post('message');

        $this->template->content->view('contactos/form_contacto', $data);
        $this->template->publish();
    }
*/
    function pedido_contacto() {
        $this->load->library('email');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->load->helper('url');

        $data = array();
        $data['name'] = $this->input->post('name');
        $data['email'] = $this->input->post('email');
        $data['phone'] = $this->input->post('phone');
        $data['subject'] = $this->input->post('subject');
        $data['message'] = $this->input->post('message');

        $this->form_validation->set_rules('name', 'Nome', 'trim|required|min_length[6]');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('phone', 'Contacto Telefónico', 'trim|required');
        $this->form_validation->set_rules('message', 'Mensagem', 'trim|required');
        $this->form_validation->set_rules('subject', 'Assunto', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $data['error'] = validation_errors();
            $this->template->content->view('contactos/pedido_contacto', $data);
        } else {
            $email_to = 'geral@novoscanais.com';

            $htmlmessage = '<h4>Foi enviada uma mensagem a partir do site da Novoscanais:</h4>';
            $htmlmessage .= '<h4>Nome: ' . $data['name'] . '</h4>';
            $htmlmessage .= '<h4>Email: ' . $data['email'] . '</h4>';
            $htmlmessage .= '<h4>Contacto telefónico: ' . $data['phone'] . '</h4>';
            $htmlmessage .= '<h4>Assunto: ' . $data['subject'] . '</h4>';
            $htmlmessage .= '<h4>Mensagem: ' . $data['message'] . '</h4><br>';

            $this->email->from('noreply@novoscanais.com');
            $this->email->to($email_to);
            $this->email->subject("Mensagem enviada a partir do site da Novoscanais");
            $this->email->message($htmlmessage);
            $r = $this->email->send();

            if (!$r) {
                $data['error'] = $this->email->print_debugger();
                $this->template->content->view('contactos/pedido_contacto', $data);
            } else {
                redirect('contactos/contacto_sucesso', 'refresh');
            }
        }
        $this->template->publish();
    }

    function contacto_sucesso() {
        $data = array();
        $this->template->content->view('contactos/contacto-sucesso', $data);
        $this->template->publish();
    }

}

?>
