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
					$current_page = "Nova Encomenda";
					include("breadcrumbs.php"); 
				?>
				<div class="row-fluid step">
					<div class="step-text">1. Dados Cliente</div><div class="step-bar"></div>
				</div>
				<div class="row-fluid">
					<button type="button" class="btn btn-primary" onclick="novo_cliente(); return false;"><i class="white halflings-icon plus-sign"></i> NOVO CLIENTE</button>
					<button type="submit" class="btn btn-primary" data-remodal-target="modal"><i class="halflings-icon white zoom-in"></i> CLIENTE EXISTENTE</button>
					<button type="button" class="btn btn-primary" data-remodal-target="modal-enc" onclick="recuperar_encomenda(); return false;"><i class="white halflings-icon plus-sign"></i> RECUPERAR ENCOMENDA</button><br><br>
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
					</form>
				</div>
				<div class="row-fluid" style="margin-top:15px;">
					<form class="form-horizontal">
						<div class="control-group">
							<label class="control-label" for="morada">Nome Contacto Entrega</label>
							<div class="controls">
								<input type="text" class="span4" value="" id="nome_ent" placeholder="Nome contacto">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="morada">Morada Entrega</label>
							<div class="controls">
								<input type="text" class="span4" value="" id="morada_ent" placeholder="Morada">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="codpost">Cód. Postal Entrega</label>
							<div class="controls">
								<input type="text" class="span4" value="" id="codpost_ent" placeholder="Cód. Postal">
								<input type="text" class="span3" value="" id="local_ent" placeholder="Localidade">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="codpost">Contactos Entrega</label>
							<div class="controls">
								<input type="text" class="span4" value="" id="email_ent" placeholder="Email">
								<input type="text" class="span3" value="" id="telefone_ent" placeholder="Telefone">
							</div>
						</div>
					</form>
				</div>
				<div class="row-fluid step" style="margin-top:20px">
					<div class="step-text">2. Encomenda</div><div class="step-bar"></div>
				</div>
				<div class="row-fluid">
					<button type="submit" onclick="FiltraArtigosVelvet();" class="btn btn-primary" data-remodal-target="modal-st-velvet"><i class="white halflings-icon plus-sign"></i> NOVO ARTIGO VELVET</button>
					<button type="submit" onclick="FiltraArtigosRepresentado();" class="btn btn-primary" data-remodal-target="modal-st"><i class="white halflings-icon plus-sign"></i> NOVO ARTIGO REPRESENTADO</button><br><br>
				</div>
				<div class="row-fluid">
					<table id="TabBI" class="table table-striped">
						<thead>
							<tr>
								<th>Referência</th>
								<th>Designação</th>
								<th>Qtd</th>
								<th>PVF</th>
								<th>IVA</th>
								<th>PVF Total</th>
								<th>Desc.</th>
								<th>PVF Liq. Total</th>
								<th>Pack</th>
								<th></th>
							</tr>
						</thead>   
						<tbody>
						</tbody>
					</table>
				</div>
				
				<div class="row-fluid span5">
					<div class="row-fluid">
						<form class="form-horizontal">
							<div class="control-group">
								<label class="control-label" for="totaldoc">Total PVF</label>
								<div class="controls">
									<input type="text" class="span6" value="€ 0.00" id="totaldoc">
								</div>
							</div>
						</form>
					</div>
					<div class="row-fluid">
						<form class="form-horizontal">
							<div class="control-group">
								<label class="control-label" for="totaldoc">Desconto</label>
								<div class="controls">
									<input type="text" class="span6" value="€ 0.00" id="totaldesc">
								</div>
							</div>
						</form>
					</div>
					<div class="row-fluid">
						<form class="form-horizontal">
							<div class="control-group">
								<label class="control-label" for="totaldoc">Total Liquido</label>
								<div class="controls">
									<input type="text" class="span6" value="€ 0.00" id="totalliq">
								</div>
							</div>
						</form>
					</div>
					<div class="row-fluid">
						<form class="form-horizontal">
							<div class="control-group">
								<label class="control-label" for="totaldoc">IVA</label>
								<div class="controls">
									<input type="text" class="span6" value="€ 0.00" id="totaliva">
								</div>
							</div>
						</form>
					</div>
				</div>
				<div class="row-fluid span5">
					<div class="row-fluid">
						<form class="form-horizontal">
							<div class="control-group">
								<label class="control-label" for="totaldoc">Rentabilidade Total (€)</label>
								<div class="controls">
									<input type="text" class="span6" value="€ 0.00" id="rent_total_eur">
								</div>
							</div>
						</form>
					</div>
					<div class="row-fluid">
						<form class="form-horizontal">
							<div class="control-group">
								<label class="control-label" for="totaldoc">Rentabilidade Total (%)</label>
								<div class="controls">
									<input type="text" class="span6" value="0.00%" id="rent_total_per">
								</div>
							</div>
						</form>
					</div>
					<div class="row-fluid">
						<form class="form-horizontal">
							<div class="control-group">
								<label class="control-label" for="descontofinanc">Desconto Financeiro</label>
								<div class="controls">
									<input type="text" class="span6" value="0.00%" id="descontofinanc">
								</div>
							</div>
						</form>
					</div>
					<div class="row-fluid">
						<form class="form-horizontal">
							<div class="control-group">
								<label class="control-label" for="totaldoc"><b>Total Documento</b></label>
								<div class="controls">
									<input type="text" class="span6" value="€ 0.00" id="totaldocumento">
								</div>
							</div>
						</form>
					</div>
				</div>
				<div class="row-fluid span12" style="margin-top:15px;">
					<form class="form-horizontal">
						<div class="control-group">
							<label class="control-label" for="totaldoc">Condições Pagamento</label>
							<div class="controls">
								<select class="tpdesc">
									<?php
										$tpdesc = get_tpdesc();
										foreach ($tpdesc as $pag) {
											if( trim($pag["descricao"]) == 'P. Pagamento' ) {
												$selected = 'selected';
											}
											else {
												$selected = '';
											}
										?>
											<option desc="<?php echo trim($pag["u_desconto"]); ?>" <?php echo $selected; ?> value="<?php echo trim($pag["tpstamp"]); ?>"><?php echo trim($pag["descricao"]); ?></option>
										<?php
										}
									?>
								</select>
							</div>
						</div>
					</form>
				</div>
				<div class="row-fluid span5">
					<div class="row-fluid">
						<form class="form-horizontal">
							<div class="control-group">
								<label class="control-label" for="obs">Notas Internas</label>
								<div class="controls">
									<textarea id="obs" maxlength="254" rows="11" class="span12"></textarea>
								</div>
							</div>
						</form>
					</div>
				</div>
				<div class="row-fluid span5">
					<div class="row-fluid">
						<form class="form-horizontal">
							<div class="control-group">
								<label class="control-label" for="obsint">Observações Cliente</label>
								<div class="controls">
									<textarea id="obsint" maxlength="300" rows="11" class="span12"></textarea>
								</div>
							</div>
						</form>
					</div>
				</div>
				<div class="row-fluid span12">
				</div>
				<div class="row-fluid step" style="margin-top:20px">
					<div class="step-text">4. Confirmação</div><div class="step-bar"></div>
				</div>
				<div id="signature-pad" class="m-signature-pad">
					<canvas width=400 height=200></canvas><br>
					<button type="submit" class="btn btn-primary" id="clear_sign" onclick="return false;">LIMPAR</button>
				</div>
				<div class="row-fluid step" style="margin-top:20px">
					<div class="step-text">5. Finalizar</div><div class="step-bar"></div>
				</div>
				<div class="row-fluid">
					<button type="button" class="btn btn-secondary" onclick="GuardaEncomendaTmp();">GRAVAR</button>
					<button type="submit" class="btn btn-primary" id="save_sign" onclick="return false;">FINALIZAR</button>
				</div>
			</div>
			<div class="remodal" data-remodal-id="modal">
				<button data-remodal-action="close" class="remodal-close"></button>
				<h1>Escolher cliente</h1>
				<div class="row-fluid">
					<input type="text" class="span12" value="" id="filtro_cliente" placeholder="NOME, Nº DE CLIENTE, NIF OU LOCALIDADE">
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
								<th>Cód. Postal</th>
								<th>Localidade</th>
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
			<div class="remodal" data-remodal-id="modal-enc">
				<button data-remodal-action="close" class="remodal-close"></button>
				<h1>Escolher encomenda gravada</h1>
				<div class="row-fluid">
					<table id="TabEncomendas" class="table table-striped dataTable no-footer">
						<thead>
							<tr>
								<th>Nome cliente</th>
								<th>Data/Hora gravação encomenda</th>
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
			<div class="remodal" data-remodal-id="modal-st">
				<button data-remodal-action="close" class="remodal-close"></button>
				<h1>Escolher artigo</h1>
				<div class="row-fluid">
					<input type="text" class="span11 pull-left" value="" id="filtro_st_repres" placeholder="NOME OU CÓD.">
					<button type="button" onclick="FiltraArtigosRepresentado();" class="btn btn-default span1 pull-right"><i class="halflings-icon white zoom-in"></i></button>
				</div>
				<div class="row-fluid">
					<table id="TabArtigos" class="table table-striped no-footer" width="100%">
						<thead>
							<tr>
								<th>Ref</th>
								<th>Familia</th>
								<th>Designação</th>
								<th>Preço</th>
								<th>Qtd</th>
								<th>Stock</th>
							</tr>
						</thead>   
						<tbody>
						</tbody>
					</table>
					<div class="row-fluid" style="margin-top:15px;	">
						<button type="button" onclick="InsereArtigos();" class="btn btn-primary span12">Inserir Linhas</button>
					</div>
				</div>
				<br>
				<button type="button" class="btn btn-secondary" data-remodal-action="cancel">Cancelar</button>
			</div>
			<div class="remodal" data-remodal-id="modal-st-velvet">
				<button data-remodal-action="close" class="remodal-close"></button>
				<h1>Escolher artigo</h1>
				<div class="control-group span4 pull-right">
					<label class="control-label" for="luc_total">Lucro Total</label>
					<div class="controls">
						<input type="text" class="span4" value="0" style="background:yellow; text-align:center; font-weight:bold;" id="luc_total">
					</div>
				</div>
				<div class="control-group span4 pull-right">
					<label class="control-label" for="rent_total">Rentabilidade Total</label>
					<div class="controls">
						<input type="text" class="span4" value="0%" style="background:yellow; text-align:center; font-weight:bold;" id="rent_total">
					</div>
				</div>
				<div class="control-group span4 pull-right">
					<label class="control-label" for="rent_total">Total Encomenda</label>
					<div class="controls">
						<input type="text" class="span4" value="0" style="background:yellow; text-align:center; font-weight:bold;" id="enc_total">
					</div>
				</div>
				<div class="row-fluid">
					<table id="TabArtigosVelvet" class="table table-striped no-footer" width="100%">
						<thead class="sticky" style="width: 100%;z-index: 999;background-color: #ffffff;">
							<tr>
								<th>CNP</th>
								<th>Produto</th>
								<th>PVF</th>
								<th>DESC. PVF</th>
								<th>Min. / REF.</th>
								<th>Custo Unit.</th>
								<th>PVP Recom.</th>
								<th>Lucro Unit. (€)</th>
								<th>Rent. Unit. (%)</th>
								<th>Qtd. a Enc.</th>
								<th>Custo Total</th>
								<th>Lucro Total</th>
								<th>Stock</th>
							</tr>
						</thead>   
						<tbody>
						</tbody>
					</table>
					<div class="row-fluid" style="margin-top:15px;	">
						<button type="button" id="InsereArtigosVelvetBut" onclick="InsereArtigosVelvet();" class="btn btn-primary span12">Inserir Linhas</button>
					</div>
				</div>
				<br>
				<button type="button" class="btn btn-secondary" data-remodal-action="cancel">Cancelar</button>
			</div>
			<script>
			
				function GuardaEncomendaTmp() {
					//inputs
					var inputObj = {}, $this;
					$("input").each(function(){
						inputObj[$(this).attr("id")] = $(this).val();
					});
					//table
					var table_tmp = jQuery("#TabBI").html();
					//textarea
					var txta_tmp = jQuery("#obs").val();
					var txta_tmp2 = jQuery("#obsint").val();
					//select
					var sel_tmp = $(".tpdesc").find(":selected").val();
					
					var input_tmp = encodeURIComponent( JSON.stringify(inputObj) );
					var table_tmp = encodeURIComponent( JSON.stringify(table_tmp) );
					var txta_tmp = encodeURIComponent( JSON.stringify(txta_tmp) );
					var txta2_tmp = encodeURIComponent( JSON.stringify(txta_tmp2) );
					var sel_tmp = encodeURIComponent( JSON.stringify(sel_tmp) );
					
					jQuery.ajax({
						type: "POST",
						url: "funcoes_gerais.php",
						data: { "action" : "grava_encomenda_tmp('"+input_tmp+"','"+table_tmp+"','"+txta_tmp+"','"+sel_tmp+"', <?php echo $_SESSION["user"]["id"]; ?>,'"+txta2_tmp+"');"},
						success: function(data) 
						{
							
							var obj = JSON.parse(data);
							var successed_order = 0;
							
							if( obj["success"] == 1 ) {
								successed_order = 1;
							}
							
							if( successed_order ) {
								bootbox.alert({ 
									message: "Encomenda gravada com sucesso!"
								})
							}
							else {
								bootbox.alert("Não foi possivel guardar a encomenda! Tente novamente mais tarde.");
							}
							
							DeactivateLoading();
						}
					});
					
					
				}
			
				var deve_sair = 0;
				window.onbeforeunload = function() {
					if( deve_sair == 0 ) {
						return 'Are you sure you want to navigate away from this page?';
					}
				};
				
				var canvas = document.querySelector("canvas");
				signaturePad = new SignaturePad(canvas);
				signaturePad.minWidth = 0.8;
				signaturePad.maxWidth = 0.8;
				signaturePad.penColor = "rgb(0, 0, 0)";
				var cancelButton = document.getElementById('clear_sign');
				cancelButton.addEventListener('click', function (event) {
					signaturePad.clear();
				});
				
				var saveButton = document.getElementById('save_sign');
				saveButton.addEventListener('click', function (event) {
					bootbox.confirm({
						title: "Gravação de Encomenda?",
						message: "Tem a certeza que deseja gravar a encomenda? Este procedimento não pode ser anulado.",
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
								GravaEncomenda();
							}
						}
					});
				});
				
				function isValidEmailAddress(emailAddress) {
					var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
					return pattern.test(emailAddress);
				};
				
				function GravaEncomenda() {
					ActivateLoading();
					//verificar campos preenchidos
					if( jQuery("#no").val() == "") {
						//novo cliente
						if( jQuery("#ncont").val().trim() == "" ) {
							bootbox.alert("Não é possivel gravar a encomenda! É necessário indicar o NIF do cliente.");
							DeactivateLoading();
						}
						else if( jQuery("#nome").val().trim() == "" ) {
							bootbox.alert("Não é possivel gravar a encomenda! É necessário indicar o nome do cliente.");
							DeactivateLoading();
						}
						else if( jQuery("#email").val().trim() == "" ) {
							bootbox.alert("Não é possivel gravar a encomenda! É necessário indicar o email do cliente.");
							DeactivateLoading();
						}
						else if( !isValidEmailAddress(jQuery("#email").val()) ) {
							bootbox.alert("Não é possivel gravar a encomenda! É necessário indicar um email <b>válido</b> para o cliente.");
							DeactivateLoading();
						}
						else if( jQuery("#telefone").val().trim() == "" ) {
							bootbox.alert("Não é possivel gravar a encomenda! É necessário indicar o telefone do cliente.");
							DeactivateLoading();
						}
						else if( jQuery("#morada").val().trim() == "" ) {
							bootbox.alert("Não é possivel gravar a encomenda! É necessário indicar a morada do cliente.");
							DeactivateLoading();
						}
						else if( jQuery("#codpost").val().trim() == "" ) {
							bootbox.alert("Não é possivel gravar a encomenda! É necessário indicar o código postal do cliente.");
							DeactivateLoading();
						}
						else if( jQuery("#local").val().trim() == "" ) {
							bootbox.alert("Não é possivel gravar a encomenda! É necessário indicar a localidade do cliente.");
							DeactivateLoading();
						}
						else if( signaturePad.isEmpty() ) {
							bootbox.alert("Não é possivel gravar a encomenda! O cliente tem de assinar a encomenda.");
							DeactivateLoading();
						}
						else {
							
							var data_encomenda = {}; 
							var data_encomenda_linhas = new Array();
							
							data_encomenda.nome = jQuery("#nome").val().toString().trim();
							data_encomenda.morada = jQuery("#morada").val().toString().trim();
							data_encomenda.codpost = jQuery("#codpost").val().toString().trim();
							data_encomenda.local = jQuery("#local").val().toString().trim();
							data_encomenda.nif = jQuery("#ncont").val().toString().trim();
							data_encomenda.email = jQuery("#email").val().toString().trim();
							data_encomenda.telefone = jQuery("#telefone").val().toString().trim();
							data_encomenda.no = 0;
							data_encomenda.totaldoc = (total_liquido() + total_iva())*(1-parseFloat(jQuery(".tpdesc option:selected").attr("desc"))/100);
							data_encomenda.totalpvf = total_documento();
							data_encomenda.desconto = total_desconto();
							data_encomenda.desconto_fin = parseFloat(jQuery(".tpdesc option:selected").attr("desc"));
							data_encomenda.totalliq = total_liquido();
							data_encomenda.iva = total_iva();
							data_encomenda.tpstamp = jQuery(".tpdesc").val().toString().trim();
							data_encomenda.tpdesc = jQuery(".tpdesc option:selected").text();
							
							data_encomenda.nome_ent = jQuery("#nome_ent").val().toString().trim();
							data_encomenda.morada_ent = jQuery("#morada_ent").val().toString().trim();
							data_encomenda.codpost_ent = jQuery("#codpost_ent").val().toString().trim();
							data_encomenda.local_ent = jQuery("#local_ent").val().toString().trim();
							data_encomenda.email_ent = jQuery("#email_ent").val().toString().trim();
							data_encomenda.telefone_ent = jQuery("#telefone_ent").val().toString().trim();
							
							data_encomenda.obs = jQuery("#obs").val().toString().trim();
							data_encomenda.obsint = jQuery("#obsint").val().toString().trim();
							
							var data_assinatura = signaturePad.toDataURL();
							data_encomenda.assinatura = data_assinatura.split(",")[1];
							data_encomenda.assinatura_file = data_assinatura.replace(/^data:image\/(png|jpg);base64,/, "");
							
							jQuery("#TabBI > tbody > tr").each(function() {
								var data_encomenda_linhas_temp = {};
								
								data_encomenda_linhas_temp.ref = jQuery(this).children().eq(0).html().toString().trim();
								data_encomenda_linhas_temp.design = jQuery(this).children().eq(1).html().toString().trim();
								data_encomenda_linhas_temp.qtt = parseFloat(jQuery(this).children().eq(2).find("input").val().trim());
								data_encomenda_linhas_temp.epv2 = parseFloat(jQuery(this).children().eq(3).html().toString().trim());
								data_encomenda_linhas_temp.ettdeb = parseFloat(jQuery(this).children().eq(7).html().toString().trim());
								data_encomenda_linhas_temp.desc = parseFloat(jQuery(this).children().eq(6).html().toString().trim());
								
								data_encomenda_linhas.push(data_encomenda_linhas_temp);
							});
							
							data_encomenda.linhas = data_encomenda_linhas;
							
							var encodedString = encodeURIComponent( JSON.stringify(data_encomenda) );
							
							jQuery.ajax({
								type: "POST",
								url: "funcoes_gerais.php",
								data: { "action" : "cria_encomenda('"+encodedString+"');"},
								success: function(data) 
								{
									var obj = JSON.parse(data);
									var successed_order = 0;
									
									if( obj["success"] == 1 ) {
										successed_order = 1;
									}
									
									if( successed_order ) {
										bootbox.alert({ 
											message: "Encomenda finalizada com sucesso!", 
											callback: function(){
												deve_sair = 1;
												location.replace("home.php");
											}
										})
									}
									else {
										bootbox.alert("Não foi possivel guardar a encomenda! Tente novamente mais tarde.");
									}
									
									DeactivateLoading();
								}
							});
							DeactivateLoading();
						}
					}
					else {
						//cliente pre-preenchido
						if( signaturePad.isEmpty() ) {
							bootbox.alert("Não é possivel gravar a encomenda! O cliente tem de assinar a encomenda.");
							DeactivateLoading();
						}
						else {
							
							var data_encomenda = {}; 
							var data_encomenda_linhas = new Array();
							
							data_encomenda.nome = jQuery("#nome").val().toString().trim();
							data_encomenda.morada = jQuery("#morada").val().toString().trim();
							data_encomenda.codpost = jQuery("#codpost").val().toString().trim();
							data_encomenda.local = jQuery("#local").val().toString().trim();
							data_encomenda.nif = jQuery("#ncont").val().toString().trim();
							data_encomenda.email = jQuery("#email").val().toString().trim();
							data_encomenda.telefone = jQuery("#telefone").val().toString().trim();
							data_encomenda.no = jQuery("#no").val().toString().trim();
							data_encomenda.totaldoc = (total_liquido() + total_iva())*(1-parseFloat(jQuery(".tpdesc option:selected").attr("desc"))/100);
							data_encomenda.totalpvf = total_documento();
							data_encomenda.desconto = total_desconto();
							data_encomenda.desconto_fin = parseFloat(jQuery(".tpdesc option:selected").attr("desc"));
							data_encomenda.totalliq = total_liquido();
							data_encomenda.iva = total_iva();
							data_encomenda.tpstamp = jQuery(".tpdesc").val().toString().trim();
							data_encomenda.tpdesc = jQuery(".tpdesc option:selected").text();
							
							data_encomenda.nome_ent = jQuery("#nome_ent").val().toString().trim();
							data_encomenda.morada_ent = jQuery("#morada_ent").val().toString().trim();
							data_encomenda.codpost_ent = jQuery("#codpost_ent").val().toString().trim();
							data_encomenda.local_ent = jQuery("#local_ent").val().toString().trim();
							data_encomenda.email_ent = jQuery("#email_ent").val().toString().trim();
							data_encomenda.telefone_ent = jQuery("#telefone_ent").val().toString().trim();
							
							data_encomenda.obs = jQuery("#obs").val().toString().trim();
							data_encomenda.obsint = jQuery("#obsint").val().toString().trim();
							
							var data_assinatura = signaturePad.toDataURL();
							data_encomenda.assinatura = data_assinatura.split(",")[1];
							data_encomenda.assinatura_file = data_assinatura.replace(/^data:image\/(png|jpg);base64,/, "");
							
							jQuery("#TabBI > tbody > tr").each(function() {
								var data_encomenda_linhas_temp = {};
								
								data_encomenda_linhas_temp.ref = jQuery(this).children().eq(0).html().toString().trim();
								data_encomenda_linhas_temp.design = jQuery(this).children().eq(1).html().toString().trim();
								data_encomenda_linhas_temp.qtt = parseFloat(jQuery(this).children().eq(2).find("input").val().trim());
								data_encomenda_linhas_temp.epv2 = parseFloat(jQuery(this).children().eq(3).html().toString().trim());
								data_encomenda_linhas_temp.ettdeb = parseFloat(jQuery(this).children().eq(7).html().toString().trim());
								data_encomenda_linhas_temp.desc = parseFloat(jQuery(this).children().eq(6).html().toString().trim());
								data_encomenda_linhas_temp.attr = "lucrounit=" + jQuery(this).attr("lucrounit") + "|||";
								data_encomenda_linhas_temp.attr += "custounit=" + jQuery(this).attr("custounit") + "|||";
								data_encomenda_linhas_temp.attr += "packdesc=" + jQuery(this).attr("packdesc") + "|||";
								data_encomenda_linhas_temp.attr += "packstamp=" + jQuery(this).attr("packstamp") + "|||";
								data_encomenda_linhas_temp.attr += "pack=" + jQuery(this).attr("pack") + "|||";
								data_encomenda_linhas_temp.attr += "packtotal=" + jQuery(this).attr("packtotal") + "|||";
								data_encomenda_linhas_temp.attr += "packmin=" + jQuery(this).attr("packmin") + "|||";
								data_encomenda_linhas_temp.attr += "rowmin=" + jQuery(this).attr("rowmin");
								
								data_encomenda_linhas.push(data_encomenda_linhas_temp);
							});
							
							data_encomenda.linhas = data_encomenda_linhas;
							
							var encodedString = encodeURIComponent( JSON.stringify(data_encomenda) );
							
							jQuery.ajax({
								type: "POST",
								url: "funcoes_gerais.php",
								data: { "action" : "cria_encomenda('"+encodedString+"');"},
								success: function(data) 
								{
									console.log(data);
									var obj = JSON.parse(data);
									var successed_order = 0;
									
									if( obj["success"] == 1 ) {
										successed_order = 1;
									}
									
									if( successed_order ) {
										bootbox.alert({ 
											message: "Encomenda finalizada com sucesso!", 
											callback: function(){
												deve_sair = 1;
												location.replace("home.php");
											}
										})
									}
									else {
										bootbox.alert("Não foi possivel guardar a encomenda! Tente novamente mais tarde.");
									}
									
									DeactivateLoading();
								}
							});
						}
					}
				}
			</script>
			<script>
				var table;
				var table2;
				var table3;
				
				function get_encomenda(id) {
					ActivateLoading();
					var inst = $('[data-remodal-id=modal-enc]').remodal();
					inst.close();
					
					jQuery.ajax({
						type: "POST",
						url: "funcoes_gerais.php",
						data: { "action" : "get_encomenda_tmp("+id+");"},
						success: function(data) 
						{
							var obj = JSON.parse(data);
							var rown = 0;
							
							$.each(obj, function(index, value) {
								if( rown == 0 ) {
									var input_tmp = JSON.parse( decodeURIComponent(value["input"]) );

									$.each(input_tmp, function(index2, value2) {
										jQuery("#"+index2).val(value2);
										if( index2 == "no" && value2 != "" && parseInt(value2) > 0 ) {
											jQuery("#nome").attr("disabled", "disabled");
											jQuery("#no").attr("disabled", "disabled");
											jQuery("#ncont").attr("disabled", "disabled");
											jQuery("#morada").attr("disabled", "disabled");
											jQuery("#codpost").attr("disabled", "disabled");
											jQuery("#local").attr("disabled", "disabled");
											jQuery("#email").removeAttr("disabled");
											jQuery("#telefone").attr("disabled", "disabled");
										}
									});
									
									var table_tmp = JSON.parse( decodeURIComponent(value["tabela"]) );
									jQuery("#TabBI").html(table_tmp);
									
									var txta_tmp = JSON.parse( decodeURIComponent(value["textarea"]) );
									jQuery("#obs").val(txta_tmp);
									
									var txta_tmp2 = JSON.parse( decodeURIComponent(value["textarea2"]) );
									jQuery("#obsint").val(txta_tmp2);
									
									var sel_tmp = JSON.parse( decodeURIComponent(value["sel"]) );
									$(".tpdesc").val(sel_tmp)
									
									rown = rown + 1;
									
									calcula_totais();
									
									DeactivateLoading();
									bootbox.alert({ 
										message: "Encomenda carregada com sucesso!"
									})
								}
							});
						}
					});
				}
				
				function get_reencomenda(id) {
					ActivateLoading();
					var inst = $('[data-remodal-id=modal-enc]').remodal();
					inst.close();
					
					jQuery.ajax({
						type: "POST",
						url: "funcoes_gerais.php",
						data: { "action" : "get_reencomenda_tmp("+id+");"},
						success: function(data) 
						{
							console.log( obj );
							var obj = JSON.parse(data);
							var rown = 0;
							
							$.each(obj, function(index, value) {
								if( rown == 0 ) {
									var input_tmp = JSON.parse( decodeURIComponent(value["input"]) );

									$.each(input_tmp, function(index2, value2) {
										jQuery("#"+index2).val(value2);
										if( index2 == "no" && value2 != "" && parseInt(value2) > 0 ) {
											jQuery("#nome").attr("disabled", "disabled");
											jQuery("#no").attr("disabled", "disabled");
											jQuery("#ncont").attr("disabled", "disabled");
											jQuery("#morada").attr("disabled", "disabled");
											jQuery("#codpost").attr("disabled", "disabled");
											jQuery("#local").attr("disabled", "disabled");
											jQuery("#email").removeAttr("disabled");
											jQuery("#telefone").attr("disabled", "disabled");
										}
									});
									
									var table_tmp = JSON.parse( decodeURIComponent(value["tabela"]) );
									jQuery("#TabBI").html(table_tmp);
									
									var txta_tmp = JSON.parse( decodeURIComponent(value["textarea"]) );
									jQuery("#obs").val(txta_tmp);
									
									var txta_tmp2 = JSON.parse( decodeURIComponent(value["textarea2"]) );
									jQuery("#obsint").val(txta_tmp2);
									
									var sel_tmp = JSON.parse( decodeURIComponent(value["sel"]) );
									$(".tpdesc").val(sel_tmp)
									
									rown = rown + 1;
									
									calcula_totais();
									
									DeactivateLoading();
									bootbox.alert({ 
										message: "Encomenda carregada com sucesso!"
									})
								}
							});
						}
					});
				}
				
				function recuperar_encomenda() {
					//carrega encomenda gravada
					
					ActivateLoading();
					
					$('#TabEncomendas').DataTable().clear();

					jQuery.ajax({
						type: "POST",
						url: "funcoes_gerais.php",
						data: { "action" : "get_encomendas_gravadas('<?php echo $_SESSION["user"]["id"] ?>');"},
						success: function(data) 
						{
							var obj = JSON.parse(data);
							
							jQuery("#TabEncomendas tbody").empty();

							$.each(obj, function(index, value) {

								var dados = new Array();
								
								
								var data = JSON.parse(decodeURIComponent((value["input"]+'').replace(/\+/g, '%20')));
								
								dados.push(data["nome"]);
								dados.push(value["data"]);
								dados.push('<button type="button" class="btn btn-primary" onclick="get_encomenda(' + value["id"] + '); return false;">ESCOLHER</button>');
								
								table3.row.add(dados).draw();
							});
							
							// table3.columns.adjust().draw();
							DeactivateLoading();
						}
					});
				}
				
				jQuery(document).ready(function() {
					
					jQuery(function() {
						jQuery(document).on('keydown', '.txtboxToFilter', function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||/65|67|86|88/.test(e.keyCode)&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});
					})
					
					table = $('#TabArtigos').DataTable({
						"bPaginate" : false,
						"paging":   false,
						"info":     false,
						"bFilter":     false,
						columnDefs: [ {
							targets: [ 1 ],
							orderData: [ 1, 2 ]
						}],
						"order": [[ 1, "asc" ], [ 2, "asc" ]]
					});
					
					table2 = $('#TabArtigosVelvet').DataTable({
						"bPaginate" : false,
						"paging":   false,
						"info":     false,
						"bFilter":     false,
						"ordering": false
					});
					
					table3 = $('#TabEncomendas').DataTable({
						"bPaginate" : false,
						"paging":   false,
						"info":     false,
						"bFilter":     false,
						"ordering": false
					});
					
					<?php
					if( isset($_GET["r"]) && $_GET["r"]>0 ) {
					?>
						get_reencomenda(<?php echo $_GET["r"]; ?>);
					<?php
					}
					?>
					
					jQuery(".tpdesc").change(function() {
						calcula_totais();
					});
					
				});
				
				$('#filtro_cliente').keyup(function(e){
					if(e.keyCode == 13)
					{
						FiltraClientes();
					}
				});
				
				function InsereArtigosVelvet() {
					$("#InsereArtigosVelvetBut").attr("disabled", "disabled");
					ActivateLoading();
					$('#TabArtigosVelvet > tbody  > tr').each(function() {
						var ref = $(this).children().eq(0).html().toString().trim();
						
						if( ref != '' ) {
							var stamp = $(this).children().eq(9).find("input").attr("tipo").toString().trim();
							var desc = parseFloat($(this).children().eq(3).html().toString().trim());
							var qtd = parseFloat($(this).children().eq(9).find("input").val());
							var row_min = parseFloat($(this).children().eq(4).html().toString().trim());
							var descpack = parseFloat($(this).children().eq(3).html().toString().trim());
							
							var lucrounit = parseFloat($(this).children().eq(7).html().toString().trim());
							var custounit = parseFloat($(this).children().eq(5).html().toString().trim());
							
							var totalPack = CheckTotalQtdPack( stamp );
							var checkMinRef = CheckMinRefPack( stamp );
							
							var pack_obj = $("input[name='packinfo_"+stamp.trim()+"']");
							var pack_min = parseFloat(pack_obj.attr("min"));
							var pack = pack_obj.parent().parent().children().eq(1).find("b").html().trim();
							
							var pack_total = 0;
							
							$('#TabArtigosVelvet tbody tr td [tipo="' + stamp.trim() + '"]').each(function() {
								pack_total += parseFloat($(this).parent().parent().children().eq(4).html().trim());
							});
							
							if( !totalPack || !checkMinRef ) {
								desc = 0;
							}
							
							if( qtd > 0 ) {
								insere_artigo(ref, qtd, desc, pack, pack_min, pack_total, row_min, stamp, descpack, lucrounit, custounit);
							}
							
						}
					});
					
					var inst = $('[data-remodal-id=modal-st-velvet]').remodal();
					inst.close();
					DeactivateLoading();
				}
				
				function InsereArtigos() {
					ActivateLoading();
					
					$('#TabArtigos > tbody  > tr').each(function() {
						var qtd = $(this).children().eq(4).find("input").first().val();
						var ref = $(this).children().eq(0).html();
						
						if( qtd > 0 ) {
							insere_artigo(ref, qtd, 0, '', 0, 0, 0, '', 0, 0, 0)
						}
					});
					
					var inst = $('[data-remodal-id=modal-st]').remodal();
					inst.close();
					DeactivateLoading();
				}
				
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
								
								if( value["tpstamp"].trim() != '' ) {
									jQuery(".tpdesc").val(value["tpstamp"].trim());
								}
								
								jQuery("#nome").attr("disabled", "disabled");
								jQuery("#no").attr("disabled", "disabled");
								jQuery("#ncont").attr("disabled", "disabled");
								jQuery("#morada").attr("disabled", "disabled");
								jQuery("#codpost").attr("disabled", "disabled");
								jQuery("#local").attr("disabled", "disabled");
								jQuery("#email").removeAttr("disabled");
								jQuery("#telefone").attr("disabled", "disabled");
							});

							inst.close();
							DeactivateLoading();
						}
					});
				}
				
				function total_documento() {
					var total = 0;
					jQuery("#TabBI > tbody > tr").each(function() {
						total += parseFloat(jQuery(this).children().eq(5).html());
					});
					
					return total;
				}
				
				function total_desconto() {
					var total = 0;
					jQuery("#TabBI > tbody > tr").each(function() {
						total += parseFloat(jQuery(this).children().eq(5).html()) - parseFloat(jQuery(this).children().eq(7).html());
					});
					return total;
				}
				
				function total_liquido() {
					var total = 0;
					jQuery("#TabBI > tbody > tr").each(function() {
						total += parseFloat(jQuery(this).children().eq(7).html());
					});
					return total;
				}
				
				function total_iva() {
					var total = 0;
					jQuery("#TabBI > tbody > tr").each(function() {
						total += (parseFloat(jQuery(this).children().eq(7).html()) * (1 + ((parseFloat(jQuery(this).children().eq(4).html()))/100))) - parseFloat(jQuery(this).children().eq(7).html());
					});
					return total;
				}
				
				function total_custo() {
					var total = 0;
					jQuery("#TabBI > tbody > tr").each(function() {
						total += parseFloat(jQuery(this).attr("custounit"))*parseFloat(jQuery(this).children().eq(2).find("input").val());
					});
					return total;
				}
				
				function total_lucro() {
					var total = 0;
					jQuery("#TabBI > tbody > tr").each(function() {
						total += parseFloat(jQuery(this).attr("lucrounit"))*parseFloat(jQuery(this).children().eq(2).find("input").val());
					});
					return total;
				}
				
				function calcula_totais() {
					var total = total_documento();
					var totald = total_desconto();
					var totall = total_liquido();
					var totali = total_iva();
					var totalcusto = total_custo();
					var totallucro = total_lucro();
					var rent_per = 0;
					if( totalcusto != 0 )
						rent_per = totallucro/totalcusto*100
					var desconto_fin = parseFloat(jQuery(".tpdesc option:selected").attr("desc"));
					
					jQuery("#rent_total_eur").val("€ " + totallucro.toFixed(2).toString());
					jQuery("#rent_total_per").val(rent_per.toFixed(2).toString() + "%");
					
					jQuery("#totaldoc").val("€ " + total.toFixed(2).toString());
					jQuery("#totaldesc").val("€ " + totald.toFixed(2).toString());
					jQuery("#totalliq").val("€ " + totall.toFixed(2).toString());
					jQuery("#totaliva").val("€ " + totali.toFixed(2).toString());
					jQuery("#descontofinanc").val(desconto_fin.toFixed(2).toString() + "%");
					
					jQuery("#totaldocumento").val("€ " + ((totali + totall) * (1 - desconto_fin/100)).toFixed(2).toString());
				}
				
				function remove_artigo(obj) {
					var pack_stamp = obj.attr("packstamp");
					obj.remove();
					$('#TabBI tbody tr[packstamp="' + pack_stamp + '"]').each(function() {
						calcula_linha($(this).children().eq(2).find("input"), 1);
					});
					calcula_totais();
					return false;
				}
				
				function limpa_filtra_clientes() {
					jQuery("#filtro_cliente").val("");
					jQuery("#TabClientes tbody").empty();
				}
				
				function limpa_filtra_artigos() {
					jQuery("#filtro_artigo").val("");
					jQuery("#TabArtigos tbody").empty();
				}
				
				function calcula_linha(obj, apenaslinha) {
					
					if( obj.val() == '' ) {
						obj.val("1");
					}

					var qtd =  parseFloat(obj.val());
					var epv2 = parseFloat(obj.parent().parent().children().eq(3).html());
					var desc = parseFloat(obj.parent().parent().children().eq(6).html());

					var pack_min = obj.parent().parent().attr("packmin");
					var pack_total = obj.parent().parent().attr("packtotal");
					var pack_stamp = obj.parent().parent().attr("packstamp").trim();
					var descpack = obj.parent().parent().attr("packdesc");

					var pack_min_tmp = 0;
					var pack_total_tmp = 0;
					//verificar se total pack esta a ser cumprido
					//verificar se min linhas pack esta a ser cumprido

					$('#TabBI tbody tr[packstamp="' + pack_stamp + '"]').each(function() {
						pack_total_tmp += parseFloat( $(this).attr("rowmin") );
						pack_min_tmp += parseFloat( $(this).children().eq(2).find("input").val() );
					});

					if( pack_total_tmp == pack_total && pack_min_tmp >= pack_min ) {
						desc = parseFloat( descpack );
					}
					else {
						desc = 0;
					}

					var total_antes_desc = (qtd*epv2).toFixed(2);
					
					obj.parent().parent().children().eq(5).html(total_antes_desc);
					obj.parent().parent().children().eq(6).html(desc.toFixed(2)+"%");
					obj.parent().parent().children().eq(7).html((total_antes_desc*(1-(desc/100))).toFixed(2));
					
					if( !apenaslinha ) {
						$('#TabBI tbody tr[packstamp="' + pack_stamp + '"]').each(function() {
							calcula_linha($(this).children().eq(2).find("input"), 1);
						});
					}
				}
				
				function mudapreco(obj) {
					calcula_linha(obj, 0);
					calcula_totais();
				}
				
				function insere_artigo(ref, qtd, desc, pack, packmin, packtotal, rowmin, packstamp, descpack, lucrounit, custounit) {
					
					if( isNaN(parseFloat(qtd)) || isNaN(qtd) ) {
						qtd = 0;
					}
					
					jQuery.ajax({
						type: "POST",
						url: "funcoes_gerais.php",
						data: { "action" : "get_artigo('"+ref+"');"},
						async: false,
						success: function(data) 
						{
							var obj = JSON.parse(data);
							
							$.each(obj, function(index, value) {
								var total_antes_desc = (qtd*parseFloat(Math.round(value["epv2"] * 100) / 100)).toFixed(2);
								
								//verificar se ja existe este artigo com este pack na lista
								var art_existe = 0;
								$('#TabBI tbody tr[packstamp="' + packstamp + '"]').each(function() {
									procura_ref = $(this).children().eq(0).html().trim();
									procura_qtt = parseFloat( $(this).children().eq(2).find("input").val() );
									
									if( value["ref"].trim() == procura_ref.trim() ) {
										art_existe = 1;
										$(this).children().eq(2).find("input").val( (procura_qtt + parseFloat(qtd)).toFixed(2) );
									}
								});
								
								if( !art_existe ) {
									var st_str = "<tr lucrounit='" + lucrounit + "' custounit='" + custounit + "' packdesc='" + descpack + "' packstamp='" + packstamp + "' pack='" + pack + "' packtotal='" + packtotal + "' packmin='" + packmin + "' rowmin='" + rowmin + "'>" +
									"<td>"+value["ref"]+"</td>" +
									"<td>"+value["design"]+"</td>" +
									"<td><input type='text' class='txtboxToFilter' onkeyup='mudapreco(jQuery(this));' value='"+parseFloat(qtd).toFixed(2)+"' /></td>" +
									"<td>"+parseFloat(Math.round(value["epv2"] * 100) / 100).toFixed(2)+"</td>" +
									"<td>"+parseFloat(value["taxa"]).toFixed(2)+"</td>" +
									"<td>"+total_antes_desc+"</td>" +
									"<td>"+desc.toFixed(2)+"%</td>" +
									"<td>"+(total_antes_desc*(1-(desc/100))).toFixed(2)+"</td>" +
									"<td>"+pack+"</td>" +
									"<td><button onclick='remove_artigo(jQuery(this).parent().parent())' type='button' class='btn btn-primary'><i class='white halflings-icon minus-sign'></i></button></td>" +
									"</tr>";
									
									jQuery("#TabBI tbody").append(st_str);
								}
							});
							
							$('#TabBI tbody tr[packstamp="' + packstamp + '"]').each(function() {
								calcula_linha($(this).children().eq(2).find("input"), 1);
							});
							calcula_totais();
						}
					});
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
								jQuery("#TabClientes tbody").append("<tr><td>"+value["no"]+"</td><td>"+value["nome"]+"</td><td>"+value["ncont"]+"</td><td>"+value["codpost"]+"</td><td>"+value["local"]+"</td><td><button onclick='insere_cliente("+value["no"]+")' type='button' class='btn btn-primary'><i class='white halflings-icon plus-sign'></i></button></td></tr>");
							});

							DeactivateLoading();
						}
					});
				}
				
				function CheckTotalQtdPack(stamp) {
					var total = 0;
					
					$( "input[tipo='" + stamp + "']" ).each(function( i ) {
						total += parseFloat($(this).val());
					});
					
					var obj = $("input[name='packinfo_"+stamp.trim()+"']");
					var min_un = parseFloat(obj.attr("min"));
					var confere = true;
					
					if( total < min_un ) {
						confere = false;
					}

					return confere;
				}
				
				function CheckMinRefPack(stamp) {
					var confere = true;
					
					$( "input[tipo='" + stamp + "']" ).each(function( i ) {
						var qtd = parseFloat($(this).val());
						var minUn = parseFloat($(this).parent().parent().children().eq(4).html());
						
						if( qtd < minUn ) {
							confere = false;
						}
					});
					
					return confere;
				}
				
				function updateTableRow(obj, stamp) {
					var total = 0;
					var custo_total = 0;
					var lucro_total = 0;
					var custoUnit = parseFloat(obj.parent().parent().children().eq(5).html());
					var rentUnit = parseFloat(obj.parent().parent().children().eq(7).html());
					var qtt = parseFloat(obj.val());
					
					obj.parent().parent().children().eq(10).html( (custoUnit*qtt).toFixed(2) );
					obj.parent().parent().children().eq(11).html( (rentUnit*qtt).toFixed(2) );
					
					$( "input[tipo='" + stamp + "']" ).each(function( i ) {
						total += parseFloat($(this).val());
						
						var custo = parseFloat($(this).parent().parent().children().eq(10).html());
						if( isNaN(custo) )
							custo = 0;
						var lucro = parseFloat($(this).parent().parent().children().eq(11).html());
						if( isNaN(lucro) )
							lucro = 0;
						
						custo_total += custo;
						lucro_total += lucro;
					});
					
					$( "input[custo_stamp='" + stamp + "']" ).val(custo_total.toFixed(2));
					$( "input[lucro_stamp='" + stamp + "']" ).val(lucro_total.toFixed(2));
					$( "input[stamp='" + stamp + "']" ).val(total);
					
					var custo_total = 0;
					var lucro_total = 0;
					$( "[calc='1']" ).each(function( i ) {
						var custo = parseFloat($(this).parent().parent().children().eq(10).html());
						if( isNaN(custo) )
							custo = 0;
						var lucro = parseFloat($(this).parent().parent().children().eq(11).html());
						if( isNaN(lucro) )
							lucro = 0;
						
						custo_total += custo;
						lucro_total += lucro;
					});
					
					$( "#enc_total" ).val(custo_total.toFixed(2));
					$( "#luc_total" ).val(lucro_total.toFixed(2));
					$( "#rent_total" ).val((lucro_total/custo_total*100).toFixed(2) + '%');
					
				}
				
				function FiltraArtigosVelvet() {
					$("#InsereArtigosVelvetBut").removeAttr("disabled");
					ActivateLoading();
					
					$('#TabArtigosVelvet').DataTable().clear();
					$( "#enc_total" ).val(0);
					$( "#rent_total" ).val("0%");
					$( "#luc_total" ).val(0);
					jQuery.ajax({
						type: "POST",
						url: "funcoes_gerais.php",
						data: { "action" : "tabela_artigos_velvet();"},
						success: function(data) 
						{
							var obj = JSON.parse(data);
							
							jQuery("#TabArtigosVelvet tbody").empty();
							
							$.each(obj["pack"], function(index, value) {
								var dados = new Array();
								dados.push("");
								dados.push("<b class='ColorRow'>PACK "+value["pack"]+"</b>");
								dados.push("<input name='packinfo_"+value["u_packstamp"].trim()+"' type='hidden' min='"+value["minun"]+"' />");
								dados.push("");
								dados.push("");
								dados.push("");
								dados.push("");
								dados.push("");
								dados.push("");
								dados.push("");
								dados.push("");
								dados.push("");
								dados.push("");
								table2.row.add(dados).draw();
								
								$.each(obj["artigos"], function(index2, value2) {
									
									if( value2["u_packstamp"] == value["u_packstamp"] ) {
										var dados = new Array();
										var stock_atual = "";
								
										if ( parseFloat(value2["stock"]) <= 0 ) {
											stock_atual = "stock_red";
											stock_atual_n = "<a style='color:red'>0</a>";
										}
										else if( parseFloat(value2["stock"]) < 50 ) {
											stock_atual = "stock_orange";
											stock_atual_n = "<a style='color:orange'>1</a>";
										}
										else {
											stock_atual = "stock_green";
											stock_atual_n = "<a style='color:green'>2</a>";
										}
										
										dados.push(value2["ref"]);
										dados.push(value2["design"]);
										dados.push(parseFloat(Math.round(value2["pvf"] * 100) / 100).toFixed(2));
										dados.push(parseFloat(Math.round(value2["desconto"] * 100) / 100).toFixed(2));
										dados.push(parseFloat(Math.round(value2["minun"] * 100) / 100).toFixed(2));
										dados.push(parseFloat(Math.round(value2["custoun"] * 100) / 100).toFixed(2));
										dados.push(parseFloat(Math.round(value2["pvprec"] * 100) / 100).toFixed(2));
										dados.push(parseFloat(Math.round(value2["rentunit"] * 100) / 100).toFixed(2));
										dados.push(parseFloat(Math.round(value2["rentunit_percent"] * 100) / 100).toFixed(2));

										var stamp = '"' + value["u_packstamp"].toString().trim() + '"';
										
										dados.push("<input calc='1' tipo='" + value["u_packstamp"].toString().trim() + "' class='txtboxToFilter' onkeyup='updateTableRow($(this), "+stamp+")' style='width:100px; text-align:center;' type='text' value='0' />");
										dados.push("0");
										dados.push("0");
										dados.push("<span class='"+stock_atual+"'>" + stock_atual_n + "</span>");
										
										table2.row.add(dados).draw();
										table2.columns.adjust().draw();
									}
								});
								
								var dados = new Array();
								dados.push("");
								dados.push("");
								dados.push("");
								dados.push("");
								dados.push("");
								dados.push("");
								dados.push("");
								dados.push("");
								dados.push("");
								dados.push("<input class='txtboxToFilter' stamp='"+value["u_packstamp"].toString().trim()+"' style='width:100px; background:yellow; text-align:center; font-weight:bold;' disabled style='text-align:center;' type='text' value='0' />");
								dados.push("<input class='txtboxToFilter' custo_stamp='"+value["u_packstamp"].toString().trim()+"' style='width:100px; background:yellow; text-align:center; font-weight:bold;' disabled style='text-align:center;' type='text' value='0' />");
								dados.push("<input class='txtboxToFilter' lucro_stamp='"+value["u_packstamp"].toString().trim()+"' style='width:100px; background:yellow; text-align:center; font-weight:bold;' disabled style='text-align:center;' type='text' value='0' />");
								dados.push("");
								table2.row.add(dados).draw();
								
								table2.columns.adjust().draw();
							});
							
							table2.columns.adjust().draw();
							// $('.sticky').stickMe(function(){
								// topOffset: 300
							// });
							DeactivateLoading();
						}
					});
				}
				
				//setup before functions
				// var typingTimer;
				// var doneTypingInterval = 500;
				// var $input = $('#filtro_st_repres');

				//on keyup, start the countdown
				// $input.on('keyup', function () {
				  // clearTimeout(typingTimer);
				  // typingTimer = setTimeout(FiltraArtigosRepresentado, doneTypingInterval);
				// });

				//on keydown, clear the countdown 
				// $input.on('keydown', function () {
				  // clearTimeout(typingTimer);
				// });
				
				function FiltraArtigosRepresentado() {
					ActivateLoading();
					
					$('#TabArtigos').DataTable().clear();
					
					jQuery.ajax({
						type: "POST",
						url: "funcoes_gerais.php",
						data: { "action" : "tabela_artigos_2('" + jQuery("#filtro_st_repres").val() + "', 'u_famsite');"},
						success: function(data) 
						{
							var obj = JSON.parse(data);
							
							jQuery("#TabArtigos tbody").empty();

							$.each(obj, function(index, value) {
								var stock_atual = "";
								
								if ( parseFloat(value["stock"]) <= 0 ) {
									stock_atual = "stock_red";
									stock_atual_n = "<a style='color:red'>0</a>";
								}
								else if( parseFloat(value["stock"]) < 50 ) {
									stock_atual = "stock_orange";
									stock_atual_n = "<a style='color:orange'>1</a>";
								}
								else {
									stock_atual = "stock_green";
									stock_atual_n = "<a style='color:green'>2</a>";
								}

								var dados = new Array();
								dados.push(value["ref"]);
								dados.push(value["u_famsite"]);
								dados.push(value["design"]);
								
								dados.push(parseFloat(Math.round(value["epv2"] * 100) / 100).toFixed(2));
								dados.push("<input class='txtboxToFilter' style='text-align:center;' type='text' value='0' />");
								
								dados.push("<span class='"+stock_atual+"'>" + stock_atual_n + "</span>");
								
								table.row.add(dados).draw();
							});
							
							table.columns.adjust().draw();
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
