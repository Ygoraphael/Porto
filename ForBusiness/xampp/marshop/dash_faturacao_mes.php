<?php	
	$sql = "
		SELECT 
			CONVERT(VARCHAR(2), fdata, 101) + CONVERT(VARCHAR(2), fdata, 105) data, 
			SUM(ettiliq + ettiva) valor
		FROM ft (nolock)
		WHERE 
			fdata between dateadd(day, -100, getdate()) and getdate() and
			(tipodoc=1 or tipodoc=3) and 
			anulado = 0
		GROUP BY
			fdata
		ORDER BY
			fdata
		";
	
	$data = mssql__select($sql);
	$data_str = "";
	$dia = 0;

	foreach($data as $row) {
		$data_str .= "[" . $dia . "," . $row["valor"] . "],";
		$dia++;
	}
	$data_str = substr($data_str, 0, strlen($data_str) - 1);
?>

<div class="row-fluid">
	<div class="span12 widget blue" onTablet="span6" onDesktop="span12">
		<h2><span class="halflings-icon time white"><i></i></span> Faturação Últimos 31 Dias</h2>
		<hr>
		<div id="stats-chart2" style="height:282px" ></div>
	</div>
	<?php //include("stats.php"); ?>
</div>

<script>
jQuery(document).ready(function($){
	<?php
		echo "var ft_vendas = [" . $data_str . "];";
	?>

	var plot = $.plot($("#stats-chart2"),
		   [ { data: ft_vendas, 
			   label: "Vendas", 
			   lines: { show: true, 
						fill: false,
						lineWidth: 2 
					  },
			   shadowSize: 0	
			  }
			], {
			   
			   grid: { hoverable: true, 
					   clickable: true, 
					   tickColor: "rgba(255,255,255,0.05)",
					   borderWidth: 0
					 },
			 legend: {
						show: false
					},	
			   colors: ["rgba(255,255,255,0.8)", "rgba(255,255,255,0.6)", "rgba(255,255,255,0.4)", "rgba(255,255,255,0.2)"],
			xaxis: {ticks:15, tickDecimals: 0, color: "rgba(255,255,255,0.8)" },
				yaxis: {ticks:5, tickDecimals: 0, color: "rgba(255,255,255,0.8)" },
			});

	function showTooltip(x, y, contents) {
		$('<div id="tooltip">' + contents + '</div>').css( {
			position: 'absolute',
			display: 'none',
			top: y + 5,
			left: x + 5,
			border: '1px solid #fdd',
			padding: '2px',
			'background-color': '#dfeffc',
			opacity: 0.80
		}).appendTo("body").fadeIn(200);
	}

	var previousPoint = null;
	$("#stats-chart2").bind("plothover", function (event, pos, item) {
		$("#x").text(pos.x.toFixed(2));
		$("#y").text(pos.y.toFixed(2));

			if (item) {
				if (previousPoint != item.dataIndex) {
					previousPoint = item.dataIndex;

					$("#tooltip").remove();
					var x = item.datapoint[0].toFixed(2),
						y = item.datapoint[1].toFixed(2);

					showTooltip(item.pageX, item.pageY,
								item.series.label + " of " + x + " = " + y);
				}
			}
			else {
				$("#tooltip").remove();
				previousPoint = null;
			}
	});
});
</script>

