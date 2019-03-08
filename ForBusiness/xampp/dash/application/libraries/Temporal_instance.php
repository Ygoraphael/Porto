<?php

if (!defined("BASEPAHT"))
    exit("No direct script access allowed");

class Temporal_instance {

    public function __construct() {

        $this->$CI = & get_instance();

        $ci->load->model("Ponto_model");
    }

    public function get_nome_product($ststamp) {

        $result = $ci->Ponto_model->get_produt($ststamp);
        if ($result) {
            foreach ($result as $resp) {

                return $resp;
            }
        }
        return false;
    }

}
