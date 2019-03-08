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
						if(isset($_GET["frefstamp"])) {
							$dados_projeto = get_projeto(trim($_GET["frefstamp"]));
							if(!sizeof($dados_projeto)) {
								return;
							}
						}
						else {
							return;
						}
						$dados_projeto = $dados_projeto[0];
						
						$custo_projeto = get_custo_total_funcionarios_projeto(trim($_GET["frefstamp"]));
						
						if( sizeof($custo_projeto)>0 ){
							$custo_total_funcionarios_projeto = round($custo_projeto[0]["custo_total"], 2);
							$custo_total_horas_funcionarios_projeto = round($custo_projeto[0]["custo_horas"], 2);
						}
						else {
							$custo_total_funcionarios_projeto = 0;
							$custo_total_horas_funcionarios_projeto = 0;
						}
						
						$current_page = "Projeto: " . $dados_projeto["fref"] . " - " . $dados_projeto["nmfref"] ;
						include("breadcrumbs.php"); 
					?>
						
					<div class="row-fluid">
						<div class="span6">
							<button type="submit" class="btn btn-primary" onclick="window.history.go(-1); return false;" ><i class="white halflings-icon circle-arrow-left"></i> Voltar</button>
							<br><br>
							<form class="form-horizontal">
								<div class="control-group">
									<label class="control-label" for="codigo_projeto">Código</label>
									<div class="controls">
										<input type="text" class="span8" readonly value='<?php echo $dados_projeto["fref"]; ?>' id="codigo_projeto">
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="nome_projeto">Descrição</label>
									<div class="controls">
										<input type="text" class="span8" readonly value='<?php echo $dados_projeto["nmfref"]; ?>' id="codigo_projeto">
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="tipo_projeto">Tipo</label>
									<div class="controls">
										<input type="text" class="span8" readonly value='<?php echo $dados_projeto["u_tipo"]; ?>' id="tipo_projeto">
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="estado_projeto">Estado</label>
									<div class="controls">
										<input type="text" class="span8" readonly value='<?php echo $dados_projeto["u_estado"]; ?>' id="estado_projeto">
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="responsavel_projeto">Responsável</label>
									<div class="controls">
										<input type="text" class="span8" readonly value='<?php echo $dados_projeto["u_resp"]; ?>' id="responsavel_projeto">
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="contacto_projeto">Contacto</label>
									<div class="controls">
										<input type="text" class="span8" readonly value='<?php echo $dados_projeto["u_contact"]; ?>' id="contacto_projeto">
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="email_projeto">Email</label>
									<div class="controls">
										<input type="text" class="span8" readonly value='<?php echo $dados_projeto["u_email"]; ?>' id="email_projeto">
										<button class="btn" type="button" onclick="EnviaEmail('<?php echo $dados_projeto["u_email"];?>')"><i class="halflings-icon white envelope"></i></button>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="datai_projeto">Data Prevista Início</label>
									<div class="controls">
										<input type="text" class="span8" readonly value='<?php echo substr($dados_projeto["u_datapini"], 0, 10); ?>' id="datai_projeto">
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="datai_projeto">Data Início</label>
									<div class="controls">
										<input type="text" class="span8" readonly value='<?php echo substr($dados_projeto["u_dataini"], 0, 10); ?>' id="datai_projeto">
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="dataf_projeto">Data Prevista Fecho</label>
									<div class="controls">
										<input type="text" class="span8" readonly value='<?php echo substr($dados_projeto["u_datafim"], 0, 10); ?>' id="dataf_projeto">
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="dataf_projeto">Data Fecho</label>
									<div class="controls">
										<input type="text" class="span8" readonly value='<?php echo substr($dados_projeto["u_datafr"], 0, 10); ?>' id="dataf_projeto">
									</div>
								</div>
							</form>
						</div>
						<div class="span6">
							<table id="TabProjetosCusto" class="table table-striped bootstrap-datatable">
								<thead>
									<tr>
										<th>Utilizador</th>
										<th>Horas Trabalhadas</th>
										<th>Valor Hora</th>
										<th>Total</th>
									</tr>
								</thead>   
								<tbody>
								</tbody>
							</table>
							<form class="form-horizontal">
								<div class="span6">
									<div class="control-group">
										<h3>VALOR</h3>
									</div>
									<div class="control-group">
										<label class="control-label" for="tvr_projeto">Total Real</label>
										<div class="controls">
											<input type="text" class="span12" readonly value='<?php echo $custo_total_funcionarios_projeto; ?>' id="tvr_projeto">
										</div>
									</div>
									<div class="control-group">
										<label class="control-label" for="tvo_projeto">Total Orçamentado</label>
										<div class="controls">
											<input type="text" class="span12" readonly value='<?php echo number_format($dados_projeto["u_valoro"], 2, '.', ''); ?>' id="tvo_projeto">
										</div>
									</div>
									<div class="control-group">
										<label class="control-label" for="dvalor_projeto">Rentabilidade</label>
										<div class="controls">
											<?php 
												if( $dados_projeto["u_valoro"]-$custo_total_funcionarios_projeto <= 0 ) {
													$cvalor = "red c_white";
												}
												else {
													$cvalor = "green c_white";
												}
											?>
											<input type="text" class="span12 <?php echo $cvalor ?>" readonly value='<?php echo number_format($dados_projeto["u_valoro"]-$custo_total_funcionarios_projeto, 2, '.', ''); ?>' id="dvalor_projeto">
										</div>
									</div>
								</div>
								<div class="span6">
									<div class="control-group">
										<h3>HORAS</h3>
									</div>
									<div class="control-group">
										<label class="control-label" for="thr_projeto">Total Real</label>
										<div class="controls">
											<input type="text" class="span12" readonly value='<?php echo $custo_total_horas_funcionarios_projeto; ?>' id="thr_projeto">
										</div>
									</div>
									<div class="control-group">
										<label class="control-label" for="tho_projeto">Total Orçamentado</label>
										<div class="controls">
											<input type="text" class="span12" readonly value='<?php echo number_format($dados_projeto["u_nhoraso"], 2, '.', ''); ?>' id="tho_projeto">
										</div>
									</div>
									<div class="control-group">
										<label class="control-label" for="dhoras_projeto">Desvio</label>
										<div class="controls">
											<?php 
												if( $dados_projeto["u_nhoraso"]-$custo_total_horas_funcionarios_projeto <= 0 ) {
													$choras = "red c_white";
												}
												else {
													$choras = "green c_white";
												}
											?>
											<input type="text" class="span12 <?php echo $choras ?>" readonly value='<?php echo number_format($dados_projeto["u_nhoraso"]-$custo_total_horas_funcionarios_projeto, 2, '.', ''); ?>' id="dhoras_projeto">
										</div>
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
		function EnviaEmail(email) {
			window.location = "mailto:" + email;
		}
		
		$(document).ready(function () {
			ActivateLoading();
			
			var table = $('#TabProjetosCusto').DataTable({
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
				"bFilter":     false
			});
			
			jQuery.ajax({
				type: "POST",
				url: "funcoes_gerais.php",
				data: { "action" : "tabela_custo_projeto_funcionarios('<?php echo trim($_GET["frefstamp"]); ?>');"},
				success: function(data) 
				{
					var obj = JSON.parse(data);

					$.each(obj, function(index, value) {
						var dados = new Array();
						dados.push(value["utilizador"]);
						dados.push(parseFloat(value["horas"]).toFixed(2));
						dados.push(parseFloat(value["valor_hora"]).toFixed(2));
						dados.push(parseFloat(value["custo_utilizador"]).toFixed(2));
						
						table.row.add(dados).draw();
					});
					
					jQuery("#TabProjetosCusto thead tr th").css( "width", "auto");
					DeactivateLoading();
				}
			});
		});
	</script>
	<?php include("footer.php"); ?>
	
	<!-- start: JavaScript-->
	<?php include("footer_code.php"); ?>
	<!-- end: JavaScript-->
</body>
</html>
