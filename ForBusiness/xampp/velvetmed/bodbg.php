<!DOCTYPE html>
<html lang="pt">
<head>
	<?php include("header.php"); ?>
</head>
<body>
	<!-- start: Header -->
	<?php include("nav_bar.php"); ?>
	<!-- start: Header -->
	<div class="container-fluid-full">
		<div class="row-fluid">
			<!-- start: Main Menu -->
			<?php include("menu.php"); ?>
			<!-- end: Main Menu -->
			<noscript>
				<div class="alert alert-block span10">
					<h4 class="alert-heading">Warning!</h4>
					<p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
				</div>
			</noscript>
			<!-- start: Content -->
			<div id="content" class="span10">
				<?php 
					$current_page = "BackOffice Debug";
					include("breadcrumbs.php"); 
				?>
				<div class="row-fluid">
					<form class="form-horizontal">
						<textarea class="span12 logArea" style="height:42vh; background:white; font-size:12px;" readonly=""></textarea>
					</form>
				</div>
				<div class="row-fluid">
					<form class="form-horizontal">
						<div class="control-group">
							<button class="btn btn-large btn-primary span3 logOn" onclick="SwitchDebugger(1); return false;"><i class="white halflings-icon ok-circle"></i> Debug ON</button>
							<button disabled class="btn btn-large btn-primary span3 logOff" onclick="SwitchDebugger(0); return false;"><i class="white halflings-icon ban-circle"></i> Debug OFF</button>
							<button class="btn btn-large btn-primary span3 logClear" onclick="ClearDebugger(); return false;"><i class="white halflings-icon trash"></i> Limpar</button>
						</div>
					</form>
				</div>
			</div>
		</div><!--/.fluid-container-->
			<!-- end: Content -->
	</div><!--/#content.span10-->	
	<div class="clearfix"></div>
	<?php include("footer.php"); ?>
	<!-- start: JavaScript-->
	<script>
		var temporizador;
		var lastId = 0;
		
		function SwitchDebugger(type) {
			if(type) {
				jQuery(".logOn").attr('disabled', true);
				jQuery(".logOff").removeProp("disabled");
				temporizador = setInterval(function(){ ShowLog() }, 1000);
			}
			else {
				jQuery(".logOff").attr('disabled', true);
				jQuery(".logOn").removeProp("disabled");
				clearInterval(temporizador);
				lastId = 0;
			}
		}
		
		function ClearDebugger() {
			jQuery.ajax({
				type: "POST",
				url: "funcoes_gerais.php",
				data: { "action" : "ClearLog();"},
				success: function(data) 
				{
					jQuery(".logArea").html('');
				}
			});
		}
		
		function ShowLog() {
			jQuery.ajax({
				type: "POST",
				url: "funcoes_gerais.php",
				data: { "action" : "ReadLog("+lastId+");"},
				success: function(data) 
				{
					var obj = JSON.parse(data);

					$.each(obj, function(index, value) {
						var d = new Date(value["datetime"]*1000);
						
						jQuery(".logArea").html(jQuery(".logArea").html() + dateToLog(d) + "-----------------------------------------\n" + atob(value["msg"]) + '\n\n');
						if(value["id"]>lastId)
							lastId = value["id"];
					});
					
				}
			});
		}
	</script>
	<?php include("footer_code.php"); ?>
	<!-- end: JavaScript-->
</body>
</html>
