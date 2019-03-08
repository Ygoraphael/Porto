<?php

namespace App\Controller;

use Cosmos\System\Controller;

class Translate extends Controller {

    private $response;



    function __construct() {
		parent::__construct($this);
    }
	
	
	public function translate_script() {
		$string = filter_input(INPUT_POST, 'string', FILTER_SANITIZE_STRING);
		$translate = (new \App\Model\Translate());
		$translate->translater($string);
		if($translate){
			$this->translate = $translate->translate;
		}		
		echo json_encode($this->translate);
    }



}
