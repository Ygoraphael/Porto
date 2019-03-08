<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Translation {
	
    protected $CI;
	
	public function __construct()
    {
		$this->CI =& get_instance();
		$this->CI->load->model('translation_model');
		  
    }
	
	public function Translation_key($key)
	{
		  
		  $response = $this->CI->translation_model->get_translations_by_key($key);
		  if($response == null){
			   return  $key;
		  }else{
			 return  $response->textvalue;  
		  }
		 
	}
	
	
}