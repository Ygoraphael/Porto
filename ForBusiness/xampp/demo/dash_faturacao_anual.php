<?php	
	$sql = "
		select 
			str(month(ft.fdata)) as Mes,	
			sum(case when year(ft.fdata)=" . (date("Y") - 1) . " then ft.eivain1+ft.eivain2+ft.eivain3+ft.eivain4+ft.eivain5+ft.eivain6 else 0 end) as 'Ano_1', 	
			sum(case when year(ft.fdata)=" . date("Y") . " then ft.eivain1+ft.eivain2+ft.eivain3+ft.eivain4+ft.eivain5+ft.eivain6 else 0 end) as 'Ano_2' 
		from ft (NOLOCK) 
			inner join ft2 on ft.ftstamp = ft2.ft2stamp 
		where 	
			(ft.tipodoc=1 or ft.tipodoc=3) and 
			ft.anulado = 0 
		group by 	
			str(month(ft.fdata))
		order by 	
			str(month(ft.fdata))";
	
	$data = mssql__select($sql);
	$data_str1 = "";
	$data_str2 = "";
	$mes = 1;
?>

<div class="box span5 blue" onTablet="span6" onDesktop="span5">
	<div class="box-header">
		<h2><i class="halflings-icon white list-alt"></i><span class="break"></span>Faturação Anual</h2>
	</div>
	<div class="box-content blue">
		 <div id="stackchart" class="center" style="height:260px;"></div>
	</div>
</div>

<script>
	jQuery(document).ready(function($){
		
		<?php
			foreach($data as $row) {
				$data_str1 .= "['" . $mes . "','" . number_format($row["Ano_1"], 2, '.', '') . "'],";
				$data_str2 .= "['" . $mes . "','" . number_format($row["Ano_2"], 2, '.', '') . "'],";
				$mes++;
			}
			$data_str1 = substr($data_str1, 0, strlen($data_str1) - 1);
			$data_str2 = substr($data_str2, 0, strlen($data_str2) - 1);
			
			echo "var d2 = [" . $data_str1 . "];\n";
			echo "var d1 = [" . $data_str2 . "];";
		?>
		
		var stack = null, bars = true, lines = false, steps = false;

		function plotWithOptions() {
			$.plot($("#stackchart"), [ d1, d2 ], {
				series: {
					stack: stack,
					lines: { show: lines, fill: false, steps: steps },
					bars: { show: bars, barWidth: 0.6 },
				},
				colors: ["#FA5833", "#2FABE9"]
			});
		}

		plotWithOptions();
	});
</script>