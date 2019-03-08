<!DOCTYPE html>
<html lang="en">
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
						$current_page = "Agenda";
						include("breadcrumbs.php"); 
						
						
					?>
					
					<div class="row-fluid">
						<form class="form-horizontal">
							<button type="submit" class="btn btn-primary" onclick="window.history.go(-1); return false;" ><i class="white halflings-icon circle-arrow-left"></i> Voltar</button>
							<br><br>
							<h1>Agenda</h1>
						</form>
						<div id="calendar_div">
						</div>
						<div class="remodal" data-remodal-id="modal">
							<div class="container-fluid-full">
								<button data-remodal-action="close" class="remodal-close"></button>
								<h1>Visita</h1>
									<div class="span6">
										<form class="form-horizontal">
											<label for="nome_cliente" class="control-label">Nome</label>
											<div class="controls">
												<input disabled type="text" id="nome_cliente" class="span6" value=''>
											</div><br>
											<label for="num_cliente" class="control-label">Nº Cliente</label>
											<div class="controls">
												<input disabled type="text" id="num_cliente" class="span6" value=''>
											</div><br>
											<label class="control-label">Estabelecimento</label>
											<div class="controls">
												<input disabled type="text" id="estab" class="span6" value=''>
											</div><br>
											<label class="control-label">Data Visita</label>
											<div class="controls">
												<input type="date" id="data" class="span6" value=''>
											</div><br>
											<label class="control-label" for="Hora">Hora</label>
											<div class="controls">
												<input type="text" id="hora1" class="span1" value="" >
												<input type="text" id="hora2" class="span1" value="" >
											</div>
											<br>
											<label class="control-label" for="Hora">Hora Real</label>
											<div class="controls">
												<input disabled type="text" id="hora11" class="span1" value="<?php echo date('H'); ?>" >
												<input disabled type="text" id="hora22" class="span1" value="<?php echo date('i'); ?>" >
											</div>
										</form>
									</div>
									<div class="span6" >
										<form class="form-horizontal">
											<label for="" class="control-label">Nº Cont.</label>
											<div class="controls">
												<input disabled type="text" id="ncont" class="span6" value=''>
											</div><br>
											<label for="" class="control-label">Morada</label>
											<div class="controls">
												<input disabled type="text" id="morada" class="span6" value=''>
											</div><br>
											<label for="" class="control-label">Cód. Postal</label>
											<div class="controls">
												<input disabled type="text" id="codpostal" class="span6" value=''>
											</div><br>
											<label class="control-label">Localidade</label>
											<div class="controls">
												<input disabled type="text" id="local" class="span6" value=''>
												<input  style="display:none;" type="text" id="mxstamp" class="span6" value=''>
											</div>
										</form>
									</div>
									<div class="span6">
										<form class="form-horizontal">
											<label for="" class="control-label">Email</label>
											<div class="controls">
												<input disabled type="text" id="email" class="span6" value=''>
											</div><br>
											<label for="" class="control-label">Telefone</label>
											<div class="controls">
												<input disabled type="text" id="telefone" class="span6" value=''>
											</div><br>
											<label for="" class="control-label">Email 2</label>
											<div class="controls">
												<input disabled type="text" id="email2" class="span6" value=''>
											</div><br>
											<label class="control-label">Telefone2</label>
											<div class="controls">
												<input disabled type="text" id="telefone2" class="span6" value=''>
											</div>
										</form>
									</div>
									<div class="span12">
										<form class="form-horizontal">
											<label class="control-label">Objetivos</label>
											<div class="controls">
												<textarea id="objetivos" class="span10" style="height:100px; background:white;"></textarea>								
											</div>
										</form>
									</div>
									<div class="span12">
										<form class="form-horizontal">
											<label class="control-label">Relatório</label>
											<div class="controls">
												<textarea id="relatorio" class="span10" style="height:100px; background:white;"></textarea>								
											</div>
										</form>
									</div>
								</div>
								<div class="span12">
									<button type="button" onclick='apagaVisita()' class="btn btn-secondary" >Apagar</button>
									<button type="button" class="btn btn-secondary" data-remodal-action="cancel">Cancelar</button>
									<button type="button" id="btnguardar" class="btn btn-success" style="display:none;" data-remodal-action="cancel">GUARDAR</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div><!--/.fluid-container-->
		</div><!--/#content.span10-->
	
	<div class="clearfix"></div>
	
	<script type="text/javascript">
	
		var saveButton = document.getElementById('btnguardar');
		saveButton.addEventListener('click', function (event) {
			bootbox.confirm({
				title: "Gravação de Visita?",
				message: "Tem a certeza que deseja alterar a visita?",
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
						alteravisita();
					}
				}
			});
		});
		
		function apagaVisita(){
			var stamp = escape(jQuery("#mxstamp").val().trim());
			var encodedString = encodeURIComponent( stamp );
			
			jQuery.ajax({
				type: "POST",
				url: "funcoes_gerais.php",
				data: { "action" : "apaga_visita('"+encodedString+"');"},
				success: function(data) 
				{
					var inst = $('[data-remodal-id=modal]').remodal();
					inst.close();
					var obj = JSON.parse(data);
					var successed_order = 0;
					
					if( obj["success"] == 1 ) {
						successed_order = 1;
					}
					
					if( successed_order ) {
						bootbox.alert({ 
							message: "Visita apagada com sucesso!", 
							callback: function(){
								var currentTime = new Date();
								getCalendar("calendar_div",currentTime.getFullYear(),currentTime.getMonth() + 1);
							}
						})
					}
					else {
						bootbox.alert("Não foi possivel apagar a visita! Tente novamente mais tarde.");
					}		
				}
			});
		}
		
		function alteravisita(){
			var data_visita = {}; 
				
			data_visita.relatorio = escape(jQuery("#relatorio").val().trim());
			data_visita.objetivos = escape(jQuery("#objetivos").val().trim());
			data_visita.stamp = escape(jQuery("#mxstamp").val().trim());
			data_visita.data = escape(jQuery("#data").val().trim());
			data_visita.hora1 = escape(jQuery("#hora1").val().trim());
			data_visita.hora2 = escape(jQuery("#hora2").val().trim());

			var encodedString = encodeURIComponent( JSON.stringify(data_visita) );
			
			jQuery.ajax({
				type: "POST",
				url: "funcoes_gerais.php",
				data: { "action" : "altera_visita('"+encodedString+"');"},
				success: function(data) 
				{
					var obj = JSON.parse(data);
					var successed_order = 0;
					
					if( obj["success"] == 1 ) {
						successed_order = 1;
					}
					
					if( successed_order ) {
						bootbox.alert({ 
							message: "Visita alterada com sucesso!", 
							callback: function(){
								var currentTime = new Date();
								getCalendar("calendar_div",currentTime.getFullYear(),currentTime.getMonth() + 1);
							}
						})
					}
					else {
						bootbox.alert("Não foi possivel fechar a visita! Tente novamente mais tarde.");
					}		
				}
			});
		}
		
		function modal(stamp,estado){	
		
			jQuery.ajax({
				type: "POST",
				url: "funcoes_gerais.php",
				data: { "action" : "get_visita(' " + stamp + "');"},
				success: function(data) 
				{
									
					var obj = JSON.parse(data);
					
					$.each(obj, function(index, value) {
						jQuery("#nome_cliente").val(value["clnome"]);
						jQuery("#num_cliente").val(value["clno"]);
						jQuery("#estab").val(value["clestab"]);
						jQuery("#data").val(value["data"].substr(0, 10));
						jQuery("#hora1").val(value["hinicio"].substr(0, 2));
						jQuery("#hora2").val(value["hinicio"].substr(3, 5));
						jQuery("#ncont").val(value["ncont"]);
						jQuery("#morada").val(value["morada"]);
						jQuery("#codpostal").val(value["codpost"]);
						jQuery("#local").val(value["local"]);
						jQuery("#relatorio").val(value["texto"]);
						jQuery("#objetivos").val(value["u_objet"]);
						jQuery("#mxstamp").val(value["mxstamp"]);
						
						jQuery("#email").val(value["u_email"]);
						jQuery("#email2").val(value["u_email2"]);
						jQuery("#telefone").val(value["u_tel"]);
						jQuery("#telefone2").val(value["u_tel2"]);
						
						// if(estado == '0'){
						// jQuery("#relatorio").removeAttr("disabled");
						// jQuery("#objetivos").removeAttr("disabled");
						// jQuery("#hora11").removeAttr("disabled");
						// jQuery("#hora22").removeAttr("disabled");
						jQuery("#btnguardar").css("display","initial");
						
						// }
					});
					
					
					var inst = $('[data-remodal-id=modal]').remodal();
					inst.open();
				}
			});
			
		}
		var currentTime = new Date();
		getCalendar("calendar_div",currentTime.getFullYear(),currentTime.getMonth() + 1);
		function getCalendar(target_div,year,month){
			$.ajax({
				type:'POST',
				url:'funcoes_gerais.php',
				data:'func=getCalender&year='+year+'&month='+month,
				success:function(html){
					$('#'+target_div).html(html);
				}
			});
		}
		
		function getEvents(date){
			$.ajax({
				type:'POST',
				url:'funcoes_gerais.php',
				data:'func=getEvents&date='+date,
				success:function(html){
					$('#event_list').html(html);
					$('#event_list').slideDown('slow');
				}
			});
		}
		
		function addEvent(date){
			$.ajax({
				type:'POST',
				url:'funcoes_gerais.php',
				data:'func=addEvent&date='+date,
				success:function(html){
					$('#event_list').html(html);
					$('#event_list').slideDown('slow');
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
