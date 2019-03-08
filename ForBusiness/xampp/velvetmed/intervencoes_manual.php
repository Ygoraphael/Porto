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
						$current_page = "Intervenção Manual";
						include("breadcrumbs.php");
						$tarefas = get_tarefas_suporte();
						$clientes = get_clientes();						
					?>
						
					<div class="row-fluid">
						<div class="span12">
							<button type="submit" class="btn btn-primary" onclick="window.history.go(-1); return false;" ><i class="white halflings-icon circle-arrow-left"></i> Voltar</button>
							<form id="new_inter" role="form" data-toggle="validator" class="form-horizontal">
								<br><br>
								<div class="control-group">
									<div class="controls">
										<input type="text" placeholder="Filtrar cliente" class="span8" id="filtro_cliente">
										<button class="btn" type="button" onclick="filtra_cl()"><i class="halflings-icon white zoom-in"></i></button>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="cliente">Cliente</label>
									<div class="controls">
										<select onchange="filtra_projetos()" id="cliente" class="span8 form-control" required>
											<option></option>
											<?php
												foreach($clientes as $cliente) {
													echo "<option value='" . $cliente["no"] . "'>" . $cliente["nome"] ."</option>";
												}
											?>
										</select>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="tarefa">Tarefa</label>
									<div class="controls">
										<select id="tarefa" class="span8 form-control" required>
											<?php
												foreach($tarefas as $tarefa) {
													$default = "";
													if(trim($tarefa["campo"]) == "Assistência PHC") {
														$default = "selected";
													}
													
													echo "<option $default value='" . $tarefa["dytablestamp"] . "'>" . $tarefa["campo"] ."</option>";
												}
											?>
										</select>

									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="quem_pediu">Quem Pediu</label>
									<div class="controls">
										<input type="text" class="span8" id="quem_pediu">
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="quem_pediu">Inicio</label>
									<div class="controls">
										<input type="date" class="span2 auto_trigger" id="data_inicio">
										<input type="text" class="span1 auto_trigger" placeholder="<?php echo date('H'); ?>" id="hora_inicio">
										<input type="text" class="span1 auto_trigger" placeholder="<?php echo date('i'); ?>" id="minuto_inicio">
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="quem_pediu">Fim</label>
									<div class="controls">
										<input type="date" class="span2 auto_trigger" id="data_fim">
										<input type="text" class="span1 auto_trigger" placeholder="<?php echo date('H'); ?>" id="hora_fim">
										<input type="text" class="span1 auto_trigger" placeholder="<?php echo date('i'); ?>" id="minuto_fim">
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="quem_pediu">Tempo</label>
									<div class="controls">
										<input type="checkbox" id="tempo_tipo" data-on="Automático" data-off="Manual" checked data-toggle="toggle">
									</div>
								</div>
								<div class="control-group checkauto">
									<label class="control-label" for="quem_pediu">Automático</label>
									<div class="controls">
										<input type="text" tabindex="-1" class="span1" placeholder="Horas" readonly id="hora_tempo1">
										<input type="text" tabindex="-1" class="span1" placeholder="Minutos" readonly id="minuto_tempo1">
									</div>
								</div>
								<div class="control-group checkmanual hidden">
									<label class="control-label" for="quem_pediu">Manual</label>
									<div class="controls">
										<input type="text" class="span1" placeholder="Horas" id="hora_tempo2">
										<input type="text" class="span1" placeholder="Minutos" id="minuto_tempo2">
									</div>
								</div>
								<div class="control-group">
									<label class="control-label">Relatório</label>
									<div class="controls">
										<textarea class="form-control span8" id="relatorio" style="height:30vh; background:white;" required></textarea>
									</div>
								</div>
								<div class="control-group projtype">
									<div class="controls">
										<a style="color:white;" class="quick-button span2 botass blue">
											<p>Assistência Espontânea</p>
										</a>
										<a class="quick-button span2 botproj">
											<p>Projeto</p>
										</a>
										<a class="quick-button span2 botcon">
											<p>Contrato</p>
										</a>
										<a class="quick-button span2">
											<p>Não Faturar</p>
										</a>
									</div>
								</div>
								<div class="control-group hidden" id="projeto_hover">
									<label class="control-label" for="projeto">Projeto</label>
									<div class="controls">
										<select id="projeto" class="form-control span8" required>
										</select>
									</div>
								</div>
								<div class="control-group">
									<div class="controls">
										<a onclick="$('#new_inter').submit();" class="quick-button blue span8">
											<p style="color:white; font-size:2vh;">INSERIR</p>
										</a>
									</div>
								</div>
							</form>
						</div>	
					</div>
				</div>
			</div><!--/.fluid-container-->
				<!-- end: Content -->
		</div><!--/#content.span10-->	
	<div class="clearfix"></div>
	
	<script>
		$('#new_inter').validator().on('submit', function (e) {
			if (e.isDefaultPrevented()) {
				return false;
			} else {
				// ActivateLoading();
					
					tipo_intervencao="";
					$( ".projtype .quick-button" ).each(function() {
						if( $(this).hasClass("blue") ) {
							if( $(this).children().eq(0).html() == "Assistência Espontânea" ) {
								tipo_intervencao="ass";
							}
							else if( $(this).children().eq(0).html() == "Projeto" ) {
								tipo_intervencao="pro";
							}
							else if( $(this).children().eq(0).html() == "Contrato" ) {
								tipo_intervencao="con";
							}
							else if( $(this).children().eq(0).html() == "Não Faturar" ) {
								tipo_intervencao="nft";
							}
						}
					});
					
					var strajx = "cria_intervencao_manual('";
					strajx += 	jQuery("#cliente").val() + "', '";
					strajx += 	jQuery("#tarefa").val() + "', '";
					strajx += 	jQuery("#projeto").val() + "', '";
					strajx += 	"<?php echo $_SESSION['user']['username'] ?>', '";
					strajx += 	jQuery("#quem_pediu").val() + "', '";
					strajx += 	jQuery("#data_inicio").val() + "', '";
					strajx += 	jQuery("#hora_inicio").val() + "', '";
					strajx += 	jQuery("#minuto_inicio").val() + "', '";
					strajx += 	jQuery("#data_fim").val() + "', '";
					strajx += 	jQuery("#hora_fim").val() + "', '";
					strajx += 	jQuery("#minuto_fim").val() + "', '";
					strajx += 	jQuery("#hora_tempo2").val() + "', '";
					strajx += 	jQuery("#minuto_tempo2").val() + "', '";
					strajx += 	jQuery("#tempo_tipo").prop('checked') + "', '";
					strajx += 	jQuery("#relatorio").val() + "', '";
					strajx += 	tipo_intervencao + "', '";
					strajx += 	"');";
					
					jQuery.ajax({
						type: "POST",
						url: "funcoes_gerais.php",
						data: { "action" : strajx},
						success: function(data) 
						{
							window.location.replace("index.php");
						}
					});
				return false;
			}
		})
		
		$(function() {
			$('#tempo_tipo').change(function() {
				//true - automatico
				//false - manual
				if( $(this).prop('checked') ) {
					jQuery(".checkauto").removeClass("hidden");
					jQuery(".checkmanual").addClass("hidden");
				}
				else {
					jQuery(".checkauto").addClass("hidden");
					jQuery(".checkmanual").removeClass("hidden");
				}
			})
		})	
		
		$('#filtro_cliente').keyup(function(e){
			if(e.keyCode == 13)
			{
				filtra_cl();
			}
		});
		
		function filtra_cl() {
			ActivateLoading();
			jQuery.ajax({
				type: "POST",
				url: "funcoes_gerais.php",
				data: { "action" : "tabela_clientes('', '" + jQuery("#filtro_cliente").val() + "', 'nome');"},
				success: function(data) 
				{
					var obj = JSON.parse(data);
					
					$('#cliente').find('option').remove();
					$('#projeto').find('option').remove();
					$('#cliente').append($("<option></option>")); 
							
					$.each(obj, function(index, value) {
						$('#cliente')
							.append($("<option></option>")
							.attr("value",value["no"])
							.text(value["nome"])); 
					});
					
					DeactivateLoading();
				}
			});
		}
	
		function filtra_projetos() {
			if( jQuery(".botproj").hasClass("blue") ) {
				ActivateLoading();
					
				$("#projeto_hover").removeClass("hidden");
				
				jQuery.ajax({
					type: "POST",
					url: "funcoes_gerais.php",
					data: { "action" : "tabela_projetos('" + jQuery("#cliente").val() + "', 'fref');"},
					success: function(data) 
					{
						var obj = JSON.parse(data);
					
						$('#projeto').find('option').remove();
								
						$.each(obj, function(index, value) {
							$('#projeto')
								.append($("<option></option>")
								.attr("value",value["fref"])
								.text(value["fref"] + " | " + value["nmfref"])); 
						});
						
						$("#projeto_hover").prop("required", true);
						
						DeactivateLoading();
					}
				});
			}
			
			verifica_contrato();
		}
	
		function verifica_contrato() {
			ActivateLoading();
			jQuery.ajax({
				type: "POST",
				url: "funcoes_gerais.php",
				data: { "action" : "get_contrato('" + jQuery("#cliente").val() + "');"},
				success: function(data) 
				{
					var obj = JSON.parse(data);
						
					if( obj.length > 0 ) {
						jQuery(".botcon").removeClass("hidden");
					}
					else {
						if( jQuery(".botcon").hasClass("blue") ) {
							jQuery(".botcon").removeClass("blue");
							jQuery(".botcon").css("color", "#646464");
							
							jQuery(".botass").addClass("blue");
							jQuery(".botass").css("color", "white");
						}
						jQuery(".botcon").addClass("hidden");
					}
					
					DeactivateLoading();
				},
				error: function(data) 
				{
					DeactivateLoading();
				}
			});
		}
	
		jQuery(".projtype .quick-button").click(function() {
			
			jQuery(".projtype .quick-button").removeClass("blue");
			jQuery(".projtype .quick-button").css("color", "#646464");
			
			$(this).addClass("blue");
			$(this).css("color", "white");
			
			if( $(this).children().eq(0).html() == "Projeto" ) {
				filtra_projetos();
			}
			else {
				$('#projeto').find('option').remove();
				$("#projeto_hover").addClass("hidden");
			}
		})
		
		function MyParseDate(str) {
			var parts = str.split(' '),
			
			dateParts = parts[0].split('-'),
			
			timeParts = parts[1].split(':'),
			
			timeHours = Number(timeParts[0]),
			
			_date = new Date;
			_date.setFullYear(Number(dateParts[0]));
			_date.setMonth(Number(dateParts[1])-1);
			_date.setDate(Number(dateParts[2]));
			_date.setHours(Number(timeHours));
			_date.setMinutes(Number(timeParts[1]));
			_date.setSeconds(Number(timeParts[2]));
			
			return _date;
		}
	
		function timeDifference(current, previous) {
			var sPerMinute = 60;
			var sPerHour = sPerMinute * 60;

			var elapsed = current - previous;
			var string_date = "";
			
			string_date += Math.floor(elapsed / sPerHour) + ' hora(s) e ';
			horas = Math.floor(elapsed / sPerHour);
			elapsed = elapsed % sPerHour;
			string_date += Math.floor(elapsed / sPerMinute) + ' minuto(s)';
			minutos = Math.floor(elapsed / sPerMinute);

			if (string_date.indexOf("-") != -1) {
				return "";
			}
			
			if (elapsed >= 86400) {
				return "";
			}
			
			if (current - previous == 0) {
				return "";
			}
			
			//return [string_date, current - previous];
			return [horas, minutos];
		}
		
		jQuery(".auto_trigger").change(function() {
								
			if (jQuery("#data_inicio").val().length > 0 && jQuery("#data_fim").val().length > 0 && jQuery("#hora_inicio").val().length > 0 && jQuery("#hora_fim").val().length > 0 && jQuery("#minuto_inicio").val().length > 0 && jQuery("#minuto_fim").val().length > 0) {
				
				var date_string_inicial = jQuery("#data_inicio").val() + " " + jQuery("#hora_inicio").val() + ":" + jQuery("#minuto_inicio").val() + ":00";
				var date_string_final = jQuery("#data_fim").val() + " " + jQuery("#hora_fim").val() + ":" + jQuery("#minuto_fim").val() + ":00";
				
				var d1 = MyParseDate(date_string_inicial);
				var d2 = MyParseDate(date_string_final);
				
				date_string_inicial = Date.parse( d1 ) / 1000;
				date_string_final = Date.parse( d2 ) / 1000;

				if (date_string_inicial >= 0 && date_string_final >= 0) 
				{
					if (date_string_inicial < date_string_final ) {
						jQuery("#hora_tempo1").val(timeDifference(date_string_final, date_string_inicial)[0] + " horas" );
						jQuery("#minuto_tempo1").val(timeDifference(date_string_final, date_string_inicial)[1] + " minutos");
						
					}
					else {
						jQuery("#hora_tempo1").val("");
						jQuery("#minuto_tempo1").val("");
					}
				}
				else {
					jQuery("#hora_tempo1").val("");
					jQuery("#minuto_tempo1").val("");
				}
			}
		});
	</script>
	
	<?php include("footer.php"); ?>
	
	<!-- start: JavaScript-->
	<?php include("footer_code.php"); ?>
	<!-- end: JavaScript-->
</body>
</html>
