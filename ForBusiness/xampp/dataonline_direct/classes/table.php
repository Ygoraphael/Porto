<?php

class Table {
	
	public $data;
	public $countvals;
	public $table_id;
	public $model;
	public $field_1;
	public $field_2;
	public $field_3;
	public $field_4;
	
	public $slot_number;
	
	public $return_str;
	
	public function __construct() {
	}
	
	public function get() {
		
		if(sizeof($this->data) > 0) {
	
			$str = "";
			$str2 = "";
			$str3 = "";
			$str4 = "";
			
			$end_final = 
			"
				<script>
					jQuery(document).ready(function() { 
						jQuery('#$this->slot_number').tablesorter(); 
					});
				</script>
			";
			
			if( $this->countvals == 4) {
				$str .= "<table id='$this->slot_number' class='pure-table tablesorter pure-table-bordered'>";
				$str .= "<thead><tr><th>$this->field_1</th><th>$this->field_2</th><th>$this->field_3</th><th>$this->field_4</th></tr></thead>";
				foreach ($this->data as $tmp => $row) {
					$str .= "<tr>";

					if(trim($this->format_1) != "")
						$str .= "<td>" . sprintf(trim($this->format_1), $row[$this->field_1]) . "</td>";
					else
						$str .= "<td>" . $row[$this->field_1] . "</td>";
					if(trim($this->format_2) != "")
						$str .= "<td>" . sprintf(trim($this->format_2), $row[$this->field_2]) . "</td>";
					else
						$str .= "<td>" . $row[$this->field_2] . "</td>";
					if(trim($this->format_3) != "")
						$str .= "<td>" . sprintf(trim($this->format_3), $row[$this->field_3]) . "</td>";
					else
						$str .= "<td>" . $row[$this->field_3] . "</td>";
					if(trim($this->format_4) != "")
						$str .= "<td>" . sprintf(trim($this->format_4), $row[$this->field_4]) . "</td>";
					else
						$str .= "<td>" . $row[$this->field_4] . "</td>";

					$str .= "</tr>";
				}
				$str .= "</table>";
				$this->return_str = $str.$end_final;
				
				return $this->return_str;
			}
			
			if( $this->countvals == 3 ) {
			
				$str .= "<table id='$this->slot_number' class='pure-table tablesorter pure-table-bordered'>";
				$str .= "<thead><tr><th>$this->field_1</th><th>$this->field_2</th><th>$this->field_3</th></tr></thead>";
				foreach ($this->data as $tmp => $row) {
					$str .= "<tr>";
					if(trim($this->format_1) != "")
						$str .= "<td>" . sprintf(trim($this->format_1), $row[$this->field_1]) . "</td>";
					else
						$str .= "<td>" . $row[$this->field_1] . "</td>";
					if(trim($this->format_2) != "")
						$str .= "<td>" . sprintf(trim($this->format_2), $row[$this->field_2]) . "</td>";
					else
						$str .= "<td>" . $row[$this->field_2] . "</td>";
					if(trim($this->format_3) != "")
						$str .= "<td>" . sprintf(trim($this->format_3), $row[$this->field_3]) . "</td>";
					else
						$str .= "<td>" . $row[$this->field_3] . "</td>";
					$str .= "</tr>";
				}
				$str .= "</table>";
				$this->return_str = $str.$end_final;
				
				return $this->return_str;
			}
			
			if( $this->countvals == 2 ) {
			
				$str .= "<table id='$this->slot_number' class='pure-table tablesorter pure-table-bordered'>";
				$str .= "<thead><tr><th>$this->field_1</th><th>$this->field_2</th></tr></thead>";
				foreach ($this->data as $tmp => $row) {
					$str .= "<tr>";
					if(trim($this->format_1) != "")
						$str .= "<td>" . sprintf(trim($this->format_1), $row[$this->field_1]) . "</td>";
					else
						$str .= "<td>" . $row[$this->field_1] . "</td>";
					if(trim($this->format_2) != "")
						$str .= "<td>" . sprintf(trim($this->format_2), $row[$this->field_2]) . "</td>";
					else
						$str .= "<td>" . $row[$this->field_2] . "</td>";
					$str .= "</tr>";
				}
				$str .= "</table>";
				$this->return_str = $str.$end_final;
				
				return $this->return_str;
			}
			
			if( $this->countvals == 1 ) {
			
				$str .= "<table id='$this->slot_number' class='pure-table pure-table-bordered'>";
				$str .= "<thead><tr><th>$this->field_1</th></tr></thead>";
				foreach ($this->data as $tmp => $row) {
					$str .= "<tr>";
					if(trim($this->format_1) != "")
						$str .= "<td>" . sprintf(trim($this->format_1), $row[$this->field_1]) . "</td>";
					else
						$str .= "<td>" . $row[$this->field_1] . "</td>";
					$str .= "</tr>";
				}
				$str .= "</table>";
				$this->return_str = $str.$end_final;
				
				return $this->return_str;
			}
			
			if( $this->countvals == 0 ) {
			
				$str .= "<table id='$this->slot_number' class='pure-table tablesorter pure-table-bordered'>";
				$str .= "<tr>";
				$str .= "<td></td>";
				$str .= "</tr>";
				$str .= "</table>";
				$this->return_str = $str.$end_final;
				
				return $this->return_str;
			}
		}
		else {
			return "<div>Sem Valores Para Apresentar</div>";
		}
	}
}

?>