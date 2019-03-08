<?php
	include './classes/userauth.class.php';
?>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>DataOnline</title>
	<script src="js/jquery-1.11.0.min.js"></script>
	<script src="js/freewall.js"></script>	
	<!-- jqplot -->
	<!--[if lt IE 9]><script language="javascript" type="text/javascript" src="excanvas.js"></script><![endif]-->
	<script language="javascript" type="text/javascript" src="js/jqplot/jquery.jqplot.min.js"></script>
	<link rel="stylesheet" type="text/css" href="js/jqplot/jquery.jqplot.css" />
	<script type="text/javascript" src="js/jqplot/plugins/jqplot.pieRenderer.min.js"></script>
	<script type="text/javascript" src="js/jqplot/plugins/jqplot.donutRenderer.min.js"></script>
	<script type="text/javascript" src="js/jqplot/plugins/jqplot.barRenderer.min.js"></script>
	<script type="text/javascript" src="js/jqplot/plugins/jqplot.categoryAxisRenderer.min.js"></script>
	<script type="text/javascript" src="js/jqplot/plugins/jqplot.pointLabels.min.js"></script>
	<!-- end jqplot -->
	<!-- table -->
	<script type="text/javascript" src="js/jquery.tablesorter.js"></script> 
	<script language="javascript" type="text/javascript" src="js/jquery.tablesorter.pager.js"></script>
	<link rel="stylesheet" type="text/css" href="css/table.css" />
	<!-- end table -->
	<style type="text/css">
		body {
			background: rgb(20, 19, 20);
			color: #555;
			font-family: "Century Gothic", CenturyGothic, Geneva, AppleGothic, sans-serif;
		}
		#container {
			width: 99%;
			margin: auto;
		}
		.item {
			background: #D0D0D0;
		}
		.maskedsec {
			padding-top:10%;
			font-size:15px;
			font-family: "Century Gothic", CenturyGothic, Geneva, AppleGothic, sans-serif;
			text-align: center;
			text-transform: uppercase;
			font-variant: small-caps;
		}
		.masked {
			padding-top:10%;
			background: url(img/paint.png) repeat, white;
			-webkit-text-fill-color: transparent;
			-webkit-background-clip: text;
			-webkit-animation-name: masked-animation;
			-webkit-animation-duration: 40s;
			-webkit-animation-iteration-count: infinite;
			-webkit-animation-timing-function: linear;
			
			font-size:25px;
			font-family: "Century Gothic", CenturyGothic, Geneva, AppleGothic, sans-serif;
			text-align: center;
			text-transform: uppercase;
			font-variant: small-caps;
		}
		@-webkit-keyframes masked-animation {
			0% {background-position: left bottom;}
			100% {background-position: right bottom;}
		}
		.clearfix:after {
			content: ".";
			display: block;
			clear: both;
			visibility: hidden;
			line-height: 0;
			height: 0;
		}
		 
		.clearfix {
			display: inline-block;
		}
		 
		html[xmlns] .clearfix {
			display: block;
		}
		 
		* html .clearfix {
			height: 1%;
		}
	</style>
	<script language="Javascript" type="text/javascript" src="js/editarea_0_8_2/edit_area/edit_area_full.js"></script>
	<script language="Javascript" type="text/javascript" src="js/pushbuttoneffect.js"></script>
</head>