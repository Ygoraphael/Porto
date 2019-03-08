<?php	
	$sql = "
		SELECT 
			CONVERT(VARCHAR(2), A.data, 105) data, 
			SUM(A.moh) horas_trabalhadas
		FROM mh A (nolock) 
			INNER JOIN dytable B (nolock) ON A.mhtipo = B.campo 
		WHERE 
			B.ENTITYNAME = 'A_MHTIPO' and
			A.tecnico = " . $_SESSION['user']['tecnico'] . " and
			A.data >= GETDATE()-31
		GROUP BY
			A.data
		ORDER BY
			A.data";
	
	$data = mssql__select($sql);
	$data_str = "";
	$dia = 0;

	foreach($data as $row) {
		$data_str .= "[" . $dia . "," . $row["horas_trabalhadas"] . "],";
		$dia++;
	}
	$data_str = substr($data_str, 0, strlen($data_str) - 1);
?>

<div class="row-fluid">
	<div class="span8 widget blue" onTablet="span7" onDesktop="span8">
		<h2><span class="halflings-icon time white"><i></i></span> Horas Trabalhadas Últimos 31 Dias</h2>
		<hr>
		<div id="stats-chart2" style="height:282px" ></div>
	</div>
	<?php include("stats.php"); ?>
</div>

<script>
jQuery(document).ready(function($){
	<?php
		echo "var horas_trabalhadas = [" . $data_str . "];";
	?>

	var plot = $.plot($("#stats-chart2"),
		   [ { data: horas_trabalhadas, 
			   label: "Horas Trabalhadas", 
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

