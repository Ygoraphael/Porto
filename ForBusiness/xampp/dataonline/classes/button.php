<?php

class Button {
	
	public $data;
	public $countvals;
	public $table_id;
	public $model;
	public $field_1;
	public $field_2;
	public $field_3;
	public $field_4;
	public $label_1;
	public $label_2;
	public $label_3;
	public $label_4;
	public $format_1;
	public $format_2;
	public $format_3;
	public $format_4;
	public $link;
	public $height;
	
	public $slot_number;
	
	public $return_str;
	
	public function __construct() {
	}
	
	public function get() {
	
		$str = "";
		$str2 = "";
		$str3 = "";
		$str4 = "";
		
		$end_final = "";
		
		if( $this->countvals == 1 ) {
			$str .= "<div class='imgclick' style='width:100%; height:100%;' onclick='window.location.replace(".'"'.$this->link.'"'.")'>";
			if(sizeof($this->data)>0) {
				if(trim($this->data[0][$this->field_1]) != "") {
					$str .= "<div class='masked'>";
					if(trim($this->format_1) != "") {
						$str .= sprintf(trim($this->format_1), $this->data[0][$this->field_1]);
					}
					else {
						$str .= $this->data[0][$this->field_1];
					}
					$str .= "</div>";
					$padding_top = "";
				}
			}
			$str .= "<div class='maskedsec' style='position: absolute; top: 50%; left: 50%; height: 30%; width: 50%; margin: -15% 0 0 -25%;'>";
			$str .= $this->label_1;
			$str .= "</div>";
			$str .= "</div>";
			
			$this->return_str = $str.$end_final;
			
			return $this->return_str;
		}
		
		if( $this->countvals == 0 ) {
		
			$str .= "<table id='$this->slot_number' style='width:100%;height:100%;'>";
			$str .= "</table>";
			$this->return_str = $str.$end_final;
			
			return $this->return_str;
		}
	}
}

?>