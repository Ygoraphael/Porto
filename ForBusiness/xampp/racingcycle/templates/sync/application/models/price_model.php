<?php

class Price_model extends CI_Model {
	
	var $fields = array();

	function __construct()
    {
        // Call the Model constructor
        parent::__construct();

        $this->load->database();
    }
    

    function get_last_date() {

        $this->db->select_max( 'mdate', 'mdate' );
        $query = $this->db->get( 'jos_vm_product_price' );

        $row = $query->result_array();

        return $row;
    }


    function get( $product_id, $shopper_group_id ) {


    	$this->db->where( 'product_id', $product_id );
    	$this->db->where( 'shopper_group_id', $shopper_group_id );

    	$query = $this->db->get( 'jos_vm_product_price' ); 

    	if ( $query->num_rows() > 0 ) {

    		foreach( $query->result_array() as $row ) {

                $this->fields = $row; 

                return $this;

            }
    	}


    	return false;
    }


    function save( $insert = false ) {

    	if ( $insert ) {

    		if( !$this->db->insert( 'jos_vm_product_price', $this->fields ) ) {
                return false;
            }

            return true;

    	} else {

    		if ( $this->fields['product_price_id'] != '' && 
    			$this->fields['product_price_id'] > 0 ) {

    			$this->db->where( 'product_price_id', $this->fields['product_price_id'] );

    			if ( !$this->db->update( 'jos_vm_product_price', $this->fields) ) {
                    return false;
                }

                return true;
    		}
    	}
    }



}



?>