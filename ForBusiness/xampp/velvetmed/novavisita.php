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
					$current_page = "Nova Visita";
					include("breadcrumbs.php"); 
				?>
				
				<div class="row-fluid step">
					<div class="step-text">1. Dados Cliente</div><div class="step-bar"></div>
				</div>
				<div class="row-fluid">
					<button type="button" class="btn btn-primary" onclick="novo_cliente(); return false;"><i class="white halflings-icon plus-sign"></i> NOVO CLIENTE</button>
					<button type="submit" class="btn btn-primary" data-remodal-target="modal"><i class="halflings-icon white zoom-in"></i> CLIENTE EXISTENTE</button><br><br>
				</div>
				<div class="row-fluid">
					<form class="form-horizontal">
						<div class="control-group">
							<label class="control-label" for="nome_cliente">Cliente</label>
							<div class="controls">
								<input type="text" class="span4" value="" id="nome" placeholder="Nome">
								<input type="text" class="span1" value="" disabled id="no" placeholder="Nº">
								<input type="text" class="span2" value="" id="ncont" placeholder="NIF">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="morada">Morada</label>
							<div class="controls">
								<input type="text" class="span4" value="" id="morada" placeholder="Morada">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="codpost">Cód. Postal</label>
							<div class="controls">
								<input type="text" class="span4" value="" id="codpost" placeholder="Cód. Postal">
								<input type="text" class="span3" value="" id="local" placeholder="Localidade">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="codpost">Contactos</label>
							<div class="controls">
								<input type="text" class="span4" value="" id="email" placeholder="Email">
								<input type="text" class="span3" value="" id="telefone" placeholder="Telefone">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="codpost">Contactos2</label>
							<div class="controls">
								<input type="text" class="span4" value="" id="email2" placeholder="Email">
								<input type="text" class="span3" value="" id="telefone2" placeholder="Telefone">
							</div>
						</div>
					</form>
				</div>
				<div class="row-fluid step" style="margin-top:20px">
					<div class="step-text">2. Data/Hora da Visita</div><div class="step-bar"></div>
				</div>
				<div class="row-fluid">
					<form class="form-horizontal">
						<div class="control-group">
							<label class="control-label" for="Data">Data</label>
							<div class="controls">
								<input type="date" class="span4" value="<?php echo date("Y-m-d"); ?>" id="Data" placeholder="Data">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="Hora">Hora</label>
							<div class="controls">
								<input type="text" class="span1" value="<?php echo date("H"); ?>" id="Hora" placeholder="Hora">
								<input type="text" class="span1" value="<?php echo date("i"); ?>" id="Minuto" placeholder="Minuto">
							</div>
						</div>
					</form>
				</div>
				<div class="row-fluid step" style="margin-top:20px">
					<div class="step-text">3. Objetivos</div><div class="step-bar"></div>
				</div>
				<form class="form-horizontal">
					<textarea id="objetivos" class="span12" style="height:200px; background:white;"></textarea>
				</form>
				<div class="row-fluid step" style="margin-top:20px">
					<div class="step-text">4. Relatório</div><div class="step-bar"></div>
				</div>
				<form class="form-horizontal">
					<textarea id="relatorio" class="span12" style="height:200px; background:white;"></textarea>
				</form>
				<div class="row-fluid">
					<button type="submit" class="btn btn-primary" id="save_sign" onclick="return false;">GRAVAR VISITA</button>
				</div>
			</div>
			<div class="remodal" data-remodal-id="modal">
				<button data-remodal-action="close" class="remodal-close"></button>
				<h1>Escolher cliente</h1>
				<div class="row-fluid">
					<input type="text" class="span12" value="" id="filtro_cliente" placeholder="NOME OU Nº DE CLIENTE">
				</div>
				<div class="row-fluid">
					<button type="button" onclick="FiltraClientes();" class="btn btn-primary span12">Filtrar</button>
				</div>
				<div class="row-fluid">
					<table id="TabClientes" class="table table-striped dataTable no-footer">
						<thead>
							<tr>
								<th>Nº</th>
								<th>Nome</th>
								<th>NIF</th>
								<th></th>
							</tr>
						</thead>   
						<tbody>
						</tbody>
					</table>
				</div>
				<br>
				<button type="button" class="btn btn-secondary" data-remodal-action="cancel">Cancelar</button>
			</div>
			<script>
				var deve_sair = 0;
				window.onbeforeunload = function() {
					if( deve_sair == 0 ) {
						return 'Are you sure you want to navigate away from this page?';
					}
				};
				
				
				var saveButton = document.getElementById('save_sign');
				saveButton.addEventListener('click', function (event) {
					bootbox.confirm({
						title: "Gravação de Visita?",
						message: "Tem a certeza que deseja gravar a visita? Este procedimento não pode ser anulado.",
						buttons: {
							confirm: {
								label: 'SIM',
								className: 'btn-success'
							},
							cancel: {
								label: 'NÃO',
								className: 'btn-danger'
							}
						},
						callback: function (result) {
							if(result) {
								GravaVisita();
							}
						}
					});
				});
				
				function isValidEmailAddress(emailAddress) {
					var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
					return pattern.test(emailAddress);
				};
				
				function GravaVisita() {
					ActivateLoading();
					//verificar campos preenchidos
					if( jQuery("#no").val() == "") {
						//novo cliente
						if( jQuery("#ncont").val().trim() == "" ) {
							bootbox.alert("Não é possivel gravar a visita! É necessário indicar o NIF do cliente.");
							DeactivateLoading();
						}
						else if( jQuery("#nome").val().trim() == "" ) {
							bootbox.alert("Não é possivel gravar a visita! É necessário indicar o nome do cliente.");
							DeactivateLoading();
						}
						else if( jQuery("#email").val().trim() == "" ) {
							bootbox.alert("Não é possivel gravar a visita! É necessário indicar o email do cliente.");
							DeactivateLoading();
						}
						else if( !isValidEmailAddress(jQuery("#email").val()) ) {
							bootbox.alert("Não é possivel gravar a visita! É necessário indicar um email <b>válido</b> para o cliente.");
							DeactivateLoading();
						}
						else if( jQuery("#telefone").val().trim() == "" ) {
							bootbox.alert("Não é possivel gravar a visita! É necessário indicar o telefone do cliente.");
							DeactivateLoading();
						}
						else if( jQuery("#morada").val().trim() == "" ) {
							bootbox.alert("Não é possivel gravar a visita! É necessário indicar a morada do cliente.");
							DeactivateLoading();
						}
						else if( jQuery("#codpost").val().trim() == "" ) {
							bootbox.alert("Não é possivel gravar a visita! É necessário indicar o código postal do cliente.");
							DeactivateLoading();
						}
						else if( jQuery("#local").val().trim() == "" ) {
							bootbox.alert("Não é possivel gravar a visita! É necessário indicar a localidade do cliente.");
							DeactivateLoading();
						}
						else {
							
							var data_visita = {}; 
							
							data_visita.nome = jQuery("#nome").val().trim();
							data_visita.morada = jQuery("#morada").val().trim();
							data_visita.codpost = jQuery("#codpost").val().trim();
							data_visita.local = jQuery("#local").val().trim();
							data_visita.nif = jQuery("#ncont").val().trim();
							data_visita.email = jQuery("#email").val().trim();
							data_visita.telefone = jQuery("#telefone").val().trim();
							data_visita.no = 0;
							data_visita.email2 = jQuery("#email2").val().trim();
							data_visita.telefone2 = jQuery("#telefone2").val().trim();
							
							data_visita.vendedor = <?php echo $_SESSION['user']['id']; ?>;
							
							data_visita.data = jQuery("#Data").val().trim();
							data_visita.hora = jQuery("#Hora").val().trim();
							data_visita.minuto = jQuery("#Minuto").val().trim();
							
							data_visita.relatorio = escape(jQuery("#relatorio").val().trim());
							data_visita.objetivos = escape(jQuery("#objetivos").val().trim());

							var encodedString = encodeURIComponent( JSON.stringify(data_visita) );
							
							jQuery.ajax({
								type: "POST",
								url: "funcoes_gerais.php",
								data: { "action" : "cria_visita('"+encodedString+"');"},
								success: function(data) 
								{
									var obj = JSON.parse(data);
									var successed_order = 0;
									
									if( obj["success"] == 1 ) {
										successed_order = 1;
									}
									
									if( successed_order ) {
										bootbox.alert({ 
											message: "Visita gravada com sucesso!", 
											callback: function(){
												deve_sair = 1;
												location.replace("home.php");
											}
										})
									}
									else {
										bootbox.alert("Não foi possivel guardar a visita! Tente novamente mais tarde.");
									}
									
									DeactivateLoading();
								}
							});
							DeactivateLoading();
						}
					}
					else {
						//cliente pre-preenchido
						var data_visita = {}; 
						var data_visita_linhas = new Array();
						
						data_visita.nome = jQuery("#nome").val().trim();
						data_visita.morada = jQuery("#morada").val().trim();
						data_visita.codpost = jQuery("#codpost").val().trim();
						data_visita.local = jQuery("#local").val().trim();
						data_visita.nif = jQuery("#ncont").val().trim();
						data_visita.email = jQuery("#email").val().trim();
						data_visita.telefone = jQuery("#telefone").val().trim();
						data_visita.no = jQuery("#no").val().trim();
						data_visita.email2 = jQuery("#email2").val().trim();
						data_visita.telefone2 = jQuery("#telefone2").val().trim();
						
						data_visita.data = jQuery("#Data").val().trim();
						data_visita.hora = jQuery("#Hora").val().trim();
						data_visita.minuto = jQuery("#Minuto").val().trim();
						
						data_visita.vendedor = <?php echo $_SESSION['user']['id']; ?>;
						
						data_visita.relatorio = escape(jQuery("#relatorio").val().trim());
						data_visita.objetivos = escape(jQuery("#objetivos").val().trim());
						
						var encodedString = encodeURIComponent( JSON.stringify(data_visita) );
						
						jQuery.ajax({
							type: "POST",
							url: "funcoes_gerais.php",
							data: { "action" : "cria_visita('"+encodedString+"');"},
							success: function(data) 
							{
								var obj = JSON.parse(data);
								var successed_order = 0;
								
								if( obj["success"] == 1 ) {
									successed_order = 1;
								}
								
								if( successed_order ) {
									bootbox.alert({ 
										message: "Visita gravada com sucesso!", 
										callback: function(){
											deve_sair = 1;
											location.replace("home.php");
										}
									})
								}
								else {
									bootbox.alert("Não foi possivel guardar a visita! Tente novamente mais tarde.");
								}
								
								DeactivateLoading();
							}
						});
					}
				}
			</script>
			<script>
				jQuery(document).ready(function() {
					jQuery(function() {
						jQuery(document).on('keydown', '.txtboxToFilter', function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||/65|67|86|88/.test(e.keyCode)&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});
					})
				});
				
				$('#filtro_cliente').keyup(function(e){
					if(e.keyCode == 13)
					{
						FiltraClientes();
					}
				});
				
				function novo_cliente() {
					jQuery("#nome").val("");
					jQuery("#no").val("");
					jQuery("#ncont").val("");
					jQuery("#morada").val("");
					jQuery("#codpost").val("");
					jQuery("#local").val("");
					jQuery("#email").val("");
					jQuery("#telefone").val("");
					
					jQuery("#nome").attr("disabled", false);
					jQuery("#no").attr("disabled", true);
					jQuery("#ncont").attr("disabled", false);
					jQuery("#morada").attr("disabled", false);
					jQuery("#codpost").attr("disabled", false);
					jQuery("#local").attr("disabled", false);
					jQuery("#email").attr("disabled", false);
					jQuery("#telefone").attr("disabled", false);
				}
				
				function insere_cliente(no) {
					ActivateLoading();
					
					limpa_filtra_clientes();
					var inst = $('[data-remodal-id=modal]').remodal();
					
					jQuery.ajax({
						type: "POST",
						url: "funcoes_gerais.php",
						data: { "action" : "get_cliente('"+no+"');"},
						success: function(data) 
						{
							var obj = JSON.parse(data);
							
							$.each(obj, function(index, value) {
								jQuery("#nome").val(value["nome"]);
								jQuery("#no").val(value["no"]);
								jQuery("#ncont").val(value["ncont"]);
								jQuery("#morada").val(value["morada"]);
								jQuery("#codpost").val(value["codpost"]);
								jQuery("#local").val(value["local"]);
								jQuery("#email").val(value["email"]);
								jQuery("#telefone").val(value["telefone"]);
								jQuery("#email2").val(value["c1email"]);
								jQuery("#telefone2").val(value["c1tele"]);
								
								jQuery("#objetivos").val(value["obj"]);
								
								jQuery("#nome").attr("disabled", "disabled");
								jQuery("#no").attr("disabled", "disabled");
								jQuery("#ncont").attr("disabled", "disabled");
								jQuery("#morada").attr("disabled", "disabled");
								jQuery("#codpost").attr("disabled", "disabled");
								jQuery("#local").attr("disabled", "disabled");
							});

							inst.close();
							DeactivateLoading();
						}
					});
				}
				
				function limpa_filtra_clientes() {
					jQuery("#filtro_cliente").val("");
					jQuery("#TabClientes tbody").empty();
				}
				
				function FiltraClientes() {
					ActivateLoading();
			
					jQuery.ajax({
						type: "POST",
						url: "funcoes_gerais.php",
						data: { "action" : "tabela_clientes_2('"+jQuery("#filtro_cliente").val()+"', 'nome');"},
						success: function(data) 
						{
							var obj = JSON.parse(data);
							jQuery("#TabClientes tbody").empty();
							
							$.each(obj, function(index, value) {
								jQuery("#TabClientes tbody").append("<tr><td>"+value["no"]+"</td><td>"+value["nome"]+"</td><td>"+value["ncont"]+"</td><td><button onclick='insere_cliente("+value["no"]+")' type='button' class='btn btn-primary'><i class='white halflings-icon plus-sign'></i></button></td></tr>");
							});

							DeactivateLoading();
						}
					});
				}
				
			</script>
		</div><!--/.fluid-container-->
			<!-- end: Content -->
	</div><!--/#content.span10-->	
	<div class="clearfix"></div>
	<?php include("footer.php"); ?>
	<!-- start: JavaScript-->
	<?php include("footer_code.php"); ?>
	<!-- end: JavaScript-->
</body>
</html>
