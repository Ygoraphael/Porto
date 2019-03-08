<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Urlparameters {
	
    protected $CI;
	
	public function __construct()
    {
		$this->CI =& get_instance();
    }
	
	public function GetArrayToUrl($parameters, $filter, $value)
	{	
		if( array_key_exists( $filter, $parameters ) ) {
			$current_filter = $parameters[$filter];
			$current_filter = explode('|', $current_filter);
			
			if( in_array( $value, $current_filter ) ) {
				$key = array_search($value, $current_filter);
				unset($current_filter[$key]);

				if( sizeof($current_filter) > 0 ) {
					$parameters[$filter] = implode('%7C', $current_filter);
				}
				else {
					unset($parameters[$filter]);
				}
			}
			else {
				$current_filter[] = $value;
				$parameters[$filter] = implode('%7C', $current_filter);
			}
		}
		else {
			$parameters[$filter] = $value;
		}
		
		return $this->ArrayUrlToString($parameters);
	}
	
	public function ArrayUrlToString($parameters)
	{
		if( sizeof($parameters)>0 ) {
			$url_string = "?";
			foreach($parameters as $key=>$value) {
				$url_string .= $key . '=' . $value . '&';
			}
			
			$url_string = substr($url_string, 0, strlen($url_string) - 1);
		}
		else {
			$url_string = "";
		}
		
		return $url_string;
	}
	
	public function ArrayUrlChangeParameter($parameters, $parametertochange, $destinyvalue)
	{
		if( sizeof($parameters)>0 ) {
			$url_string = "?";
			foreach($parameters as $key=>$value) {
				if( $key == $parametertochange ) {
					//$url_string .= $key . '=' . $destinyvalue . '&';
				}
				else {
					$url_string .= $key . '=' . $value . '&';
					$url_string .= $parametertochange . '=' . $destinyvalue . '&';
				}
			}
			
			$url_string = substr($url_string, 0, strlen($url_string) - 1);
		}
		else {
			$url_string = "";
		}
		
		if( $url_string == "" ) {
			$url_string = "?" . $parametertochange . '=' . $destinyvalue;
		}
		
		return $url_string;
	}
}