<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Utils {

    protected $CI;

    public function __construct() {
        $this->CI = & get_instance();
    }

    function validateDate($date, $format = 'Y-m-d') {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    function set_back_url() {
        if ($this->CI->session->userdata('current_url') != current_url()) {
            $this->CI->session->set_userdata('previous_url', $this->CI->session->userdata('current_url'));
            $this->CI->session->set_userdata('current_url', current_url());
        }
    }

}
