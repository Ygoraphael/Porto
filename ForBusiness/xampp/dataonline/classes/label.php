<?php

class Label {
	
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
		
		if( $this->countvals == 4) {
			
			$str .= "<div class='masked'>";
			if(trim($this->format_1) != "")
				$str .= sprintf(trim($this->format_1), $this->data[0][$this->field_1]);
			else
				$str .= $this->data[0][$this->field_1];
			$str .= "</div>";
			$str .= "<div class='maskedsec'>";
			$str .= $this->label_1;
			$str .= "</div>";
			
			$str .= "<div class='masked'>";
			if(trim($this->format_2) != "")
				$str .= sprintf(trim($this->format_2), $this->data[0][$this->field_2]);
			else
				$str .= $this->data[0][$this->field_2];
			$str .= "</div>";
			$str .= "<div class='maskedsec'>";
			$str .= $this->label_2;
			$str .= "</div>";
			
			$str .= "<div class='masked'>";
			if(trim($this->format_3) != "")
				$str .= sprintf(trim($this->format_3), $this->data[0][$this->field_3]);
			else
				$str .= $this->data[0][$this->field_3];
			$str .= "</div>";
			$str .= "<div class='maskedsec'>";
			$str .= $this->label_3;
			$str .= "</div>";
			
			$str .= "<div class='masked'>";
			if(trim($this->format_4) != "")
				$str .= sprintf(trim($this->format_4), $this->data[0][$this->field_4]);
			else
				$str .= $this->data[0][$this->field_4];
			$str .= "</div>";
			$str .= "<div class='maskedsec'>";
			$str .= $this->label_4;
			$str .= "</div>";
			
			$this->return_str = $str.$end_final;
			
			return $this->return_str;
		}
		
		if( $this->countvals == 3 ) {
		
			$str .= "<div class='masked'>";
			if(trim($this->format_1) != "")
				$str .= sprintf(trim($this->format_1), $this->data[0][$this->field_1]);
			else
				$str .= $this->data[0][$this->field_1];
			$str .= "</div>";
			$str .= "<div class='maskedsec'>";
			$str .= $this->label_1;
			$str .= "</div>";
			
			$str .= "<div class='masked'>";
			if(trim($this->format_2) != "")
				$str .= sprintf(trim($this->format_2), $this->data[0][$this->field_2]);
			else
				$str .= $this->data[0][$this->field_2];
			$str .= "</div>";
			$str .= "<div class='maskedsec'>";
			$str .= $this->label_2;
			$str .= "</div>";
			
			$str .= "<div class='masked'>";
			if(trim($this->format_3) != "")
				$str .= sprintf(trim($this->format_3), $this->data[0][$this->field_3]);
			else
				$str .= $this->data[0][$this->field_3];
			$str .= "</div>";
			$str .= "<div class='maskedsec'>";
			$str .= $this->label_3;
			$str .= "</div>";
			
			$this->return_str = $str.$end_final;
			
			return $this->return_str;
		}
		
		if( $this->countvals == 2 ) {
		
			$str .= "<div class='masked'>";
			if(trim($this->format_1) != "")
				$str .= sprintf(trim($this->format_1), $this->data[0][$this->field_1]);
			else
				$str .= $this->data[0][$this->field_1];
			$str .= "</div>";
			$str .= "<div class='maskedsec'>";
			$str .= $this->label_1;
			$str .= "</div>";
			
			$str .= "<div class='masked'>";
			if(trim($this->format_2) != "")
				$str .= sprintf(trim($this->format_2), $this->data[0][$this->field_2]);
			else
				$str .= $this->data[0][$this->field_2];
			$str .= "</div>";
			$str .= "<div class='maskedsec'>";
			$str .= $this->label_2;
			$str .= "</div>";
			
			$this->return_str = $str.$end_final;
			
			return $this->return_str;
		}
		
		if( $this->countvals == 1 ) {
		
			$str .= "<div class='masked'>";
			if(trim($this->format_1) != "")
				$str .= sprintf(trim($this->format_1), $this->data[0][$this->field_1]);
			else
				$str .= $this->data[0][$this->field_1];
			$str .= "</div>";
			$str .= "<div class='maskedsec'>";
			$str .= $this->label_1;
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