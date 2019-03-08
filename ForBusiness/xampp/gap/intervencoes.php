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
					$current_page = "Intervenções";
					include("breadcrumbs.php"); 
					$tecnicos = get_tecnicos();	
					$clientes = get_clientes();	
				?>
				<div class="row-fluid">
					<div class="span6">
						<form class="form-horizontal">
							<div class="control-group">
								<label class="control-label" for="dt_ini">Data Inicial</label>
								<div class="controls">
									<input type="date" id="dt_ini" value="<?php echo date("Y-m-d"); ?>">
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="dt_fim">Data Final</label>
								<div class="controls">
									<input type="date" id="dt_fim" value="<?php echo date("Y-m-d"); ?>">
								</div>
							</div>
						</form>
					</div>
					<div class="span6">
						<form class="form-horizontal">
							<div class="control-group">
								<label class="control-label" for="tp_sums">Tempo Total (seg)</label>
								<div class="controls">
									<input type="text" id="tp_sums" value="0">
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="tp_sumd">Tempo Total (dec)</label>
								<div class="controls">
									<input type="text" id="tp_sumd" value="0">
								</div>
							</div>
						</form>
					</div>
				</div>
				<div class="row-fluid">
					<form class="form-horizontal">
						<div class="control-group">
							<label class="control-label">Filtros</label>
							<div class="controls">
								<label class="checkbox inline">
									<div class="checker" id="uniform-inlineCheckbox1"><span class=""><input type="checkbox" id="cb_facturar" value="option1"></span></div> Faturar
								</label>
								<label class="checkbox inline">
									<div class="checker" id="uniform-inlineCheckbox2"><span><input type="checkbox" id="cb_okft" value="option2"></span></div> Faturado
								</label>
								<label class="checkbox inline">
									<div class="checker" id="uniform-inlineCheckbox3"><span><input type="checkbox" id="cb_u_cat" value="option3"></span></div> Contrato
								</label>
								<label class="checkbox inline">
									<div class="checker" id="uniform-inlineCheckbox3"><span><input type="checkbox" id="cb_fref" value="option3"></span></div> Projeto
								</label>
							</div>
						</div>
					</form>
				</div>
				<div class="row-fluid">
					<div class="form-horizontal">
						<div class="control-group">
							<label class="control-label">Técnico</label>
							<div class="controls">
								<select id="tecnico" class="span4 form-control">
									<option></option>
									<?php
										foreach($tecnicos as $tecnico) {
											$selected = '';
											echo "<option value='" . $tecnico["cm"] . "'>" . $tecnico["cmdesc"] . "</option>";
										}
									?>
								</select>
							</div>
						</div>
						<div class="control-group">
							<div class="controls">
								<input type="text" class="form-control span4" placeholder="Filtro Cliente" id="filt_cl">
								<button class="btn" type="button" onclick="filtra_cl()"><i class="halflings-icon white zoom-in"></i></button>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">Cliente</label>
							<div class="controls">
								<select id="cliente" class="span4 form-control">
									<option></option>
									<?php
										foreach($clientes as $cliente) {
											echo "<option value='" . $cliente["no"] . "'>" . $cliente["nome"] . "</option>";
										}
									?>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="row-fluid">
					<form class="form-horizontal">
						<div class="control-group">
							<button class="btn btn-large btn-primary span12" onclick="atualizaTabela(); return false;"><i class="white halflings-icon search"></i> Mostrar</button>
						</div>
					</form>
				</div>
				<div class="row-fluid">
					<div class="row-fluid">
						<table id="TabIntervencoes" class="table table-striped bootstrap-datatable">
							<thead>
								<tr>
									<th>id</th>
									<th>Técnico</th>
									<th>Cliente</th>
									<th>Tarefa</th>
									<th>Data Inicial</th>
									<th>Data Final</th>
									<th>Tempo</th>
									<th>Faturar</th>
									<th>Faturado</th>
									<th>Contrato</th>
									<th>Projeto</th>
									<th>Relatorio</th>
									<th></th>
								</tr>
							</thead>   
							<tbody>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div><!--/.fluid-container-->
			<!-- end: Content -->
	</div><!--/#content.span10-->	
	<div class="clearfix"></div>
	<?php include("footer.php"); ?>
	<!-- start: JavaScript-->
	<script>

		$(document).ready(function () {
			atualizaTabela();
		});
		
		function filtra_cl() {
			ActivateLoading();
			jQuery.ajax({
				type: "POST",
				url: "funcoes_gerais.php",
				data: { "action" : "tabela_clientes('', '" + jQuery("#filt_cl").val() + "');"},
				success: function(data) 
				{
					var obj = JSON.parse(data);

					$('#cliente')
						.find('option')
						.remove()
						.end()
						.append('<option value=""></option>')
					;
					
					$.each(obj, function(index, value) {
						$('#cliente')
							.find('option')
							.end()
							.append('<option value="' + value["no"] + '">' + value["nome"] + '</option>')
						;
					});

					DeactivateLoading();
				}
			});
		}
		
		$('#filt_cl').keyup(function(e){
			if(e.keyCode == 13)
			{
				filtra_cl();
			}
		});
		
		function atualizaTabela() {
			ActivateLoading();
			
			var table = $('#TabIntervencoes').DataTable({
				dom: 'lBfrtip',
				buttons: [
					{
						extend:    'copy',
						text:      '<i class="fa fa-copy"></i> Copiar',
						titleAttr: 'Copiar'
					},
					{
						extend:    'csv',
						text:      '<i class="fa fa-file-text-o"></i> CSV',
						titleAttr: 'CSV'
					},
					{
						extend:    'excel',
						text:      '<i class="fa fa-file-excel-o"></i> Excel',
						titleAttr: 'Excel'
					},
					{
						extend:    'pdf',
						text:      '<i class="fa fa-file-pdf-o"></i> PDF',
						titleAttr: 'PDF'
					},
					{
						extend:    'print',
						text: '<i class="fa fa-print"></i> Imprimir',
						titleAttr: 'Imprimir'
					}
				],
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
				"iDisplayLength": 100,
				sPaginationType : "full_numbers",
				aoColumnDefs : [{ "bVisible": false, "aTargets": [0] }],
				"bDestroy": true
			});
			$('#TabIntervencoes').DataTable().clear();
			
			$('#TabIntervencoes').on( 'draw.dt', function () {
				var mohSum = 0;
				if(table.$('tr', { "filter": "applied" }).length) {
					var sData = table.$('tr', { "filter": "applied" });

					for (var i = 0; i < sData.length; i++) {
						var res = sData[i].childNodes[5].innerHTML.split(" / ");
						mohSum = mohSum + parseFloat(res[1]);
					}
				}
				
				var tempo = secondsToTime(parseFloat(mohSum).toFixed(2));
				jQuery("#tp_sums").val(leftPad(tempo.h,2)+":"+leftPad(tempo.m,2)+":"+leftPad(tempo.s,2));
				jQuery("#tp_sumd").val(parseFloat(mohSum).toFixed(2));
			});
			
			var dtini = replaceAll(jQuery("#dt_ini").val(), '-','');
			var dtfim = replaceAll(jQuery("#dt_fim").val(), '-','');
			
			var tec = isNull(jQuery("#tecnico").val());
			var cl = isNull(jQuery("#cliente").val());
			
			var params = '"isnull((select top 1 nmfref from fref where fref = mh.fref),\'\') nmfref", "'+dtini+'","'+dtfim+'",';
			params += '"'+boolToInt(jQuery("#cb_facturar").is(":checked"))+'", "'+boolToInt(jQuery("#cb_okft").is(":checked"))+'", "'+boolToInt(jQuery("#cb_u_cat").is(":checked"))+'", "'+boolToInt(jQuery("#cb_fref").is(":checked"))+'", "'+tec+'", "'+cl+'"';							
			
			jQuery.ajax({
				type: "POST",
				url: "funcoes_gerais.php",
				data: { "action" : 'tabela_intervencoes('+params+');'},
				success: function(data) 
				{
					var obj = JSON.parse(data);

					$.each(obj, function(index, value) {
						var dados = new Array();
						dados.push(value["u_movid"]);
						
						var str = value["tecnnm"];
						var tecIn = str.replace(/[a-z\s]/g, '');
						dados.push(tecIn);
						
						dados.push(value["nome"]);
						dados.push(value["mhtipo"]);
						
						dados.push(value["data"].substr(0, 10)+" "+value["hora"]);
						dados.push(value["data"].substr(0, 10)+" "+value["horaf"]);
						
						var tempo = secondsToTime(parseFloat(value["moh"]).toFixed(2));
						dados.push(leftPad(tempo.h,2)+":"+leftPad(tempo.m,2)+":"+leftPad(tempo.s,2) + " / " +parseFloat(value["moh"]).toFixed(2));
						
						dados.push(value["facturar"]);
						dados.push(value["okft"]);
						dados.push(value["u_cat"]);
						dados.push(value["nmfref"]);
						
						dados.push('<a class="btn btn-success" onclick="ShowRel(\''+value["mhstamp"]+'\')" ><i class="halflings-icon white envelope"></i></a>');
						
						dados.push("<a class='btn btn-success' href='intervencao.php?mhstamp=" + value["mhstamp"] + "'><i class='halflings-icon white zoom-in'></i></a>");
						
						table.row.add(dados).draw();
					});

					jQuery("#TabIntervencoes thead tr th").css( "width", "auto");
					
					var mohSum = 0;
					if(table.data().length) {
						var sData = table.data();
						for (var i = 0; i < sData.length; i++) {
							var res = sData[i][6].split(" / ");
							mohSum = mohSum + parseFloat(res[1]);
						}
					}
					var tempo = secondsToTime(parseFloat(mohSum).toFixed(2));
					jQuery("#tp_sums").val(leftPad(tempo.h,2)+":"+leftPad(tempo.m,2)+":"+leftPad(tempo.s,2));
					jQuery("#tp_sumd").val(parseFloat(mohSum).toFixed(2));

					DeactivateLoading();
				}
			});
		}
		
		function ShowRel(mhstamp) {
			jQuery.ajax({
				type: "POST",
				url: "funcoes_gerais.php",
				data: { "action" : 'get_relatorio_inter("'+mhstamp+'");'},
				success: function(data) 
				{
					var obj = JSON.parse(data);
					$.each(obj, function(index, value) {
						bootbox.dialog({
							message: replaceAll(value["relatorio"], '\n', '<br>'),
							title: "Relatório"
						});
					});
				}
			});
		}
	</script>
	<?php include("footer_code.php"); ?>
	<!-- end: JavaScript-->
</body>
</html>
