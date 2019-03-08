<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('user_model', 'user');
        $this->template->set_template('template_ajax');
    }

    function get_timestamp() {
        echo time();
    }

    function jsonDecode($json, $assoc = false) {
        $ret = json_decode($json, $assoc);
        if ($error = json_last_error()) {
            $errorReference = [
                JSON_ERROR_DEPTH => 'The maximum stack depth has been exceeded.',
                JSON_ERROR_STATE_MISMATCH => 'Invalid or malformed JSON.',
                JSON_ERROR_CTRL_CHAR => 'Control character error, possibly incorrectly encoded.',
                JSON_ERROR_SYNTAX => 'Syntax error.',
                JSON_ERROR_UTF8 => 'Malformed UTF-8 characters, possibly incorrectly encoded.',
                JSON_ERROR_RECURSION => 'One or more recursive references in the value to be encoded.',
                JSON_ERROR_INF_OR_NAN => 'One or more NAN or INF values in the value to be encoded.',
                JSON_ERROR_UNSUPPORTED_TYPE => 'A value of a type that cannot be encoded was given.',
            ];
            $errStr = isset($errorReference[$error]) ? $errorReference[$error] : "Unknown error ($error)";
            throw new \Exception("JSON decode error ($error): $errStr");
        }
        return $ret;
    }

}
