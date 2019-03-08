<!DOCTYPE html>
<html lang="pt">
<head>
	<?php include("header.php"); ?>
</head>

<body>
		<!-- start: Header -->
	<div class="navbar">
		<div class="navbar-inner">
			<div class="container-fluid">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".top-nav.nav-collapse,.sidebar-nav.nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
				<a class="brand" href="index.php"><span>TasKas</span></a>
								
				<!-- start: Header Menu -->
				<div class="nav-no-collapse header-nav">
					<ul class="nav pull-right">
						<li class="dropdown hidden-phone">
							<?php include("user_notifications.php"); ?>
						</li>
						<!-- start: Message Dropdown -->
						<li class="dropdown hidden-phone">
							<?php include("user_messages.php"); ?>
						</li>
						<!-- start: User Dropdown -->
						<?php include("user_panel.php"); ?>
						<!-- end: User Dropdown -->
					</ul>
				</div>
				<!-- end: Header Menu -->
			</div>
		</div>
	</div>
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
						if(isset($_GET["csupstamp"])) {
							$dados_contrato = get_contrato(0, trim($_GET["csupstamp"]));
							if(!sizeof($dados_contrato)) {
								return;
							}
						}
						else {
							return;
						}
						$dados_contrato = $dados_contrato[0];
						
						$current_page = "Contrato: " . $dados_contrato["descricao"] . " - " . $dados_contrato["nome"] ;
						include("breadcrumbs.php"); 
					?>
						
					<div class="row-fluid">
						<div class="span6">
							<button type="submit" class="btn btn-primary" onclick="window.history.go(-1); return false;" ><i class="white halflings-icon circle-arrow-left"></i> Voltar</button>
							<br><br>
							<form class="form-horizontal">
								<div class="control-group">
									<label class="control-label" for="codigo_contrato">Código</label>
									<div class="controls">
										<input type="text" class="span8" readonly value='<?php echo $dados_contrato["descricao"]; ?>' id="codigo_contrato">
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="nome_contrato">Cliente</label>
									<div class="controls">
										<input type="text" class="span8" readonly value='<?php echo $dados_contrato["nome"]; ?>' id="nome_contrato">
										<input type="text" class="span2" readonly value='<?php echo $dados_contrato["no"]; ?>' id="no_contrato">
										<a class="btn btn-success" href="cliente.php?id=<?php echo $dados_contrato["no"]; ?>"><i class="halflings-icon white zoom-in"></i></a>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="inicio_contrato">Data Inicio</label>
									<div class="controls">
										<input type="text" class="span8" readonly value='<?php echo $dados_contrato["data_inicial"]; ?>' id="inicio_contrato">
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="fim_contrato">Data Fim</label>
									<div class="controls">
										<input type="text" class="span8" readonly value='<?php echo $dados_contrato["data_final"]; ?>' id="fim_contrato">
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="hres_contrato">Horas Restantes</label>
									<div class="controls">
										<input type="text" class="span8" readonly value='<?php echo number_format($dados_contrato["u_horasres"], 2, '.', ''); ?>' id="hres_contrato">
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="hextras_contrato">Horas Extra</label>
									<div class="controls">
										<input type="text" class="span8" readonly value='<?php echo number_format($dados_contrato["u_hextra"], 2, '.', ''); ?>' id="hextras_contrato">
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="hcont_contrato">Horas Contratadas</label>
									<div class="controls">
										<input type="text" class="span8" readonly value='<?php echo number_format($dados_contrato["u_horasc"], 2, '.', ''); ?>' id="hcont_contrato">
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="valor_contrato">Valor Contrato</label>
									<div class="controls">
										<input type="text" class="span8" readonly value='<?php echo number_format($dados_contrato["evalor"], 2, '.', '') ; ?>' id="valor_contrato">
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="per_contrato">Período Contrato</label>
									<div class="controls">
										<?php
											switch(trim($dados_contrato["periodol"])) {
												case "1":
													$periodo = "Mensal";
													break;
												case "2":
													$periodo = "Trimestral";
													break;
												case "3":
													$periodo = "Semestral";
													break;
												case "4":
													$periodo = "Anual";
													break;
											}
										?>
										<input type="text" class="span8" readonly value='<?php echo $periodo; ?>' id="per_contrato">
									</div>
								</div>
							</form>
							<div class="span4">
								<h3>Faturação Contrato</h3>
							</div>
							<table id="TabDocumentos" class="table table-striped bootstrap-datatable">
								<thead>
									<tr>
										<th>Documento</th>
										<th>Data Documento</th>
										<th>Data Vencimento</th>
										<th>A Regularizar</th>
										<th>Regularizado</th>
										<th></th>
									</tr>
								</thead>   
								<tbody>
								</tbody>
							</table>
						</div>
						<div class="span6">
							<div class="content">
								<h2>Nº Intervenções Último Ano</h2>
								<br>
								<div id="intervencoesAnualContrato" style="height:300px"></div>
							</div>
							<div class="content">
								<h2>Tempo Intervenções Último Ano</h2>
								<br>
								<div id="intervencoesAnualContratoTempo" style="height:300px"></div>
							</div>
						</div>
					</div>
				</div>
			</div><!--/.fluid-container-->
				<!-- end: Content -->
		</div><!--/#content.span10-->	
	<div class="clearfix"></div>
	<script>
		$(document).ready(function () {
			ActivateLoading();
			
			var table = $('#TabDocumentos').DataTable({
				oLanguage: {
					sSearch: "Procurar:",
					oPaginate: {
						sFirst:		"Primeiro",
						sLast:		"Último",
						sNext:		"Seguinte",
						sPrevious:	"Anterior"
					},
					"sInfo": "A mostrar _START_ até _END_ registos de um total de _TOTAL_ registos",
					"sLengthMenu":     "Mostrar _MENU_ registos"
				},
				"bDestroy": true,
				"bPaginate":   false,
				"bInfo":     false,
				"bFilter":     false,
				"aaSorting": [[ 1, "desc" ]]
			});
			
			jQuery.ajax({
				type: "POST",
				url: "funcoes_gerais.php",
				data: { "action" : "tabela_faturacao_contrato('<?php echo trim($_GET["csupstamp"]); ?>');"},
				success: function(data) 
				{
					var obj = JSON.parse(data);

					$.each(obj, function(index, value) {
						var dados = new Array();
						dados.push(value["nmdoc"] + " - " + value["fno"]);
						dados.push(value["fdata"].substr(0, 10));
						dados.push(value["pdata"].substr(0, 10));
						dados.push(parseFloat(value["etotal"]).toFixed(2));
						
						if( parseFloat(value["erec"]) >= parseFloat(value["etotal"]) ) {
							dados.push(parseFloat(value["erec"]).toFixed(2));
						}
						else {
							dados.push("<span style='color:red;'>" + parseFloat(value["erec"]).toFixed(2) + "</span>");
						}

						dados.push('<a class="btn btn-success" href="clientedoc.php?docstamp=' + value["ftstamp"] + '"><i class="halflings-icon white zoom-in"></i></a>');
						
						table.fnAddData(dados);
					});
					
					jQuery("#TabDocumentos thead tr th").css( "width", "auto");
					DeactivateLoading();
				}
			});
		});
			
		<?php
			$intervencoes_ano_contrato = get_num_inter_ano_contrato($dados_contrato["no"]);
			
			$dados = "";
			$ticks = "";
			$i = 1;
			
			foreach($intervencoes_ano_contrato as $intervencoesAnoMes) {
				$dados .= "[" . $i . ", " . $intervencoesAnoMes["num_inter"] . "], ";
				$ticks .= "[" . $i . ", '" . $intervencoesAnoMes["data"] . "'], ";
				$i++;
			}
			$dados = "var inters = [" . substr($dados, 0, strlen($dados)-2) . "];";
			$ticks = "[0, " . substr($ticks, 0, strlen($ticks)-2) . "]";
			
			echo $dados;
		?>
		
		var plot = $.plot($("#intervencoesAnualContrato"),
		   [ { data: inters, label: "# Intervenções"} ], {
			   series: {
				   lines: { show: true,
							lineWidth: 2,
							fill: true, fillColor: { colors: [ { opacity: 0.5 }, { opacity: 0.2 } ] }
						 },
				   points: { show: true, 
							 lineWidth: 2 
						 }
			   },
			   grid: { hoverable: true, 
					   clickable: true, 
					   tickColor: "#f9f9f9",
					   borderWidth: 0
					 },
			   colors: ["#3B5998"],
				xaxis: {
					ticks:<?php echo $ticks; ?>
				},
				yaxis: {ticks:12, tickDecimals: 0},
			 });
		
		<?php
			$intervencoes_tempo_ano_contrato = get_tempo_inter_ano_contrato($dados_contrato["no"]);
			
			$dados = "";
			$ticks = "";
			$i = 1;
			
			foreach($intervencoes_tempo_ano_contrato as $intervencoesAnoMes) {
				$dados .= "[" . $i . ", " . $intervencoesAnoMes["moh"] . "], ";
				$ticks .= "[" . $i . ", ''], ";
				$i++;
			}
			$dados = "var intersTempo = [" . substr($dados, 0, strlen($dados)-2) . "];";
			$ticks = "[0, " . substr($ticks, 0, strlen($ticks)-2) . "]";
			
			echo $dados;
		?>
		
		var plot = $.plot($("#intervencoesAnualContratoTempo"),
		   [ { data: intersTempo, label: "Tempo Intervenções"} ], {
			   series: {
				   lines: { show: true,
							lineWidth: 2,
							fill: true, fillColor: { colors: [ { opacity: 0.5 }, { opacity: 0.2 } ] }
						 },
				   points: { show: true, 
							 lineWidth: 2 
						 }
			   },
			   grid: { hoverable: true, 
					   clickable: true, 
					   tickColor: "#f9f9f9",
					   borderWidth: 0
					 },
			   colors: ["#3B5998"],
				xaxis: {
					ticks:<?php echo $ticks; ?>
				},
				yaxis: {ticks:12, tickDecimals: 0},
			 });

		function EnviaEmail(email) {
			window.location = "mailto:" + email;
		}
	</script>
	<?php include("footer.php"); ?>
	
	<!-- start: JavaScript-->
	<?php include("footer_code.php"); ?>
	<!-- end: JavaScript-->
</body>
</html>
