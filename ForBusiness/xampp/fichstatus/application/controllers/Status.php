<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Status extends CI_Controller {
    public function index() {
        $f = $this->input->post("f");
        $apikey = $this->input->post("apikey");
        
        if ($f && $apikey) {
            if ($apikey == "phc656") {
                log_message("error", "apikey");
                $this->db->select('estado');
                $this->db->from('cl');
                $this->db->where('numficha', $f);
                $query = $this->db->get();

                if ($query->num_rows()) {
                    $row = $query->row_array();
                    echo $row["estado"];
                } else {
                    echo 1;
                }
            }
        }
    }
}
