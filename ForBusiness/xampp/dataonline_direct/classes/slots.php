<?php

class Slots {
	public $slot_number;
	public $sql_str;
	public $connection_type;
	
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
	
	public $type;
	public $return_str;
	public $method;
	public $titulo;
	public $data;
	public $model;
	public $width;
	public $height;
	public $link;
	
	public function __construct() {
	}
	
	public function countvals() {
		if( trim($this->field_1) == "" && trim($this->field_2) == "" && trim($this->field_3) == "" && trim($this->field_4) == "")
			return 0;
		if( trim($this->field_1) != "" && trim($this->field_2) == "" && trim($this->field_3) == "" && trim($this->field_4) == "")
			return 1;
		if( trim($this->field_1) != "" && trim($this->field_2) != "" && trim($this->field_3) == "" && trim($this->field_4) == "")
			return 2;
		if( trim($this->field_1) != "" && trim($this->field_2) != "" && trim($this->field_3) != "" && trim($this->field_4) == "")
			return 3;
		if( trim($this->field_1) != "" && trim($this->field_2) != "" && trim($this->field_3) != "" && trim($this->field_4) != "")
			return 4;
	}
	
	public function arrayUtf8Enconde(array $array) {
		$novo = array();
		foreach ($array as $i => $value) {
			if (is_array($value)) {
				$value = arrayUtf8Enconde($value);
			} 
			elseif (!mb_check_encoding($value, 'UTF-8')) {
				$value = utf8_encode($value);
			}
			$novo[$i] = $value;
		}
		return $novo;
	}
	
	public function getoutput() {
		
		if( $this->type == "2d_graph" ) {
			
			$obj = new Graph();
			$obj->countvals = $this->countvals();
			$obj->field_1 = $this->field_1;
			$obj->field_2 = $this->field_2;
			$obj->field_3 = $this->field_3;
			$obj->field_4 = $this->field_4;
			$obj->titulo = $this->titulo;
			$obj->data = $this->data;
			$obj->model = $this->model;
			$obj->slot_number = $this->slot_number;
			$obj->width = $this->width;
			$obj->height = $this->height;
			$obj->link = $this->link;
			
			$final = "<div id='chartdiv$this->slot_number' style='top:5%;height:".($obj->height*0.7)."px;width:".($obj->width*0.9)."px;margin-left:auto;margin-right:auto;'></div>";
			return $final.$obj->get();
		}
		
		if( $this->type == "table" ) {
			$obj = new Table();
			$obj->countvals = $this->countvals();
			$obj->field_1 = $this->field_1;
			$obj->field_2 = $this->field_2;
			$obj->field_3 = $this->field_3;
			$obj->field_4 = $this->field_4;
			$obj->data = $this->data;
			$obj->model = $this->model;
			$obj->slot_number = $this->slot_number;
			$obj->format_1 = $this->format_1;
			$obj->format_2 = $this->format_2;
			$obj->format_3 = $this->format_3;
			$obj->format_4 = $this->format_4;
			
			$final = "<div id='chartdiv$this->slot_number' style='height:100%;width:100%;overflow-y:scroll;'>";
			return $final.$obj->get() . "</div>";
		}
		
		if( $this->type == "label" ) {
			$obj = new Label();
			$obj->countvals = $this->countvals();
			$obj->field_1 = $this->field_1;
			$obj->field_2 = $this->field_2;
			$obj->field_3 = $this->field_3;
			$obj->field_4 = $this->field_4;
			$obj->label_1 = $this->label_1;
			$obj->label_2 = $this->label_2;
			$obj->label_3 = $this->label_3;
			$obj->label_4 = $this->label_4;
			$obj->format_1 = $this->format_1;
			$obj->format_2 = $this->format_2;
			$obj->format_3 = $this->format_3;
			$obj->format_4 = $this->format_4;
			$obj->data = $this->data;
			$obj->model = $this->model;
			$obj->slot_number = $this->slot_number;
			
			$final = "<div id='chartdiv$this->slot_number' style='height:100%;width:100%;'>";
			return $final.$obj->get()."</div>";
		}
		
		if( $this->type == "button" ) {
			$obj = new Button();
			$obj->countvals = $this->countvals();
			$obj->field_1 = $this->field_1;
			$obj->field_2 = $this->field_2;
			$obj->field_3 = $this->field_3;
			$obj->field_4 = $this->field_4;
			$obj->label_1 = $this->label_1;
			$obj->label_2 = $this->label_2;
			$obj->label_3 = $this->label_3;
			$obj->label_4 = $this->label_4;
			$obj->format_1 = $this->format_1;
			$obj->format_2 = $this->format_2;
			$obj->format_3 = $this->format_3;
			$obj->format_4 = $this->format_4;
			$obj->data = $this->data;
			$obj->model = $this->model;
			$obj->link = $this->link;
			$obj->slot_number = $this->slot_number;
			$obj->height = $this->height;
			
			$final = "<div id='chartdiv$this->slot_number' style='height:100%;width:100%;'>";
			return $final.$obj->get()."</div>";
		}
	}
}

?>