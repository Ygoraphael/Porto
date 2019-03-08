<?php

class Tax_model extends CI_Model {
	
	var $fields = array();

	function __construct()
    {
        // Call the Model constructor
        parent::__construct();

        $this->load->database();
    }


    function get( $id ) {

    	$query = $this->db->get_where( 'jos_vm_tax_rate', array( 'tax_rate_id' => $id) );

    	if ( $query->num_rows() > 0 ) {

    		$query = $query->result_array();

            $this->fields = $query[0];

            return $this;
    	}

    	return false;
    } 


    public function save( $insert = false ) {

    	if ( $insert ) {

    		$query = $this->db->insert( 'jos_vm_tax_rate', $this->fields );

    		if ( $query ) {

    			return $this->db->insert_id();
    		}

    	} else {

    		if ( $this->fields['tax_rate_id'] != '' &&
    			$this->fields['tax_rate_id'] > 0 ) {

    			$this->db->where( 'tax_rate_id', $this->fields['tax_rate_id'] );

    			return $this->db->update( 'jos_vm_tax_rate', $this->fields );
    		} else {

    			return $this->save( true );
    		}
    	}
    }

}

?>