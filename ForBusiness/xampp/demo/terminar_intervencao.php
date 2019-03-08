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
						$current_page = "Terminar Intervenção";
						include("breadcrumbs.php");
						if(isset($_GET["id"])) {
							$dados = get_dados_tarefa($_GET["id"]);
						}
						else {
							return;
						}
					?>
						
					<div class="row-fluid">
						<div class="span12">
							<button type="submit" class="btn btn-primary" onclick="window.location.replace('index.php'); return false;" ><i class="white halflings-icon circle-arrow-left"></i> Voltar</button>
							<form id="ter_inter" role="form" data-toggle="validator" class="form-horizontal">
								<br><br>
								<div class="control-group">
									<label class="control-label">Relatório</label>
									<div class="controls">
										<textarea class="form-control span8" id="relatorio" style="height:30vh; background:white;" required></textarea>
									</div>
								</div>
								<div class="control-group projtype">
									<div class="controls">
										<?php
											$contrato_cliente = get_contrato($dados[0]["cliente"], '');
											if(sizeof($contrato_cliente)>0){
												$blue_ass = "";
												$blue_cnt = "blue";
												
												$white_ass = "";
												$white_cnt = "style='color:white;'";
											}
											else {
												$blue_ass = "blue";
												$blue_cnt = "";
												
												$white_ass = "style='color:white;'";
												$white_cnt = "";
											}
										?>
										<a <?php echo $white_ass; ?> class="quick-button span2 <?php echo $blue_ass; ?>">
											<p>Assistência Espontânea</p>
										</a>
										<a class="quick-button span2">
											<p>Projeto</p>
										</a>
										<?php
											if( sizeof($contrato_cliente)>0 ) {
										?>
										<a <?php echo $white_cnt; ?> class="quick-button span2 <?php echo $blue_cnt; ?>">
											<p>Contrato</p>
										</a>
										<?php
											}
										?>
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
										<a onclick="$('#ter_inter').submit();" class="quick-button blue span8">
											<p style="color:white; font-size:1vw;">FINALIZAR</p>
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
		function ifnull(val) {
			if (val==null)
				return "";
			else
				return val;
		}
		
		$('#ter_inter').validator().on('submit', function (e) {
			if (e.isDefaultPrevented()) {
				return false;
			} else {
				ActivateLoading();
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
					
					jQuery.ajax({
						type: "POST",
						url: "funcoes_gerais.php",
						data: { "action" : "termina_intervencao('<?php echo $_GET["id"]; ?>', '" + jQuery("#relatorio").val() + "', '" + tipo_intervencao + "', '" + jQuery("#projeto").val() + "');"},
						success: function(data) 
						{
							window.location.replace("index.php");
						}
					});
				return false;
			}
		})
		
		jQuery(".projtype .quick-button").click(function() {
			
			jQuery(".projtype .quick-button").removeClass("blue");
			jQuery(".projtype .quick-button").css("color", "#646464");
			
			$(this).addClass("blue");
			$(this).css("color", "white");
			
			if( $(this).children().eq(0).html() == "Projeto" ) {
				ActivateLoading();
				
				$("#projeto_hover").removeClass("hidden");
				
				jQuery.ajax({
					type: "POST",
					url: "funcoes_gerais.php",
					data: { "action" : "tabela_projetos('<?php echo $dados[0]["cliente"] ?>', 'fref');"},
					success: function(data) 
					{
						var obj = JSON.parse(data);
					
						$('#projeto').find('option').remove();
								
						$.each(obj, function(index, value) {
							selec_val = "";
							if(value["fref"].trim() == '<?php echo $dados[0]["id_projecto"] ?>'.trim()) {
								selec_val = "selected";
							}
							
							$('#projeto')
								.append($("<option " + selec_val + "></option>")
								.attr("value",value["fref"])
								.text(value["fref"] + " | " + value["nmfref"])); 
						});
						
						$("#projeto_hover").prop("required", true);
						
						DeactivateLoading();
					}
				});
			}
			else {
				$('#projeto').find('option').remove();
				$("#projeto_hover").addClass("hidden");
			}
		})
	</script>
	<?php include("footer.php"); ?>
	
	<!-- start: JavaScript-->
	<?php include("footer_code.php"); ?>
	<!-- end: JavaScript-->
</body>
</html>
