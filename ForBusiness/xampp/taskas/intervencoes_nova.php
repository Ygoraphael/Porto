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
						$current_page = "Nova Intervenção";
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
									<label class="control-label" for="projeto">Projeto</label>
									<div class="controls">
										<select id="projeto" class="span8">
										</select>
									</div>
								</div>
								<div class="control-group">
									<div class="controls">
										<a onclick="$('#new_inter').submit();" class="quick-button blue span6">
											<p style="color:white; font-size:2vh;">INICIAR</p>
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
				ActivateLoading();
					jQuery.ajax({
						type: "POST",
						url: "funcoes_gerais.php",
						data: { "action" : "cria_intervencao('" + jQuery("#cliente").val() + "', '" + jQuery("#tarefa").val() + "', '" + jQuery("#projeto").val() + "', '<?php echo $_SESSION['user']['username'] ?>', '" + jQuery("#quem_pediu").val() + "');"},
						success: function(data) 
						{
							window.location.replace("index.php");
						}
					});
				return false;
			}
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
			ActivateLoading();
			jQuery.ajax({
				type: "POST",
				url: "funcoes_gerais.php",
				data: { "action" : "tabela_projetos('" + jQuery("#cliente").val() + "', 'fref');"},
				success: function(data) 
				{
					var obj = JSON.parse(data);
				
					$('#projeto').find('option').remove();
					$('#projeto').append($("<option></option>")); 
							
					$.each(obj, function(index, value) {
						$('#projeto')
							.append($("<option></option>")
							.attr("value",value["fref"])
							.text(value["fref"] + " | " + value["nmfref"])); 
					});
					
					DeactivateLoading();
				}
			});
		}
	</script>
	<?php include("footer.php"); ?>
	
	<!-- start: JavaScript-->
	<?php include("footer_code.php"); ?>
	<!-- end: JavaScript-->
</body>
</html>
