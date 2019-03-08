<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Translation {

    protected $CI;

    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->model('translation_model');
    }

    public function Translation_key($key, $lang) {
        $response = $this->CI->translation_model->get_translations_by_key($key, $lang);
        foreach ($response as $resp) {
            $respt = $resp["textvalue"];
        }
        if (!empty($respt)) {
            return $respt;
        } else {
            return $key;
        }
    }

}
