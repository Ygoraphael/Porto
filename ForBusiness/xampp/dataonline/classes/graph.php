<?php

class Graph {
	
	public $data;
	public $countvals;
	public $titulo;
	
	public $model;
	
	public $field_1;
	public $field_2;
	public $field_3;
	public $field_4;
	
	public $label_1;
	public $label_2;
	public $label_3;
	public $label_4;
	
	public $slot_number;
	
	public $return_str;
	
	public function __construct() {
	}
	
	public function get() {
	
		$str = "";
		$str2 = "";
		$str3 = "";
		$str4 = "";
		
		if( $this->model == "Axis") {
			if( $this->countvals == 4 ) {
				foreach ($this->data as $tmp => $row) {
					$str .= "[".$row[$this->label_1]."," . $row[$this->label_2]."], ";
					$str2 .= "[".$row[$this->label_3]."," . $row[$this->label_4]."], ";
				}
				$this->return_str = "[$str],[$str2]";
				
				return "<script>
							$.jqplot('chartdiv$this->slot_number',  [$this->return_str], { 
								title:'$this->titulo', 
								gridPadding: { top: 30, right: 10, bottom: 20, left: 20 }, 
								series:[{color:'#5FAB78'}]
							});
						</script>";
			}
			if( $this->countvals == 2 || $this->countvals == 3 ) {
				foreach ($this->data as $tmp => $row) {
					$str .= "['".$row[$this->label_1]."'," . $row[$this->label_2]."], ";
				}
				$this->return_str = "[$str],";
				
				return "<script>
							$.jqplot('chartdiv$this->slot_number',  [$this->return_str], { 
								title:'$this->titulo', 
								gridPadding: { top: 30, right: 10, bottom: 20, left: 20 }, 
								series:[{color:'#5FAB78'}]
							});
						</script>";
			}
			if( $this->countvals == 1 ) {
				foreach ($this->data as $tmp => $row) {
					$str .= "[".$row[$this->label_1].",0], ";
				}
				$this->return_str = "[$str],";
				
				return "<script>
							$.jqplot('chartdiv$this->slot_number',  [$this->return_str], { 
								title:'$this->titulo', 
								gridPadding: { top: 30, right: 10, bottom: 20, left: 20 }, 
								series:[{color:'#5FAB78'}]
							});
						</script>";
			}
			if( $this->countvals == 0 ) {
				$this->return_str = "[0]";
				
				return "<script>
							$.jqplot('chartdiv$this->slot_number',  [$this->return_str], { 
								title:'$this->titulo', 
								gridPadding: { top: 30, right: 10, bottom: 20, left: 20 }, 
								series:[{color:'#5FAB78'}]
							});
						</script>";
			}
			else {
				return "";
			}
		}
		if( $this->model == "Pie") {
		
			if( $this->countvals == 2 || $this->countvals == 3 || $this->countvals == 4 ) {
				foreach ($this->data as $tmp => $row) {
					$str .= "['".$row[$this->label_1]."'," . $row[$this->label_2]."], ";
				}
				$str = substr($str, 0, -2);
				$this->return_str = "[$str]";
				
				return "<script>
							$.jqplot('chartdiv$this->slot_number',  [$this->return_str], { 
								title:'$this->titulo', 
								seriesDefaults: {
									renderer: jQuery.jqplot.PieRenderer, 
									rendererOptions: {
										showDataLabels: true
									}
								},
								legend: { show:true, location: 'e' }
							});
						</script>";
			}
			if( $this->countvals == 0 || $this->countvals == 1) {
				$this->return_str = "[['', 0]]";
				
				return "<script>
							$.jqplot('chartdiv$this->slot_number',  [$this->return_str], { 
								title:'$this->titulo', 
								seriesDefaults: {
									renderer: jQuery.jqplot.PieRenderer, 
									rendererOptions: {
										showDataLabels: true
									}
								},
								legend: { show:true, location: 'e' }
							});
						</script>";
			}
			else {
				return "";
			}
		}
		if( $this->model == "Bar") {
		
			if( $this->countvals == 2 || $this->countvals == 3 || $this->countvals == 4 ) {
				
				foreach ($this->data as $tmp => $row) {
					$str  .= "['".trim($row["val01"])."'], ";
					$str2 .= $row["val02"].", ";
					$str3 .= $row["val03"].", ";
				}
				
				$str  = substr($str, 0, -2);
				$str2 = substr($str2, 0, -2);
				$str3 = substr($str3, 0, -2);
				
				$this->return_str = "[$str2], [$str3]";
				
				return "<script>
							var ticks = [$str];
							$.jqplot('chartdiv$this->slot_number',  [$this->return_str], { 
								title:'$this->titulo', 
								seriesDefaults:{
									renderer:$.jqplot.BarRenderer,
									rendererOptions: {fillToZero: true}
								},
								series:[
									{label:'".$this->label_2."'},
									{label:'".$this->label_3."'}
								],
								legend: {
									show: true,
									placement: 'outsideGrid'
								},
								axes: {
									xaxis: {
										renderer: $.jqplot.CategoryAxisRenderer,
										ticks: ticks
									},
									yaxis: {
										pad: 1.05,
										tickOptions: {formatString: '%d'}
									}
								}
							});
						</script>";
			}
			if( $this->countvals == 0 || $this->countvals == 1) {
				$this->return_str = "[['', 0]]";
				
				return "<script>
							$.jqplot('chartdiv$this->slot_number',  [$this->return_str], { 
								title:'$this->titulo', 
								seriesDefaults:{
									renderer:$.jqplot.BarRenderer,
									rendererOptions: {fillToZero: true}
								},
								series:[
									{label:''}
								],
								legend: {
									show: true,
									placement: 'outsideGrid'
								},
								axes: {
									xaxis: {
										renderer: $.jqplot.CategoryAxisRenderer,
										ticks: ticks
									},
									yaxis: {
										pad: 1.05,
										tickOptions: {formatString: '%d'}
									}
								}
							});
						</script>";
			}
			else {
				return "";
			}
		}
	}
}

?>