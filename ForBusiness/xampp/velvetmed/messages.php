<!DOCTYPE html>
<html lang="pt">
<head>
	<?php include("header.php"); ?>
</head>

<?php
	if(isset($_POST["mens_assunto"])) {
		$mensagemDestino = $_POST["mens_destino"];
		$mensagemAssunto = $_POST["mens_assunto"];
		$mensagemCorpo = $_POST["mens_corpo"];
		$mensagemEnviada = set_mensagem($_SESSION['user']['tecnico'], $mensagemAssunto, $mensagemCorpo, $mensagemDestino);
		if( $mensagemEnviada ) {
			header("Location: messages.php?s=1");
			die();
		}
		else {
			header("Location: messages.php?s=0");
			die();
		}
	}
	else {
		$mensagemEnviada = 0;
		$mensagemDestino = "";
		$mensagemAssunto = "";
		$mensagemCorpo = "";
	}
?>

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
						$current_page = "Mensagens";
						include("breadcrumbs.php"); 
					?>
						
					<div class="row-fluid">
						<div class="span7">
							<?php
								if( isset($_GET['s']) ) {
									if($_GET['s'] == '0')
										echo "<h3>Mensagem não enviada.<br>Tente novamente mais tarde ou contacto o Administrador de Sistema</h3>";
									if($_GET['s'] == '1')
									echo "<h3>Mensagem enviada com sucesso</h3>";
								}
							?>
							<button type="submit" class="btn btn-primary btn-setting" onclick="return false;" ><i class="white halflings-icon envelope"></i> Nova mensagem</button>
							<button type="submit" class="btn btn-primary" onclick="return false;" ><i class="white halflings-icon envelope"></i> Correio Recebido</button>
							<button type="submit" class="btn btn-primary" onclick="return false;" ><i class="white halflings-icon envelope"></i> Correio Enviado</button>
							<h1>Correio Enviado</h1>
							<button type="submit" class="btn btn-primary" onclick="window.location.replace('messages.php'); return false;" ><i class="white halflings-icon envelope"></i> Todas</button>
							<button type="submit" class="btn btn-primary" onclick="window.location.replace('messages.php?f=1'); return false;" ><i class="white halflings-icon envelope"></i> Por Ler</button>
							<button type="submit" class="btn btn-primary" onclick="window.location.replace('messages.php?f=2'); return false;" ><i class="white halflings-icon envelope"></i> Lidas</button><br><br>
							<ul class="messagesList">
								<?php
									if( isset($_GET["f"]) ) {
										$filtro = $_GET["f"];
									}
									else {
										$filtro = 0;
									}
									
									$mensagens = get_mensagens($_SESSION['user']['tecnico'], $filtro);
									
									if(sizeof($mensagens)>0) {
										foreach($mensagens as $mensagem) {
											if( $mensagem["estado"]==1 ) {
												$estado = '<span class="title estadoDiv"><span class="label label-warning">por ler</span>';
											}
											else {
												$estado = '<span class="title estadoDiv"><span></span>';
											}
										?>
											<li class="mensagem_linha" mensagem="<?php echo $mensagem["id"]; ?>">
												<span class="from"><?php echo $mensagem["completeName"]; ?></span><?php echo $estado; ?> <?php echo $mensagem["assunto"]; ?></span><span class="date"><?php echo date('d-m-Y', $mensagem["datahora"]); ?>, <b><?php echo date('H:i', $mensagem["datahora"]); ?></b></span>
											</li>
										<?php
										}
									}
								?>
							</ul>
						</div>
						<div class="span5 noMarginLeft hidden messageDisplay">
							<div class="message dark">
								<div class="header">
									<h1 class="lerMensagem_assunto"></h1>
									<div class="from"><i class="halflings-icon user"></i> <b><a class="lerMensagem_remetente"></a></b> / <a class="lerMensagem_remetenteEmail"></a></div>
									<div class="date"><i class="halflings-icon time"></i> <a class="lerMensagem_data"></a>, <b><a class="lerMensagem_hora"></a></b></div>
									<div class="menu"></div>
								</div>
								<div class="content lerMensagem_corpo">
								</div>
								<form class="replyForm"method="post" action="">
									<fieldset>
										<textarea tabindex="3" class="input-xlarge span12" id="message" name="body" rows="12" placeholder="Clique aqui para responder"></textarea>
										<div class="actions">
											<button tabindex="3" type="submit" class="btn btn-success">Enviar Mensagem</button>
										</div>
									</fieldset>
								</form>	
							</div>	
						</div>
					</div>
				</div>
			</div><!--/.fluid-container-->
				<!-- end: Content -->
		</div><!--/#content.span10-->
	
	<div class="modal hide fade"id="myModal">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">×</button>
			<h3>Nova Mensagem</h3>
		</div>
		<div class="modal-body">
			<form method="post" id="novaMensagemForm" class="form-horizontal">
				<label class="" for="typeahead">Destinatário </label>
				<input type="text" name="mens_destino" value="<?php echo $mensagemEnviada ? '' : $mensagemDestino ?>" class="span6 typeahead" id="typeahead"  data-provide="typeahead" data-items="4" data-source='["antonio.vasconcelos", "ricardo.castilho", "tiago.loureiro", "tiago.pereira"]'>
				<label class="" for="typeahead">Assunto </label>
				<input type="text" name="mens_assunto" value="<?php echo $mensagemEnviada ? '' : $mensagemAssunto ?>" class="span6 typeahead" id="">
				<label class="" for="textarea2">Mensagem</label>
				<textarea class="cleditor" name="mens_corpo" id="textarea2" rows="3">
					<?php echo $mensagemEnviada ? '' : $mensagemCorpo ?>
				</textarea>
			</form>
		</div>
		<div class="modal-footer">
			<a href="#" class="btn" data-dismiss="modal">Cancelar</a>
			<a href="#" onclick="submeterMensagem()" class="btn btn-primary">Enviar</a>
		</div>
	</div>
	
	<div class="common-modal modal fade" id="common-Modal1" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-content">
			<ul class="list-inline item-details">
				<li><a href="http://themifycloud.com">Admin templates</a></li>
				<li><a href="http://themescloud.org">Bootstrap themes</a></li>
			</ul>
		</div>
	</div>
	
	<div class="clearfix"></div>
	<script>
		function submeterMensagem() {
			if( $("input[name='mens_destino']").val().toString().trim() == '' ) {
				alert("Tem de indicar o destinatário da mensagem");
			}
			else if( $("input[name='mens_assunto']").val().toString().trim() == '' ) {
				alert("Tem de indicar o assunto da mensagem");
			}
			else if( $("textarea[name='mens_corpo']").val().toString().trim() == '' ) {
				alert("A mensagem não pode ser vazia");
			}
			else {
				$( "#novaMensagemForm" ).submit();
			}
		}
		
		$(".mensagem_linha").click(function() {
			var id = $(this).attr("mensagem");
			var linha = $(this);
			
			
			
			jQuery.ajax({
				type: "POST",
				url: "funcoes_gerais.php",
				data: { "action" : "get_message('" + id + "');"},
				success: function(data) 
				{
					var obj = JSON.parse(data);
					$.each(obj, function(index, value) {
						
						var date = new Date(value["datahora"]*1000);
						
						$(".lerMensagem_assunto").html(value["assunto"]);
						linha.find(".estadoDiv").html('<span></span>' + value["assunto"]);
						$(".lerMensagem_remetente").html(value["remetente"]);
						$(".lerMensagem_remetenteEmail").html(value["remetenteEmail"]);
						$(".lerMensagem_data").html(date.getDate() + "-" + ("0" + (date.getMonth() + 1)).slice(-2) + "-" + date.getFullYear());
						$(".lerMensagem_hora").html(("0" + date.getHours()).slice(-2) + ":" + ("0" + date.getMinutes()).slice(-2));
						$(".lerMensagem_corpo").html("<p>" + decodeURIComponent(escape(atob(value["corpo"]))) + "</p>");
						$("#message").val("");
						$(".messageDisplay").removeClass("hidden");
					});
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
