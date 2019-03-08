<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Currency {
	
    protected $CI;
	private $rate;
	
	public function __construct()
    {
		$this->CI =& get_instance();
		
		if( isset($_SESSION["type_currency"]) && isset($_SESSION["ch"]) != '') { 
		}
		else {
			$_SESSION["type_currency"] = "EURO";
			$_SESSION["ch"] = "EUR";
			$_SESSION["i"] = "&#xf153;";
			$_SESSION["c_currency"] = 1;
		}
    }
	  
	public static function change($ch)
    {
		$url = 'http://finance.yahoo.com/d/quotes.csv?e=.csv&f=sl1d1t1&s=EUR'.$ch.'=X';
        $handle = @fopen($url, 'r');
		
		if ($handle) {
            $result = fgets($handle, 4096);
            fclose($handle);
        }
		
        if (isset($result)) {
            $allData = explode(',', $result);
			$rate  = $allData[1];
        }
		else {
           $rate  = 0;
        }

		if($ch && isset($ch) !='' ){
			$pricefl = $rate;
		}	

        return($pricefl);
    }
	
	// Calculo Val costo * valCHANGE//EUR VS Currency function change()//
	public static function valor($ch){
		if(isset($ch) && trim($ch) !='' ){
			$pricefl = number_format( $ch * $_SESSION["c_currency"], 2, '.', ',');
		}	
		
		return($pricefl);	
	}
		
	// Calculo Val costo * valCHANGE//EUR VS Currency function change()// to JQuery
	public static function multiplicador($ch){
		if($ch && isset($ch) !='' ){
			$pricefl = number_format($_SESSION["c_currency"],2,'.',',');
		}		
		return($pricefl);	
	}	
}
    