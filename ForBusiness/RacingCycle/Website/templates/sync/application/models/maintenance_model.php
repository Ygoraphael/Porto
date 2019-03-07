<?php

class Maintenance_model extends CI_Model {
	
	var $fields = array();

	function __construct()
    {
        // Call the Model constructor
        parent::__construct();

        $this->load->database();
    }
    

    function clean_db() {

		$this->db->empty_table('d2e0b_virtuemart_products');
		$this->db->empty_table('d2e0b_virtuemart_products_en_gb');
		$this->db->empty_table('d2e0b_virtuemart_products_pt_pt');
		$this->db->empty_table('d2e0b_virtuemart_product_categories');
		$this->db->empty_table('d2e0b_virtuemart_product_customfields');
		$this->db->empty_table('d2e0b_virtuemart_product_medias');
		$this->db->empty_table('d2e0b_virtuemart_product_prices');
		$this->db->empty_table('d2e0b_virtuemart_categories');
		$this->db->empty_table('d2e0b_virtuemart_categories_en_gb');
		$this->db->empty_table('d2e0b_virtuemart_categories_pt_pt');
		$this->db->empty_table('d2e0b_virtuemart_category_categories');
		$this->db->empty_table('d2e0b_virtuemart_category_medias');
		$this->db->empty_table('d2e0b_virtuemart_medias');
    }


}



?>